<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إعادة تعيين كلمة المرور</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            direction: rtl;
        }
        .container {
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
        }
        .title {
            text-align: center;
            font-size: 24px;
            color: #333;
            margin-bottom: 15px;
        }
        .description {
            text-align: center;
            color: #666;
            font-size: 14px;
            margin-bottom: 20px;
        }
        .input-group {
            margin-bottom: 20px;
        }
        .input-group label {
            display: block;
            color: #333;
            font-size: 14px;
            margin-bottom: 5px;
        }
        .input-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
        }
        .input-group input:focus {
            border-color: #007bff;
            outline: none;
        }
        .error-message {
            color: red;
            font-size: 12px;
            margin-top: 5px;
        }
        .submit-button {
            background-color: #007bff;
            color: white;
            padding: 12px;
            width: 100%;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        .submit-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2 class="title">نسيت كلمة المرور؟</h2>
        <p class="description">لا مشكلة. فقط أخبرنا بعنوان بريدك الإلكتروني وسوف نرسل لك رابط لإعادة تعيين كلمة المرور لتمكنك من اختيار كلمة مرور جديدة.</p>

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <!-- عنوان البريد الإلكتروني -->
            <div class="input-group">
                <label for="email">البريد الإلكتروني</label>
                <input id="email" type="email" name="email" required autofocus placeholder="أدخل عنوان بريدك الإلكتروني" value="{{ old('email') }}">
                @if($errors->has('email'))
                    <p class="error-message">{{ $errors->first('email') }}</p>
                @endif
            </div>

            <!-- زر الإرسال -->
            <button type="submit" class="submit-button">إرسال رابط إعادة تعيين كلمة المرور</button>
        </form>
    </div>

</body>
</html>
