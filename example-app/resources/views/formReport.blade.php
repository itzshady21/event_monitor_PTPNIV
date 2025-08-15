@extends('template.header')

@section('content')
<div class="container mt-4">
    <h2>Halaman Laporan</h2>

    <div class="card mb-4">
        <div class="card-header bg-secondary text-white">
            <h4>Filter Laporan</h4>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('report.filter') }}" class="form-inline flex-wrap">
    <div class="form-group mb-2 mr-3">
        <label for="tanggal" class="mr-2" style="font-size: 14px;">Bulan & Tahun:</label>
        <input type="month" name="tanggal" id="tanggal" class="form-control form-control-sm" style="width: 150px;"
               value="{{ request('tanggal') ?? (isset($bulan) && isset($tahun) ? $tahun . '-' . str_pad($bulan, 2, '0', STR_PAD_LEFT) : '') }}">
    </div>

    <div class="form-group mb-2 mr-3">
        <label for="search" class="mr-2" style="font-size: 14px;">Cari:</label>
        <input type="text" name="search" id="search" class="form-control form-control-sm" style="width: 180px;" 
               placeholder="Nama, Judul, dll..." value="{{ request('search') }}">
    </div>

    <button type="submit" class="btn btn-sm btn-primary mb-2 mr-2">
        <i class="fas fa-filter"></i> Filter
    </button>

    <a href="{{ route('report.index') }}" class="btn btn-sm btn-secondary mb-2 mr-2">
        <i class="fas fa-undo"></i> Reset
    </a>

    <button type="button" class="btn btn-sm btn-success mb-2" onclick="exportExcel()">
        <i class="fas fa-file-excel"></i> Export Excel
    </button>

    <button type="button" class="btn btn-sm btn-danger mb-2" onclick="window.open('{{ route('report.export.pdf', request()->query()) }}', '_blank')">
        <i class="fas fa-file-pdf"></i> Cetak PDF
    </button>

</form>


        </div>
    </div>

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

    <div class="card">
        <div class="card-header bg-info text-white">
            <h4>Data Peserta Pelatihan</h4>
        </div>
        <div class="card-body">
            @if($data_event->isEmpty())
                <p>Tidak ada data yang tersedia.</p>
            @else
                <div class="table-responsive">
                <table class="table table-striped table-bordered align-middle text-nowrap" id="karyawanTable" style="font-size: 16px;">
                    <thead class="table-light text-center">
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
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data_event as $event)
                                <tr>
                                    <td>{{ $loop->iteration + ($data_event->currentPage() - 1) * $data_event->perPage() }}</td>
                                    <td>{{ $event->nik }}</td>
                                    <td>{{ $event->nama }}</td>
                                    <td>{{ $event->jabatan }}</td>
                                    <td>{{ $event->bagian }}</td>
                                    <td>{{ $event->unit_usaha }}</td>
                                    <td>{{ \Carbon\Carbon::parse($event->tgl_awal)->locale('id')->isoFormat('D MMMM Y') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($event->tgl_akhir)->locale('id')->isoFormat('D MMMM Y') }}</td>
                                    <td>{{ $event->judul_pelatihan }}</td>
                                    <td>{{ $event->metode_pelatihan }}</td>
                                    <td>{{ $event->lokasi_pelatihan }}</td>
                                    <td>{{ $event->jenis_pelatihan }}</td>
                                    <td>{{ $event->penyelenggara }}</td>
                                    <td>{{ $event->biaya }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Paginasi -->
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <span>Menampilkan {{ $data_event->count() }} dari {{ $data_event->total() }} data</span>
                    </div>
                    <div>
                        {{ $data_event->appends(request()->query())->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            @endif
        </div>  
    </div>
</div>

<script>
    function exportExcel() {
        const tanggal = document.getElementById('tanggal')?.value ?? '';
        const search = document.getElementById('search')?.value ?? '';

        let url = "{{ route('report.export') }}";

        // Tambahkan query string jika ada filter
        const params = new URLSearchParams();
        if (tanggal) params.append('tanggal', tanggal);
        if (search) params.append('search', search);

        window.location.href = url + '?' + params.toString();
    }
</script>

@endsection
