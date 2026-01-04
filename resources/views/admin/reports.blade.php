@extends('layouts.admin')
@section('title', 'Cetak Laporan')
@section('content')
    <div class="page-header no-print">
        <h1 class="page-title">Fitur Cetak Laporan</h1>
        <button onclick="printReport()" class="btn btn-primary">
            <i class="fas fa-file-pdf"></i> Simpan Sebagai PDF
        </button>
    </div>

    <div class="card no-print" style="margin-bottom: 2rem;">
        <div class="card-body">
            <p class="text-muted mb-3">Pilih rentang tanggal untuk menyaring data laporan:</p>
            <form method="GET" style="display: flex; gap: 1rem; align-items: flex-end;">
                <div class="form-group" style="margin-bottom: 0;">
                    <label class="form-label">Mulai</label>
                    <input type="date" name="start_date" class="form-control" value="{{ $startDate }}">
                </div>
                <div class="form-group" style="margin-bottom: 0;">
                    <label class="form-label">Selesai</label>
                    <input type="date" name="end_date" class="form-control" value="{{ $endDate }}">
                </div>
                <button type="submit" class="btn btn-secondary"><i class="fas fa-sync"></i> Update Data</button>
            </form>
        </div>
    </div>

    <!-- AREA LAPORAN (Sangat Simpel Untuk PDF) -->
    <div id="printableArea" class="report-container">
        <div class="report-header">
            <h1>LAPORAN OPERASIONAL LELANG</h1>
            <p>Sistem Informasi Pelelangan Online (LelangKu)</p>
            <div class="report-meta">
                <span>Periode: <strong>{{ $startDate }}</strong> s/d <strong>{{ $endDate }}</strong></span>
                <span>Dicetak pada: {{ date('d/m/Y H:i') }}</span>
            </div>
        </div>

        <hr class="report-divider">

        <h3 class="section-title">1. Ringkasan Status Barang</h3>
        <table class="report-table">
            <thead>
                <tr>
                    <th>Status Lelang</th>
                    <th style="text-align: right;">Jumlah Barang</th>
                </tr>
            </thead>
            <tbody>
                @forelse($auctionStats as $stat)
                    <tr>
                        <td>{{ ucfirst($stat->status) }}</td>
                        <td style="text-align: right;">{{ $stat->count }} Item</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2" style="text-align: center;">Tidak ada data pada periode ini</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <h3 class="section-title" style="margin-top: 2rem;">2. Partisipan Lelang Teraktif</h3>
        <table class="report-table">
            <thead>
                <tr>
                    <th width="80">Peringkat</th>
                    <th>Nama Lengkap</th>
                    <th style="text-align: right;">Total Penawaran (Bid)</th>
                </tr>
            </thead>
            <tbody>
                @forelse($topBidders as $i => $bidder)
                    <tr>
                        <td>#{{ $i + 1 }}</td>
                        <td>{{ $bidder->name }}</td>
                        <td style="text-align: right;">{{ $bidder->bids_count }} kali</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" style="text-align: center;">Belum ada aktivitas penawaran</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="report-footer">
            <p>Dokumen ini dihasilkan secara otomatis oleh Sistem LelangKu pada {{ date('Y') }}.</p>
        </div>
    </div>
@endsection

@section('styles')
    <style>
        /* Style untuk tampilan di layar (Sederhana) */
        .report-container {
            background: white;
            color: black;
            padding: 3rem;
            border-radius: 8px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            max-width: 900px;
            margin: 0 auto;
        }

        .report-header {
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .report-header h1 {
            font-size: 22px;
            font-weight: 800;
            color: #1a1a2e;
            margin-bottom: 5px;
        }

        .report-header p {
            color: #666;
            font-size: 14px;
        }

        .report-meta {
            display: flex;
            justify-content: space-between;
            font-size: 12px;
            margin-top: 15px;
            color: #444;
            border-top: 1px dashed #ccc;
            padding-top: 10px;
        }

        .report-divider {
            border: none;
            border-top: 2px solid #333;
            margin-bottom: 2rem;
        }

        .section-title {
            font-size: 16px;
            font-weight: 700;
            margin-bottom: 1rem;
            color: #333;
            border-left: 4px solid #6366f1;
            padding-left: 10px;
        }

        .report-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 1rem;
        }

        .report-table th {
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            padding: 12px;
            text-align: left;
            font-size: 13px;
        }

        .report-table td {
            border: 1px solid #dee2e6;
            padding: 10px;
            font-size: 13px;
        }

        .report-footer {
            margin-top: 4rem;
            text-align: center;
            font-size: 11px;
            color: #888;
            border-top: 1px solid #eee;
            padding-top: 20px;
        }

        /* Pengaturan KHUSUS Saat PRINT / Simpan PDF */
        @media print {

            .no-print,
            .sidebar,
            .navbar,
            .footer {
                display: none !important;
            }

            .main-content {
                margin-left: 0 !important;
                padding: 0 !important;
                width: 100% !important;
            }

            .report-container {
                box-shadow: none !important;
                padding: 0 !important;
                width: 100% !important;
                max-width: none !important;
            }

            body {
                background: white !important;
            }

            @page {
                size: portrait;
                margin: 2cm;
            }
        }
    </style>
@endsection

@section('scripts')
    <script>
        function printReport() {
            // Mengubah nama file saat disimpan ke PDF agar terlihat profesional
            const originalTitle = document.title;
            document.title = "Laporan_Lelang_" + new Date().toLocaleDateString('id-ID');
            window.print();
            document.title = originalTitle;
        }
    </script>
@endsection