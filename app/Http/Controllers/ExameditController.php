<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Exam;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExameditController extends Controller
{
    public function destroy(Request $request)
{
    $Id = $request->input('id');

    $exam = Exam::where('id', $Id)
                ->exists();

    if ($exam) {
        DB::table('coordinators_departments_subjects')
        ->where('id', $Id)
        ->delete();

        return redirect()->back()->with('success', 'تم حذف الامتحان بنجاح');
    }

    return redirect()->back()->with('error','حدث خطا عند الحذف');
}

public function destroyAllExams()
{
    try {
        DB::table('coordinators_departments_subjects')->delete();

        return redirect()->back()->with('success', 'تم حذف جميع الامتحانات بنجاح');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'حدث خطأ أثناء الحذف: ' . $e->getMessage());
    }
}

public function edit()
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
}
