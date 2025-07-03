<?php

namespace App\Http\Controllers\program;

use App\Models\Department;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\v1\StoreProgramRequest;

class ProgramController extends Controller
{
    public function index()
    {
        $Departments = Department::paginate(10);
        return view('program.add' , ['Departments' => $Departments]);
    }
    public function store(StoreProgramRequest $request)
    {
        $validated = $request->validated();

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
    public function update(StoreProgramRequest $request , $id)
    {
        $Department = Department::findOrFail($id);
        $validated = $request->validated();

        $Department->update([
            'name' => $request->name,
             'ProgramType' => $request->ProgramType,
        ]);

        return redirect()->route('programs.index')->with('success', 'تم تحديث البرنامج بنجاح!');
    }
    public function destroy($id)
    {
        $Department = Department::findOrFail($id);

            $Department->delete();
            return redirect()->back()->with('success', 'تم مسح البرنامج بنجاح');
    }
}
