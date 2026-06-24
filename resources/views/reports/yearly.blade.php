@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Báo Cáo Năm</h2>

    <form method="GET" action="{{ route('reports.yearly') }}" class="row g-2 mb-3">
        <div class="col-auto">
            <label for="year" class="form-label">Năm</label>
            <select name="year" id="year" class="form-select">
                @if(empty($years))
                    <option value="{{ $year }}">{{ $year }}</option>
                @else
                    @foreach($years as $y)
                        <option value="{{ $y }}" {{ $y == $year ? 'selected' : '' }}>{{ $y }}</option>
                    @endforeach
                @endif
            </select>
        </div>
        <div class="col-auto align-self-end">
            <button class="btn btn-primary">Lọc</button>
        </div>
    </form>

    <div class="card">
        <div class="card-body p-0">
            <table class="table table-striped mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Tài khoản</th>
                        <th>Năm</th>
                        <th>Tổng Thu</th>
                        <th>Tổng Chi</th>
                        <th>Tiền Thuế Thu</th>
                        <th>Tiền Đặt Cọc Thu</th>
                        <th>Chi Phí Vận Hành</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($records as $i => $r)
                        <tr>
                            <td>{{ $i+1 }}</td>
                            <td>{{ $r->TaiKhoanId }}</td>
                            <td>{{ $r->Nam }}</td>
                            <td>{{ number_format($r->TongThu,0,',','.') }}</td>
                            <td>{{ number_format($r->TongChi,0,',','.') }}</td>
                            <td>{{ number_format($r->TienThueThu,0,',','.') }}</td>
                            <td>{{ number_format($r->TienDatCocThu,0,',','.') }}</td>
                            <td>{{ number_format($r->ChiPhiVanHanh,0,',','.') }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="8" class="text-center">Không có dữ liệu</td></tr>
                    @endforelse
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="3">Tổng</th>
                        <th>{{ number_format($totals['TongThu'],0,',','.') }}</th>
                        <th>{{ number_format($totals['TongChi'],0,',','.') }}</th>
                        <th>{{ number_format($totals['TienThueThu'],0,',','.') }}</th>
                        <th>{{ number_format($totals['TienDatCocThu'],0,',','.') }}</th>
                        <th>{{ number_format($totals['ChiPhiVanHanh'],0,',','.') }}</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@endsection
