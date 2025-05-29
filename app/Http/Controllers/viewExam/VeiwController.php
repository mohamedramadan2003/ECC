<?php

namespace App\Http\Controllers\viewExam;

use Carbon\Carbon;
use App\Models\Exam;
use App\Models\Subject;
use App\Models\Department;
use App\Models\Coordinator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;


class VeiwController extends Controller
{
   public function showExams(Request $request, $programType = 'عادي', $view = 'viewExam.veiw')
    {
        $departments = Department::where('ProgramType', $programType)->get();

        $exams = Exam::with(['coordinator', 'subject', 'department'])
            ->whereHas('department', function($query) use ($programType) {
                $query->where('ProgramType', $programType);
            })
            ->orderBy('Exam_Date', 'asc')
            ->get();

        $groupedExams = $exams->groupBy(function($exam) {
            return Carbon::parse($exam->Exam_Date)
                ->format('d-m-Y') . ' (' . Carbon::parse($exam->Exam_Date)
                ->locale('ar')->dayName . ')';
        });

        return view($view, [
            'departments' => $departments,
            'groupedExams' => $groupedExams,
        ]);
    }
    public function index1()
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


        return view('viewExam.editexaim', [
            'departments' => $departments,
            'groupedExams' => $groupedExams,

        ]);
    }

    public function create1()
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

        return view('viewExam.editexaim', [
            'departments' => $departments,
            'groupedExams' => $groupedExams,
        ]);
    }
    public function update(Request $request)
    {


        $subject = Subject::where('id', $request->input('su_id'))->first();
        $coordinator = Coordinator::where('id', $request->input('co_id'))->first();
        $department = Department::where('id', $request->input('de_id'))->first();
        $status = $request->input('delivery_status');
        if($status == 1)
        {
            $updated = DB::table('coordinators_departments_subjects')
            ->where('subject_id', $subject->id)
            ->where('coordinator_id', $coordinator->id)
            ->where('department_id', $department->id)
            ->update(['status' => 1, 'time' => now(), 'name' => Auth::user()->name]);
        }
        if($status == 0)
        {
            $updated = DB::table('coordinators_departments_subjects')
            ->where('subject_id', $subject->id)
            ->where('coordinator_id', $coordinator->id)
            ->where('department_id', $department->id)
            ->update(['status' => 0, 'time' => null, 'name' => 'لا يوجد بيانات']);
        }
        return redirect()->back()->with('success','تم تحديث التسليم بنجاح');
    }
}
