<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Management - Sistem Akademik</title>
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
            overflow-y: auto;
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
        
        .card-container { background: white; padding: 25px; border-radius: 10px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
        .card-header { 
            display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;
            border-bottom: 2px solid #e5e7eb; padding-bottom: 15px;
        }
        
        .btn-group-custom { display: flex; gap: 10px; margin-bottom: 20px; }
        .btn-custom { 
            padding: 10px 15px; border-radius: 8px; border: none; cursor: pointer;
            font-weight: 600; transition: all 0.3s;
        }
        .btn-primary-custom { background: var(--primary); color: white; }
        .btn-primary-custom:hover { background: var(--primary-dark); }
        .btn-secondary-custom { background: #e5e7eb; color: #374151; }
        .btn-secondary-custom:hover { background: #d1d5db; }
        
        .table-custom { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .table-custom th { 
            background: #f3f4f6; padding: 12px; text-align: left; font-weight: 600;
            border-bottom: 2px solid #e5e7eb; color: #374151;
        }
        .table-custom td { padding: 12px; border-bottom: 1px solid #e5e7eb; }
        .table-custom tr:hover { background: #f9fafb; }
        
        .alert-info { background: #dbeafe; border-left: 4px solid #3b82f6; padding: 15px; border-radius: 5px; }
        .alert-success { background: #dcfce7; border-left: 4px solid #10b981; padding: 15px; border-radius: 5px; }
        .alert-warning { background: #fef3c7; border-left: 4px solid #f59e0b; padding: 15px; border-radius: 5px; }
        .alert-danger { background: #fee2e2; border-left: 4px solid #ef4444; padding: 15px; border-radius: 5px; }
        
        .modal-overlay { 
            display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center;
        }
        .modal-overlay.active { display: flex; }
        .modal-content { 
            background: white; padding: 20px; border-radius: 10px; max-width: 550px; width: 90%;
            max-height: 85vh; overflow-y: auto;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
        }
        
        .form-group { margin-bottom: 10px; }
        .form-group label { display: block; margin-bottom: 3px; font-weight: 600; color: #374151; font-size: 12px; }
        .form-group input, .form-group select, .form-group textarea { 
            width: 100%; padding: 6px 8px; border: 1px solid #d1d5db; border-radius: 4px;
            font-size: 13px;
        }
        
        .form-grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
        .form-grid-2 .form-group { margin-bottom: 0; }
        
        .badge-role {
            display: inline-block; padding: 5px 10px; border-radius: 20px; font-size: 12px; font-weight: 600;
        }
        .badge-admin { background: #dbeafe; color: #1e40af; }
        .badge-instruktur { background: #fce7f3; color: #831843; }
        .badge-mahasiswa { background: #d1fae5; color: #065f46; }
        
        @media (max-width: 768px) {
            .sidebar { width: 70px; }
            .sidebar-menu a span { display: none; }
            .main-content { margin-left: 70px; }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-brand">
            <i class="fas fa-graduation-cap"></i> <span>Akademik</span>
        </div>
        <ul class="sidebar-menu" id="sidebarMenu">
            <li data-role="admin"><a href="#" onclick="selectModule('mahasiswa'); return false;" class="nav-link active" data-module="mahasiswa"><i class="fas fa-users-circle"></i> <span>Mahasiswa</span></a></li>
            <li data-role="admin"><a href="#" onclick="selectModule('instruktur'); return false;" class="nav-link" data-module="instruktur"><i class="fas fa-chalkboard-user"></i> <span>Instruktur</span></a></li>
            <li data-role="admin"><a href="#" onclick="selectModule('kelas'); return false;" class="nav-link" data-module="kelas"><i class="fas fa-book"></i> <span>Kelas</span></a></li>
            <li data-role="admin"><a href="#" onclick="selectModule('jadwal'); return false;" class="nav-link" data-module="jadwal"><i class="fas fa-calendar"></i> <span>Jadwal</span></a></li>
            <li data-role="instruktur admin" style="margin-top: 20px;"><a href="/risalah-dashboard-new" class="nav-link"><i class="fas fa-file-alt"></i> <span>Risalah</span></a></li>
            <hr style="border: none; border-top: 1px solid rgba(255,255,255,0.1); margin: 20px 0;">
            <li><a href="#" onclick="logout(); return false;"><i class="fas fa-sign-out-alt"></i> <span>Logout</span></a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Header -->
        <div class="header">
            <div class="header-left">
                <h1 id="pageTitle">Data Mahasiswa</h1>
                <p id="pageDesc">Manage student data</p>
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

        <!-- Content Area -->
        <div class="card-container">
            <div class="card-header">
                <h3 style="margin: 0;" id="moduleTitle">Mahasiswa</h3>
                <button class="btn-custom btn-primary-custom" onclick="openAddModal(); return false;" id="btnAdd">
                    <i class="fas fa-plus"></i> Add New
                </button>
            </div>

            <!-- Permission Alert -->
            <div class="alert-warning" id="permissionAlert" style="display: none; margin-bottom: 20px;">
                <i class="fas fa-info-circle"></i> <strong>Info:</strong> <span id="alertMessage"></span>
            </div>

            <!-- Data Table -->
            <div style="overflow-x: auto;">
                <table class="table-custom" id="dataTable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="tableBody">
                        <tr>
                            <td colspan="6" style="text-align: center; color: #9ca3af;">Loading...</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Add/Edit Modal -->
    <div class="modal-overlay" id="formModal">
        <div class="modal-content">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                <h4 style="margin: 0; font-size: 16px;" id="modalTitle">Add Mahasiswa</h4>
                <button onclick="closeModal(); return false;" style="background: none; border: none; font-size: 20px; cursor: pointer; padding: 0;">×</button>
            </div>
            <form id="dataForm" onsubmit="submitForm(event); return false;">
                <!-- User Fields -->
                <div class="form-group" id="fieldName">
                    <label>Name *</label>
                    <input type="text" id="formName">
                </div>
                <div class="form-group" id="fieldEmail">
                    <label>Email *</label>
                    <input type="email" id="formEmail">
                </div>
                <div class="form-group" id="fieldPassword">
                    <label>Password</label>
                    <input type="password" id="formPassword" placeholder="Default: password123">
                </div>
                <div class="form-group" id="fieldRole">
                    <label>Role *</label>
                    <select id="formRole">
                        <option value="">-- Loading --</option>
                    </select>
                </div>
                <div class="form-group" id="fieldStatus">
                    <label>Status</label>
                    <select id="formStatus">
                        <option value="">-- Loading --</option>
                    </select>
                </div>

                <!-- Kelas Fields -->
                <div class="form-group" id="fieldKelasInstruktur" style="display: none;">
                    <label>Instruktur *</label>
                    <select id="formInstruktur">
                        <option value="">-- Select Instruktur --</option>

                    </select>
                </div>
                <div class="form-group" id="fieldKodeKelas" style="display: none;">
                    <label>Kode Kelas *</label>
                    <input type="text" id="formKodeKelas" placeholder="e.g., 12A1">
                </div>
                <div class="form-group" id="fieldNamaKelas" style="display: none;">
                    <label>Nama Kelas *</label>
                    <input type="text" id="formNamaKelas" placeholder="e.g., English 101">
                </div>
                <div class="form-group" id="fieldKapasitas" style="display: none;">
                    <label>Kapasitas *</label>
                    <input type="number" id="formKapasitas" min="1" placeholder="e.g., 30">
                </div>
                <div class="form-group" id="fieldTahunAkademik" style="display: none;">
                    <label>Tahun Akademik *</label>
                    <input type="text" id="formTahunAkademik" placeholder="e.g., 2024/2025">
                </div>

                <!-- Jadwal Fields -->
                <div class="form-group" id="fieldJadwalKelas" style="display: none;">
                    <label>Kelas *</label>
                    <select id="formJadwalKelas" onchange="onKelasChange()">
                        <option value="">-- Select Kelas --</option>
                    </select>
                </div>
                <div class="form-group" id="fieldJadwalInstruktur" style="display: none;">
                    <label>Instruktur</label>
                    <input type="text" id="formJadwalInstrukturDisplay" readonly style="background-color: #f5f5f5; cursor: not-allowed;">
                    <input type="hidden" id="formJadwalInstruktur">
                </div>
                <div class="form-group" id="fieldHari" style="display: none;">
                    <label>Hari *</label>
                    <select id="formHari">
                        <option value="">-- Loading --</option>
                    </select>
                </div>
                <div class="form-group" id="fieldJamMulai" style="display: none;">
                    <label>Jam Mulai *</label>
                    <input type="time" id="formJamMulai">
                </div>
                <div class="form-group" id="fieldJamSelesai" style="display: none;">
                    <label>Jam Selesai *</label>
                    <input type="time" id="formJamSelesai">
                </div>
                <div class="form-group" id="fieldRuangan" style="display: none;">
                    <label>Ruangan *</label>
                    <input type="text" id="formRuangan" placeholder="e.g., Ruang 101">
                </div>

                <!-- Instruktur Fields -->
                <div class="form-grid-2">
                    <div class="form-group" id="fieldInstrukturNama" style="display: none;">
                        <label>Nama *</label>
                        <input type="text" id="formInstrukturNama" placeholder="Nama instruktur">
                    </div>
                    <div class="form-group" id="fieldNip" style="display: none;">
                        <label>NIP *</label>
                        <input type="text" id="formNip" placeholder="NIP-001">
                    </div>
                    <div class="form-group" id="fieldKeahlian" style="display: none;">
                        <label>Keahlian</label>
                        <input type="text" id="formKeahlian" placeholder="e.g., Programming">
                    </div>
                    <div class="form-group" id="fieldSpesialisasi" style="display: none;">
                        <label>Spesialisasi</label>
                        <input type="text" id="formSpesialisasi" placeholder="Web Dev">
                    </div>
                    <div class="form-group" id="fieldNoHp" style="display: none;">
                        <label>No. HP</label>
                        <input type="text" id="formNoHp" placeholder="081234567890">
                    </div>
                    <div class="form-group" id="fieldAlamat" style="display: none; grid-column: 1 / -1;">
                        <label>Alamat</label>
                        <textarea id="formAlamat" placeholder="Alamat lengkap" style="height: 45px; resize: vertical;"></textarea>
                    </div>
                </div>

                <!-- Mahasiswa Fields -->
                <div class="form-grid-2">
                    <div class="form-group" id="fieldMahasiswaNama" style="display: none;">
                        <label>Nama *</label>
                        <input type="text" id="formMahasiswaNama" placeholder="Nama mahasiswa">
                    </div>
                    <div class="form-group" id="fieldNim" style="display: none;">
                        <label>NIM *</label>
                        <input type="text" id="formNim" placeholder="NIM-001">
                    </div>
                    <div class="form-group" id="fieldJurusan" style="display: none;">
                        <label>Jurusan</label>
                        <input type="text" id="formJurusan" placeholder="Teknik Informatika">
                    </div>
                    <div class="form-group" id="fieldAngkatan" style="display: none;">
                        <label>Angkatan</label>
                        <input type="number" id="formAngkatan" placeholder="2024" min="1900" max="2099">
                    </div>
                    <div class="form-group" id="fieldMahasiswaNoHp" style="display: none;">
                        <label>No. HP</label>
                        <input type="text" id="formMahasiswaNoHp" placeholder="081234567890">
                    </div>
                    <div class="form-group" id="fieldMahasiswaAlamat" style="display: none; grid-column: 1 / -1;">
                        <label>Alamat</label>
                        <textarea id="formMahasiswaAlamat" placeholder="Alamat lengkap" style="height: 45px; resize: vertical;"></textarea>
                    </div>
                </div>

                <!-- Disposisi/Surat Fields -->
                <div class="form-group" id="fieldSuratMasukId" style="display: none;">
                    <label>Surat Masuk *</label>
                    <select id="formSuratMasukId">
                        <option value="">-- Select Surat --</option>
                    </select>
                </div>
                <div class="form-group" id="fieldDisposisiUserId" style="display: none;">
                    <label>User (Penerima) *</label>
                    <select id="formDisposisiUserId">
                        <option value="">-- Select User --</option>
                    </select>
                </div>
                <div class="form-group" id="fieldDisposisiCatatan" style="display: none;">
                    <label>Catatan</label>
                    <textarea id="formDisposisiCatatan" placeholder="Catatan disposisi" style="height: 80px; resize: vertical;"></textarea>
                </div>
                <div class="form-group" id="fieldDisposisiStatus" style="display: none;">
                    <label>Status</label>
                    <select id="formDisposisiStatus">
                        <option value="">-- Select Status --</option>
                        <option value="pending">Pending</option>
                        <option value="in_progress">In Progress</option>
                        <option value="completed">Completed</option>
                    </select>
                </div>
                <div class="form-group" id="fieldDisposisiTanggal" style="display: none;">
                    <label>Tanggal Disposisi</label>
                    <input type="date" id="formDisposisiTanggal">
                </div>

                <div style="display: flex; gap: 8px; justify-content: flex-end; margin-top: 15px;">
                    <button type="button" class="btn-custom btn-secondary-custom" onclick="closeModal(); return false;" style="padding: 8px 15px; font-size: 12px;">Cancel</button>
                    <button type="submit" class="btn-custom btn-primary-custom" style="padding: 8px 15px; font-size: 12px;">Save</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const API_BASE = '{{ config("app.url") }}/api';
        let currentModule = 'mahasiswa';
        let currentUser = {};

        // ========== AUTH CHECK ==========
        function checkAuth() {
            const token = localStorage.getItem('auth_token');
            const user = JSON.parse(localStorage.getItem('user') || '{}');
            
            if (!token) {
                window.location.href = '{{ route("login") }}';
                return false;
            }
            
            currentUser = user;
            return true;
        }

        // ========== PAGE LOAD ==========
        document.addEventListener('DOMContentLoaded', () => {
            if (!checkAuth()) return;
            
            // Set user info
            document.getElementById('userName').textContent = currentUser.name || 'User';
            document.getElementById('userRole').textContent = currentUser.role?.toUpperCase() || 'ROLE';
            
            // Load initial data
            loadModuleData('mahasiswa');
        });

        // ========== MODULE SELECTION ==========
        function selectModule(module) {
            currentModule = module;
            
            // Update active nav
            document.querySelectorAll('.nav-link').forEach(link => link.classList.remove('active'));
            document.querySelector(`[data-module="${module}"]`).classList.add('active');
            
            // Load data
            loadModuleData(module);
        }

        // ========== LOAD MODULE DATA ==========
        async function loadModuleData(module) {
            const config = {
                mahasiswa: { title: 'Data Mahasiswa', desc: 'Manage student information', endpoint: 'mahasiswa' },
                instruktur: { title: 'Data Instruktur', desc: 'Manage instructor information', endpoint: 'instruktur' },
                kelas: { title: 'Data Kelas', desc: 'Manage classes', endpoint: 'kelas' },
                jadwal: { title: 'Data Jadwal', desc: 'Manage schedules', endpoint: 'jadwal' }
            };

            const cfg = config[module] || config.mahasiswa;
            document.getElementById('pageTitle').textContent = cfg.title;
            document.getElementById('pageDesc').textContent = cfg.desc;
            document.getElementById('moduleTitle').textContent = cfg.title;

            // Check permissions
            const canCreate = checkPermission('create', module);
            document.getElementById('btnAdd').style.display = canCreate ? 'block' : 'none';
            
            if (!canCreate) {
                document.getElementById('permissionAlert').style.display = 'block';
                document.getElementById('alertMessage').textContent = `You don't have permission to create ${module}`;
            } else {
                document.getElementById('permissionAlert').style.display = 'none';
            }

            // Load data from API
            try {
                const token = localStorage.getItem('auth_token');
                const response = await fetch(`${API_BASE}/${cfg.endpoint}`, {
                    headers: { 'Authorization': `Bearer ${token}` }
                });

                if (response.ok) {
                    const data = await response.json();
                    renderTable(data.data || data, module);
                } else {
                    document.getElementById('tableBody').innerHTML = `
                        <tr><td colspan="6" style="text-align: center; color: #ef4444;">
                            <i class="fas fa-exclamation-circle"></i> Failed to load data
                        </td></tr>
                    `;
                }
            } catch (error) {
                console.error('Error loading data:', error);
                document.getElementById('tableBody').innerHTML = `
                    <tr><td colspan="6" style="text-align: center; color: #ef4444;">
                        <i class="fas fa-exclamation-circle"></i> Error: ${error.message}
                    </td></tr>
                `;
            }
        }

        // ========== PERMISSION CHECK ==========
        function checkPermission(action, module) {
            const role = currentUser.role;
            
            // Define permissions per role
            const permissions = {
                admin: { create: true, read: true, update: true, delete: true },
                instruktur: { create: false, read: true, update: false, delete: false },
                mahasiswa: { create: false, read: true, update: false, delete: false }
            };

            return (permissions[role] || {})[action] || false;
        }

        // ========== RENDER TABLE ==========
        function renderTable(data, module) {
            const tbody = document.getElementById('tableBody');
            if (!Array.isArray(data) || data.length === 0) {
                tbody.innerHTML = `<tr><td colspan="8" style="text-align: center; color: #9ca3af;">No data available</td></tr>`;
                return;
            }

            if (module === 'kelas') {
                updateTableHeaders(['ID', 'Kode', 'Nama Kelas', 'Instruktur', 'Kapasitas', 'Tahun', 'Actions']);
                tbody.innerHTML = data.map(item => `
                    <tr>
                        <td>${item.id}</td>
                        <td>${item.kode_kelas}</td>
                        <td><strong>${item.nama_kelas}</strong></td>
                        <td>${item.instruktur?.nama || '-'}</td>
                        <td>${item.kapasitas}</td>
                        <td>${item.tahun_akademik}</td>
                        <td>
                            ${checkPermission('update', module) ? `<button class="btn-custom btn-secondary-custom" onclick="editItem(${item.id}); return false;" style="padding: 5px 10px; font-size: 12px;"><i class="fas fa-edit"></i></button>` : ''}
                            ${checkPermission('delete', module) ? `<button class="btn-custom" style="background: #ef4444; color: white; padding: 5px 10px; font-size: 12px; cursor: pointer;" onclick="deleteItem(${item.id}); return false;"><i class="fas fa-trash"></i></button>` : ''}
                        </td>
                    </tr>
                `).join('');
            } else if (module === 'jadwal') {
                updateTableHeaders(['ID', 'Kelas', 'Instruktur', 'Hari', 'Mulai', 'Selesai', 'Ruangan', 'Actions']);
                const hariMap = {1:'Senin', 2:'Selasa', 3:'Rabu', 4:'Kamis', 5:'Jumat', 6:'Sabtu'};
                tbody.innerHTML = data.map(item => `
                    <tr>
                        <td>${item.id}</td>
                        <td><strong>${item.kelas?.nama_kelas || '-'}</strong></td>
                        <td>${item.instruktur?.nama || '-'}</td>
                        <td>${hariMap[item.hari_id] || '-'}</td>
                        <td>${item.jam_mulai || '-'}</td>
                        <td>${item.jam_selesai || '-'}</td>
                        <td>${item.ruangan || '-'}</td>
                        <td>
                            ${checkPermission('update', module) ? `<button class="btn-custom btn-secondary-custom" onclick="editItem(${item.id}); return false;" style="padding: 5px 10px; font-size: 12px;"><i class="fas fa-edit"></i></button>` : ''}
                            ${checkPermission('delete', module) ? `<button class="btn-custom" style="background: #ef4444; color: white; padding: 5px 10px; font-size: 12px; cursor: pointer;" onclick="deleteItem(${item.id}); return false;"><i class="fas fa-trash"></i></button>` : ''}
                        </td>
                    </tr>
                `).join('');
            } else if (module === 'instruktur') {
                updateTableHeaders(['Nama', 'NIP', 'Spesialisasi', 'No HP', 'Alamat', 'Actions']);
                tbody.innerHTML = data.map(item => `
                    <tr>
                        <td><strong>${item.nama || '-'}</strong></td>
                        <td>${item.nip || '-'}</td>
                        <td>${item.spesialisasi || '-'}</td>
                        <td>${item.no_hp || '-'}</td>
                        <td>${item.alamat || '-'}</td>
                        <td>
                            ${checkPermission('update', module) ? `<button class="btn-custom btn-secondary-custom" onclick="editItem(${item.id}); return false;" style="padding: 5px 10px; font-size: 12px;"><i class="fas fa-edit"></i></button>` : ''}
                            ${checkPermission('delete', module) ? `<button class="btn-custom" style="background: #ef4444; color: white; padding: 5px 10px; font-size: 12px; cursor: pointer;" onclick="deleteItem(${item.id}); return false;"><i class="fas fa-trash"></i></button>` : ''}
                        </td>
                    </tr>
                `).join('');
            } else if (module === 'mahasiswa') {
                updateTableHeaders(['Nama', 'NIM', 'Jurusan', 'Angkatan', 'No HP', 'Alamat', 'Actions']);
                tbody.innerHTML = data.map(item => `
                    <tr>
                        <td><strong>${item.nama || '-'}</strong></td>
                        <td>${item.nim || '-'}</td>
                        <td>${item.jurusan || '-'}</td>
                        <td>${item.angkatan || '-'}</td>
                        <td>${item.no_hp || '-'}</td>
                        <td>${item.alamat || '-'}</td>
                        <td>
                            ${checkPermission('update', module) ? `<button class="btn-custom btn-secondary-custom" onclick="editItem(${item.id}); return false;" style="padding: 5px 10px; font-size: 12px;"><i class="fas fa-edit"></i></button>` : ''}
                            ${checkPermission('delete', module) ? `<button class="btn-custom" style="background: #ef4444; color: white; padding: 5px 10px; font-size: 12px; cursor: pointer;" onclick="deleteItem(${item.id}); return false;"><i class="fas fa-trash"></i></button>` : ''}
                        </td>
                    </tr>
                `).join('');
            } else {
                updateTableHeaders(['ID', 'Name', 'Email', 'Role', 'Status', 'Actions']);
                tbody.innerHTML = data.map(item => {
                    const roleClass = `badge-${item.role || 'user'}`;
                    return `
                        <tr>
                            <td>${item.id}</td>
                            <td><strong>${item.name}</strong></td>
                            <td>${item.email}</td>
                            <td><span class="badge-role ${roleClass}">${(item.role || 'user').toUpperCase()}</span></td>
                            <td>${item.status || 'active'}</td>
                            <td>
                                ${checkPermission('update', module) ? `<button class="btn-custom btn-secondary-custom" onclick="editItem(${item.id}); return false;" style="padding: 5px 10px; font-size: 12px;"><i class="fas fa-edit"></i></button>` : ''}
                                ${checkPermission('delete', module) ? `<button class="btn-custom" style="background: #ef4444; color: white; padding: 5px 10px; font-size: 12px; cursor: pointer;" onclick="deleteItem(${item.id}); return false;"><i class="fas fa-trash"></i></button>` : ''}
                            </td>
                        </tr>
                    `;
                }).join('');
            }
        }

        function updateTableHeaders(headers) {
            const thead = document.querySelector('.table-custom thead tr');
            thead.innerHTML = headers.map(h => `<th>${h}</th>`).join('');
        }

        function showFormFieldsForModule(module) {
            const allFields = document.querySelectorAll('.form-group[id^="field"]');
            allFields.forEach(f => f.style.display = 'none');

            if (module === 'mahasiswa') {
                ['fieldMahasiswaNama', 'fieldNim', 'fieldJurusan', 'fieldAngkatan', 'fieldMahasiswaNoHp', 'fieldMahasiswaAlamat'].forEach(f => document.getElementById(f).style.display = 'block');
            } else if (module === 'instruktur') {
                ['fieldInstrukturNama', 'fieldNip', 'fieldKeahlian', 'fieldSpesialisasi', 'fieldNoHp', 'fieldAlamat'].forEach(f => document.getElementById(f).style.display = 'block');
            } else if (module === 'kelas') {
                ['fieldKelasInstruktur', 'fieldKodeKelas', 'fieldNamaKelas', 'fieldKapasitas', 'fieldTahunAkademik'].forEach(f => document.getElementById(f).style.display = 'block');
            } else if (module === 'jadwal') {
                ['fieldJadwalKelas', 'fieldJadwalInstruktur', 'fieldHari', 'fieldJamMulai', 'fieldJamSelesai', 'fieldRuangan'].forEach(f => document.getElementById(f).style.display = 'block');
                // Reset instruktur display
                document.getElementById('formJadwalInstrukturDisplay').value = '';
                document.getElementById('formJadwalInstruktur').value = '';
            } else if (module === 'surat') {
                ['fieldSuratMasukId', 'fieldDisposisiUserId', 'fieldDisposisiCatatan', 'fieldDisposisiStatus', 'fieldDisposisiTanggal'].forEach(f => document.getElementById(f).style.display = 'block');
            }
        }

        async function loadInstrukturDropdown() {
            const select = document.getElementById('formInstruktur');
            if (!select) return;
            try {
                const token = localStorage.getItem('auth_token');
                // prefer users API that can filter by role, fallback to module endpoints
                const urlCandidates = [
                    `${API_BASE}/users?role=instruktur`,
                    `${API_BASE}/instruktur`,
                    `${API_BASE}/instruktur/dropdown`
                ];

                let response = null;
                for (const url of urlCandidates) {
                    try {
                        response = await fetch(url, { headers: { 'Authorization': `Bearer ${token}` } });
                        if (response && response.ok) break;
                    } catch (err) {
                        response = null;
                    }
                }

                if (response && response.ok) {
                    const data = await response.json();
                    const instrukturList = Array.isArray(data) ? data : (data.data || []);

                    if (instrukturList.length === 0) {
                        select.innerHTML = '<option value="">-- Tidak ada instruktur --</option>';
                        return;
                    }

                    const options = instrukturList
                        .map(i => `<option value="${i.id}">${i.nama || i.name}</option>`)
                        .join('');

                    select.innerHTML = '<option value="">-- Select Instruktur --</option>' + options;
                } else {
                    select.innerHTML = '<option value="">-- Error --</option>';
                }
            } catch (e) {
                const selectEl = document.getElementById('formInstruktur');
                if (selectEl) selectEl.innerHTML = '<option value="">-- Error loading --</option>';
            }
        }

        async function loadRoleDropdown() {
            try {
                const token = localStorage.getItem('auth_token');
                const response = await fetch(`${API_BASE}/roles`, { 
                    headers: { 'Authorization': `Bearer ${token}` } 
                });
                if (response.ok) {
                    const data = await response.json();
                    const select = document.getElementById('formRole');
                    const options = data.data.map(r => `<option value="${r.id || r.name}">${r.name}</option>`).join('');
                    select.innerHTML = options;
                } else {
                    // Fallback ke hardcoded jika API tidak tersedia
                    const select = document.getElementById('formRole');
                    select.innerHTML = '<option value="mahasiswa">Mahasiswa</option><option value="instruktur">Instruktur</option><option value="admin">Admin</option>';
                }
            } catch (e) { 
                // Fallback ke hardcoded jika API tidak tersedia
                const select = document.getElementById('formRole');
                select.innerHTML = '<option value="mahasiswa">Mahasiswa</option><option value="instruktur">Instruktur</option><option value="admin">Admin</option>';
                console.warn('Error loading roles, using fallback:', e); 
            }
        }

        async function loadStatusDropdown() {
            try {
                const token = localStorage.getItem('auth_token');
                const response = await fetch(`${API_BASE}/statuses`, { 
                    headers: { 'Authorization': `Bearer ${token}` } 
                });
                if (response.ok) {
                    const data = await response.json();
                    const select = document.getElementById('formStatus');
                    const options = data.data.map(s => `<option value="${s.id || s.value}">${s.name || s.label}</option>`).join('');
                    select.innerHTML = options;
                } else {
                    // Fallback ke hardcoded
                    const select = document.getElementById('formStatus');
                    select.innerHTML = '<option value="1">Aktif</option><option value="0">Nonaktif</option>';
                }
            } catch (e) { 
                // Fallback ke hardcoded
                const select = document.getElementById('formStatus');
                select.innerHTML = '<option value="1">Aktif</option><option value="0">Nonaktif</option>';
                console.warn('Error loading statuses, using fallback:', e); 
            }
        }

        async function loadHariDropdown() {
            try {
                const token = localStorage.getItem('auth_token');
                const response = await fetch(`${API_BASE}/hari`, { 
                    headers: { 'Authorization': `Bearer ${token}` } 
                });
                if (response.ok) {
                    const data = await response.json();
                    const select = document.getElementById('formHari');
                    const options = data.data.map(h => `<option value="${h.id}">${h.nama}</option>`).join('');
                    select.innerHTML = '<option value="">-- Select Hari --</option>' + options;
                } else {
                    // Fallback ke hardcoded
                    const select = document.getElementById('formHari');
                    select.innerHTML = '<option value="">-- Select Hari --</option><option value="1">Senin</option><option value="2">Selasa</option><option value="3">Rabu</option><option value="4">Kamis</option><option value="5">Jumat</option><option value="6">Sabtu</option>';
                }
            } catch (e) { 
                // Fallback ke hardcoded
                const select = document.getElementById('formHari');
                select.innerHTML = '<option value="">-- Select Hari --</option><option value="1">Senin</option><option value="2">Selasa</option><option value="3">Rabu</option><option value="4">Kamis</option><option value="5">Jumat</option><option value="6">Sabtu</option>';
                console.warn('Error loading hari, using fallback:', e); 
            }
        }

        async function loadKelasDropdown() {
            try {
                const token = localStorage.getItem('auth_token');
                const response = await fetch(`${API_BASE}/kelas`, { headers: { 'Authorization': `Bearer ${token}` } });
                if (response.ok) {
                    const data = await response.json();
                    const select = document.getElementById('formJadwalKelas');
                    select.innerHTML = '<option value="">-- Select Kelas --</option>' + data.data.map(k => `<option value="${k.id}">${k.nama_kelas}</option>`).join('');
                }
            } catch (e) { console.error('Error loading kelas:', e); }
        }

        // Handle Kelas selection change - auto-populate instruktur
        async function onKelasChange() {
            const kelasId = document.getElementById('formJadwalKelas').value;
            const instrukturDisplay = document.getElementById('formJadwalInstrukturDisplay');
            const instrukturHidden = document.getElementById('formJadwalInstruktur');
            
            if (!kelasId) {
                instrukturDisplay.value = '';
                instrukturHidden.value = '';
                return;
            }
            
            try {
                const token = localStorage.getItem('auth_token');
                const response = await fetch(`${API_BASE}/kelas/${kelasId}`, { headers: { 'Authorization': `Bearer ${token}` } });
                if (response.ok) {
                    const data = await response.json();
                    const kelas = data.data;
                    instrukturHidden.value = kelas.instruktur_id || '';
                    instrukturDisplay.value = kelas.instruktur?.nama || 'No Instruktur';
                }
            } catch (e) { console.error('Error loading kelas details:', e); }
        }

        async function loadJadwalInstrukturDropdown() {
            try {
                const token = localStorage.getItem('auth_token');
                const response = await fetch(`${API_BASE}/instruktur`, { headers: { 'Authorization': `Bearer ${token}` } });
                if (response.ok) {
                    const data = await response.json();
                    const select = document.getElementById('formJadwalInstruktur');
                    select.innerHTML = '<option value="">-- Select Instruktur --</option>' + data.data.map(i => `<option value="${i.id}">${i.nama}</option>`).join('');
                }
            } catch (e) { console.error('Error loading instruktur:', e); }
        }

        // ========== MODAL FUNCTIONS ==========
        function openAddModal() {
            editingUserId = null;
            document.getElementById('modalTitle').textContent = `Add ${currentModule}`;
            document.getElementById('dataForm').reset();
            showFormFieldsForModule(currentModule);
            document.getElementById('formModal').classList.add('active');
            
            // Load dropdowns untuk semua module
            loadRoleDropdown();
            loadStatusDropdown();
            loadHariDropdown();
            
            if (currentModule === 'kelas') loadInstrukturDropdown();
            if (currentModule === 'jadwal') { loadKelasDropdown(); }
        }

        function closeModal() {
            editingUserId = null;
            document.getElementById('formModal').classList.remove('active');
        }

        // ========== CRUD FUNCTIONS ==========
        let editingUserId = null;

        async function submitForm(e) {
            if (e) e.preventDefault();
            
            const isEdit = editingUserId !== null;
            const permission = isEdit ? 'update' : 'create';
            
            if (!checkPermission(permission, currentModule)) {
                alert(`You do not have permission to ${isEdit ? 'edit' : 'create'}`);
                return false;
            }

            // Custom validation for visible fields
            if (currentModule === 'mahasiswa') {
                if (!document.getElementById('formMahasiswaNama').value.trim()) {
                    alert('Nama is required');
                    return false;
                }
                if (!document.getElementById('formNim').value.trim()) {
                    alert('NIM is required');
                    return false;
                }
            } else if (currentModule === 'instruktur') {
                if (!document.getElementById('formInstrukturNama').value.trim()) {
                    alert('Nama is required');
                    return false;
                }
                if (!document.getElementById('formNip').value.trim()) {
                    alert('NIP is required');
                    return false;
                }
            } else if (currentModule === 'kelas') {
                if (!document.getElementById('formKodeKelas').value.trim()) {
                    alert('Kode Kelas is required');
                    return false;
                }
                if (!document.getElementById('formNamaKelas').value.trim()) {
                    alert('Nama Kelas is required');
                    return false;
                }
                if (!document.getElementById('formKapasitas').value) {
                    alert('Kapasitas is required');
                    return false;
                }
            } else if (currentModule === 'jadwal') {
                if (!document.getElementById('formJadwalKelas').value) {
                    alert('Kelas is required');
                    return false;
                }
                if (!document.getElementById('formHari').value) {
                    alert('Hari is required');
                    return false;
                }
                if (!document.getElementById('formJamMulai').value) {
                    alert('Jam Mulai is required');
                    return false;
                }
                if (!document.getElementById('formJamSelesai').value) {
                    alert('Jam Selesai is required');
                    return false;
                }
            } else if (currentModule === 'surat') {
                if (!document.getElementById('formSuratMasukId').value) {
                    alert('Surat Masuk is required');
                    return false;
                }
                if (!document.getElementById('formDisposisiUserId').value) {
                    alert('Penerima (User) is required');
                    return false;
                }
            }

            let formData = {};
            let url = `${API_BASE}/users`;
            
            if (currentModule === 'kelas') {
                formData = {
                    instruktur_id: parseInt(document.getElementById('formInstruktur').value) || null,
                    kode_kelas: document.getElementById('formKodeKelas').value,
                    nama_kelas: document.getElementById('formNamaKelas').value,
                    kapasitas: parseInt(document.getElementById('formKapasitas').value) || null,
                    tahun_akademik: document.getElementById('formTahunAkademik').value
                };
                url = isEdit ? `${API_BASE}/kelas/${editingUserId}` : `${API_BASE}/kelas`;
            } else if (currentModule === 'jadwal') {
                formData = {
                    kelas_id: parseInt(document.getElementById('formJadwalKelas').value) || null,
                    instruktur_id: parseInt(document.getElementById('formJadwalInstruktur').value) || null,
                    hari_id: parseInt(document.getElementById('formHari').value) || null,
                    jam_mulai: document.getElementById('formJamMulai').value,
                    jam_selesai: document.getElementById('formJamSelesai').value,
                    ruangan: document.getElementById('formRuangan').value
                };
                url = isEdit ? `${API_BASE}/jadwal/${editingUserId}` : `${API_BASE}/jadwal`;
            } else if (currentModule === 'instruktur') {
                // Validate required fields for instruktur
                if (!document.getElementById('formInstrukturNama').value.trim()) {
                    alert('Nama is required');
                    return false;
                }
                if (!document.getElementById('formNip').value.trim()) {
                    alert('NIP is required');
                    return false;
                }

                // For instruktur: use instruktur API endpoint
                formData = {
                    nama: document.getElementById('formInstrukturNama').value,
                    nip: document.getElementById('formNip').value,
                    keahlian: document.getElementById('formKeahlian').value,
                    spesialisasi: document.getElementById('formSpesialisasi').value,
                    no_hp: document.getElementById('formNoHp').value,
                    alamat: document.getElementById('formAlamat').value
                };
                url = isEdit ? `${API_BASE}/instruktur/${editingUserId}` : `${API_BASE}/instruktur`;
            } else if (currentModule === 'mahasiswa') {
                // Validate required fields for mahasiswa
                if (!document.getElementById('formMahasiswaNama').value.trim()) {
                    alert('Nama is required');
                    return false;
                }
                if (!document.getElementById('formNim').value.trim()) {
                    alert('NIM is required');
                    return false;
                }

                // For mahasiswa: use mahasiswa API endpoint
                formData = {
                    nama: document.getElementById('formMahasiswaNama').value,
                    nim: document.getElementById('formNim').value,
                    jurusan: document.getElementById('formJurusan').value,
                    angkatan: parseInt(document.getElementById('formAngkatan').value) || null,
                    no_hp: document.getElementById('formMahasiswaNoHp').value,
                    alamat: document.getElementById('formMahasiswaAlamat').value
                };
                url = isEdit ? `${API_BASE}/mahasiswa/${editingUserId}` : `${API_BASE}/mahasiswa`;
            } else if (currentModule === 'surat') {
                formData = {
                    surat_masuk_id: parseInt(document.getElementById('formSuratMasukId').value) || null,
                    user_id: parseInt(document.getElementById('formDisposisiUserId').value) || null,
                    catatan: document.getElementById('formDisposisiCatatan').value || '',
                    status: document.getElementById('formDisposisiStatus').value || 'pending',
                    tanggal_disposisi: document.getElementById('formDisposisiTanggal').value || null
                };
                url = isEdit ? `${API_BASE}/disposisi/${editingUserId}` : `${API_BASE}/disposisi`;
            } else {
                formData = {
                    name: document.getElementById('formName').value,
                    email: document.getElementById('formEmail').value,
                    role: document.getElementById('formRole').value,
                    status: document.getElementById('formStatus')?.value || '1',
                    password: document.getElementById('formPassword')?.value || 'password123'
                };
                url = isEdit ? `${API_BASE}/users/${editingUserId}` : `${API_BASE}/users`;
            }

            try {
                const token = localStorage.getItem('auth_token');
                if (!token) {
                    alert('No authentication token found. Please login again.');
                    return;
                }

                const method = isEdit ? 'PUT' : 'POST';
                
                console.log(`API Call: ${method} ${url}`);
                console.log('Form Data:', JSON.stringify(formData, null, 2));
                
                const response = await fetch(url, {
                    method: method,
                    headers: { 
                        'Authorization': `Bearer ${token}`,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(formData)
                });

                console.log('Response Status:', response.status);
                const data = await response.json();
                console.log('Response Data:', JSON.stringify(data, null, 2));

                if (response.ok) {
                    alert(`Data ${isEdit ? 'updated' : 'created'} successfully`);
                    closeModal();
                    editingUserId = null;
                    loadModuleData(currentModule);
                } else {
                    let errorMsg = 'Failed to save data';
                    if (data.errors) {
                        // Validation errors format: {field: [error1, error2]}
                        errorMsg = Object.entries(data.errors)
                            .map(([field, msgs]) => `${field}: ${msgs.join(', ')}`)
                            .join('\n');
                    } else if (data.message) {
                        errorMsg = data.message;
                    } else if (data.error) {
                        errorMsg = data.error;
                    }
                    console.error('Full Error Data:', JSON.stringify(data, null, 2));
                    alert('Error: ' + errorMsg);
                }
            } catch (error) {
                console.error('Fetch Error:', error);
                alert('Error: ' + error.message);
            }
        }

        async function editItem(id) {
            if (!checkPermission('update', currentModule)) {
                alert('You do not have permission to edit');
                return;
            }

            try {
                const token = localStorage.getItem('auth_token');
                let url = `${API_BASE}/users/${id}`;
                if (currentModule === 'kelas') url = `${API_BASE}/kelas/${id}`;
                else if (currentModule === 'jadwal') url = `${API_BASE}/jadwal/${id}`;
                else if (currentModule === 'instruktur') url = `${API_BASE}/instruktur/${id}`;
                else if (currentModule === 'mahasiswa') url = `${API_BASE}/mahasiswa/${id}`;
                
                const response = await fetch(url, { headers: { 'Authorization': `Bearer ${token}` } });
                if (!response.ok) {
                    alert('Failed to load data');
                    return;
                }

                const data = await response.json();
                const item = data.data;
                editingUserId = id;
                document.getElementById('modalTitle').textContent = `Edit ${currentModule}`;
                showFormFieldsForModule(currentModule);
                
                // Load semua dropdowns
                await loadRoleDropdown();
                await loadStatusDropdown();
                await loadHariDropdown();
                
                if (currentModule === 'kelas') {
                    await loadInstrukturDropdown();
                    document.getElementById('formInstruktur').value = item.instruktur_id;
                    document.getElementById('formKodeKelas').value = item.kode_kelas;
                    document.getElementById('formNamaKelas').value = item.nama_kelas;
                    document.getElementById('formKapasitas').value = item.kapasitas;
                    document.getElementById('formTahunAkademik').value = item.tahun_akademik;
                } else if (currentModule === 'jadwal') {
                    await loadKelasDropdown();
                    document.getElementById('formJadwalKelas').value = item.kelas_id;
                    await onKelasChange();
                    document.getElementById('formHari').value = item.hari_id;
                    document.getElementById('formJamMulai').value = item.jam_mulai;
                    document.getElementById('formJamSelesai').value = item.jam_selesai;
                    document.getElementById('formRuangan').value = item.ruangan;
                } else if (currentModule === 'instruktur') {
                    document.getElementById('formInstrukturNama').value = item.nama || '';
                    document.getElementById('formNip').value = item.nip || '';
                    document.getElementById('formKeahlian').value = item.keahlian || '';
                    document.getElementById('formSpesialisasi').value = item.spesialisasi || '';
                    document.getElementById('formNoHp').value = item.no_hp || '';
                    document.getElementById('formAlamat').value = item.alamat || '';
                } else if (currentModule === 'mahasiswa') {
                    document.getElementById('formMahasiswaNama').value = item.nama || '';
                    document.getElementById('formNim').value = item.nim || '';
                    document.getElementById('formJurusan').value = item.jurusan || '';
                    document.getElementById('formAngkatan').value = item.angkatan || '';
                    document.getElementById('formMahasiswaNoHp').value = item.no_hp || '';
                    document.getElementById('formMahasiswaAlamat').value = item.alamat || '';
                } else {
                    document.getElementById('formName').value = item.name;
                    document.getElementById('formEmail').value = item.email;
                    document.getElementById('formRole').value = item.role;
                    document.getElementById('formStatus').value = item.status;
                    document.getElementById('formPassword').value = '';
                }
                
                document.getElementById('formModal').classList.add('active');
            } catch (error) {
                alert('Error: ' + error.message);
            }
        }

        async function deleteItem(id) {
            if (!checkPermission('delete', currentModule)) {
                alert('You do not have permission to delete');
                return;
            }

            if (confirm('Are you sure?')) {
                try {
                    const token = localStorage.getItem('auth_token');
                    let url = `${API_BASE}/users/${id}`;
                    if (currentModule === 'kelas') url = `${API_BASE}/kelas/${id}`;
                    else if (currentModule === 'jadwal') url = `${API_BASE}/jadwal/${id}`;
                    else if (currentModule === 'instruktur') url = `${API_BASE}/instruktur/${id}`;
                    else if (currentModule === 'mahasiswa') url = `${API_BASE}/mahasiswa/${id}`;
                    
                    const response = await fetch(url, {
                        method: 'DELETE',
                        headers: { 'Authorization': `Bearer ${token}` }
                    });

                    if (response.ok) {
                        alert('Data deleted successfully');
                        loadModuleData(currentModule);
                    } else {
                        const error = await response.json();
                        alert('Error: ' + (error.message || 'Failed to delete'));
                    }
                } catch (error) {
                    alert('Error: ' + error.message);
                }
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
    <script src="{{ asset('js/sidebar-menu.js') }}"></script>
</body>
</html>
