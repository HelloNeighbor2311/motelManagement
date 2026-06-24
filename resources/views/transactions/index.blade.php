@extends('layouts.app')

@section('content')
<div class="page-header">
	<div class="page-title">
		<h1>Quản Lý Thu Chi</h1>
		<div class="breadcrumb">
			<a href="{{ route('dashboard') }}">Trang Chủ</a>
			<span class="separator">/</span>
			<span>Thu Chi</span>
		</div>
	</div>
	<div class="page-actions">
		<a href="{{ route('transactions.create') }}" class="btn btn-primary">
			<i class="fas fa-plus"></i> Thêm Giao Dịch
		</a>
	</div>
</div>

@if (session('success'))
	<div class="alert alert-success alert-dismissible fade show" role="alert">
		<i class="fas fa-check-circle"></i> {{ session('success') }}
		<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
	</div>
@endif

<div class="card mb-3">
    <div class="card-body">
        <div class="row g-3">

            <div class="col-md-3 d-flex">
                <div class="w-100 h-100 d-flex flex-column justify-content-center"
                     style="padding:16px;background:#28a745;border-radius:8px;color:white;text-align:center;">
                    <p style="margin:0;font-size:12px;text-transform:uppercase;opacity:.9">
                        Tổng Thu
                    </p>
                    <p style="margin:8px 0 0 0;font-size:24px;font-weight:700;">
                        {{ number_format($statistics['totalIncome'] ?? 0, 0, ',', '.') }} đ
                    </p>
                </div>
            </div>

            <div class="col-md-3 d-flex">
                <div class="w-100 h-100 d-flex flex-column justify-content-center"
                     style="padding:16px;background:#dc3545;border-radius:8px;color:white;text-align:center;">
                    <p style="margin:0;font-size:12px;text-transform:uppercase;opacity:.9">
                        Tổng Chi
                    </p>
                    <p style="margin:8px 0 0 0;font-size:24px;font-weight:700;">
                        {{ number_format($statistics['totalExpense'] ?? 0, 0, ',', '.') }} đ
                    </p>
                </div>
            </div>

            <div class="col-md-3 d-flex">
                <div class="w-100 h-100 d-flex flex-column justify-content-center"
                     style="padding:16px;background:#17a2b8;border-radius:8px;color:white;text-align:center;">
                    <p style="margin:0;font-size:12px;text-transform:uppercase;opacity:.9">
                        Thu Tháng
                    </p>
                    <p style="margin:8px 0 0 0;font-size:24px;font-weight:700;">
                        {{ number_format($statistics['monthIncome'] ?? 0, 0, ',', '.') }} đ
                    </p>
                </div>
            </div>

            <div class="col-md-3 d-flex">
                <div class="w-100 h-100 d-flex flex-column justify-content-center"
                     style="padding:16px;background:#dc3545;border-radius:8px;color:white;text-align:center;">
                    <p style="margin:0;font-size:12px;text-transform:uppercase;opacity:.9">
                        Chi Tháng
                    </p>
                    <p style="margin:8px 0 0 0;font-size:24px;font-weight:700;">
                        {{ number_format($statistics['monthExpense'] ?? 0, 0, ',', '.') }} đ
                    </p>
                </div>
            </div>

        </div>
    </div>
</div>

<div class="card">
	<div class="card-header">
		<div class="row g-3 align-items-center">
			<div class="col-md-3">
				<select id="typeFilter" class="form-select" onchange="applyFilters()">
					<option value="">-- Tất cả --</option>
					<option value="Thu" {{ request('type') == 'Thu' ? 'selected' : '' }}>Thu</option>
					<option value="Chi" {{ request('type') == 'Chi' ? 'selected' : '' }}>Chi</option>
				</select>
			</div>
			<div class="col-md-3">
				<input type="month" id="monthFilter" class="form-control" value="{{ request('month') }}" onchange="applyFilters()">
			</div>
			<div class="col-md-6">
				<form method="GET" action="{{ route('transactions.index') }}" class="d-flex gap-2">
					<input type="hidden" name="type" value="{{ request('type') }}">
					<input type="month" name="month" value="{{ request('month') }}" style="display:none">
					<input type="text" name="search" class="form-control" placeholder="Tìm tham chiếu, mô tả..." value="{{ request('search') }}">
					<button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Tìm</button>
				</form>
			</div>
		</div>
	</div>

	<div class="table-responsive">
		<table class="table table-hover mb-0">
			<thead style="background-color: #f8f9fa;">
				<tr>
					<th>Ngày</th>
					<th>Tham Chiếu</th>
					<th>Mô Tả</th>
					<th>Loại</th>
					<th style="text-align: right;">Số Tiền</th>
					<th style="text-align: center;">Thao Tác</th>
				</tr>
			</thead>
			<tbody>
				@forelse ($transactions as $t)
					<tr>
						<td>{{ $t->NgayGiaoDich ? \Carbon\Carbon::parse($t->NgayGiaoDich)->format('d/m/Y') : 'N/A' }}</td>
						<td>{{ $t->ThamChieu ?? '-' }}</td>
						<td>{{ $t->MoTa ?? '-' }}</td>
						<td>
							@if ($t->LoaiGiaoDich == 'Thu')
								<span class="badge bg-success">Thu</span>
							@else
								<span class="badge bg-danger">Chi</span>
							@endif
						</td>
						<td style="text-align: right; font-weight:600">{{ number_format($t->SoTien, 0, ',', '.') }} đ</td>
						<td style="text-align: center;">
							<a href="{{ route('transactions.show', $t->Id) }}" class="btn btn-sm btn-info table-action-btn" title="Xem Chi Tiết"><i class="fas fa-eye"></i></a>
							<a href="{{ route('transactions.edit', $t->Id) }}" class="btn btn-sm btn-warning table-action-btn" title="Chỉnh Sửa"><i class="fas fa-edit"></i></a>
							<button type="button" class="btn btn-sm btn-danger delete-btn table-action-btn" data-id="{{ $t->Id }}" data-url="{{ route('transactions.destroy', $t->Id) }}" title="Xóa"><i class="fas fa-trash"></i></button>
						</td>
					</tr>
				@empty
					<tr>
						<td colspan="6" class="text-center py-4">
							<i class="fas fa-inbox" style="font-size:32px;color:#ccc"></i>
							<p style="margin-top:8px;color:#999">Không có giao dịch</p>
						</td>
					</tr>
				@endforelse
			</tbody>
		</table>
	</div>

	@if ($transactions->hasPages())
		<div class="card-footer">
			{{ $transactions->links('pagination::bootstrap-5') }}
		</div>
	@endif
</div>

<script>
	function applyFilters() {
		const type = document.getElementById('typeFilter').value;
		const month = document.getElementById('monthFilter').value;
		const params = new URLSearchParams(window.location.search);
		if (type) params.set('type', type); else params.delete('type');
		if (month) params.set('month', month); else params.delete('month');
		window.location.href = `{{ route('transactions.index') }}?${params.toString()}`;
	}

	document.querySelectorAll('.delete-btn').forEach(btn => {
		btn.addEventListener('click', function() {
			const id = this.dataset.id;
			const url = this.dataset.url;
			Swal.fire({
				title: 'Xóa giao dịch?',
				text: 'Hành động này sẽ không thể hoàn tác',
				icon: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#dc3545',
				cancelButtonColor: '#6c757d',
				confirmButtonText: 'Xóa',
				cancelButtonText: 'Hủy'
			}).then(result => {
				if (result.isConfirmed) {
					fetch(url, {
						method: 'DELETE',
						headers: {
							'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
							'Content-Type': 'application/json'
						}
					})
					.then(r => r.json())
					.then(data => {
						if (data.success) {
							Swal.fire('Thành công', data.message, 'success').then(() => location.reload());
						} else {
							Swal.fire('Lỗi', data.message || 'Có lỗi xảy ra', 'error');
						}
					})
					.catch(e => Swal.fire('Lỗi', 'Có lỗi xảy ra: ' + e, 'error'));
				}
			});
		});
	});
</script>

@endsection

