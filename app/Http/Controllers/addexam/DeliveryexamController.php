<?php

namespace App\Http\Controllers\addexam;

use App\Models\Exam;
use App\Models\Subject;
use Twilio\Rest\Client;
use App\Models\Location;
use App\Models\Department;
use App\Models\Coordinator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\v1\DeliveryRequest;
use App\Http\Requests\v1\StoreExamRequest;

class DeliveryexamController extends Controller
{
    public function index()
    {
        $departments = Department::get();

        return view('addExam.delivery' , ['departments'=>$departments ]);
    }
    public function create()
    {
    $departments = Department::get();
    return view('viewExam.add', compact('departments'));
    }
    public function store(StoreExamRequest $request)
    {
        dd($request->exam_date);
        $validated = $request->validated();
        $subject     = Subject::firstWhere('code', $validated['courseCode']);
        $coordinator = Coordinator::firstWhere('phone_number', $validated['professorCode']);
        $department  = Department::find($validated['department_id']);
        $committeeNumbers = collect($validated['committees'])->pluck('numbers')->toArray();
    $existingExams = DB::table('coordinators_departments_subjects')
    ->where('coordinator_id', $coordinator->id)
    ->where('subject_id', $subject->id)
    ->where('department_id', $validated['department_id'])
    ->whereIn('committee_number', $committeeNumbers)
    ->exists();
        if($existingExams)
        {
            return redirect()->back()->with('error','الامتحان موجود بالفعل');
        }
    $data = [];

foreach ($request->committees as $committee) {
    $data[] = [
        'subject_id'       => $subject->id,
        'coordinator_id'   => $coordinator->id,
        'department_id'    => $department->id,
        'exam_date'        => $validated['exam_date'],
        'committee_number'   => $committee['numbers'],
        'student_number'   => $committee['students'],
    ];
}

Exam::insert($data);

return back()->with('success', 'تم إضافة الامتحان بنجاح لجميع اللجان المحددة!');
}

    public function delivery(DeliveryRequest $request)
    {

        $validated = $request->validated();
        $courseCode = $request->input('courseCode');
        $professorCode = $request->input('professorCode');
        $question_type = $request->input('question_type');
        $subject = Subject::where('code', $courseCode)->first();
        $coordinator = Coordinator::where('phone_number', $professorCode)->first();

        if (!$subject || !$coordinator) {
            return redirect()->back()->with('error', 'لم يتم العثور على المادة أو المنسق');
        }


        $existingRecord = DB::table('coordinators_departments_subjects')
                            ->where('subject_id', $subject->id)
                            ->where('coordinator_id', $coordinator->id)
                            ->where('department_id',$request->department_id)
                            ->whereIn('committee_number', collect($request->committees)->pluck('numbers'))
                            ->where('status', 1)
                            ->exists();

        if ($existingRecord || !$request->has('department_id')) {
            return redirect()->back()->with('error', ' تم تسليم الامتحان مسبقًا او البرنامج ليس لديه هذا المادة');
        }

        $updated = DB::table('coordinators_departments_subjects')
                    ->where('subject_id', $subject->id)
                    ->where('coordinator_id', $coordinator->id)
                    ->where('department_id',$request->department_id)
                    ->whereIn('committee_number', collect($request->committees)->pluck('numbers'))
                    ->update(['status' => 1, 'time' => now(), 'name' => Auth::user()->name , 'question_type' => $question_type]);

        if ($updated) {
            return redirect()->back()->with('success', 'تم تسليم الامتحان بنجاح');
        }

        return redirect()->back()->with('error', 'لم يتم العثور على السجل المطلوب');
    }

}
