@extends('template.header')
@section('content')

<div class="card mt-4">
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
        <div class="d-flex justify-content-between align-items-center flex-wrap">
        <h4>Daftar Karyawan</h4>
    </div>
    </div>

    <div class="card-body">
    <div class="d-flex justify-content-end mb-3">
    <form action="{{ route('listKaryawan') }}" method="GET" class="d-flex align-items-center">
            <input type="text" id="searchBar" name="search" class="form-control mr-2" placeholder="Cari data..." value="{{ request('search') }}">
            <button type="submit" class="btn btn-light" style="background-color: #007bff; color: white;">
                <i class="fas fa-search"></i>
            </button>
        </form>
        </div>

    <div class="table-responsive">
    <table class="table table-striped table-bordered align-middle text-nowrap" id="karyawanTable" style="font-size: 16px;">
        <thead class="bg-primary text-black">
            <tr>
                <th style="white-space: nowrap;">No</th>
                <th style="white-space: nowrap;">Foto</th>
                <th style="white-space: nowrap;">NIK</th>
                <th style="white-space: nowrap;">Nama</th>
                <th style="white-space: nowrap;">Jenis Kelamin</th>
                <th style="white-space: nowrap;">Tempat, Tanggal Lahir</th>
                <th style="white-space: nowrap;">Agama</th>
                <th style="white-space: nowrap;">Pendidikan</th>
                <th style="white-space: nowrap;">Alamat</th>
                <th style="white-space: nowrap;">Jabatan</th>
                <th style="white-space: nowrap;">Bagian</th>
                <th style="white-space: nowrap;">BOD</th>
                <th style="white-space: nowrap;">Unit Usaha</th>
                <th style="white-space: nowrap;">Status Perkawinan</th>
                <th style="white-space: nowrap;">No Telp</th>
                <th style="white-space: nowrap;">Email</th>
                <th style="white-space: nowrap;">Password</th>
                <th style="white-space: nowrap;">Aksi</th>
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
                <td>{{ $karyawan->password }}</td>
                <td class="text-center">
                   <!-- Tombol Edit -->
                <button type="button" class="btn btn-warning btn-sm me-1" 
                    data-bs-toggle="modal" 
                    data-bs-target="#editModal" 
                    data-id="{{ $karyawan->id }}"
                    title="Edit Data">
                    <i class="fas fa-edit"></i> Edit
                </button>

                <!-- Tombol Hapus -->
                <button type="button" class="btn btn-danger btn-sm" 
                    onclick="confirmDelete({{ $karyawan->id }})"
                    title="Hapus Data">
                    <i class="fas fa-trash-alt"></i> Hapus
                </button>
                </td>
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
</div>

<!-- Modal Edit -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="editForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Karyawan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="nik">NIK</label>
                            <input type="number" class="form-control" id="nik" name="nik" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="nama">Nama</label>
                            <input type="text" class="form-control" id="nama" name="nama" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="jenis_kelamin">Jenis Kelamin</label>
                            <select class="form-control" id="jenis_kelamin" name="jenis_kelamin" required>
                                <option value="" selected disabled hidden>-Pilih-</option>
                                <option value="Laki-Laki">Laki-Laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label for="tempat">Tempat Lahir</label>
                            <input type="text" class="form-control" id="tempat" name="tempat" required>
                        </div>

                        <div class="form-group mb-3">
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

                        <div class="form-group mb-3">
                            <label for="pendidikan">Pendidikan</label>
                            <input type="text" class="form-control" id="pendidikan" name="pendidikan" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="alamat">Alamat</label>
                            <textarea class="form-control" id="alamat" name="alamat" required></textarea>
                        </div>

                        <div class="form-group mb-3">
                            <label for="foto">Foto (Max: 5MB)</label>
                            <input type="file" class="form-control" id="foto" name="foto" accept="image/*">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <!-- Kolom kanan -->
                        <div class="form-group mb-3">
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

                        <div class="form-group mb-3">
                            <label for="bod">BOD</label>
                            <select class="form-control" id="bod" name="bod"  required>
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

                        <div class="form-group mb-3">
                            <label for="status_perkawinan">Status Perkawinan</label>
                            <select class="form-control" id="status_perkawinan" name="status_perkawinan" required>
                                <option value="" selected disabled hidden>-Pilih-</option>
                                <option value="Belum Menikah">Belum Menikah</option>
                                <option value="Menikah">Menikah</option>
                                <option value="Janda/Duda">Janda/Duda</option>
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label for="no_telp">No Telepon</label>
                            <input type="number" class="form-control" id="no_telp" name="no_telp" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function confirmDelete(karyawanId) {
    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: "Data ini akan dihapus secara permanen!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, hapus data!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-form-' + karyawanId).submit();
        }
    });
}

document.getElementById('searchBar').addEventListener('input', function() {
    const searchTerm = this.value.toLowerCase();
    const rows = document.querySelectorAll('#karyawanTable tbody tr');

    let visibleCount = 0;

    rows.forEach(row => {
        const nik = row.querySelector('td:nth-child(3)').textContent.toLowerCase();
        const nama = row.querySelector('td:nth-child(4)').textContent.toLowerCase();
        const isVisible = nik.includes(searchTerm) || nama.includes(searchTerm);
        row.style.display = isVisible ? '' : 'none';
        if (isVisible) visibleCount++;
    });

    // Cek apakah sudah ada row "Data tidak tersedia"
    let noDataRow = document.querySelector('#karyawanTable tbody tr.no-data');

    if (visibleCount === 0) {
        if (!noDataRow) {
            let newRow = document.createElement('tr');
            newRow.classList.add('no-data');
            newRow.innerHTML = `<td colspan="17" class="text-center text-muted">Data tidak tersedia</td>`;
            document.querySelector('#karyawanTable tbody').appendChild(newRow);
        }
    } else {
        if (noDataRow) noDataRow.remove();
    }
});


document.addEventListener('DOMContentLoaded', function () {
    var editModal = document.getElementById('editModal');
    editModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var id = button.getAttribute('data-id');
        var form = document.getElementById('editForm');
        form.action = `/karyawan/${id}`;

        fetch(`/karyawan/${id}/edit`)
            .then(response => response.json())
            .then(data => {
                form.querySelector('#nik').value = data.nik;
                form.querySelector('#nama').value = data.nama;
                form.querySelector('#jenis_kelamin').value = data.jenis_kelamin;
                form.querySelector('#tempat').value = data.tempat;
                form.querySelector('#tanggal_lahir').value = data.tanggal_lahir;
                form.querySelector('#agama').value = data.agama;
                form.querySelector('#pendidikan').value = data.pendidikan;
                form.querySelector('#alamat').value = data.alamat;
                form.querySelector('#jabatan').value = data.jabatan;
                form.querySelector('#bagian').value = data.bagian;
                form.querySelector('#bod').value = data.bod;
                form.querySelector('#unit_usaha').value = data.unit_usaha;
                form.querySelector('#status_perkawinan').value = data.status_perkawinan;
                form.querySelector('#no_telp').value = data.no_telp;
                form.querySelector('#email').value = data.email;
                form.querySelector('#password').value = data.password || '';
            });
    });
});
</script>

@if (session('success'))
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

@if (session('warning'))
    <script>
        Swal.fire({
            icon: 'warning',
            title: 'Peringatan',
            text: '{{ session('warning') }}',
            showConfirmButton: false,
            timer: 2000
        });
    </script>
@endif

@endsection
