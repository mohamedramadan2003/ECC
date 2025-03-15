<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>صفحة التواصل</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            flex-direction: column;
        }
        .container {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 100%;
            max-width: 500px;
        }
        h2 {
            text-align: center;
            color: #333;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            font-size: 16px;
            color: #555;
            display: block;
            margin-bottom: 5px;
        }
        input[type="text"],
        input[type="email"],
        textarea {
            width: 100%;
            padding: 10px;
            font-size: 14px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-bottom: 10px;
        }
        textarea {
            resize: vertical;
            height: 150px;
        }
        button {
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            width: 100%;
        }
        button:hover {
            background-color: #45a049;
        }
        .back-button {
            background-color: #f44336; /* اللون الأحمر للزر */
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            width: 100%;
            margin-top: 20px;
        }
        .back-button:hover {
            background-color: #e53935;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>التواصل معنا</h2>
        <form action="mailto:moh7medramadan2003@gmail.com" method="post" enctype="text/plain">
            <div class="form-group">
                <label for="name">الاسم:</label>
                <input type="text" id="name" name="name" required placeholder="أدخل اسمك">
            </div>
            <div class="form-group">
                <label for="email">البريد الإلكتروني:</label>
                <input type="email" id="email" name="email" required placeholder="أدخل بريدك الإلكتروني">
            </div>
            <div class="form-group">
                <label for="message">الرسالة:</label>
                <textarea id="message" name="message" required placeholder="اكتب رسالتك هنا..."></textarea>
            </div>
            <button type="submit">إرسال الرسالة</button>
        </form>

        <!-- زر الرجوع -->
        <button class="back-button" onclick="window.history.back()">رجوع</button>
    </div>

</body>
</html>
