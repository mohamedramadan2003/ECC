<?php
namespace App\Http\Controllers\serch;

use App\Models\Subject;
use App\Models\Coordinator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SearchController extends Controller
{
    
    public function searchSubjects(Request $request)
    {
        $query = $request->input('query');
        $subjects = Subject::where('subject_name', 'LIKE', "%$query%")
                           ->orWhere('code', 'LIKE', "%$query%")
                           ->get();
    
        $output = '';
        foreach ($subjects as $subject) {
            $output .= '<div class="subject-item" data-code="'.$subject->code.'" data-name="'.$subject->subject_name.'">
                            '.$subject->subject_name.' - '.$subject->code.'
                        </div>';
        }
    
        return response()->json($output);
    }
    
    public function searchCoordinators(Request $request)
    {
        $query = $request->input('query');
        $coordinators = Coordinator::where('coordinator_name', 'LIKE', "%$query%")
                                   ->orWhere('phone_number', 'LIKE', "%$query%")
                                   ->get();
    
        $output = '';
        foreach ($coordinators as $coordinator) {
            $output .= '<div class="professor-item" data-phone="'.$coordinator->phone_number.'" data-name="'.$coordinator->coordinator_name.'">
                            '.$coordinator->coordinator_name.' - '.$coordinator->phone_number.'
                        </div>';
        }
    
        return response()->json($output);
    }
}    
