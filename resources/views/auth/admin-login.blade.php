<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل دخول المشرف</title>
    <!-- Google Fonts: Cairo -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700;900&display=swap" rel="stylesheet">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --deep-forest: #174032;
            --warm-gold: #d4af37;
            --soft-cream: #faf9f6;
            --pure-white: #ffffff;
            --charcoal-dark: #2c3e50;
            --border-subtle: #e8e8e8;
            --primary-gradient: linear-gradient(135deg, #174032 0%, #14532d 100%);
            --gold-gradient: linear-gradient(135deg, #d4af37 0%, #b8941f 100%);
            --background-gradient: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Cairo', sans-serif;
            background: var(--background-gradient);
            min-height: 100vh;
            display: flex;
            align-items: stretch;
            justify-content: stretch;
            padding: 0;
            position: relative;
            overflow: hidden;
        }
        
        /* Background Decoration */
        .bg-decoration {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            opacity: 0.03;
        }
        
        .bg-decoration::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, var(--warm-gold) 1px, transparent 1px);
            background-size: 50px 50px;
            animation: float 20s ease-in-out infinite;
        }
        
        .bg-decoration::after {
            content: '';
            position: absolute;
            bottom: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, var(--deep-forest) 1px, transparent 1px);
            background-size: 80px 80px;
            animation: float 25s ease-in-out infinite reverse;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(180deg); }
        }
        
        .login-wrapper {
            display: flex;
            background: var(--pure-white);
            border-radius: 0;
            box-shadow: 0 20px 60px rgba(23, 64, 50, 0.15);
            overflow: hidden;
            width: 100%;
            max-width: 100%;
            min-height: 100vh;
            border: none;
        }
        
        .login-side {
            flex: 1;
            background: var(--primary-gradient);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 3rem;
            position: relative;
            overflow: hidden;
        }
        
        .login-side::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="50" cy="50" r="1" fill="%23d4af37" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
            opacity: 0.3;
        }
        
        .login-side-content {
            position: relative;
            z-index: 2;
            text-align: center;
            color: var(--warm-gold);
        }
        
        .logo-icon {
            width: 100px;
            height: 100px;
            background: var(--gold-gradient);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 2rem;
            font-size: 3rem;
            color: var(--deep-forest);
            border: 4px solid var(--warm-gold);
            box-shadow: 0 10px 30px rgba(212, 175, 55, 0.3);
        }
        
        .side-title {
            font-size: 2.2rem;
            font-weight: 900;
            margin-bottom: 1rem;
            letter-spacing: 0.5px;
        }
        
        .side-subtitle {
            font-size: 1.1rem;
            font-weight: 500;
            opacity: 0.9;
            line-height: 1.6;
        }
        
        .form-side {
            flex: 1;
            padding: 3rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        
        .form-header {
            text-align: center;
            margin-bottom: 2.5rem;
        }
        
        .form-title {
            color: var(--deep-forest);
            font-size: 1.8rem;
            font-weight: 900;
            margin-bottom: 0.5rem;
        }
        
        .form-subtitle {
            color: var(--charcoal-dark);
            font-size: 1rem;
            opacity: 0.7;
        }
        
        .form-group {
            margin-bottom: 1.5rem;
            position: relative;
        }
        
        .form-label {
            display: block;
            color: var(--deep-forest);
            font-weight: 700;
            font-size: 1rem;
            margin-bottom: 0.5rem;
        }
        
        .input-wrapper {
            position: relative;
        }
        
        .form-input {
            width: 100%;
            padding: 1rem 1rem 1rem 3rem;
            border: 2px solid var(--border-subtle);
            border-radius: 12px;
            font-size: 1rem;
            font-family: 'Cairo', sans-serif;
            background: var(--pure-white);
            color: var(--charcoal-dark);
            transition: all 0.3s ease;
            height: 55px;
        }
        
        .form-input:focus {
            outline: none;
            border-color: var(--warm-gold);
            background: #fffbe6;
            box-shadow: 0 4px 16px rgba(212, 175, 55, 0.1);
        }
        
        .input-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--charcoal-dark);
            font-size: 1.1rem;
            transition: color 0.3s ease;
        }
        
        .form-input:focus + .input-icon {
            color: var(--warm-gold);
        }
        
        .login-btn {
            width: 100%;
            background: var(--primary-gradient);
            color: var(--warm-gold);
            border: none;
            border-radius: 12px;
            padding: 1rem;
            font-size: 1.1rem;
            font-weight: 700;
            font-family: 'Cairo', sans-serif;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 1rem;
            position: relative;
            overflow: hidden;
        }
        
        .login-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(212, 175, 55, 0.2), transparent);
            transition: left 0.5s ease;
        }
        
        .login-btn:hover::before {
            left: 100%;
        }
        
        .login-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(23, 64, 50, 0.2);
        }
        
        .login-btn:active {
            transform: translateY(0);
        }
        
        .error-message {
            background: #fee;
            color: #c53030;
            padding: 0.75rem;
            border-radius: 8px;
            margin-bottom: 1rem;
            font-size: 0.9rem;
            border: 1px solid #fecaca;
        }
        
        .success-message {
            background: #f0fff4;
            color: #22543d;
            padding: 0.75rem;
            border-radius: 8px;
            margin-bottom: 1rem;
            font-size: 0.9rem;
            border: 1px solid #c6f6d5;
        }
        
        .back-link {
            text-align: center;
            margin-top: 2rem;
        }
        
        .back-link a {
            color: var(--warm-gold);
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }
        
        .back-link a:hover {
            color: var(--deep-forest);
        }
        
        @media (max-width: 768px) {
            .login-wrapper {
                flex-direction: column;
                max-width: 100%;
                min-height: 100vh;
            }
            
            .login-side {
                padding: 2rem;
                min-height: 40vh;
            }
            
            .form-side {
                padding: 2rem;
                min-height: 60vh;
            }
            
            .side-title {
                font-size: 1.8rem;
            }
            
            .logo-icon {
                width: 80px;
                height: 80px;
                font-size: 2.5rem;
            }
        }
        
        @media (max-width: 480px) {
            body {
                padding: 0;
            }
            
            .login-wrapper {
                margin: 0;
            }
            
            .login-side {
                padding: 1.5rem;
                min-height: 35vh;
            }
            
            .form-side {
                padding: 1.5rem;
                min-height: 65vh;
            }
            
            .side-title {
                font-size: 1.5rem;
            }
            
            .form-title {
                font-size: 1.5rem;
            }
            
            .logo-icon {
                width: 60px;
                height: 60px;
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>
    <div class="bg-decoration"></div>
    
    <div class="login-wrapper">
        <div class="form-side">
            <div class="form-header">
                <h2 class="form-title">تسجيل دخول المشرف</h2>
                <p class="form-subtitle">أدخل بياناتك للوصول إلى النظام</p>
            </div>
            
            @if ($errors->any())
                <div class="error-message">
                    <i class="fas fa-exclamation-triangle"></i>
                    بيانات الدخول غير صحيحة
                </div>
            @endif
            
            @if (session('status'))
                <div class="success-message">
                    <i class="fas fa-check-circle"></i>
                    {{ session('status') }}
                </div>
            @endif
            
            <form method="POST" action="{{ route('admin.login') }}">
                @csrf
                
                <div class="form-group">
                    <label for="email" class="form-label">البريد الإلكتروني</label>
                    <div class="input-wrapper">
                        <input type="email" id="email" name="email" class="form-input" 
                               value="{{ old('email') }}" required autofocus 
                               placeholder="أدخل بريدك الإلكتروني">
                        <i class="fas fa-envelope input-icon"></i>
                    </div>
                    @error('email')
                        <span style="color: #c53030; font-size: 0.85rem; margin-top: 0.25rem; display: block;">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="password" class="form-label">كلمة المرور</label>
                    <div class="input-wrapper">
                        <input type="password" id="password" name="password" class="form-input" 
                               required placeholder="أدخل كلمة المرور">
                        <i class="fas fa-lock input-icon"></i>
                    </div>
                    @error('password')
                        <span style="color: #c53030; font-size: 0.85rem; margin-top: 0.25rem; display: block;">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label style="display: flex; align-items: center; cursor: pointer;">
                        <input type="checkbox" name="remember" style="margin-left: 0.5rem;">
                        <span style="font-size: 0.9rem; color: var(--charcoal-dark);">تذكرني</span>
                    </label>
                </div>
                
                <button type="submit" class="login-btn">
                    <i class="fas fa-sign-in-alt" style="margin-left: 0.5rem;"></i>
                    تسجيل الدخول
                </button>
            </form>
            
            <div class="back-link">
                <a href="{{ url('/') }}">
                    <i class="fas fa-arrow-right" style="margin-left: 0.5rem;"></i>
                    العودة للصفحة الرئيسية
                </a>
            </div>
        </div>
        
        <div class="login-side">
            <div class="login-side-content">
                <div class="logo-icon">
                    <i class="fas fa-mosque"></i>
                </div>
                <h1 class="side-title">نظام إدارة المساجد</h1>
                <p class="side-subtitle">مرحباً بك في لوحة تحكم المشرف<br>سجل دخولك للوصول إلى جميع الميزات</p>
            </div>
        </div>
    </div>
</body>
</html> 