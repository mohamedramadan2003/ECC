<?php

namespace App\Http\Controllers\commitees;

use App\Models\Location;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\v1\StoreLocationRequest;

class CommiteeController extends Controller
{
    public function index(){
           $locations = Location::paginate(10);
        return view('Committee.Committee' ,compact('locations'));
    }
    public function store(StoreLocationRequest  $request){
        Location::create($request->validated());
    return redirect()->back()->with('success', 'تمت إضافة المكان بنجاح');
    }
    public function destroy($committee_number)
{
    $commitee = Location::where('committee_number' , $committee_number);
    $commitee->delete();

    return redirect()->back()->with('success', 'تم حذف اللجنة بنجاح');
}

}
