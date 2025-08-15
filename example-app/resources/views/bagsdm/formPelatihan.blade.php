@extends('bagsdm.header')

@section('content')
<style>
    /* Rapiin padding dan posisi konten */
    .table th, .table td {
        vertical-align: middle !important;
        padding: 0.6rem 0.9rem !important;
        white-space: nowrap;
    }
    /* Hover efek */
    .table-hover tbody tr:hover {
        background-color: #f1f7ff;
    }
    /* Badge custom biar konsisten */
    .badge {
        font-size: 0.85rem;
        padding: 0.4em 0.6em;
        border-radius: 0.4rem;
    }
</style>

<div class="card mt-4 shadow-sm">
    <div class="card-header bg-primary text-white">
        <h4 class="mb-0">Data Pelatihan</h4>
    </div>
    <div class="card-body">
        
        {{-- Form Pencarian --}}
        <form method="GET" action="{{ route('bagsdm.formPelatihan') }}" class="mb-3">
            <div class="row g-2">
                <div class="col-md-3">
                    <input type="text" name="search" class="form-control" placeholder="Cari data" value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <input type="date" name="tanggal" class="form-control" value="{{ request('tanggal') }}">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-search"></i> Cari
                    </button>
                </div>
            </div>
        </form>

        {{-- Tabel --}}
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover mt-3">
                <thead class="table-primary text-center">
                    <tr>
                        <th>No</th>
                        <th>Judul Pelatihan</th>
                        <th>Periode Pelatihan</th>
                        <th>Metode</th>
                        <th>Lokasi</th>
                        <th>Jenis</th>
                        <th>Penyelenggara</th>
                        <th>Biaya</th>
                        <th>Status Pelatihan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pelatihan as $index => $item)
                        @php
                            $today = \Carbon\Carbon::today();
                            if ($today->between(\Carbon\Carbon::parse($item->tgl_awal), \Carbon\Carbon::parse($item->tgl_akhir))) {
                                $status = 'Sedang Berlangsung';
                                $badgeClass = 'bg-success text-white';
                            } elseif ($today->lt(\Carbon\Carbon::parse($item->tgl_awal))) {
                                $status = 'Pelatihan Mendatang';
                                $badgeClass = 'bg-warning text-dark';
                            } else {
                                $status = 'Telah Berakhir';
                                $badgeClass = 'bg-danger text-white';
                            }
                        @endphp
                        <tr>
                            <td class="text-center">{{ $pelatihan->firstItem() + $index }}</td>
                            <td>{{ $item->judul_pelatihan }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->tgl_awal)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($item->tgl_akhir)->format('d/m/Y') }}</td>
                            <td>{{ $item->metode_pelatihan }}</td>
                            <td>{{ $item->lokasi_pelatihan }}</td>
                            <td>{{ $item->jenis_pelatihan }}</td>
                            <td>{{ $item->penyelenggara }}</td>
                            <td>Rp{{ number_format($item->biaya, 0, ',', '.') }}</td>
                            <td class="text-center">
                                <span class="badge {{ $badgeClass }}">{{ $status }}</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center text-muted py-4">Data tidak tersedia</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Paginasi --}}
        <div class="d-flex justify-content-center mt-3">
            {{ $pelatihan->links() }}
        </div>
    </div>
</div>
@endsection
