@extends('layouts.home')
@section('title', 'عرض التسليم')
@section('css')
<link rel="stylesheet" href="{{ asset('view/view.css') }}" />
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
    a{
        text-decoration: none;
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
    justify-content: center;  /* يضبط الأزرار في منتصف العرض */
    align-items: center;      /* يضبط الأزرار عموديًا في المنتصف */
    gap: 20px;                /* يضيف المسافة بين الأزرار */
}

.program-button {
    padding: 15px 50px;        /* الحواف الداخلية للزر */
    font-size: 16px;           /* حجم الخط */
    color: white;              /* لون النص */
    background-color: #7379a5; /* لون الخلفية */
    border: none;              /* إزالة الحدود */
    border-radius: 5px;        /* تدوير الحواف */
    cursor: pointer;           /* تغيير شكل المؤشر عند التمرير */
    transition: background-color 0.3s ease; /* تأثير تغيير اللون عند التمرير */
}

.program-button:hover {
    background-color: #3c2763;  /* تغيير اللون عند التمرير */
}

</style>
@endsection

@section('js')
<script src="{{ asset('view/view.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const groupedExams = @json($groupedExams); // تأكد من أن البيانات تم تمريرها بشكل صحيح
        const cardsContainer = document.querySelector('.cards');
        const paginationContainer = document.querySelector('.pagination-container');

        let currentPage = 1;
        const examsPerPage = 1; // عدد الأيام في كل صفحة (كل يوم امتحان في صفحة)

        // إجمالي عدد الصفحات
        const totalPages = Math.ceil(Object.keys(groupedExams).length / examsPerPage);

        // وظيفة لعرض التصفح باستخدام Bootstrap
        function renderPagination() {
            paginationContainer.innerHTML = ''; // إعادة تعيين التصفح

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

            // عرض الامتحانات وفقًا للصفحة الحالية
            renderExams();

            // تحديث أزرار التصفح
            renderPagination();
        }

        // وظيفة لعرض الامتحانات بناءً على الصفحة الحالية
        function renderExams() {
            cardsContainer.innerHTML = ''; // إعادة تعيين المحتوى
            
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
                        <td>${exam.status == 1 ? '✔️' : '❌'}</td>`;
                    tableBody.appendChild(row);
                });

                table.appendChild(tableBody);
                section.appendChild(table);
                cardsContainer.appendChild(section);
            });
        }

        // عند تحميل الصفحة، قم بعرض الصفحة الأولى
        renderExams();
        renderPagination();
    });
</script>
@endsection

@section('content')
<main class="main containers" id="main">
    <div class="button-groups">
        <a class="program-button" href="{{route('viewexams.index')}}">عادي</a>
        <a class="program-button" href="{{route('viewexams.create')}}">نوعي</a>
    </div>
    
    <div class="cards">
        <!-- سيتم عرض الامتحانات هنا بواسطة JavaScript -->
    </div>
    <div class="pagination-container">
        <!-- أزرار التصفح ستظهر هنا -->
    </div>
</main>
@endsection