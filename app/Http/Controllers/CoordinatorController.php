<?php

namespace App\Http\Controllers;

use App\Models\Coordinator;
use Illuminate\Http\Request;
use App\Http\Requests\v1\CoordinatorRequest;

class CoordinatorController extends Controller
{
    public function index(Request $request)
{
    $query = Coordinator::query();

    if ($request->has('search') && $request->search != '') {
        $query->where('coordinator_name', 'like', '%' . $request->search . '%');
    }

    $Coordinators = $query->paginate(8);

    return view('Coordinator.add', ['Coordinators' => $Coordinators]);
}
    public function store(CoordinatorRequest $request)
    {
        Coordinator::create([
            'coordinator_name' => $request->coordinator_name,
            'phone_number' => $request->phone_number,
        ]);

        return redirect()->back()->with('success', 'تم إضافة الدكتور بنجاح!');
    }

public function edit($id)
{
    $Coordinator = Coordinator::findOrFail($id);
    return view('coordinator.edit', compact('Coordinator'));
}
 public function update(CoordinatorRequest $request, $id)
{
    $Coordinator = Coordinator::findOrFail($id);

    $data = [];

    if ($request->filled('coordinator_name')) {
        $data['coordinator_name'] = $request->coordinator_name;
    }

    if ($request->filled('phone_number')) {
        $data['phone_number'] = $request->phone_number;
    }

    $Coordinator->update($data);

    return redirect()->route('addcoordinator.index')->with('success', 'تم تحديث الدكتور بنجاح!');
}
public function destroy($id)
{
    $user = Coordinator::findOrFail($id);

        $user->delete();
        return redirect()->back()->with('success', 'تم مسح الدكتور بنجاح');
}

}
