@extends('bagsdm.header')

@section('content')
<div class="card mt-4">
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
        <h4>Data Pelatihan</h4>
    </div>
    <div class="card-body">
        
        {{-- Form Pencarian --}}
        <form method="GET" action="{{ route('bagsdm.formPelatihan') }}" class="mb-3">
            <div class="row">
                <div class="col-md-3">
                    <input type="text" name="search" class="form-control" placeholder="Cari data" value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <input type="date" name="tanggal" class="form-control" value="{{ request('tanggal') }}">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </form>

        {{-- Tabel --}}
        <div class="table-responsive">
            <table class="table table-bordered table-hover mt-3">
                <thead class="thead-dark">
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
                                $badgeClass = 'badge bg-success text-white';
                            } elseif ($today->lt(\Carbon\Carbon::parse($item->tgl_awal))) {
                                $status = 'Pelatihan Mendatang';
                                $badgeClass = 'badge bg-warning text-dark';
                            } else {
                                $status = 'Telah Berakhir';
                                $badgeClass = 'badge bg-danger text-white';
                            }
                        @endphp
                        <tr>
                            <td>{{ $pelatihan->firstItem() + $index }}</td>
                            <td>{{ $item->judul_pelatihan }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->tgl_awal)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($item->tgl_akhir)->format('d/m/Y') }}</td>
                            <td>{{ $item->metode_pelatihan }}</td>
                            <td>{{ $item->lokasi_pelatihan }}</td>
                            <td>{{ $item->jenis_pelatihan }}</td>
                            <td>{{ $item->penyelenggara }}</td>
                            <td>Rp{{ number_format($item->biaya, 0, ',', '.') }}</td>
                            <td>
                                <span class="badge {{ $badgeClass }}">{{ $status }}</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center">Data tidak tersedia</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Paginasi --}}
        <div class="d-flex justify-content-center">
            {{ $pelatihan->links() }}
        </div>
    </div>
</div>
@endsection
