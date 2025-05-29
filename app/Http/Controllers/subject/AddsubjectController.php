<?php

namespace App\Http\Controllers\subject;

use App\Models\Subject;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\v1\StoreSubjectRequest;
use App\Http\Requests\v1\UpdateSubjectRequest;

class AddsubjectController extends Controller
{
    public function index()
    {
        $Subjects = Subject::paginate(8);
        return view('subject.add', ['Subjects'=>$Subjects]);
    }
    public function store(StoreSubjectRequest $request)
    {
        Subject::create($request->validated());

        
        return redirect()->back()->with('success', 'تم إضافة المفرر بنجاح!');
    }

    public function edit($id)
    {
        $Subjects = Subject::findOrFail($id);


        return view('subject.edit', compact('Subjects'));
    }
    public function update(UpdateSubjectRequest  $request , $id)
    {
        $Subject = Subject::findOrFail($id);
       $Subject->update($request->validated());

        return redirect()->route('addsubject.index')->with('success', 'تم تحديث المقرر بنجاح!');
    }
    public function destroy($id)
    {
        $Subject = Subject::findOrFail($id);

            $Subject->delete();
            return redirect()->route('addsubject.index')->with('success', 'تم مسح المفرر بنجاح');
    }

}
