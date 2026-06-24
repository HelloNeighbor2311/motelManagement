@php
    $isAreaActive = request()->routeIs('areas.*');
    $isBuildingActive = request()->routeIs('buildings.*');
    $isApartmentFloorPlanActive = request()->routeIs('apartments.floor-plan');
    $isApartmentActive = request()->routeIs('apartments.*') && ! $isApartmentFloorPlanActive;
    $isDataMenuActive = $isAreaActive || $isBuildingActive || $isApartmentActive || $isApartmentFloorPlanActive;

    $isCustomerActive = request()->routeIs('customers.*');
    $isContractActive = request()->routeIs('contracts.*');

    $isInvoiceActive = request()->routeIs('invoices.*');
    $isTransactionActive = request()->routeIs('transactions.*');
    $isFinanceMenuActive = $isInvoiceActive || $isTransactionActive;

    $isMonthlyReportActive = request()->routeIs('reports.monthly');
    $isYearlyReportActive = request()->routeIs('reports.yearly');
    $isReportMenuActive = $isMonthlyReportActive || $isYearlyReportActive;

    $isSystemMenuActive = request()->routeIs('profile', 'profile.*', 'users.*');
@endphp

<div class="sidebar" id="sidebar">
    <!-- Sidebar Brand -->
    <div class="sidebar-brand">
        <i class="fas fa-building"></i>
        <span>Motel</span>
    </div>

    <!-- Sidebar Menu -->
    <ul class="sidebar-menu">
        <!-- Dashboard -->
        <li>
            <a href="{{ route('dashboard') }}" class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="fas fa-chart-line"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <!-- Danh Mục Dữ Liệu -->
        <li class="has-submenu {{ $isDataMenuActive ? 'open' : '' }}">
            <a href="#" class="sidebar-link {{ $isDataMenuActive ? 'active' : '' }}">
                <i class="fas fa-database"></i>
                <span>Danh Mục Dữ Liệu</span>
            </a>
            <ul class="{{ $isDataMenuActive ? 'show' : '' }}">
                <li>
                    <a href="{{ route('areas.index') }}" class="{{ $isAreaActive ? 'active' : '' }}">
                        <i class="fas fa-map"></i>
                        <span>Khu Vực</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('buildings.index') }}" class="{{ $isBuildingActive ? 'active' : '' }}">
                        <i class="fas fa-home"></i>
                        <span>Tòa Nhà</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('apartments.index') }}" class="{{ $isApartmentActive ? 'active' : '' }}">
                        <i class="fas fa-door-open"></i>
                        <span>Căn Hộ</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('apartments.floor-plan') }}" class="{{ $isApartmentFloorPlanActive ? 'active' : '' }}">
                        <i class="fas fa-th-large"></i>
                        <span>Sơ Đồ Căn Hộ</span>
                    </a>
                </li>
            </ul>
        </li>

        <!-- Quản Lý Khách Hàng -->
        <li class="has-submenu {{ $isCustomerActive ? 'open' : '' }}">
            <a href="#" class="sidebar-link {{ $isCustomerActive ? 'active' : '' }}">
                <i class="fas fa-users"></i>
                <span>Khách Hàng</span>
            </a>
            <ul class="{{ $isCustomerActive ? 'show' : '' }}">
                <li>
                    <a href="{{ route('customers.index') }}" class="{{ $isCustomerActive ? 'active' : '' }}">
                        <i class="fas fa-user-circle"></i>
                        <span>Danh Sách KH</span>
                    </a>
                </li>
            </ul>
        </li>

        <!-- Quản Lý Hợp Đồng -->
        <li class="has-submenu {{ $isContractActive ? 'open' : '' }}">
            <a href="#" class="sidebar-link {{ $isContractActive ? 'active' : '' }}">
                <i class="fas fa-file-contract"></i>
                <span>Hợp Đồng</span>
            </a>
            <ul class="{{ $isContractActive ? 'show' : '' }}">
                <li>
                    <a href="{{ route('contracts.index') }}" class="{{ $isContractActive ? 'active' : '' }}">
                        <i class="fas fa-scroll"></i>
                        <span>Danh Sách HĐ</span>
                    </a>
                </li>
            </ul>
        </li>

        <!-- Quản Lý Tài Chính -->
        <li class="has-submenu {{ $isFinanceMenuActive ? 'open' : '' }}">
            <a href="#" class="sidebar-link {{ $isFinanceMenuActive ? 'active' : '' }}">
                <i class="fas fa-wallet"></i>
                <span>Tài Chính</span>
            </a>
            <ul class="{{ $isFinanceMenuActive ? 'show' : '' }}">
                <li>
                    <a href="{{ route('invoices.index') }}" class="{{ $isInvoiceActive ? 'active' : '' }}">
                        <i class="fas fa-receipt"></i>
                        <span>Hóa Đơn</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('transactions.index') }}" class="{{ $isTransactionActive ? 'active' : '' }}">
                        <i class="fas fa-exchange-alt"></i>
                        <span>Thu Chi</span>
                    </a>
                </li>
            </ul>
        </li>

        <!-- Báo Cáo & Thống Kê -->
        <li class="has-submenu {{ $isReportMenuActive ? 'open' : '' }}">
            <a href="#" class="sidebar-link {{ $isReportMenuActive ? 'active' : '' }}">
                <i class="fas fa-chart-bar"></i>
                <span>Báo Cáo</span>
            </a>
            <ul class="{{ $isReportMenuActive ? 'show' : '' }}">
                <li>
                    <a href="{{ route('reports.monthly') }}" class="{{ $isMonthlyReportActive ? 'active' : '' }}">
                        <i class="fas fa-calendar"></i>
                        <span>Báo Cáo Tháng</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('reports.yearly') }}" class="{{ $isYearlyReportActive ? 'active' : '' }}">
                        <i class="fas fa-calendar"></i>
                        <span>Báo Cáo Năm</span>
                    </a>
                </li>
            </ul>
        </li>
                {{-- Báo Cáo Quý đã bị loại bỏ - chỉ còn Tháng và Năm --}}

        <!-- Hệ Thống -->
        <li class="has-submenu {{ $isSystemMenuActive ? 'open' : '' }}">
            <a href="#" class="sidebar-link {{ $isSystemMenuActive ? 'active' : '' }}">
                <i class="fas fa-cog"></i>
                <span>Hệ Thống</span>
            </a>
            <ul class="{{ $isSystemMenuActive ? 'show' : '' }}">
                <li>
                    <a href="{{ route('profile') }}" class="{{ $isSystemMenuActive ? 'active' : '' }}">
                        <i class="fas fa-user-shield"></i>
                        <span>Tài Khoản</span>
                    </a>
                </li>
            </ul>
        </li>
    </ul>
</div>

<!-- Sidebar Toggle Button (Mobile) -->
<button class="sidebar-toggle d-md-none" id="sidebarToggle">
    <i class="fas fa-bars"></i>
</button>

<style>
    .sidebar-toggle {
        position: fixed;
        top: 15px;
        left: 15px;
        z-index: 2000;
        background: none;
        border: none;
        color: var(--dark);
        font-size: 20px;
        cursor: pointer;
        display: none;
    }

    @media (max-width: 768px) {
        .sidebar-toggle {
            display: block;
        }
    }
</style>
