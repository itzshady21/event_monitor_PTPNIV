@extends('bagsdm.header')

@section('content')
<style>
    /* Biar sel tabel lebih lega dan rapi */
    .table th, .table td {
        vertical-align: middle !important;
        padding: 0.6rem 0.9rem !important;
        white-space: nowrap;
    }
    .table img {
        border-radius: 8px;
        object-fit: cover;
    }
    .table-responsive {
        overflow-x: auto;
    }
    /* Efek hover */
    .table-hover tbody tr:hover {
        background-color: #f1f7ff;
    }
</style>

<div class="card mt-4 shadow-sm">
    <div class="card-header bg-primary text-white">
        <h4 class="mb-0">Daftar Karyawan</h4>
    </div>

    <div class="card-body">
        {{-- Form Pencarian --}}
        <div class="d-flex justify-content-end mb-3">
            <form action="{{ route('formDataKaryawan') }}" method="GET" class="d-flex">
                <input type="text" id="searchBar" name="search" class="form-control me-2" placeholder="Cari data..." value="{{ request('search') }}">
                <button type="submit" class="btn btn-light" style="background-color: #007bff; color: white;">
                    <i class="fas fa-search"></i>
                </button>
            </form>
        </div>

        {{-- Tabel Data --}}
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover align-middle text-nowrap" id="karyawanTable" style="font-size: 15px;">
                <thead class="table-primary text-center">
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
                    @forelse($karyawans as $karyawan)
                        <tr>
                            <td class="text-center">{{ $loop->iteration + ($karyawans->currentPage() - 1) * $karyawans->perPage() }}</td>
                            <td class="text-center">
                                @if ($karyawan->foto)
                                    <img src="{{ asset('storage/foto/' . $karyawan->foto) }}" alt="Foto" width="80" height="90">
                                @else
                                    <span class="badge bg-secondary">Belum Ada Foto</span>
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
                    @empty
                        <tr>
                            <td colspan="16" class="text-center text-muted py-4">
                                Belum ada data karyawan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Paginasi --}}
        <div class="d-flex justify-content-between align-items-center mt-3">
            <div>
                <span>Menampilkan {{ $karyawans->count() }} dari {{ $karyawans->total() }} data</span>
            </div>
            <div>
                {{ $karyawans->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('searchBar').addEventListener('input', function() {
    const searchTerm = this.value.toLowerCase();
    const rows = document.querySelectorAll('#karyawanTable tbody tr');

    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(searchTerm) ? '' : 'none';
    });
});
</script>

@endsection
