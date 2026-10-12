@extends('layouts.admin')

@section('page_title', 'Input Peminjaman Baru')

@section('content')
<div class="card">
    <div class="card-header">
        <h4>Form Peminjaman Buku</h4>
    </div>
    <div class="card-body">
        <form id="peminjamanForm" action="{{ route('peminjaman.store') }}" method="POST" class="confirm-submit">
            @csrf
            <div class="mb-3">
                <label for="id_anggota" class="form-label">Anggota</label>
                <select class="form-select @error('id_anggota') is-invalid @enderror" id="id_anggota" name="id_anggota" required>
                    <option value="">Pilih Anggota</option>
                    @foreach($anggota as $item)
                        <option value="{{ $item->id_anggota }}" {{ old('id_anggota') == $item->id_anggota ? 'selected' : '' }}>
                            {{ $item->nama }} ({{ $item->no_hp }})
                        </option>
                    @endforeach
                </select>
                @error('id_anggota')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="tgl_peminjaman" class="form-label">Tanggal Peminjaman</label>
                <input type="date" class="form-control @error('tgl_peminjaman') is-invalid @enderror" id="tgl_peminjaman" name="tgl_peminjaman" value="{{ old('tgl_peminjaman', date('Y-m-d')) }}" required>
                @error('tgl_peminjaman')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="lama_pinjam" class="form-label">Lama Peminjaman (hari)</label>
                <input type="number" class="form-control @error('lama_pinjam') is-invalid @enderror" id="lama_pinjam" name="lama_pinjam" value="{{ old('lama_pinjam', 7) }}" required min="1">
                @error('lama_pinjam')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="id_denda" class="form-label">Jenis Denda (Opsional)</label>
                <select class="form-select @error('id_denda') is-invalid @enderror" id="id_denda" name="id_denda">
                    <option value="">Pilih Jenis Denda</option>
                    @foreach($denda as $item)
                        <option value="{{ $item->id_denda }}" {{ old('id_denda') == $item->id_denda ? 'selected' : '' }}>
                            Rp {{ number_format($item->nominal, 2, ',', '.') }} per hari
                        </option>
                    @endforeach
                </select>
                @error('id_denda')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <hr>
            <h4>Buku yang Dipinjam</h4>
            <div id="books-list">
                {{-- Dynamic book selection rows will go here --}}
            </div>
            <button type="button" id="addBookBtn" class="btn btn-success mb-4">Tambah Buku</button>

            <button type="submit" class="btn btn-primary">Simpan Peminjaman</button>
            <a href="{{ route('peminjaman.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        let bookIndex = 0;
        const booksListContainer = document.getElementById('books-list');
        const addBookBtn = document.getElementById('addBookBtn');
        const allBuku = @json($buku); // Mengambil data buku dari controller

        addBookBtn.addEventListener('click', addBookRow);

        // Tambah baris buku pertama secara otomatis saat halaman dimuat
        if (booksListContainer.children.length === 0 && !{{ count(old('books') ?: []) }}) {
            addBookRow();
        }

        // Jika ada old input (setelah validasi gagal), isi kembali
        @if(old('books'))
            @foreach(old('books') as $oldBookId)
                addBookRow({{ $oldBookId }});
            @endforeach
        @endif


        function addBookRow(preselectedBookId = null) {
            const newRow = document.createElement('div');
            newRow.classList.add('row', 'mb-3', 'book-item', 'align-items-center');
            newRow.innerHTML = `
                <div class="col-md-10">
                    <label for="book_id_${bookIndex}" class="form-label">Pilih Buku</label>
                    <select class="form-select book-select" id="book_id_${bookIndex}" name="books[${bookIndex}]" required>
                        <option value="">Pilih Buku</option>
                        ${allBuku.map(buku => `<option value="${buku.id_buku}">${buku.judul} (${buku.pengarang})</option>`).join('')}
                    </select>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="button" class="btn btn-danger w-100 remove-book">Hapus</button>
                </div>
            `;
            booksListContainer.appendChild(newRow);

            // Set preselected value if provided (for old input)
            if (preselectedBookId) {
                newRow.querySelector('.book-select').value = preselectedBookId;
            }

            // Add event listener for removing book row
            newRow.querySelector('.remove-book').addEventListener('click', function() {
                newRow.remove();
            });

            bookIndex++;
        }
    });
</script>
@endsection