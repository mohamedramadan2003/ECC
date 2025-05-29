<?php

namespace App\Http\Controllers\user;
use Rules\Password;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\v1\StoreUserRequest;
use App\Http\Requests\v1\UpdateUserRequest;

class UserController extends Controller
{
    public function index()
    {
        $users = User::select('id','name', 'email')->where('usertype', 'user')->paginate(6);
        return view('user.add', ['users' => $users]);
    }
    public function store(StoreUserRequest $request)
    {
        User::create([
            'name'              => $request->name,
            'email'             => $request->email,
            'password'          => Hash::make($request->password),
            'email_verified_at' => now(),
        ]);

        return redirect()->back()->with('success', 'تم إضافة المستخدم بنجاح!');
    }

public function edit($id)
{
    $user = User::findOrFail($id);

    return view('user.edit', compact('user'));
}
public function update(UpdateUserRequest $request, $id)
    {
        $user = User::findOrFail($id);

        $user->update([
            'name'  => $request->name,
            'email' => $request->email,
        ]);

        return redirect()->route('user.index')->with('success', 'تم تحديث المستخدم بنجاح!');
    }
public function destroy($id)
{
    $user = User::findOrFail($id);

        $user->delete();
        return redirect()->back()->with('success', 'تم مسح المستخدم بنجاح');
}

}
