@extends('layouts.home')
@section('title','تسليم امتحان')
@section('css')
<link rel="stylesheet" href="{{asset('addexam/add.css')}}" />
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
    a{
        text-decoration: none;
    }
    .number-input {
  width: 100%;
  max-width: 200px;
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
  .btn-custom-secondary {
  display: inline-block;
  font-weight: 400;
  color: #fff;
  background-color: #6c757d; /* لون secondary */
  border: 1px solid #6c757d;
  padding: 8px 16px;
  font-size: 16px;
  line-height: 1.5;
  border-radius: 6px;
  cursor: pointer;
  transition: background-color 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
}

.btn-custom-secondary:hover {
  background-color: #5c636a;
  border-color: #5c636a;
}

.btn-custom-secondary:focus {
  outline: none;
  box-shadow: 0 0 0 0.25rem rgba(108, 117, 125, 0.5);
}
.mt-2 {
  margin-top: 0.5rem;
  margin-bottom: 10px;
}
@media screen and (max-width: 576px) {
  .mains {
    padding: 1rem;
    padding-right: 100px !important; /* مراعاة السايدبار */
  }

  .cards {
    width: 100% !important;
    margin: 0 auto !important;
  }

  .submit-btn {
    width: 100%;
    margin-right: 0 !important;
    padding: 15px;
  }

  .form-group input,
  .number-input,
  select,
  .question-select {
 width: fit-content;
max-width: 100%;
  padding: 6px 10px !important;  /* قللنا البادينج */
  font-size: 15px !important;
  border-radius: 6px;
  box-sizing: border-box;
}

  .question-select option {
  font-size: 14px !important;
  padding: 5px 8px;
}

  .button-group {
    display: flex;
    flex-direction: column;
    gap: 10px;
    margin-top: 15px;
  }

  .button-group button {
    width: 50%;
    padding: 10px;
    font-size: 14px;
    border-radius: 6px;
  }

  .committee-row {
    flex-direction: column;
    gap: 5px;
  }

  .department-list label {
    font-size: 18px;
  }
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
<main class="mains containers left-pd" id="main">
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
<button type="button" onclick="addCommittee()" class="btn-custom-secondary mt-2">➕ إضافة لجنة</button>
<hr>

<div class="form-group" style="margin-top: 20px;">
    <label for="question_type" style="font-weight: bold;">نوع الأسئلة:</label>
<select name="question_type" class="number-input question-select" required>
        <option value="">-- اختر نوع الأسئلة --</option>
        <option value="0">📄 مقالي</option>
        <option value="1">💻 إلكتروني</option>
    </select>
</div>
<br>
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
            <div class="actions">
                <button type="submit" class="action-btn submit-btn">تسليم</button>
            </div>
        </form>
    </div>
@endsection
