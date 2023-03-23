<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'department_name',
    ];

    //this = ตารางของ department
    //hasOne = เชื่อมความสัมพันธ์แบบ 1ต่อ1
    //hasOne(User::class,'id','user_id'); = ไปเชื่อมกับตาราง User โดย id คือ FK ในตาราง Department เชื่อมไปยัง id คือ PK ในตาราง User
    public function user(){
        return $this->hasOne(User::class,'id','user_id');
    }
}