<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Location extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['committee_number','place_name','committee_code'];

    
}
