@extends('dashboard.header')

@section('content')
<div class="container mt-4">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h4>Sertifikat Pelatihan</h4>
        </div>
        <div class="card-body">
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>No</th>
                        <th>Judul Pelatihan</th>
                        <th>Periode Pelatihan</th>
                        <th>Metode Pelatihan</th>
                        <th>Lokasi Pelatihan</th>
                        <th>Jenis Pelatihan</th>
                        <th>Penyelenggara</th>
                        <th>Biaya</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pelatihanBerakhir as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item->judul_pelatihan }}</td>
                        <td>{{ $item->tgl_awal }} s/d {{ $item->tgl_akhir }}</td>
                        <td>{{ $item->metode_pelatihan }}</td>
                        <td>{{ $item->lokasi_pelatihan }}</td>
                        <td>{{ $item->jenis_pelatihan }}</td>
                        <td>{{ $item->penyelenggara }}</td>
                        <td>Rp{{ number_format($item->biaya, 0, ',', '.') }}</td>
                        <td>
                            <a href="{{ route('sertifikat.download', $item->id) }}" class="btn btn-primary btn-sm">
                                <i class="fa fa-download"></i> Unduh
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center text-muted">Tidak ada sertifikat tersedia.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
                        <div class="mt-3">
                                {{ $pelatihanBerakhir->links() }}
                            </div>

        </div>
    </div>
</div>

@endsection
