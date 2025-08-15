@extends('dashboard.header')

@section('content')
<style>
    .table th, .table td {
        vertical-align: middle !important;
        padding: 0.75rem 1rem !important;
        white-space: nowrap;
    }
    .table-responsive {
        overflow-x: auto;
    }
</style>

<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Sertifikat Pelatihan</h4>
        </div>
        <div class="card-body">
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <div class="table-responsive">
                <table class="table table-striped table-bordered align-middle">
                    <thead class="table-primary">
                        <tr class="text-center">
                            <th>No</th>
                            <th>Judul Pelatihan</th>
                            <th>Periode Pelatihan</th>
                            <th>Metode</th>
                            <th>Lokasi</th>
                            <th>Jenis</th>
                            <th>Penyelenggara</th>
                            <th>Biaya</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pelatihanBerakhir as $index => $item)
                            <tr>
                                <td class="text-center">{{ $pelatihanBerakhir->firstItem() + $index }}</td>
                                <td>{{ $item->judul_pelatihan }}</td>
                                <td class="text-center">
                                    {{ \Carbon\Carbon::parse($item->tgl_awal)->format('d-m-Y') }}
                                    s/d
                                    {{ \Carbon\Carbon::parse($item->tgl_akhir)->format('d-m-Y') }}
                                </td>
                                <td class="text-center">{{ $item->metode_pelatihan }}</td>
                                <td>{{ $item->lokasi_pelatihan }}</td>
                                <td class="text-center">{{ $item->jenis_pelatihan }}</td>
                                <td>{{ $item->penyelenggara }}</td>
                                <td class="text-end">Rp{{ number_format($item->biaya, 0, ',', '.') }}</td>
                                <td class="text-center">
                                    <a href="{{ route('sertifikat.download', $item->id) }}" class="btn btn-sm btn-primary">
                                        <i class="fa fa-download"></i> Unduh
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center text-muted py-4">
                                    Tidak ada sertifikat tersedia.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-3">
                {{ $pelatihanBerakhir->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
