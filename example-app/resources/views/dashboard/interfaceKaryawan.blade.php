@extends('dashboard.header')

@section('content')
@php
    use Carbon\Carbon;

    Carbon::setLocale('id'); // Bahasa Indonesia
    $now = Carbon::now('Asia/Jakarta'); // Pastikan zona waktu benar
    $dayName = $now->translatedFormat('l'); // Hari dalam Bahasa Indonesia
    $dateToday = $now->translatedFormat('d F Y'); // Format tanggal
@endphp

<style>
    .info-box {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 20px;
        border-radius: 12px;
        color: #fff;
        transition: transform 0.3s ease-in-out;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }

    .info-box:hover {
        transform: translateY(-5px);
    }

    .info-blue {
        background-color: #007bff;
    }

    .info-green {
        background-color: #28a745;
    }

    .info-box .icon {
        font-size: 3rem;
        margin-right: 20px;
        animation: float 2s ease-in-out infinite;
    }

    @keyframes float {
        0% { transform: translateY(0); }
        50% { transform: translateY(-6px); }
        100% { transform: translateY(0); }
    }

    .info-box .text {
        flex: 1;
    }

    .btn-white {
        background-color: #fff;
        color: #000;
        font-weight: 600;
        border: none;
    }

    .btn-white:hover {
        background-color: #f0f0f0;
    }

    .alert-info, .alert-warning {
        border-radius: 8px;
    }
</style>

<div class="container mt-4">
    <h4>Selamat Datang!</h4>
    <p class="text-muted">{{ $dayName }}, {{ $dateToday }}</p>

    {{-- Notifikasi Pelatihan --}}
    <div class="mt-3">
        @if($ongoing->count())
            <div class="alert alert-success">
                <strong><i class="fas fa-bell"></i> Sedang Berlangsung:</strong>
                @foreach($ongoing as $item)
                    <div>📌 <strong>{{ $item->judul_pelatihan }}</strong> ({{ \Carbon\Carbon::parse($item->tgl_awal)->locale('id')->timezone('Asia/Jakarta')->translatedFormat('d/m/Y') }} - {{ \Carbon\Carbon::parse($item->tgl_akhir)->locale('id')->timezone('Asia/Jakarta')->translatedFormat('d/m/Y') }})</div>
                @endforeach
            </div>
        @endif

        @if($upcoming->count())
            <div class="alert alert-info">
                <strong><i class="fas fa-calendar-alt"></i> Akan Datang:</strong>
                @foreach($upcoming as $item)
                    <div>📅 <strong>{{ $item->judul_pelatihan }}</strong> ({{ \Carbon\Carbon::parse($item->tgl_awal)->locale('id')->timezone('Asia/Jakarta')->translatedFormat('d/m/Y') }})</div>
                @endforeach
            </div>
        @endif
    </div>

    {{-- Dua Kotak --}}
    <div class="row mt-4">
        {{-- Pelatihan Diikuti --}}
        <div class="col-md-6 mb-4">
            <div class="info-box info-blue">
                <div class="icon">
                    <i class="fas fa-user-graduate"></i>
                </div>
                <div class="text">
                    <h5>Pelatihan yang Diikuti</h5>
                    <p class="mb-2">Lihat riwayat pelatihan Anda.</p>
                    <a href="{{ url('jadwal-pelatihan/' . session('karyawan_id')) }}" class="btn btn-white btn-sm">Lihat Pelatihan</a>
                </div>
            </div>
        </div>

        {{-- Registrasi Pelatihan --}}
        <div class="col-md-6 mb-4">
            <div class="info-box info-green">
                <div class="icon">
                    <i class="fas fa-user-plus"></i>
                </div>
                <div class="text">
                    <h5>Registrasi Pelatihan</h5>
                    <p class="mb-2">Daftar ke pelatihan yang tersedia.</p>
                    <a href="{{ route('register.form') }}" class="btn btn-white btn-sm">Daftar Pelatihan</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
