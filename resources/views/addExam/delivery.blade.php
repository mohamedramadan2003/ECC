@extends('layouts.home')
@section('title','تسليم امتحان')
@section('css')
<link rel="stylesheet" href="{{asset('addexam/add.css')}}" />
@endsection

@section('js')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{asset('Exam/add.js')}}"></script>
<script>
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
            $('#professor-results').html('لا يوجد بيانات ').hide();
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
<main class="mains container" id="main">
    <div class="cards">
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
        <form id="exam-form" method="POST" action="{{ route('deliveryexams.delivery') }}">
            @csrf
            <h2 class="form-title">تسليم امتحان</h2>

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
        <br>
            <div class="actions">
                <button type="submit" class="action-btn submit-btn">تسليم</button>
            </div>
        </form>
    </div>
</main>
<br> <br>
@endsection
