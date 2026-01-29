<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Browse Kelas - Sistem Akademik</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
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
        .sidebar-menu a, .sidebar-menu button { 
            color: rgba(255,255,255,0.8); text-decoration: none; display: flex; align-items: center; gap: 12px;
            padding: 12px 15px; border-radius: 8px; transition: all 0.3s; font-size: inherit; font-family: inherit;
        }
        .sidebar-menu a:hover, .sidebar-menu button:hover { background: rgba(255,255,255,0.2); color: white; }
        .sidebar-menu a.active { background: rgba(255,255,255,0.3); color: white; font-weight: 600; }
        .sidebar-menu button { background: none; border: none; width: 100%; text-align: left; cursor: pointer; }
        
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
        .user-info { display: flex; flex-direction: column; }
        .user-info p { margin: 0; font-size: 12px; color: #6b7280; }
        .user-info p:first-child { font-weight: 600; font-size: 14px; color: #1f2937; }

        .search-box { 
            background: white; padding: 20px; border-radius: 10px; 
            box-shadow: 0 1px 3px rgba(0,0,0,0.1); margin-bottom: 25px;
        }

        .kelas-grid {
            display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 20px;
        }

        .kelas-card {
            background: white; border-radius: 10px; overflow: hidden;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1); transition: all 0.3s;
            border-left: 4px solid var(--primary);
        }

        .kelas-card:hover { 
            box-shadow: 0 4px 12px rgba(0,0,0,0.15); transform: translateY(-2px);
        }

        .kelas-card-header {
            background: white; padding: 20px; border-bottom: 1px solid #e5e7eb;
        }

        .kelas-card-header h5 { margin: 0; font-weight: 600; font-size: 16px; color: #1f2937; }
        .kelas-card-code { font-size: 13px; color: #6b7280; margin-top: 5px; }

        .kelas-card-body { padding: 20px; }

        .info-row {
            display: flex; justify-content: space-between; margin-bottom: 12px; font-size: 14px;
        }

        .info-label { color: #6b7280; font-weight: 500; }
        .info-value { color: #1f2937; font-weight: 600; }
        .info-value.instructor { color: var(--primary); }

        .capacity-bar {
            background: #e5e7eb; height: 6px; border-radius: 3px; overflow: hidden; margin: 12px 0;
        }

        .capacity-fill {
            background: linear-gradient(90deg, var(--primary) 0%, var(--secondary) 100%);
            height: 100%; transition: width 0.3s;
        }

        .capacity-full .capacity-fill { background: var(--danger); }

        .btn-enroll {
            width: 100%; padding: 10px; border: none; border-radius: 6px; font-weight: 600;
            cursor: pointer; transition: all 0.3s; margin-top: 12px; font-size: 14px;
        }

        .btn-enroll:not(.enrolled):not(:disabled) {
            background: var(--primary); color: white;
        }

        .btn-enroll:not(.enrolled):not(:disabled):hover {
            opacity: 0.9; background: var(--primary-dark);
        }

        .btn-enroll.enrolled {
            background: var(--success); color: white;
        }

        .btn-enroll:disabled {
            background: #d1d5db; color: #9ca3af; cursor: not-allowed;
        }

        .alert { border-radius: 8px; border: none; padding: 15px; margin-bottom: 20px; }
        .alert-danger { background: #fee2e2; color: #991b1b; }
        .alert-success { background: #dcfce7; color: #166534; }
        .alert-info { background: #cffafe; color: #164e63; }

        .empty-state { 
            text-align: center; padding: 80px 20px; background: white;
            border-radius: 10px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            grid-column: 1 / -1;
        }

        .empty-state i { font-size: 60px; color: #d1d5db; margin-bottom: 15px; }
        .empty-state h3 { color: #1f2937; font-weight: 600; margin-bottom: 10px; }
        .empty-state p { color: #6b7280; }

        @media (max-width: 768px) {
            .sidebar { width: 70px; }
            .sidebar-menu a span, .sidebar-menu button span { display: none; }
            .main-content { margin-left: 70px; padding: 15px; }
            .header { flex-direction: column; gap: 15px; text-align: center; }
            .kelas-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-brand">
            <i class="fas fa-graduation-cap"></i> Akademik
        </div>
        <ul class="sidebar-menu">
            <li><a href="/dashboard"><i class="fas fa-home"></i> Dashboard</a></li>
            <li data-role="mahasiswa all"><a href="/kelas-browse" class="active"><i class="fas fa-book"></i> Browse Kelas</a></li>
            <li data-role="mahasiswa all"><a href="/kelas-saya"><i class="fas fa-list"></i> Kelas Saya</a></li>
            <li data-role="instruktur admin"><a href="/risalah"><i class="fas fa-file-alt"></i> Risalah</a></li>
            <li data-role="admin"><a href="/data-management"><i class="fas fa-database"></i> Data Management</a></li>
            <li data-role="admin"><a href="/admin"><i class="fas fa-shield"></i> Admin Panel</a></li>
            <li><a href="#" onclick="logout()"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
        </ul>
    </aside>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Header -->
        <div class="header">
            <div class="header-left">
                <h1>Browse Kelas</h1>
                <p>Pilih kelas yang ingin Anda ikuti</p>
            </div>
            <div class="header-right">
                <div class="user-profile">
                    <img src="https://api.dicebear.com/7.x/avataaars/svg?seed=user" alt="Avatar">
                    <div class="user-info">
                        <p id="userName">User</p>
                        <p id="userRole">Role</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Messages -->
        <div id="messageContainer"></div>

        <!-- Search Box -->
        <div class="search-box">
            <div class="input-group">
                <span class="input-group-text" style="background: white; border-right: none; border-color: #d1d5db;">
                    <i class="fas fa-search" style="color: #6b7280;"></i>
                </span>
                <input 
                    type="text" 
                    class="form-control" 
                    id="searchInput" 
                    placeholder="Cari nama atau kode kelas..."
                    style="border-left: none; border-color: #d1d5db;"
                >
            </div>
        </div>

        <!-- Kelas Grid -->
        <div id="kelasContainer" class="kelas-grid">
        </div>
    </div>

<!-- Scripts -->
<script src="{{ asset('js/api-utils.js') }}"></script>
<script>
    let allKelas = [];
    let currentUserId = null;
    let currentUserName = null;
    let currentUserRole = null;
    let enrolledKelasIds = [];

    // Check authentication dan role
    function checkAuthAndRole() {
        try {
            const userJSON = localStorage.getItem('user');
            const token = localStorage.getItem('auth_token') || localStorage.getItem('token');

            if (!token) {
                window.location.href = '/login';
                return false;
            }

            // Parse user data
            let userData = null;
            if (userJSON) {
                userData = JSON.parse(userJSON);
            }

            // Check role
            const role = userData?.role || localStorage.getItem('userRole');
            if (role !== 'mahasiswa') {
                alert('Halaman ini hanya bisa diakses oleh mahasiswa!');
                window.location.href = '/dashboard';
                return false;
            }

            // Store data
            currentUserId = userData?.id || localStorage.getItem('userId');
            currentUserName = userData?.name || localStorage.getItem('userName');
            currentUserRole = userData?.role || localStorage.getItem('userRole');

            // Simpan ke localStorage untuk consistency
            if (userData) {
                localStorage.setItem('userId', currentUserId);
                localStorage.setItem('userName', currentUserName);
                localStorage.setItem('userRole', currentUserRole);
            }

            return true;
        } catch (error) {
            console.error('Auth check error:', error);
            window.location.href = '/login';
            return false;
        }
    }

    // Load user info ke UI
    function loadUserInfo() {
        try {
            if (currentUserName) {
                document.getElementById('userName').textContent = currentUserName;
                document.getElementById('userRole').textContent = (currentUserRole || 'User').toUpperCase();
            }
        } catch (error) {
            console.error('Error loading user info:', error);
        }
    }

    // Get current user's enrolled kelas
    async function loadEnrolledKelas() {
        try {
            if (currentUserId) {
                const enrolled = await getUserEnrolledKelas(currentUserId);
                enrolledKelasIds = enrolled.map(k => k.id);
            }
        } catch (error) {
            console.error('Error loading enrolled kelas:', error);
        }
    }

    // Load available kelas
    async function loadKelas(search = '') {
        try {
            showMessage('Memuat kelas...', 'info');
            const kelas = await getAvailableKelas(search);
            allKelas = kelas;
            renderKelas(kelas);
            hideMessage();
        } catch (error) {
            showMessage('Gagal memuat kelas: ' + error.message, 'danger');
            document.getElementById('kelasContainer').innerHTML = `
                <div style="grid-column: 1/-1;">
                    <div class="empty-state">
                        <i class="fas fa-exclamation-circle"></i>
                        <h3>Terjadi kesalahan</h3>
                        <p>${error.message}</p>
                    </div>
                </div>
            `;
        }
    }

    // Render kelas cards
    function renderKelas(kelas) {
        if (kelas.length === 0) {
            document.getElementById('kelasContainer').innerHTML = `
                <div style="grid-column: 1/-1;">
                    <div class="empty-state">
                        <i class="fas fa-inbox"></i>
                        <h3>Tidak ada kelas</h3>
                        <p>Maaf, tidak ada kelas yang tersedia saat ini</p>
                    </div>
                </div>
            `;
            return;
        }

        document.getElementById('kelasContainer').innerHTML = kelas.map(k => {
            const isEnrolled = enrolledKelasIds.includes(k.id);
            const capacityPercent = k.kapasitas > 0 ? (k.peserta_count / k.kapasitas * 100) : 0;
            const isFull = k.is_full;

            return `
                <div class="kelas-card">
                    <div class="kelas-card-header">
                        <h5>${k.nama_kelas}</h5>
                        <div class="kelas-card-code">Kode: ${k.kode_kelas}</div>
                    </div>
                    
                    <div class="kelas-card-body">
                        <div class="info-row">
                            <span class="info-label">Instruktur:</span>
                            <span class="info-value instructor">${k.instruktur?.nama || 'N/A'}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Peserta:</span>
                            <span class="info-value">${k.peserta_count} / ${k.kapasitas}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Tersisa:</span>
                            <span class="info-value">${k.kapasitas_tersisa}</span>
                        </div>

                        <!-- Capacity Bar -->
                        <div class="capacity-bar ${isFull ? 'capacity-full' : ''}">
                            <div class="capacity-fill" style="width: ${capacityPercent}%"></div>
                        </div>

                        <!-- Buttons -->
                        <div style="display: flex; gap: 10px; margin-top: 12px;">
                            <button 
                                class="btn-enroll"
                                onclick="handleEnroll(${k.id}, ${isEnrolled ? 'true' : 'false'})"
                                ${isFull && !isEnrolled ? 'disabled' : ''}
                                style="flex: 1;"
                            >
                                ${isEnrolled 
                                    ? '<i class="fas fa-check"></i> Sudah Terdaftar' 
                                    : isFull 
                                    ? '<i class="fas fa-times"></i> Kelas Penuh' 
                                    : '<i class="fas fa-plus"></i> Daftar Sekarang'
                                }
                            </button>
                            <button 
                                class="btn-enroll"
                                onclick="window.location.href = '/kelas/${k.id}'"
                                style="flex: 1; background: #06b6d4; color: white; margin-top: 0;"
                            >
                                <i class="fas fa-eye"></i> Detail
                            </button>
                        </div>
                    </div>
                </div>
            `;
        }).join('');
    }

    // Handle enroll/unenroll
    async function handleEnroll(kelasId, isEnrolled) {
        if (!currentUserId) {
            showMessage('Anda harus login terlebih dahulu', 'danger');
            return;
        }

        try {
            if (isEnrolled) {
                if (!confirm('Anda yakin ingin membatalkan pendaftaran?')) return;
                await unenrollKelas(currentUserId, kelasId);
                showMessage('Berhasil membatalkan pendaftaran', 'success');
            } else {
                await enrollKelas(currentUserId, kelasId);
                showMessage('Berhasil mendaftar kelas!', 'success');
            }
            
            // Reload
            await loadEnrolledKelas();
            await loadKelas();
        } catch (error) {
            showMessage('Error: ' + error.message, 'danger');
        }
    }

    // Show message
    function showMessage(text, type = 'info') {
        const alertClass = type === 'danger' ? 'alert-danger' : type === 'success' ? 'alert-success' : 'alert-info';
        document.getElementById('messageContainer').innerHTML = `
            <div class="alert ${alertClass}" role="alert">
                ${text}
            </div>
        `;
    }

    // Hide message
    function hideMessage() {
        document.getElementById('messageContainer').innerHTML = '';
    }

    // Logout function
    function logout() {
        if (confirm('Anda yakin ingin logout?')) {
            localStorage.clear();
            window.location.href = '/login';
        }
    }

    // Search functionality
    document.getElementById('searchInput').addEventListener('input', (e) => {
        const searchTerm = e.target.value.toLowerCase();
        if (searchTerm.length > 0) {
            loadKelas(searchTerm);
        } else {
            renderKelas(allKelas);
        }
    });

    // Initialize
    async function init() {
        // Check auth dan role terlebih dahulu
        if (!checkAuthAndRole()) {
            return;
        }

        // Load user info ke UI
        loadUserInfo();

        // Load kelas
        await loadEnrolledKelas();
        await loadKelas();
    }

    init();
</script>
<script src="{{ asset('js/sidebar-menu.js') }}"></script>
</body>
</html>
