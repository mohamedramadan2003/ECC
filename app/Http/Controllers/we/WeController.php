<?php

namespace App\Http\Controllers\we;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WeController extends Controller
{
    public function index()
    {
        return view('We have.we');
    }
    public function create()
    {
        return view('We have.concat');
    }
}
