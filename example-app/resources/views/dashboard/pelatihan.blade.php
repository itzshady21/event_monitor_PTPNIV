@extends('dashboard.header')

@section('content')
<style>
    /* Biar jarak antar sel lebih lega */
    .table th, .table td {
        vertical-align: middle !important;
        padding: 0.75rem 1rem !important;
        white-space: nowrap; /* Biar kolom tidak kepanjangan ke bawah */
    }
    .table-responsive {
        overflow-x: auto; /* Jika kolom banyak, bisa scroll horizontal */
    }
</style>

<div class="card mt-4 shadow-sm">
    <div class="card-header bg-primary text-white">
        <h4 class="mb-0">Riwayat Pelatihan yang Diikuti</h4>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-bordered align-middle">
                <thead class="table-primary">
                    <tr class="text-center">
                        <th>No</th>
                        <th>Judul Pelatihan</th>
                        <th>Tanggal Awal</th>
                        <th>Tanggal Akhir</th>
                        <th>Metode</th>
                        <th>Lokasi</th>
                        <th>Jenis</th>
                        <th>Penyelenggara</th>
                        <th>Biaya</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pelatihans as $index => $p)
                        <tr>
                            <td class="text-center">{{ $pelatihans->firstItem() + $index }}</td>
                            <td>{{ $p->judul_pelatihan }}</td>
                            <td class="text-center">{{ \Carbon\Carbon::parse($p->tgl_awal)->format('d-m-Y') }}</td>
                            <td class="text-center">{{ \Carbon\Carbon::parse($p->tgl_akhir)->format('d-m-Y') }}</td>
                            <td class="text-center">{{ $p->metode_pelatihan }}</td>
                            <td>{{ $p->lokasi_pelatihan }}</td>
                            <td class="text-center">{{ $p->jenis_pelatihan }}</td>
                            <td>{{ $p->penyelenggara }}</td>
                            <td class="text-end">Rp{{ number_format($p->biaya, 0, ',', '.') }}</td>
                            <td class="text-center">
                                @php
                                    $now = \Carbon\Carbon::now();
                                    $start = \Carbon\Carbon::parse($p->tgl_awal);
                                    $end = \Carbon\Carbon::parse($p->tgl_akhir);
                                @endphp

                                @if ($now->lt($start))
                                    <span class="badge bg-warning text-dark">Mendatang</span>
                                @elseif ($now->between($start, $end))
                                    <span class="badge bg-success text-white">Sedang Berlangsung</span>
                                @else
                                    <span class="badge bg-danger text-white">Telah Berakhir</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center text-muted py-4">
                                Belum ada pelatihan diikuti.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- Tombol Paginasi --}}
            <div class="d-flex justify-content-center mt-3">
                {{ $pelatihans->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
