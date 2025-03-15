@extends('layouts.home')
@section('title','تعديل بيانات الدكتور')
@section('css')
<link rel="stylesheet" href="{{asset('edit/edit.css')}}" />

@section('content')
<!--=============== MAIN ===============-->
<main class="main containers" id="main">
    <div class="cards">
      <form action="{{route('coordinator.update' , ['id' => $Coordinator->id])}}" method="POST">
        @csrf
        @method('patch')
        <h2 class="form-title">تعديل بيانات الدكتور</h2>
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
          <label for="subject-code">اسم الدكتور</label>
          <input
            type="text"
            id="subject-code"
            name="coordinator_name"
            value="{{ old('coordinator_name', $Coordinator->coordinator_name) }}"  
            placeholder="اسم الدكتور"
            required
          />
        </div>

        <div class="form-group">
          <label for="subject-name">رقم الهاتف</label>
          <input
            type="text"
            id="subject-name"
            name="phone_number"
            value="{{ old('phone_number', $Coordinator->phone_number) }}" 
            placeholder="رقم الدكتور"
            required
          />
        </div>

        <div class="actions">
          <button type="submit" class="action-btn submit-btn">حفط</button>
        </div>

        
      </form>
    </div>
  </main>
@endsection