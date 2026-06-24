<nav class="navbar">
    <!-- Search Bar -->
    <div class="navbar-search d-none d-lg-block">
        <input type="text" placeholder="Tìm kiếm..." id="globalSearch">
        <i class="fas fa-search" style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); color: var(--secondary);"></i>
    </div>

    <!-- Navbar Menu (Right) -->
    <ul class="navbar-menu ms-auto">
        <!-- Notifications -->
        <li class="notification-bell">
            <button id="notificationBell" title="Thông báo">
                <i class="fas fa-bell"></i>
                <span class="badge bg-danger">3</span>
            </button>
            <div class="notification-dropdown hidden">
                <div style="background: white; border-radius: 8px; min-width: 350px; max-height: 400px; overflow-y: auto; box-shadow: 0 4px 12px rgba(0,0,0,0.15);">
                    <div style="padding: 16px; border-bottom: 1px solid #e0e0e0;">
                        <h6 style="margin: 0; font-weight: 600;">Thông Báo</h6>
                    </div>
                    <div style="padding: 0;">
                        <div style="padding: 12px 16px; border-bottom: 1px solid #f0f0f0; cursor: pointer; transition: background-color 0.3s;" class="notification-item">
                            <div style="font-weight: 500; font-size: 13px; color: #343A40;">Hóa đơn sắp đến hạn</div>
                            <div style="font-size: 12px; color: #6C757D; margin-top: 4px;">3 hóa đơn cần thanh toán</div>
                            <div style="font-size: 11px; color: #aaa; margin-top: 4px;">5 phút trước</div>
                        </div>
                        <div style="padding: 12px 16px; border-bottom: 1px solid #f0f0f0; cursor: pointer; transition: background-color 0.3s;" class="notification-item">
                            <div style="font-weight: 500; font-size: 13px; color: #343A40;">Hợp đồng sắp hết hạn</div>
                            <div style="font-size: 12px; color: #6C757D; margin-top: 4px;">1 hợp đồng sắp hết hạn</div>
                            <div style="font-size: 11px; color: #aaa; margin-top: 4px;">1 giờ trước</div>
                        </div>
                        <div style="padding: 12px 16px; border-bottom: 1px solid #f0f0f0; cursor: pointer; transition: background-color 0.3s;" class="notification-item">
                            <div style="font-weight: 500; font-size: 13px; color: #343A40;">Khách hàng mới</div>
                            <div style="font-size: 12px; color: #6C757D; margin-top: 4px;">2 khách hàng đăng ký</div>
                            <div style="font-size: 11px; color: #aaa; margin-top: 4px;">3 giờ trước</div>
                        </div>
                    </div>
                    <div style="padding: 12px 16px; border-top: 1px solid #e0e0e0; text-align: center;">
                        <a href="#" style="color: var(--primary); font-size: 13px; font-weight: 500;">Xem tất cả</a>
                    </div>
                </div>
            </div>
        </li>

        <!-- User Dropdown -->
        <li class="user-dropdown">
            <div class="user-avatar" title="Menu người dùng">
                <i class="fas fa-user"></i>
            </div>
            <div class="dropdown-menu">
                <a href="{{ route('profile') }}">
                    <i class="fas fa-user-circle"></i>
                    <span>Hồ sơ cá nhân</span>
                </a>
                <!-- Settings removed per request -->
                <hr style="margin: 8px 0;">
                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Đăng xuất</span>
                </a>
            </div>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </li>
    </ul>
</nav>

<style>
    .notification-dropdown {
        position: absolute;
        top: 60px;
        right: 80px;
        z-index: 1000;
        margin-top: 8px;
    }

    .notification-dropdown.hidden {
        display: none;
    }

    .notification-item:hover {
        background-color: #f8f9fa;
    }

    .navbar {
        position: relative;
    }

    .navbar-search {
        position: relative;
    }

    .navbar-search input {
        padding-right: 35px;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const notificationBell = document.getElementById('notificationBell');
        const notificationDropdown = document.querySelector('.notification-dropdown');

        if (notificationBell) {
            notificationBell.addEventListener('click', function(e) {
                e.stopPropagation();
                notificationDropdown.classList.toggle('hidden');
            });

            document.addEventListener('click', function(e) {
                if (!e.target.closest('.notification-bell')) {
                    notificationDropdown.classList.add('hidden');
                }
            });
        }

        // Global Search
        const globalSearch = document.getElementById('globalSearch');
        if (globalSearch) {
            globalSearch.addEventListener('keyup', function(e) {
                if (e.key === 'Enter') {
                    // Implement search logic
                    console.log('Search:', this.value);
                }
            });
        }
    });
</script>
