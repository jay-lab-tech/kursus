<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelas Saya - Sistem Akademik</title>
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
        
        .stats-section { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 30px; }
        
        .stat-card { 
            background: white; padding: 20px; border-radius: 10px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            border-left: 4px solid var(--primary);
        }
        
        .stat-card h4 { color: #6b7280; margin: 0 0 10px 0; font-size: 13px; font-weight: 600; }
        .stat-card .value { font-size: 28px; font-weight: 700; color: var(--primary); }
        
        .table-container { 
            background: white; border-radius: 10px; overflow: hidden;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        
        .table { margin: 0; }
        .table thead { background: #f3f4f6; }
        .table thead th { 
            padding: 15px; font-weight: 600; color: #1f2937; border: none;
            font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px;
        }
        
        .table tbody td { 
            padding: 15px; vertical-align: middle; border-color: #e5e7eb;
            color: #4b5563;
        }
        
        .table tbody tr:hover { background: #f9fafb; }
        
        .badge-custom { 
            padding: 6px 12px; border-radius: 6px; font-size: 12px; font-weight: 600;
        }
        
        .badge-active { background: #d1fae5; color: var(--success); }
        
        .instructor-info { display: flex; align-items: center; gap: 10px; }
        .instructor-avatar { width: 32px; height: 32px; border-radius: 50%; background: var(--primary); color: white; display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: 700; }
        
        .schedule-info { 
            display: flex; flex-direction: column; gap: 5px;
        }
        
        .schedule-info .day { font-weight: 600; color: #1f2937; }
        .schedule-info .time { font-size: 12px; color: #6b7280; }
        
        .action-buttons { display: flex; gap: 8px; }
        
        .btn-custom { 
            padding: 6px 12px; border-radius: 6px; border: none; font-weight: 600;
            cursor: pointer; transition: all 0.3s; font-size: 12px;
            display: inline-flex; align-items: center; gap: 6px;
        }
        
        .btn-unenroll { background: var(--danger); color: white; }
        .btn-unenroll:hover { background: #dc2626; }
        
        .btn-view { background: var(--secondary); color: white; }
        .btn-view:hover { background: #0891b2; }
        
        .empty-state { 
            text-align: center; padding: 80px 20px; color: #6b7280;
        }
        
        .empty-state i { font-size: 48px; color: #d1d5db; margin-bottom: 15px; }
        .empty-state h3 { color: #1f2937; margin-bottom: 10px; }
        
        .loading { text-align: center; padding: 40px; }
        .spinner { border: 4px solid #e5e7eb; border-top: 4px solid var(--primary); border-radius: 50%; width: 40px; height: 40px; animation: spin 1s linear infinite; margin: 0 auto; }
        @keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }
        
        .alert { border-radius: 8px; border: none; }
        
        .modal-content { border: none; border-radius: 10px; }
        .modal-header { border-bottom: 1px solid #e5e7eb; background: #f9fafb; }
        .modal-footer { border-top: 1px solid #e5e7eb; }
        
        @media (max-width: 768px) {
            .sidebar { width: 70px; }
            .sidebar-menu a span { display: none; }
            .main-content { margin-left: 70px; padding: 15px; }
            .header { flex-direction: column; gap: 15px; text-align: center; }
            .stats-section { grid-template-columns: 1fr; }
            .table { font-size: 13px; }
            .action-buttons { flex-direction: column; }
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
            <li data-role="mahasiswa all"><a href="/kelas-browse"><i class="fas fa-book"></i> <span>Browse Kelas</span></a></li>
            <li data-role="mahasiswa all"><a href="/kelas-saya" class="active"><i class="fas fa-graduation-cap"></i> <span>Kelas Saya</span></a></li>
            <li data-role="instruktur admin" style="margin-top: 20px;"><a href="/risalah"><i class="fas fa-file-alt"></i> <span>Risalah</span></a></li>
            <li style="margin-top: 20px;" data-role="admin"><a href="/data-management"><i class="fas fa-database"></i> <span>Data Management</span></a></li>
            <li data-role="admin"><a href="/admin"><i class="fas fa-shield"></i> <span>Admin Panel</span></a></li>
            <hr style="border: none; border-top: 1px solid rgba(255,255,255,0.1); margin: 20px 0;">
            <li><button onclick="logout()" style="background: none; border: none; color: rgba(255,255,255,0.8); width: 100%; text-align: left; padding: 12px 15px; border-radius: 8px; cursor: pointer; display: flex; align-items: center; gap: 12px; font-size: inherit; font-family: inherit;"><i class="fas fa-sign-out-alt"></i> <span>Logout</span></button></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Header -->
        <div class="header">
            <div class="header-left">
                <h1>Kelas Saya</h1>
                <p>Kelola kelas-kelas yang Anda ikuti</p>
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

        <!-- Statistics -->
        <div class="stats-section">
            <div class="stat-card">
                <h4><i class="fas fa-book"></i> Total Kelas</h4>
                <div class="value" id="totalKelas">0</div>
            </div>
            <div class="stat-card" style="border-left-color: var(--secondary);">
                <h4><i class="fas fa-calendar"></i> Jadwal Minggu Ini</h4>
                <div class="value" style="color: var(--secondary);" id="kelasHariIni">0</div>
            </div>
            <div class="stat-card" style="border-left-color: var(--success);">
                <h4><i class="fas fa-check"></i> Status</h4>
                <div class="value" style="color: var(--success); font-size: 16px;">Aktif</div>
            </div>
        </div>

        <!-- Alert Messages -->
        <div id="alertContainer"></div>

        <!-- Kelas Table -->
        <div class="table-container">
            <div id="tableContainer">
                <div class="loading">
                    <div class="spinner"></div>
                    <p style="margin-top: 15px; color: #6b7280;">Memuat kelas Anda...</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Confirm Unenroll Modal -->
    <div class="modal fade" id="unenrollModal" tabindex="-1">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-exclamation-triangle" style="color: var(--warning);"></i> Konfirmasi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p id="unenrollMessage"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-danger" id="confirmUnenrollBtn">Ya, Batalkan</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const API_BASE = '/api';
        let currentUser = null;
        let pendingUnenroll = null;

        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            loadUserInfo();
            loadEnrolledKelas();
            setupEventListeners();
        });

        // Load user info from localStorage
        function loadUserInfo() {
            const userData = JSON.parse(localStorage.getItem('user') || '{}');
            currentUser = userData;
            document.getElementById('userName').textContent = userData.name || 'User';
            document.getElementById('userRole').textContent = userData.role || 'Mahasiswa';
        }

        // Load enrolled kelas
        function loadEnrolledKelas() {
            if (!currentUser || !currentUser.id) {
                showAlert('warning', 'Silakan login terlebih dahulu');
                return;
            }

            const token = localStorage.getItem('token');
            
            const headers = {
                'Content-Type': 'application/json'
            };
            
            if (token) {
                headers['Authorization'] = `Bearer ${token}`;
            }
            
            fetch(`${API_BASE}/mahasiswa/${currentUser.id}/kelas`, {
                method: 'GET',
                headers: headers
            })
            .then(response => {
                console.log('Response status:', response.status);
                console.log('Response headers:', response.headers.get('content-type'));
                
                if (!response.ok) {
                    if (response.status === 401) {
                        showAlert('error', 'Session expired. Please login again.');
                        setTimeout(() => window.location.href = '/login', 2000);
                        return null;
                    }
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.text().then(text => {
                    console.log('Response text:', text.substring(0, 200));
                    try {
                        return JSON.parse(text);
                    } catch (e) {
                        console.error('JSON parse error. Raw response:', text);
                        throw new Error('Invalid JSON response from server');
                    }
                });
            })
            .then(data => {
                if (!data) return; // Handle 401 case
                
                if (data.success) {
                    const kelas = data.data || [];
                    updateStats(kelas);
                    renderTable(kelas);
                } else {
                    showAlert('error', data.message || 'Gagal memuat data kelas');
                }
            })
            .catch(error => {
                console.error('Error loading enrolled kelas:', error);
                showAlert('error', 'Terjadi kesalahan saat memuat kelas: ' + error.message);
            });
        }

        // Update statistics
        function updateStats(kelas) {
            document.getElementById('totalKelas').textContent = kelas.length;
            
            // Count kelas with jadwal today
            const today = new Date().toLocaleString('id-ID', { weekday: 'long' });
            const kelasHariIni = kelas.filter(k => {
                const hari = k.jadwal?.hari || '';
                return hari.toLowerCase() === today.toLowerCase();
            }).length;
            
            document.getElementById('kelasHariIni').textContent = kelasHariIni;
        }

        // Render kelas table
        function renderTable(kelasData) {
            const container = document.getElementById('tableContainer');
            
            if (!kelasData || kelasData.length === 0) {
                container.innerHTML = `
                    <div class="empty-state">
                        <i class="fas fa-book"></i>
                        <h3>Belum Ada Kelas</h3>
                        <p>Anda belum mendaftar di kelas manapun.</p>
                        <a href="/kelas-browse" class="btn btn-primary mt-3" style="text-decoration: none;">
                            <i class="fas fa-plus"></i> Daftar Kelas Sekarang
                        </a>
                    </div>
                `;
                return;
            }

            let html = `
                <table class="table">
                    <thead>
                        <tr>
                            <th>Nama Kelas</th>
                            <th>Instruktur</th>
                            <th>Jadwal</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
            `;

            kelasData.forEach(kelas => {
                const instruktur = kelas.instruktur || {};
                const jadwalList = kelas.jadwal || [];
                const jadwal = jadwalList.length > 0 ? jadwalList[0] : {};
                const initials = (instruktur.nama || 'XX').split(' ').map(n => n[0]).join('').toUpperCase();

                html += `
                    <tr>
                        <td>
                            <strong>${kelas.nama_kelas}</strong>
                        </td>
                        <td>
                            <div class="instructor-info">
                                <div class="instructor-avatar">${initials}</div>
                                <span>${instruktur.nama || 'N/A'}</span>
                            </div>
                        </td>
                        <td>
                            <div class="schedule-info">
                                <span class="day"><i class="fas fa-calendar-day"></i> ${jadwal.hari ? jadwal.hari.nama_hari : '-'}</span>
                                <span class="time"><i class="fas fa-clock"></i> ${jadwal.jam_mulai || '-'} - ${jadwal.jam_selesai || '-'}</span>
                            </div>
                        </td>
                        <td>
                            <span class="badge-custom badge-active"><i class="fas fa-check-circle"></i> Aktif</span>
                        </td>
                        <td>
                            <div class="action-buttons">
                                <button class="btn-custom btn-view" onclick="viewDetail(${kelas.id})">
                                    <i class="fas fa-eye"></i> Lihat
                                </button>
                                <button class="btn-custom btn-unenroll" onclick="showUnenrollModal(${kelas.id}, '${kelas.nama_kelas}')">
                                    <i class="fas fa-times"></i> Batalkan
                                </button>
                            </div>
                        </td>
                    </tr>
                `;
            });

            html += `
                    </tbody>
                </table>
            `;

            container.innerHTML = html;
        }

        // Show unenroll modal
        function showUnenrollModal(kelasId, kelasName) {
            document.getElementById('unenrollMessage').textContent = `Apakah Anda yakin ingin membatalkan pendaftaran dari kelas "${kelasName}"?`;
            pendingUnenroll = { kelasId, kelasName };
            const modal = new bootstrap.Modal(document.getElementById('unenrollModal'));
            modal.show();
        }

        // Confirm unenroll
        function setupEventListeners() {
            document.getElementById('confirmUnenrollBtn').addEventListener('click', function() {
                if (pendingUnenroll) {
                    performUnenroll(pendingUnenroll.kelasId);
                }
            });
        }

        // Perform unenroll
        function performUnenroll(kelasId) {
            if (!currentUser || !currentUser.id) {
                showAlert('warning', 'Silakan login terlebih dahulu');
                return;
            }

            const token = localStorage.getItem('token');
            const btn = document.getElementById('confirmUnenrollBtn');
            const originalText = btn.innerHTML;
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memproses...';

            fetch(`${API_BASE}/mahasiswa/${currentUser.id}/kelas/${kelasId}/unenroll`, {
                method: 'DELETE',
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showAlert('success', 'Berhasil membatalkan pendaftaran kelas');
                    bootstrap.Modal.getInstance(document.getElementById('unenrollModal')).hide();
                    setTimeout(() => {
                        loadEnrolledKelas();
                        btn.disabled = false;
                        btn.innerHTML = originalText;
                    }, 1500);
                } else {
                    btn.disabled = false;
                    btn.innerHTML = originalText;
                    showAlert('error', data.message || 'Gagal membatalkan pendaftaran');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                btn.disabled = false;
                btn.innerHTML = originalText;
                showAlert('error', 'Terjadi kesalahan saat membatalkan pendaftaran');
            });
        }

        // View detail
        function viewDetail(kelasId) {
            window.location.href = `/kelas/${kelasId}`;
        }

        // Show alert
        function showAlert(type, message) {
            const alertContainer = document.getElementById('alertContainer');
            const alertId = 'alert-' + Date.now();
            const bgColor = type === 'success' ? 'alert-success' : type === 'error' ? 'alert-danger' : type === 'warning' ? 'alert-warning' : 'alert-info';
            
            const alertHTML = `
                <div id="${alertId}" class="alert ${bgColor} alert-dismissible fade show" role="alert">
                    <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : type === 'warning' ? 'exclamation-triangle' : 'info-circle'}"></i>
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
    <script src="{{ asset('js/sidebar-menu.js') }}"></script>
</body>
</html>
