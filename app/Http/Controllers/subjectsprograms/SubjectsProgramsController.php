<?php

namespace App\Http\Controllers\subjectsPrograms;

use App\Models\Subject;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Models\SubjectDepartment;
use App\Http\Controllers\Controller;
use App\Http\Requests\SebjectProgramRequest;

class SubjectsProgramsController extends Controller
{
    public function index(Request $request)
    {
        
        $departments = Department::all();
    
        
        $departmentId = $request->get('department_id');
    
        if ($departmentId) {
            $subjects = SubjectDepartment::with(['subject', 'department'])
                ->where('department_id', $departmentId)
                ->paginate(8);
        } else {
            $subjects = SubjectDepartment::with(['subject', 'department'])->paginate(8);
        }
    
        return view('subjectsPrograms.add', [
            'subjects' => $subjects,
            'departments' => $departments, 
        ]);
    }

    public function store(SebjectProgramRequest $request)
    {
        $result = $request->validated();
        $subjects = Subject::firstOrCreate(
            ['code' => $result['course_code']],
            ['code'=>$result['course_code'] ,
            'subject_name' => $result['course_name']],
        );
        $programs = Department::firstOrCreate(
            ['name'=>$result['program_name']],
            ['name'=>$result['program_name'],
            'ProgramType'=>$result['ProgramType']]
        );
        $subjectprogram = SubjectDepartment::create(
            [
                'department_id' =>$programs->id,
                'subject_id'=>$subjects->id,
                'level'=>$result['level'],
                'term'=>$result['term'],
            ]
            );
            return redirect()->back()->with('success','تم اضافة المادة للبرنامج بنجاح');
    }
    public function edit($id)
    {
        $subjects = SubjectDepartment::with(['subject', 'department'])->where('id',$id)->first();
        return view('subjectsPrograms.edit',['subjects'=> $subjects]);
    }
    public function update(SebjectProgramRequest $request,$id)
    {
        $result = $request->validated();
        $subjectprogram = SubjectDepartment::findOrFail($id);
        $subjects = Subject::find($subjectprogram->subject_id);
        if($subjects && $subjects->code != $result['course_code'] || $subjects->subject_name != $result['course_name'])
        {
            $subjects->update(
                [
                    'code'=>$result['course_code'],
                    'subject_name'=>$result['course_name'],
                ]
                );
        }
        $programs = Department::find($subjectprogram->department_id);
        if($programs && $programs->name != $result['program_name'] || $programs->ProgramType != $result['ProgramType'])
        {
            $programs->update(
                [
                    'name'=>$result['program_name'],
                    'ProgramType'=>$result['ProgramType'],
                ]
                );
        }
        $subjectprogram->update([
               'department_id' =>$programs->id,
                'subject_id'=>$subjects->id,
                'level'=>$result['level'],
                'term'=>$result['term'],
        ]);
            return redirect()->route('addsubjects.index')->with('success','تم تحديث المادة بنجاح');
    }
    public function destroy($id)
    {
        $subjectprogram = SubjectDepartment::findOrFail($id);
        $subjects = Subject::find($subjectprogram->subject_id);
        if($subjects)
        {
            $subjects->delete();
        }
        $programs = Department::find($subjectprogram->department_id);
        if($programs)
        {
            $programs->delete();
        }
        return redirect()->back()->with('success','تم حذف المادة للبرنامج بنجاح');

    }
}
