<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Sistem Akademik</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #4f46e5;
            --primary-dark: #4338ca;
            --secondary: #06b6d4;
        }
        body { background-color: #f9fafb; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .sidebar { background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%); min-height: 100vh; padding: 20px; position: fixed; width: 250px; left: 0; top: 0; color: white; }
        .sidebar-brand { font-size: 20px; font-weight: 700; margin-bottom: 30px; padding: 20px; text-align: center; border-bottom: 1px solid rgba(255,255,255,0.1); }
        .main-content { margin-left: 250px; padding: 30px; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
        .header h1 { margin: 0; color: #1f2937; }
        .user-menu { display: flex; gap: 15px; align-items: center; }
        .admin-card { background: white; padding: 20px; border-radius: 10px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); margin-bottom: 20px; }
        .stat-box { background: white; padding: 20px; border-radius: 10px; text-align: center; box-shadow: 0 1px 3px rgba(0,0,0,0.1); margin-bottom: 20px; }
        .stat-number { font-size: 28px; font-weight: 700; color: var(--primary); }
        .stat-label { color: #6b7280; font-size: 14px; margin-top: 5px; }
        button { cursor: pointer; }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-brand">
            <i class="fas fa-graduation-cap"></i> Admin Panel
        </div>
        <ul class="list-group list-group-flush">
            <li class="list-group-item" style="background: transparent; border: 0; padding: 10px;"><button onclick="return false;" style="background: none; border: none; color: white; text-decoration: none; cursor: pointer; font-size: 14px;"><i class="fas fa-tachometer-alt"></i> Dashboard</button></li>
            <li class="list-group-item" style="background: transparent; border: 0; padding: 10px;"><button onclick="return false;" style="background: none; border: none; color: white; text-decoration: none; cursor: pointer; font-size: 14px;"><i class="fas fa-users"></i> Users</button></li>
            <li class="list-group-item" style="background: transparent; border: 0; padding: 10px;"><button onclick="return false;" style="background: none; border: none; color: white; text-decoration: none; cursor: pointer; font-size: 14px;"><i class="fas fa-book"></i> Kelas</button></li>
            <li class="list-group-item" style="background: transparent; border: 0; padding: 10px;"><button onclick="return false;" style="background: none; border: none; color: white; text-decoration: none; cursor: pointer; font-size: 14px;"><i class="fas fa-file-alt"></i> Surat</button></li>
            <li class="list-group-item" style="background: transparent; border: 0; padding: 10px;"><button onclick="return false;" style="background: none; border: none; color: white; text-decoration: none; cursor: pointer; font-size: 14px;"><i class="fas fa-cog"></i> Settings</button></li>
        </ul>
        <div style="position: absolute; bottom: 20px; left: 20px; right: 20px;">
            <button onclick="logout()" class="btn btn-danger w-100"><i class="fas fa-sign-out-alt"></i> Logout</button>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="header">
            <div>
                <h1>Admin Dashboard</h1>
                <p class="text-muted">Sistem Manajemen Akademik</p>
            </div>
            <div class="user-menu">
                <div>
                    <p style="margin: 0; font-weight: 600;" id="userName">Loading...</p>
                    <p style="margin: 0; font-size: 12px; color: #6b7280;" id="userRole">ADMIN</p>
                </div>
                <img src="https://api.dicebear.com/7.x/avataaars/svg?seed=admin" style="width: 40px; height: 40px; border-radius: 50%;" alt="Avatar">
            </div>
        </div>

        <!-- Statistics -->
        <div class="row">
            <div class="col-md-3">
                <div class="stat-box">
                    <div class="stat-number" id="totalUsers">-</div>
                    <div class="stat-label">Total Users</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-box">
                    <div class="stat-number" id="totalKelas">-</div>
                    <div class="stat-label">Total Kelas</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-box">
                    <div class="stat-number" id="totalSurat">-</div>
                    <div class="stat-label">Total Surat</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-box">
                    <div class="stat-number" id="totalDokumentasi">-</div>
                    <div class="stat-label">Dokumentasi</div>
                </div>
            </div>
        </div>

        <!-- Admin Panel Info -->
        <div class="admin-card">
            <h5><i class="fas fa-info-circle"></i> Admin Information</h5>
            <p>Welcome to the Admin Dashboard. Use this panel to manage the academic system.</p>
            <div class="alert alert-info">
                <strong>Note:</strong> This is a simplified admin interface. Full admin features coming soon.
            </div>
        </div>
    </div>

    <script>
        // ========== AUTH CHECK ==========
        // Protect page: only admin can access
        function checkAuth() {
            const token = localStorage.getItem('auth_token');
            const user = JSON.parse(localStorage.getItem('user') || '{}');
            
            if (!token) {
                console.log('No token found, redirecting to login');
                window.location.href = '{{ route("login") }}';
                return false;
            }
            
            if (user.role !== 'admin') {
                console.log('Not admin, redirecting to dashboard');
                window.location.href = '{{ route("dashboard") }}';
                return false;
            }
            
            return true;
        }

        // Check auth on page load
        document.addEventListener('DOMContentLoaded', () => {
            if (!checkAuth()) return;
            loadAdminData();
        });

        // ========== LOAD ADMIN DATA ==========
        function loadAdminData() {
            const user = JSON.parse(localStorage.getItem('user') || '{}');
            document.getElementById('userName').textContent = user.name || 'Admin';
            
            // Load statistics from API
            loadStats();
        }

        async function loadStats() {
            const token = localStorage.getItem('auth_token');
            const headers = {
                'Authorization': `Bearer ${token}`,
                'Content-Type': 'application/json'
            };

            try {
                // Fetch users count
                const usersResp = await fetch('{{ config("app.url") }}/api/users', { headers });
                if (usersResp.ok) {
                    const users = await usersResp.json();
                    document.getElementById('totalUsers').textContent = Array.isArray(users.data) ? users.data.length : users.length || 0;
                }
            } catch (e) {
                console.log('Could not load users:', e);
                document.getElementById('totalUsers').textContent = '0';
            }

            // Set dummy data for now
            document.getElementById('totalKelas').textContent = '8';
            document.getElementById('totalSurat').textContent = '24';
            document.getElementById('totalDokumentasi').textContent = '15';
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
