<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubjectDepartment extends Model
{
    protected $table = 'departments_subjects';
    protected $fillable = [
        'department_id','subject_id','level','term'
    ];
    public $timestamps = false ;
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
