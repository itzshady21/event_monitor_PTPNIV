@extends('template.header')

@section('content')
<div class="container mt-4">
    <h2>Dashboard Pelatihan</h2>
    
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="alert alert-primary">
                <h5><i class="fa fa-calendar"></i> Tanggal: <span id="tanggal"></span></h5>
                <h5><i class="fa fa-calendar-day"></i> Hari: <span id="hari"></span></h5>
                <h5><i class="fa fa-clock"></i> Waktu: <span id="jam"></span></h5>
            </div>
        </div>


    <!-- Dashboard event boxes -->
    <div class="row">
        <!-- Ongoing Events (Green) -->
        <div class="col-md-4">
            <div class="card text-white bg-success mb-4" id="box-ongoing">
                <div class="card-body">
                    <h3>{{ $ongoingEvents->total() }} <i class="fa fa-users" aria-hidden="true"></i></h3>
                    <p>Event yang Sedang Berlangsung</p>
                    <button class="btn btn-success mt-3" onclick="showTable('ongoing')">Lihat Data</button>
                </div>
            </div>
        </div>
        <!-- Upcoming Events (Yellow) -->
        <div class="col-md-4">
            <div class="card text-white bg-warning mb-4" id="box-upcoming">
                <div class="card-body">
                    <h3>{{ $upcomingEvents->total() }} <i class="fa fa-users"></i></h3>
                    <p>Event yang Akan Datang</p>
                    <button class="btn text-white btn-warning mt-3" onclick="showTable('upcoming')">Lihat Data</button>
                </div>
            </div>
        </div>
        <!-- Past Events (Red) -->
        <div class="col-md-4">
            <div class="card text-white bg-danger mb-4" id="box-past">
                <div class="card-body">
                    <h3>{{ $pastEvents->total() }} <i class="fa fa-users"></i></h3>
                    <p>Event yang Telah Lewat</p>
                    <button class="btn btn-danger mt-3" onclick="showTable('past')">Lihat Data</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Dynamic Table to display event data -->
    <div id="event-table" class="mt-4">
        <!-- Ongoing Events Table -->
        <div id="ongoing-table" style="display: none;">
            <div class="card mt-4">
                <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                    <h4>Event yang Sedang Berlangsung</h4>
                </div>
                <div class="card-body">
                <div class="table-responsive">
                <table class="table table-bordered table-striped text-nowrap" style="font-size: 16px;">
                <thead class="thead-light text-center">
                                <tr>
                                    <th>No</th>
                                    <th>NIK</th>
                                    <th>Nama</th>
                                    <th>Jabatan</th>
                                    <th>Bagian</th>
                                    <th>Unit Usaha</th>
                                    <th>Judul Pelatihan</th>
                                    <th>Metode Pelatihan</th>
                                    <th>Lokasi Pelatihan</th>
                                    <th>Jenis Pelatihan</th>
                                    <th>Penyelenggara</th>
                                    <th>Tgl Awal Pelatihan</th>
                                    <th>Tgl Akhir Pelatihan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($ongoingEvents as $event)
                                <tr>
                                    <td>{{ ($ongoingEvents->currentPage()-1) * $ongoingEvents->perPage() + $loop->iteration }}</td>
                                    <td>{{ $event->nik }}</td>
                                    <td>{{ $event->nama }}</td>
                                    <td>{{ $event->jabatan }}</td>
                                    <td>{{ $event->bagian }}</td>
                                    <td>{{ $event->unit_usaha }}</td>
                                    <td>{{ $event->judul_pelatihan }}</td>
                                    <td>{{ $event->metode_pelatihan }}</td>
                                    <td>{{ $event->lokasi_pelatihan }}</td>
                                    <td>{{ $event->jenis_pelatihan }}</td>
                                    <td>{{ $event->penyelenggara }}</td>
                                    <td>{{ \Carbon\Carbon::parse($event->tgl_awal)->format('d/m/Y') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($event->tgl_akhir)->format('d/m/Y') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $ongoingEvents->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Upcoming Events Table -->
        <div id="upcoming-table" style="display: none;">
            <div class="card mt-4">
                <div class="card-header bg-warning text-white d-flex justify-content-between align-items-center">
                    <h4>Event yang Akan Datang</h4>
                </div>
                <div class="card-body">
                <div class="table-responsive">
                <table class="table table-bordered table-striped text-nowrap" style="font-size: 16px;">
                <thead class="thead-light text-center">
                                <tr>
                                    <th>No</th>
                                    <th>NIK</th>
                                    <th>Nama</th>
                                    <th>Jabatan</th>
                                    <th>Bagian</th>
                                    <th>Unit Usaha</th>
                                    <th>Judul Pelatihan</th>
                                    <th>Metode Pelatihan</th>
                                    <th>Lokasi Pelatihan</th>
                                    <th>Jenis Pelatihan</th>
                                    <th>Penyelenggara</th>
                                    <th>Tgl Awal Pelatihan</th>
                                    <th>Tgl Akhir Pelatihan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($upcomingEvents as $event)
                                <tr>
                                    <td>{{ ($upcomingEvents->currentPage()-1) * $upcomingEvents->perPage() + $loop->iteration }}</td>
                                    <td>{{ $event->nik }}</td>
                                    <td>{{ $event->nama }}</td>
                                    <td>{{ $event->jabatan }}</td>
                                    <td>{{ $event->bagian }}</td>
                                    <td>{{ $event->unit_usaha }}</td>
                                    <td>{{ $event->judul_pelatihan }}</td>
                                    <td>{{ $event->metode_pelatihan }}</td>
                                    <td>{{ $event->lokasi_pelatihan }}</td>
                                    <td>{{ $event->jenis_pelatihan }}</td>
                                    <td>{{ $event->penyelenggara }}</td>
                                    <td>{{ \Carbon\Carbon::parse($event->tgl_awal)->format('d/m/Y') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($event->tgl_akhir)->format('d/m/Y') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $upcomingEvents->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Past Events Table -->
        <div id="past-table" style="display: none;">
            <div class="card mt-4">
                <div class="card-header bg-danger text-white d-flex justify-content-between align-items-center">
                    <h4>Event yang Telah Lewat</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                    <table class="table table-bordered table-striped text-nowrap" style="font-size: 16px;">
                    <thead class="thead-light text-center">
                                <tr>
                                    <th>No</th>
                                    <th>NIK</th>
                                    <th>Nama</th>
                                    <th>Jabatan</th>
                                    <th>Bagian</th>
                                    <th>Unit Usaha</th>
                                    <th>Judul Pelatihan</th>
                                    <th>Metode Pelatihan</th>
                                    <th>Lokasi Pelatihan</th>
                                    <th>Jenis Pelatihan</th>
                                    <th>Penyelenggara</th>
                                    <th>Tgl Awal Pelatihan</th>
                                    <th>Tgl Akhir Pelatihan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pastEvents as $event)
                                <tr>
                                    <td>{{ ($pastEvents->currentPage()-1) * $pastEvents->perPage() + $loop->iteration }}</td>
                                    <td>{{ $event->nik }}</td>
                                    <td>{{ $event->nama }}</td>
                                    <td>{{ $event->jabatan }}</td>
                                    <td>{{ $event->bagian }}</td>
                                    <td>{{ $event->unit_usaha }}</td>
                                    <td>{{ $event->judul_pelatihan }}</td>
                                    <td>{{ $event->metode_pelatihan }}</td>
                                    <td>{{ $event->lokasi_pelatihan }}</td>
                                    <td>{{ $event->jenis_pelatihan }}</td>
                                    <td>{{ $event->penyelenggara }}</td>
                                    <td>{{ \Carbon\Carbon::parse($event->tgl_awal)->format('d/m/Y') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($event->tgl_akhir)->format('d/m/Y') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $pastEvents->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

        <!-- Chart Section -->
<div class="row mt-5">
    <div class="col-md-6">
        <div class="card shadow">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5>Grafik Jumlah Peserta Pelatihan</h5>
                <select id="barChartToggle" class="form-control w-auto" onchange="updateBarChart()">
                    <option value="" selected disabled hidden>Filter</option>
                    <option value="monthly">Per Bulan</option>
                    <option value="yearly">Per Tahun</option>
                </select>
            </div>
            <div class="chart-container" style="height:300px;">
                <canvas id="barChart" style="max-height: 100%;"></canvas>
            </div>

        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card shadow">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5>Distribusi Peserta Berdasarkan Bagian</h5>
            </div>
            <div class="chart-container" style="height:300px;">
                <canvas id="pieChart" style="max-height: 100%;"></canvas>
            </div>
        </div>
    </div>
</div>
</div>

<script>
    // Function to update date, day, and time
    function updateTime() {
        const now = new Date();
        const optionsDate = { year: 'numeric', month: 'long', day: 'numeric' };
        const optionsDay = { weekday: 'long' };
        const optionsTime = { hour: '2-digit', minute: '2-digit', second: '2-digit' };

        document.getElementById('tanggal').textContent = now.toLocaleDateString('id-ID', optionsDate);
        document.getElementById('hari').textContent = now.toLocaleDateString('id-ID', optionsDay);
        document.getElementById('jam').textContent = now.toLocaleTimeString(undefined, optionsTime);
    }

    // Update the time every second
    setInterval(updateTime, 1000);
    // Initial call to display the time immediately on page load
    updateTime();

    function showTable(type) {
        document.getElementById('ongoing-table').style.display = 'none';
        document.getElementById('upcoming-table').style.display = 'none';
        document.getElementById('past-table').style.display = 'none';
        
        if (type === 'ongoing') {
            document.getElementById('ongoing-table').style.display = 'block';
        } else if (type === 'upcoming') {
            document.getElementById('upcoming-table').style.display = 'block';
        } else if (type === 'past') {
            document.getElementById('past-table').style.display = 'block';
        }
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    let barChart, pieChart;

    const monthlyBarData = {
        labels: {!! json_encode($monthlyLabels ?? []) !!}, 
        datasets: [{
            label: 'Jumlah Peserta',
            backgroundColor: '#007bff',
            data: {!! json_encode($monthlyCounts ?? []) !!}
        }]
    };

    const yearlyBarData = {
        labels: {!! json_encode($yearlyLabels ?? []) !!}, 
        datasets: [{
            label: 'Jumlah Peserta',
            backgroundColor: '#28a745',
            data: {!! json_encode($yearlyCounts ?? []) !!}
        }]
    };

    const pieData = {
        labels: {!! json_encode($bagianLabels ?? []) !!},
        datasets: [{
        data: {!! json_encode($bagianCounts ?? []) !!},
        backgroundColor: [
                'rgba(0, 123, 255, 0.7)',
                'rgba(255, 193, 7, 0.7)',
                'rgba(220, 53, 69, 0.7)',
                'rgba(40, 167, 69, 0.7)',
                'rgba(111, 66, 193, 0.7)',
                'rgba(23, 162, 184, 0.7)',
                'rgba(102, 16, 242, 0.7)',
                'rgba(253, 126, 20, 0.7)',
                'rgba(32, 201, 151, 0.7)',
                'rgba(232, 62, 140, 0.7)',
                'rgba(52, 58, 64, 0.7)',
                'rgba(173, 181, 189, 0.7)',
                'rgba(255, 111, 97, 0.7)',
                'rgba(142, 68, 173, 0.7)'
                                            ]

        }]
    };


    function initCharts() {
    const barCtx = document.getElementById('barChart').getContext('2d');
    const pieCtx = document.getElementById('pieChart').getContext('2d');

    barChart = new Chart(barCtx, {
        type: 'bar',
        data: monthlyBarData,
        options: {
            responsive: true,
            scales: {
                y: { beginAtZero: true }
            }
        }
    });

    pieChart = new Chart(pieCtx, {
        type: 'pie',
        data: pieData,
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'bottom' }
            }
        }
    });
}

// ✅ Letakkan fungsi updateBarChart di luar initCharts
function updateBarChart() {
    const type = document.getElementById('barChartToggle').value;
    barChart.data = (type === 'monthly') ? monthlyBarData : yearlyBarData;
    barChart.update();
}

// ✅ Panggil saat DOM siap
document.addEventListener('DOMContentLoaded', initCharts);

</script>

@endsection
