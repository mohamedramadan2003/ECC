<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>تواصل معنا</title>
  <link rel="icon" href="{{asset('layout/upload/Screenshot 2025-01-30 172054.png')}}" type="image/x-icon">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
  <style>
    body {
      font-family: 'Cairo', sans-serif;
      background: linear-gradient(135deg, #dbe9f4, #ffffff);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 30px 15px;
    }

    .contact-box {
      backdrop-filter: blur(10px);
      background: rgba(255, 255, 255, 0.7);
      border-radius: 16px;
      box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
      padding: 30px;
      max-width: 460px;
      width: 100%;
      animation: fadeIn 0.5s ease-in-out;
      border: 1px solid rgba(255, 255, 255, 0.3);
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(25px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .contact-box h2 {
      text-align: center;
      color: #a415c0;
      font-weight: bold;
      margin-bottom: 20px;
      font-size: 22px;
    }

    .form-label i {
      color: #a415c0;
      margin-left: 8px;
    }

    .form-control {
      border-radius: 10px;
      background-color: rgba(255, 255, 255, 0.8);
      transition: 0.3s ease;
    }

    .form-control:focus {
      border-color: #a415c0;
      box-shadow: 0 0 0 0.15rem rgba(122, 51, 216, 0.25);
      background-color: #fff;
    }

    .btn-send {
      background: linear-gradient(to right, #a415c0, #8f58d6);
      color: white;
      border: none;
      padding: 10px;
      border-radius: 10px;
      font-weight: bold;
      font-size: 15px;
    }

    .btn-send:hover {
      background: linear-gradient(to right, #7422df, #480758);
    }

    .btn-back {
      background: linear-gradient(to right, #e53935, #c62828);
      color: white;
      border: none;
      padding: 10px;
      border-radius: 10px;
      font-weight: bold;
      font-size: 15px;
    }

    .btn-back:hover {
      background: linear-gradient(to right, #d32f2f, #b71c1c);
    }
  </style>
</head>
<body>
  

  <div class="contact-box">
    @if(session('success'))
  <div class="alert alert-success">
      {{ session('success') }}
  </div>
@endif

@if(session('error'))
  <div class="alert alert-danger">
      {{ session('error') }}
  </div>
@endif
    <h2><i class="fas fa-paper-plane"></i> تواصل معنا</h2>
    <form action="{{route('concat.send')}}" method="POST">
      @csrf
      <div class="mb-3">
        <label for="name" class="form-label"><i class="fas fa-user"></i> الاسم</label>
        <input type="text" class="form-control" id="name" placeholder="اسمك الكامل" required>
      </div>

      <div class="mb-3">
        <label for="email" class="form-label"><i class="fas fa-envelope"></i> البريد الإلكتروني</label>
        <input type="email" class="form-control" id="email" placeholder="example@email.com" required>
      </div>

      <div class="mb-3">
        <label for="message" class="form-label"><i class="fas fa-comment-dots"></i> الرسالة</label>
        <textarea class="form-control" id="message" rows="4" placeholder="اكتب رسالتك هنا..." required></textarea>
      </div>

      <div class="d-grid gap-2 mt-3">
        <button type="submit" class="btn btn-send">✉️ إرسال</button>
        <a href="{{route('home.index')}}" type="button" class="btn btn-back" onclick="history.back()">🔙 رجوع</a>
      </div>
    </form>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
