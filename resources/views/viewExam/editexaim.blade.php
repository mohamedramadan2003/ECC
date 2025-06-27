@extends('layouts.home')
@section('title', 'تعديل الامتحان')
@section('css')
<link rel="stylesheet" href="{{ asset('view/view.css') }}" />
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
    a{
        text-decoration: none;
    }
.modal-effect {
    width: 100%;
        margin: 0 auto;
        text-align: center;
        display: inline;
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
    .program-button.active {
    background-color: #007bff;
    color: white;
}
.btn-danger{
    display: inline;
}
td{
    font-size: 18px;
    font-weight: bold;
}
</style>
@endsection

@section('js')
<script src="{{ asset('view/view.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const groupedExams = @json($groupedExams);
        const cardsContainer = document.querySelector('.cards');
        const paginationContainer = document.querySelector('.pagination-container');
        let today = new Date();
let day = String(today.getDate()).padStart(2, '0');
let month = String(today.getMonth() + 1).padStart(2, '0');
let year = today.getFullYear();
let todayFormatted = `${year}-${month}-${day}`;
        let currentPage = 1;
        const examsPerPage = 1;


        const totalPages = Math.ceil(Object.keys(groupedExams).length / examsPerPage);

        function renderPagination() {
            paginationContainer.innerHTML = '';

            const paginationUl = document.createElement('ul');
            paginationUl.classList.add('pagination');

            const prevButton = document.createElement('li');
            prevButton.classList.add('page-item');
            if (currentPage === 1) prevButton.classList.add('disabled');
            prevButton.innerHTML = `<a class="page-link" href="#" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a>`;
            prevButton.addEventListener('click', () => changePage(currentPage - 1));
            paginationUl.appendChild(prevButton);

            for (let i = 1; i <= totalPages; i++) {
                const pageButton = document.createElement('li');
                pageButton.classList.add('page-item');
                if (i === currentPage) pageButton.classList.add('active');
                pageButton.innerHTML = `<a class="page-link" href="#">${i}</a>`;
                pageButton.addEventListener('click', () => changePage(i));
                paginationUl.appendChild(pageButton);
            }

            const nextButton = document.createElement('li');
            nextButton.classList.add('page-item');
            if (currentPage === totalPages) nextButton.classList.add('disabled');
            nextButton.innerHTML = `<a class="page-link" href="#" aria-label="Next"><span aria-hidden="true">&raquo;</span></a>`;
            nextButton.addEventListener('click', () => changePage(currentPage + 1));
            paginationUl.appendChild(nextButton);

            paginationContainer.appendChild(paginationUl);
        }

        function changePage(page) {
            if (page < 1 || page > totalPages) return;
            currentPage = page;

            renderExams();

            renderPagination();
        }

        function renderExams() {
        cardsContainer.innerHTML = '';
        const userType = "{{ Auth::user()->usertype }}";
        const userName = "{{ Auth::user()->name }}";
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
                    <th>اسم المكان</th>
                    <th>اسم االلجنة</th>
                    <th>العدد</th>
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
                    <td>${exam.coordinator.phone_number} </td>
                     <td>${exam.location.place_name}</td>
                    <td>  اللجنة (${exam.location.committee_number ?? ''})  ${exam.location.committee_code ?? ''} </td>
                    <td>${exam.student_number}</td>
                    <td>${exam.name}<br>
                         ${exam.status == 1 ? new Intl.DateTimeFormat('ar-EG', {
                            month: 'long',
                            day: 'numeric',
                          }).format(new Date(exam.time)) : ''}</td>
                    <td style="font-size: 20px;">${exam.status == 1 ? '✅' : '❌'}</td>
                   <td>
    <div class="d-flex gap-2 align-items-center">
        ${(exam.status === 0 || exam.time >= todayFormatted && userName == exam.name) ? `
            <a href="#modaldemo8" class="modal-effect btn btn-primary btn-sm"
               data-co_id="${exam.id}">تعديل</a>
        ` : `<span class="text-muted">غير قابل للتعديل</span>`}

        @if(Auth::user()->usertype == 'admin')
            <form action="{{ route('viewexams.destroy') }}" method="POST" class="delete-form m-0">
                @csrf
                @method('DELETE')
                <input type="hidden" name="id" value="${exam.id}">
                <button type="submit" class="btn btn-danger btn-sm delete-btn">حذف</button>
            </form>
        @endif
    </div>
</td>

                `;
                tableBody.appendChild(row);
            });

            table.appendChild(tableBody);
            section.appendChild(table);
            cardsContainer.appendChild(section);
        });
    }

    document.addEventListener('click', function(e) {
        if (e.target && e.target.classList.contains('modal-effect')) {
            e.preventDefault();
            var modalId = e.target.getAttribute('href');
            var modal = new bootstrap.Modal(document.querySelector(modalId));
            modal.show();

            var co_id = e.target.dataset.co_id;


            $('#modaldemo8').find('input[name="co_id"]').val(co_id);

        }


        if (e.target && e.target.classList.contains('delete-btn')) {
            e.preventDefault();
            const form = e.target.closest('.delete-form');

            Swal.fire({
                title: 'هل أنت متأكد؟',
                text: "لن يمكنك استعادة هذا الامتحان!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'نعم، احذف!',
                cancelButtonText: 'إلغاء',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        }
    });

    renderExams();
    renderPagination();
});
    $(document).ready(function() {

        $(".modal-effect").click(function(event) {
            event.preventDefault();

            var modalId = $(this).attr("href");
            var modal = new bootstrap.Modal(document.querySelector(modalId));
            modal.show();
            var co_id = $(this).data('co_id');

        $('#modaldemo8').find('input[name="co_id"]').val(co_id);
        });
    });
</script>
@endsection

@section('content')
<main class="main containers" id="main">
   <div class="button-groups">
    <a
      class="program-button {{ Route::currentRouteName() == 'viewexams.index.edit' ? 'active' : '' }}"
      href="{{ route('viewexams.index.edit') }}">
      عادي
    </a>

    <a
      class="program-button {{ Route::currentRouteName() == 'viewexams.create.edit' ? 'active' : '' }}"
      href="{{ route('viewexams.create.edit') }}">
      نوعي
    </a>
    @if(Auth::user()->usertype == 'admin')
    <button class="btn btn-danger btn-lg fs-5" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal">
        حذف جميع الامتحانات
    </button>
@endif

<!-- Modal -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title" id="confirmDeleteModalLabel">تأكيد الحذف</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="إغلاق"></button>
      </div>
      <div class="modal-body">
        هل أنت متأكد أنك تريد حذف جميع الامتحانات؟ هذا الإجراء لا يمكن التراجع عنه.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
        <a href="{{ route('exams.deleteAll') }}" class="btn btn-danger">تأكيد الحذف</a>
      </div>
    </div>
  </div>
</div>


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
          <input type="hidden" name="su_id" id="subject_id" value="">
          <input type="hidden" name="de_id" id="department_id" value="">

         <!-- حالة التسليم -->
<div class="mb-3">
  <label class="form-label">حالة التسليم</label>
  <div class="delivery-status d-flex flex-column gap-2">

    <div class="status-option">
      <input type="radio" id="delivered-electronic" name="delivery_status" value="electronic" class="status-radio" required>
      <label for="delivered-electronic" class="status-label delivered">
        <i class="fas fa-laptop"></i>
        <span>سلم إلكتروني</span>
      </label>
    </div>

    <div class="status-option">
      <input type="radio" id="delivered-written" name="delivery_status" value="written" class="status-radio">
      <label for="delivered-written" class="status-label delivered">
        <i class="fas fa-file-alt"></i>
        <span>سلم مقالي</span>
      </label>
    </div>

    <div class="status-option">
      <input type="radio" id="not-delivered" name="delivery_status" value="not_delivered" class="status-radio">
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
</div>

    <!-- End Basic modal -->
     @if (count($groupedExams) === 0)
    <div class="alert alert-danger text-center fw-bold" role="alert">
        لا يوجد امتحانات الآن
    </div>
@endif
    <div class="pagination-container">
    </div>
</main>
<br><br></br><br></br>
@endsection
