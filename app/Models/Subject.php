<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'code',
        'subject_name',
    ];
    public function coordinatorDepartmentSubjects()
    {
        return $this->hasMany(Exam::class, 'subject_code', 'code');
    }
    public function departments()
    {
        return $this->belongsToMany(Department::class);
    }
}
