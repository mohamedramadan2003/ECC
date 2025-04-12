@extends('layouts.home')
@section('title','اضافة مادة للبرنامج')
@section('css')
<link rel="stylesheet" href="{{asset('subjectprogram/add.css')}}" />
@endsection
@section('js')
<script src="{{asset('subjectprogram/add.js')}}"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" async></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" async></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection
@section('content')
   <!--=============== MAIN ===============-->
   <main class="main containers" id="main">

    <div class="cards">
    
      <section class="exam-section">
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
            <a class="modal-effect btn btn-custom w-50" href="#modaldemo8">اضافة مادة </a>
            <table class="data-table">
          <thead>
            <tr>
                <th>كود المادة</th>
                <th>اسم المادة</th>
              <th>اسم البرنامج</th>
              <th>المستوي</th>
              <th>الترم</th>
              <th>إجراءات</th>
            </tr>
          </thead>
          <tbody>
            @if($subjects->isEmpty())
            <tr><td colspan="6">لا توجد بيانات لعرضها.</td></tr>
        @else
            @foreach ($subjects as $subject)
            <tr>
                <td>{{ $subject->subject->code }}</td>
                <td>{{ $subject->subject->subject_name }}</td>
                <td>{{ $subject->department->name }}</td>
                <td>{{ $subject->level }}</td>
                <td>{{ $subject->term }}</td>
                <td>
                        <a href="{{route('subjects.edit', ['id' => $subject->id])}}" class="btn btn-edit" title="تعديل">تعديل</a>
                        
                        <form style="display: inline" action="{{ route('subjects.destroy', ['id' => $subject->id]) }}" method="POST" id="deleteForm">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-delete" onclick="confirmDelete(event)">حذف</button>
                        </form>
            
                                   
                </td>
            </tr>
            @endforeach
        @endif
          </tbody>
        </table>

       <!-- Basic modal -->
<div class="modal fade" id="modaldemo8" tabindex="-1" aria-labelledby="modaldemo8Label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title" id="modaldemo8Label">إضافة مادة </h6>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
              <form action="{{ route('addsubjects.store') }}" method="post">
                @csrf
                <div class="mb-3">
                    <label for="course_code" class="form-label">كود المادة :</label>
                    <input type="text" class="form-control" id="course_code" name="course_code" required>
                </div>
                <div class="mb-3">
                    <label for="course_name" class="form-label">اسم المادة :</label>
                    <input type="text" class="form-control" id="course_name" name="course_name" required>
                </div>
                <div class="mb-3">
                    <label for="program_name" class="form-label">اسم البرنامج :</label>
                    <input type="text" class="form-control" id="program_name" name="program_name" required>
                </div>
                
                <div class="mb-3">
                  <label for="ProgramType" class="form-label">نوع البرنامج :</label>
                  <select class="form-control" id="ProgramType" name="ProgramType" required>
                      <option value="عادي">عادي</option>
                      <option value="خاص">نوعي</option>
                  </select>
                </div>
                
                <div class="mb-3">
                    <label for="level" class="form-label">المستوى :</label>
                    <select class="form-control" id="level" name="level" required>
                        <option value="الاول">الاول</option>
                        <option value="الثاني">الثاني</option>
                        <option value="الثالث">الثالث</option>
                        <option value="الرابع">الرابع</option>
                    </select>
                </div>
                
                <div class="mb-3">
                    <label for="term" class="form-label">الفصل الدراسي :</label>
                    <select class="form-control" id="term" name="term" required>
                        <option value="الاول">الاول</option>
                        <option value="الثاني">الثاني</option>
                    </select>
                </div>
                
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-primary">إضافة</button>
              <button class="btn ripple btn-secondary" data-bs-dismiss="modal" type="button">إغلاق</button>
            </div>
          </form>
        </div>  
    </div>
  </div>
  <!-- End Basic modal -->
  
      </section>
      <!-- إضافة روابط التصفح -->
      <div class="pagination-container">
        {{ $subjects->links('pagination::bootstrap-4') }}
        </div>
    </div>
  </main>
  @if($subjects->isEmpty())
  <br><br><br><br><br>
  @endif
@endsection
