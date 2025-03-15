<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coordinator extends Model
{
    protected $fillable = [
        'coordinator_name',
        'phone_number',
    ];
    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'coordinator_department_subject', 'coordinator_code', 'subject_code')
                    ->withPivot('department_id', 'Exam_Date', 'status');
    }
}
