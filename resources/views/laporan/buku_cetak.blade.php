<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Laporan Buku</title>
    <!-- Bootstrap CSS dari file lokal Anda -->
    <link href="{{ asset('library/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
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
            <h3>LAPORAN DAFTAR BUKU</h3>
            <h4>Perpustakaan Pintar</h4>
            <p>Tanggal Cetak: {{ date('d M Y H:i:s') }}</p>
        </div>

        <table class="table-print">
            <thead>
                <tr>
                    <th>ID Buku</th>
                    <th>Judul</th>
                    <th>Pengarang</th>
                    <th>Penerbit</th>
                    <th>Tahun</th>
                    <th>ISBN</th>
                    <th>Kategori</th>
                    <th>Jml Halaman</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($buku as $item)
                <tr>
                    <td>{{ $item->id_buku }}</td>
                    <td>{{ $item->judul }}</td>
                    <td>{{ $item->pengarang }}</td>
                    <td>{{ $item->penerbit }}</td>
                    <td>{{ $item->tahun }}</td>
                    <td>{{ $item->isbn }}</td>
                    <td>{{ $item->kategori->kategori ?? 'N/A' }}</td>
                    <td>{{ $item->jml_halaman }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center">Tidak ada data buku untuk dicetak.</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <div class="total-section">
            <p>Total Buku Tercatat: <strong>{{ $buku->count() }}</strong></p>
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
