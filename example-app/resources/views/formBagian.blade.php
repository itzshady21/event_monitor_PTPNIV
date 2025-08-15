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
            <button type="submit" class="btn btn-primary mt-3" title="Simpan Data">
                <i class="fas fa-save"></i> Simpan
            </button>
        </form>
    </div>
</div>

<!-- TABEL LIST BAGIAN -->
<div class="card mt-4 shadow-sm border-0">
    <div class="card-header bg-success text-white rounded-top">
        <h4 class="mb-0">Daftar Bagian</h4>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead style="background-color: #007bff; color: white;">
                    <tr class="text-center text-black">
                        <th style="width: 50px;">No</th>
                        <th>Nama Bagian</th>
                        <th>Kepala</th>
                        <th>Wakil Kepala</th>
                        <th>Tanggal Dibentuk</th>
                        <th style="width: 150px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bagians as $index => $bagian)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>{{ $bagian->nama_bagian }}</td>
                            <td>{{ $bagian->kepala_bagian }}</td>
                            <td>{{ $bagian->wakep_bagian }}</td>
                            <td class="text-center">{{ \Carbon\Carbon::parse($bagian->Tgl_bagian)->format('d/m/Y') }}</td>
                            <td class="text-center">
                                <button class="btn btn-warning btn-sm mb-1" data-bs-toggle="modal" data-bs-target="#editModal{{ $bagian->id }}">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <form action="{{ route('bagian.destroy', $bagian->id) }}" method="POST" class="delete-form d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-danger btn-sm btn-delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
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
                                            <div class="form-group mb-3">
                                                <label>Nama Bagian</label>
                                                <input type="text" name="nama_bagian" class="form-control" value="{{ $bagian->nama_bagian }}" required>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label>Kepala Bagian</label>
                                                <input type="text" name="kepala_bagian" class="form-control kepala-input" value="{{ $bagian->kepala_bagian }}" list="listKaryawan" required>
                                            </div>
                                            <div class="form-group mb-3">
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
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">Tidak ada data bagian</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>


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
