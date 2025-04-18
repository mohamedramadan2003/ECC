<?php

namespace App\Imports;

use Carbon\Carbon;
use App\Models\Exam;
use App\Models\Subject;
use App\Models\Department;
use App\Models\Coordinator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Concerns\ToModel;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ExamImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        static $rowNumber = 1; 
        if (is_numeric($row['a'])) {
            
            $examDate = Carbon::instance(Date::excelToDateTimeObject($row['a']));
        } else {
            
            if (preg_match('/=DATE\((\d{4}),(\d{1,2}),(\d{1,2})\)/', $row['a'], $matches)) {
                
                $examDate = Carbon::createFromFormat('Y-m-d', "{$matches[1]}-{$matches[2]}-{$matches[3]}");
            } else {
                
                try {
                    $examDate = Carbon::parse($row['a']);
                } catch (\Exception $e) {
                    
                    $examDate = null;
                }
            }
        }
    
        
        if (!$examDate || $examDate->lt(today())) {
            return redirect()->back()->with('error', 'لا يمكن إدخال تاريخ قديم للامتحان');
        }
    
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
            Session::push('import_errors',"الصف رقم {$rowNumber}: " . implode(', ', $errors)); 
            $rowNumber++;
            return null; 
        }

        $existingExam = Exam::where('coordinator_id', $coordinator->id)
                            ->where('subject_id', $subject->id)
                            ->where('department_id', $department->id)
                            ->whereDate('exam_date', $examDate)
                            ->first();

        if ($existingExam) {
            Session::push('import_errors', "الصف رقم {$rowNumber}: الامتحان موجود بالفعل للمنسق {$coordinator->phone_number} للمادة {$subject->code} في القسم {$department->name} بتاريخ {$examDate}");
            $rowNumber++;
            return null; 
        }

        try {
            DB::table('coordinators_departments_subjects')->insert([
                'coordinator_id' => $coordinator->id,
                'subject_id' => $subject->id,
                'department_id' => $department->id,
                'exam_date' => $examDate,
            ]);
            $rowNumber++; 
            return null; 
        } catch (\Exception $e) {
            Session::push('import_errors', 'حدث خطأ أثناء إضافة الامتحان.');
            $rowNumber++; 
            return null; 
        }
    }
}
