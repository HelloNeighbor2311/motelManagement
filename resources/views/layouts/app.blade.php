<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Quản Lý Phòng Trọ' }} - Motel Management System</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome 6 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    @vite(['resources/css/app.css', 'resources/css/custom.scss'])

    <style>
        :root {
            --primary: #0066CC;
            --success: #28A745;
            --warning: #FFC107;
            --danger: #DC3545;
            --info: #17A2B8;
            --secondary: #6C757D;
            --light: #F8F9FA;
            --dark: #343A40;
            --white: #FFFFFF;
        }
    </style>
</head>
<body>
    <div class="app-wrapper">
        <!-- Sidebar -->
        @include('layouts.sidebar')

        <div class="main-content" id="mainContent">
            <!-- Navbar -->
            @include('layouts.navbar')

            <!-- Page Content -->
            <div class="page-content">
                @yield('content')
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- jQuery (Optional, for DataTables) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- DataTables -->
    <link href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css" rel="stylesheet">
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

    <!-- Custom JavaScript -->
    <script>
        // Sidebar Toggle
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebar = document.querySelector('.sidebar');
            const mainContent = document.getElementById('mainContent');

            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', function() {
                    sidebar.classList.toggle('collapsed');
                    mainContent.classList.toggle('sidebar-collapsed');
                });
            }

            // Submenu Toggle
            const menuItems = document.querySelectorAll('.sidebar-menu li.has-submenu > a');
            menuItems.forEach(item => {
                item.addEventListener('click', function(e) {
                    e.preventDefault();
                    const parent = this.parentElement;
                    parent.classList.toggle('open');
                    const submenu = parent.querySelector('ul');
                    submenu.classList.toggle('show');
                });
            });

            // User Dropdown
            const userAvatar = document.querySelector('.user-dropdown .user-avatar');
            const dropdownMenu = document.querySelector('.user-dropdown .dropdown-menu');
            
            if (userAvatar) {
                userAvatar.addEventListener('click', function(e) {
                    e.stopPropagation();
                    dropdownMenu.classList.toggle('show');
                });

                document.addEventListener('click', function(e) {
                    if (!e.target.closest('.user-dropdown')) {
                        dropdownMenu.classList.remove('show');
                    }
                });
            }

            // Active Menu Item
            const currentPath = window.location.pathname;
            document.querySelectorAll('.sidebar-menu a').forEach(link => {
                if (link.getAttribute('href') === currentPath) {
                    link.classList.add('active');
                    const parent = link.closest('li.has-submenu');
                    if (parent) {
                        parent.classList.add('open');
                        parent.querySelector('ul').classList.add('show');
                    }
                }
            });
        });

        // Global Alert Function
        function showAlert(title, message, type = 'info') {
            Swal.fire({
                title: title,
                text: message,
                icon: type,
                confirmButtonColor: '#0066CC'
            });
        }

        // Global Confirm Dialog
        function showConfirm(title, message, callback) {
            Swal.fire({
                title: title,
                text: message,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#DC3545',
                cancelButtonColor: '#6C757D',
                confirmButtonText: 'Xóa',
                cancelButtonText: 'Hủy'
            }).then((result) => {
                if (result.isConfirmed) {
                    callback();
                }
            });
        }
    </script>

    @stack('scripts')
</body>
</html>
