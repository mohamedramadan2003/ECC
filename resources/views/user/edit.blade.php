@extends('layouts.home')
@section('title','تعديل مستخدم')
@section('css')
<link rel="stylesheet" href="{{asset('edit/edit.css')}}" />

@section('content')
<!--=============== MAIN ===============-->
<main class="main containers" id="main">
    <div class="cards">
      <form action="{{route('users.update' , ['id' => $user->id])}}" method="POST">
        @csrf
        @method('patch')
        <h2 class="form-title">تعديل بيانات المستخدم</h2>
        @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

        <div class="form-group">
          <label for="subject-code">اسم المستخدم</label>
          <input
            type="text"
            id="subject-code"
            name="name"
            value="{{ old('name', $user->name) }}"
            placeholder="اسم المستخدم"
            required
          />
        </div>

        <div class="form-group">
          <label for="subject-name">الايميل</label>
          <input
            type="text"
            id="subject-name"
            name="username"
            value="{{ old('email', $user->username) }}"
            placeholder="الايميل"
            required
          />
        </div>

        <div class="actions">
          <button type="submit" class="action-btn submit-btn">حفط</button>
        </div>

        <div id="qr-code-container" class="qr-container"></div>
      </form>
    </div>
  </main>
@endsection
