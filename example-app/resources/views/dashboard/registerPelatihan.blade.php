@extends('dashboard.header')

@section('content')
<style>
    /* Styling tabel agar rapi */
    .table th, .table td {
        vertical-align: middle !important;
        padding: 0.75rem 1rem !important;
        white-space: nowrap;
    }
    .table-responsive {
        overflow-x: auto;
    }
</style>

<div class="card mt-4 shadow-sm">
    <div class="card-header bg-success text-white">
        <h4 class="mb-0">Daftar Pelatihan Tersedia</h4>
    </div>
    <div class="card-body">
        {{-- SweetAlert for Success --}}
        @if(session('success'))
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: '{{ session('success') }}',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK'
                    });
                });
            </script>
        @endif

        <div class="table-responsive">
            <table class="table table-striped table-bordered align-middle">
                <thead class="table-success">
                    <tr class="text-center">
                        <th>No</th>
                        <th>Judul Pelatihan</th>
                        <th>Tanggal Awal</th>
                        <th>Tanggal Akhir</th>
                        <th>Metode</th>
                        <th>Lokasi</th>
                        <th>Jenis</th>
                        <th>Penyelenggara</th>
                        <th>Biaya</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pelatihan as $index => $item)
                        <tr>
                            <td class="text-center">{{ $pelatihan->firstItem() + $index }}</td>
                            <td>{{ $item->judul_pelatihan }}</td>
                            <td class="text-center">{{ \Carbon\Carbon::parse($item->tgl_awal)->format('d-m-Y') }}</td>
                            <td class="text-center">{{ \Carbon\Carbon::parse($item->tgl_akhir)->format('d-m-Y') }}</td>
                            <td class="text-center">{{ $item->metode_pelatihan }}</td>
                            <td>{{ $item->lokasi_pelatihan }}</td>
                            <td class="text-center">{{ $item->jenis_pelatihan }}</td>
                            <td>{{ $item->penyelenggara }}</td>
                            <td class="text-end">Rp{{ number_format($item->biaya, 0, ',', '.') }}</td>
                           <td class="text-center">
                                <form action="{{ route('register.pelatihan', $item->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-primary" title="Daftar Pelatihan">
                                        <i class="fas fa-book"></i> Register
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center text-muted py-4">
                                Tidak ada pelatihan tersedia saat ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Paginate Navigation -->
            <div class="d-flex justify-content-center mt-3">
                {{ $pelatihan->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
