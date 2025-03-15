<?php

namespace App\Http\Controllers\Excel;

use App\Models\Exam;
use App\Models\Subject;
use App\Models\Department;
use App\Models\Coordinator;
use App\Imports\ExamsImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class ExcelController extends Controller
{
    public function index()
    {
        return view('viewExam.excel');
    }

    public function import(Request $request)
{
    // التحقق من أن الملف تم تحميله
    $request->validate([
        'excel_file' => 'required|file|mimes:xlsx,xls,csv', 
    ]);

    try {
        // استيراد البيانات من الملف Excel
        $import = new ExamsImport;
        $import->import($request->file('excel_file'));

        // التحقق إذا كان هناك أخطاء أثناء الاستيراد


        // إذا تم الاستيراد بنجاح
        return back()->with('success', 'تم إضافة الاختبارات بنجاح من ملف Excel!');
    } catch (\Exception $e) {
        // في حالة حدوث خطأ
        return back()->with('error', 'حدث خطأ أثناء معالجة الملف: ' . $e->getMessage());
    }
}
}