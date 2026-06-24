<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom" style="position: fixed; top: 0; left: 250px; right: 0; height: 60px; z-index: 999; padding: 0 1rem;">
    <!-- Search Bar -->
    <div class="d-none d-lg-block">
        <div class="input-group" style="max-width: 400px;">
            <input type="text" class="form-control form-control-sm" placeholder="Tìm kiếm..." id="globalSearch">
            <span class="input-group-text"><i class="fas fa-search"></i></span>
        </div>
    </div>

    <!-- Navbar Menu (Right) -->
    <ul class="navbar-nav ms-auto">
        <!-- Notifications -->
        <li class="nav-item">
            <button class="btn btn-link" id="notificationBell" title="Thông báo" style="text-decoration: none; color: inherit; position: relative;">
                <i class="fas fa-bell"></i>
                <span class="badge bg-danger position-absolute" style="top: -5px; right: -10px;">3</span>
            </button>
            <div class="dropdown-menu dropdown-menu-end" id="notificationDropdown" style="min-width: 350px; max-height: 400px; overflow-y: auto; display: none; position: absolute; top: 45px; right: 10px;">
                <div class="p-3 border-bottom">
                    <h6 class="mb-0 fw-bold">Thông Báo</h6>
                </div>
                <div>
                    <div class="px-3 py-2 border-bottom notification-item" style="cursor: pointer;">
                        <div class="fw-bold small">Hóa đơn sắp đến hạn</div>
                        <div class="text-muted small">3 hóa đơn cần thanh toán</div>
                        <div class="text-secondary" style="font-size: 11px;">5 phút trước</div>
                    </div>
                    <div class="px-3 py-2 border-bottom notification-item" style="cursor: pointer;">
                        <div class="fw-bold small">Hợp đồng sắp hết hạn</div>
                        <div class="text-muted small">1 hợp đồng sắp hết hạn</div>
                        <div class="text-secondary" style="font-size: 11px;">1 giờ trước</div>
                    </div>
                    <div class="px-3 py-2 border-bottom notification-item" style="cursor: pointer;">
                        <div class="fw-bold small">Khách hàng mới</div>
                        <div class="text-muted small">2 khách hàng đăng ký</div>
                        <div class="text-secondary" style="font-size: 11px;">3 giờ trước</div>
                    </div>
                </div>
                <div class="p-3 border-top text-center">
                    <a href="#" class="text-primary small fw-bold" style="text-decoration: none;">Xem tất cả</a>
                </div>
            </div>
        </li>

        <!-- User Dropdown -->
        <li class="nav-item">
            <button class="btn btn-link" id="userDropdown" title="Menu người dùng" style="text-decoration: none; color: inherit;">
                <i class="fas fa-user"></i>
            </button>
            <div class="dropdown-menu dropdown-menu-end" id="userDropdownMenu" style="display: none; position: absolute; top: 45px; right: 0;">
                <a href="{{ route('profile') }}" class="dropdown-item">
                    <i class="fas fa-user-circle"></i>
                    <span>Hồ sơ cá nhân</span>
                </a>
                <hr class="dropdown-divider">
                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="dropdown-item">
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
    .notification-item:hover {
        background-color: #f8f9fa;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const notificationBell = document.getElementById('notificationBell');
        const notificationDropdown = document.getElementById('notificationDropdown');
        const userDropdown = document.getElementById('userDropdown');
        const userDropdownMenu = document.getElementById('userDropdownMenu');

        if (notificationBell && notificationDropdown) {
            notificationBell.addEventListener('click', function(e) {
                e.stopPropagation();
                notificationDropdown.style.display = notificationDropdown.style.display === 'none' ? 'block' : 'none';
                userDropdownMenu.style.display = 'none';
            });

            document.addEventListener('click', function(e) {
                if (!e.target.closest('#notificationBell') && !e.target.closest('#notificationDropdown')) {
                    notificationDropdown.style.display = 'none';
                }
            });
        }

        if (userDropdown && userDropdownMenu) {
            userDropdown.addEventListener('click', function(e) {
                e.stopPropagation();
                userDropdownMenu.style.display = userDropdownMenu.style.display === 'none' ? 'block' : 'none';
                notificationDropdown.style.display = 'none';
            });

            document.addEventListener('click', function(e) {
                if (!e.target.closest('#userDropdown') && !e.target.closest('#userDropdownMenu')) {
                    userDropdownMenu.style.display = 'none';
                }
            });
        }

        // Global Search
        const globalSearch = document.getElementById('globalSearch');
        if (globalSearch) {
            globalSearch.addEventListener('keyup', function(e) {
                if (e.key === 'Enter') {
                    console.log('Search:', this.value);
                }
            });
        }
    });
</script>
