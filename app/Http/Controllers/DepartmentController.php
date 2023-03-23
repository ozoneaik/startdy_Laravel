<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use PhpParser\Builder\Function_;
use PhpParser\Node\Expr\FuncCall;
use App\Models\Department;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DepartmentController extends Controller
{
    // public function index(){
    //     // ถ้าต้องการแสดงแบบมีหมายเลขหน้า
    //     $departments=Department::paginate(20);
    //     $trashDepartment = Department::onlyTrashed()->paginate(20);
    //     return view('admin.department.index',compact('departments','trashDepartment'));
    // }
    public function index(){
        // ถ้าต้องการแสดงแบบมีหมายเลขหน้า
        $departments=Department::paginate(20);
        $trashDepartment = Department::onlyTrashed()->paginate(20);
        return view('admin.department.index',compact('departments','trashDepartment'));
    }

    public function store(Request $request){
        // ตรวจสอบข้อมูล
        $request->validate([
            'department_name' => 'required|unique:departments|max:255'
        ],
        [
            'department_name.required'=>"กรุณาป้อนชื่อแผนก",
            'department_name.max'=>"คุณป้อนตัวอักษรเยอะเกินไป",
            'department_name.unique' =>"แผนกอยู่ในข้อมูลนี้แล้ว"
        ]);
        //เริ่มต้นบันทึกข้อมูล แบบ อีโลเฟร่น
        $department = new Department;
        $department->department_name = $request->department_name;
        $department->user_id = $request =Auth::user()->id;
        $department->save();

        //เริ่มต้นบันทึกข้อมูล แบบ คิวลี่
        // $data = array();
        // $data["department_name"] = $request->department_name;
        // $data["user_id"] = Auth::user()->id;
        // DB::table('departments')->insert($data);
        return redirect()->back()->with('success','บันทึกข้อมูลเรียบร้อย');
    }

    public function edit($id){
        $department = Department::find($id);
        return view('admin.department.edit',compact('department'));

    }

    public function update(Request $request , $id){
        $request->validate([
            'department_name' => 'required|unique:departments|max:255'
        ],
        [
            'department_name.required'=>"กรุณาป้อนชื่อแผนก",
            'department_name.max'=>"คุณป้อนตัวอักษรเยอะเกินไป",
            'department_name.unique' =>"แผนกอยู่ในข้อมูลนี้แล้ว"
        ]);
        Department::find($id)->update([
            'department_name'=>$request->department_name,
            'user_id'=>Auth::user()->id
        ]);

        return redirect()->route('department')->with('success','อัพเดทข้อมูลเรียบร้อย');
    }

    // softdelete
    public function softdelete($id){
        // อีโลเคว่น
        $delete = Department::find($id)->delete();
        return redirect()->back()->with('success','ลบข้อมูลเรียบร้อย');
    }

    //restore (softdelete only)
    public function restore($id){
        $restore = Department::withTrashed()->find($id)->restore();
        return redirect()->back()->with('success','กู้คืนเรียบร้อย');
    }

    //forcedelete
    public function delete($id){
        $delete = Department::onlyTrashed()->find($id)->forceDelete();
        return redirect()->back()->with('success','ลบข้อมูลถาวรเรียบร้อย');
    }

}