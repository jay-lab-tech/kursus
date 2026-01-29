<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Browse Kelas - Sistem Akademik</title>
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
        
        .filter-section { background: white; padding: 20px; border-radius: 10px; margin-bottom: 25px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
        .filter-section .form-control { border-radius: 8px; border: 1px solid #e5e7eb; }
        
        .kelas-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 20px; }
        
        .kelas-card { 
            background: white; border-radius: 10px; overflow: hidden; 
            box-shadow: 0 1px 3px rgba(0,0,0,0.1); transition: all 0.3s;
            border-left: 4px solid var(--primary);
        }
        
        .kelas-card:hover { transform: translateY(-5px); box-shadow: 0 4px 12px rgba(0,0,0,0.15); }
        
        .kelas-card-header { 
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white; padding: 20px; 
        }
        
        .kelas-card-header h5 { margin: 0; font-size: 18px; font-weight: 700; }
        .kelas-card-header p { margin: 5px 0 0; font-size: 13px; opacity: 0.9; }
        
        .kelas-card-body { padding: 20px; }
        
        .kelas-info { display: flex; gap: 20px; margin-bottom: 15px; flex-wrap: wrap; }
        .info-item { flex: 1; min-width: 150px; }
        .info-item label { color: #6b7280; font-size: 12px; font-weight: 600; display: block; margin-bottom: 5px; }
        .info-item .value { font-size: 16px; font-weight: 600; color: var(--primary); }
        
        .capacity-bar { 
            height: 8px; background: #e5e7eb; border-radius: 4px; overflow: hidden; margin-top: 10px;
        }
        .capacity-bar .fill { height: 100%; background: var(--primary); transition: width 0.3s; }
        
        .kelas-footer { display: flex; gap: 10px; margin-top: 15px; padding-top: 15px; border-top: 1px solid #e5e7eb; }
        
        .btn-custom { 
            flex: 1; padding: 10px; border-radius: 8px; border: none; font-weight: 600;
            cursor: pointer; transition: all 0.3s; font-size: 13px;
        }
        
        .btn-enroll { background: var(--success); color: white; }
        .btn-enroll:hover { background: #059669; }
        .btn-enrolled { background: #e5e7eb; color: #4b5563; cursor: not-allowed; }
        .btn-view { background: var(--secondary); color: white; }
        .btn-view:hover { background: #0891b2; }
        
        .empty-state { 
            text-align: center; padding: 60px 20px; color: #6b7280;
        }
        
        .empty-state i { font-size: 48px; color: #d1d5db; margin-bottom: 15px; }
        .empty-state h3 { color: #1f2937; margin-bottom: 10px; }
        
        .loading { text-align: center; padding: 40px; }
        .spinner { border: 4px solid #e5e7eb; border-top: 4px solid var(--primary); border-radius: 50%; width: 40px; height: 40px; animation: spin 1s linear infinite; margin: 0 auto; }
        @keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }
        
        .alert { border-radius: 8px; border: none; }
        
        @media (max-width: 768px) {
            .sidebar { width: 70px; }
            .sidebar-menu a span { display: none; }
            .main-content { margin-left: 70px; padding: 15px; }
            .header { flex-direction: column; gap: 15px; text-align: center; }
            .kelas-grid { grid-template-columns: 1fr; }
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
            <li><a href="/kelas-browse" class="active"><i class="fas fa-book"></i> <span>Browse Kelas</span></a></li>
            <li><a href="/kelas-saya"><i class="fas fa-graduation-cap"></i> <span>Kelas Saya</span></a></li>
            <li style="margin-top: 20px;"><a href="/data-management"><i class="fas fa-database"></i> <span>Data Management</span></a></li>
            <li style="margin-top: 10px;"><a href="/admin" style="color: rgba(255,255,255,0.6);"><i class="fas fa-lock"></i> <span>Admin Panel</span></a></li>
            <hr style="border: none; border-top: 1px solid rgba(255,255,255,0.1); margin: 20px 0;">
            <li><button onclick="logout()" style="background: none; border: none; color: rgba(255,255,255,0.8); width: 100%; text-align: left; padding: 12px 15px; border-radius: 8px; cursor: pointer; display: flex; align-items: center; gap: 12px; font-size: inherit; font-family: inherit;"><i class="fas fa-sign-out-alt"></i> <span>Logout</span></button></li>
        </ul>
    </div>

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
                    <div>
                        <p style="margin: 0; font-weight: 600; font-size: 14px;" id="userName">User</p>
                        <p style="margin: 0; font-size: 12px; color: #6b7280;" id="userRole">Mahasiswa</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter Section -->
        <div class="filter-section">
            <div class="row">
                <div class="col-md-6">
                    <label class="form-label"><i class="fas fa-search"></i> Cari Kelas</label>
                    <input type="text" id="searchInput" class="form-control" placeholder="Nama kelas atau instruktur...">
                </div>
                <div class="col-md-6">
                    <label class="form-label"><i class="fas fa-filter"></i> Filter Kapasitas</label>
                    <select id="filterCapacity" class="form-control">
                        <option value="">Semua Kelas</option>
                        <option value="available">Masih Ada Tempat</option>
                        <option value="full">Penuh</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Alert Messages -->
        <div id="alertContainer"></div>

        <!-- Kelas Grid -->
        <div id="kelasContainer" class="kelas-grid">
            <div class="loading">
                <div class="spinner"></div>
                <p style="margin-top: 15px; color: #6b7280;">Memuat data kelas...</p>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const API_BASE = '/api';
        let allKelas = [];
        let currentUser = null;

        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            loadUserInfo();
            loadKelas();
            setupEventListeners();
        });

        // Load user info from localStorage
        function loadUserInfo() {
            const userData = JSON.parse(localStorage.getItem('user') || '{}');
            currentUser = userData;
            document.getElementById('userName').textContent = userData.name || 'User';
            document.getElementById('userRole').textContent = userData.role || 'Mahasiswa';
        }

        // Load available kelas
        function loadKelas() {
            const token = localStorage.getItem('token');
            
            const headers = {
                'Content-Type': 'application/json'
            };
            
            // Tambah auth header hanya kalau ada token yang valid
            if (token) {
                headers['Authorization'] = `Bearer ${token}`;
            }
            
            fetch(`${API_BASE}/kelas/available`, {
                method: 'GET',
                headers: headers
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    allKelas = data.data || [];
                    if (allKelas.length === 0) {
                        showAlert('info', 'Tidak ada kelas yang tersedia');
                    }
                    renderKelas(allKelas);
                } else {
                    showAlert('error', data.message || 'Gagal memuat data kelas');
                }
            })
            .catch(error => {
                console.error('Error loading kelas:', error);
                showAlert('error', 'Terjadi kesalahan saat memuat kelas: ' + error.message);
            });
        }

        // Render kelas cards
        function renderKelas(kelasData) {
            const container = document.getElementById('kelasContainer');
            
            if (!kelasData || kelasData.length === 0) {
                container.innerHTML = `
                    <div class="empty-state" style="grid-column: 1/-1;">
                        <i class="fas fa-book"></i>
                        <h3>Tidak Ada Kelas</h3>
                        <p>Saat ini belum ada kelas yang tersedia.</p>
                    </div>
                `;
                return;
            }

            container.innerHTML = kelasData.map(kelas => {
                const peserta = kelas.peserta_count || 0;
                const kapasitas = kelas.kapasitas || 30;
                const persentase = (peserta / kapasitas) * 100;
                const sisa = kapasitas - peserta;
                const isEnrolled = kelas.is_enrolled || false;

                return `
                    <div class="kelas-card">
                        <div class="kelas-card-header">
                            <h5>${kelas.nama_kelas}</h5>
                            <p><i class="fas fa-user"></i> ${kelas.instruktur?.nama_instruktur || 'N/A'}</p>
                        </div>
                        <div class="kelas-card-body">
                            <div class="kelas-info">
                                <div class="info-item">
                                    <label><i class="fas fa-users"></i> Peserta</label>
                                    <div class="value">${peserta}/${kapasitas}</div>
                                </div>
                                <div class="info-item">
                                    <label><i class="fas fa-chair"></i> Sisa Tempat</label>
                                    <div class="value" style="color: ${sisa > 0 ? 'var(--success)' : 'var(--danger)'};">${sisa}</div>
                                </div>
                                <div class="info-item">
                                    <label><i class="fas fa-clock"></i> Jadwal</label>
                                    <div class="value" style="font-size: 13px;">${kelas.jadwal?.hari || '-'}</div>
                                </div>
                            </div>
                            <div class="capacity-bar">
                                <div class="fill" style="width: ${persentase}%"></div>
                            </div>
                            <div class="kelas-footer">
                                ${isEnrolled ? 
                                    `<button class="btn-custom btn-enrolled" disabled>
                                        <i class="fas fa-check"></i> Sudah Terdaftar
                                    </button>` :
                                    `<button class="btn-custom btn-enroll" onclick="enrollKelas(${kelas.id})">
                                        <i class="fas fa-plus"></i> Daftar Sekarang
                                    </button>`
                                }
                            </div>
                        </div>
                    </div>
                `;
            }).join('');
        }

        // Enroll to kelas
        function enrollKelas(kelasId) {
            if (!currentUser || !currentUser.id) {
                showAlert('warning', 'Silakan login terlebih dahulu');
                return;
            }

            const token = localStorage.getItem('token');
            const btn = event.target.closest('.btn-enroll');
            const originalText = btn.innerHTML;
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Mendaftar...';

            fetch(`${API_BASE}/mahasiswa/${currentUser.id}/kelas/${kelasId}/enroll`, {
                method: 'POST',
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Content-Type': 'application/json'
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP ${response.status}: ${response.statusText}`);
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    showAlert('success', 'Berhasil mendaftar kelas!');
                    setTimeout(() => {
                        loadKelas();
                    }, 1500);
                } else {
                    btn.disabled = false;
                    btn.innerHTML = originalText;
                    showAlert('error', data.message || 'Gagal mendaftar kelas');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                btn.disabled = false;
                btn.innerHTML = originalText;
                showAlert('error', 'Terjadi kesalahan saat mendaftar: ' + error.message);
            });
        }

        // Setup event listeners
        function setupEventListeners() {
            document.getElementById('searchInput').addEventListener('keyup', filterKelas);
            document.getElementById('filterCapacity').addEventListener('change', filterKelas);
        }

        // Filter kelas
        function filterKelas() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            const capacityFilter = document.getElementById('filterCapacity').value;

            let filtered = allKelas.filter(kelas => {
                const matchSearch = !searchTerm || 
                    kelas.nama_kelas.toLowerCase().includes(searchTerm) ||
                    (kelas.instruktur?.nama_instruktur || '').toLowerCase().includes(searchTerm);

                const peserta = kelas.peserta_count || 0;
                const kapasitas = kelas.kapasitas || 30;
                let matchCapacity = true;

                if (capacityFilter === 'available') {
                    matchCapacity = peserta < kapasitas;
                } else if (capacityFilter === 'full') {
                    matchCapacity = peserta >= kapasitas;
                }

                return matchSearch && matchCapacity;
            });

            renderKelas(filtered);
        }

        // Show alert
        function showAlert(type, message) {
            const alertContainer = document.getElementById('alertContainer');
            const alertId = 'alert-' + Date.now();
            const bgColor = type === 'success' ? 'alert-success' : type === 'error' ? 'alert-danger' : 'alert-warning';
            
            const alertHTML = `
                <div id="${alertId}" class="alert ${bgColor} alert-dismissible fade show" role="alert">
                    <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : 'info-circle'}"></i>
                    ${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            `;
            
            alertContainer.insertAdjacentHTML('beforeend', alertHTML);
            setTimeout(() => {
                const alert = document.getElementById(alertId);
                if (alert) alert.remove();
            }, 5000);
        }

        // Logout
        function logout() {
            localStorage.removeItem('token');
            localStorage.removeItem('user');
            window.location.href = '/login';
        }
    </script>
</body>
</html>
