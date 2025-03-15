<?php

namespace App\Http\Controllers\viewExam;

use App\Models\Exam;
use App\Models\Department;
use App\Http\Controllers\Controller;

class VeiwController extends Controller
{
    public function index()
    {
        $departments = Department::where('ProgramType', 'عادي')->get();

    
        // جلب جميع الامتحانات مع العلاقات المرتبطة
        $exams = Exam::with(['coordinator', 'subject', 'department'])
        ->whereHas('department', function($query) {
            $query->where('ProgramType', 'عادي'); // التصفية على الأقسام ذات البرنامج العادي
        })
        ->orderBy('Exam_Date', 'asc')
        ->get(); // جلب جميع البيانات
    
        // تجميع الامتحانات حسب التاريخ بعد جلب جميع البيانات
        $groupedExams = $exams->groupBy(function($exam) {
            return \Carbon\Carbon::parse($exam->Exam_Date)->format('d-m-Y') . ' (' . \Carbon\Carbon::parse($exam->Exam_Date)->locale('ar')->dayName . ')';
        });
    
        // تمرير البيانات إلى الـ view
        return view('viewExam.veiw', [
            'departments' => $departments,
            'groupedExams' => $groupedExams, // الامتحانات المجمعة
        ]);
    }
    
    public function create()
    {
        $departments = Department::where('ProgramType', 'عادي')->get();

    
        // جلب جميع الامتحانات مع العلاقات المرتبطة
        $exams = Exam::with(['coordinator', 'subject', 'department'])
        ->whereHas('department', function($query) {
            $query->where('ProgramType', 'خاص'); // التصفية على الأقسام ذات البرنامج العادي
        })
        ->orderBy('Exam_Date', 'asc')
        ->get(); // جلب جميع البيانات
    
        // تجميع الامتحانات حسب التاريخ بعد جلب جميع البيانات
        $groupedExams = $exams->groupBy(function($exam) {
            return \Carbon\Carbon::parse($exam->Exam_Date)->format('d-m-Y') . ' (' . \Carbon\Carbon::parse($exam->Exam_Date)->locale('ar')->dayName . ')';
        });
    
        // تمرير البيانات إلى الـ view
        return view('viewExam.veiw', [
            'departments' => $departments,
            'groupedExams' => $groupedExams, // الامتحانات المجمعة
        ]);
    }


}
