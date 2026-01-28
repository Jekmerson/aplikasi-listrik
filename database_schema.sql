-- =============================================
-- Database: aplikasi_listrik_pascabayar
-- Complete Schema with Sample Data
-- Author: SERKOM Assessment
-- Date: 2026-01-28
-- =============================================

DROP DATABASE IF EXISTS aplikasi_listrik_pascabayar;
CREATE DATABASE aplikasi_listrik_pascabayar 
CHARACTER SET utf8mb4 
COLLATE utf8mb4_unicode_ci;

USE aplikasi_listrik_pascabayar;

-- =============================================
-- TABLE DEFINITIONS
-- =============================================

-- Tabel Level (User Roles)
CREATE TABLE level (
    id_level INT AUTO_INCREMENT PRIMARY KEY,
    nama_level VARCHAR(50) NOT NULL UNIQUE,
    deskripsi TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Tabel User
CREATE TABLE user (
    id_user INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    nama_lengkap VARCHAR(100) NOT NULL,
    email VARCHAR(100),
    id_level INT NOT NULL,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_level) REFERENCES level(id_level) ON DELETE RESTRICT,
    INDEX idx_username (username),
    INDEX idx_level (id_level)
) ENGINE=InnoDB;

-- Tabel Tarif Listrik
CREATE TABLE tarif (
    id_tarif INT AUTO_INCREMENT PRIMARY KEY,
    nama_tarif VARCHAR(50) NOT NULL,
    tarif_per_kwh DECIMAL(10,2) NOT NULL,
    biaya_beban DECIMAL(10,2) DEFAULT 0,
    berlaku_dari DATE NOT NULL,
    berlaku_sampai DATE,
    keterangan TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_berlaku (berlaku_dari, berlaku_sampai)
) ENGINE=InnoDB;

-- Tabel Daya Listrik
CREATE TABLE daya_listrik (
    id_daya_listrik INT AUTO_INCREMENT PRIMARY KEY,
    daya_watt INT NOT NULL UNIQUE,
    id_tarif INT NOT NULL,
    keterangan VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_tarif) REFERENCES tarif(id_tarif) ON DELETE RESTRICT,
    INDEX idx_daya (daya_watt)
) ENGINE=InnoDB;

-- Tabel Pelanggan
CREATE TABLE pelanggan (
    id_pelanggan VARCHAR(20) PRIMARY KEY,
    nama_pelanggan VARCHAR(100) NOT NULL,
    alamat TEXT NOT NULL,
    no_telepon VARCHAR(15),
    email VARCHAR(100),
    id_daya_listrik INT NOT NULL,
    id_user INT,
    tanggal_registrasi DATE NOT NULL,
    status ENUM('Aktif', 'Nonaktif', 'Suspend') DEFAULT 'Aktif',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_daya_listrik) REFERENCES daya_listrik(id_daya_listrik) ON DELETE RESTRICT,
    FOREIGN KEY (id_user) REFERENCES user(id_user) ON DELETE SET NULL,
    INDEX idx_nama (nama_pelanggan),
    INDEX idx_status (status),
    INDEX idx_daya (id_daya_listrik)
) ENGINE=InnoDB;

-- Tabel Penggunaan Listrik
CREATE TABLE penggunaan (
    id_penggunaan INT AUTO_INCREMENT PRIMARY KEY,
    id_pelanggan VARCHAR(20) NOT NULL,
    bulan TINYINT NOT NULL CHECK (bulan BETWEEN 1 AND 12),
    tahun YEAR NOT NULL,
    meter_awal INT NOT NULL,
    meter_akhir INT NOT NULL,
    total_kwh INT GENERATED ALWAYS AS (meter_akhir - meter_awal) STORED,
    tanggal_catat DATETIME DEFAULT CURRENT_TIMESTAMP,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_pelanggan) REFERENCES pelanggan(id_pelanggan) ON DELETE CASCADE,
    UNIQUE KEY unique_periode (id_pelanggan, bulan, tahun),
    INDEX idx_periode (tahun, bulan),
    INDEX idx_pelanggan_periode (id_pelanggan, tahun, bulan),
    CHECK (meter_akhir > meter_awal)
) ENGINE=InnoDB;

-- Tabel Tagihan
CREATE TABLE tagihan (
    id_tagihan INT AUTO_INCREMENT PRIMARY KEY,
    id_penggunaan INT NOT NULL,
    id_pelanggan VARCHAR(20) NOT NULL,
    total_tagihan DECIMAL(12,2) NOT NULL,
    tanggal_tagihan DATETIME DEFAULT CURRENT_TIMESTAMP,
    jatuh_tempo DATE NOT NULL,
    status_bayar ENUM('Belum Bayar', 'Sudah Bayar', 'Terlambat') DEFAULT 'Belum Bayar',
    denda DECIMAL(10,2) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_penggunaan) REFERENCES penggunaan(id_penggunaan) ON DELETE CASCADE,
    FOREIGN KEY (id_pelanggan) REFERENCES pelanggan(id_pelanggan) ON DELETE CASCADE,
    INDEX idx_status (status_bayar),
    INDEX idx_jatuh_tempo (jatuh_tempo),
    INDEX idx_pelanggan (id_pelanggan)
) ENGINE=InnoDB;

-- Tabel Pembayaran
CREATE TABLE pembayaran (
    id_pembayaran INT AUTO_INCREMENT PRIMARY KEY,
    id_tagihan INT NOT NULL,
    jumlah_bayar DECIMAL(12,2) NOT NULL,
    tanggal_bayar DATETIME DEFAULT CURRENT_TIMESTAMP,
    metode_bayar ENUM('Tunai', 'Transfer', 'EDC', 'QRIS') DEFAULT 'Tunai',
    keterangan TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_tagihan) REFERENCES tagihan(id_tagihan) ON DELETE RESTRICT,
    INDEX idx_tanggal (tanggal_bayar),
    INDEX idx_metode (metode_bayar)
) ENGINE=InnoDB;

-- =============================================
-- DATA SEEDING
-- =============================================

-- Insert Level User
INSERT INTO level (nama_level, deskripsi) VALUES
('Admin', 'Administrator dengan akses penuh sistem'),
('Operator', 'Operator PLN untuk input data'),
('Pelanggan', 'Pelanggan listrik pascabayar');

-- Insert User (Password menggunakan hash MD5 untuk demo)
INSERT INTO user (username, password, nama_lengkap, email, id_level) VALUES
('admin', MD5('admin123'), 'Administrator Sistem', 'admin@pln.co.id', 1),
('operator1', MD5('operator123'), 'Budi Santoso', 'budi@pln.co.id', 2),
('operator2', MD5('operator123'), 'Siti Nurhaliza', 'siti@pln.co.id', 2),
('PEL001', MD5('password123'), 'Ahmad Subarjo', 'ahmad@email.com', 3),
('PEL002', MD5('password123'), 'Rina Melati', 'rina@email.com', 3),
('PEL003', MD5('password123'), 'Joko Widodo', 'joko@email.com', 3);

-- Insert Tarif (berdasarkan tarif PLN 2026)
INSERT INTO tarif (nama_tarif, tarif_per_kwh, biaya_beban, berlaku_dari) VALUES
('R-1/TR 450VA', 169.00, 0, '2026-01-01'),
('R-1/TR 900VA', 1352.00, 0, '2026-01-01'),
('R-1/TR 1300VA', 1444.70, 0, '2026-01-01'),
('R-1/TR 2200VA', 1444.70, 0, '2026-01-01'),
('B-2/TR 2200VA', 1699.53, 0, '2026-01-01');

-- Insert Daya Listrik
INSERT INTO daya_listrik (daya_watt, id_tarif, keterangan) VALUES
(450, 1, 'Rumah Tangga 450 VA'),
(900, 2, 'Rumah Tangga 900 VA'),
(1300, 3, 'Rumah Tangga 1300 VA'),
(2200, 4, 'Rumah Tangga 2200 VA'),
(3500, 5, 'Bisnis 3500 VA');

-- Insert Pelanggan
INSERT INTO pelanggan (id_pelanggan, nama_pelanggan, alamat, no_telepon, email, id_daya_listrik, id_user, tanggal_registrasi, status) VALUES
('PEL001', 'Ahmad Subarjo', 'Jl. Merdeka No. 123, Jakarta Pusat', '081234567890', 'ahmad@email.com', 2, 4, '2025-01-15', 'Aktif'),
('PEL002', 'Rina Melati', 'Jl. Sudirman No. 45, Jakarta Selatan', '081298765432', 'rina@email.com', 2, 5, '2025-02-20', 'Aktif'),
('PEL003', 'Joko Widodo', 'Jl. Gatot Subroto No. 78, Jakarta Barat', '081356789012', 'joko@email.com', 3, 6, '2025-01-10', 'Aktif'),
('PEL004', 'Susi Susanti', 'Jl. Ahmad Yani No. 99, Bandung', '082112345678', 'susi@email.com', 1, NULL, '2025-03-05', 'Aktif'),
('PEL005', 'Bambang Pamungkas', 'Jl. Diponegoro No. 200, Surabaya', '083187654321', 'bambang@email.com', 4, NULL, '2025-02-15', 'Aktif');

-- Insert Penggunaan Listrik (Januari 2026)
INSERT INTO penggunaan (id_pelanggan, bulan, tahun, meter_awal, meter_akhir, tanggal_catat) VALUES
('PEL001', 1, 2026, 1000, 1150, '2026-01-28 10:00:00'),
('PEL002', 1, 2026, 2000, 2200, '2026-01-28 10:15:00'),
('PEL003', 1, 2026, 3000, 3250, '2026-01-28 10:30:00'),
('PEL004', 1, 2026, 500, 580, '2026-01-28 10:45:00'),
('PEL005', 1, 2026, 4000, 4350, '2026-01-28 11:00:00');

-- Insert Penggunaan Bulan Desember 2025
INSERT INTO penggunaan (id_pelanggan, bulan, tahun, meter_awal, meter_akhir, tanggal_catat) VALUES
('PEL001', 12, 2025, 850, 1000, '2025-12-28 10:00:00'),
('PEL002', 12, 2025, 1800, 2000, '2025-12-28 10:15:00');

-- =============================================
-- VIEWS
-- =============================================

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
    p.nama_pelanggan;

-- =============================================
-- STORED PROCEDURES
-- =============================================

DELIMITER $$

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
END$$

DELIMITER ;

-- =============================================
-- FUNCTIONS
-- =============================================

DELIMITER $$

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
END$$

DELIMITER ;

-- =============================================
-- TRIGGERS
-- =============================================

DELIMITER $$

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
END$$

DELIMITER ;

-- =============================================
-- VERIFY DATABASE
-- =============================================

SELECT 'Database created successfully!' AS Status;
SELECT COUNT(*) AS 'Total Tables' FROM information_schema.tables WHERE table_schema = 'aplikasi_listrik_pascabayar';
SELECT COUNT(*) AS 'Total Pelanggan' FROM pelanggan;
SELECT COUNT(*) AS 'Total Penggunaan' FROM penggunaan;
