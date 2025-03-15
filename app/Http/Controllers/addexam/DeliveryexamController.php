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

class DeliveryexamController extends Controller
{
    public function index()
    {
        return view('addExam.delivery');
    }
    public function create()
    {
    $departments = Department::get();

    return view('viewExam.edit', compact('departments'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'courseCode' => 'required|exists:subjects,code', 
            'professorCode' => 'required|exists:coordinators,phone_number', 
            'exam_date' => 'required|date|after_or_equal:today', 
            'department_id' => 'required|exists:departments,id', 
        ], [
            'courseCode.required' => 'يرجى إدخال كود المادة.',
            'courseCode.exists' => 'كود المادة المدخل غير موجود في قاعدة البيانات.',
            'professorCode.required' => 'يرجى إدخال رقم هاتف الدكتور.',
            'professorCode.exists' => 'رقم هاتف الدكتور المدخل غير موجود في قاعدة البيانات.',
            'exam_date.required' => 'يرجى إدخال تاريخ الامتحان.',
            'exam_date.date' => 'يرجى إدخال تاريخ صالح للامتحان.',
            'exam_date.after_or_equal' => 'تاريخ الامتحان يجب أن يكون اليوم أو في المستقبل.',
            'department_id.required' => 'يرجى تحديد القسم.',
            'department_id.exists' => 'القسم المدخل غير موجود في قاعدة البيانات.',
        ]);
    
        $subject = Subject::where('code', $request->courseCode)->first(); 
        $coordinator = Coordinator::where('phone_number', $request->professorCode)->first(); 
        $department = Department::where('id', $request->department_id)->first(); 
    
        $existingExam = DB::table('coordinators_departments_subjects')
            ->where('coordinator_id', $coordinator->id)
            ->where('subject_id', $subject->id)
            ->where('department_id', $department->id)
            ->first();
    
        if ($existingExam) {
            
            return back()->with('error', 'هذا الامتحان تم تحديده بالفعل لهذا المنسق والمادة في هذا القسم.');
        }
    
        $exam = new Exam();
        $exam->coordinator_id = $coordinator->id;
        $exam->subject_id = $subject->id;
        $exam->department_id = $department->id;
        $exam->exam_date = $request->exam_date;
        $exam->save();
    
        return back()->with('success', 'تم إضافة الامتحان بنجاح!');
    }
    

    public function delivery(Request $request)
    { 
        
        $validatedData = $request->validate([
            'courseCode' => 'required|string|regex:/^[\pL0-9\s]+$/u|max:255',
            'professorCode' => 'required|string|regex:/^[\pL0-9\s]+$/u|max:255',
        ],[
            'courseCode.required' => 'يرجى إدخال كود المادة.',
            'courseCode.string' => 'كود المادة يجب أن يكون نصاً.',
            'courseCode.regex' => 'كود المادة يجب أن يتكون من أرقام وحروف فقط.',
            'courseCode.max' => 'كود المادة لا يمكن أن يتجاوز 255 حرفاً.',
            
            'professorCode.required' => 'يرجى إدخال رقم المنسق.',
            'professorCode.string' => 'رقم المنسق يجب أن يكون نصاً.',
            'professorCode.regex' => 'رقم المنسق يجب أن يتكون من أرقام وحروف فقط.',
            'professorCode.max' => 'رقم المنسق لا يمكن أن يتجاوز 255 حرفاً.',
        ]);
    
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
                            ->where('status', 1)
                            ->first();
    
        if ($existingRecord) {
            return redirect()->back()->with('error', 'تم تسليم الامتحان مسبقًا');
        }
    
        $updated = DB::table('coordinators_departments_subjects')
                    ->where('subject_id', $subject->id) 
                    ->where('coordinator_id', $coordinator->id)  
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
