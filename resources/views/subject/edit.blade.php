@extends('layouts.home')
@section('title','تعديل بيانات المقرر')
@section('css')
<link rel="stylesheet" href="{{asset('edit/edit.css')}}" />

@section('content')
<!--=============== MAIN ===============-->
<main class="main containers left-pd" id="main">
    <div class="cards">
      <form action="{{route('subject.update' , ['id' => $Subjects->id])}}" method="POST">
        @csrf
        @method('patch')
        <h2 class="form-title">تعديل بيانات المقرر</h2>
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
          <label for="subject-code">كود المقرر</label>
          <input
            type="text"
            id="subject-code"
            name="code"
            value="{{ old('code', $Subjects->code) }}"
            placeholder="كود المقرر"
            required
          />
        </div>

        <div class="form-group">
          <label for="subject-name">اسم المقرر</label>
          <input
            type="text"
            id="subject-name"
            name="subject_name"
            value="{{ old('subject_name', $Subjects->subject_name) }}"
            placeholder="اسم المقرر"
            required
          />
        </div>

        <div class="actions">
          <button type="submit" class="action-btn submit-btn">حفط</button>
        </div>

        <div id="qr-code-container" class="qr-container"></div>
      </form>
    </div>
  
@endsection
