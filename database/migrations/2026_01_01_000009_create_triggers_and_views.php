<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Create View: vw_informasi_penggunaan
        DB::statement("
            CREATE OR REPLACE VIEW vw_informasi_penggunaan AS
            SELECT 
                p.id_pelanggan,
                p.nama_pelanggan,
                p.alamat,
                p.no_telepon,
                dl.daya_watt,
                t.nama_tarif,
                t.tarif_per_kwh,
                pg.bulan,
                pg.tahun,
                DATE_FORMAT(CONCAT(pg.tahun, '-', LPAD(pg.bulan, 2, '0'), '-01'), '%M %Y') AS periode,
                pg.meter_awal,
                pg.meter_akhir,
                pg.total_kwh,
                (pg.total_kwh * t.tarif_per_kwh) AS estimasi_biaya,
                pg.tanggal_catat,
                CASE 
                    WHEN tag.status_bayar IS NULL THEN 'Belum Ada Tagihan'
                    ELSE tag.status_bayar 
                END AS status_pembayaran
            FROM 
                penggunaan pg
                INNER JOIN pelanggan p ON pg.id_pelanggan = p.id_pelanggan
                INNER JOIN daya_listrik dl ON p.id_daya_listrik = dl.id_daya_listrik
                INNER JOIN tarif t ON dl.id_tarif = t.id_tarif
                LEFT JOIN tagihan tag ON pg.id_penggunaan = tag.id_penggunaan
            ORDER BY 
                pg.tahun DESC, 
                pg.bulan DESC, 
                p.nama_pelanggan
        ");

        // Create Stored Procedure: sp_pelanggan_900watt
        DB::unprepared("
            DROP PROCEDURE IF EXISTS sp_pelanggan_900watt;
            CREATE PROCEDURE sp_pelanggan_900watt()
            BEGIN
                SELECT 
                    p.id_pelanggan AS 'ID Pelanggan',
                    p.nama_pelanggan AS 'Nama Pelanggan',
                    p.alamat AS 'Alamat',
                    p.no_telepon AS 'No. Telepon',
                    dl.daya_watt AS 'Daya (Watt)',
                    t.nama_tarif AS 'Tarif',
                    t.tarif_per_kwh AS 'Tarif/kWh (Rp)',
                    p.status AS 'Status',
                    p.tanggal_registrasi AS 'Tanggal Registrasi'
                FROM 
                    pelanggan p
                    INNER JOIN daya_listrik dl ON p.id_daya_listrik = dl.id_daya_listrik
                    INNER JOIN tarif t ON dl.id_tarif = t.id_tarif
                WHERE 
                    dl.daya_watt = 900
                    AND p.status = 'Aktif'
                ORDER BY 
                    p.nama_pelanggan;
            END
        ");

        // Create Function: fn_total_penggunaan_bulan
        DB::unprepared("
            DROP FUNCTION IF EXISTS fn_total_penggunaan_bulan;
            CREATE FUNCTION fn_total_penggunaan_bulan(
                p_id_pelanggan VARCHAR(20),
                p_bulan TINYINT,
                p_tahun YEAR
            )
            RETURNS INT
            DETERMINISTIC
            READS SQL DATA
            BEGIN
                DECLARE v_total_kwh INT DEFAULT 0;
                
                SELECT IFNULL(total_kwh, 0) INTO v_total_kwh
                FROM penggunaan
                WHERE 
                    id_pelanggan = p_id_pelanggan
                    AND bulan = p_bulan
                    AND tahun = p_tahun;
                
                RETURN v_total_kwh;
            END
        ");

        // Create Trigger: trg_after_insert_penggunaan
        DB::unprepared("
            DROP TRIGGER IF EXISTS trg_after_insert_penggunaan;
            CREATE TRIGGER trg_after_insert_penggunaan
            AFTER INSERT ON penggunaan
            FOR EACH ROW
            BEGIN
                DECLARE v_tarif_kwh DECIMAL(10,2);
                DECLARE v_biaya_beban DECIMAL(10,2);
                DECLARE v_total_tagihan DECIMAL(12,2);
                DECLARE v_jatuh_tempo DATE;
                
                -- Ambil tarif dari pelanggan
                SELECT 
                    t.tarif_per_kwh, 
                    t.biaya_beban
                INTO 
                    v_tarif_kwh, 
                    v_biaya_beban
                FROM 
                    pelanggan p
                    INNER JOIN daya_listrik dl ON p.id_daya_listrik = dl.id_daya_listrik
                    INNER JOIN tarif t ON dl.id_tarif = t.id_tarif
                WHERE 
                    p.id_pelanggan = NEW.id_pelanggan;
                
                -- Hitung total tagihan
                SET v_total_tagihan = (NEW.total_kwh * v_tarif_kwh) + v_biaya_beban;
                
                -- Set jatuh tempo 20 hari dari tanggal tagihan
                SET v_jatuh_tempo = DATE_ADD(CURDATE(), INTERVAL 20 DAY);
                
                -- Insert ke tabel tagihan
                INSERT INTO tagihan (
                    id_penggunaan, 
                    id_pelanggan, 
                    total_tagihan, 
                    jatuh_tempo, 
                    status_bayar
                ) VALUES (
                    NEW.id_penggunaan,
                    NEW.id_pelanggan,
                    v_total_tagihan,
                    v_jatuh_tempo,
                    'Belum Bayar'
                );
            END
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP TRIGGER IF EXISTS trg_after_insert_penggunaan');
        DB::unprepared('DROP FUNCTION IF EXISTS fn_total_penggunaan_bulan');
        DB::unprepared('DROP PROCEDURE IF EXISTS sp_pelanggan_900watt');
        DB::statement('DROP VIEW IF EXISTS vw_informasi_penggunaan');
    }
};
