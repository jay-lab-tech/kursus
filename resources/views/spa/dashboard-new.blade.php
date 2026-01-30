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
        
        @media (max-width: 768px) {
            .sidebar { width: 70px; }
            .sidebar-menu a span { display: none; }
            .main-content { margin-left: 70px; padding: 15px; }
            .header { flex-direction: column; gap: 15px; text-align: center; }
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
            <li><a href="/dashboard" class="active"><i class="fas fa-home"></i> <span>Dashboard</span></a></li>
            <li><a href="/kelas-browse"><i class="fas fa-book"></i> <span>Browse Kelas</span></a></li>
            <li><a href="/kelas-saya"><i class="fas fa-graduation-cap"></i> <span>Kelas Saya</span></a></li>
            <li style="margin-top: 20px;"><a href="/data-management"><i class="fas fa-database"></i> <span>Data Management</span></a></li>
            <li style="margin-top: 10px;"><a href="/admin" style="color: rgba(255,255,255,0.6);"><i class="fas fa-lock"></i> <span>Admin Panel</span></a></li>
            <li style="margin-top: 10px;"><a href="/risalah-dashboard-new" style="color: rgba(255,255,255,0.8);"><i class="fas fa-file-alt"></i> <span>Risalah</span></a></li>
            <hr style="border: none; border-top: 1px solid rgba(255,255,255,0.1); margin: 20px 0;">
            <li><button onclick="logout()" style="background: none; border: none; color: rgba(255,255,255,0.8); width: 100%; text-align: left; padding: 12px 15px; border-radius: 8px; cursor: pointer; display: flex; align-items: center; gap: 12px; font-size: inherit; font-family: inherit;"><i class="fas fa-sign-out-alt"></i> <span>Logout</span></button></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Header -->
        <div class="header">
            <div class="header-left">
                <h1>Dashboard</h1>
                <p>Welcome back! Here's your system overview</p>
            </div>
            <div class="header-right">
                <div class="user-profile">
                    <img src="https://api.dicebear.com/7.x/avataaars/svg?seed=user" alt="Avatar">
                    <div>
                        <p style="margin: 0; font-weight: 600; font-size: 14px;" id="userName">User</p>
                        <p style="margin: 0; font-size: 12px; color: #6b7280;" id="userRole">Role</p>
                    </div>
                </div>
                
            </div>
        </div>

        <!-- Statistics -->
        <div class="stats-grid" id="statsContainer">
            <!-- Will be populated by loadStats() based on role -->
        </div>

        <!-- Quick Info -->
        <div class="card-container">
            <h4 style="margin-bottom: 15px;"><i class="fas fa-info-circle"></i> System Information</h4>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div>
                    <p style="color: #6b7280; margin-bottom: 5px;">Your Role</p>
                    <p style="font-weight: 600; font-size: 16px;" id="displayRole">-</p>
                </div>
                <div>
                    <p style="color: #6b7280; margin-bottom: 5px;">System Status</p>
                    <p style="font-weight: 600; font-size: 16px;"><span style="background: var(--success); color: white; padding: 5px 10px; border-radius: 5px; font-size: 12px;">✓ Online</span></p>
                </div>
            </div>
        </div>
    </div>

    <script>
        const API_BASE = '{{ config("app.url") }}/api';
        let currentUser = null;

        document.addEventListener('DOMContentLoaded', () => {
            checkAuth();
            loadStats();
        });

        function checkAuth() {
            const token = localStorage.getItem('auth_token');
            const user = JSON.parse(localStorage.getItem('user') || '{}');
            
            if (!token) {
                window.location.href = '{{ route("login") }}';
                return;
            }

            currentUser = user;
            document.getElementById('userName').textContent = user.name || 'User';
            document.getElementById('userRole').textContent = (user.role || 'user').toUpperCase();
            document.getElementById('displayRole').textContent = (user.role || 'user').toUpperCase();
        }

        async function loadStats() {
            try {
                if (!currentUser) return;
                const userRole = currentUser.role || 'user';
                const token = localStorage.getItem('auth_token');

                if (userRole === 'MAHASISWA') {
                    loadMahasiswaStats(token);
                } else if (userRole === 'INSTRUKTUR') {
                    loadInstrukturStats(token);
                } else if (userRole === 'ADMIN') {
                    loadAdminStats(token);
                }
            } catch (error) {
                console.error('Error loading stats:', error);
            }
        }

        function createStatCard(icon, title, value, description, color = 'var(--primary)') {
            return `
                <div class="stat-card" style="border-left-color: ${color};">
                    <h4><i class="fas fa-${icon}"></i> ${title}</h4>
                    <div class="value" style="color: ${color};">${value}</div>
                    <p>${description}</p>
                </div>
            `;
        }

        async function loadMahasiswaStats(token) {
            try {
                const userId = currentUser.id;
                
                // Get enrolled kelas
                const kelasRes = await fetch(`${API_BASE}/mahasiswa/${userId}/kelas`, {
                    headers: { 'Authorization': `Bearer ${token}` }
                });
                
                let enrolledCount = 0;
                let jadwalCount = 0;
                let instrukturCount = 0;

                if (kelasRes.ok) {
                    const kelasData = await kelasRes.json();
                    const enrolledKelas = kelasData.data || [];
                    enrolledCount = enrolledKelas.length;
                    
                    // Count unique instruktur and jadwal
                    const instrukturSet = new Set();
                    let totalJadwal = 0;
                    
                    enrolledKelas.forEach(k => {
                        if (k.instruktur && k.instruktur.id) {
                            instrukturSet.add(k.instruktur.id);
                        }
                        if (k.jadwal && Array.isArray(k.jadwal)) {
                            totalJadwal += k.jadwal.length;
                        }
                    });
                    
                    instrukturCount = instrukturSet.size;
                    jadwalCount = totalJadwal;
                }

                // Render stats
                const statsHtml = `
                    ${createStatCard('graduation-cap', 'Kelas Diikuti', enrolledCount, 'Classes enrolled', 'var(--primary)')}
                    ${createStatCard('user-tie', 'Instruktur', instrukturCount, 'Different instructors', 'var(--secondary)')}
                    ${createStatCard('calendar', 'Total Jadwal', jadwalCount, 'Class schedules', 'var(--success)')}
                `;
                
                document.getElementById('statsContainer').innerHTML = statsHtml;
            } catch (error) {
                console.error('Error loading mahasiswa stats:', error);
            }
        }

        async function loadInstrukturStats(token) {
            try {
                // Get all jadwal and kelas
                const [jadwalRes, kelasRes] = await Promise.all([
                    fetch(`${API_BASE}/jadwal`, {
                        headers: { 'Authorization': `Bearer ${token}` }
                    }),
                    fetch(`${API_BASE}/kelas`, {
                        headers: { 'Authorization': `Bearer ${token}` }
                    })
                ]);

                let myJadwalCount = 0;
                let myKelasCount = 0;
                let totalMahasiswaCount = 0;

                if (jadwalRes.ok && kelasRes.ok) {
                    const jadwalData = await jadwalRes.json();
                    const kelasData = await kelasRes.json();
                    
                    const allJadwal = jadwalData.data || [];
                    const allKelas = kelasData.data || [];
                    const instrukturId = currentUser.instruktur_id;

                    // Filter jadwal dan kelas untuk instruktur ini
                    const myKelas = allKelas.filter(k => k.instruktur_id === instrukturId);
                    myKelasCount = myKelas.length;

                    const myJadwal = allJadwal.filter(j => {
                        return myKelas.some(k => k.id === j.kelas_id);
                    });
                    myJadwalCount = myJadwal.length;

                    // Count total mahasiswa di semua kelas instruktur
                    myKelas.forEach(k => {
                        totalMahasiswaCount += (k.peserta_count || 0);
                    });
                }

                // Render stats
                const statsHtml = `
                    ${createStatCard('calendar', 'Jadwal Saya', myJadwalCount, 'Class schedules', 'var(--primary)')}
                    ${createStatCard('book', 'Kelas Dimiliki', myKelasCount, 'Classes owned', 'var(--secondary)')}
                    ${createStatCard('users', 'Total Mahasiswa', totalMahasiswaCount, 'Total students', 'var(--success)')}
                `;
                
                document.getElementById('statsContainer').innerHTML = statsHtml;
            } catch (error) {
                console.error('Error loading instruktur stats:', error);
            }
        }

        async function loadAdminStats(token) {
            try {
                // Get users, classes, schedules
                const [usersRes, klasesRes, jadwalRes] = await Promise.all([
                    fetch(`${API_BASE}/users`, {
                        headers: { 'Authorization': `Bearer ${token}` }
                    }).catch(() => null),
                    fetch(`${API_BASE}/kelas`, {
                        headers: { 'Authorization': `Bearer ${token}` }
                    }),
                    fetch(`${API_BASE}/jadwal`, {
                        headers: { 'Authorization': `Bearer ${token}` }
                    })
                ]);

                let totalUsers = 0;
                let totalClasses = 0;
                let totalSchedules = 0;

                if (usersRes && usersRes.ok) {
                    const usersData = await usersRes.json();
                    totalUsers = (usersData.data || []).length;
                }

                if (klasesRes.ok) {
                    const klasesData = await klasesRes.json();
                    totalClasses = (klasesData.data || []).length;
                }

                if (jadwalRes.ok) {
                    const jadwalData = await jadwalRes.json();
                    totalSchedules = (jadwalData.data || []).length;
                }

                // Render stats
                const statsHtml = `
                    ${createStatCard('users', 'Total Users', totalUsers, 'Active users in system', 'var(--primary)')}
                    ${createStatCard('book', 'Total Classes', totalClasses, 'Classes in system', 'var(--secondary)')}
                    ${createStatCard('calendar', 'Total Schedules', totalSchedules, 'Configured schedules', 'var(--success)')}
                `;
                
                document.getElementById('statsContainer').innerHTML = statsHtml;
            } catch (error) {
                console.error('Error loading admin stats:', error);
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
