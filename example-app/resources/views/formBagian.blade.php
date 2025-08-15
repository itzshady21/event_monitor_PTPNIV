@extends('template.header')

@section('content')
@if (session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Sukses',
        text: '{{ session('success') }}',
        timer: 2000,
        showConfirmButton: false
    });
</script>
@endif

<div class="card mt-4">
    <div class="card-header bg-primary text-white">
        <h4>Form Tambah Bagian</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('bagian.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="nama_bagian">Nama Bagian</label>
                <input type="text" name="nama_bagian" class="form-control" required>
            </div>
           <div class="form-group">
    <label for="kepala_bagian">Kepala Bagian</label>
    <input type="text" name="kepala_bagian" class="form-control kepala-input" list="listKaryawan" required>
</div>

        <div class="form-group">
            <label for="wakep_bagian">Wakil Kepala Bagian</label>
            <input type="text" name="wakep_bagian" class="form-control wakil-input" list="listKaryawan" required>
        </div>

        <datalist id="listKaryawan">
            @foreach($karyawans as $karyawan)
                <option value="{{ $karyawan->nik }} - {{ $karyawan->nama }}">
            @endforeach
        </datalist>

            <div class="form-group">
                <label for="Tgl_bagian">Tanggal Dibentuk</label>
                <input type="date" name="Tgl_bagian" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Simpan</button>
        </form>
    </div>
</div>

<!-- TABEL LIST BAGIAN -->
<div class="card mt-4">
    <div class="card-header bg-success text-white">
        <h4>Daftar Bagian</h4>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Bagian</th>
                    <th>Kepala</th>
                    <th>Wakil Kepala</th>
                    <th>Tanggal Dibentuk</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($bagians as $index => $bagian)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $bagian->nama_bagian }}</td>
                    <td>{{ $bagian->kepala_bagian }}</td>
                    <td>{{ $bagian->wakep_bagian }}</td>
                    <td>{{ \Carbon\Carbon::parse ($bagian->Tgl_bagian)->format('d/m/Y') }}</td>
                    <td>
                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal{{ $bagian->id }}">Edit</button>
                        <form action="{{ route('bagian.destroy', $bagian->id) }}" method="POST" style="display:inline;" class="delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-danger btn-sm btn-delete">Hapus</button>
                        </form>
                    </td>
                </tr>

                <!-- MODAL EDIT -->
                <div class="modal fade" id="editModal{{ $bagian->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $bagian->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form action="{{ route('bagian.update', $bagian->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-header bg-warning">
                                    <h5 class="modal-title" id="editModalLabel{{ $bagian->id }}">Edit Bagian</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label>Nama Bagian</label>
                                        <input type="text" name="nama_bagian" class="form-control" value="{{ $bagian->nama_bagian }}" required>
                                    </div>
                                   <div class="form-group">
                                        <label>Kepala Bagian</label>
                                        <input type="text" name="kepala_bagian" class="form-control kepala-input" value="{{ $bagian->kepala_bagian }}" list="listKaryawan" required>
                                    </div>

                                    <div class="form-group">
                                        <label>Wakil Kepala Bagian</label>
                                        <input type="text" name="wakep_bagian" class="form-control wakil-input" value="{{ $bagian->wakep_bagian }}" list="listKaryawan" required>
                                    </div>

                                    <div class="form-group">
                                        <label>Tanggal Dibentuk</label>
                                        <input type="date" name="Tgl_bagian" class="form-control" value="{{ $bagian->Tgl_bagian }}" required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- END MODAL -->
                @endforeach

                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        const deleteButtons = document.querySelectorAll('.btn-delete');

                        deleteButtons.forEach(button => {
                            button.addEventListener('click', function (e) {
                                const form = this.closest('.delete-form');

                                Swal.fire({
                                    title: 'Yakin ingin hapus?',
                                    text: "Data yang dihapus tidak bisa dikembalikan!",
                                    icon: 'warning',
                                    showCancelButton: true,
                                    confirmButtonColor: '#d33',
                                    cancelButtonColor: '#6c757d',
                                    confirmButtonText: 'Ya, hapus',
                                    cancelButtonText: 'Batal'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        form.submit();
                                    }
                                });
                            });
                        });
                    });
                </script>

                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        function formatNama(inputElement) {
                            inputElement.addEventListener('change', function () {
                                let val = this.value;
                                if (val.includes(" - ")) {
                                    this.value = val.split(" - ")[1]; // hanya ambil nama
                                }
                            });
                        }

                        document.querySelectorAll('.kepala-input').forEach(formatNama);
                        document.querySelectorAll('.wakil-input').forEach(formatNama);
                    });
                    </script>


            </tbody>
        </table>
    </div>
</div>

@endsection
