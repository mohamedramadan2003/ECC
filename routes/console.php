<?php

use Carbon\Carbon;
use App\Models\Exam;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Inspiring;
use App\Console\Commands\DeleteExams;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();


Schedule::call(function () {
    Exam::whereDate('exam_date', '<=', Carbon::today())->delete();
})->daily()->timezone('Africa/Cairo');


