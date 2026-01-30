<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Risalah - Sistem Akademik</title>
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
        
        .badge-status {
            display: inline-block; padding: 5px 10px; border-radius: 20px; font-size: 12px; font-weight: 600;
        }
        .badge-draft { background: #dbeafe; color: #1e40af; }
        .badge-pending { background: #fef3c7; color: #92400e; }
        .badge-published { background: #d1fae5; color: #065f46; }
        .badge-approved { background: #d1fae5; color: #065f46; }
        .badge-selesai { background: #d1fae5; color: #065f46; }
        .badge-rejected { background: #fee2e2; color: #991b1b; }
        
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
            background: white; padding: 30px; border-radius: 10px; max-width: 600px; width: 90%;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2); max-height: 80vh; overflow-y: auto;
        }
        
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: 600; color: #374151; }
        .form-group input, .form-group select, .form-group textarea { 
            width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 5px;
            font-size: 14px;
        }
        
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
            <li><a href="/dashboard" class="nav-link"><i class="fas fa-home"></i> <span>Dashboard</span></a></li>
            <li><a href="/data-management" class="nav-link"><i class="fas fa-database"></i> <span>Data Management</span></a></li>
            <li><a href="/risalah-dashboard-new" class="nav-link active"><i class="fas fa-file-alt"></i> <span>Risalah</span></a></li>
            <hr style="border: none; border-top: 1px solid rgba(255,255,255,0.1); margin: 20px 0;">
            <li><a href="#" onclick="logout(); return false;"><i class="fas fa-sign-out-alt"></i> <span>Logout</span></a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Header -->
        <div class="header">
            <div class="header-left">
                <h1 id="pageTitle">Data Risalah</h1>
                <p id="pageDesc">Manage risalah documents</p>
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
                <h3 style="margin: 0;" id="moduleTitle">Data Risalah</h3>
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
                            <th>Judul Risalah</th>
                            <th>Kelas</th>
                            <th>Instruktur</th>
                            <th>Tanggal</th>
                            <th>Peserta Hadir</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="tableBody">
                        <tr>
                            <td colspan="8" style="text-align: center; color: #9ca3af;">Loading...</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Add/Edit Modal -->
    <div class="modal-overlay" id="formModal">
        <div class="modal-content">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <h4 style="margin: 0;" id="modalTitle">Add Risalah</h4>
                <button onclick="closeModal(); return false;" style="background: none; border: none; font-size: 24px; cursor: pointer;">×</button>
            </div>
            <form id="dataForm" onsubmit="submitForm(event); return false;">
                <div class="form-group">
                    <label>Kelas *</label>
                    <select id="formKelas" required>
                        <option value="">-- Select Kelas --</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Tanggal *</label>
                    <input type="date" id="formTanggal" required>
                </div>
                <div class="form-group">
                    <label>Judul Risalah *</label>
                    <input type="text" id="formJudul" required>
                </div>
                <div class="form-group">
                    <label>Isi Risalah</label>
                    <textarea id="formIsi" style="height: 150px; resize: vertical;"></textarea>
                </div>
                <div class="form-group">
                    <label>Peserta Hadir *</label>
                    <input type="number" id="formPesertaHadir" min="0" required>
                </div>
                <div class="form-group">
                    <label>Catatan Penting</label>
                    <textarea id="formCatatanPenting" style="height: 100px; resize: vertical;"></textarea>
                </div>
                <div class="form-group">
                    <label>Status</label>
                    <select id="formStatus">
                        <option value="draft">Draft</option>
                        <option value="published">Published</option>
                    </select>
                </div>

                <div style="display: flex; gap: 10px; justify-content: flex-end;">
                    <button type="button" class="btn-custom btn-secondary-custom" onclick="closeModal(); return false;">Cancel</button>
                    <button type="submit" class="btn-custom btn-primary-custom">Save</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const API_BASE = '/api';
        let currentUser = {};
        let editingId = null;

        // ========== AUTH CHECK ==========
        function checkAuth() {
            const token = localStorage.getItem('auth_token');
            const user = JSON.parse(localStorage.getItem('user') || '{}');
            
            if (!token) {
                window.location.href = '/login';
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
            
            // Load risalah data
            loadRisalahData();
            // Load kelas dropdown
            loadKelasDropdown();
        });

        // ========== PERMISSION CHECK ==========
        function checkPermission(action) {
            const role = currentUser.role;
            
            const permissions = {
                admin: { create: true, read: true, update: true, delete: true },
                instruktur: { create: true, read: true, update: true, delete: true },
                mahasiswa: { create: false, read: true, update: false, delete: false }
            };

            return (permissions[role] || {})[action] || false;
        }

        // ========== LOAD RISALAH DATA ==========
        async function loadRisalahData() {
            try {
                const token = localStorage.getItem('auth_token');
                const response = await fetch(`${API_BASE}/risalah`, {
                    headers: { 'Authorization': `Bearer ${token}` }
                });

                if (response.ok) {
                    const data = await response.json();
                    renderTable(data.data || data);
                } else {
                    document.getElementById('tableBody').innerHTML = `
                        <tr><td colspan="7" style="text-align: center; color: #ef4444;">
                            <i class="fas fa-exclamation-circle"></i> Failed to load data
                        </td></tr>
                    `;
                }
            } catch (error) {
                console.error('Error loading data:', error);
                document.getElementById('tableBody').innerHTML = `
                    <tr><td colspan="7" style="text-align: center; color: #ef4444;">
                        <i class="fas fa-exclamation-circle"></i> Error: ${error.message}
                    </td></tr>
                `;
            }

            // Check permission for add button
            const canCreate = checkPermission('create');
            document.getElementById('btnAdd').style.display = canCreate ? 'block' : 'none';
            
            if (!canCreate) {
                document.getElementById('permissionAlert').style.display = 'block';
                document.getElementById('alertMessage').textContent = 'You don\'t have permission to create risalah';
            } else {
                document.getElementById('permissionAlert').style.display = 'none';
            }
        }

        // ========== RENDER TABLE ==========
        function renderTable(data) {
            const tbody = document.getElementById('tableBody');
            if (!Array.isArray(data) || data.length === 0) {
                tbody.innerHTML = `<tr><td colspan="8" style="text-align: center; color: #9ca3af;">No data available</td></tr>`;
                return;
            }

            tbody.innerHTML = data.map(item => `
                <tr>
                    <td>${item.id}</td>
                    <td><strong>${item.judul || '-'}</strong></td>
                    <td>${item.kelas?.nama_kelas || '-'}</td>
                    <td>${item.instruktur?.nama || '-'}</td>
                    <td>${formatDate(item.tanggal)}</td>
                    <td>${item.peserta_hadir || 0}</td>
                    <td>
                        <span class="badge-status badge-${item.status || 'draft'}">
                            ${getStatusLabel(item.status)}
                        </span>
                    </td>
                    <td>
                        ${checkPermission('update') ? `<button class="btn-custom btn-secondary-custom" onclick="editItem(${item.id}); return false;" style="padding: 5px 10px; font-size: 12px;"><i class="fas fa-edit"></i></button>` : ''}
                        ${checkPermission('delete') ? `<button class="btn-custom" style="background: #ef4444; color: white; padding: 5px 10px; font-size: 12px; cursor: pointer;" onclick="deleteItem(${item.id}); return false;"><i class="fas fa-trash"></i></button>` : ''}
                    </td>
                </tr>
            `).join('');
        }

        function getStatusLabel(status) {
            const labels = {
                'draft': 'Draft',
                'pending': 'Pending',
                'published': 'Published',
                'approved': 'Approved',
                'selesai': 'Selesai',
                'rejected': 'Rejected'
            };
            return labels[status] || status || 'Unknown';
        }

        function formatDate(dateString) {
            if (!dateString) return '-';
            try {
                const date = new Date(dateString);
                return date.toLocaleDateString('id-ID', {
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                });
            } catch (e) {
                return dateString;
            }
        }

        // ========== LOAD KELAS DROPDOWN ==========
        async function loadKelasDropdown() {
            try {
                const token = localStorage.getItem('auth_token');
                const response = await fetch(`${API_BASE}/kelas`, { 
                    headers: { 'Authorization': `Bearer ${token}` } 
                });
                if (response.ok) {
                    const data = await response.json();
                    console.log('Kelas Data:', data.data); // Debug
                    const select = document.getElementById('formKelas');
                    const options = data.data.map(k => {
                        const instrukturNama = k.instruktur?.nama || 'No Instruktur';
                        return `<option value="${k.id}">${k.nama_kelas} - ${instrukturNama}</option>`;
                    }).join('');
                    select.innerHTML = '<option value="">-- Select Kelas --</option>' + options;
                } else {
                    console.error('Failed to load kelas:', response.status, response.statusText);
                }
            } catch (e) { console.error('Error loading kelas:', e); }
        }

        // ========== MODAL FUNCTIONS ==========
        function openAddModal() {
            editingId = null;
            document.getElementById('modalTitle').textContent = 'Add Risalah';
            document.getElementById('dataForm').reset();
            loadKelasDropdown(); // Load kelas dropdown saat modal dibuka
            document.getElementById('formModal').classList.add('active');
        }

        function closeModal() {
            editingId = null;
            document.getElementById('formModal').classList.remove('active');
        }

        // ========== CRUD FUNCTIONS ==========
        async function submitForm(e) {
            if (e) e.preventDefault();
            
            const isEdit = editingId !== null;
            const permission = isEdit ? 'update' : 'create';
            
            if (!checkPermission(permission)) {
                alert(`You do not have permission to ${isEdit ? 'edit' : 'create'}`);
                return false;
            }

            // Validation
            if (!document.getElementById('formKelas').value) {
                alert('Kelas is required');
                return false;
            }
            if (!document.getElementById('formTanggal').value) {
                alert('Tanggal is required');
                return false;
            }
            if (!document.getElementById('formJudul').value.trim()) {
                alert('Judul Risalah is required');
                return false;
            }
            if (!document.getElementById('formPesertaHadir').value) {
                alert('Peserta Hadir is required');
                return false;
            }

            const formData = {
                kelas_id: parseInt(document.getElementById('formKelas').value),
                tanggal: document.getElementById('formTanggal').value,
                judul: document.getElementById('formJudul').value,
                isi: document.getElementById('formIsi').value,
                peserta_hadir: parseInt(document.getElementById('formPesertaHadir').value),
                catatan_penting: document.getElementById('formCatatanPenting').value,
                status: document.getElementById('formStatus').value
            };

            try {
                const token = localStorage.getItem('auth_token');
                const method = isEdit ? 'PUT' : 'POST';
                const url = isEdit ? `${API_BASE}/risalah/${editingId}` : `${API_BASE}/risalah`;
                
                const response = await fetch(url, {
                    method: method,
                    headers: { 
                        'Authorization': `Bearer ${token}`,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(formData)
                });

                const data = await response.json();

                if (response.ok) {
                    alert(`Data ${isEdit ? 'updated' : 'created'} successfully`);
                    closeModal();
                    editingId = null;
                    loadRisalahData();
                } else {
                    let errorMsg = 'Failed to save data';
                    if (data.errors) {
                        errorMsg = Object.entries(data.errors)
                            .map(([field, msgs]) => `${field}: ${msgs.join(', ')}`)
                            .join('\n');
                    } else if (data.message) {
                        errorMsg = data.message;
                    }
                    alert('Error: ' + errorMsg);
                }
            } catch (error) {
                console.error('Fetch Error:', error);
                alert('Error: ' + error.message);
            }
        }

        async function editItem(id) {
            if (!checkPermission('update')) {
                alert('You do not have permission to edit');
                return;
            }

            try {
                const token = localStorage.getItem('auth_token');
                const response = await fetch(`${API_BASE}/risalah/${id}`, { 
                    headers: { 'Authorization': `Bearer ${token}` } 
                });
                
                if (!response.ok) {
                    alert('Failed to load data');
                    return;
                }

                const data = await response.json();
                const item = data.data;
                editingId = id;
                document.getElementById('modalTitle').textContent = 'Edit Risalah';
                
                // Load kelas dropdown first
                await loadKelasDropdown();
                
                document.getElementById('formKelas').value = item.kelas_id || '';
                document.getElementById('formTanggal').value = item.tanggal ? item.tanggal.split(' ')[0] : '';
                document.getElementById('formJudul').value = item.judul || '';
                document.getElementById('formIsi').value = item.isi || '';
                document.getElementById('formPesertaHadir').value = item.peserta_hadir || 0;
                document.getElementById('formCatatanPenting').value = item.catatan_penting || '';
                document.getElementById('formStatus').value = item.status || 'draft';
                
                document.getElementById('formModal').classList.add('active');
            } catch (error) {
                alert('Error: ' + error.message);
            }
        }

        async function deleteItem(id) {
            if (!checkPermission('delete')) {
                alert('You do not have permission to delete');
                return;
            }

            if (confirm('Are you sure?')) {
                try {
                    const token = localStorage.getItem('auth_token');
                    const response = await fetch(`${API_BASE}/risalah/${id}`, {
                        method: 'DELETE',
                        headers: { 'Authorization': `Bearer ${token}` }
                    });

                    if (response.ok) {
                        alert('Data deleted successfully');
                        loadRisalahData();
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
                window.location.href = '/login';
            }
        }
    </script>
</body>
</html>
