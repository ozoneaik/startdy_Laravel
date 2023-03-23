<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Department;
use App\models\User;

class AdminController extends Controller
{
    //
    // public function index(){
    //     $departments = Department::all(); // Assuming you have a `Department` model
    //     return view('admin.layouts.admin-dash-layout',compact('departments'));
    // }

    public function index(){
        $user = User::all(); 
        return view('admin.layouts.admin-dash-layout',compact('user'));
    }
}
