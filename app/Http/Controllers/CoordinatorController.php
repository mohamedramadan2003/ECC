<?php

namespace App\Http\Controllers;

use App\Models\Coordinator;
use Illuminate\Http\Request;

class CoordinatorController extends Controller
{
    public function index()
    {
        $Coordinators = Coordinator::paginate(8);
      
        return view('Coordinator.add' , ['Coordinators'=>$Coordinators]);
    }
    public function store(Request $request)
{
    // التحقق من البيانات
    $request->validate([
        'coordinator_name' => 'required|string|regex:/^[\x{0600}-\x{06FF}\s]+$/u|max:150',
         'phone_number' => 'required|string|unique:coordinators,phone_number|regex:/^(01)[0-9]{9}$/|size:11',
    ],[
        'coordinator_name.required' => 'اسم الدكتور مطلوب',
    'coordinator_name.string' => 'اسم الدكتور يجب أن يكون نصًا',
    'coordinator_name.regex' => 'اسم الدكتور يجب أن يحتوي فقط على الحروف العربية أو الفراغات',
    'coordinator_name.max' => 'اسم الدكتور يجب أن لا يتجاوز 150 حرفًا',

    'phone_number.required' => 'رقم الهاتف مطلوب',
    'phone_number.string' => 'رقم الهاتف يجب أن يكون نصًا',
    'phone_number.unique' => 'رقم الهاتف هذا مسجل بالفعل',
    'phone_number.regex' => 'رقم الهاتف يجب أن يبدأ بـ 01 ويكون مكون من 11 رقمًا',
    'phone_number.size' => 'رقم الهاتف يجب أن يتكون من 11 رقمًا',
    ]);
    
    // إنشاء المستخدم إذا كانت البيانات صحيحة
    $user = Coordinator::create([
        'coordinator_name' => $request->coordinator_name,
        'phone_number' => $request->phone_number,
    ]);

    // إعادة التوجيه مع رسالة النجاح
    return redirect()->back()->with('success', 'تم إضافة الدكتور بنجاح!');
}

public function edit($id)
{
    $Coordinator = Coordinator::findOrFail($id);
    
    // إرجاع العرض مع بيانات المستخدم
    return view('coordinator.edit', compact('Coordinator'));
}
public function update(Request $request , $id)
{
    $Coordinator = Coordinator::findOrFail($id);
    // التحقق من البيانات
    $request->validate([
      'coordinator_name' => 'required|string|regex:/^[\x{0600}-\x{06FF}\s]+$/u|max:150',
    'phone_number' => 'required|string|regex:/^(01)[0-9]{9}$/|size:11|unique:coordinators,phone_number,' . $Coordinator->id,
    ],[
        'coordinator_name.required' => 'اسم الدكتور مطلوب',
    'coordinator_name.string' => 'اسم الدكتور يجب أن يكون نصًا',
    'coordinator_name.regex' => 'اسم الدكتور يجب أن يحتوي فقط على الحروف العربية أو الفراغات',
    'coordinator_name.max' => 'اسم الدكتور يجب أن لا يتجاوز 150 حرفًا',

    'phone_number.required' => 'رقم الهاتف مطلوب',
    'phone_number.string' => 'رقم الهاتف يجب أن يكون نصًا',
    'phone_number.unique' => 'رقم الهاتف هذا مسجل بالفعل',
    'phone_number.regex' => 'رقم الهاتف يجب أن يبدأ بـ 01 ويكون مكون من 11 رقمًا',
    'phone_number.size' => 'رقم الهاتف يجب أن يتكون من 11 رقمًا',
    ]
);

    // البحث عن المستخدم وتحديث البيانات
    
    $Coordinator->update([
        'coordinator_name' => $request->coordinator_name,
        'phone_number' => $request->phone_number,
    ]);

    // إعادة التوجيه مع رسالة النجاح
    return redirect()->route('addcoordinator.index')->with('success', 'تم تحديث الدكتور بنجاح!');
}
public function destroy($id)
{
    $user = Coordinator::findOrFail($id); // ابحث عن المستخدم باستخدام find بدلاً من where + get
    
        $user->delete(); 
        return redirect()->back()->with('success', 'تم مسح الدكتور بنجاح');
}

}
