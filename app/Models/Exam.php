<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    protected $table = 'coordinators_departments_subjects';
    protected $fillable = ['coordinator_id', 'subject_id', 'department_id', 'Exam_Date', 'status'];
    public $timestamps = false;

    

    // تحديد العلاقات
    public function coordinator()
{
    return $this->belongsTo(Coordinator::class, 'coordinator_id', 'id');
}


    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id', 'id'); 
    }
    


    public function department()
{
    return $this->belongsTo(Department::class, 'department_id', 'id');
}
}
