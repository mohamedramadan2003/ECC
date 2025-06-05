<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'name',
        'ProgramType',
    ];
    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'subject_department', 'department_id', 'subject_code');
    }
}
