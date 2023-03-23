<?php

use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\AdminController;
use App\Models\Department;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use Illuminate\Support\Facades\DB;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//welcom page
// Route::get('/', function () {
//     return view('welcome');
// });

//เป็นการกำหนดสิทธฺูเข้าถึงหน้าเว็บนั้นๆ
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
    // rout ต่างๆ ที่ถูกกำหนดสิทธิ์การเข้าถึง
])->group(function () {
    Route::get('/dashboard', function () {
        // อีโลเคว่น
        // $user = User::all();

        //คิวลี่
        $user = DB::table('users')->get();
        return view('dashboard', compact('user'));
    })->name('dashboard');


    Route::get('/department/all', [DepartmentController::class, 'index'])->name('department');
    Route::post('/dapartment/add', [DepartmentController::class, 'store'])->name('addDepartment');
    Route::get('/department/edit/{id}',[DepartmentController::class,'edit']);
    Route::post('/department/update/{id}',[DepartmentController::class,'update']);
    Route::get('/department/softdelete/{id}',[DepartmentController::class,'softdelete']);
    Route::get('/department/restore/{id}',[DepartmentController::class,'restore']);
    Route::get('/department/delete/{id}',[DepartmentController::class,'delete']);
    
    //Services
    Route::get('/service/all',[ServicesController::class,'index'])->name('services');
    Route::post('/service/add',[ServicesController::class,'store'])->name('addservice');
    Route::get('/service/edit/{id}',[ServicesController::class,'edit']);
    Route::get('/service/delete/{id}',[ServicesController::class,'delete']);
    Route::post('/service/update/{id}',[ServicesController::class,'update']);

    Route::get('/adminlte',[AdminController::class,'index'])->name('adminlte');
    Route::get('/',[AdminController::class,'index'])->name('adminlte');


});