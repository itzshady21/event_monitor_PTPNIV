@extends('template.header')
@section('content')


<div class="card mt-4">
  <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
    <h4>Input Peseta Pelatihan</h4>
  </div>
  <div class="card-body">
    <form method="POST" action="{{ route('formEvent.store') }}">
      @csrf

      <!-- Input Peserta dengan datalist -->
      <div class="form-group">
        <label for="peserta_datalist">Cari Peserta (NIK/Nama)</label>
        <input class="form-control" list="listKaryawan" id="peserta_datalist" placeholder="Ketik NIK atau Nama">
        <datalist id="listKaryawan">
          @foreach($karyawans as $karyawan)
            <option value="{{ $karyawan->nik }} - {{ $karyawan->nama }}"
              data-nik="{{ $karyawan->nik }}"
              data-nama="{{ $karyawan->nama }}"
              data-jabatan="{{ $karyawan->jabatan }}"
              data-bagian="{{ $karyawan->bagian }}"
              data-unit_usaha="{{ $karyawan->unit_usaha }}">
            @endforeach
        </datalist>
        <small id="peserta-count" class="form-text text-muted">Maksimal 20 peserta dapat dipilih.</small>
      </div>

      <!-- Tabel peserta terpilih -->
      <div class="form-group mt-3">
        <table id="selected-employees-table" class="table table-bordered">
          <thead>
            <tr><th>No</th><th>NIK</th><th>Nama</th><th>Jabatan</th><th>Bagian</th><th>Unit Usaha</th><th>Aksi</th></tr>
          </thead>
          <tbody></tbody>
        </table>
      </div>

      <!-- Hidden peserta -->
      <div id="hidden-checkboxes"></div>

      <!-- Data pelatihan -->
      <div class="form-group">
        <label>Judul Pelatihan</label>
        <select id="judul_pelatihan" name="judul_pelatihan" class="form-control" required>
          <option value="" selected disabled hidden>-Pilih Pelatihan-</option>
          @foreach($pelatihans as $pelatihan)
          <option value="{{ $pelatihan->judul_pelatihan }}" data-id="{{ $pelatihan->id }}">
            {{ $pelatihan->judul_pelatihan }}
          </option>
          @endforeach
        </select>
      </div>

      <div class="form-group">
        <label>Tanggal Awal</label>
        <input type="date" id="tgl_awal" name="tgl_awal" class="form-control" readonly style="background:#e9ecef;" required>
      </div>

      <div class="form-group">
        <label>Tanggal Akhir</label>
        <input type="date" id="tgl_akhir" name="tgl_akhir" class="form-control" readonly style="background:#e9ecef;" required>
      </div>

      <input type="hidden" id="metode_pelatihan_hidden" name="metode_pelatihan">
      <div class="form-group">
        <label>Metode Pelatihan</label>
        <input type="text" id="metode_pelatihan_visible" class="form-control" readonly style="background:#e9ecef;" required>
      </div>

      <div class="form-group" id="lokasi_pelatihan" style="display:none;">
        <label>Lokasi Pelatihan</label>
        <input type="text" id="lokasi" name="lokasi_pelatihan" class="form-control" readonly style="background:#e9ecef;">
      </div>

      <input type="hidden" id="jenis_pelatihan_hidden" name="jenis_pelatihan">
      <div class="form-group">
        <label>Jenis Pelatihan</label>
        <input type="text" id="jenis_pelatihan_visible" class="form-control" readonly style="background:#e9ecef;" required>
      </div>

      <div class="form-group">
        <label>Penyelenggara</label>
        <input type="text" id="penyelenggara" name="penyelenggara" class="form-control" readonly style="background:#e9ecef;" required>
      </div>

      <input type="hidden" id="biaya_hidden" name="biaya">
      <div class="form-group">
        <label>Biaya</label>
        <input type="text" id="biaya_visible" class="form-control" readonly style="background:#e9ecef;">
      </div>

      <button type="submit" class="btn btn-primary mt-3">Simpan</button>
    </form>
  </div>
</div>

<script>
  const karyawanList = @json($karyawans);

  document.getElementById('peserta_datalist').addEventListener('change', function () {
    const val = this.value;
    const match = karyawanList.find(k =>
      `${k.nik} - ${k.nama}`.toLowerCase() === val.toLowerCase()
    );
    if (!match) return;

    const max = document.querySelectorAll('#hidden-checkboxes input').length;
    if (max >= 20) {
      alert('Maksimal 20 peserta!');
      return;
    }

    if (document.getElementById(`peserta_${match.nik}`)) return;

    const table = document.querySelector('#selected-employees-table tbody');
    const row = document.createElement('tr');
    const id = table.children.length + 1;

    row.innerHTML = `
      <td>${id}</td><td>${match.nik}</td><td>${match.nama}</td>
      <td>${match.jabatan}</td><td>${match.bagian}</td><td>${match.unit_usaha}</td>
      <td><button type="button" class="btn btn-danger btn-sm" onclick="hapusPeserta('${match.nik}')">Hapus</button></td>
    `;
    table.appendChild(row);

    // Hidden checkbox
    document.getElementById('hidden-checkboxes').innerHTML += `
      <input type="checkbox" id="peserta_${match.nik}" name="peserta[]" value="${match.nik}" checked hidden>
    `;

    // Bersihkan input
    this.value = '';

    // Update count
    document.getElementById('peserta-count').textContent = `Peserta yang dipilih: ${max + 1}`;
  });

  function hapusPeserta(nik) {
    document.getElementById(`peserta_${nik}`)?.remove();
    const rows = document.querySelectorAll('#selected-employees-table tbody tr');
    rows.forEach(row => {
      if (row.children[1].textContent === nik) row.remove();
    });

    // Re-index
    rows.forEach((r, i) => r.children[0].textContent = i + 1);
    document.getElementById('peserta-count').textContent = `Peserta yang dipilih: ${rows.length - 1}`;
  }

  function toggleLokasiInput(){
    const m = document.getElementById('metode_pelatihan_visible').value;
    document.getElementById('lokasi_pelatihan').style.display = (m === 'Offline') ? 'block' : 'none';
  }

  function formatRupiah(x){
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
  }

  document.getElementById('judul_pelatihan').addEventListener('change', function(){
    const id = this.selectedOptions[0].getAttribute('data-id');
    if (!id) return;

    fetch(`/api/pelatihan/${id}`)
      .then(r => r.json())
      .then(data => {
        document.getElementById('metode_pelatihan_hidden').value = data.metode_pelatihan;
        document.getElementById('metode_pelatihan_visible').value = data.metode_pelatihan;
        document.getElementById('jenis_pelatihan_hidden').value = data.jenis_pelatihan;
        document.getElementById('jenis_pelatihan_visible').value = data.jenis_pelatihan;
        document.getElementById('penyelenggara').value = data.penyelenggara;
        document.getElementById('tgl_awal').value = data.tgl_awal;
        document.getElementById('tgl_akhir').value = data.tgl_akhir;
        document.getElementById('biaya_hidden').value = data.biaya;
        document.getElementById('biaya_visible').value = formatRupiah(data.biaya);
        document.getElementById('lokasi').value = data.lokasi_pelatihan;
        toggleLokasiInput();
      });
  });

  document.addEventListener('DOMContentLoaded', toggleLokasiInput);
</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if (session('success'))
<script>
    document.addEventListener('DOMContentLoaded', () => {
        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: '{{ session('success') }}',
            showConfirmButton: false,
            timer: 2000
        });
    });
</script>
@endif

@endsection
