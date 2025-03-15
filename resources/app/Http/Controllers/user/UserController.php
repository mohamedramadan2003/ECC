<?php

namespace App\Http\Controllers\user;
use Illuminate\Validation\Rules;
use Rules\Password;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::select('id','name', 'email')->where('usertype', 'user')->paginate(6);
        return view('user.add', ['users' => $users]);
    }
    public function store(Request $request)
{
    // التحقق من البيانات
    $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
        'password' => ['required', 'confirmed', Rules\Password::defaults()],
    ],[
        'name.required' => 'اسم المستخدم فارغ',
        'email.unique' => 'الايميل مسجل مسبقا',
        'password.confirmed' => 'كلمة المرور غير متطابفة'
    ]);
    
    // إنشاء المستخدم إذا كانت البيانات صحيحة
    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'email_verified_at' => now(),
    ]);

    // إعادة التوجيه مع رسالة النجاح
    return redirect()->back()->with('success', 'تم إضافة المستخدم بنجاح!');
}

public function edit($id)
{
    $user = User::findOrFail($id);
    
    // إرجاع العرض مع بيانات المستخدم
    return view('user.edit', compact('user'));
}
public function update(Request $request , $id)
{
    // التحقق من البيانات
    $request->validate([
        'name' => ['required', 'string', 'max:80'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $request->id],
    ],[
        'name.required' => 'اسم المستخدم فارغ',
        'email.unique' => 'الايميل موجود بالفعل'
    ]
);

    // البحث عن المستخدم وتحديث البيانات
    $user = User::findOrFail($id);
    $user->update([
        'name' => $request->name,
        'email' => $request->email,
    ]);

    // إعادة التوجيه مع رسالة النجاح
    return redirect()->route('user.index')->with('success', 'تم تحديث المستخدم بنجاح!');
}
public function destroy($id)
{
    $user = User::findOrFail($id); // ابحث عن المستخدم باستخدام find بدلاً من where + get
    
        $user->delete(); 
        return redirect()->route('adduser.index')->with('success', 'تم مسح المستخدم بنجاح');
}

}
