<?php

namespace App\Imports;

use App\Models\Exam;
use App\Models\Subject;
use App\Models\Department;
use App\Models\Coordinator;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Session;

class ExamImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        $examDate = \Carbon\Carbon::createFromFormat('d/m/Y', $row['a'])->format('Y-m-d');
   
        $subject = Subject::where('code', $row['b'])->first();
        $coordinator = Coordinator::where('phone_number', $row['c'])->first();
        $department = Department::where('name', $row['d'])->first();

        $errors = [];

        if (!$subject) {
            $errors[] = "المادة بالرمز {$row['b']} غير موجودة.";
        }

        if (!$coordinator) {
            $errors[] = "المنسق بالرقم {$row['c']} غير موجود.";
        }

        if (!$department) {
            $errors[] = "القسم باسم {$row['d']} غير موجود.";
        }

        if (!empty($errors)) {
            Session::push('import_errors', implode(', ', $errors)); 
            return null; 
        }

        $existingExam = Exam::where('coordinator_id', $coordinator->id)
                            ->where('subject_id', $subject->id)
                            ->where('department_id', $department->id)
                            ->whereDate('exam_date', $examDate)
                            ->first();

        if ($existingExam) {
            Session::push('import_errors', "الامتحان موجود بالفعل للمنسق {$coordinator->phone_number} للمادة {$subject->code} في القسم {$department->name} بتاريخ {$examDate}");
            return null; 
        }

        try {
            DB::table('coordinators_departments_subjects')->insert([
                'coordinator_id' => $coordinator->id,
                'subject_id' => $subject->id,
                'department_id' => $department->id,
                'exam_date' => $examDate,
            ]);
            return null; 
        } catch (\Exception $e) {
            Session::push('import_errors', 'حدث خطأ أثناء إضافة الامتحان.');
            return null; 
        }
    }
}
