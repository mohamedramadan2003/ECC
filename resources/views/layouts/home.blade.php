<!DOCTYPE html>
<html lang="en" dir="rtl">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" href="{{asset('layout/upload/Screenshot 2025-01-30 172054.png')}}" type="image/x-icon">
    <!--=============== REMIXICONS ===============-->
    <script src="https://kit.fontawesome.com/1f6757b42d.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="{{asset('layout/all.min.css')}}" />
    <!--=============== CSS ===============-->
    <link rel="stylesheet" href="{{asset('layout/style.css')}}" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" async></script>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" async></script>
    @yield('js1')
    <style>
        a{
            text-decoration: none;
        }
        .sidebar__user{
          color: black ;
        }
        .sidebar__user:hover{
          color: rgb(60, 60, 143);
        }
        </style>
    @yield('css')

    <title>@yield('title')</title>
  </head>
  <body>
    <!--=============== HEADER ===============-->
    <header class="header" id="header">
      <div class="header__container">
       
        <ul class="header__nav">
          <li><a href="{{route('home.index')}}"> الرئسية </a></li>
          <li><a href=""> خدمات </a></li>
          <li><a href="{{route('we.index')}}"> عنا </a></li>
          <li><a href="{{route('concat.create')}}"> تواصل </a></li>
        </ul>
        <div class="header__logo">
         <img title="Electron Central Control" src="{{asset('layout/upload/Screenshot 2025-01-30 172054.png')}}" width="60" height="70">
        </div>
      </div>
    </header>

    <!--=============== SIDEBAR ===============-->
    <nav class="sidebar" id="sidebar">
      <div class="sidebar__container">
        <button class="sidebar__toggle" id="header-toggle">
          <i class="fa-solid fa-bars"></i>
        </button>
        <a  href="{{route('profile.edit')}}" class="sidebar__user">
          <div class="sidebar__img">
            <img src="{{asset('layout/upload/perfil.png')}}" alt="image" />
          </div>

          <div class="sidebar__info">
            <h5>{{Auth::user()->name}}</h5>
          </div>
        </a>

        <div class="sidebar__content">
          <div>
            <div class="sidebar__list">
              <a href="{{route('home.index')}}" class="sidebar__link active-link">
                <i class="fa fa-home" aria-hidden="true"></i>
                <span>الرئسية</span>
              </a>

              <a href="{{route('deliveryexams.index')}}" class="sidebar__link">
                <i class="fa-solid fa-table-cells"></i>
                <span>تسليم امتحان</span>
              </a>
              <a href="{{route('viewexams.index')}}" class="sidebar__link">
                <i class="fa-solid fa-eye"></i>
                <span>عرض الامتحانات </span>
              </a>
              <a href="{{route('viewexamsedit.edit')}}" class="sidebar__link">
                <i class="fa-solid fa-square-check"></i>
                <span>تعديل التسليمات</span>
              </a>
              
              @if(Auth::user()->usertype == 'admin')
              <a href="{{route('editdeliveryexams.create')}}" class="sidebar__link">
                <i class="fa-solid fa-pen-to-square"></i>
                <span>اضافة امتحان</span>
              </a>
              <a href="{{route('addsubjects.index')}}" class="sidebar__link">
                <i class="fa-solid fa-square-plus"></i>
                <span>إضافة مادة</span>
              </a>
              <a href="{{route('addcoordinator.index')}}" class="sidebar__link">
                <i class="fa-solid fa-user-md"></i>
                <span>إضافة دكتور</span>
              </a>
              <a href="{{route('user.index')}}" class="sidebar__link">
                <i class="fa-solid fa-user-plus"></i>
                <span>إضافة مستخدم</span>
              </a>
              @endif
            </div>
          </div>
        </div>
        <form action="{{route('logout')}}" method="POST">
          @csrf
        <div class="sidebar__actions">
          <button class="sidebar__link"  type="submit">
            <i class="fa-solid fa-right-from-bracket"></i>
            <span>تسجيل الخروج</span>
          </button>
        </div> 
        </form>
      </div>
    </nav>
@yield('content')

<!-- ============== FOOTER =============== -->
<footer class="footer">
    <p>جميع الحقوق محفوظة ECC ©.</p>
    <ul class="footer__links">
      <li><a href="#">سياسة الخصوصية</a></li>
      <li><a href="#">الشروط والأحكام</a></li>
      <li><a href="{{route('concat.create')}}">التواصل</a></li>
    </ul>
  </footer>
</main>

<!--=============== MAIN JS ===============-->

<script src="{{asset('layout/main.js')}}"></script>
@yield('js')
</body>
</html>
