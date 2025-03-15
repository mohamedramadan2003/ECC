<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل الدخول</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" href="{{asset('layout/upload/Screenshot 2025-01-30 172054.png')}}" type="image/x-icon">

    <link rel="stylesheet" href="{{asset('log in/login.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="login-background">
        <div class="login-container">
            <div class="login-card">
                <div class="logo">
                    
                    <i class="fa-solid fa-server"></i>
                    <h2 style="color: rgb(158, 158, 167); text-shadow: 1px 2px rgb(86, 86, 90);">ECC</h2>
                </div>
                <h2>تسجيل الدخول</h2>
                <p>أدخل بياناتك للوصول إلى حسابك</p>
                 
                       <!-- عرض الأخطاء إن وجدت -->
                    @if ($errors->any())
                    
                        <p class="alert alert-danger">البريد الإلكتروني أو كلمة المرور غير صحيحة</p>
                    @endif

                <form action="{{route('login')}}" method="POST" id="login-form">
                    @csrf
                    <div class="form-group">
                        <input type="email" id="email" name="email" placeholder="البريد الإلكتروني">
                        <i class="fas fa-envelope"></i>
                       
                    </div>
                    <div class="form-group">
                        <input type="password" id="password" name="password" placeholder="كلمة المرور">
                        <i class="fas fa-lock"></i>
                        <p id="password-error" class="error-message" style="display: none; color: red;"></p>
                    </div>
                    
                    <div class="forgot-password">
                        <a href="{{route('password.request')}}">نسيت كلمة المرور؟</a>
                    </div>
                    <button  type="submit" class="login-button ">تسجيل الدخول</button>
                </form>
               
            </div>
        </div>
    </div>
    
</body>
</html>

