<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Sistem Akademik</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #4f46e5;
            --primary-dark: #4338ca;
            --secondary: #06b6d4;
        }

        body {
            background-color: #f9fafb;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .container-fluid {
            padding: 0;
        }

        .sidebar {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            min-height: 100vh;
            padding: 20px;
            position: fixed;
            width: 250px;
            left: 0;
            top: 0;
        }

        .sidebar-brand {
            color: white;
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 30px;
            padding: 20px;
            text-align: center;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .sidebar-menu {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sidebar-menu li {
            margin-bottom: 10px;
        }

        .sidebar-menu a {
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            display: block;
            padding: 12px 15px;
            border-radius: 8px;
            transition: all 0.3s;
        }

        .sidebar-menu a:hover,
        .sidebar-menu a.active {
            background: rgba(255, 255, 255, 0.2);
            color: white;
        }

        .main-content {
            margin-left: 250px;
            padding: 0;
        }

        .topbar {
            background: white;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .topbar h2 {
            margin: 0;
            color: #111827;
            font-weight: 600;
        }

        .user-menu {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--primary);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
        }

        .content {
            padding: 30px;
        }

        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            margin-bottom: 20px;
        }

        .card-header {
            background: white;
            border: none;
            padding: 20px;
            font-weight: 600;
            color: #111827;
        }

        .card-body {
            padding: 20px;
        }

        .btn-logout {
            background: #ef4444;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-logout:hover {
            background: #dc2626;
            color: white;
        }

        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            text-align: center;
            margin-bottom: 20px;
        }

        .stat-card h4 {
            color: #6b7280;
            font-size: 14px;
            margin: 0 0 10px 0;
        }

        .stat-card .number {
            font-size: 32px;
            font-weight: 700;
            color: var(--primary);
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-auto sidebar">
                <div class="sidebar-brand">
                    <i class="fas fa-graduation-cap"></i> Akademik
                </div>
                <ul class="sidebar-menu">
                    <li><a href="{{ route('dashboard') }}" class="active"><i class="fas fa-home"></i> Dashboard</a></li>
                    <li><a href="{{ route('admin') }}"><i class="fas fa-cog"></i> Admin Panel</a></li>
                    <li><a href="{{ route('data-management') }}"><i class="fas fa-database"></i> Data Management</a></li>
                    <li><hr style="border-color: rgba(255,255,255,0.2); margin: 20px 0;"></li>
                    <li><a href="#" onclick="logout()"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
                </ul>
            </div>

            <!-- Main Content -->
            <div class="col main-content">
                <!-- Topbar -->
                <div class="topbar">
                    <h2>Dashboard</h2>
                    <div class="user-menu">
                        <span id="userName">{{ auth()->user()->name ?? 'User' }}</span>
                        <div class="user-avatar" id="userInitial">{{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}</div>
                    </div>
                </div>

                <!-- Content -->
                <div class="content">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="stat-card">
                                <h4>Mahasiswa</h4>
                                <div class="number" id="studentCount">-</div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="stat-card">
                                <h4>Instruktur</h4>
                                <div class="number" id="instructorCount">-</div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="stat-card">
                                <h4>Kelas</h4>
                                <div class="number" id="classCount">-</div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="stat-card">
                                <h4>Jadwal</h4>
                                <div class="number" id="scheduleCount">-</div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">Informasi Sistem</div>
                        <div class="card-body">
                            <p><strong>Status:</strong> <span class="badge bg-success">Online</span></p>
                            <p><strong>User:</strong> {{ auth()->user()->name ?? 'User' }}</p>
                            <p><strong>Role:</strong> <span class="badge bg-primary">{{ auth()->user()->role ?? 'User' }}</span></p>
                            <p><strong>Email:</strong> {{ auth()->user()->email ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // ========== AUTH CHECK ==========
        // Protect page: redirect to login if no token
        function checkAuth() {
            const token = localStorage.getItem('auth_token');
            if (!token) {
                console.log('No token found, redirecting to login');
                window.location.href = '{{ route("login") }}';
                return false;
            }
            return true;
        }

        // Check auth on page load
        document.addEventListener('DOMContentLoaded', () => {
            if (!checkAuth()) return;
            loadStats();
        });

        // ========== REST OF CODE ==========
        const API_BASE = '{{ config("app.url") }}/api';

        function loadStats() {
            const user = JSON.parse(localStorage.getItem('user') || '{}');
            document.getElementById('userName').textContent = user.name || 'User';
            document.getElementById('userRole').textContent = (user.role || 'user').toUpperCase();
        }

        function logout() {
            if (confirm('Yakin ingin logout?')) {
                localStorage.removeItem('auth_token');
                localStorage.removeItem('user');
                window.location.href = '{{ route("login") }}';
            }
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
