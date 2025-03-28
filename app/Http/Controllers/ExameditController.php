<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class ExameditController extends Controller
{
    public function destroy(Request $request)
{
    $coordinatorId = $request->input('coordinator_id');
    $subjectId = $request->input('subject_id');
    $departmentId = $request->input('department_id');
    
    $exam = Exam::where('coordinator_id', $coordinatorId)
                ->where('subject_id', $subjectId)
                ->where('department_id', $departmentId)
                ->first();
                
    if ($exam) {
        DB::table('coordinators_departments_subjects')
        ->where('coordinator_id', $coordinatorId)
        ->where('subject_id', $subjectId)
        ->where('department_id', $departmentId)
        ->delete();
    
        return redirect()->back()->with('success', 'تم حذف الامتحان بنجاح');
    }

    return redirect()->back()->with('error','حدث خطا عند الحذف');
}
}
