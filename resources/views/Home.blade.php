@extends('layouts.home')
@section('title' , 'الصفحة الرئيسية')
@section('css')
<style>
    .card-title{
      color: rgb(107, 106, 110);
    }
    </style>
    @endsection
@section('content')
 <!--=============== MAIN ===============-->
 <main class="main containers" id="main">
    <div class="card-container">
      <div class="cardz">
        <a href="{{route('viewexams.index')}}">
          <div class="card-icon">👁‍🗨</div>
          <div class="card-title">عرض الامتحانات المسلمة </div>
          <div class="card-subtitle">عرض جدول الامتحانات</div>
          <div class="divider"></div>
        </a>
      </div>
      <div class="cardz">
        <a href="{{route('deliveryexams.index')}}">
          <div class="card-icon">💾</div>
          <div class="card-title">تسليم امتحان</div>
          <div class="card-subtitle">تعديل تفاصيل اختبار</div>
          <div class="divider"></div>
        </a>
      </div>
      <div class="cardz">
        <a href="{{route('viewexamsedit.edit')}}">
          <div class="card-icon">📑</div>
          <div class="card-title">تعديل التسليمات</div>
          <div class="card-subtitle">تعديل تسليمات الامتحان</div>
          <div class="divider"></div>
        </a>
      </div>
      @if(Auth::user()->usertype == 'admin')
     
      <div class="cardz">
        <a href="{{route('editdeliveryexams.create')}}">
          <div class="card-icon">💻</div>
          <div class="card-title">اضافة امتحان </div>
          <div class="card-subtitle">إضافة موعد اختبار</div>
          <div class="divider"></div>
        </a>
      </div>
      <div class="cardz">
        <a href="{{route('addsubjects.index')}}">
          <div class="card-icon">📖</div>
          <div class="card-title">اضافة مادة</div>
          <div class="card-subtitle">إضافة مادة جديدة</div>
          <div class="divider"></div>
        </a>
      </div>
      <div class="cardz">
        <a href="{{route('addcoordinator.index')}}">
          <div class="card-icon">👤</div>
          <div class="card-title">اضافة دكتور</div>
          <div class="card-subtitle">إضافة بيانات دكتور</div>
          <div class="divider"></div>
        </a>
      </div> 
      @endif
      @if(Auth::user()->usertype == 'user')
      <br> <br> <br><br> <br>
      @endif
    </div>

    @endsection