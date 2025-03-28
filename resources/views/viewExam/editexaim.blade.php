@extends('layouts.home')
@section('title', 'تعديل الامتحان')
@section('css')
<link rel="stylesheet" href="{{ asset('view/view.css') }}" />
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
    a{
        text-decoration: none;
    }
    
.btn {
        padding: 8px 16px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 14px;
        margin: 0 5px;
        border-radius: 10px;
        
    }


.pagination-container {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-top: 20px;
}

.pagination .page-item {
    margin: 0 5px;
}

.pagination .page-link {
    padding: 12px 16px;
    font-size: 16px;
    color: #ffffff;
    background-color: #ccc8ec;
    border: none;
    border-radius: 5px;
    transition: background-color 0.3s ease, transform 0.2s ease;
}

.pagination .page-link:hover {
    background-color: #4a3f9e;
    transform: translateY(-2px);
}

.pagination .page-item.active .page-link {
    background-color: #4131aa;
    border-color: #4a3f9e;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

.pagination .page-item.disabled .page-link {
    background-color: #e0e0e0;
    color: #b0b0b0;
    pointer-events: none;
    cursor: not-allowed;
}
.button-groups {
    display: flex;
    justify-content: center;  
    align-items: center;      
    gap: 20px;                
}

.program-button {
    padding: 15px 50px;        
    font-size: 16px;          
    color: white;             
    background-color: #7379a5; 
    border: none;             
    border-radius: 5px;      
    cursor: pointer;         
    transition: background-color 0.3s ease; 
}

.program-button:hover {
    background-color: #3c2763; 
}
.modal-effect {
       
        margin: 0 auto;
        text-align: center; 
        display: block;
        background-color:rgb(39, 39, 133);
        color: white;   
}
.delivery-status {
        display: flex;
        gap: 15px;
        margin-bottom: 20px;
    }
    
    .status-option {
        position: relative;
        flex: 1;
    }
    
    .status-radio {
        position: absolute;
        opacity: 0;
    }
    
    .status-label {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 15px 10px;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s ease;
        text-align: center;
        border: 2px solid #eee;
        background: #f9f9f9;
    }
    
    .status-label i {
        font-size: 24px;
        margin-bottom: 8px;
    }
    
    /* تنسيق حالة "سلم" */
    .delivered {
        color: #28a745;
    }
    
    .delivered:hover, 
    .status-radio:checked ~ .delivered {
        background: rgba(40, 167, 69, 0.1);
        border-color: #28a745;
    }
    
    
    .not-delivered {
        color: #dc3545;
    }
    
    .not-delivered:hover, 
    .status-radio:checked ~ .not-delivered {
        background: rgba(220, 53, 69, 0.1);
        border-color: #dc3545;
    }
    
  
    .status-radio:focus ~ .status-label {
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }

</style>
@endsection

@section('js')
<script src="{{ asset('view/view.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const groupedExams = @json($groupedExams); // تأكد من أن البيانات تم تمريرها بشكل صحيح
        const cardsContainer = document.querySelector('.cards');
        const paginationContainer = document.querySelector('.pagination-container');

        let currentPage = 1;
        const examsPerPage = 1; // عدد الأيام في كل صفحة (كل يوم امتحان في صفحة)

        
        const totalPages = Math.ceil(Object.keys(groupedExams).length / examsPerPage);

        function renderPagination() {
            paginationContainer.innerHTML = '';

            const paginationUl = document.createElement('ul');
            paginationUl.classList.add('pagination');

            // زر السابق
            const prevButton = document.createElement('li');
            prevButton.classList.add('page-item');
            if (currentPage === 1) prevButton.classList.add('disabled');
            prevButton.innerHTML = `<a class="page-link" href="#" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a>`;
            prevButton.addEventListener('click', () => changePage(currentPage - 1));
            paginationUl.appendChild(prevButton);

            // أزرار الصفحات
            for (let i = 1; i <= totalPages; i++) {
                const pageButton = document.createElement('li');
                pageButton.classList.add('page-item');
                if (i === currentPage) pageButton.classList.add('active');
                pageButton.innerHTML = `<a class="page-link" href="#">${i}</a>`;
                pageButton.addEventListener('click', () => changePage(i));
                paginationUl.appendChild(pageButton);
            }

            // زر التالي
            const nextButton = document.createElement('li');
            nextButton.classList.add('page-item');
            if (currentPage === totalPages) nextButton.classList.add('disabled');
            nextButton.innerHTML = `<a class="page-link" href="#" aria-label="Next"><span aria-hidden="true">&raquo;</span></a>`;
            nextButton.addEventListener('click', () => changePage(currentPage + 1));
            paginationUl.appendChild(nextButton);

            paginationContainer.appendChild(paginationUl);
        }

        // وظيفة لتغيير الصفحة
        function changePage(page) {
            if (page < 1 || page > totalPages) return; // التأكد من عدم الخروج عن حدود الصفحات
            currentPage = page;

            renderExams();

            renderPagination();
        }

        function renderExams() {
            cardsContainer.innerHTML = ''; 
            const user = "{{ Auth::user()->usertype }}";
            const startIndex = (currentPage - 1) * examsPerPage;
            const endIndex = startIndex + examsPerPage;
            const daysOnCurrentPage = Object.keys(groupedExams).slice(startIndex, endIndex);

            daysOnCurrentPage.forEach(function(date) {
                const exams = groupedExams[date];

                const section = document.createElement('section');
                section.classList.add('exam-section');
                
                const examDateDiv = document.createElement('div');
                examDateDiv.classList.add('exam-date');
                examDateDiv.innerHTML = `<h4>اليوم: ${date}</h4>`;
                section.appendChild(examDateDiv);

                const table = document.createElement('table');
                table.classList.add('data-table');

                const tableHead = document.createElement('thead');
                tableHead.innerHTML = `
                    <tr>
                        <th>كود المادة</th>
                        <th>اسم المادة</th>
                        <th>البرنامج</th>
                        <th>اسم الدكتور</th>
                        <th>رقم الدكتور</th>
                        <th>اسم المستلم</th>
                        <th>حالة التسليم</th>
                        <th>الاجراءات</th>

                    </tr>`;
                table.appendChild(tableHead);

                const tableBody = document.createElement('tbody');
                exams.forEach(function(exam) {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${exam.subject.code}</td>
                        <td>${exam.subject.subject_name}</td>
                        <td>${exam.department.name}</td>
                        <td>${exam.coordinator.coordinator_name}</td>
                        <td>${exam.coordinator.phone_number}</td>
                        <td>${exam.name}<br>
                             ${exam.status == 1 ? new Intl.DateTimeFormat('ar-EG', { 
    month: 'long',    
    day: 'numeric',   
    hour: '2-digit',  
    minute: '2-digit',
    hour12: true     
  }).format(new Date(exam.time)) : ''}</td>
                        <td>${exam.status == 1 ? '✔️' : '❌'}</td>
                        
                        <td>
                            
                            @if(Auth::user()->usertype == 'user')
                             <a href="#modaldemo8" class="modal-effect btn btn-edit" 
                             data-co_id="${exam.coordinator_id}" data-su_id="${exam.subject_id}"
                             data-de_id="${exam.department_id}"> تعديل</a> 
                            @endif
                            @if(Auth::user()->usertype == 'admin')
        <form action="{{ route('viewexams.destroy') }}" method="POST"id="deleteForm">
        @csrf
        @method('DELETE')
        <input type="hidden" name="coordinator_id" value="${exam.coordinator_id}">
        <input type="hidden" name="subject_id" value="${exam.subject_id}">
        <input type="hidden" name="department_id" value="${exam.department_id}">
        <button type="submit" class="btn btn-danger delete-btn" onclick="confirmDelete(event)">حذف</button>
    </form>
    @endif
                        </td>
                        `;
                    tableBody.appendChild(row);
                });

                table.appendChild(tableBody);
                section.appendChild(table);
                cardsContainer.appendChild(section);
            });
        }

        renderExams();
        renderPagination();
    });
    function confirmDelete(event) {
        event.preventDefault();  
        
        
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
    $(document).ready(function() {
        
        $(".modal-effect").click(function(event) {
            event.preventDefault();
            // فتح الـ Modal
            var modalId = $(this).attr("href");  
            var modal = new bootstrap.Modal(document.querySelector(modalId));
            modal.show();
            var co_id = $(this).data('co_id');
        var su_id = $(this).data('su_id');
        var de_id = $(this).data('de_id');
        
        $('#modaldemo8').find('input[name="co_id"]').val(co_id);
        $('#modaldemo8').find('input[name="su_id"]').val(su_id);
        $('#modaldemo8').find('input[name="de_id"]').val(de_id);
        });
    });
</script>
@endsection

@section('content')
<main class="main containers" id="main">
    <div class="button-groups">
        <a class="program-button" href="{{route('viewexams.index')}}">عادي</a>
        <a class="program-button" href="{{route('viewexams.create')}}">نوعي</a>
    </div>
    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
    <div class="cards">
          
    </div>
    <!-- Basic modal -->
    <div class="modal fade" id="modaldemo8" tabindex="-1" aria-labelledby="modaldemo8Label" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title" id="modaldemo8Label">تعديل التسليم</h6>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                  <form action="{{route('view.update')}}" method="post">
                    @csrf
                    @method('put')
                    <input type="hidden" name="co_id" id="course_id" value="">
                    <input type="hidden" name="su_id" id="course_id" value="">
                    <input type="hidden" name="de_id" id="course_id" value="">
                    <div class="delivery-status">
                        <div class="status-option">
                            <input type="radio" id="delivered" name="delivery_status" value="1" class="status-radio">
                            <label for="delivered" class="status-label delivered">
                                <i class="fas fa-check-circle"></i>
                                <span>سلم</span>
                            </label>
                        </div>
                        
                        <div class="status-option">
                            <input type="radio" id="not-delivered" name="delivery_status" value="0" class="status-radio">
                            <label for="not-delivered" class="status-label not-delivered">
                                <i class="fas fa-times-circle"></i>
                                <span>لم يسلم</span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                  <button type="submit" class="btn btn-primary">حفظ</button>
                  <button class="btn ripple btn-secondary" data-bs-dismiss="modal" type="button">إغلاق</button>
                </div>
              </form>
            </div>  
        </div>
    </div>
  
    <!-- End Basic modal -->
    <div class="pagination-container">
    </div>
</main>
@endsection