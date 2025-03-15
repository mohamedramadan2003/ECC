<?php

namespace App\Http\Controllers\program;

use App\Models\Department;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProgramController extends Controller
{
    public function index()
    {
        $Departments = Department::paginate(5);
        return view('program.add' , ['Departments' => $Departments]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|regex:/^[\x{0600}-\x{06FF}\s]+$/u|max:255|unique:Departments,name',
             'ProgramType' => 'required|in:عادي,خاص',
        ],[
          'name.required' => 'الاسم هو حقل مطلوب',
            'name.string' => 'الاسم يجب أن يكون نصًا',
            'name.regex' => 'الاسم يجب أن يحتوي على أحرف عربية فقط',
            'name.max' => 'الاسم يجب أن لا يتجاوز 255 حرفًا',
            'name.unique' => 'الاسم هذا مسجل مسبقًا في النظام',
            
            'ProgramType.required' => 'نوع البرنامج هو حقل مطلوب',
            'ProgramType.in' => 'نوع البرنامج يجب أن يكون إما "عادي" أو "خاص"',
        ]);
        
        $Subject = Department::create([
            'name' => $request->name,
             'ProgramType' => $request->ProgramType,
             
        ]);
    
        return redirect()->back()->with('success', 'تم إضافة البرنامج بنجاح!');
    }
    
    public function edit($id)
    {
        $Departments = Department::findOrFail($id);
        
        return view('program.edit', compact('Departments'));
    }
    public function update(Request $request , $id)
    {
        $Department = Department::findOrFail($id);
        $request->validate([
            'name' => 'required|string|regex:/^[\x{0600}-\x{06FF}\s]+$/u|max:255|unique:Departments,name,' . $Department->id,
    'ProgramType' => 'required|in:عادي,خاص',
            
        ],[
            'name.required' => 'الاسم هو حقل مطلوب',
            'name.string' => 'الاسم يجب أن يكون نصًا',
            'name.regex' => 'الاسم يجب أن يحتوي على أحرف عربية فقط',
            'name.max' => 'الاسم يجب أن لا يتجاوز 255 حرفًا',
            'name.unique' => 'الاسم هذا مسجل مسبقًا في النظام',
            
            'ProgramType.required' => 'نوع البرنامج هو حقل مطلوب',
            'ProgramType.in' => 'نوع البرنامج يجب أن يكون إما "عادي" أو "خاص"',
        ]
    );
    
        $Department->update([
            'name' => $request->name,
             'ProgramType' => $request->ProgramType,
        ]);
    
        return redirect()->route('addprogram.index')->with('success', 'تم تحديث البرنامج بنجاح!');
    }
    public function destroy($id)
    {
        $Department = Department::findOrFail($id); 
        
            $Department->delete(); 
            return redirect()->route('addprogram.index')->with('success', 'تم مسح البرنامج بنجاح');
    }
}
