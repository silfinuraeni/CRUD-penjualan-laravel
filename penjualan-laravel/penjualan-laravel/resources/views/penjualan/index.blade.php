@extends('layouts.app')

@section('title', 'Daftar Penjualan')

@section('content')
<div class="topbar">
    <div>
        <h1>Daftar Penjualan</h1>
        <p class="muted">Kelola data transaksi penjualan.</p>
    </div>

    <a href="{{ route('penjualan.create') }}" class="btn btn-primary">
        + Tambah Transaksi
    </a>
</div>

@if (session('success'))
    <div class="card" style="margin-bottom: 16px; color: green;">
        {{ session('success') }}
    </div>
@endif

<div class="card" style="margin-bottom: 20px;">
    <p class="muted">Total Omzet dari Transaksi Selesai</p>
    <h2>Rp {{ number_format($totalOmzet, 0, ',', '.') }}</h2>
</div>

<div class="card" style="margin-bottom: 20px;">
    <form action="{{ route('penjualan.index') }}" method="GET">
        <div class="grid">
            <div>
                <label for="search">Cari Transaksi</label>
                <input
                    type="text"
                    id="search"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Kode, nama pelanggan, atau produk"
                >
            </div>

            <div>
                <label for="status">Filter Status</label>
                <select id="status" name="status">
                    <option value="">Semua Status</option>
                    <option value="Selesai" {{ request('status') == 'Selesai' ? 'selected' : '' }}>
                        Selesai
                    </option>
                    <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>
                        Pending
                    </option>
                    <option value="Batal" {{ request('status') == 'Batal' ? 'selected' : '' }}>
                        Batal
                    </option>
                </select>
            </div>
        </div>

        <div class="actions" style="margin-top: 16px;">
            <button type="submit" class="btn btn-primary">
                Cari / Filter
            </button>

            <a href="{{ route('penjualan.index') }}" class="btn">
                Reset
            </a>
        </div>
    </form>
</div>

<div class="card">
    <h2>Data Transaksi</h2>

    <div style="overflow-x: auto;">
        <table>
            <thead>
                <tr>
                    <th>Kode Transaksi</th>
                    <th>Tanggal</th>
                    <th>Pelanggan</th>
                    <th>Produk</th>
                    <th>Jumlah</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($penjualan as $item)
                    <tr>
                        <td>{{ $item->kode_transaksi }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}</td>
                        <td>{{ $item->nama_pelanggan }}</td>
                        <td>{{ $item->nama_produk }}</td>
                        <td>{{ $item->jumlah }}</td>
                        <td>Rp {{ number_format($item->total, 0, ',', '.') }}</td>
                        <td>{{ $item->status }}</td>
                        <td>
                            <div class="actions">
                                <a href="{{ route('penjualan.show', $item) }}" class="btn">
                                    Detail
                                </a>

                                <a href="{{ route('penjualan.edit', $item) }}" class="btn">
                                    Edit
                                </a>

                                <form
                                    action="{{ route('penjualan.destroy', $item) }}"
                                    method="POST"
                                    onsubmit="return confirm('Yakin ingin menghapus transaksi ini?')"
                                >
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="btn">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" style="text-align: center; padding: 24px;">
                            Tidak ada transaksi yang cocok dengan pencarian atau filter.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection