@extends('dashboard.header')

@section('content')
    <div class="container mt-4">
        

        <div class="card mt-3">
            <div class="card-header bg-primary text-white">
                <h4>Data Profil</h4>
            </div>
            <div class="card-body">

                {{-- FOTO PROFIL --}}
                <div class="d-flex align-items-center mb-4">
                    <div>
                        @if ($karyawan->foto)
                            <img src="{{ asset('storage/foto/' . $karyawan->foto) }}" 
                                 alt="Foto Profil" 
                                 width="150" height="150"
                                 style="object-fit: cover; border-radius: 10px; border: 2px solid #ddd;">
                        @else
                            <div style="width: 150px; height: 150px; background-color: #f0f0f0; display: flex; align-items: center; justify-content: center; border-radius: 10px; border: 2px solid #ddd;">
                                <span class="text-muted">Tidak ada foto</span>
                            </div>
                        @endif
                    </div>
                    <div class="ms-4">
                        <h5 class="mb-0">{{ $karyawan->nama }}</h5>
                        <p class="text-muted mb-0">{{ $karyawan->jabatan }} - {{ $karyawan->bagian }}</p>
                        <p class="text-muted">{{ $karyawan->unit_usaha }}</p>
                    </div>
                </div>

                {{-- DATA TABEL --}}
                <table class="table table-bordered">
                    <tr>
                        <th>NIK</th>
                        <td>{{ $karyawan->nik }}</td>
                    </tr>
                    <tr>
                        <th>Nama</th>
                        <td>{{ $karyawan->nama }}</td>
                    </tr>
                    <tr>
                        <th>Jenis Kelamin</th>
                        <td>{{ $karyawan->jenis_kelamin }}</td>
                    </tr>
                    <tr>
                        <th>Tempat, Tanggal Lahir</th>
                        <td>{{ $karyawan->tempat }}, {{ \Carbon\Carbon::parse($karyawan->tanggal_lahir)->format('d/m/Y') }}</td>
                    </tr>
                     <tr>
                        <th>Agama</th>
                        <td>{{ $karyawan->agama }}</td>
                    </tr>
                    <tr>
                        <th>Pendidikan</th>
                        <td>{{ $karyawan->pendidikan }}</td>
                    </tr>
                    <tr>
                        <th>Alamat</th>
                        <td>{{ $karyawan->alamat }}</td>
                    </tr>
                    <tr>
                        <th>Jabatan</th>
                        <td>{{ $karyawan->jabatan }}</td>
                    </tr>
                    <tr>
                        <th>Bagian</th>
                        <td>{{ $karyawan->bagian }}</td>
                    </tr>
                    <tr>
                        <th>BOD</th>
                        <td>{{ $karyawan->bod }}</td>
                    </tr>
                    <tr>
                        <th>Unit Usaha</th>
                        <td>{{ $karyawan->unit_usaha }}</td>
                    </tr>
                    <tr>
                        <th>Status Perkawinan</th>
                        <td>{{ $karyawan->status_perkawinan }}</td>
                    </tr>
                    <tr>
                        <th>No Telepon</th>
                        <td>{{ $karyawan->no_telp }}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{ $karyawan->email }}</td>
                    </tr>
                    <tr>
                        <th>Password</th>
                        <td>{{ $karyawan->password }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
@endsection
