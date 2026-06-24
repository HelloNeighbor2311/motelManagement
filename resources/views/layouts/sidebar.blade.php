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
            <a href="{{ route('dashboard') }}" class="sidebar-link">
                <i class="fas fa-chart-line"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <!-- Danh Mục Dữ Liệu -->
        <li class="has-submenu">
            <a href="#" class="sidebar-link">
                <i class="fas fa-database"></i>
                <span>Danh Mục Dữ Liệu</span>
            </a>
            <ul>
                <li>
                    <a href="{{ route('areas.index') }}">
                        <i class="fas fa-map"></i>
                        <span>Khu Vực</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('buildings.index') }}">
                        <i class="fas fa-home"></i>
                        <span>Tòa Nhà</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('apartments.index') }}">
                        <i class="fas fa-door-open"></i>
                        <span>Căn Hộ</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('apartments.floor-plan') }}">
                        <i class="fas fa-th-large"></i>
                        <span>Sơ Đồ Căn Hộ</span>
                    </a>
                </li>
            </ul>
        </li>

        <!-- Quản Lý Khách Hàng -->
        <li class="has-submenu">
            <a href="#" class="sidebar-link">
                <i class="fas fa-users"></i>
                <span>Khách Hàng</span>
            </a>
            <ul>
                <li>
                    <a href="{{ route('customers.index') }}">
                        <i class="fas fa-user-circle"></i>
                        <span>Danh Sách KH</span>
                    </a>
                </li>
            </ul>
        </li>

        <!-- Quản Lý Hợp Đồng -->
        <li class="has-submenu">
            <a href="#" class="sidebar-link">
                <i class="fas fa-file-contract"></i>
                <span>Hợp Đồng</span>
            </a>
            <ul>
                <li>
                    <a href="{{ route('contracts.index') }}">
                        <i class="fas fa-scroll"></i>
                        <span>Danh Sách HĐ</span>
                    </a>
                </li>
            </ul>
        </li>

        <!-- Quản Lý Tài Chính -->
        <li class="has-submenu">
            <a href="#" class="sidebar-link">
                <i class="fas fa-wallet"></i>
                <span>Tài Chính</span>
            </a>
            <ul>
                <li>
                    <a href="{{ route('invoices.index') }}">
                        <i class="fas fa-receipt"></i>
                        <span>Hóa Đơn</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('transactions.index') }}">
                        <i class="fas fa-exchange-alt"></i>
                        <span>Thu Chi</span>
                    </a>
                </li>
            </ul>
        </li>

        <!-- Báo Cáo & Thống Kê -->
        <li class="has-submenu">
            <a href="#" class="sidebar-link">
                <i class="fas fa-chart-bar"></i>
                <span>Báo Cáo</span>
            </a>
            <ul>
                <li>
                    <a href="{{ route('reports.monthly') }}">
                        <i class="fas fa-calendar"></i>
                        <span>Báo Cáo Tháng</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('reports.quarterly') }}">
                        <i class="fas fa-calendar"></i>
                        <span>Báo Cáo Quý</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('reports.yearly') }}">
                        <i class="fas fa-calendar"></i>
                        <span>Báo Cáo Năm</span>
                    </a>
                </li>
            </ul>
        </li>

        <!-- Hệ Thống -->
        <li class="has-submenu">
            <a href="#" class="sidebar-link">
                <i class="fas fa-cog"></i>
                <span>Hệ Thống</span>
            </a>
            <ul>
                <li>
                    <a href="{{ route('users.index') }}">
                        <i class="fas fa-user-shield"></i>
                        <span>Tài Khoản</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('roles.index') }}">
                        <i class="fas fa-key"></i>
                        <span>Phân Quyền</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('settings.index') }}">
                        <i class="fas fa-sliders-h"></i>
                        <span>Cài Đặt</span>
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
