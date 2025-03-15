<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>صفحة الأشخاص</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh; /* يجعل الصفحة تشغل كامل ارتفاع الشاشة */
            flex-direction: column;
        }
        .container {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            padding: 20px;
            flex: 1;
        }
        .box {
            background-color: white;
            width: 300px; /* تم زيادة العرض هنا */
            margin: 20px; /* تم زيادة المسافة بين الصناديق */
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            text-align: center;
            transition: transform 0.3s; /* تأثير الحركة عند التمرير */
        }
        .box:hover {
            transform: translateY(-10px); /* يجعل الصندوق يرتفع قليلاً عند التمرير عليه */
        }
        .box img {
            width: 100%;
            height: 250px; /* تم زيادة ارتفاع الصورة */
            object-fit: cover;
        }
        .box .content {
            padding: 20px;
        }
        .box h3 {
            margin: 10px 0;
            font-size: 22px; /* تم زيادة حجم الخط */
            color: #333;
        }
        .box p {
            color: #555;
            font-size: 16px; /* تم زيادة حجم الخط */
        }
        /* تنسيق زر الرجوع */
        .back-button {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            margin-top: 20px;
        }
        .back-button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="box">
            <img src="{{asset('layout/upload/1000032765.jpg')}}" alt="شخص 1">
            <div class="content">
                <h3>محمد رمضان محمد</h3>
                <p>محمد هو مطور باك إند ذو خبرة في بناء الأنظمة وقواعد البيانات. يعمل على تطوير التطبيقات والخدمات خلف الكواليس لتوفير أداء ممتاز وسريع.</p>
            </div>
        </div>

        <div class="box">
            <img src="image2.jpg" alt="شخص 2">
            <div class="content">
                <h3>اسم الشخص 2</h3>
                <p>شخص 2 هو مطور فرونت إند متخصص في تصميم واجهات المستخدم وتجربة المستخدم. يعمل على جعل التطبيقات والمواقع أكثر جمالًا وسهولة في الاستخدام.</p>
            </div>
        </div>

        <div class="box">
            <img src="image3.jpg" alt="شخص 3">
            <div class="content">
                <h3>اسم الشخص 3</h3>
                <p>شخص 3 هو أيضًا مطور فرونت إند، متخصص في إنشاء تصاميم تفاعلية وسهلة الاستخدام باستخدام تقنيات حديثة مثل HTML, CSS, JavaScript، وما إلى ذلك.</p>
            </div>
        </div>
    </div>

    <!-- زر الرجوع أسفل الصفحة -->
    <a class="back-button" onclick="window.history.back()">رجوع</a>

</body>
</html>
