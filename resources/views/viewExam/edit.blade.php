@extends('layouts.home')
@section('title', 'اضافة امتحان')
@section('css')
<link rel="stylesheet" href="{{ asset('Exam/add.css') }}" />
<style>
    .search-results {
        margin-top: 5px;
        padding: 0;
        list-style-type: none;
        border: 1px solid #ddd;
        border-top: none;
        max-height: 200px;
        overflow-y: auto;
        background-color: #fff;
        position: absolute;
        width: 100%;
        z-index: 1000;
    }

    .search-results div {
        padding: 8px;
        cursor: pointer;
        font-size: 14px;
        background-color: #f9f9f9;
        border-bottom: 1px solid #eee;
    }

    .search-results div:hover {
        background-color: #e3e3e3;
    }

    .form-group {
        position: relative;
        margin-bottom: 20px;
    }

    #subject-name, #professor-name {
        padding: 10px;
        width: 100%;
        border: 1px solid #ccc;
        font-size: 14px;
    }

</style>
@endsection
@section('js')
<script src="{{ asset('Exam/add.js') }}"></script>
<script>
     $(document).ready(function() {
        
        $(".modal-effect").click(function(event) {
            event.preventDefault(); 
            // فتح الـ Modal
            var modalId = $(this).attr("href");  // استلام الـ ID الخاص بالـ Modal
            var modal = new bootstrap.Modal(document.querySelector(modalId));
            modal.show();
        });
    });
    $(document).ready(function() {
    $('#subject-name').on('keyup', function() {
        let query = $(this).val();

        if (query.length > 1) {  
            $.ajax({
                url: '{{ route('search.subjects') }}',
                method: 'GET',
                data: { query: query },
                success: function(data) {
                    $('#subject-results').html(data).show();
                }
            });
        } else {
            $('#subject-results').html('').hide();
        }
    });

    $('#professor-name').on('keyup', function() {
        let query = $(this).val();

        if (query.length > 1) {  
            $.ajax({
                url: '{{ route('search.coordinators') }}',
                method: 'GET',
                data: { query: query },
                success: function(data) {
                    $('#professor-results').html(data).show();
                }
            });
        } else {
            $('#professor-results').html('').hide();
        }
    });
    $(document).on('click', '.subject-item', function() {
        let code = $(this).data('code'); 
        let name = $(this).data('name'); 
        $('#subject-name').val(name); 
        $('#subject-code').val(code); 
        $('#subject-results').html('').hide(); 
    });
    $(document).on('click', '.professor-item', function() {
    let name = $(this).data('name');  
    let phone = $(this).data('phone');  
    $('#professor-name').val(name);  
    $('#professor-code').val(phone); 
    $('#professor-results').html('').hide();  
});

});
</script>
@endsection
@section('content')
 <!--=============== MAIN ===============-->
 <main class="main containers" id="main">
  <div class="cards">
    <a class="modal-effect btn btn-custom w-50" href="#modaldemo8">اضافة اختبار عن طريق اكيسيل</a>
     <!-- Basic modal -->
     <div class="modal fade" id="modaldemo8" tabindex="-1" aria-labelledby="modaldemo8Label" aria-hidden="true" >
        <div class="modal-dialog" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title" id="modaldemo8Label">إضافة امتحانات من ملف اكيسيل</h6>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                  <form action="{{route('addexcel.store')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="excel_file" class="form-label">رفع ملف Excel</label>
                        <input type="file" class="form-control" id="excel_file" name="excel_file" accept=".xlsx, .csv" required>
                    </div>
                    
                </div>
                <div class="modal-footer">
                  <button type="submit" class="btn btn-primary">اضافة</button>
                  <button class="btn ripple btn-secondary" data-bs-dismiss="modal" type="button">إغلاق</button>
                </div>
              </form>
            </div>  
        </div>
    </div>
  
    <!-- End Basic modal -->
    <form id="exam-form" method="POST" action="{{ route('exams.store') }}">
      @csrf
      <h2 class="form-title">إضافة اختبار جديد</h2>
      @if(session('error'))
      <div class="alert alert-danger">
          {{ session('error') }}
      </div>
    @endif
      @if ($errors->any())
      <div class="alert alert-danger">
          <ul>
              @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
              @endforeach
          </ul>
      </div>
  @endif
  @if(session('import_errors'))
    <div class="alert alert-danger">
        <ul>
            @foreach(session('import_errors') as $error)
                <li>{{$error}}</li>
            @endforeach
        </ul>
    </div>
@endif

            <!-- عرض رسالة النجاح إذا كانت موجودة -->
  @if (session('success'))
  <div class="alert alert-success">
      {{ session('success') }}
  </div>
@endif
<div class="form-group">
    <label for="subject-name">اسم المادة</label>
    <input
        type="text"
        id="subject-name"
        name="subject-name"
        placeholder="اسم المادة"
        required
    />
    <input type="hidden" id="subject-code" name="courseCode" />
    <div id="subject-results" class="search-results"></div> <!-- نتائج البحث هنا -->
</div>

<div class="form-group">
    <label for="professor-name">اسم المنسق</label>
    <input
        type="text"
        id="professor-name"
        name="professor-name"
        placeholder="اسم المنسق"
        required
    />
    <input type="hidden" id="professor-code" name="professorCode" />
    <div id="professor-results" class="search-results"></div> 
</div>
  
      <div class="form-group">
          <label for="exam-date">موعد الاختبار</label>
          <input type="date" id="exam-date" name="exam_date" required />
      </div>
  
 
      <div class="button-group">
          <label for="">البرنامج:</label>
          <button type="button" onclick="toggleDepartments('normal')">عادي</button>
          <button type="button" onclick="toggleDepartments('special')">نوعي</button>
      </div>
  
      <div id="normal-departments" class="department-list">
          <h3>البرامج</h3>
          @foreach ($departments as $department)
              @if($department->ProgramType == 'عادي')
                  <label>
                    <input type="checkbox" name="department_id[]" value="{{ $department->id }}"> {{ $department->name }}
                </label>
              @endif
          @endforeach
      </div>
  
      <div id="special-departments" class="department-list">
          <h3>البرامج</h3>
          @foreach ($departments as $department)
              @if($department->ProgramType == 'خاص')
                  <label>
                      <input type="checkbox" name="department_id[]" value="{{ $department->id }}"> {{ $department->name }}
                  </label>
              @endif
          @endforeach
      </div>
  
      <div class="actions">
          <button type="submit" class="action-btn submit-btn">اضاقة</button>
      </div>
  </form>
  </div>
</main>

@endsection