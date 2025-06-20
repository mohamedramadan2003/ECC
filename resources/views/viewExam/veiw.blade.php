@extends('layouts.home')
@section('title', 'عرض التسليم')
@section('css')
<link rel="stylesheet" href="{{ asset('view/view.css') }}" />
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
    a{
        text-decoration: none;
    }


.program-button.active {
    background-color: #007bff; /* اللون النشط */
    color: #fff;
    border-color: #007bff;
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
        const examsPerPage = 1;


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

        function changePage(page) {
            if (page < 1 || page > totalPages) return;
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
                        <th>كود المقرر</th>
                        <th>اسم المقرر</th>
                        <th>البرنامج</th>
                        <th>اسم الدكتور</th>
                        <th>رقم الدكتور</th>
                        <th>اسم المكان</th>
                        <th>اسم االلجنة</th>
                        <th>العدد</th>
                        <th>اسم المستلم</th>
                        <th>حالة التسليم</th>
                    </tr>`;
                table.appendChild(tableHead);

                const tableBody = document.createElement('tbody');
                exams.forEach(function(exam) {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${exam.subject.code}</td>
                        <td>${exam.subject.subject_name}</td>
                        <td>${exam.department.name}</td>
                        <td>${exam.coordinator.coordinator_name} </td>
                        <td>${exam.coordinator.phone_number} </td>
                        <td>${exam.location.place_name}</td>
                        <td>  اللجنة (${exam.location.committee_number})  ${exam.location.committee_code} </td>
                        <td>${exam.student_number}</td>
                        <td>${exam.name}<br>
                             ${exam.status == 1 ? new Intl.DateTimeFormat('ar-EG', {
    month: 'long',
    day: 'numeric',
  }).format(new Date(exam.time)) : ''}</td>
                        <td style="font-size: 20px;">${exam.status == 1 ? '✅' : '❌'}</td>`;
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
</script>

@endsection

@section('content')
<main class="main containers" id="main">
   <div class="button-groups">
    <a class="program-button {{ request()->route('programType') == 'عادي' ? 'active' : '' }}"
       href="{{ route('viewexams.show', ['programType' => 'عادي']) }}">
        عادي
    </a>

    <a class="program-button {{ request()->route('programType') == 'خاص' ? 'active' : '' }}"
       href="{{ route('viewexams.show', ['programType' => 'خاص']) }}">
نوعي    </a>
</div>


    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
    <div class="cards">


    </div>
      @if (count($groupedExams) === 0)
    <div class="alert alert-danger text-center fw-bold" role="alert">
        لا يوجد امتحانات الآن
    </div>
@endif

 <div class="pagination-container">
    </div>

</main>

<br/></br><br></br>
@endsection
