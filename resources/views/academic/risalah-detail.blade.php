@extends('layouts.app')

@section('content')
<div class="risalah-detail-container">
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
            --light: #f9fafb;
            --dark: #1f2937;
            --border: #e5e7eb;
        }

        .risalah-detail-container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 30px 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }

        .detail-wrapper {
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            overflow: hidden;
        }

        .detail-header {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            padding: 40px;
            display: flex;
            justify-content: space-between;
            align-items: start;
        }

        .header-content h1 {
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 15px;
        }

        .header-meta {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
            font-size: 14px;
            opacity: 0.9;
        }

        .meta-item {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .header-actions {
            display: flex;
            gap: 10px;
        }

        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .btn-edit {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .btn-edit:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        .btn-delete {
            background: var(--danger);
            color: white;
        }

        .btn-delete:hover {
            background: #dc2626;
        }

        .btn-back {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .btn-back:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        .detail-body {
            padding: 40px;
        }

        .section {
            margin-bottom: 40px;
        }

        .section-title {
            font-size: 18px;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            padding-bottom: 15px;
            border-bottom: 2px solid var(--border);
        }

        .section-title i {
            color: var(--primary);
            font-size: 20px;
        }

        .meta-info {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 25px;
            margin-bottom: 30px;
        }

        .info-card {
            padding: 20px;
            background: var(--light);
            border-radius: 8px;
            border-left: 4px solid var(--primary);
        }

        .info-label {
            font-size: 12px;
            font-weight: 600;
            color: #9ca3af;
            text-transform: uppercase;
            margin-bottom: 8px;
            letter-spacing: 0.5px;
        }

        .info-value {
            font-size: 16px;
            font-weight: 700;
            color: var(--dark);
        }

        .content-section {
            background: var(--light);
            padding: 25px;
            border-radius: 8px;
            line-height: 1.8;
            color: #4b5563;
        }

        .content-section p {
            margin-bottom: 12px;
        }

        .status-badge {
            display: inline-block;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-draft {
            background: #fef3c7;
            color: #92400e;
        }

        .status-published {
            background: #dcfce7;
            color: #166534;
        }

        .instruktur-card {
            display: flex;
            align-items: center;
            gap: 20px;
            padding: 20px;
            background: #f0f4ff;
            border-radius: 8px;
            border-left: 4px solid var(--secondary);
        }

        .instruktur-avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: var(--secondary);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            font-weight: 700;
        }

        .instruktur-info h4 {
            margin: 0 0 5px 0;
            color: var(--dark);
            font-size: 16px;
        }

        .instruktur-info p {
            margin: 0;
            font-size: 13px;
            color: #6b7280;
        }

        .loading {
            text-align: center;
            padding: 60px 40px;
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

        .alert-error {
            background: #fee2e2;
            color: #991b1b;
            border-left: 4px solid var(--danger);
        }

        @media (max-width: 640px) {
            .detail-header {
                flex-direction: column;
            }

            .header-actions {
                width: 100%;
                flex-direction: column;
            }

            .btn {
                width: 100%;
                justify-content: center;
            }

            .meta-info {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <div class="detail-wrapper">
        <!-- Header -->
        <div class="detail-header">
            <div class="header-content" id="headerContent" style="display: none;">
                <h1 id="judulDisplay"></h1>
                <div class="header-meta">
                    <div class="meta-item">
                        <i class="fas fa-book"></i>
                        <span id="kelasDisplay"></span>
                    </div>
                    <div class="meta-item">
                        <i class="fas fa-calendar"></i>
                        <span id="tanggalDisplay"></span>
                    </div>
                    <div class="meta-item">
                        <i class="fas fa-users"></i>
                        <span id="pesertaDisplay"></span>
                    </div>
                </div>
            </div>
            <div class="header-actions" id="headerActions" style="display: none;">
                <button class="btn btn-back" onclick="window.location.href='/risalah'">
                    <i class="fas fa-arrow-left"></i> Kembali
                </button>
                <button class="btn btn-edit" id="editBtn" onclick="editRisalah()">
                    <i class="fas fa-edit"></i> Edit
                </button>
                <button class="btn btn-delete" onclick="deleteRisalah()">
                    <i class="fas fa-trash"></i> Hapus
                </button>
            </div>
            <div class="loading" id="headerLoading">
                Memuat...
            </div>
        </div>

        <!-- Body -->
        <div class="detail-body" id="detailBody" style="display: none;">
            <!-- Status & Info -->
            <div class="section">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                    <div>
                        <span class="status-badge" id="statusBadge"></span>
                    </div>
                </div>
            </div>

            <!-- Metadata -->
            <div class="section">
                <div class="meta-info">
                    <div class="info-card">
                        <div class="info-label">Kelas</div>
                        <div class="info-value" id="kelasInfo"></div>
                    </div>
                    <div class="info-card">
                        <div class="info-label">Tanggal</div>
                        <div class="info-value" id="tanggalInfo"></div>
                    </div>
                    <div class="info-card">
                        <div class="info-label">Peserta Hadir</div>
                        <div class="info-value" id="pesertaInfo"></div>
                    </div>
                </div>
            </div>

            <!-- Instruktur -->
            <div class="section">
                <div class="section-title">
                    <i class="fas fa-user-tie"></i> Instruktur
                </div>
                <div class="instruktur-card" id="instrukturCard"></div>
            </div>

            <!-- Isi Risalah -->
            <div class="section">
                <div class="section-title">
                    <i class="fas fa-file-alt"></i> Isi Risalah
                </div>
                <div class="content-section" id="isiContent"></div>
            </div>

            <!-- Catatan Penting -->
            <div class="section" id="catatanSection" style="display: none;">
                <div class="section-title">
                    <i class="fas fa-exclamation-circle"></i> Catatan Penting
                </div>
                <div class="content-section" id="catatanContent"></div>
            </div>
        </div>

        <div id="errorContainer" style="display: none;">
            <div class="alert alert-error">
                <i class="fas fa-exclamation-circle"></i>
                <span id="errorMessage"></span>
            </div>
        </div>
    </div>
</div>

<script>
    let risalahId = null;

    document.addEventListener('DOMContentLoaded', async () => {
        const pathParts = window.location.pathname.split('/');
        risalahId = pathParts[2];

        if (!risalahId) {
            showError('Risalah not found');
            return;
        }

        await loadRisalah();
    });

    async function loadRisalah() {
        try {
            const token = localStorage.getItem('token');
            const response = await fetch(`/api/risalah/${risalahId}`, {
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Content-Type': 'application/json'
                }
            });

            if (!response.ok) {
                if (response.status === 404) {
                    showError('Risalah tidak ditemukan');
                } else {
                    showError('Error loading risalah');
                }
                return;
            }

            const result = await response.json();
            const risalah = result.data;

            displayRisalah(risalah);
        } catch (error) {
            console.error('Error loading risalah:', error);
            showError('Error: ' + error.message);
        }
    }

    function displayRisalah(risalah) {
        // Header
        document.getElementById('judulDisplay').textContent = escapeHtml(risalah.judul);
        document.getElementById('kelasDisplay').textContent = escapeHtml(risalah.kelas.nama_kelas);
        document.getElementById('tanggalDisplay').textContent = new Date(risalah.tanggal).toLocaleDateString('id-ID');
        document.getElementById('pesertaDisplay').textContent = risalah.peserta_hadir + ' peserta';

        // Body
        document.getElementById('kelasInfo').textContent = escapeHtml(risalah.kelas.nama_kelas);
        document.getElementById('tanggalInfo').textContent = new Date(risalah.tanggal).toLocaleDateString('id-ID', { 
            weekday: 'long', 
            year: 'numeric', 
            month: 'long', 
            day: 'numeric' 
        });
        document.getElementById('pesertaInfo').textContent = risalah.peserta_hadir + ' peserta hadir';

        // Status
        const statusBadge = document.getElementById('statusBadge');
        statusBadge.className = `status-badge status-${risalah.status}`;
        statusBadge.textContent = risalah.status === 'draft' ? 'Draft' : 'Published';

        // Instruktur
        const instruktur = risalah.instruktur;
        const initials = (instruktur.nama || 'XX').split(' ').map(n => n[0]).join('').toUpperCase();
        document.getElementById('instrukturCard').innerHTML = `
            <div class="instruktur-avatar">${initials}</div>
            <div class="instruktur-info">
                <h4>${escapeHtml(instruktur.nama)}</h4>
                <p><strong>NIP:</strong> ${escapeHtml(instruktur.nip || 'N/A')}</p>
                <p><strong>Spesialisasi:</strong> ${escapeHtml(instruktur.spesialisasi || 'N/A')}</p>
            </div>
        `;

        // Isi
        document.getElementById('isiContent').innerHTML = escapeHtml(risalah.isi).split('\n').map(p => `<p>${p}</p>`).join('');

        // Catatan Penting
        if (risalah.catatan_penting) {
            document.getElementById('catatanSection').style.display = 'block';
            document.getElementById('catatanContent').innerHTML = escapeHtml(risalah.catatan_penting).split('\n').map(p => `<p>${p}</p>`).join('');
        }

        // Show content
        document.getElementById('headerLoading').style.display = 'none';
        document.getElementById('headerContent').style.display = 'block';
        document.getElementById('headerActions').style.display = 'flex';
        document.getElementById('detailBody').style.display = 'block';
    }

    function editRisalah() {
        window.location.href = `/risalah/${risalahId}/edit`;
    }

    async function deleteRisalah() {
        if (!confirm('Apakah Anda yakin ingin menghapus risalah ini?')) return;

        try {
            const token = localStorage.getItem('token');
            const response = await fetch(`/api/risalah/${risalahId}`, {
                method: 'DELETE',
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Content-Type': 'application/json'
                }
            });

            if (response.ok) {
                window.location.href = '/risalah';
            } else {
                showError('Gagal menghapus risalah');
            }
        } catch (error) {
            console.error('Error deleting risalah:', error);
            showError('Error: ' + error.message);
        }
    }

    function showError(message) {
        document.getElementById('headerLoading').style.display = 'none';
        document.getElementById('errorContainer').style.display = 'block';
        document.getElementById('errorMessage').textContent = message;
        setTimeout(() => window.location.href = '/risalah', 3000);
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
@endsection
