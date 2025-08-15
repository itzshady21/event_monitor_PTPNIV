@extends('bagsdm.header')

@section('content')

<div class="card mt-4">
    <div class="card-header bg-primary text-white">
        <div class="d-flex justify-content-between align-items-center flex-wrap">
            <h4 class="mb-0">Data Peserta</h4>
        </div>
    </div>

    <div class="card-body">

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
            <form action="{{ route('formDataPeserta') }}" method="GET" class="d-flex align-items-center">
                <input type="text" id="searchInput" name="search" class="form-control mr-2" placeholder="Cari data..." value="{{ request('search') }}">
                <button type="submit" class="btn" style="background-color: #007bff; color: white;">
                    <i class="fas fa-search"></i>
                </button>
            </form>
        </div>

        {{-- Tabel Data --}}
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
                        <th>Tgl Awal Pelatihan</th>
                        <th>Tgl Akhir Pelatihan</th>
                        <th>Judul Pelatihan</th>
                        <th>Metode Pelatihan</th>
                        <th>Lokasi Pelatihan</th>
                        <th>Jenis Pelatihan</th>
                        <th>Penyelenggara</th>
                        <th>Biaya</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody id="dataTableBody">
                    @foreach($data_event as $event)
                        @php
                            $today = \Carbon\Carbon::today();
                            $tglAwal = \Carbon\Carbon::parse($event->tgl_awal);
                            $tglAkhir = \Carbon\Carbon::parse($event->tgl_akhir);

                            if ($today->between($tglAwal, $tglAkhir)) {
                                $status = 'Sedang Berlangsung';
                                $badgeClass = 'badge bg-success text-white';
                            } elseif ($today->lt($tglAwal)) {
                                $status = 'Pelatihan Mendatang';
                                $badgeClass = 'badge bg-warning text-dark';
                            } else {
                                $status = 'Telah Berakhir';
                                $badgeClass = 'badge bg-danger text-white';
                            }
                        @endphp
                        <tr>
                            <td>{{ $loop->iteration + ($data_event->currentPage() - 1) * $data_event->perPage() }}</td>
                            <td>{{ $event->nik }}</td>
                            <td>{{ $event->nama }}</td>
                            <td>{{ $event->jabatan }}</td>
                            <td>{{ $event->bagian }}</td>
                            <td>{{ $event->unit_usaha }}</td>
                            <td>{{ $tglAwal->format('d/m/Y') }}</td>
                            <td>{{ $tglAkhir->format('d/m/Y') }}</td>
                            <td>{{ $event->judul_pelatihan }}</td>
                            <td>{{ $event->metode_pelatihan }}</td>
                            <td>{{ $event->lokasi_pelatihan }}</td>
                            <td>{{ $event->jenis_pelatihan }}</td>
                            <td>{{ $event->penyelenggara }}</td>
                            <td>Rp{{ number_format($event->biaya, 0, ',', '.') }}</td>
                            <td class="text-center">
                                <span class="{{ $badgeClass }}">{{ $status }}</span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

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

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
// Filter data tabel di sisi client
document.getElementById('searchInput').addEventListener('input', function() {
    const searchTerm = this.value.toLowerCase();
    const rows = document.querySelectorAll('#dataTableBody tr');
    
    rows.forEach(row => {
        const columns = row.querySelectorAll('td');
        const rowText = Array.from(columns).map(col => col.textContent.toLowerCase()).join(' ');
        
        if (rowText.includes(searchTerm)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
});
</script>

@endsection
