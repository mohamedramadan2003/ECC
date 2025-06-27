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

        $exams = Exam::with(['coordinator', 'subject', 'department','location'])
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

        $exams = Exam::with(['coordinator', 'subject', 'department','location'])
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

        $exams = Exam::with(['coordinator', 'subject', 'department','location'])
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
    $exam = Exam::where('id', $request->input('co_id'))->first();

    $status = $request->input('delivery_status');

    if (!$exam) {
        return redirect()->back()->with('error', 'لم يتم العثور على الامتحان');
    }

    if ($status == 'electronic') {
        DB::table('coordinators_departments_subjects')
            ->where('id', $exam->id)
            ->update([
                'status' => 1,
                'question_type' => 1,
                'time' => now(),
                'name' => Auth::user()->name
            ]);
    }

    elseif ($status == 'written') {
        DB::table('coordinators_departments_subjects')
            ->where('id', $exam->id)
            ->update([
                'status' => 1,
                'question_type' => 0,
                'time' => now(),
                'name' => Auth::user()->name
            ]);
    }

    elseif ($status == 'not_delivered') {
        DB::table('coordinators_departments_subjects')
            ->where('id', $exam->id)
            ->update([
                'status' => 0,
                'question_type' => null,
                'time' => null,
                'name' => 'لا يوجد بيانات'
            ]);
    }

    return redirect()->back()->with('success', 'تم تحديث التسليم بنجاح');
}

}
