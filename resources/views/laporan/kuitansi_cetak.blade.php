<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kuitansi Peminjaman #{{ $peminjaman->id_pinjam }}</title>
    <link href="{{ asset('library/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <style>
        @media print {
            body {
                font-family: 'Courier New', Courier, monospace !important; /* Font monospace untuk kesan struk */
                font-size: 10pt !important;
                margin: 0;
                padding: 0;
            }
            .container-kuitansi {
                width: 80mm; /* Lebar standar struk */
                margin: auto;
                padding: 10mm;
                border: none !important;
            }
            .header-kuitansi, .footer-kuitansi {
                text-align: center;
                margin-bottom: 10px;
            }
            .divider {
                border-top: 1px dashed #000;
                margin: 10px 0;
            }
            .item-table {
                width: 100%;
                border-collapse: collapse;
                margin-bottom: 10px;
            }
            .item-table th, .item-table td {
                padding: 2px 0;
                text-align: left;
                vertical-align: top;
            }
            .item-table th:nth-child(2), .item-table td:nth-child(2) { text-align: right; } /* Qty */
            .item-table th:nth-child(3), .item-table td:nth-child(3) { text-align: right; } /* Harga */
            .item-table th:nth-child(4), .item-table td:nth-child(4) { text-align: right; } /* Subtotal */
            .no-print {
                display: none !important;
            }
        }

        /* Tampilan di layar sebelum cetak */
        body { background-color: #f0f2f5; }
        .container-kuitansi {
            background-color: #fff;
            padding: 20px;
            margin-top: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            width: 80mm; /* Lebar di layar */
            min-height: 200px;
        }
    </style>
</head>
<body>
    <div class="container-kuitansi">
        <div class="header-kuitansi">
            <strong>PERPUSTAKAAN PINTAR</strong><br>
            Jl. Contoh No. 123<br>
            Telp: (021) 1234567<br>
            ----------------------------------
        </div>

        <div style="font-size: 9pt;">
            <p><strong>Kuitansi Peminjaman</strong></p>
            <p>Tgl Pinjam: {{ $peminjaman->tgl_peminjaman->format('d/m/Y H:i') }}</p>
            <p>No. Pinjam: {{ $peminjaman->id_pinjam }}</p>
            <p>Anggota : {{ $peminjaman->anggota->nama ?? 'N/A' }} ({{ $peminjaman->anggota->no_hp ?? 'N/A' }})</p>
            <p>Petugas : {{ $peminjaman->user->nama_user ?? 'N/A' }}</p>
            <p>Lama Pinjam: {{ $peminjaman->lama_pinjam }} hari</p>
            @if ($peminjaman->id_denda)
                <p>Jenis Denda: Rp {{ number_format($peminjaman->denda->nominal, 2, ',', '.') }} /hari</p>
            @endif
        </div>

        <div class="divider"></div>

        <table class="item-table">
            <thead>
                <tr>
                    <th>Buku</th>
                    <th>Kembali</th>
                    <th>Denda</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($peminjaman->detailPinjam as $detail)
                    <tr>
                        <td>{{ $detail->buku->judul ?? 'N/A' }}<br><small>ISBN: {{ $detail->buku->isbn ?? 'N/A' }}</small></td>
                        <td>{{ $detail->tgl_kembali ? $detail->tgl_kembali->format('d/m/Y') : 'BELUM' }}</td>
                        <td>
                            @if (!is_null($detail->tgl_kembali) && $peminjaman->denda && $detail->tgl_kembali->greaterThan($peminjaman->tgl_peminjaman->addDays($peminjaman->lama_pinjam)))
                                @php
                                    $tglHarusKembali = $peminjaman->tgl_peminjaman->addDays($peminjaman->lama_pinjam);
                                    $keterlambatan = $detail->tgl_kembali->diffInDays($tglHarusKembali);
                                    $dendaBukuIni = $keterlambatan * $peminjaman->denda->nominal;
                                @endphp
                                Rp {{ number_format($dendaBukuIni, 2, ',', '.') }}
                            @else
                                Rp 0,00
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="divider"></div>

        <div class="total-section">
            <p>Total Denda Peminjaman: <strong>Rp {{ number_format($peminjaman->nominal_denda, 2, ',', '.') }}</strong></p>
        </div>

        <div class="footer-kuitansi" style="font-size: 9pt; margin-top: 20px;">
            <p>Terima kasih telah meminjam di Perpustakaan Pintar.</p>
            <p>-- Layanan Terbaik Kami --</p>
        </div>

        <div class="text-center no-print" style="margin-top: 20px;">
            <button onclick="window.print()" class="btn btn-primary me-2">Cetak Kuitansi</button>
            <a href="{{ route('peminjaman.show', $peminjaman->id_pinjam) }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
    <script src="{{ asset('library/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
