@extends('template.header')

@section('content')


    @if(session('success'))
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: '{{ session('success') }}',
                    showConfirmButton: false,
                    timer: 2000
                });
            </script>
        @endif

                @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

<div class="card mt-4">
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
        <h4>Input Data Karyawan</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('storeKaryawan') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="nik">NIK</label>
                <input type="number" class="form-control" id="nik" name="nik" required>
            </div>

            <div class="form-group">
                <label for="nama">Nama</label>
                <input type="text" class="form-control" id="nama" name="nama" required>
            </div>

            <div class="form-group">
                <label for="jenis_kelamin">Jenis Kelamin</label>
                <select class="form-control" id="jenis_kelamin" name="jenis_kelamin" required>
                    <option value="" selected disabled hidden>-Pilih-</option>
                    <option value="Laki-Laki">Laki-Laki</option>
                    <option value="Perempuan">Perempuan</option>
                </select>
            </div>

            <div class="form-group">
                <label for="tempat">Tempat</label>
                <input type="text" class="form-control" id="tempat" name="tempat" required>
            </div>

            <div class="form-group">
                <label for="tanggal_lahir">Tanggal Lahir</label>
                <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" required>
            </div>
            
            <div class="form-group mb-3">
                <label for="agama">Agama</label>
                <select class="form-control" id="agama" name="agama" required>
                    <option value="" selected disabled hidden>-Pilih</option>
                    <option value="Islam">Islam</option>
                    <option value="Kristen">Kristen</option>
                    <option value="Katolik">Katolik</option>
                    <option value="Buddha">Buddha</option>
                    <option value="Khonghucu">Khonghucu</option>
                    <option value="Hindu">Hindu</option>
                </select>
            </div>

            <div class="form-group">
                <label for="pendidikan">Pendidikan</label>
                <input type="text" class="form-control" id="pendidikan" name="pendidikan" required>
            </div>

            <div class="form-group">
                <label for="alamat">Alamat</label>
                <input type="text" class="form-control" id="alamat" name="alamat" required>
            </div>

            <div class="form-group">
                <label for="jabatan">Jabatan</label>
                <input type="text" class="form-control" id="jabatan" name="jabatan" required>
            </div>

            <div class="form-group">
                <label for="bagian">Bagian</label>
                <select class="form-control" id="bagian" name="bagian" required>
                    <option value="" selected disabled hidden>-Pilih-</option>
                @foreach($bagians as $bagian)
                    <option value="{{ $bagian->nama_bagian }}">{{ $bagian->nama_bagian }}</option>
                @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="bod">BOD</label>
                <select class="form-control" id="bod" name="bod" required>
                    <option value="" selected disabled hidden>-Pilih-</option>
                    <option value="BRM">BRM</option>
                    <option value="BOD-1">BOD-1</option>
                    <option value="BOD-2">BOD-2</option>
                    <option value="BOD-3">BOD-3</option>
                    <option value="BOD-4">BOD-4</option>
                    <option value="BOD-5">BOD-5</option>
                    <option value="BOD-6">BOD-6</option>
                </select>
                </div>

                <div class="form-group">
                <label for="unit_usaha">Unit Usaha</label>
                <select class="form-control" id="unit_usaha" name="unit_usaha" required>
                    <option value="" selected disabled hidden>-Pilih-</option>
                    <option value="KANTOR REGIONAL IV">KANTOR REGIONAL IV</option>
                    <option value="KB BATANG HARI">KB BATANG HARI</option>
                    <option value="KB BUKIT CERMIN">KB BUKIT CERMIN</option>
                    <option value="KB BUNUT">KB BUNUT</option>
                    <option value="KB DANAU KEMBAR">KB DANAU KEMBAR</option>
                    <option value="KB DURIANLUNCUK">KB DURIANLUNCUK</option>
                    <option value="KB KAYU ARO">KB KAYU ARO</option>
                    <option value="KB OPHIR">KB OPHIR</option>
                    <option value="KB PANGK 50KOTA">KB PANGK 50KOTA</option>
                    <option value="KB RIM BUJANG 2">KB RIM BUJANG 2</option>
                    <option value="KB RIM BUJANG 1">KB RIM BUJANG 1</option>
                    <option value="KB SOLOK SEL">KB SOLOK SEL</option>
                    <option value="KB TJ LEBAR">KB TJ LEBAR</option>
                    <option value="KB BUKIT KAUSAR">KB BUKIT KAUSAR</option>
                    <option value="KB LAGAN">KB LAGAN</option>
                    <option value="PB AURGADING">PB AURGADING</option>
                    <option value="PB PINANGTINGGI">PB PINANGTINGGI</option>
                    <option value="PB BUNUT">PB BUNUT</option>
                    <option value="PB TJ LEBAR">PB TJ LEBAR</option>
                    <option value="PB RIM BUJANG 2">PB RIM BUJANG 2</option>
                    <option value="PB SOLOK SEL">PB SOLOK SEL</option>
                    <option value="PB OPHIR">PB OPHIR</option>
                    <option value="PB KAYU ARO">PB KAYU ARO</option>
                    <option value="PB DANAU KEMBAR">PB DANAU KEMBAR</option>
                    <option value="PB PENGABUAN">PB PENGABUAN</option>
                    <option value="KANTOR PUSAT">KANTOR PUSAT</option>
                    <option value="IT3B">IT3B</option>
                    <option value="ADDITIONAL">ADDITIONAL</option>
                    <option value="KB ALAM LESTARI NUSANTARA">KB ALAM LESTARI NUSANTARA</option>
                </select>
            </div>

            <div class="form-group">
                <label for="status_perkawinan">Status Perkawinan</label>
                <select class="form-control" id="status_perkawinan" name="status_perkawinan" required>
                    <option value="" selected disabled hidden>-Pilih-</option>    
                    <option value="Belum Menikah">Belum Menikah</option>
                    <option value="Menikah">Menikah</option>
                    <option value="Janda/Duda">Janda/Duda</option>
                </select>
            </div>

            <div class="form-group">
                <label for="no_telp">No Telepon</label>
                <input type="number" class="form-control" id="no_telp" name="no_telp" required>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control" placeholder="Password Karyawan" required >
            </div>

            <div class="form-group mb-3">
                <label for="foto">Foto (Maks: 5MB)</label>
                <input type="file" name="foto" class="form-control" accept="image/*">
                        @if(isset($karyawan) && $karyawan->foto)
                <div class="mt-2">
                    <img src="{{ asset('storage/foto/' . $karyawan->foto) }}" width="100" alt="Foto Karyawan">
                </div>
                        @endif
            </div>

            <button type="submit" class="btn btn-primary mt-3">Simpan</button>
        </form>
    </div>
</div>

@endsection
