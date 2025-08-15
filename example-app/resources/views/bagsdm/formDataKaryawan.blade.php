@extends('bagsdm.header')
@section('content')

<div class="card mt-4">
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
    <div class="d-flex justify-content-between align-items-center flex-wrap">
    <h4>Daftar Karyawan</h4>
    </div>   
    </div>

    <div class="card-body">
    <div class="d-flex justify-content-end mb-3">
    <form action="{{ route('formDataKaryawan') }}" method="GET" class="d-flex">
            <input type="text" id="searchBar" name="search" class="form-control mr-2" placeholder="Cari data..." value="{{ request('search') }}">
            <button type="submit" class="btn btn-light" style="background-color: #007bff; color: white;">
                <i class="fas fa-search"></i>
            </button>
        </form>
        </div>

    <div class="table-responsive">
        <table class="table table-striped table-bordered align-middle text-nowrap" id="karyawanTable" style="font-size: 16px;">
            <thead class="table-light text-center">
                <tr>
                    <th>No</th>
                    <th>Foto</th>
                    <th>NIK</th>
                    <th>Nama</th>
                    <th>Jenis Kelamin</th>
                    <th>Tempat, Tanggal Lahir</th>
                    <th>Agama</th>
                    <th>Pendidikan</th>
                    <th>Alamat</th>
                    <th>Jabatan</th>
                    <th>Bagian</th>
                    <th>BOD</th>
                    <th>Unit Usaha</th>
                    <th>Status Perkawinan</th>
                    <th>No Telp</th>
                    <th>Email</th>
                </tr>
            </thead>
            <tbody>
            @foreach($karyawans as $karyawan)
                <tr>
                    <td class="text-center">{{ $loop->iteration + ($karyawans->currentPage() - 1) * $karyawans->perPage() }}</td>
                    <td class="text-center">
                        @if ($karyawan->foto)
                            <img src="{{ asset('storage/foto/' . $karyawan->foto) }}" alt="Foto" width="90" height="100" style="object-fit: cover; border-radius: 5px;">
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </td>
                    <td>{{ $karyawan->nik }}</td>
                    <td>{{ $karyawan->nama }}</td>
                    <td>{{ $karyawan->jenis_kelamin }}</td>
                    <td>{{ $karyawan->tempat }}, {{ \Carbon\Carbon::parse($karyawan->tanggal_lahir)->format('d/m/Y') }}</td>
                    <td>{{ $karyawan->agama }}</td>
                    <td>{{ $karyawan->pendidikan }}</td>
                    <td>{{ $karyawan->alamat }}</td>
                    <td>{{ $karyawan->jabatan }}</td>
                    <td>{{ $karyawan->bagian }}</td>
                    <td>{{ $karyawan->bod }}</td>
                    <td>{{ $karyawan->unit_usaha }}</td>
                    <td>{{ $karyawan->status_perkawinan }}</td>
                    <td>{{ $karyawan->no_telp }}</td>
                    <td>{{ $karyawan->email }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <!-- Paginasi -->
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <span>Menampilkan {{ $karyawans->count() }} dari {{ $karyawans->total() }} data</span>
        </div>
        <div>
            {{ $karyawans->links('pagination::bootstrap-4') }}
        </div>
    </div>
</div>

<script>
document.getElementById('searchBar').addEventListener('input', function() {
    const searchTerm = this.value.toLowerCase();
    const rows = document.querySelectorAll('#karyawanTable tbody tr');

    rows.forEach(row => {
        const nik = row.querySelector('td:nth-child(3)').textContent.toLowerCase();
        const nama = row.querySelector('td:nth-child(4)').textContent.toLowerCase();
        const isVisible = nik.includes(searchTerm) || nama.includes(searchTerm);
        row.style.display = isVisible ? '' : 'none';
    });
});
</script>

@endsection
