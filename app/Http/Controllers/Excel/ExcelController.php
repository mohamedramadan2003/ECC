<?php

namespace App\Http\Controllers\Excel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ExamImport;

class ExcelController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|file|mimes:xlsx,csv', 
        ]);

        try {
            Excel::import(new ExamImport, $request->file('excel_file')); 

            $errors = session('import_errors', []);
            if (empty($errors)) {
                return back()->with('success', 'تم إضافة الامتحانات بنجاح!');
            } else {
                return back()->with('error', 'حدثت مشاكل أثناء تحميل البيانات.')
                             ->with('import_errors', $errors);
            }

        } catch (\Exception $e) {
            return back()->with('error', 'حدث خطأ أثناء تحميل البيانات من الملف.'. $e );
        }
    }
}
