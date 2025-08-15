@extends('template.header')

@section('content')

{{-- ================= CARD FORM INPUT ================= --}}
<div class="card mt-4">
    <div class="card-header bg-primary text-white">
        <h4>Form Pelatihan</h4>
    </div>
    <div class="card-body">
        @if(session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: '{{ session('success') }}',
                timer: 2000,
                showConfirmButton: false
            });
        </script>
        @endif

        <form action="{{ route('formPelatihan.store') }}" method="POST" id="formPelatihan">
            @csrf
            <div class="form-group">
                <label for="judul_pelatihan">Judul Pelatihan</label>
                <input type="text" class="form-control" id="judul_pelatihan" name="judul_pelatihan" required>
            </div>

            <div class="form-group">
                <label for="tgl_awal">Tanggal Awal Pelatihan</label>
                <input type="date" class="form-control" id="tgl_awal" name="tgl_awal" required>
            </div>

            <div class="form-group">
                <label for="tgl_akhir">Tanggal Akhir Pelatihan</label>
                <input type="date" class="form-control" id="tgl_akhir" name="tgl_akhir" required>
            </div>

            <div class="form-group">
                <label for="metode_pelatihan">Metode Pelatihan</label>
                <select class="form-control" id="metode_pelatihan" name="metode_pelatihan" required>
                    <option value="" selected disabled hidden>-Pilih-</option>
                    <option value="Online">Online</option>
                    <option value="Offline">Offline</option>
                </select>
            </div>

            <div class="form-group" id="lokasiGroup">
                <label for="lokasi_pelatihan">Lokasi Pelatihan</label>
                <input type="text" class="form-control" id="lokasi_pelatihan" name="lokasi_pelatihan" placeholder="Contoh: Jakarta">
            </div>

            <div class="form-group">
                <label for="jenis_pelatihan">Jenis Pelatihan</label>
                <select class="form-control" id="jenis_pelatihan" name="jenis_pelatihan" required>
                    <option value="" selected disabled hidden>-Pilih-</option>
                    <option value="Asesmen">Asesmen</option>
                    <option value="Sertifikasi">Sertifikasi</option>
                    <option value="Softskill">Softskill</option>
                    <option value="Hardskill">Hardskill</option>
                </select>
            </div>

            <div class="form-group">
                <label for="penyelenggara">Penyelenggara</label>
                <input type="text" class="form-control" id="penyelenggara" name="penyelenggara" required>
            </div>

            <div class="form-group">
                <label for="biaya">Biaya</label>
                <input type="number" class="form-control" id="biaya" name="biaya" min="0" required>
            </div>

            <button type="submit" class="btn btn-primary mt-3">Simpan</button>
        </form>
    </div>
</div>

{{-- ================= CARD DATA TABEL ================= --}}
<div class="card mt-4">
    <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
        <h4>Data Pelatihan</h4>
    </div>

    <div class="card-body">
        <div class="d-flex justify-content-end mb-3">
             <form action="{{ route('formPelatihan') }}" method="GET" class="d-flex align-items-center">
            <input type="text" name="search" value="{{ request('search') }}" class="form-control mr-2" placeholder="Cari data...">
            <button type="submit" class="btn btn-light" style="background-color: #007bff; color: white;">
                <i class="fas fa-search"></i>
            </button>
        </form>
        </div>
            <div class="table-responsive" id="tableData">
            <table class="table table-bordered table-hover mt-3">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Judul</th>
                        <th>Periode Pelatihan</th>
                        <th>Metode</th>
                        <th>Lokasi</th>
                        <th>Jenis</th>
                        <th>Penyelenggara</th>
                        <th>Biaya</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pelatihan as $item)
                    <tr>
                        <td>{{ $loop->iteration + ($pelatihan->currentPage() - 1) * $pelatihan->perPage() }}</td>
                        <td>{{ $item->judul_pelatihan }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->tgl_awal)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($item->tgl_akhir)->format('d/m/Y') }}</td>
                        <td>{{ $item->metode_pelatihan }}</td>
                        <td>{{ $item->lokasi_pelatihan }}</td>
                        <td>{{ $item->jenis_pelatihan }}</td>
                        <td>{{ $item->penyelenggara }}</td>
                        <td>Rp{{ number_format($item->biaya, 0, ',', '.') }}</td>
                        <td>
                            <button class="btn btn-sm btn-warning" onclick="editData({{ json_encode($item) }})">Edit</button>
                            <form method="POST" action="{{ route('formPelatihan.destroy', $item->id) }}" class="form-delete d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-sm btn-danger btn-delete">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center">Data tidak tersedia</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

    {{-- PAGINATION --}}
    <div class="d-flex justify-content-center">
        {{ $pelatihan->links() }}
    </div>
</div>


{{-- ================= MODAL EDIT ================= --}}
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form id="editForm" method="POST">
      @csrf 
      @method('POST')
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit Pelatihan</h5>
          <button type="button" class="close" onclick="$('#editModal').modal('hide')" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="modal-body">
            <div class="form-group"><label>Judul</label><input type="text" name="judul_pelatihan" id="edit_judul" class="form-control" required></div>
            <div class="form-group"><label>Tanggal Awal</label><input type="date" name="tgl_awal" id="edit_tgl_awal" class="form-control" required></div>
            <div class="form-group"><label>Tanggal Akhir</label><input type="date" name="tgl_akhir" id="edit_tgl_akhir" class="form-control" required></div>
            <div class="form-group">
                <label>Metode</label>
                <select name="metode_pelatihan" id="edit_metode" class="form-control" required>
                    <option value="Online">Online</option>
                    <option value="Offline">Offline</option>
                </select>
            </div>
            <div class="form-group" id="edit_lokasiGroup">
                <label>Lokasi</label>
                <input type="text" name="lokasi_pelatihan" id="edit_lokasi" class="form-control">
            </div>
            <div class="form-group"><label>Jenis</label>
                <select name="jenis_pelatihan" id="edit_jenis" class="form-control" required>
                    <option value="Asesmen">Asesmen</option>
                    <option value="Sertifikasi">Sertifikasi</option>
                    <option value="Softskill">Softskill</option>
                    <option value="Hardskill">Hardskill</option>
                </select>
            </div>
            <div class="form-group"><label>Penyelenggara</label><input type="text" name="penyelenggara" id="edit_penyelenggara" class="form-control" required></div>
            <div class="form-group"><label>Biaya</label><input type="number" name="biaya" id="edit_biaya" class="form-control" min="0" required></div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Simpan</button>
          <button type="button" class="btn btn-secondary" onclick="$('#editModal').modal('hide')">Batal</button>
        </div>
      </div>
    </form>
  </div>
</div>

{{-- ================= SCRIPT ================= --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function(){
    $('#searchBar').on('keyup', function(){
        let query = $(this).val();
        $.ajax({
            url: "{{ route('formPelatihan') }}",
            type: "GET",
            data: { search: query },
            success: function(data){
                let newTable = $(data).find('#tableData').html();
                $('#tableData').html(newTable);
            }
        });
    });
});
</script>

<script>
    function toggleLokasi(metode, lokasiGroupId, lokasiInputId) {
        const lokasiGroup = document.getElementById(lokasiGroupId);
        const lokasiInput = document.getElementById(lokasiInputId);

        if (metode === 'Online') {
            lokasiGroup.style.display = 'none';
            lokasiInput.value = '-';
        } else {
            lokasiGroup.style.display = 'block';
            if (lokasiInput.value === '-' || lokasiInput.value === '') {
                lokasiInput.value = '';
            }
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        const metodeSelect = document.getElementById('metode_pelatihan');
        toggleLokasi(metodeSelect.value, 'lokasiGroup', 'lokasi_pelatihan');
        metodeSelect.addEventListener('change', function () {
            toggleLokasi(this.value, 'lokasiGroup', 'lokasi_pelatihan');
        });

        const editMetodeSelect = document.getElementById('edit_metode');
        editMetodeSelect.addEventListener('change', function () {
            toggleLokasi(this.value, 'edit_lokasiGroup', 'edit_lokasi');
        });
    });

    function editData(data) {
        const form = document.getElementById('editForm');
        form.action = `/formPelatihan/update/${data.id}`;
        
        const methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = 'POST';
        form.appendChild(methodInput);

        document.getElementById('edit_judul').value = data.judul_pelatihan;
        document.getElementById('edit_tgl_awal').value = data.tgl_awal;
        document.getElementById('edit_tgl_akhir').value = data.tgl_akhir;
        document.getElementById('edit_metode').value = data.metode_pelatihan;
        document.getElementById('edit_lokasi').value = data.lokasi_pelatihan;
        document.getElementById('edit_jenis').value = data.jenis_pelatihan;
        document.getElementById('edit_penyelenggara').value = data.penyelenggara;
        document.getElementById('edit_biaya').value = data.biaya;

        toggleLokasi(data.metode_pelatihan, 'edit_lokasiGroup', 'edit_lokasi');
        $('#editModal').modal('show');
    }

    document.addEventListener('DOMContentLoaded', function () {
        const deleteButtons = document.querySelectorAll('.btn-delete');
        deleteButtons.forEach(button => {
            button.addEventListener('click', function () {
                const form = this.closest('form');
                Swal.fire({
                    title: 'Yakin ingin menghapus?',
                    text: "Data yang dihapus tidak dapat dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Iya, Hapus!',
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

@endsection
