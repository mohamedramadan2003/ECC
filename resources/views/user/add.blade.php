@extends('layouts.home')
@section('title','اضافة مستخدم')
@section('css')
<link rel="stylesheet" href="{{asset('view/view.css')}}" />
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
    a{
        text-decoration: none;
    }
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
        background-color: #16879e; 
        color: white;
    }

    .btn-edit:hover {
        background-color: #51a6df;
        color: white; 
    }

    .btn-delete {
        background-color: #ac2e3a; 
        color: white;
    }

    .btn-delete:hover {
        background-color: #db2b3c;
        color: white; 
    }

    .btn-add-course {
        background-color: #28a745;
        color: white;
        padding: 15px;  
        font-size: 18px;
        border: none;
        border-radius: 10px;
        cursor: pointer;
        transition: background-color 0.3s ease;
        margin-top: 20px;
        width: 100%; 
        max-width: 800px; 
        display: block;
        text-align: center;
        box-sizing: border-box; 
    }

    .btn-add-course:hover {
        background-color: #218838; 
    }

    .modal-effect {
        width: 50%;
        margin: 0 auto; 
        text-align: center; 
        display: block;
        
}
.btn-custom {
    background-color: #633a72; 
    color: white;
    border-radius: 10px;
}

.btn-custom:hover {
    background-color: #bb49d8; 
    color: white;
}

.pagination-container {
    display: flex;
    justify-content: center;
    margin-top: 20px;
}

.pagination .page-item .page-link {
    padding: 10px 12px;
    font-size: 14px; 
    color: #463c88;   
    border: 1px solid #ddd;
    border-radius: 5px;
}

.pagination .page-item:hover .page-link {
    background-color: #8850c7;  
    color: white;           
}

.pagination .page-item.active .page-link {
    background-color: #593ba0;  
    color: white;         
}

.pagination .page-item.disabled .page-link {
    background-color: #f8f9fa; 
    color: #6c757d;   
}


</style>
@endsection
@section('js')
<script src="{{asset('view/view.js')}}"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" async></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" async></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    

    $(document).ready(function() {
        $(".modal-effect").click(function(event) {
            event.preventDefault();
            var modalId = $(this).attr("href"); 
            var modal = new bootstrap.Modal(document.querySelector(modalId));
            modal.show();
        });
    });
    function confirmDelete(event) {
        event.preventDefault();  
        Swal.fire({
            title: 'هل أنت متأكد؟',
            text: "لن يمكنك استعادة هذا المستخدم!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'نعم، احذف!',
            cancelButtonText: 'إلغاء',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
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
    
    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
            <a class="modal-effect btn btn-custom w-50" href="#modaldemo8">اضافة مستخدم</a>
            <table class="data-table">
          <thead>
            <tr>
              <th>الايميل</th>
              <th>اسم المستخدم</th>
              <th>إجراءات</th>
            </tr>
          </thead>
          <tbody>
            @if($users->isEmpty())
            <tr><td colspan="3">لا توجد بيانات لعرضها.</td></tr>
        @else
            @foreach ($users as $user)
            <tr>
                <td>{{ $user->email }}</td>
                <td>{{ $user->name }}</td>
                <td>
                      
                        <a href="{{route('user.edit', ['id' => $user->id])}}" class="btn btn-edit" title="تعديل">تعديل</a>
                        
                        <form style="display: inline" action="{{ route('user.destroy', ['id' => $user->id]) }}" method="POST" id="deleteForm">
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
                        <h6 class="modal-title" id="modaldemo8Label">إضافة مستخدم</h6>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                      <form action="{{route('adduser.store')}}" method="post">
                        @csrf
                        <div class="mb-3">
                            <label for="username" class="form-label">اسم المستخدم:</label>
                            <input type="text" class="form-control" id="username" name="name" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="email" class="form-label">البريد الإلكتروني:</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="password" class="form-label">كلمة السر:</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>  
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">تأكيد كلمة السر:</label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
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
               <div class="pagination-container">
                {{ $users->links('pagination::bootstrap-4') }}
            </div>

    </div>
  </main>

@endsection