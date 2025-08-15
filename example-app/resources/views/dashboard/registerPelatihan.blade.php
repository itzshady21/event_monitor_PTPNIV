@extends('dashboard.header')

@section('content')
<div class="card mt-4">
    <div class="card-header bg-success text-white">
        <h4>Daftar Pelatihan Tersedia</h4>
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
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
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
                    @foreach($pelatihan as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item->judul_pelatihan }}</td>
                        <td>{{ $item->tgl_awal }}</td>
                        <td>{{ $item->tgl_akhir }}</td>
                        <td>{{ $item->metode_pelatihan }}</td>
                        <td>{{ $item->lokasi_pelatihan }}</td>
                        <td>{{ $item->jenis_pelatihan }}</td>
                        <td>{{ $item->penyelenggara }}</td>
                        <td>Rp{{ number_format($item->biaya, 0, ',', '.') }}</td>
                        <td>
                            <form action="{{ route('register.pelatihan', $item->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-primary">Register</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
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
