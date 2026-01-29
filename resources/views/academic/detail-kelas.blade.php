<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Kelas - Sistem Akademik</title>
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
        .btn-back { padding: 10px 20px; background: #e5e7eb; color: #1f2937; border: none; border-radius: 8px; cursor: pointer; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; }
        .btn-back:hover { background: #d1d5db; }
        
        .kelas-header {
            background: white; border-radius: 10px; padding: 30px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            margin-bottom: 30px; border-left: 5px solid var(--primary);
        }
        
        .kelas-header h2 { color: #1f2937; margin-bottom: 10px; }
        .kelas-code { color: #6b7280; font-size: 14px; margin-bottom: 15px; }
        
        .kelas-info { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-top: 20px; }
        .info-item { }
        .info-label { font-size: 12px; color: #6b7280; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 5px; }
        .info-value { font-size: 18px; font-weight: 700; color: #1f2937; }
        .info-value.status-aktif { color: var(--success); }
        
        .card-section {
            background: white; border-radius: 10px; padding: 25px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            margin-bottom: 25px;
        }
        
        .section-title { 
            font-size: 18px; font-weight: 700; color: #1f2937; margin-bottom: 20px;
            display: flex; align-items: center; gap: 10px;
        }
        
        .section-title i { color: var(--primary); }
        
        .instruktur-card {
            display: flex; align-items: center; gap: 20px; padding: 20px;
            background: #f9fafb; border-radius: 10px; border-left: 3px solid var(--secondary);
        }
        
        .instruktur-avatar {
            width: 80px; height: 80px; border-radius: 50%; background: var(--secondary);
            color: white; display: flex; align-items: center; justify-content: center;
            font-size: 32px; font-weight: 700;
        }
        
        .instruktur-info { flex: 1; }
        .instruktur-info h4 { margin: 0 0 5px 0; color: #1f2937; }
        .instruktur-info p { margin: 5px 0; color: #6b7280; font-size: 14px; }
        
        .jadwal-grid { display: grid; gap: 15px; }
        
        .jadwal-card {
            display: flex; align-items: center; padding: 15px; background: #f9fafb;
            border-radius: 8px; border-left: 3px solid var(--success);
        }
        
        .jadwal-time { font-weight: 700; color: var(--primary); min-width: 120px; }
        .jadwal-details { flex: 1; padding-left: 20px; border-left: 1px solid #e5e7eb; }
        .jadwal-day { font-weight: 600; color: #1f2937; }
        .jadwal-room { font-size: 13px; color: #6b7280; margin-top: 3px; }
        
        .peserta-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 15px; }
        
        .peserta-card {
            padding: 15px; background: #f9fafb; border-radius: 8px;
            border: 1px solid #e5e7eb; text-align: center;
        }
        
        .peserta-avatar {
            width: 50px; height: 50px; border-radius: 50%; background: var(--primary);
            color: white; display: flex; align-items: center; justify-content: center;
            font-weight: 700; margin: 0 auto 10px;
        }
        
        .peserta-name { font-weight: 600; color: #1f2937; margin-bottom: 3px; }
        .peserta-nim { font-size: 12px; color: #6b7280; }
        
        .action-buttons { display: flex; gap: 10px; margin-top: 20px; }
        
        .btn-custom {
            padding: 10px 20px; border-radius: 8px; border: none; font-weight: 600;
            cursor: pointer; transition: all 0.3s; display: inline-flex; align-items: center; gap: 8px;
            font-size: 14px;
        }
        
        .btn-unenroll { background: var(--danger); color: white; }
        .btn-unenroll:hover { background: #dc2626; }
        
        .btn-enroll { background: var(--success); color: white; }
        .btn-enroll:hover { background: #059669; }
        
        .alert { border-radius: 8px; border: none; margin-bottom: 20px; }
        
        .loading { text-align: center; padding: 40px; }
        .spinner { border: 4px solid #e5e7eb; border-top: 4px solid var(--primary); border-radius: 50%; width: 40px; height: 40px; animation: spin 1s linear infinite; margin: 0 auto; }
        @keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }
        
        @media (max-width: 768px) {
            .sidebar { width: 70px; }
            .sidebar-menu a span { display: none; }
            .main-content { margin-left: 70px; padding: 15px; }
            .header { flex-direction: column; gap: 15px; }
            .kelas-info { grid-template-columns: 1fr; }
            .instruktur-card { flex-direction: column; text-align: center; }
            .peserta-grid { grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); }
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
            <li data-role="mahasiswa all"><a href="/kelas-saya"><i class="fas fa-graduation-cap"></i> <span>Kelas Saya</span></a></li>
            <li data-role="instruktur admin" style="margin-top: 20px;"><a href="/risalah"><i class="fas fa-file-alt"></i> <span>Risalah</span></a></li>
            <li data-role="admin" style="margin-top: 20px;"><a href="/data-management"><i class="fas fa-database"></i> <span>Data Management</span></a></li>
            <hr style="border: none; border-top: 1px solid rgba(255,255,255,0.1); margin: 20px 0;">
            <li><button onclick="logout()" style="background: none; border: none; color: rgba(255,255,255,0.8); width: 100%; text-align: left; padding: 12px 15px; border-radius: 8px; cursor: pointer; display: flex; align-items: center; gap: 12px; font-size: inherit; font-family: inherit;"><i class="fas fa-sign-out-alt"></i> <span>Logout</span></button></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Header -->
        <div class="header">
            <div class="header-left">
                <h1>Detail Kelas</h1>
                <p>Informasi lengkap kelas</p>
            </div>
            <div class="header-right">
                <a href="/kelas-saya" class="btn-back"><i class="fas fa-arrow-left"></i> Kembali</a>
            </div>
        </div>

        <!-- Alert Container -->
        <div id="alertContainer"></div>

        <!-- Content Loading -->
        <div id="contentContainer">
            <div class="loading">
                <div class="spinner"></div>
                <p style="margin-top: 15px; color: #6b7280;">Memuat data kelas...</p>
            </div>
        </div>
    </div>

    <!-- Modal Confirm Unenroll -->
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
        let kelasData = null;
        let pendingUnenroll = null;

        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            // Extract kelasId from URL path (e.g., /kelas/7)
            const pathParts = window.location.pathname.split('/');
            const kelasId = pathParts[pathParts.length - 1];
            
            if (!kelasId || isNaN(kelasId)) {
                showAlert('error', 'ID kelas tidak valid');
                setTimeout(() => window.location.href = '/kelas-saya', 2000);
                return;
            }
            
            loadUserInfo();
            loadKelasDetail(kelasId);
            setupEventListeners();
        });

        // Load user info
        function loadUserInfo() {
            const userData = JSON.parse(localStorage.getItem('user') || '{}');
            currentUser = userData;
        }

        // Load kelas detail
        function loadKelasDetail(kelasId) {
            const token = localStorage.getItem('token');
            const headers = { 'Content-Type': 'application/json' };
            
            if (token) {
                headers['Authorization'] = `Bearer ${token}`;
            }
            
            fetch(`${API_BASE}/kelas/${kelasId}`, {
                method: 'GET',
                headers: headers
            })
            .then(response => {
                if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    kelasData = data.data;
                    renderDetail();
                } else {
                    showAlert('error', data.message || 'Gagal memuat data kelas');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showAlert('error', 'Terjadi kesalahan saat memuat data kelas');
            });
        }

        // Render detail
        function renderDetail() {
            const container = document.getElementById('contentContainer');
            const instruktur = kelasData.instruktur || {};
            const jadwalList = kelasData.jadwal || [];
            const mahasiswa = kelasData.mahasiswa || [];
            
            // Check if current user is enrolled
            const isEnrolled = currentUser && mahasiswa.some(m => m.user_id == currentUser.id);
            
            let html = `
                <!-- Kelas Header -->
                <div class="kelas-header">
                    <h2>${kelasData.nama_kelas || 'N/A'}</h2>
                    <div class="kelas-code"><strong>Kode:</strong> ${kelasData.kode_kelas || 'N/A'}</div>
                    
                    <div class="kelas-info">
                        <div class="info-item">
                            <div class="info-label"><i class="fas fa-users"></i> Peserta</div>
                            <div class="info-value">${mahasiswa.length}/${kelasData.kapasitas || 0}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label"><i class="fas fa-calendar"></i> Tahun Akademik</div>
                            <div class="info-value">${kelasData.tahun_akademik || '-'}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label"><i class="fas fa-check-circle"></i> Status</div>
                            <div class="info-value status-aktif">${kelasData.status === 'aktif' ? 'Aktif' : 'Selesai'}</div>
                        </div>
                    </div>
                    
                    <div class="action-buttons">
            `;
            
            if (isEnrolled) {
                html += `<button class="btn-custom btn-unenroll" onclick="showUnenrollModal('${kelasData.id}', '${kelasData.nama_kelas}')">
                            <i class="fas fa-times"></i> Batalkan Pendaftaran
                        </button>`;
            } else {
                html += `<button class="btn-custom btn-enroll" onclick="performEnroll('${kelasData.id}')">
                            <i class="fas fa-check"></i> Daftar Kelas
                        </button>`;
            }
            
            html += `
                    </div>
                </div>
            `;
            
            // Instruktur Section
            html += `
                <div class="card-section">
                    <div class="section-title"><i class="fas fa-chalkboard-user"></i> Instruktur</div>
                    <div class="instruktur-card">
                        <div class="instruktur-avatar">
                            ${(instruktur.nama || 'XX').split(' ').map(n => n[0]).join('').toUpperCase()}
                        </div>
                        <div class="instruktur-info">
                            <h4>${instruktur.nama || 'N/A'}</h4>
                            <p><strong>NIP:</strong> ${instruktur.nip || '-'}</p>
                            <p><strong>Spesialisasi:</strong> ${instruktur.spesialisasi || '-'}</p>
                            <p><strong>Kontak:</strong> ${instruktur.no_hp || '-'}</p>
                        </div>
                    </div>
                </div>
            `;
            
            // Jadwal Section
            html += `
                <div class="card-section">
                    <div class="section-title"><i class="fas fa-calendar-days"></i> Jadwal Kelas</div>
                    <div class="jadwal-grid">
            `;
            
            if (jadwalList.length > 0) {
                jadwalList.forEach(jadwal => {
                    const hari = jadwal.hari || {};
                    html += `
                        <div class="jadwal-card">
                            <div class="jadwal-time">${jadwal.jam_mulai || '-'}</div>
                            <div class="jadwal-details">
                                <div class="jadwal-day"><i class="fas fa-calendar"></i> ${hari.nama_hari || '-'}</div>
                                <div class="jadwal-room"><i class="fas fa-door-open"></i> Ruangan: ${jadwal.ruangan || 'Belum ditentukan'}</div>
                                <div class="jadwal-room"><i class="fas fa-clock"></i> ${jadwal.jam_mulai || '-'} - ${jadwal.jam_selesai || '-'}</div>
                            </div>
                        </div>
                    `;
                });
            } else {
                html += `<p style="color: #6b7280; text-align: center; padding: 20px;">Belum ada jadwal</p>`;
            }
            
            html += `
                    </div>
                </div>
            `;
            
            // Deskripsi Section
            if (kelasData.deskripsi) {
                html += `
                    <div class="card-section">
                        <div class="section-title"><i class="fas fa-file-lines"></i> Deskripsi</div>
                        <p style="color: #4b5563; line-height: 1.6;">${kelasData.deskripsi}</p>
                    </div>
                `;
            }
            
            // Peserta Section
            html += `
                <div class="card-section">
                    <div class="section-title"><i class="fas fa-people-group"></i> Peserta Terdaftar (${mahasiswa.length})</div>
            `;
            
            if (mahasiswa.length > 0) {
                html += `<div class="peserta-grid">`;
                mahasiswa.forEach(m => {
                    const initials = (m.nama || 'XX').split(' ').map(n => n[0]).join('').toUpperCase();
                    html += `
                        <div class="peserta-card">
                            <div class="peserta-avatar">${initials}</div>
                            <div class="peserta-name">${m.nama || 'N/A'}</div>
                            <div class="peserta-nim">${m.nim || 'N/A'}</div>
                        </div>
                    `;
                });
                html += `</div>`;
            } else {
                html += `<p style="color: #6b7280; text-align: center; padding: 20px;">Belum ada peserta terdaftar</p>`;
            }
            
            html += `</div>`;
            
            container.innerHTML = html;
        }

        // Show unenroll modal
        function showUnenrollModal(kelasId, kelasName) {
            document.getElementById('unenrollMessage').textContent = `Apakah Anda yakin ingin membatalkan pendaftaran dari kelas "${kelasName}"?`;
            pendingUnenroll = { kelasId, kelasName };
            const modal = new bootstrap.Modal(document.getElementById('unenrollModal'));
            modal.show();
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
                        window.location.href = '/kelas-saya';
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

        // Perform enroll
        function performEnroll(kelasId) {
            if (!currentUser || !currentUser.id) {
                showAlert('warning', 'Silakan login terlebih dahulu');
                return;
            }

            const token = localStorage.getItem('token');
            
            fetch(`${API_BASE}/mahasiswa/${currentUser.id}/kelas/${kelasId}/enroll`, {
                method: 'POST',
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showAlert('success', 'Berhasil mendaftar kelas');
                    setTimeout(() => {
                        location.reload();
                    }, 1500);
                } else {
                    showAlert('error', data.message || 'Gagal mendaftar kelas');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showAlert('error', 'Terjadi kesalahan saat mendaftar kelas');
            });
        }

        // Setup event listeners
        function setupEventListeners() {
            document.getElementById('confirmUnenrollBtn').addEventListener('click', function() {
                if (pendingUnenroll) {
                    performUnenroll(pendingUnenroll.kelasId);
                }
            });
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
            
            if (type === 'success' || type === 'info') {
                setTimeout(() => {
                    const alert = document.getElementById(alertId);
                    if (alert) {
                        alert.remove();
                    }
                }, 4000);
            }
        }

        // Logout
        function logout() {
            const token = localStorage.getItem('token');
            if (token) {
                fetch(`${API_BASE}/auth/logout`, {
                    method: 'POST',
                    headers: {
                        'Authorization': `Bearer ${token}`,
                        'Content-Type': 'application/json'
                    }
                }).then(() => {
                    localStorage.clear();
                    window.location.href = '/login';
                });
            } else {
                localStorage.clear();
                window.location.href = '/login';
            }
        }
    </script>
    <script src="{{ asset('js/sidebar-menu.js') }}"></script>
</body>
</html>
