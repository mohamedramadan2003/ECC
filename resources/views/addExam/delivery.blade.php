@extends('layouts.home')
@section('title','تسليم امتحان')
@section('css')
<link rel="stylesheet" href="{{asset('addexam/add.css')}}" />
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

    .actions {
        margin-top: 20px;
        text-align: center;
    }

    .submit-btn {
        padding: 10px 20px;
        background-color: #2d226d;
        color: white;
        border: none;
        cursor: pointer;
        border-radius: 4px;
    }

    .submit-btn:hover {
        background-color: #4f64db;
    }

</style>
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
<main class="mains container" id="main">
    <div class="cards">
        <form id="exam-form" method="POST" action="{{ route('deliveryexams.delivery') }}">
            @csrf
            <h2 class="form-title">تسليم امتحان</h2>
            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

         
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
                <div id="professor-results" class="search-results"></div> <!-- نتائج البحث هنا -->
            </div>

            <div class="actions">
                <button type="submit" class="action-btn submit-btn">تسليم</button>
            </div>
        </form>
    </div>
</main>
<br> <br>
@endsection
