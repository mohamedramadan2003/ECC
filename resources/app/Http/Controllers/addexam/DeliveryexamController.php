<?php

namespace App\Http\Controllers\addexam;

use App\Models\Exam;
use App\Models\Subject;
use App\Models\Department;
use App\Models\Coordinator;
use Illuminate\Http\Request;
use Twilio\Rest\Client;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class DeliveryexamController extends Controller
{
    public function index()
    {
        return view('addExam.delivery');
    }
    public function create()
    {
         // جلب جميع الأقسام
    $departments = Department::get();

    // تمرير البيانات إلى الـ view
    return view('viewExam.edit', compact('departments'));
    }
    public function store(Request $request)
    {
        // التحقق من المدخلات
        $request->validate([
            'subject_code' => 'required|exists:subjects,code', // التأكد أن كود المادة موجود في جدول المواد
            'professor_name' => 'required|exists:coordinators,phone_number', // التأكد أن رقم الدكتور موجود في جدول المنسقين
            'exam_date' => 'required|date|after_or_equal:today', // التأكد من أن تاريخ الامتحان صالح
            'department_id' => 'required|exists:departments,id', // التأكد من أن الـ department_id موجود
        ]);
    
        // الحصول على كود المادة وID المنسق والقسم
        $subject = Subject::where('code', $request->subject_code)->first(); // الحصول على المادة بناءً على الكود
        $coordinator = Coordinator::where('phone_number', $request->professor_name)->first(); // الحصول على المنسق بناءً على الرقم
        $department = Department::where('id', $request->department_id)->first(); // الحصول على القسم بناءً على الـ ID
    
        // التحقق إذا كان السجل موجودًا بالفعل في جدول coordinators_departments_subjects
        $existingExam = DB::table('coordinators_departments_subjects')
            ->where('coordinator_id', $coordinator->id)
            ->where('subject_id', $subject->id)
            ->where('department_id', $department->id)
            ->first();
    
        if ($existingExam) {
            // إذا كان السجل موجودًا، إظهار رسالة خطأ للمستخدم
            return back()->with('error', 'هذا الامتحان تم تحديده بالفعل لهذا المنسق والمادة في هذا القسم.');
        }
    
        // حفظ البيانات في جدول coordinators_departments_subjects
        $exam = new Exam();
        $exam->coordinator_id = $coordinator->id;
        $exam->subject_id = $subject->id;
        $exam->department_id = $department->id;
        $exam->exam_date = $request->exam_date;
        $exam->save();
    
        // العودة مع رسالة النجاح
        return back()->with('success', 'تم إضافة الامتحان بنجاح!');
    }
    

public function delivery(Request $request)
{
    // التحقق من المدخلات
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

    // الحصول على البيانات من النموذج
    $courseCode = $request->input('courseCode');
    $professorCode = $request->input('professorCode');
    $departmentId = $request->input('departmentCode');

    // التأكد من أن المادة والمنسق موجودين في قاعدة البيانات
    $subject = Subject::where('code', $courseCode)->first();
    $coordinator = Coordinator::where('phone_number', $professorCode)->first();

    if (!$subject || !$coordinator) {
        return redirect()->back()->with('error', 'لم يتم العثور على المادة أو المنسق');
    }

    // التحديث في جدول coordinators_departments_subjects
    $updated = DB::table('coordinators_departments_subjects')
                ->where('subject_id', $subject->id) 
                ->where('coordinator_id', $coordinator->id)  
                ->update(['status' => 1]);

    if ($updated) {
        
         $this->sendSmsToProfessor($professorCode);
        
        return redirect()->back()->with('success', 'تم تسليم الامتحان بنجاح');
    }

    return redirect()->back()->with('error', 'لم يتم العثور على السجل المطلوب');
}

  
   private function sendSmsToProfessor($professorCode)
{
    // الحصول على رقم هاتف المنسق باستخدام الـ professorCode
    $professor = DB::table('coordinators')->where('code', $professorCode)->first();
    
    if ($professor) {
        // بيانات Twilio من ملف .env
        $sid = env('TWILIO_SID');
        $authToken = env('TWILIO_AUTH_TOKEN');
        $twilioNumber = env('TWILIO_PHONE_NUMBER');
        $phoneNumber = '+20' . substr($professor->phone_number, 1);

        // إعداد العميل Twilio
        $client = new Client($sid, $authToken);

        // إرسال الرسالة
        $message = "The exam for the subject was successfully delivered.";
        
        try {
            $client->messages->create(
                $phoneNumber, // رقم المنسق
                [
                    'from' => $twilioNumber,  // رقم Twilio الخاص بك
                    'body' => $message,       // النص الذي سيتم إرساله
                ]
            );
        } catch (\Exception $e) {
            Log::error("Error sending SMS: " . $e->getMessage());
        }
    }
      
}



}