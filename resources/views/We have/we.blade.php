<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> عنا</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700&display=swap" rel="stylesheet">

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Cairo', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 20px 20px;
        }

        h1 {
            margin-top: 150px;
            font-size: 28px;
            color: #0d47a1;
            margin-bottom: 25px;
            text-align: center;
        }

        
        .description-section {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 20px;
            width: 100%;
            max-width: 1200px;
            margin-bottom: 25px;
        }

        .description-box {
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            padding: 20px;
            flex: 1;
            min-width: 280px;
            text-align: center;
            transition: transform 0.3s ease;
        }

        .description-box:hover {
            transform: translateY(-8px);
        }

        .description-box h2 {
            font-size: 20px;
            color: #0d47a1;
            margin-bottom: 10px;
        }

        .description-box p {
            font-size: 14px;
            color: #555;
            line-height: 1.5;
        }

      
        .team-section {
            display: flex;
            justify-content: center;
            gap: 20px;
            width: 100%;
            max-width: 1200px;
            flex-wrap: wrap;
        }

        .team-box {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            text-align: center;
            transition: transform 0.3s;
            padding: 15px;
            width: 220px;
            margin-bottom: 15px;
        }

        .team-box:hover {
            transform: translateY(-5px);
        }

        .team-box img {
            width: 100%;
            height: 180px; 
            object-fit: cover;
            border-radius: 6px;
        }

        .team-box h3 {
            font-size: 16px;
            color: #0d47a1;
            margin: 10px 0;
        }

        .team-box p {
            font-size: 12px;
            color: #666;
        }

        .back-button {
            margin-top: 20px;
            padding: 10px 20px;
            font-size: 14px;
            border-radius: 8px;
            border: none;
            background: linear-gradient(to right, #e53935, #c62828);
            color: white;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .back-button:hover {
            background: linear-gradient(to right, #d32f2f, #b71c1c);
        }

        @media (max-width: 768px) {
            .description-section {
                flex-direction: column;
                align-items: center;
            }

            .team-section {
                flex-direction: column;
                align-items: center;
            }

            .description-box, .team-box {
                width: 90%;
                margin-bottom: 20px;
            }
        }
    </style>
</head>
<body>

    <h1><i class="fas fa-graduation-cap"></i> تسليم الامتحانات بسهولة واحترافية</h1>

    <!-- قسم "ما يفعله الموقع" -->
    <div class="description-section">
        <div class="description-box">
            <h2>ما يفعله الموقع</h2>
            <p>
                موقعنا يهدف إلى تسهيل وتسريع عملية تسليم الامتحانات بشكل آمن واحترافي. يمكن للطلاب رفع ملفات الامتحانات بسهولة،
                كما يتيح للمؤسسات التعليمية متابعة تسليم الامتحانات بشكل لحظي. تصميم الموقع يركز على تبسيط العملية وجعلها سهلة 
                لجميع المستخدمين مع توفير مستويات حماية وأمان عالية.
            </p>
        </div>

        <div class="description-box">
            <h2>ميزات الموقع</h2>
            <p>
                يوفر الموقع تجربة سلسة للمشرفين والعاملين في الكونترول. يتيح للمشرفين إضافة الامتحانات والمواد الدراسية بكل سهولة عبر الويب.
             وتنظيم الامتحانات للمواد المختلفة.            </p>
            <p>
                العاملون في الكونترول مسؤولون عن استلام الامتحانات التي يتم رفعها من قبل المشرفين. يتيح لهم الموقع متابعة عملية تسليم الامتحانات بشكل دقيق،
            </p>
        </div>
        
    </div>
    
    <!-- زر الرجوع -->
    <a href="{{route('home.index')}}" class="back-button" onclick="history.back()">🔙 رجوع</a>

</body>
</html>
