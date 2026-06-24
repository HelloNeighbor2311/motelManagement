<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Quản Lý Phòng Trọ' }} - Motel Management System</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <style>
        :root {
            --auth-bg-1: #0f172a;
            --auth-bg-2: #1e293b;
            --auth-accent: #0d6efd;
        }

        * {
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background:
                radial-gradient(circle at top left, rgba(13, 110, 253, 0.22), transparent 34%),
                radial-gradient(circle at bottom right, rgba(13, 202, 240, 0.16), transparent 30%),
                linear-gradient(135deg, var(--auth-bg-1), var(--auth-bg-2));
            color: #1f2937;
        }

        .auth-shell {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }

        .auth-card {
            width: 100%;
            max-width: 460px;
            background: rgba(255, 255, 255, 0.96);
            border: 1px solid rgba(255, 255, 255, 0.35);
            border-radius: 24px;
            box-shadow: 0 24px 80px rgba(15, 23, 42, 0.35);
            overflow: hidden;
            backdrop-filter: blur(10px);
        }

        .auth-card__header {
            padding: 28px 28px 18px;
            text-align: center;
            background: linear-gradient(135deg, rgba(13, 110, 253, 0.12), rgba(13, 202, 240, 0.12));
        }

        .auth-mark {
            width: 56px;
            height: 56px;
            border-radius: 16px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #0d6efd, #3b82f6);
            color: #fff;
            box-shadow: 0 10px 25px rgba(13, 110, 253, 0.35);
            font-size: 24px;
            margin-bottom: 14px;
        }

        .auth-title {
            margin: 0;
            font-size: 28px;
            font-weight: 800;
            color: #0f172a;
        }

        .auth-subtitle {
            margin: 8px 0 0;
            color: #64748b;
            font-size: 14px;
        }

        .auth-card__body {
            padding: 28px;
        }

        .auth-footer {
            padding: 0 28px 28px;
            color: #64748b;
            font-size: 14px;
        }

        .form-control,
        .form-select {
            border-radius: 14px;
            padding: 0.85rem 1rem;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: rgba(13, 110, 253, 0.55);
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.12);
        }

        .btn-auth {
            border-radius: 14px;
            padding: 0.85rem 1rem;
            font-weight: 700;
        }

        .auth-link {
            color: var(--auth-accent);
            text-decoration: none;
            font-weight: 600;
        }

        .auth-link:hover {
            text-decoration: underline;
        }

        .auth-help {
            font-size: 13px;
            color: #64748b;
        }

        @media (max-width: 576px) {
            .auth-shell {
                padding: 16px;
            }

            .auth-card__header,
            .auth-card__body,
            .auth-footer {
                padding-left: 20px;
                padding-right: 20px;
            }
        }
    </style>
</head>
<body>
    <main class="auth-shell">
        <div class="auth-card">
            <div class="auth-card__header">
                <div class="auth-mark">
                    <i class="fas fa-building"></i>
                </div>
                <h1 class="auth-title">Quản Lý Phòng Trọ</h1>
                <p class="auth-subtitle">Motel Management System</p>
            </div>

            <div class="auth-card__body">
                @if ($errors->any())
                    <div class="alert alert-danger border-0 rounded-3 mb-4">
                        <div class="fw-bold mb-1">Vui lòng kiểm tra lại thông tin</div>
                        <ul class="mb-0 ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
            </div>

            @hasSection('footer')
                <div class="auth-footer">
                    @yield('footer')
                </div>
            @endif
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
