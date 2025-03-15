@extends('layouts.home')
@section('title','اضافة مادة')
@section('css')
<link rel="stylesheet" href="{{asset('view/view.css')}}" />
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
    a{
        text-decoration: none;
    }
    /* تنسيقات الأزرار */
    .btn {
        padding: 8px 16px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
        margin: 0 5px;
        border-radius: 10px;
        
    }

    .btn-edit {
        background-color: #16879e; /* الأزرق */
        color: white;
    }

    .btn-edit:hover {
        background-color: #51a6df;
        color: white; /* لون أزرق داكن عند التمرير */
    }

    .btn-delete {
        background-color: #ac2e3a; /* الأحمر */
        color: white;
    }

    .btn-delete:hover {
        background-color: #db2b3c;
        color: white; /* لون أحمر داكن عند التمرير */
    }

    /* تنسيق زر إضافة المادة */
    .btn-add-course {
        background-color: #28a745; /* اللون الأخضر */
        color: white;
        padding: 15px;  /* padding أفقي وعمودي */
        font-size: 18px;
        border: none;
        border-radius: 10px;
        cursor: pointer;
        transition: background-color 0.3s ease;
        margin-top: 20px;
        width: 100%; /* جعل الزر يمتد على كامل عرض الحاوية */
        max-width: 800px; /* الحد الأقصى للعرض */
        display: block;
        text-align: center;
        box-sizing: border-box; /* لضمان احتساب padding ضمن الحجم الإجمالي */
    }

    .btn-add-course:hover {
        background-color: #218838; /* أخضر داكن عند التمرير */
    }

    /* تخصيص الزر "إضافة مادة" */
    .modal-effect {
        width: 50%; /* تحديد عرض الزر */
        margin: 0 auto; /* وضع الزر في المنتصف */
        text-align: center; /* محاذاة النص داخل الزر */
        display: block;
        
}
.btn-custom {
    background-color: #633a72;  /* لون فيروزى */
    color: white;
    border-radius: 10px;
}

.btn-custom:hover {
    background-color: #bb49d8; 
    color: white;/* لون فيروزى غامق عند التمرير */
}
/* لتنسيق التصفح */
.pagination-container {
    display: flex;
    justify-content: center;
    margin-top: 20px;
}

/* تخصيص أزرار التصفح في حالة استخدام Bootstrap */
.pagination .page-item .page-link {
    padding: 10px 12px;  /* تعديل الحواف الداخلية */
    font-size: 14px;     /* تغيير حجم الخط */
    color: #463c88;      /* لون النص */
    border: 1px solid #ddd; /* اللون العام للأزرار */
    border-radius: 5px;   /* تدوير الحواف */
}

/* عند التمرير على الأزرار */
.pagination .page-item:hover .page-link {
    background-color: #8850c7;  /* تغيير اللون عند التمرير */
    color: white;               /* النص الأبيض */
}

/* تخصيص الزر النشط */
.pagination .page-item.active .page-link {
    background-color: #593ba0;  /* زر نشط ذو خلفية زرقاء */
    color: white;               /* النص الأبيض */
}

/* تخصيص الزر المعطل */
.pagination .page-item.disabled .page-link {
    background-color: #f8f9fa;  /* خلفية فاتحة عند التعطيل */
    color: #6c757d;             /* لون نص غير نشط */
}


</style>
@endsection
@section('js')
<script src="{{asset('view/view.js')}}"></script>
<!-- إضافة مكتبة jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js" async></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" async></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        // عند النقر على الزر "إضافة مادة" سيتم فتح الـ Modal
        $(".modal-effect").click(function(event) {
            event.preventDefault(); // منع إعادة تحميل الصفحة
            // فتح الـ Modal
            var modalId = $(this).attr("href");  // استلام الـ ID الخاص بالـ Modal
            var modal = new bootstrap.Modal(document.querySelector(modalId));
            modal.show();
        });
    });
    function confirmDelete(event) {
        event.preventDefault();  // منع إرسال النموذج مباشرة
        
        // استخدام SweetAlert2 لإظهار نافذة منبثقة
        Swal.fire({
            title: 'هل أنت متأكد؟',
            text: "لن يمكنك استعادة هذه المقرر!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'نعم، احذف!',
            cancelButtonText: 'إلغاء',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                // إذا اختار المستخدم "نعم"، إرسال النموذج
                document.getElementById('deleteForm').submit();
            }
        });
    }
</script>
@endsection
@section('content')
   <!--=============== MAIN ===============-->
   <main class="mains containers" id="main">

    <div class="cards">
    
      <!-- جدول 1 -->
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
    

              <!-- عرض رسالة النجاح إذا كانت موجودة -->
    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
            <!-- الزر الخاص بإضافة مادة -->
            <a class="modal-effect btn btn-custom w-50" href="#modaldemo8">اضافة مادة</a>
            <table class="data-table">
          <thead>
            <tr>
              <th> كود المادة</th>
              <th>اسم المادة</th>
              <th>إجراءات</th>
            </tr>
          </thead>
          <tbody>
            @if($Subjects->isEmpty())
            <tr><td colspan="3">لا توجد بيانات لعرضها.</td></tr>
        @else
            @foreach ($Subjects as $Subject)
            <tr>
                <td>{{ $Subject->code }}</td>
                <td>{{ $Subject->subject_name }}</td>
                <td>
                        <!-- زر آخر بجانب زر "حذف" -->
                        <a href="{{route('subject.edit', ['id' => $Subject->id])}}" class="btn btn-edit" title="تعديل">تعديل</a>
                        
                        <!-- زر حذف -->
                        <form style="display: inline" action="{{ route('subject.destroy', ['id' => $Subject->id]) }}" method="POST" id="deleteForm">
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
                      <h6 class="modal-title" id="modaldemo8Label">إضافة مقرر</h6>
                      <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                      </button>
                  </div>
                  <div class="modal-body">
                    <form action="{{route('subject.store')}}" method="post">
                      @csrf
                      <div class="mb-3">
                          <label for="username" class="form-label">كود المفرر:</label>
                          <input type="text" class="form-control" id="username" name="code" required>
                      </div>
                      
                      <div class="mb-3">
                          <label for="email" class="form-label">اسم المقرر :</label>
                          <input type="text" class="form-control" id="email" name="subject_name" required>
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
      </section>
       <!-- إضافة روابط التصفح -->
        <div class="pagination-container">
        {{ $Subjects->links('pagination::bootstrap-4') }}
        </div>
    </div>
  </main>

@endsection
