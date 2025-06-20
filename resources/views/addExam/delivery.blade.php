@extends('layouts.home')
@section('title','تسليم امتحان')
@section('css')
<link rel="stylesheet" href="{{asset('addexam/add.css')}}" />
<style>
    .number-input {
  width: 100%;
  max-width: 300px;
  padding: 12px 15px;
  font-size: 16px;
  border: 2px solid #ccc;
  border-radius: 10px;
  transition: 0.3s ease;
  box-shadow: inset 0 1px 3px rgba(0,0,0,0.1);
  text-align: left;
  direction: ltr;
  margin-bottom: 20px;
}

.number-input:focus {
  border-color: #007bff;
  outline: none;
  box-shadow: 0 0 5px rgba(0,123,255,0.5);
}
    .committee-row {
      display: flex;
      gap: 10px;
      margin-bottom: 10px;
      align-items: center;
      flex-wrap: wrap;
  }

  .committee-row input {
      flex: 1;
  }

  .committee-row button {
      background: #dc3545;
      color: #fff;
      border: none;
      padding: 8px 10px;
      border-radius: 5px;
      cursor: pointer;
      margin-bottom: 20px;
  }

  .committee-row button:hover {
      background: #c82333;
  }
  .committee-row select {
      flex: 1;
      min-width: 150px;
      padding: 8px;
      border-radius: 8px;
      border: 1px solid #ccc;
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
let committeeIndex = 1;

    function addCommittee() {
        const wrapper = document.getElementById('committees-wrapper');

        const div = document.createElement('div');
        div.classList.add('committee-row');
        div.innerHTML = `
        <input type="number" name="committees[${committeeIndex}][numbers]" placeholder="رقم اللجنة" class="number-input" min="0" required>
            <button type="button" onclick="removeCommittee(this)">❌ حذف</button>
        `;
        wrapper.appendChild(div);
        committeeIndex++;
    }

    function removeCommittee(button) {
        button.parentElement.remove();
    }

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
                @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
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
            <h4>اللجان:</h4>
<div id="committees-wrapper">
    <div class="committee-row">
        <input type="number" name="committees[0][numbers]" placeholder="رقم اللجنة" class="number-input" min="0" required>
        <button type="button" onclick="removeCommittee(this)">❌ حذف</button>
    </div>
</div>
<button type="button" onclick="addCommittee()" class="btn btn-secondary mt-2">➕ إضافة لجنة</button>
<hr>
             <div class="button-group">
            <label for="">البرنامج:</label>
            <button type="button" id="btn-normal" onclick="toggleDepartments('normal', this)">عادي</button>
            <button type="button" id="btn-special" onclick="toggleDepartments('special', this)">نوعي</button>
        </div>

            <div id="normal-departments" class="department-list">
                <h3>البرامج</h3>
                @foreach ($departments as $department)
                    @if($department->ProgramType == 'عادي')
                        <label>
                            <input type="radio" name="department_id" value="{{ $department->id }}"> {{ $department->name }}
                        </label>
                    @endif
                @endforeach
            </div>

            <div id="special-departments" class="department-list">
                <h3>البرامج</h3>
                @foreach ($departments as $department)
                    @if($department->ProgramType == 'خاص')
                        <label>
                            <input type="radio" name="department_id" value="{{ $department->id }}"> {{ $department->name }}
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
