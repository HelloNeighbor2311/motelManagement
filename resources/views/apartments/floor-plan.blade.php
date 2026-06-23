@extends('layouts.app')

@section('content')
<div class="page-header">
    <div class="page-title">
        <h1>Sơ Đồ Căn Hộ</h1>
        <div class="breadcrumb">
            <a href="{{ route('dashboard') }}">Trang Chủ</a>
            <span class="separator">/</span>
            <a href="{{ route('apartments.index') }}">Căn Hộ</a>
            <span class="separator">/</span>
            <span>Sơ Đồ</span>
        </div>
    </div>
    <div class="page-actions">
        <a href="{{ route('apartments.index') }}" class="btn btn-secondary">
            <i class="fas fa-list"></i> Danh Sách
        </a>
    </div>
</div>

<div class="card mb-3">
    <div class="card-body p-3">
        <form method="GET" action="{{ route('apartments.floor-plan') }}" class="row g-3 align-items-end">
            <div class="col-md-8">
                <label class="form-label" style="font-weight: 600; font-size: 12px;">Chọn Tòa Nhà</label>
                <select name="building" class="form-select">
                    @foreach ($buildings as $item)
                        <option value="{{ $item->Id }}" {{ optional($building)->Id === $item->Id ? 'selected' : '' }}>
                            {{ $item->TenToaNha }}{{ $item->khuVuc ? ' - ' . $item->khuVuc->TenKhuVuc : '' }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-filter"></i> Xem Sơ Đồ
                </button>
            </div>
        </form>
    </div>
</div>

@if ($building)
    <div class="card">
        <div class="card-header" style="background-color: #f8f9fa; border-bottom: 1px solid #e0e0e0; padding: 16px;">
            <h6 class="mb-0 fw-bold">{{ $building->TenToaNha }} - {{ $building->khuVuc->TenKhuVuc ?? 'N/A' }}</h6>
        </div>
        <div class="card-body">
            @forelse ($apartments as $floor => $floorApartments)
                <div class="mb-4">
                    <h6 class="fw-bold mb-3">Tầng {{ $floor }}</h6>
                    <div class="floor-grid">
                        @foreach ($floorApartments as $apartment)
                            <a href="{{ route('apartments.show', $apartment->Id) }}" class="apartment-tile {{ $apartment->status_badge }}">
                                <strong>{{ $apartment->MaCanHo }}</strong>
                                <span>{{ $apartment->status_display }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>
            @empty
                <div class="alert alert-info mb-0">Tòa nhà này chưa có căn hộ nào.</div>
            @endforelse
        </div>
    </div>
@else
    <div class="alert alert-info">Chưa có tòa nhà nào để hiển thị sơ đồ.</div>
@endif

<style>
    .floor-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
        gap: 12px;
    }

    .apartment-tile {
        border-radius: 10px;
        color: white !important;
        display: flex;
        flex-direction: column;
        gap: 6px;
        min-height: 88px;
        padding: 14px;
        text-decoration: none;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .apartment-tile:hover {
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.16);
        transform: translateY(-2px);
    }

    .apartment-tile span {
        font-size: 12px;
        opacity: 0.9;
    }

    .badge-trong {
        background-color: #28a745 !important;
    }

    .badge-dang-thue {
        background-color: #0066cc !important;
    }

    .badge-bao-tri {
        background-color: #dc3545 !important;
    }
</style>
@endsection
