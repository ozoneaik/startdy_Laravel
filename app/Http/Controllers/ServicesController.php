<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;
use App\Models\service;
use Carbon\Carbon;

class ServicesController extends Controller
{
    public function index()
    {
        $services = service::paginate(5);
        return view('admin.service.index', compact('services'));
    }

    public function store(Request $request)
    {
        // ตรวจสอบข้อมูล
        $request->validate(
            [
                'service_name' => 'required|unique:services|max:255',
                'service_image' => 'required|mimes:jpg,jpag,png'
            ],
            [
                'service_name.required' => "กรุณาป้อนชื่อบริการ",
                'service_name.max' => "คุณป้อนตัวอักษรเยอะเกินไป",
                'service_name.unique' => "บริการอยู่ในข้อมูลนี้แล้ว",
                'service_image.required' => "กรุณาใส่ภาพประกอบบริการ"
            ]
        );

        //เข้ารหัส
        $service_image = $request->file('service_image');

        //generate ชื่อภาพ
        $name_gen = hexdec(uniqid());

        //ดึงนามสกุล
        $img_ext = strtolower($service_image->getClientOriginalExtension());
        //เอามารวมกัน
        $img_name = $name_gen . '.' . $img_ext;

        // upload
        $upload_location = 'image/services/';
        $full_path = $upload_location . $img_name;
        $service_image->move($upload_location, $img_name);

        //เริ่มต้นบันทึกข้อมูล แบบ อีโลเฟร่น
        //service คือ model ตารางฐานข้อมูลของ services ใน phpMyAdmin
        service::insert([
            'service_name' => $request->service_name,
            'service_image' => $full_path,
            'created_at' => Carbon::now()
        ]);
        return redirect()->back()->with('success', 'บันทึกข้อมูลเรียบร้อย');
    }

    public function edit($id)
    {
        $service = service::find($id);
        return view('admin.service.edit', compact('service'));
    }

    public function update(Request $request, $id)
    {
        $request->validate(
            [
                'service_name' => 'required|max:255'
                // 'service_image' => 'mimes:jpg,jpag,png'
            ],
            [
                'service_name.required' => "กรุณาป้อนชื่อบริการ",
                'service_name.max' => "คุณป้อนตัวอักษรเยอะเกินไป"
            ]
        );
        $service_image = $request->file('service_image');

        //update img only
        if ($service_image) {
            //generate ชื่อภาพ
            $name_gen = hexdec(uniqid());

            //ดึงนามสกุล
            $img_ext = strtolower($service_image->getClientOriginalExtension());
            //เอามารวมกัน
            $img_name = $name_gen . '.' . $img_ext;

            // upload
            $upload_location = 'image/services/';
            $full_path = $upload_location . $img_name;
            
            //update
            service::find($id)->update([
                'service_name' => $request->service_name,
                'service_image' => $full_path,
            ]);

            //delete old img and repleace new img
            $old_image = $request->old_image;
            unlink($old_image);
            $service_image->move($upload_location, $img_name);

            return redirect()->route('services')->with('success', 'อัพเดทข้อมูลเรียบร้อย');
        } else {
            dd("มีการอัพเดทชื่อ");
        }
        
    }
}