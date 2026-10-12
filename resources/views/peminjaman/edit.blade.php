@extends('layouts.admin')

@section('page_title', 'Edit Peminjaman')

@section('content')
<div class="card">
    <div class="card-header">
        <h4>Form Edit Peminjaman #{{ $peminjaman->id_pinjam }}</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('peminjaman.update', $peminjaman->id_pinjam) }}" method="POST" class="confirm-submit">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="id_anggota" class="form-label">Anggota</label>
                <select class="form-select @error('id_anggota') is-invalid @enderror" id="id_anggota" name="id_anggota" required>
                    <option value="">Pilih Anggota</option>
                    @foreach($anggota as $item)
                        <option value="{{ $item->id_anggota }}" {{ old('id_anggota', $peminjaman->id_anggota) == $item->id_anggota ? 'selected' : '' }}>
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
                <input type="date" class="form-control @error('tgl_peminjaman') is-invalid @enderror" id="tgl_peminjaman" name="tgl_peminjaman" value="{{ old('tgl_peminjaman', $peminjaman->tgl_peminjaman->format('Y-m-d')) }}" required>
                @error('tgl_peminjaman')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="lama_pinjam" class="form-label">Lama Peminjaman (hari)</label>
                <input type="number" class="form-control @error('lama_pinjam') is-invalid @enderror" id="lama_pinjam" name="lama_pinjam" value="{{ old('lama_pinjam', $peminjaman->lama_pinjam) }}" required min="1">
                @error('lama_pinjam')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="id_denda" class="form-label">Jenis Denda (Opsional)</label>
                <select class="form-select @error('id_denda') is-invalid @enderror" id="id_denda" name="id_denda">
                    <option value="">Pilih Jenis Denda</option>
                    @foreach($denda as $item)
                        <option value="{{ $item->id_denda }}" {{ old('id_denda', $peminjaman->id_denda) == $item->id_denda ? 'selected' : '' }}>
                            Rp {{ number_format($item->nominal, 2, ',', '.') }} per hari
                        </option>
                    @endforeach
                </select>
                @error('id_denda')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="nominal_denda" class="form-label">Nominal Denda Total (diupdate saat pengembalian)</label>
                <input type="number" step="0.01" class="form-control @error('nominal_denda') is-invalid @enderror" id="nominal_denda" name="nominal_denda" value="{{ old('nominal_denda', $peminjaman->nominal_denda) }}" min="0">
                @error('nominal_denda')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Update Peminjaman</button>
            <a href="{{ route('peminjaman.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection