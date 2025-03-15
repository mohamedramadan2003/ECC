<?php

namespace App\Http\Controllers\subject;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use Illuminate\Http\Request;

class AddsubjectController extends Controller
{
    public function index()
    {
        $Subjects = Subject::paginate(8);
        return view('subject.add', ['Subjects'=>$Subjects]);
    }
    public function store(Request $request)
    {
        // التحقق من البيانات
        $request->validate([
            'code' => 'required|string|max:255|unique:subjects,code|regex:/^\S*$/u',
             'subject_name' => 'required|string|max:255',
        ],[
            'code.required' => 'الكود هو حقل مطلوب',
            'code.string' => 'الكود يجب أن يكون نصًا',
            'code.max' => 'الكود يجب أن لا يتجاوز 255 حرفًا',
            'code.unique' => 'الكود هذا مسجل مسبقًا في النظام',
            'code.regex' => 'الكود يجب أن يحتوي فقط على أحرف بدون فراغات',
            'subject_name.required' => 'اسم المادة هو حقل مطلوب',
            'subject_name.string' => 'اسم المادة يجب أن يكون نصًا',
            'subject_name.max' => 'اسم المادة يجب أن لا يتجاوز 255 حرفًا',
        ]);
        
        // إنشاء المستخدم إذا كانت البيانات صحيحة
        $Subject = Subject::create([
            'code' => $request->code,
             'subject_name' => $request->subject_name,
             
        ]);
    
        // إعادة التوجيه مع رسالة النجاح
        return redirect()->back()->with('success', 'تم إضافة المفرر بنجاح!');
    }
    
    public function edit($id)
    {
        $Subjects = Subject::findOrFail($id);
        
        // إرجاع العرض مع بيانات المستخدم
        return view('subject.edit', compact('Subjects'));
    }
    public function update(Request $request , $id)
    {
        $Subject = Subject::findOrFail($id);
        // التحقق من البيانات
        $request->validate([
            'code' => 'required|string|max:255|unique:subjects,code,' . $Subject->id . '|regex:/^\S*$/u',
    'subject_name' => 'required|string|max:255',
            
        ],[
            'code.required' => 'الكود هو حقل مطلوب',
            'code.string' => 'الكود يجب أن يكون نصًا',
            'code.max' => 'الكود يجب أن لا يتجاوز 255 حرفًا',
            'code.unique' => 'الكود هذا مسجل مسبقًا في النظام',
            'code.regex' => 'الكود يجب أن يحتوي فقط على أحرف بدون فراغات',
            'subject_name.required' => 'اسم المادة هو حقل مطلوب',
            'subject_name.string' => 'اسم المادة يجب أن يكون نصًا',
            'subject_name.max' => 'اسم المادة يجب أن لا يتجاوز 255 حرفًا',
        ]
    );
    
        // البحث عن المستخدم وتحديث البيانات
        
        $Subject->update([
            'code' => $request->code,
             'subject_name' => $request->subject_name,
        ]);
    
        // إعادة التوجيه مع رسالة النجاح
        return redirect()->route('addsubject.index')->with('success', 'تم تحديث المقرر بنجاح!');
    }
    public function destroy($id)
    {
        $Subject = Subject::findOrFail($id); 
        
            $Subject->delete(); 
            return redirect()->route('addsubject.index')->with('success', 'تم مسح المفرر بنجاح');
    }
    
}
