<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Hello {{Auth::user()->name}}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            แก้ไขข้อมูล<br>
                            <label for="">ชื่อแผนกที่ต้องการเปลี่ยน : {{$department->department_name}}</label>
                        </div>
                        <div class="card-body">
                            <form action="{{url('/department/update/'.$department->id)}}" method="post">
                                @csrf
                                <div class="form-group">
                                    <label for="department_name">ชื่อแผนกใหม่</label>
                                    <input type="text" class="form-control" name="department_name">
                                </div>

                                @error('department_name')
                                <div class="text-danger my-2">
                                    <span>{{$message}}</span>
                                </div>

                                @enderror
                                <br>
                                <input type="submit" value="อัพเดท" class="btn btn-primary">
                            </form>
                        </div>
                    </div>
                </div>
                
                    
                
            </div>
        </div>
    </div>
</x-app-layout>