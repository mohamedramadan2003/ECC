@extends('layouts.home')
@section('title','تعديل البرنامج')
@section('css')
<link rel="stylesheet" href="{{asset('edit/edit.css')}}" />

@section('content')
<!--=============== MAIN ===============-->
<main class="main containers" id="main">
    <div class="cards">
      <form action="{{route('program.update' , ['id' => $Departments->id])}}" method="POST">
        @csrf
        @method('patch')
        <h2 class="form-title">تعديل بيانات البرنامج</h2>
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
          <label for="subject-code">اسم البرنامج </label>
          <input
            type="text"
            id="subject-code"
            name="name"
            value="{{ old('name', $Departments->name) }}"  
            placeholder="كود المقرر"
            required
          />
        </div>

        <div class="form-group">
          <label for="subject-name">اسم المقرر</label>
          <select
    id="ProgramType"
    name="ProgramType"
    class="form-control"
    required
>
    <option value="عادي" {{ old('ProgramType', $Departments->ProgramType) == 'عادي' ? 'selected' : '' }}>عادي</option>
    <option value="خاص" {{ old('ProgramType', $Departments->ProgramType) == 'خاص' ? 'selected' : '' }}>خاص</option>
</select>

        </div>

        <div class="actions">
          <button type="submit" class="action-btn submit-btn">حفط</button>
        </div>

        <div id="qr-code-container" class="qr-container"></div>
      </form>
    </div>
  </main>
@endsection