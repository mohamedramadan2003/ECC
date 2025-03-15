<?php
namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class DeleteExamPastDate extends Command
{
    // اسم الأمر
    protected $signature = 'exam:delete-past';

    // وصف الأمر
    protected $description = 'Delete records from coordinators_departments_subjects where exam date is today or in the past';

    // تنفيذ الأمر
    public function handle()
    {
        $today = Carbon::today();

        DB::table('coordinators_departments_subjects')
            ->whereDate('Exam_Date', '<=', $today)
            ->delete();

        $this->info('Past exam records deleted successfully!');
    }
}
