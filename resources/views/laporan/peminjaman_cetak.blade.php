<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Laporan Peminjaman</title>
    <!-- Bootstrap CSS dari file lokal Anda -->
    <link href="{{ asset('library/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Custom CSS untuk cetak -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        /* CSS khusus untuk tampilan cetak */
        @media print {
            body {
                background-color: #fff !important;
                color: #000 !important;
                margin: 0;
                padding: 0;
            }
            .no-print {
                display: none !important;
            }
            .container-print {
                width: 100%;
                margin: 0;
                padding: 15mm; /* Margin cetak */
                font-size: 10pt;
            }
            .header-print {
                text-align: center;
                margin-bottom: 20px;
                border-bottom: 2px solid #000;
                padding-bottom: 10px;
            }
            .table-print {
                width: 100%;
                border-collapse: collapse;
                margin-bottom: 20px;
            }
            .table-print th, .table-print td {
                border: 1px solid #ddd;
                padding: 8px;
                text-align: left;
            }
            .table-print th {
                background-color: #f2f2f2;
            }
            .total-section {
                text-align: right;
                margin-top: 20px;
            }
            .signature-section {
                margin-top: 50px;
                text-align: right;
            }
        }

        /* Tampilan di layar sebelum cetak */
        body {
            background-color: #f0f2f5;
        }
        .container-print {
            background-color: #fff;
            padding: 20px;
            margin-top: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <div class="container-print">
        <div class="header-print">
            <h3>LAPORAN PEMINJAMAN BUKU</h3>
            <h4>Perpustakaan Pintar</h4>
            <p>Tanggal Cetak: {{ date('d M Y H:i:s') }}</p>
        </div>

        @forelse ($peminjaman as $item)
            <div style="margin-bottom: 30px; border: 1px solid #eee; padding: 15px; border-radius: 5px;">
                <p><strong>ID Peminjaman:</strong> {{ $item->id_pinjam }}</p>
                <p><strong>Anggota:</strong> {{ $item->anggota->nama ?? 'N/A' }} ({{ $item->anggota->no_hp ?? 'N/A' }})</p>
                <p><strong>Petugas:</strong> {{ $item->user->nama_user ?? 'N/A' }}</p>
                <p><strong>Tanggal Peminjaman:</strong> {{ $item->tgl_peminjaman->format('d M Y') }}</p>
                <p><strong>Lama Peminjaman:</strong> {{ $item->lama_pinjam }} hari</p>
                <p><strong>Jenis Denda:</strong> Rp {{ number_format($item->denda->nominal ?? 0, 2, ',', '.') }} per hari</p>
                <p><strong>Total Denda Peminjaman Ini:</strong> Rp {{ number_format($item->nominal_denda, 2, ',', '.') }}</p>

                <h6 style="margin-top: 15px;">Buku yang Dipinjam:</h6>
                <table class="table-print">
                    <thead>
                        <tr>
                            <th>Judul Buku</th>
                            <th>ISBN</th>
                            <th>Tanggal Kembali</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($item->detailPinjam as $detail)
                            <tr>
                                <td>{{ $detail->buku->judul ?? 'N/A' }}</td>
                                <td>{{ $detail->buku->isbn ?? 'N/A' }}</td>
                                <td>{{ $detail->tgl_kembali ? $detail->tgl_kembali->format('d M Y') : 'BELUM' }}</td>
                                <td>
                                    @if(is_null($detail->tgl_kembali))
                                        Dipinjam
                                    @else
                                        Dikembalikan
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @empty
            <p>Tidak ada data peminjaman untuk dicetak.</p>
        @endforelse

        <div class="total-section">
            <p>Total Peminjaman Tercatat: <strong>{{ $peminjaman->count() }}</strong></p>
        </div>

        <div class="signature-section">
            <p>Hormat kami,</p>
            <br><br>
            <p>(_________________________)</p>
            <p>Petugas Perpustakaan</p>
        </div>

        <div class="text-center no-print" style="margin-top: 30px;">
            <button onclick="window.print()" class="btn btn-primary me-2">Cetak Laporan</button>
            <a href="{{ route('laporan.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="{{ asset('library/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
