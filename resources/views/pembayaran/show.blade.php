<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Pembayaran - {{ $pembayaran->id_pembayaran }}</title>
    <style>
        @media print {
            .no-print {
                display: none;
            }
            @page {
                margin: 0.5cm;
            }
        }
        
        body {
            font-family: 'Courier New', monospace;
            font-size: 12px;
            max-width: 300px;
            margin: 20px auto;
            padding: 20px;
            border: 1px dashed #333;
        }
        
        .header {
            text-align: center;
            border-bottom: 1px dashed #333;
            padding-bottom: 10px;
            margin-bottom: 10px;
        }
        
        .header h2 {
            margin: 5px 0;
            font-size: 16px;
        }
        
        .header p {
            margin: 2px 0;
            font-size: 10px;
        }
        
        .content {
            margin: 15px 0;
        }
        
        .row {
            display: flex;
            justify-content: space-between;
            margin: 5px 0;
        }
        
        .separator {
            border-top: 1px dashed #333;
            margin: 10px 0;
        }
        
        .total {
            font-size: 14px;
            font-weight: bold;
            padding: 10px 0;
            border-top: 2px solid #333;
            border-bottom: 2px solid #333;
            margin: 10px 0;
        }
        
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 10px;
            border-top: 1px dashed #333;
            padding-top: 10px;
        }
        
        .btn-print {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            margin: 10px 0;
        }
        
        .btn-print:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="no-print" style="text-align: center; margin-bottom: 20px;">
        <button onclick="window.print()" class="btn-print">
            🖨️ Cetak Struk
        </button>
        <button onclick="window.close()" class="btn-print" style="background-color: #6c757d;">
            ✖️ Tutup
        </button>
    </div>

    <div class="header">
        <h2>PLN</h2>
        <h3>STRUK PEMBAYARAN</h3>
        <p>Aplikasi Listrik Pascabayar</p>
        <p>Jl. Contoh No. 123, Jakarta</p>
        <p>Telp: (021) 12345678</p>
    </div>

    <div class="content">
        <div class="row">
            <span>No. Struk</span>
            <span><strong>{{ $pembayaran->id_pembayaran }}</strong></span>
        </div>
        <div class="row">
            <span>Tanggal</span>
            <span>{{ $pembayaran->tanggal_bayar->format('d/m/Y H:i') }}</span>
        </div>
        <div class="row">
            <span>Kasir</span>
            <span>Operator</span>
        </div>

        <div class="separator"></div>

        <div class="row">
            <span>ID Pelanggan</span>
            <span><strong>{{ $pembayaran->tagihan->pelanggan->id_pelanggan }}</strong></span>
        </div>
        <div class="row">
            <span>Nama</span>
            <span>{{ $pembayaran->tagihan->pelanggan->nama_pelanggan }}</span>
        </div>
        <div class="row">
            <span>Alamat</span>
        </div>
        <div style="margin-left: 0; margin-top: 2px; font-size: 11px;">
            {{ $pembayaran->tagihan->pelanggan->alamat }}
        </div>
        <div class="row">
            <span>Daya</span>
            <span>{{ $pembayaran->tagihan->pelanggan->dayaListrik->daya_watt }} VA</span>
        </div>

        <div class="separator"></div>

        <div class="row">
            <span>Periode Tagihan</span>
            <span>{{ $pembayaran->tagihan->penggunaan ? $pembayaran->tagihan->penggunaan->periode : '-' }}</span>
        </div>
        <div class="row">
            <span>ID Tagihan</span>
            <span>{{ $pembayaran->tagihan->id_tagihan }}</span>
        </div>

        <div class="separator"></div>

        <div class="row">
            <span>Penggunaan</span>
            <span>{{ $pembayaran->tagihan->penggunaan ? number_format($pembayaran->tagihan->penggunaan->total_kwh, 2) : 0 }} kWh</span>
        </div>
        <div class="row">
            <span>Tarif/kWh</span>
            <span>Rp {{ number_format($pembayaran->tagihan->pelanggan->dayaListrik->tarif->tarif_per_kwh, 0, ',', '.') }}</span>
        </div>
        
        @if($pembayaran->tagihan->penggunaan)
        <div class="row" style="font-size: 10px; color: #666;">
            <span>Meter Awal</span>
            <span>{{ number_format($pembayaran->tagihan->penggunaan->meter_awal, 0, ',', '.') }}</span>
        </div>
        <div class="row" style="font-size: 10px; color: #666;">
            <span>Meter Akhir</span>
            <span>{{ number_format($pembayaran->tagihan->penggunaan->meter_akhir, 0, ',', '.') }}</span>
        </div>
        @endif

        <div class="separator"></div>

        <div class="row">
            <span>Subtotal</span>
            <span>Rp {{ number_format($pembayaran->tagihan->total_tagihan, 0, ',', '.') }}</span>
        </div>

        @if($pembayaran->tagihan->denda > 0)
        <div class="row">
            <span>Denda</span>
            <span>Rp {{ number_format($pembayaran->tagihan->denda, 0, ',', '.') }}</span>
        </div>
        @endif

        <div class="total">
            <div class="row">
                <span>TOTAL BAYAR</span>
                <span>Rp {{ number_format($pembayaran->jumlah_bayar, 0, ',', '.') }}</span>
            </div>
        </div>

        <div class="row">
            <span>Metode Bayar</span>
            <span><strong>{{ strtoupper($pembayaran->metode_bayar) }}</strong></span>
        </div>
    </div>

    <div class="footer">
        <p>*** TERIMA KASIH ***</p>
        <p>Struk ini adalah bukti pembayaran yang sah</p>
        <p>Simpan struk ini dengan baik</p>
        <p style="margin-top: 10px;">Dicetak: {{ date('d/m/Y H:i:s') }}</p>
    </div>

    <script>
        // Auto print on load (optional)
        // window.onload = function() { window.print(); }
    </script>
</body>
</html>
