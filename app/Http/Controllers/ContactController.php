<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function send(Request $request)
{
    $data = $request->validate([
        'name' => 'required',
        'email' => 'required|email',
        'message' => 'required',
    ]);

    try {
        Mail::raw("الاسم: {$data['name']}\nالبريد: {$data['email']}\nالرسالة:\n{$data['message']}", function ($msg) use ($data) {
            $msg->to('moh7medramadan2003@gmail.com') // الإيميل اللي تستقبل عليه الرسائل
                ->subject('رسالة جديدة من نموذج التواصل');
        });

        return back()->with('success', 'تم إرسال الرسالة بنجاح!');
    } catch (\Exception $e) {
        return back()->with('error', 'حدث خطأ أثناء إرسال الرسالة: ' . $e->getMessage());
    }
}

}
