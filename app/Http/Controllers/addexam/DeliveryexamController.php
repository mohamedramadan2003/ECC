<?php

namespace App\Http\Controllers\addexam;

use App\Models\Exam;
use App\Models\Subject;
use Twilio\Rest\Client;
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
        return view('addExam.delivery' , ['departments'=>$departments]);
    }
    public function create()
    {
    $departments = Department::get();

    return view('viewExam.edit', compact('departments'));
    }
    public function store(StoreExamRequest $request)
    {
        $validated = $request->validated();
        $subject = Subject::where('code', $request->courseCode)->first();
        $coordinator = Coordinator::where('phone_number', $request->professorCode)->first();
        $department = Department::where('id', $request->department_id)->first();


    $existingExams = DB::table('coordinators_departments_subjects')
    ->where('coordinator_id', $coordinator->id)
    ->where('subject_id', $subject->id)
    ->whereIn('department_id', $request->department_id)
    ->pluck('department_id')
    ->toArray();

if (!empty($existingExams)) {
    $existingDepartmentNames = Department::whereIn('id', $existingExams)
        ->pluck('name')
        ->implode(', ');

    return back()->with('error', "الامتحان موجود بالفعل للأقسام: {$existingDepartmentNames}!");
}


$examData = array_map(function($deptId) use ($coordinator, $subject, $request) {
    return [
        'coordinator_id' => $coordinator->id,
        'subject_id' => $subject->id,
        'department_id' => $deptId,
        'exam_date' => $request->exam_date,
    ];
}, $request->department_id);

DB::table('coordinators_departments_subjects')->insert($examData);

return back()->with('success', 'تم إضافة الامتحان بنجاح لجميع الأقسام المحددة!');
}

    public function delivery(DeliveryRequest $request)
    {
        $validated = $request->validated();
        $courseCode = $request->input('courseCode');
        $professorCode = $request->input('professorCode');

        $subject = Subject::where('code', $courseCode)->first();
        $coordinator = Coordinator::where('phone_number', $professorCode)->first();

        if (!$subject || !$coordinator) {
            return redirect()->back()->with('error', 'لم يتم العثور على المادة أو المنسق');
        }


        $existingRecord = DB::table('coordinators_departments_subjects')
                            ->where('subject_id', $subject->id)
                            ->where('coordinator_id', $coordinator->id)
                            ->whereIn('department_id',$request->department_id)
                            ->where('status', 1)
                            ->exists();

        if ($existingRecord || !$request->has('department_id')) {
            return redirect()->back()->with('error', ' تم تسليم الامتحان مسبقًا او البرنامج ليس لديه هذا المادة');
        }

        $updated = DB::table('coordinators_departments_subjects')
                    ->where('subject_id', $subject->id)
                    ->where('coordinator_id', $coordinator->id)
                    ->whereIn('department_id',$request->department_id)
                    ->update(['status' => 1, 'time' => now(), 'name' => Auth::user()->name]);

        if ($updated) {
            $this->sendSmsToProfessor($professorCode);

            return redirect()->back()->with('success', 'تم تسليم الامتحان بنجاح');
        }

        return redirect()->back()->with('error', 'لم يتم العثور على السجل المطلوب');
    }



   private function sendSmsToProfessor($professorCode)
{

        $sid = env('TWILIO_SID');
        $authToken = env('TWILIO_AUTH_TOKEN');
        $twilioNumber = env('TWILIO_PHONE_NUMBER');
        $phoneNumber = '+20' . substr($professorCode, 1);


        $client = new Client($sid, $authToken);

        $message = "The exam for the subject was successfully delivered.";

        try {
            $client->messages->create(
                $phoneNumber,
                [
                    'from' => $twilioNumber,
                    'body' => $message,
                ]
            );
        } catch (\Exception $e) {
            Log::error("Error sending SMS: " . $e->getMessage());
        }
    }

}
