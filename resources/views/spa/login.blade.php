<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Akademik - Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #4f46e5;
            --primary-dark: #4338ca;
            --secondary: #06b6d4;
        }
        
        body {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .login-container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 50px rgba(0, 0, 0, 0.2);
            max-width: 450px;
            width: 100%;
            padding: 50px;
        }
        
        .login-header {
            text-align: center;
            margin-bottom: 40px;
        }
        
        .login-header h1 {
            color: var(--primary);
            font-weight: 700;
            margin-bottom: 10px;
            font-size: 28px;
        }
        
        .login-header p {
            color: #6b7280;
            font-size: 14px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-label {
            color: #374151;
            font-weight: 500;
            margin-bottom: 8px;
            display: block;
        }
        
        .form-control {
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 12px 15px;
            font-size: 14px;
            transition: all 0.3s;
        }
        
        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        }
        
        .btn-login {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            border: none;
            color: white;
            font-weight: 600;
            padding: 12px;
            border-radius: 8px;
            width: 100%;
            transition: all 0.3s;
            margin-top: 10px;
        }
        
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(79, 70, 229, 0.3);
            color: white;
        }
        
        .alert {
            border-radius: 8px;
            border: none;
            margin-bottom: 20px;
        }
        
        .demo-users {
            background: #f3f4f6;
            border-radius: 8px;
            padding: 15px;
            margin-top: 30px;
            font-size: 13px;
        }
        
        .demo-users p {
            margin: 0;
            color: #6b7280;
        }
        
        .demo-user {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #e5e7eb;
            cursor: pointer;
            transition: all 0.3s;
        }

        .demo-user:hover {
            background: white;
            padding-left: 8px;
        }
        
        .demo-user:last-child {
            border-bottom: none;
        }
        
        .demo-user strong {
            color: var(--primary);
        }
        
        .spinner {
            display: none;
        }
        
        .spinner.show {
            display: inline-block;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <h1>
                <i class="fas fa-graduation-cap"></i> Sistem Akademik
            </h1>
            <p>Manajemen Pelatihan & Akademik</p>
        </div>

        <div id="alertContainer">
            @if ($errors->any())
                <div class="alert alert-danger" role="alert">
                    <i class="fas fa-exclamation-circle"></i>
                    {{ $errors->first() }}
                </div>
            @endif
        </div>

        <form id="loginForm">
            @csrf
            <div class="form-group">
                <label class="form-label" for="email">Email</label>
                <input 
                    type="email" 
                    class="form-control" 
                    id="email" 
                    name="email"
                    placeholder="masukkan email anda"
                    required
                >
            </div>

            <div class="form-group">
                <label class="form-label" for="password">Password</label>
                <input 
                    type="password" 
                    class="form-control" 
                    id="password" 
                    name="password"
                    placeholder="masukkan password"
                    required
                >
            </div>

            <button type="submit" class="btn-login">
                <span class="button-text">Login</span>
                <span class="spinner show">
                    <span class="spinner-border spinner-border-sm me-2"></span>
                </span>
            </button>
        </form>
        <div class="demo-users">
            <p><strong>User Demo:</strong> (klik untuk isi otomatis)</p>
            <div class="demo-user" data-email="admin@admin.com"></div>
                <span>Admin</span>
                <strong>
                    <i class="fas fa-check"></i>
                </strong>
            </div>
            
    </div>

    <script>
        // Use APP_URL from config with /api suffix
        const API_URL = '{{ config("app.url") }}/api';
        
        const form = document.getElementById('loginForm');
        const emailInput = document.getElementById('email');
        const passwordInput = document.getElementById('password');
        const alertContainer = document.getElementById('alertContainer');
        const spinnerEl = document.querySelector('.spinner');
        const buttonText = document.querySelector('.button-text');

        // Set demo user on click
        document.querySelectorAll('.demo-user').forEach(user => {
            user.addEventListener('click', () => {
                const email = user.dataset.email;
                emailInput.value = email;
                passwordInput.value = 'secret';
                passwordInput.focus();
            });
        });

        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            
            const email = emailInput.value;
            const password = passwordInput.value;

            // Show loading state
            spinnerEl.classList.add('show');
            buttonText.style.display = 'none';
            form.querySelector('button').disabled = true;

            try {
                const response = await fetch(`${API_URL}/auth/login`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ email, password })
                });

                const data = await response.json();

                if (response.ok) {
                    // Store token - support both auth_token dan token
                    localStorage.setItem('auth_token', data.access_token);
                    localStorage.setItem('token', data.access_token);
                    localStorage.setItem('user', JSON.stringify(data.user));
                    
                    // Store user details untuk quick access
                    localStorage.setItem('userId', data.user.id);
                    localStorage.setItem('userName', data.user.name);
                    localStorage.setItem('userRole', data.user.role);

                    showAlert('Login berhasil! Mengarahkan ke dashboard...', 'success');
                    
                    // Redirect to appropriate dashboard based on role
                    // Calculate base URL by removing /login from current path
                    setTimeout(() => {
                        const role = data.user.role;
                        const currentPath = window.location.pathname;
                        // Remove /login from pathname, keep everything else
                        let basePath = currentPath.replace(/\/login\/?$/, '') || '/';
                        // Remove trailing slash for clean URL building
                        basePath = basePath.replace(/\/$/, '');
                        
                        // Build redirect URL
                        const redirectPath = role === 'admin' ? '/admin' : '/dashboard';
                        const redirectUrl = window.location.origin + basePath + redirectPath;
                        
                        console.log('Redirect Debug:', {
                            currentPath: currentPath,
                            basePath: basePath,
                            redirectUrl: redirectUrl,
                            role: role
                        });
                        
                        window.location.href = redirectUrl;
                    }, 1500);
                } else {
                    showAlert(data.message || 'Login gagal. Periksa email dan password anda.', 'danger');
                }
            } catch (error) {
                showAlert(`Terjadi kesalahan: ${error.message}`, 'danger');
                console.error('Login error:', error);
            } finally {
                // Hide loading state
                spinnerEl.classList.remove('show');
                buttonText.style.display = 'inline';
                form.querySelector('button').disabled = false;
            }
        });

        function showAlert(message, type) {
            alertContainer.innerHTML = `
                <div class="alert alert-${type}" role="alert">
                    <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'}"></i>
                    ${message}
                </div>
            `;
            
            if (type === 'danger') {
                setTimeout(() => {
                    alertContainer.innerHTML = '';
                }, 5000);
            }
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
