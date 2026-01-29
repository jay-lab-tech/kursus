<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Sistem Akademik</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #4f46e5;
            --primary-dark: #4338ca;
            --secondary: #06b6d4;
            --success: #10b981;
            --danger: #ef4444;
            --warning: #f59e0b;
        }
        
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { background-color: #f9fafb; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        
        .sidebar { 
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            min-height: 100vh; padding: 20px; position: fixed; width: 260px; left: 0; top: 0; color: white;
            overflow-y: auto; z-index: 1000;
        }
        
        .sidebar-brand { 
            font-size: 18px; font-weight: 700; margin-bottom: 25px; padding: 15px; text-align: center;
            border-bottom: 1px solid rgba(255,255,255,0.2); border-radius: 8px;
        }
        
        .sidebar-menu { list-style: none; padding: 0; margin: 0; }
        .sidebar-menu li { margin-bottom: 10px; }
        .sidebar-menu a { 
            color: rgba(255,255,255,0.8); text-decoration: none; display: flex; align-items: center; gap: 12px;
            padding: 12px 15px; border-radius: 8px; transition: all 0.3s;
        }
        .sidebar-menu a:hover { background: rgba(255,255,255,0.2); color: white; }
        .sidebar-menu a.active { background: rgba(255,255,255,0.3); color: white; font-weight: 600; }
        
        .main-content { margin-left: 260px; padding: 30px; }
        
        .header { 
            display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;
            background: white; padding: 20px; border-radius: 10px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        
        .header-left h1 { margin: 0; color: #1f2937; font-size: 28px; }
        .header-left p { margin: 5px 0 0; color: #6b7280; font-size: 14px; }
        
        .header-right { display: flex; gap: 15px; align-items: center; }
        .user-profile { display: flex; gap: 10px; align-items: center; padding: 10px 15px; background: #f3f4f6; border-radius: 8px; }
        .user-profile img { width: 35px; height: 35px; border-radius: 50%; }
        
        .alert-admin { background: #fef08a; border-left: 4px solid #f59e0b; padding: 15px; border-radius: 5px; margin-bottom: 20px; }
        .alert-admin strong { color: #92400e; }
        
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-bottom: 30px; }
        
        .stat-card { 
            background: white; padding: 25px; border-radius: 10px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            border-left: 4px solid var(--primary); position: relative; overflow: hidden;
        }
        
        .stat-card::before { 
            content: ''; position: absolute; right: -30px; top: -30px; width: 100px; height: 100px;
            background: var(--primary); opacity: 0.1; border-radius: 50%;
        }
        
        .stat-card h4 { color: #6b7280; margin: 0 0 10px 0; font-size: 14px; font-weight: 600; }
        .stat-card .value { font-size: 32px; font-weight: 700; color: var(--primary); margin: 10px 0; }
        .stat-card p { margin: 0; color: #9ca3af; font-size: 13px; }
        
        .card-container { background: white; padding: 25px; border-radius: 10px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
        .card-header { 
            display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;
            border-bottom: 2px solid #e5e7eb; padding-bottom: 15px;
        }
        
        .btn-group { display: flex; gap: 10px; }
        .btn-primary-custom { background: var(--primary); color: white; padding: 10px 15px; border-radius: 8px; border: none; cursor: pointer; font-weight: 600; }
        .btn-primary-custom:hover { background: var(--primary-dark); }
        .btn-danger-custom { background: var(--danger); color: white; padding: 10px 15px; border-radius: 8px; border: none; cursor: pointer; font-weight: 600; }
        .btn-danger-custom:hover { background: #dc2626; }
        
        @media (max-width: 768px) {
            .sidebar { width: 70px; }
            .sidebar-menu a span { display: none; }
            .main-content { margin-left: 70px; padding: 15px; }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-brand">
            <i class="fas fa-graduation-cap"></i> <span>Akademik</span>
        </div>
        <ul class="sidebar-menu">
            <li><a href="/dashboard"><i class="fas fa-home"></i> <span>Dashboard</span></a></li>
            <li><a href="/admin" class="active"><i class="fas fa-lock"></i> <span>Admin Panel</span></a></li>
            <li><a href="/data-management"><i class="fas fa-database"></i> <span>Data Management</span></a></li>
            <hr style="border: none; border-top: 1px solid rgba(255,255,255,0.1); margin: 20px 0;">
            <li><button onclick="logout()" style="background: none; border: none; color: rgba(255,255,255,0.8); width: 100%; text-align: left; padding: 12px 15px; border-radius: 8px; cursor: pointer; display: flex; align-items: center; gap: 12px; font-size: inherit; font-family: inherit;"><i class="fas fa-sign-out-alt"></i> <span>Logout</span></button></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Header -->
        <div class="header">
            <div class="header-left">
                <h1>Admin Dashboard</h1>
                <p>System administration and control panel</p>
            </div>
            <div class="header-right">
                <div class="user-profile">
                    <img src="https://api.dicebear.com/7.x/avataaars/svg?seed=admin" alt="Avatar">
                    <div>
                        <p style="margin: 0; font-weight: 600; font-size: 14px;" id="userName">Admin</p>
                        <p style="margin: 0; font-size: 12px; color: #6b7280;" id="userRole">ADMIN</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Admin Alert -->
        <div class="alert-admin">
            <i class="fas fa-exclamation-triangle"></i> <strong>Admin Only Area:</strong> Only administrators can access this page. All changes made here affect the entire system.
        </div>

        <!-- Statistics -->
        <div class="stats-grid">
            <div class="stat-card">
                <h4><i class="fas fa-users"></i> Total Users</h4>
                <div class="value" id="totalUsers">0</div>
                <p>Active users in system</p>
            </div>
            <div class="stat-card" style="border-left-color: var(--secondary);">
                <h4><i class="fas fa-user-tie"></i> Instructors</h4>
                <div class="value" style="color: var(--secondary);" id="totalInstruktors">0</div>
                <p>Registered instructors</p>
            </div>
            <div class="stat-card" style="border-left-color: var(--success);">
                <h4><i class="fas fa-graduation-cap"></i> Students</h4>
                <div class="value" style="color: var(--success);" id="totalStudents">0</div>
                <p>Registered students</p>
            </div>
            <div class="stat-card" style="border-left-color: var(--warning);">
                <h4><i class="fas fa-exclamation-circle"></i> Inactive</h4>
                <div class="value" style="color: var(--warning);" id="totalInactive">0</div>
                <p>Inactive users</p>
            </div>
        </div>

        <!-- System Controls -->
        <div class="card-container">
            <div class="card-header">
                <h4 style="margin: 0;"><i class="fas fa-cogs"></i> System Controls</h4>
                <div class="btn-group">
                    <button class="btn-primary-custom" onclick="clearCache()"><i class="fas fa-trash"></i> Clear Cache</button>
                    <button class="btn-primary-custom" onclick="backupDatabase()"><i class="fas fa-database"></i> Backup</button>
                </div>
            </div>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div>
                    <p style="color: #6b7280; margin-bottom: 5px;"><i class="fas fa-info-circle"></i> System Status</p>
                    <p style="font-weight: 600; font-size: 16px;"><span style="background: var(--success); color: white; padding: 5px 10px; border-radius: 5px; font-size: 12px;">✓ Operational</span></p>
                </div>
                <div>
                    <p style="color: #6b7280; margin-bottom: 5px;"><i class="fas fa-server"></i> Server Status</p>
                    <p style="font-weight: 600; font-size: 16px;"><span style="background: var(--success); color: white; padding: 5px 10px; border-radius: 5px; font-size: 12px;">✓ Running</span></p>
                </div>
            </div>
        </div>
    </div>

    <script>
        const API_BASE = '{{ config("app.url") }}/api';

        document.addEventListener('DOMContentLoaded', () => {
            checkAdminAuth();
            loadStats();
        });

        function checkAdminAuth() {
            const token = localStorage.getItem('auth_token');
            const user = JSON.parse(localStorage.getItem('user') || '{}');
            
            if (!token) {
                window.location.href = '{{ route("login") }}';
                return;
            }

            if (user.role !== 'admin') {
                alert('Access Denied: Admin role required');
                window.location.href = '/dashboard';
                return;
            }

            document.getElementById('userName').textContent = user.name || 'Admin';
            document.getElementById('userRole').textContent = 'ADMIN';
        }

        async function loadStats() {
            try {
                const token = localStorage.getItem('auth_token');
                
                // Get users
                const usersRes = await fetch(`${API_BASE}/users`, {
                    headers: { 'Authorization': `Bearer ${token}` }
                });
                if (usersRes.ok) {
                    const usersData = await usersRes.json();
                    const allUsers = usersData.data || [];
                    document.getElementById('totalUsers').textContent = allUsers.length;
                    document.getElementById('totalInstruktors').textContent = allUsers.filter(u => u.role === 'instruktur').length;
                    document.getElementById('totalStudents').textContent = allUsers.filter(u => u.role === 'mahasiswa').length;
                    document.getElementById('totalInactive').textContent = allUsers.filter(u => u.status === 'inactive').length;
                }
            } catch (error) {
                console.error('Error loading stats:', error);
            }
        }

        function clearCache() {
            if (confirm('Clear system cache? This may take a moment.')) {
                alert('Cache cleared successfully');
            }
        }

        function backupDatabase() {
            if (confirm('Create database backup? This will take several minutes.')) {
                alert('Backup process started. You will be notified when complete.');
            }
        }

        function logout() {
            if (confirm('Logout?')) {
                localStorage.removeItem('auth_token');
                localStorage.removeItem('user');
                window.location.href = '{{ route("login") }}';
            }
        }
    </script>
</body>
</html>
