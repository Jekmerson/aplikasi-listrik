<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Aplikasi Listrik Pascabayar PLN</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
            background: linear-gradient(135deg, #0f2027 0%, #203a43 50%, #2c5364 100%);
            position: relative;
            overflow: hidden;
        }

        /* Animated Background */
        body::before {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            background-image: 
                radial-gradient(circle at 20% 50%, rgba(26, 188, 156, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 80%, rgba(52, 152, 219, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 40% 20%, rgba(155, 89, 182, 0.1) 0%, transparent 50%);
            animation: gradient 15s ease infinite;
        }

        @keyframes gradient {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }

        /* Floating Particles */
        .particle {
            position: absolute;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            animation: float 20s infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-100px) rotate(180deg); }
        }

        .login-wrapper {
            position: relative;
            z-index: 10;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        .login-container {
            max-width: 1000px;
            width: 100%;
            display: flex;
            background: rgba(255, 255, 255, 0.98);
            border-radius: 25px;
            overflow: hidden;
            box-shadow: 0 30px 80px rgba(0, 0, 0, 0.4);
            backdrop-filter: blur(10px);
        }

        /* Left Side - Brand */
        .login-brand {
            flex: 1;
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 50%, #3498db 100%);
            padding: 60px 40px;
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .login-brand::before {
            content: '';
            position: absolute;
            width: 300px;
            height: 300px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            top: -100px;
            right: -100px;
        }

        .login-brand::after {
            content: '';
            position: absolute;
            width: 200px;
            height: 200px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 50%;
            bottom: -50px;
            left: -50px;
        }

        .brand-logo {
            position: relative;
            z-index: 2;
        }

        .brand-logo i {
            font-size: 5rem;
            margin-bottom: 20px;
            display: block;
            animation: pulse 2s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        .brand-logo h1 {
            font-size: 2.2rem;
            font-weight: 700;
            margin-bottom: 10px;
            line-height: 1.2;
        }

        .brand-logo .subtitle {
            font-size: 1rem;
            font-weight: 300;
            opacity: 0.9;
            margin-bottom: 30px;
        }

        .brand-features {
            position: relative;
            z-index: 2;
            margin-top: 40px;
        }

        .brand-features .feature-item {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            animation: slideInLeft 0.6s ease forwards;
            opacity: 0;
        }

        .brand-features .feature-item:nth-child(1) { animation-delay: 0.2s; }
        .brand-features .feature-item:nth-child(2) { animation-delay: 0.4s; }
        .brand-features .feature-item:nth-child(3) { animation-delay: 0.6s; }

        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .feature-item i {
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            font-size: 1.2rem;
        }

        /* Right Side - Form */
        .login-form-section {
            flex: 1;
            padding: 60px 50px;
            background: white;
        }

        .form-header {
            margin-bottom: 40px;
        }

        .form-header h2 {
            font-size: 1.8rem;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 8px;
        }

        .form-header p {
            color: #7f8c8d;
            font-size: 0.95rem;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-label {
            font-weight: 500;
            color: #34495e;
            margin-bottom: 10px;
            font-size: 0.9rem;
        }

        .input-wrapper {
            position: relative;
        }

        .input-wrapper i {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: #95a5a6;
            font-size: 1.1rem;
        }

        .form-control {
            height: 55px;
            padding: 0 20px 0 50px;
            border: 2px solid #ecf0f1;
            border-radius: 12px;
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }
        
        .form-control:focus {
            border-color: #3498db;
            box-shadow: 0 0 0 4px rgba(52, 152, 219, 0.1);
            outline: none;
        }

        .btn-login {
            width: 100%;
            height: 55px;
            background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
            border: none;
            border-radius: 12px;
            color: white;
            font-weight: 600;
            font-size: 1rem;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .btn-login::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            transition: left 0.5s;
        }

        .btn-login:hover::before {
            left: 100%;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(52, 152, 219, 0.4);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .divider {
            text-align: center;
            margin: 30px 0;
            position: relative;
        }

        .divider::before {
            content: '';
            position: absolute;
            width: 100%;
            height: 1px;
            background: #ecf0f1;
            top: 50%;
            left: 0;
        }

        .divider span {
            background: white;
            padding: 0 15px;
            color: #95a5a6;
            font-size: 0.85rem;
            position: relative;
        }

        .demo-box {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 15px;
            padding: 25px;
            border: 2px dashed #dee2e6;
        }

        .demo-box h6 {
            font-size: 0.9rem;
            font-weight: 600;
            color: #495057;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
        }

        .demo-box h6 i {
            margin-right: 8px;
            color: #3498db;
        }

        .demo-item {
            background: white;
            padding: 12px 15px;
            border-radius: 10px;
            margin-bottom: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: all 0.3s ease;
            cursor: pointer;
            border: 1px solid #e9ecef;
        }

        .demo-item:hover {
            transform: translateX(5px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            border-color: #3498db;
        }

        .demo-item:last-child {
            margin-bottom: 0;
        }

        .demo-role {
            font-weight: 600;
            color: #2c3e50;
        }

        .demo-creds {
            font-size: 0.85rem;
            color: #7f8c8d;
        }

        .alert {
            border-radius: 12px;
            border: none;
            padding: 15px 20px;
            margin-bottom: 25px;
        }

        .footer-text {
            text-align: center;
            margin-top: 30px;
            padding-top: 25px;
            border-top: 1px solid #ecf0f1;
            color: #95a5a6;
            font-size: 0.85rem;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .login-brand {
                display: none;
            }

            .login-form-section {
                padding: 40px 30px;
            }

            .brand-logo h1 {
                font-size: 1.8rem;
            }
        }
    </style>
</head>
<body>
    <!-- Animated Particles -->
    <div class="particle" style="width: 80px; height: 80px; left: 10%; top: 20%; animation-delay: 0s;"></div>
    <div class="particle" style="width: 60px; height: 60px; left: 80%; top: 60%; animation-delay: 2s;"></div>
    <div class="particle" style="width: 40px; height: 40px; left: 60%; top: 10%; animation-delay: 4s;"></div>
    <div class="particle" style="width: 100px; height: 100px; left: 20%; top: 80%; animation-delay: 1s;"></div>

    <div class="login-wrapper">
        <div class="login-container">
            <!-- Left Side - Brand -->
            <div class="login-brand">
                <div class="brand-logo">
                    <i class="fas fa-bolt"></i>
                    <h1>PLN Pascabayar</h1>
                    <p class="subtitle">Sistem Informasi Tagihan Listrik</p>
                </div>

                <div class="brand-features">
                    <div class="feature-item">
                        <i class="fas fa-chart-line"></i>
                        <span>Monitoring Real-time</span>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-file-invoice-dollar"></i>
                        <span>Manajemen Tagihan Otomatis</span>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-shield-alt"></i>
                        <span>Keamanan Terjamin</span>
                    </div>
                </div>
            </div>

            <!-- Right Side - Form -->
            <div class="login-form-section">
                <div class="form-header">
                    <h2>Selamat Datang!</h2>
                    <p>Masuk untuk mengakses dashboard Anda</p>
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        @foreach ($errors->all() as $error)
                            {{ $error }}
                        @endforeach
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form method="POST" action="{{ route('login.process') }}">
                    @csrf
                    
                    <div class="form-group">
                        <label class="form-label">Username</label>
                        <div class="input-wrapper">
                            <i class="fas fa-user"></i>
                            <input type="text" name="username" class="form-control" 
                                   placeholder="Masukkan username Anda" 
                                   value="{{ old('username') }}" required autofocus>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Password</label>
                        <div class="input-wrapper">
                            <i class="fas fa-lock"></i>
                            <input type="password" name="password" class="form-control" 
                                   placeholder="Masukkan password Anda" required>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-login">
                        <i class="fas fa-sign-in-alt me-2"></i> Masuk ke Dashboard
                    </button>
                </form>

                <div class="divider">
                    <span>Akun Demo Tersedia</span>
                </div>

                <div class="demo-box">
                    <h6>
                        <i class="fas fa-user-shield"></i>
                        Kredensial Demo
                    </h6>
                    <div class="demo-item" onclick="fillLogin('admin', 'admin123')">
                        <div>
                            <div class="demo-role">
                                <i class="fas fa-crown text-danger me-1"></i> Admin
                            </div>
                            <div class="demo-creds">admin / admin123</div>
                        </div>
                        <i class="fas fa-arrow-right text-muted"></i>
                    </div>
                    <div class="demo-item" onclick="fillLogin('operator1', 'operator123')">
                        <div>
                            <div class="demo-role">
                                <i class="fas fa-user-cog text-primary me-1"></i> Operator
                            </div>
                            <div class="demo-creds">operator1 / operator123</div>
                        </div>
                        <i class="fas fa-arrow-right text-muted"></i>
                    </div>
                    <div class="demo-item" onclick="fillLogin('PEL001', 'password123')">
                        <div>
                            <div class="demo-role">
                                <i class="fas fa-user text-info me-1"></i> Pelanggan
                            </div>
                            <div class="demo-creds">PEL001 / password123</div>
                        </div>
                        <i class="fas fa-arrow-right text-muted"></i>
                    </div>
                </div>

                <div class="footer-text">
                    <i class="fas fa-building me-1"></i>
                    &copy; 2026 PT PLN (Persero). All rights reserved.
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function fillLogin(username, password) {
            document.querySelector('input[name="username"]').value = username;
            document.querySelector('input[name="password"]').value = password;
            // Add visual feedback
            document.querySelector('input[name="username"]').focus();
        }
    </script>
</body>
</html>
