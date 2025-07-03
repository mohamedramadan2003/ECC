<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>تأكيد تسليم الامتحان</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Cairo:wght@400;700&display=swap');

        body {
            margin: 0;
            padding: 0;
            background-color: #f4f6f8;
            font-family: 'Cairo', Tahoma, sans-serif;
            direction: rtl;
        }

        .email-container {
            max-width: 600px;
            margin: auto;
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }

        .email-header {
            background-color: #003366;
            padding: 30px 20px;
            color: #ffffff;
            text-align: center;
        }

        .email-header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 700;
        }

        .email-body {
            padding: 30px 25px;
            color: #333333;
        }

        .email-body h2 {
            font-size: 20px;
            margin-bottom: 20px;
            color: #003366;
        }

        .email-body p {
            font-size: 16px;
            margin: 8px 0;
            line-height: 1.7;
        }

        .label {
            font-weight: bold;
            color: #000;
        }

        .committee-list {
            padding: 0;
            list-style: none;
            font-size: 15px;
        }

        .committee-list li {
            margin-bottom: 6px;
        }

        .email-footer {
            background-color: #eaeaea;
            text-align: center;
            font-size: 14px;
            color: #555;
            padding: 20px 10px;
        }

        @media (max-width: 600px) {
            .email-body, .email-header {
                padding: 20px 15px;
            }

            .email-header h1 {
                font-size: 20px;
            }

            .email-body h2 {
                font-size: 18px;
            }

            .email-body p {
                font-size: 15px;
            }
        }
    </style>
</head>
<body>

<div class="email-container">
    <div class="email-header">
        <h1>تم تسليم الامتحان بنجاح</h1>
    </div>

    <div class="email-body">
        <h2>تفاصيل التسليم:</h2>
        <p><span class="label">كود المادة:</span> {{ $exam->subject->code }}</p>
        <p><span class="label">اسم المادة:</span> {{ $exam->subject->subject_name }}</p>
        <p><span class="label">البرنامج:</span> {{ $exam->department->name }}</p>
        <p><span class="label">تاريخ التسليم:</span> {{ $exam->time }}</p>

        <h2 style="margin-top: 20px;">تفاصيل اللجان:</h2>
        <ul class="committee-list">
            @foreach($committees as $committee)
                <li>لجنة ({{ $committee->committee_number }}) {{ $committee->committee_code }}</li>
            @endforeach
        </ul>

        <p style="margin-top: 15px;">
            نشكركم على التزامكم بتسليم الامتحان في الوقت المحدد
        </p>
    </div>
</body>
</html>
