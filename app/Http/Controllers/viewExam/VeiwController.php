<?php

namespace App\Http\Controllers\viewExam;

use App\Models\Exam;
use App\Models\Department;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class VeiwController extends Controller
{
    public function index()
    {
        
        $departments = Department::where('ProgramType', 'عادي')->get();

        $exams = Exam::with(['coordinator', 'subject', 'department'])
            ->whereHas('department', function($query) {
                $query->where('ProgramType', 'عادي');
            })
            ->orderBy('Exam_Date', 'asc')
            ->get();

        $groupedExams = $exams->groupBy(function($exam) {
            return Carbon::parse($exam->Exam_Date)->format('d-m-Y') . ' (' . Carbon::parse($exam->Exam_Date)->locale('ar')->dayName . ')';
        });
        

        return view('viewExam.veiw', [
            'departments' => $departments,
            'groupedExams' => $groupedExams, 
        ]);
    }
    
    public function create()
    {
        $departments = Department::where('ProgramType', 'خاص')->get();

        $exams = Exam::with(['coordinator', 'subject', 'department'])
            ->whereHas('department', function($query) {
                $query->where('ProgramType', 'خاص');
            })
            ->orderBy('Exam_Date', 'asc')
            ->get();

        $groupedExams = $exams->groupBy(function($exam) {
            return Carbon::parse($exam->Exam_Date)->format('d-m-Y') . ' (' . Carbon::parse($exam->Exam_Date)->locale('ar')->dayName . ')';
        });

        return view('viewExam.veiw', [
            'departments' => $departments,
            'groupedExams' => $groupedExams,
        ]);
    }
}
