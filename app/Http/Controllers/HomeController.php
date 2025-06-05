<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
   $rawData = DB::table('coordinators_departments_subjects')
    ->where('status', 0)
    ->select('Exam_Date', 'coordinator_id', 'subject_id')
    ->distinct()
    ->get()
    ->groupBy('Exam_Date')
    ->map(function ($group) {
        return $group->unique(function ($item) {
            return $item->coordinator_id . '-' . $item->subject_id;
        })->count();
    });

$dates = $rawData->keys()->toArray();
$counts = $rawData->values()->toArray();



        return view('Home' ,compact('dates', 'counts'));
    }
}
