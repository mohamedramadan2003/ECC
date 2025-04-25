<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إعادة تعيين كلمة المرور</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background-color: #f5f7fa;
            color: #333;
            line-height: 1.6;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
            background-image: linear-gradient(135deg, #f5f7fa 0%, #e4e8eb 100%);
        }
        
        .container {
            background-color: white;
            padding: 2.5rem;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
            width: 100%;
            max-width: 480px;
            transition: all 0.3s ease;
            border: 1px solid #e1e5eb;
        }
        
        .title {
            text-align: center;
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 0.8rem;
            color: #2c3e50;
        }
        
        .description {
            text-align: center;
            color: #7f8c8d;
            font-size: 1rem;
            margin-bottom: 2rem;
            line-height: 1.7;
        }
        
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 0.6rem;
            font-size: 0.95rem;
            font-weight: 500;
            color: #2c3e50;
        }
        
        .form-control {
            width: 100%;
            padding: 0.9rem;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s;
            background-color: #f8f9fa;
        }
        
        .form-control:focus {
            border-color: #5d4ee1;
            outline: none;
            box-shadow: 0 0 0 3px rgba(93, 78, 225, 0.2);
            background-color: white;
        }
        
        .error-message {
            color: #e74c3c;
            font-size: 0.85rem;
            margin-top: 0.4rem;
            display: block;
        }
        
        .btn {
            display: block;
            width: 100%;
            padding: 1rem;
            background-color: #5d4ee1;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1.05rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s;
            margin-top: 1.5rem;
        }
        
        .btn:hover {
            background-color: #4a3bb8;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(93, 78, 225, 0.3);
        }
        
        .btn:active {
            transform: translateY(0);
        }
        
        .footer-text {
            text-align: center;
            margin-top: 1.8rem;
            font-size: 0.9rem;
            color: #7f8c8d;
        }
        
        .footer-text a {
            color: #5d4ee1;
            text-decoration: none;
            font-weight: 500;
        }
        
        .footer-text a:hover {
            text-decoration: underline;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .container {
            animation: fadeIn 0.6s ease-out;
        }
        
        @media (max-width: 576px) {
            .container {
                padding: 1.8rem;
            }
            
            .title {
                font-size: 1.3rem;
            }
            
            .description {
                font-size: 0.95rem;
            }
        }
    </style>
</head>
<body>

    <div class="container">

        <h2 class="title">إعادة تعيين كلمة المرور</h2>
        <p class="description">سيتم إرسال رابط إلى بريدك الإلكتروني لإعادة تعيين كلمة المرور الخاصة بحسابك</p>

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="form-group">
                <label for="email">البريد الإلكتروني</label>
                <input 
                    id="email" 
                    type="email" 
                    name="email" 
                    class="form-control" 
                    required 
                    autofocus 
                    placeholder="أدخل بريدك الإلكتروني المسجل" 
                    value="{{ old('email') }}"
                >
                @if($errors->has('email'))
                    <span class="error-message">{{ $errors->first('email') }}</span>
                @endif
            </div>

            <button type="submit" class="btn">إرسال رابط التعيين</button>
        </form>

        <p class="footer-text">
            هل تذكرت كلمة المرور؟ <a href="{{ route('login') }}">العودة إلى صفحة تسجيل الدخول</a>
        </p>
    </div>

</body>
</html>