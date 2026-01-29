<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Instruktur - Akademik</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            color: #333;
        }

        .container {
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 260px;
            background: linear-gradient(180deg, #2d3561 0%, #1e1f3a 100%);
            color: white;
            padding: 20px;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            box-shadow: 2px 0 15px rgba(0,0,0,0.3);
        }

        .sidebar-header {
            margin-bottom: 30px;
            text-align: center;
            border-bottom: 2px solid rgba(255,255,255,0.2);
            padding-bottom: 15px;
        }

        .sidebar-header h3 {
            font-size: 18px;
            margin-bottom: 5px;
        }

        .sidebar-header p {
            font-size: 12px;
            opacity: 0.8;
        }

        .sidebar-menu {
            list-style: none;
        }

        .sidebar-menu li {
            margin-bottom: 10px;
        }

        .sidebar-menu a {
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 15px;
            border-radius: 8px;
            transition: all 0.3s;
            font-size: 14px;
        }

        .sidebar-menu a:hover {
            background: rgba(255,255,255,0.2);
            color: white;
        }

        .sidebar-menu a.active {
            background: rgba(102, 126, 234, 0.6);
            color: white;
            font-weight: 600;
        }

        .logout-btn {
            position: absolute;
            bottom: 20px;
            left: 20px;
            right: 20px;
        }

        .logout-btn button {
            width: 100%;
            padding: 10px;
            background: #e74c3c;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s;
        }

        .logout-btn button:hover {
            background: #c0392b;
        }

        .main-content {
            margin-left: 260px;
            padding: 30px;
            flex: 1;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .header h1 {
            font-size: 28px;
            color: #2d3561;
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .user-info {
            text-align: right;
        }

        .user-info h4 {
            color: #2d3561;
            margin-bottom: 3px;
        }

        .user-info p {
            font-size: 12px;
            color: #7f8c8d;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            display: flex;
            align-items: center;
            gap: 15px;
            transition: transform 0.3s;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-icon {
            font-size: 32px;
            width: 60px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
        }

        .stat-icon.blue { background: rgba(52, 152, 219, 0.1); color: #3498db; }
        .stat-icon.green { background: rgba(46, 204, 113, 0.1); color: #2ecc71; }
        .stat-icon.orange { background: rgba(241, 196, 15, 0.1); color: #f39c12; }

        .stat-content h3 {
            font-size: 24px;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 3px;
        }

        .stat-content p {
            font-size: 13px;
            color: #7f8c8d;
        }

        .content-section {
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }

        .section-title {
            font-size: 18px;
            font-weight: 700;
            color: #2d3561;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .table-responsive {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th {
            background: #f8f9fa;
            color: #2d3561;
            padding: 15px;
            text-align: left;
            font-weight: 600;
            border-bottom: 2px solid #e0e0e0;
        }

        table td {
            padding: 15px;
            border-bottom: 1px solid #e0e0e0;
        }

        table tr:hover {
            background: #f8f9fa;
        }

        .badge {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .badge-success { background: #d4edda; color: #155724; }
        .badge-warning { background: #fff3cd; color: #856404; }
        .badge-info { background: #d1ecf1; color: #0c5460; }

        .no-data {
            text-align: center;
            padding: 40px;
            color: #7f8c8d;
        }

        .loading {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px;
            gap: 10px;
        }

        .spinner {
            border: 3px solid #f3f3f3;
            border-top: 3px solid #667eea;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="sidebar-header">
                <h3><i class="fas fa-chalkboard-user"></i> Akademik</h3>
                <p>Dashboard Instruktur</p>
            </div>
            <ul class="sidebar-menu">
                <li><a href="/instruktur-dashboard" class="active"><i class="fas fa-home"></i> Dashboard</a></li>
                <li><a href="#kelas"><i class="fas fa-book"></i> Kelas Mengajar</a></li>
                <li><a href="/risalah"><i class="fas fa-file-alt"></i> Risalah</a></li>
                <li><a href="#jadwal"><i class="fas fa-calendar"></i> Jadwal</a></li>
                <li><a href="#profil"><i class="fas fa-user"></i> Profil</a></li>
            </ul>
            <div class="logout-btn">
                <button onclick="logout()"><i class="fas fa-sign-out-alt"></i> Logout</button>
            </div>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Header -->
            <div class="header">
                <div>
                    <h1>Dashboard Instruktur</h1>
                    <p style="color: #7f8c8d; margin-top: 5px;">Kelola kelas dan jadwal mengajar</p>
                </div>
                <div class="header-right">
                    <div class="user-info">
                        <h4 id="userName">-</h4>
                        <p>Instruktur</p>
                    </div>
                </div>
            </div>

            <!-- Kelas Section -->
            <div class="content-section" id="kelasSection">
                <h2 class="section-title">
                    <i class="fas fa-book"></i> Kelas yang Diajar
                </h2>
                <div id="kelasContent" class="loading">
                    <div class="spinner"></div>
                    <span>Memuat data...</span>
                </div>
            </div>

            <!-- Jadwal Section -->
            <div class="content-section" id="jadwalSection">
                <h2 class="section-title">
                    <i class="fas fa-calendar"></i> Jadwal Mengajar
                </h2>
                <div id="jadwalContent" class="loading">
                    <div class="spinner"></div>
                    <span>Memuat data...</span>
                </div>
            </div>
        </div>
    </div>

    <script>
        const API_BASE = '{{ config("app.url") }}/api';

        // Get token
        const token = localStorage.getItem('auth_token');
        if (!token) {
            window.location.href = '{{ route("login") }}';
        }

        // Load instruktur data
        async function loadInstrukturData() {
            try {
                // Get current user
                const userRes = await fetch(`${API_BASE}/auth/me`, {
                    headers: { 'Authorization': `Bearer ${token}` }
                });
                
                if (!userRes.ok) {
                    window.location.href = '{{ route("login") }}';
                    return;
                }

                const userData = await userRes.json();
                const user = userData.data;

                // Update header
                document.getElementById('userName').textContent = user.name;

                // Load kelas
                await loadKelas(user.id);

                // Load jadwal
                await loadJadwal(user.id);

            } catch (error) {
                console.error('Error loading data:', error);
                alert('Error loading data');
            }
        }

        async function loadKelas(userId) {
            try {
                const res = await fetch(`${API_BASE}/academic/instruktur/${userId}/kelas`, {
                    headers: { 'Authorization': `Bearer ${token}` }
                });

                const data = await res.json();
                const kelas = data.data || [];

                let html = '';
                if (kelas.length === 0) {
                    html = '<div class="no-data">Tidak ada kelas yang diajar</div>';
                } else {
                    html = `
                        <div class="table-responsive">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Kode Kelas</th>
                                        <th>Nama Kelas</th>
                                        <th>Tahun Akademik</th>
                                        <th>Kapasitas</th>
                                        <th>Jumlah Siswa</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    ${kelas.map(k => `
                                        <tr>
                                            <td><strong>${k.kode_kelas}</strong></td>
                                            <td>${k.nama_kelas}</td>
                                            <td>${k.tahun_akademik}</td>
                                            <td>${k.kapasitas} siswa</td>
                                            <td>${k.mahasiswa?.length || 0}</td>
                                        </tr>
                                    `).join('')}
                                </tbody>
                            </table>
                        </div>
                    `;
                }

                document.getElementById('kelasContent').innerHTML = html;

            } catch (error) {
                console.error('Error loading kelas:', error);
                document.getElementById('kelasContent').innerHTML = '<div class="no-data">Error loading kelas</div>';
            }
        }

        async function loadJadwal(userId) {
            try {
                const res = await fetch(`${API_BASE}/academic/instruktur/${userId}/jadwal`, {
                    headers: { 'Authorization': `Bearer ${token}` }
                });

                const data = await res.json();
                const jadwal = data.data || [];

                let html = '';
                if (jadwal.length === 0) {
                    html = '<div class="no-data">Tidak ada jadwal tersedia</div>';
                } else {
                    html = `
                        <div class="table-responsive">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Kelas</th>
                                        <th>Hari</th>
                                        <th>Jam Mulai</th>
                                        <th>Jam Selesai</th>
                                        <th>Ruangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    ${jadwal.map(j => `
                                        <tr>
                                            <td><strong>${j.kelas?.nama_kelas || '-'}</strong></td>
                                            <td>${j.hari?.nama_hari || '-'}</td>
                                            <td>${j.jam_mulai}</td>
                                            <td>${j.jam_selesai}</td>
                                            <td>${j.ruangan || '-'}</td>
                                        </tr>
                                    `).join('')}
                                </tbody>
                            </table>
                        </div>
                    `;
                }

                document.getElementById('jadwalContent').innerHTML = html;

            } catch (error) {
                console.error('Error loading jadwal:', error);
                document.getElementById('jadwalContent').innerHTML = '<div class="no-data">Error loading jadwal</div>';
            }
        }

        function logout() {
            if (confirm('Apakah Anda yakin ingin logout?')) {
                localStorage.removeItem('auth_token');
                localStorage.removeItem('user');
                window.location.href = '{{ route("login") }}';
            }
        }

        // Load data on page load
        loadInstrukturData();
    </script>
</body>
</html>
