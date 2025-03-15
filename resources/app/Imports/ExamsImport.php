<?php

namespace App\Imports;

use Carbon\Carbon;
use App\Models\Exam;
use App\Models\Subject;
use App\Models\Department;
use App\Models\Coordinator;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;

class ExamsImport implements ToModel
{
    use Importable;

    public $errors = [];

    public function model(array $row)
{   
    $examDate = $row[0] ?? null;
    $coordinator = $row[1] ?? null;
    $subjectCode = $row[2] ?? null;
    $departmentName = $row[3] ?? null;

    if (empty($coordinator) || empty($subjectCode) || empty($departmentName)|| empty($examDate)) {
        $this->errors[] = "البيانات غير مكتملة في السطر.";
        return null; 
    }

    $coordinator = Coordinator::where('coordinator_name', $coordinator)->first();
    $subject = Subject::where('code', $subjectCode)->first();
    $department = Department::where('name', $departmentName)->first();

    if (!$subject) {
        $this->errors[] = "المادة {$subjectCode} غير موجودة في  البيانات.";
    }
    if (!$coordinator) {
        $this->errors[] = "المنسق {$coordinator} غير موجود في  البيانات.";
    }
    if (!$department) {
        $this->errors[] = "القسم {$departmentName} غير موجود في  البيانات.";
    }

    if (!$this->errors) {
        return new Exam([
            'subject_id' => $subject->id,
            'coordinator_id' => $coordinator->id,
            'exam_date' => $examDate,  
            'department_id' => $department->id,
        ]);
    }

    return null; 
}
}

