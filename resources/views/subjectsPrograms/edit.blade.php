@extends('layouts.home')
@section('title','تعديل بيانات المقرر')
@section('css')
<link rel="stylesheet" href="{{asset('edit/edit.css')}}" />
@section('content')
<!--=============== MAIN ===============-->
<main class="main containers" id="main">
    <div class="cards">
      <form action="{{route('subjects.update' , ['id' => $subjects->id])}}" method="POST">
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
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
        <div class="form-group">
          <label for="code">كود المقرر</label>
          <input
            type="text"
            id="code"
            name="course_code"
            value="{{ old('course_code', $subjects->subject->code) }}"  
            placeholder="كود المقرر"
            required
          />
        </div>

        <div class="form-group">
          <label for="subject-name">اسم المقرر</label>
          <input
            type="text"
            id="subject-name"
            name="course_name"
            value="{{ old('course_name', $subjects->subject->subject_name) }}" 
            placeholder="اسم المقرر"
            required
          />
        </div>
        <div class="form-group">
            <label for="program_name">اسم البرنامج</label>
            <input
              type="text"
              id="program_name"
              name="program_name"
              value="{{ old('program_name', $subjects->department->name) }}" 
              placeholder="اسم البرنامج"
              required
            />
          </div>
          <div class="form-group">
            <label for="ProgramType">نوع البرنامج</label>
            <select class="form-control" id="ProgramType" name="ProgramType" required>
              <option value="عادي" {{ old('ProgramType', $subjects->ProgramType) == 'عادي' ? 'selected' : '' }}>عادي</option>
              <option value="خاص" {{ old('ProgramType', $subjects->ProgramType) == 'خاص' ? 'selected' : '' }}>خاص</option>
            </select>
          </div>
  
          <div class="form-group">
            <label for="level">المستوى</label>
            <select class="form-control" id="level" name="level" required>
              <option value="الاول" {{ old('level', $subjects->level) == 'الاول' ? 'selected' : '' }}>الاول</option>
              <option value="الثاني" {{ old('level', $subjects->level) == 'الثاني' ? 'selected' : '' }}>الثاني</option>
              <option value="الثالث" {{ old('level', $subjects->level) == 'الثالث' ? 'selected' : '' }}>الثالث</option>
              <option value="الرابع" {{ old('level', $subjects->level) == 'الرابع' ? 'selected' : '' }}>الرابع</option>
            </select>
          </div>
  
          <div class="form-group">
            <label for="term">الفصل الدراسي</label>
            <select class="form-control" id="term" name="term" required>
              <option value="الاول" {{ old('term', $subjects->term) == 'الاول' ? 'selected' : '' }}>الاول</option>
              <option value="الثاني" {{ old('term', $subjects->term) == 'الثاني' ? 'selected' : '' }}>الثاني</option>
            </select>
          </div>
        <div class="actions">
          <button type="submit" class="action-btn submit-btn">حفط</button>
        </div>
      </form>
    </div>
  </main>
@endsection