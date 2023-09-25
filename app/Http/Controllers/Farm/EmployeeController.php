<?php

namespace App\Http\Controllers\Farm;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        // $data = User::orderBy('id','DESC')->get();
        return view('admin.employee.index');
    }
}
