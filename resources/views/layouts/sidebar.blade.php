@php
    $dataMenuOpen = request()->routeIs('areas.*', 'buildings.*', 'apartments.*');
    $customerMenuOpen = request()->routeIs('customers.*');
    $contractMenuOpen = request()->routeIs('contracts.*');
    $financeMenuOpen = request()->routeIs('invoices.*', 'transactions.*');
    $reportMenuOpen = request()->routeIs('reports.*');
    $systemMenuOpen = request()->routeIs('profile');
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
        <li class="has-submenu {{ $dataMenuOpen ? 'open' : '' }}">
            <a href="#" class="sidebar-link {{ $dataMenuOpen ? 'active' : '' }}">
                <i class="fas fa-database"></i>
                <span>Danh Mục Dữ Liệu</span>
            </a>
            <ul class="{{ $dataMenuOpen ? 'show' : '' }}">
                <li>
                    <a href="{{ route('areas.index') }}" class="{{ request()->routeIs('areas.*') ? 'active' : '' }}">
                        <i class="fas fa-map"></i>
                        <span>Khu Vực</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('buildings.index') }}" class="{{ request()->routeIs('buildings.*') ? 'active' : '' }}">
                        <i class="fas fa-home"></i>
                        <span>Tòa Nhà</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('apartments.index') }}" class="{{ request()->routeIs('apartments.index') ? 'active' : '' }}">
                        <i class="fas fa-door-open"></i>
                        <span>Căn Hộ</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('apartments.floor-plan') }}" class="{{ request()->routeIs('apartments.floor-plan') ? 'active' : '' }}">
                        <i class="fas fa-th-large"></i>
                        <span>Sơ Đồ Căn Hộ</span>
                    </a>
                </li>
            </ul>
        </li>

        <!-- Quản Lý Khách Hàng -->
        <li class="has-submenu {{ $customerMenuOpen ? 'open' : '' }}">
            <a href="#" class="sidebar-link {{ $customerMenuOpen ? 'active' : '' }}">
                <i class="fas fa-users"></i>
                <span>Khách Hàng</span>
            </a>
            <ul class="{{ $customerMenuOpen ? 'show' : '' }}">
                <li>
                    <a href="{{ route('customers.index') }}" class="{{ request()->routeIs('customers.*') ? 'active' : '' }}">
                        <i class="fas fa-user-circle"></i>
                        <span>Danh Sách KH</span>
                    </a>
                </li>
            </ul>
        </li>

        <!-- Quản Lý Hợp Đồng -->
        <li class="has-submenu {{ $contractMenuOpen ? 'open' : '' }}">
            <a href="#" class="sidebar-link {{ $contractMenuOpen ? 'active' : '' }}">
                <i class="fas fa-file-contract"></i>
                <span>Hợp Đồng</span>
            </a>
            <ul class="{{ $contractMenuOpen ? 'show' : '' }}">
                <li>
                    <a href="{{ route('contracts.index') }}" class="{{ request()->routeIs('contracts.*') ? 'active' : '' }}">
                        <i class="fas fa-scroll"></i>
                        <span>Danh Sách HĐ</span>
                    </a>
                </li>
            </ul>
        </li>

        <!-- Quản Lý Tài Chính -->
        <li class="has-submenu {{ $financeMenuOpen ? 'open' : '' }}">
            <a href="#" class="sidebar-link {{ $financeMenuOpen ? 'active' : '' }}">
                <i class="fas fa-wallet"></i>
                <span>Tài Chính</span>
            </a>
            <ul class="{{ $financeMenuOpen ? 'show' : '' }}">
                <li>
                    <a href="{{ route('invoices.index') }}" class="{{ request()->routeIs('invoices.*') ? 'active' : '' }}">
                        <i class="fas fa-receipt"></i>
                        <span>Hóa Đơn</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('transactions.index') }}" class="{{ request()->routeIs('transactions.*') ? 'active' : '' }}">
                        <i class="fas fa-exchange-alt"></i>
                        <span>Thu Chi</span>
                    </a>
                </li>
            </ul>
        </li>

        <!-- Báo Cáo & Thống Kê -->
        <li class="has-submenu {{ $reportMenuOpen ? 'open' : '' }}">
            <a href="#" class="sidebar-link {{ $reportMenuOpen ? 'active' : '' }}">
                <i class="fas fa-chart-bar"></i>
                <span>Báo Cáo</span>
            </a>
            <ul class="{{ $reportMenuOpen ? 'show' : '' }}">
                <li>
                    <a href="{{ route('reports.monthly') }}" class="{{ request()->routeIs('reports.monthly') ? 'active' : '' }}">
                        <i class="fas fa-calendar"></i>
                        <span>Báo Cáo Tháng</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('reports.yearly') }}" class="{{ request()->routeIs('reports.yearly') ? 'active' : '' }}">
                        <i class="fas fa-calendar"></i>
                        <span>Báo Cáo Năm</span>
                    </a>
                </li>
            </ul>
        </li>
                {{-- Báo Cáo Quý đã bị loại bỏ - chỉ còn Tháng và Năm --}}

        <!-- Hệ Thống -->
        <li class="has-submenu {{ $systemMenuOpen ? 'open' : '' }}">
            <a href="#" class="sidebar-link {{ $systemMenuOpen ? 'active' : '' }}">
                <i class="fas fa-cog"></i>
                <span>Hệ Thống</span>
            </a>
            <ul class="{{ $systemMenuOpen ? 'show' : '' }}">
                <li>
                    <a href="{{ route('profile') }}" class="{{ request()->routeIs('profile') ? 'active' : '' }}">
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
