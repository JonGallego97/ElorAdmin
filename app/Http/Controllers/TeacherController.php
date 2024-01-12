<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Department;
use App\Models\Cycle;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function index()
    {

        return view('teacher.index');
    }
}
