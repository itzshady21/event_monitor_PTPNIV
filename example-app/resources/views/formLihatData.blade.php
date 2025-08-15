@extends('template.header')

@section('content')

<div class="card mt-4">
    <div class="card-header bg-primary text-white">
        <div class="d-flex justify-content-between align-items-center flex-wrap">
            <h4 class="mb-0">Data Peserta</h4>
        </div>
    </div>

    <div class="card-body">

        {{-- Notifikasi Sukses --}}
        @if(session('success'))
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: '{{ session('success') }}',
                    confirmButtonColor: '#3085d6',
                });
            </script>
        @endif

        {{-- Form Pencarian --}}
        <div class="d-flex justify-content-end mb-3">
            <form action="{{ route('formLihatData') }}" method="GET" class="d-flex align-items-center">
                <input type="text" id="searchInput" name="search" class="form-control mr-2"
                    placeholder="Cari data..." value="{{ request('search') }}">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-search"></i>
                </button>
            </form>
        </div>

        {{-- Tabel Data Peserta --}}
        <div class="table-responsive">
            <table class="table table-bordered table-striped text-nowrap" style="font-size: 16px;">
                <thead class="bg-primary text-black">
                    <tr>
                        <th>No</th>
                        <th>NIK</th>
                        <th>Nama</th>
                        <th>Jabatan</th>
                        <th>Bagian</th>
                        <th>Unit Usaha</th>
                        <th>Tgl Awal Pelatihan</th>
                        <th>Tgl Akhir Pelatihan</th>
                        <th>Judul Pelatihan</th>
                        <th>Metode Pelatihan</th>
                        <th>Lokasi Pelatihan</th>
                        <th>Jenis Pelatihan</th>
                        <th>Penyelenggara</th>
                        <th>Biaya</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="dataTableBody">
                    @foreach($data_event as $event)
                        <tr>
                            <td>{{ $loop->iteration + ($data_event->currentPage() - 1) * $data_event->perPage() }}</td>
                            <td>{{ $event->nik }}</td>
                            <td>{{ $event->nama }}</td>
                            <td>{{ $event->jabatan }}</td>
                            <td>{{ $event->bagian }}</td>
                            <td>{{ $event->unit_usaha }}</td>
                            <td>{{ \Carbon\Carbon::parse($event->tgl_awal)->format('d/m/Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($event->tgl_akhir)->format('d/m/Y') }}</td>
                            <td>{{ $event->judul_pelatihan }}</td>
                            <td>{{ $event->metode_pelatihan }}</td>
                            <td>{{ $event->lokasi_pelatihan }}</td>
                            <td>{{ $event->jenis_pelatihan }}</td>
                            <td>{{ $event->penyelenggara }}</td>
                            <td>{{ $event->biaya }}</td>
                            <td class="text-center">
                                <div class="btn-group" role="group">
                                    {{-- Tombol Edit --}}
                                    <button type="button" class="btn btn-warning btn-sm me-1 btn-edit"
                                        data-id="{{ $event->id }}"
                                        data-judul="{{ $event->judul_pelatihan }}"
                                        data-penyelenggara="{{ $event->penyelenggara }}"
                                        data-tgl_awal="{{ $event->tgl_awal }}"
                                        data-tgl_akhir="{{ $event->tgl_akhir }}"
                                        data-jenis="{{ $event->jenis_pelatihan }}"
                                        data-lokasi="{{ $event->lokasi_pelatihan }}"
                                        data-metode="{{ $event->metode_pelatihan }}"
                                        data-biaya="{{ $event->biaya }}"
                                        title="Edit Data">
                                        <i class="fas fa-edit"></i> Edit
                                    </button>

                                    {{-- Tombol Hapus --}}
                                    <button type="button" class="btn btn-danger btn-sm"
                                        onclick="confirmDelete({{ $event->id }})"
                                        title="Hapus Data">
                                        <i class="fas fa-trash-alt"></i> Hapus
                                    </button>
                                </div>

                                {{-- Form Delete --}}
                                <form id="delete-form-{{ $event->id }}"
                                    action="{{ route('deleteEvent', $event->id) }}"
                                    method="POST" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{-- Modal Edit --}}
            <div class="modal fade" id="modalEditEvent" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <form id="formEditEvent">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="id" id="edit_id">

                            <div class="modal-header">
                                <h5 class="modal-title">Edit Data Event</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>

                            <div class="modal-body row">
                                <div class="mb-3 col-md-6">
                                    <label for="edit_judul" class="form-label">Judul Pelatihan</label>
                                    <input type="text" class="form-control" name="judul_pelatihan" id="edit_judul">
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="edit_tgl_awal" class="form-label">Tanggal Awal</label>
                                    <input type="date" class="form-control" name="tgl_awal" id="edit_tgl_awal">
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="edit_tgl_akhir" class="form-label">Tanggal Akhir</label>
                                    <input type="date" class="form-control" name="tgl_akhir" id="edit_tgl_akhir">
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="edit_jenis" class="form-label">Jenis Pelatihan</label>
                                    <select class="form-control" name="jenis_pelatihan" id="edit_jenis">
                                        <option value="Asesmen">Asesmen</option>
                                        <option value="Sertifikasi">Sertifikasi</option>
                                        <option value="Hardskill">Hardskill</option>
                                        <option value="Softskill">Softskill</option>
                                    </select>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="edit_lokasi" class="form-label">Lokasi Pelatihan</label>
                                    <input type="text" class="form-control" name="lokasi_pelatihan" id="edit_lokasi">
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="edit_metode" class="form-label">Metode Pelatihan</label>
                                    <select class="form-control" name="metode_pelatihan" id="edit_metode">
                                        <option value="Offline">Offline</option>
                                        <option value="Online">Online</option>
                                    </select>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="edit_penyelenggara" class="form-label">Penyelenggara</label>
                                    <input type="text" class="form-control" name="penyelenggara" id="edit_penyelenggara">
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="edit_biaya" class="form-label">Biaya</label>
                                    <input type="number" class="form-control" name="biaya" id="edit_biaya">
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Paginasi --}}
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <span>Menampilkan {{ $data_event->count() }} dari {{ $data_event->total() }} data</span>
                </div>
                <div>
                    {{ $data_event->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Script SweetAlert2 --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
function confirmDelete(eventId) {
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
            document.getElementById('delete-form-' + eventId).submit();
        }
    });
}

document.getElementById('searchInput').addEventListener('input', function() {
    const searchTerm = this.value.toLowerCase();
    const rows = document.querySelectorAll('#dataTableBody tr');

    rows.forEach(row => {
        const rowText = Array.from(row.querySelectorAll('td'))
            .map(col => col.textContent.toLowerCase())
            .join(' ');

        row.style.display = rowText.includes(searchTerm) ? '' : 'none';
    });
});

document.querySelectorAll('.btn-edit').forEach(button => {
    button.addEventListener('click', function (e) {
        e.preventDefault();

        document.getElementById('edit_id').value = this.dataset.id;
        document.getElementById('edit_judul').value = this.dataset.judul;
        document.getElementById('edit_penyelenggara').value = this.dataset.penyelenggara;
        document.getElementById('edit_tgl_awal').value = this.dataset.tgl_awal;
        document.getElementById('edit_tgl_akhir').value = this.dataset.tgl_akhir;
        document.getElementById('edit_jenis').value = this.dataset.jenis;
        document.getElementById('edit_lokasi').value = this.dataset.lokasi;
        document.getElementById('edit_metode').value = this.dataset.metode;
        document.getElementById('edit_biaya').value = this.dataset.biaya;

        new bootstrap.Modal(document.getElementById('modalEditEvent')).show();
    });
});

document.getElementById('formEditEvent').addEventListener('submit', function(e) {
    e.preventDefault();

    const id = document.getElementById('edit_id').value;
    const url = `/formEvent/update/${id}`;
    const formData = new FormData(this);

    fetch(url, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        Swal.fire(data.success ? 'Berhasil' : 'Gagal', data.message || '', data.success ? 'success' : 'error')
            .then(() => data.success && window.location.reload());
    })
    .catch(() => {
        Swal.fire('Error', 'Terjadi kesalahan server.', 'error');
    });
});
</script>

@endsection
