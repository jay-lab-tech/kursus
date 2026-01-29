@extends('layouts.app')

@section('content')
<div class="risalah-form-container">
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

        .risalah-form-container {
            max-width: 900px;
            margin: 0 auto;
            padding: 30px 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }

        .form-wrapper {
            background: white;
            border-radius: 12px;
            padding: 40px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        .page-title {
            font-size: 28px;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 10px;
        }

        .page-subtitle {
            color: #6b7280;
            margin-bottom: 30px;
            font-size: 14px;
        }

        .form-group {
            margin-bottom: 25px;
        }

        label {
            display: block;
            font-weight: 600;
            margin-bottom: 8px;
            color: var(--dark);
            font-size: 14px;
        }

        .required::after {
            content: ' *';
            color: var(--danger);
        }

        input[type="text"],
        input[type="date"],
        input[type="number"],
        textarea,
        select {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid var(--border);
            border-radius: 8px;
            font-size: 14px;
            font-family: inherit;
            transition: all 0.3s ease;
        }

        input[type="text"]:focus,
        input[type="date"]:focus,
        input[type="number"]:focus,
        textarea:focus,
        select:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
        }

        textarea {
            resize: vertical;
            min-height: 120px;
            line-height: 1.5;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .form-row-3 {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 20px;
        }

        .form-actions {
            display: flex;
            gap: 15px;
            margin-top: 40px;
            padding-top: 30px;
            border-top: 1px solid var(--border);
        }

        button {
            padding: 12px 30px;
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

        .btn-submit {
            background: var(--primary);
            color: white;
            flex: 1;
        }

        .btn-submit:hover {
            background: #2563eb;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4);
        }

        .btn-cancel {
            background: var(--light);
            color: var(--dark);
            border: 1px solid var(--border);
            flex: 1;
        }

        .btn-cancel:hover {
            background: #f3f4f6;
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

        .alert-success {
            background: #dcfce7;
            color: #166534;
            border-left: 4px solid var(--success);
        }

        .error-message {
            color: var(--danger);
            font-size: 12px;
            margin-top: 5px;
        }

        .character-count {
            font-size: 12px;
            color: #9ca3af;
            margin-top: 5px;
            text-align: right;
        }

        .loading {
            text-align: center;
            padding: 40px;
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

        @media (max-width: 640px) {
            .form-row,
            .form-row-3 {
                grid-template-columns: 1fr;
            }

            .form-actions {
                flex-direction: column;
            }

            button {
                width: 100%;
            }
        }
    </style>

    <div class="form-wrapper">
        <h1 class="page-title" id="pageTitle">Buat Risalah Baru</h1>
        <p class="page-subtitle">Isi form di bawah untuk membuat risalah/notula kelas</p>

        <div id="alertContainer"></div>

        <form id="risalahForm">
            <div class="form-group">
                <label for="kelasSelect" class="required">Kelas</label>
                <select id="kelasSelect" required>
                    <option value="">-- Pilih Kelas --</option>
                </select>
                <div class="error-message" id="kelasError"></div>
            </div>

            <div class="form-group">
                <label for="tanggal" class="required">Tanggal</label>
                <input type="date" id="tanggal" required>
                <div class="error-message" id="tanggalError"></div>
            </div>

            <div class="form-group">
                <label for="judul" class="required">Judul/Topik</label>
                <input type="text" id="judul" placeholder="e.g., Pertemuan tentang..." required maxlength="255">
                <div class="character-count"><span id="judulCount">0</span>/255</div>
                <div class="error-message" id="judulError"></div>
            </div>

            <div class="form-group">
                <label for="isi" class="required">Isi Risalah</label>
                <textarea id="isi" placeholder="Tulis isi risalah/notula pertemuan..." required></textarea>
                <div class="character-count"><span id="isiCount">0</span> karakter</div>
                <div class="error-message" id="isiError"></div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="pesertaHadir" class="required">Jumlah Peserta Hadir</label>
                    <input type="number" id="pesertaHadir" min="0" placeholder="e.g., 25" required>
                    <div class="error-message" id="pesertaError"></div>
                </div>

                <div class="form-group">
                    <label for="status" class="required">Status</label>
                    <select id="status" required>
                        <option value="draft">Draft</option>
                        <option value="published">Published</option>
                    </select>
                    <div class="error-message" id="statusError"></div>
                </div>
            </div>

            <div class="form-group">
                <label for="catatanPenting">Catatan Penting</label>
                <textarea id="catatanPenting" placeholder="Tambahkan catatan penting atau hal khusus..."></textarea>
                <div class="character-count"><span id="catatanCount">0</span> karakter</div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-submit">
                    <i class="fas fa-save"></i> Simpan Risalah
                </button>
                <button type="button" class="btn-cancel" onclick="window.location.href='/risalah'">
                    <i class="fas fa-times"></i> Batal
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    let isEditMode = false;
    let risalahId = null;

    document.addEventListener('DOMContentLoaded', async () => {
        // Check if we're in edit mode
        const pathParts = window.location.pathname.split('/');
        if (pathParts[2] && pathParts[2] !== 'create') {
            isEditMode = true;
            risalahId = pathParts[2];
            document.getElementById('pageTitle').textContent = 'Edit Risalah';
            await loadRisalahForEdit();
        }

        await loadKelas();
        setupEventListeners();
    });

    async function loadKelas() {
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
                const select = document.getElementById('kelasSelect');
                select.innerHTML = '<option value="">-- Pilih Kelas --</option>';
                
                result.data.forEach(kelas => {
                    const option = document.createElement('option');
                    option.value = kelas.id;
                    option.textContent = kelas.nama_kelas;
                    select.appendChild(option);
                });
            }
        } catch (error) {
            console.error('Error loading kelas:', error);
            showAlert('Error loading kelas', 'error');
        }
    }

    async function loadRisalahForEdit() {
        try {
            const token = localStorage.getItem('token');
            const response = await fetch(`/api/risalah/${risalahId}`, {
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Content-Type': 'application/json'
                }
            });

            if (response.ok) {
                const result = await response.json();
                const risalah = result.data;

                document.getElementById('kelasSelect').value = risalah.kelas_id;
                document.getElementById('tanggal').value = risalah.tanggal;
                document.getElementById('judul').value = risalah.judul;
                document.getElementById('isi').value = risalah.isi;
                document.getElementById('pesertaHadir').value = risalah.peserta_hadir;
                document.getElementById('status').value = risalah.status;
                document.getElementById('catatanPenting').value = risalah.catatan_penting || '';

                updateCharacterCounts();
            } else {
                showAlert('Risalah tidak ditemukan', 'error');
                setTimeout(() => window.location.href = '/risalah', 2000);
            }
        } catch (error) {
            console.error('Error loading risalah:', error);
            showAlert('Error: ' + error.message, 'error');
        }
    }

    function setupEventListeners() {
        document.getElementById('judul').addEventListener('input', updateCharacterCounts);
        document.getElementById('isi').addEventListener('input', updateCharacterCounts);
        document.getElementById('catatanPenting').addEventListener('input', updateCharacterCounts);
        document.getElementById('risalahForm').addEventListener('submit', handleFormSubmit);
    }

    function updateCharacterCounts() {
        document.getElementById('judulCount').textContent = document.getElementById('judul').value.length;
        document.getElementById('isiCount').textContent = document.getElementById('isi').value.length;
        document.getElementById('catatanCount').textContent = document.getElementById('catatanPenting').value.length;
    }

    async function handleFormSubmit(e) {
        e.preventDefault();
        
        // Clear errors
        document.querySelectorAll('.error-message').forEach(el => el.textContent = '');

        const formData = {
            kelas_id: document.getElementById('kelasSelect').value,
            tanggal: document.getElementById('tanggal').value,
            judul: document.getElementById('judul').value,
            isi: document.getElementById('isi').value,
            peserta_hadir: parseInt(document.getElementById('pesertaHadir').value),
            status: document.getElementById('status').value,
            catatan_penting: document.getElementById('catatanPenting').value || null
        };

        try {
            const token = localStorage.getItem('token');
            const method = isEditMode ? 'PUT' : 'POST';
            const endpoint = isEditMode ? `/api/risalah/${risalahId}` : '/api/risalah';

            const response = await fetch(endpoint, {
                method: method,
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(formData)
            });

            const result = await response.json();

            if (!response.ok) {
                if (result.errors) {
                    Object.keys(result.errors).forEach(field => {
                        const errorEl = document.getElementById(field + 'Error');
                        if (errorEl) {
                            errorEl.textContent = result.errors[field][0];
                        }
                    });
                } else {
                    showAlert(result.message || 'Error saving risalah', 'error');
                }
                return;
            }

            showAlert(result.message || 'Risalah berhasil disimpan', 'success');
            setTimeout(() => window.location.href = '/risalah', 2000);
        } catch (error) {
            console.error('Error submitting form:', error);
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

        if (type === 'error') {
            setTimeout(() => alert.remove(), 4000);
        }
    }
</script>
@endsection
