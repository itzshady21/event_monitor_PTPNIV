@extends('template.header')

@section('content')

<div class="card mt-4">
    <div class="card-header bg-primary text-white">
        <h4>Upload & Edit Sertifikat</h4>
    </div>
    <div class="card-body">

        <div class="d-flex justify-content-end mb-3">
            <input type="text" id="searchInput" class="form-control w-25" placeholder="Cari data...">
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-striped text-nowrap" style="font-size: 16px;">
                <thead class="thead-dark text-center">
                    <tr>
                        <th>No</th>
                        <th>NIK</th>
                        <th>Nama</th>
                        <th>Jabatan</th>
                        <th>Bagian</th>
                        <th>Unit Usaha</th>
                        <th>Tanggal Pelatihan</th>
                        <th>Judul</th>
                        <th>Jenis</th>
                        <th>Lokasi</th>
                        <th>Metode</th>
                        <th>Penyelenggara</th>
                        <th>Biaya</th>
                        <th>Sertifikat</th>
                        <th>Upload/Edit</th>
                    </tr>
                </thead>
                <tbody id="dataTableBody">
                @foreach($events as $event)
                    <tr>
                        <td class="text-center">{{ $loop->iteration + ($events->currentPage() - 1) * $events->perPage() }}</td>
                        <td>{{ $event->nik }}</td>
                        <td>{{ $event->nama }}</td>
                        <td>{{ $event->jabatan }}</td>
                        <td>{{ $event->bagian }}</td>
                        <td>{{ $event->unit_usaha }}</td>
                        <td>{{ $event->tgl_awal }} - {{ $event->tgl_akhir }}</td>
                        <td>{{ $event->judul_pelatihan }}</td>
                        <td>{{ $event->jenis_pelatihan }}</td>
                        <td>{{ $event->lokasi_pelatihan }}</td>
                        <td>{{ $event->metode_pelatihan }}</td>
                        <td>{{ $event->penyelenggara }}</td>
                        <td>Rp{{ number_format($event->biaya, 0, ',', '.') }}</td>
                        <td class="text-center">
                            @if($event->sertifikat)
                                <a href="{{ asset('storage/' . $event->sertifikat) }}" target="_blank" class="btn btn-sm btn-primary">
                                    <i class="fa fa-eye"></i> Lihat
                                </a>
                            @else
                                <span class="text-muted">Belum Ada</span>
                            @endif
                        </td>
                        <td style="min-width: 220px;">
                            <form 
                                action="{{ $event->sertifikat ? route('edit.sertifikat', $event->id) : route('upload.sertifikat', $event->id) }}" 
                                method="POST" enctype="multipart/form-data" class="d-flex align-items-center gap-2">
                                @csrf
                                @method('POST')
                                <input type="file" name="sertifikat" accept="application/pdf" class="form-control form-control-sm" required>
                                <button type="submit" class="btn btn-sm btn-primary">
                                    {{ $event->sertifikat ? 'Edit' : 'Upload' }}
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            <!-- Paginasi -->
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <span>Menampilkan {{ $events->count() }} dari {{ $events->total() }} data</span>
                </div>
                <div>
                    {{ $events->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Search input live filtering
document.getElementById('searchInput').addEventListener('input', function () {
    const searchTerm = this.value.toLowerCase();
    const rows = document.querySelectorAll('#dataTableBody tr');

    rows.forEach(row => {
        const text = row.innerText.toLowerCase();
        row.style.display = text.includes(searchTerm) ? '' : 'none';
    });
});
</script>


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


@endsection
