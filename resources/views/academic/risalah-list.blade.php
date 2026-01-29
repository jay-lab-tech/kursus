@extends('layouts.app')

@section('content')
<div class="risalah-list-container">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary: #3b82f6;
            --secondary: #8b5cf6;
            --success: #10b981;
            --danger: #ef4444;
            --warning: #f59e0b;
            --light: #f9fafb;
            --dark: #1f2937;
            --border: #e5e7eb;
        }

        .risalah-list-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 30px 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }

        .page-header {
            margin-bottom: 30px;
            color: white;
        }

        .page-header h1 {
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .page-header p {
            font-size: 16px;
            opacity: 0.9;
        }

        .header-actions {
            display: flex;
            gap: 15px;
            align-items: center;
            flex-wrap: wrap;
            margin-top: 20px;
        }

        .btn-primary {
            background: var(--primary);
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background: #2563eb;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .search-filter {
            display: flex;
            gap: 10px;
            background: white;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 25px;
        }

        .search-filter input,
        .search-filter select {
            padding: 10px 15px;
            border: 1px solid var(--border);
            border-radius: 6px;
            font-size: 14px;
            flex: 1;
        }

        .search-filter input:focus,
        .search-filter select:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .risalah-cards {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .risalah-card {
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            border-left: 4px solid var(--primary);
        }

        .risalah-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
        }

        .risalah-header {
            display: flex;
            justify-content: space-between;
            align-items: start;
            margin-bottom: 15px;
        }

        .risalah-title {
            font-size: 18px;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 5px;
            max-width: 80%;
        }

        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            display: inline-block;
        }

        .status-draft {
            background: #fef3c7;
            color: #92400e;
        }

        .status-published {
            background: #dcfce7;
            color: #166534;
        }

        .risalah-meta {
            display: flex;
            gap: 15px;
            font-size: 13px;
            color: #6b7280;
            margin-bottom: 12px;
            flex-wrap: wrap;
        }

        .meta-item {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .risalah-kelas {
            background: var(--light);
            padding: 8px 12px;
            border-radius: 6px;
            font-size: 13px;
            color: var(--secondary);
            font-weight: 600;
            display: inline-block;
            margin-bottom: 12px;
        }

        .risalah-content {
            color: #4b5563;
            font-size: 14px;
            line-height: 1.5;
            margin-bottom: 15px;
            max-height: 100px;
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
        }

        .peserta-info {
            background: #f0f4ff;
            padding: 12px;
            border-radius: 6px;
            font-size: 13px;
            color: var(--primary);
            font-weight: 600;
            margin-bottom: 15px;
        }

        .risalah-actions {
            display: flex;
            gap: 8px;
            margin-top: 15px;
        }

        .btn-sm {
            padding: 8px 12px;
            border: none;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
        }

        .btn-view {
            background: var(--primary);
            color: white;
        }

        .btn-view:hover {
            background: #2563eb;
        }

        .btn-edit {
            background: var(--secondary);
            color: white;
        }

        .btn-edit:hover {
            background: #7c3aed;
        }

        .btn-delete {
            background: var(--danger);
            color: white;
        }

        .btn-delete:hover {
            background: #dc2626;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            background: white;
            border-radius: 12px;
            color: #6b7280;
        }

        .empty-state-icon {
            font-size: 48px;
            margin-bottom: 20px;
        }

        .empty-state h3 {
            font-size: 20px;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 10px;
        }

        .pagination {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 30px;
        }

        .pagination button {
            padding: 10px 15px;
            border: 1px solid var(--border);
            background: white;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.2s ease;
        }

        .pagination button:hover {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
        }

        .pagination button.active {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
        }

        .loading {
            text-align: center;
            padding: 40px;
            color: #6b7280;
        }

        .loading::after {
            content: '';
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(59, 130, 246, 0.3);
            border-top-color: var(--primary);
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        .alert {
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert-success {
            background: #dcfce7;
            color: #166534;
            border-left: 4px solid #10b981;
        }

        .alert-error {
            background: #fee2e2;
            color: #991b1b;
            border-left: 4px solid #ef4444;
        }
    </style>

    <!-- Page Header -->
    <div class="page-header">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
            <h1><i class="fas fa-file-alt"></i> Manajemen Risalah</h1>
            <button onclick="window.location.href='/dashboard'" class="btn-primary" style="background: rgba(255,255,255,0.2); border: 1px solid rgba(255,255,255,0.5);">
                <i class="fas fa-arrow-left"></i> Kembali
            </button>
        </div>
        <p>Kelola risalah/notula kelas Anda</p>
        <div class="header-actions">
            <a href="/risalah/create" class="btn-primary">
                <i class="fas fa-plus"></i> Buat Risalah Baru
            </a>
        </div>
    </div>

    <!-- Alerts -->
    <div id="alertContainer"></div>

    <!-- Search & Filter -->
    <div class="search-filter">
        <input type="text" id="searchInput" placeholder="Cari risalah...">
        <select id="kelasFilter">
            <option value="">Semua Kelas</option>
        </select>
        <select id="statusFilter">
            <option value="">Semua Status</option>
            <option value="draft">Draft</option>
            <option value="published">Published</option>
        </select>
    </div>

    <!-- Loading State -->
    <div id="loadingState" class="loading" style="display: none;">
        Memuat risalah...
    </div>

    <!-- Risalah Cards -->
    <div id="risalahCardsContainer" class="risalah-cards"></div>

    <!-- Empty State -->
    <div id="emptyState" style="display: none;">
        <div class="empty-state">
            <div class="empty-state-icon">📋</div>
            <h3>Belum ada risalah</h3>
            <p>Mulai buat risalah pertama Anda dengan mengklik tombol "Buat Risalah Baru" di atas</p>
        </div>
    </div>

    <!-- Pagination -->
    <div id="paginationContainer" class="pagination" style="display: none;"></div>
</div>

<script>
    let currentPage = 1;
    let risalahData = [];

    document.addEventListener('DOMContentLoaded', async () => {
        await loadKelasOptions();
        await loadRisalah();
        setupEventListeners();
    });

    function setupEventListeners() {
        document.getElementById('searchInput').addEventListener('input', () => {
            currentPage = 1;
            loadRisalah();
        });

        document.getElementById('kelasFilter').addEventListener('change', () => {
            currentPage = 1;
            loadRisalah();
        });

        document.getElementById('statusFilter').addEventListener('change', () => {
            currentPage = 1;
            loadRisalah();
        });
    }

    async function loadKelasOptions() {
        try {
            const token = localStorage.getItem('token');
            const response = await fetch('/api/risalah/kelas/list', {
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Content-Type': 'application/json'
                }
            });

            if (response.ok) {
                const result = await response.json();
                const select = document.getElementById('kelasFilter');
                result.data.forEach(kelas => {
                    const option = document.createElement('option');
                    option.value = kelas.id;
                    option.textContent = kelas.nama_kelas;
                    select.appendChild(option);
                });
            }
        } catch (error) {
            console.error('Error loading kelas:', error);
        }
    }

    async function loadRisalah() {
        try {
            const token = localStorage.getItem('token');
            document.getElementById('loadingState').style.display = 'block';

            let url = `/api/risalah?page=${currentPage}`;
            
            const search = document.getElementById('searchInput').value;
            if (search) url += `&search=${encodeURIComponent(search)}`;

            const kelasId = document.getElementById('kelasFilter').value;
            if (kelasId) url += `&kelas_id=${kelasId}`;

            const status = document.getElementById('statusFilter').value;
            if (status) url += `&status=${status}`;

            const response = await fetch(url, {
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Content-Type': 'application/json'
                }
            });

            if (!response.ok) throw new Error('Failed to load risalah');

            const result = await response.json();
            risalahData = result.data;

            document.getElementById('loadingState').style.display = 'none';

            if (risalahData.length === 0) {
                document.getElementById('emptyState').style.display = 'block';
                document.getElementById('risalahCardsContainer').innerHTML = '';
                document.getElementById('paginationContainer').style.display = 'none';
            } else {
                document.getElementById('emptyState').style.display = 'none';
                renderRisalahCards();
                renderPagination(result.pagination);
            }
        } catch (error) {
            console.error('Error loading risalah:', error);
            showAlert('Error loading risalah', 'error');
        }
    }

    function renderRisalahCards() {
        const container = document.getElementById('risalahCardsContainer');
        container.innerHTML = '';

        risalahData.forEach(risalah => {
            const statusClass = risalah.status === 'draft' ? 'status-draft' : 'status-published';
            const statusLabel = risalah.status === 'draft' ? 'Draft' : 'Published';

            const card = document.createElement('div');
            card.className = 'risalah-card';
            card.innerHTML = `
                <div class="risalah-header">
                    <div>
                        <div class="risalah-title">${escapeHtml(risalah.judul)}</div>
                        <span class="status-badge ${statusClass}">${statusLabel}</span>
                    </div>
                </div>

                <div class="risalah-kelas">
                    <i class="fas fa-book"></i> ${escapeHtml(risalah.kelas.nama_kelas)}
                </div>

                <div class="risalah-meta">
                    <div class="meta-item">
                        <i class="fas fa-calendar"></i>
                        ${new Date(risalah.tanggal).toLocaleDateString('id-ID')}
                    </div>
                    <div class="meta-item">
                        <i class="fas fa-users"></i>
                        ${risalah.peserta_hadir} peserta
                    </div>
                </div>

                <div class="risalah-content">
                    ${escapeHtml(risalah.isi)}
                </div>

                ${risalah.catatan_penting ? `
                    <div class="peserta-info">
                        <i class="fas fa-exclamation-circle"></i> 
                        ${escapeHtml(risalah.catatan_penting.substring(0, 50))}...
                    </div>
                ` : ''}

                <div class="risalah-actions">
                    <a href="/risalah/${risalah.id}" class="btn-sm btn-view">
                        <i class="fas fa-eye"></i> Lihat
                    </a>
                    <a href="/risalah/${risalah.id}/edit" class="btn-sm btn-edit">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <button class="btn-sm btn-delete" onclick="deleteRisalah(${risalah.id})">
                        <i class="fas fa-trash"></i> Hapus
                    </button>
                </div>
            `;
            container.appendChild(card);
        });
    }

    function renderPagination(pagination) {
        if (pagination.last_page <= 1) {
            document.getElementById('paginationContainer').style.display = 'none';
            return;
        }

        const container = document.getElementById('paginationContainer');
        container.innerHTML = '';
        container.style.display = 'flex';

        for (let i = 1; i <= pagination.last_page; i++) {
            const button = document.createElement('button');
            button.textContent = i;
            if (i === pagination.current_page) button.classList.add('active');
            button.onclick = () => {
                currentPage = i;
                loadRisalah();
            };
            container.appendChild(button);
        }
    }

    async function deleteRisalah(id) {
        if (!confirm('Apakah Anda yakin ingin menghapus risalah ini?')) return;

        try {
            const token = localStorage.getItem('token');
            const response = await fetch(`/api/risalah/${id}`, {
                method: 'DELETE',
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Content-Type': 'application/json'
                }
            });

            if (response.ok) {
                showAlert('Risalah berhasil dihapus', 'success');
                await loadRisalah();
            } else {
                showAlert('Gagal menghapus risalah', 'error');
            }
        } catch (error) {
            console.error('Error deleting risalah:', error);
            showAlert('Error: ' + error.message, 'error');
        }
    }

    function showAlert(message, type) {
        const container = document.getElementById('alertContainer');
        const alert = document.createElement('div');
        alert.className = `alert alert-${type}`;
        alert.innerHTML = `
            <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'}"></i>
            <span>${message}</span>
        `;
        container.appendChild(alert);

        setTimeout(() => alert.remove(), 4000);
    }

    function escapeHtml(text) {
        const map = {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;'
        };
        return text.replace(/[&<>"']/g, m => map[m]);
    }
</script>
<script src="{{ asset('js/sidebar-menu.js') }}"></script>
