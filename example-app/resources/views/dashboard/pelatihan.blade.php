@extends('dashboard.header')

@section('content')
<div class="card mt-4">
    <div class="card-header bg-primary text-white">
        <h4>Riwayat Pelatihan yang Diikuti</h4>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
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
                        <td>{{ $pelatihans->firstItem() + $index }}</td>
                        <td>{{ $p->judul_pelatihan }}</td>
                        <td>{{ \Carbon\Carbon::parse($p->tgl_awal)->format('d-m-Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($p->tgl_akhir)->format('d-m-Y') }}</td>
                        <td>{{ $p->metode_pelatihan }}</td>
                        <td>{{ $p->lokasi_pelatihan }}</td>
                        <td>{{ $p->jenis_pelatihan }}</td>
                        <td>{{ $p->penyelenggara }}</td>
                        <td>Rp{{ number_format($p->biaya, 0, ',', '.') }}</td>
                        <td>
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
                        <td colspan="10" class="text-center text-muted">Belum ada pelatihan diikuti.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
                        {{-- Tombol Paginasi --}}
                <div class="d-flex justify-content-center">
                    {{ $pelatihans->links() }}
                </div>

        </div>
    </div>
</div>
@endsection
