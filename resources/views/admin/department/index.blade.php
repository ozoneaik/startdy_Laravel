<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Hello Admin : {{Auth::user()->name}}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    @if(session("success"))
                    <div class="alert alert-success">{{session('success')}}</div>
                    @endif
                    <!-- ตารางแสดงข้อมูล -->
                    <div class="card">
                        <div class="card-header">ตารางข้อมูลแผนก</div>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">Department ID</th>
                                    <th scope="col">Department Name</th>
                                    <th scope="col">UserID</th>
                                    <th scope="col">Created At</th>
                                    <th scope="col">Edit</th>
                                    <th scope="col">Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($departments as $row)
                                <tr>
                                    <th scope="row">{{$row->id}}</th>
                                    <td>{{$row->department_name}}</td>
                                    <td>{{$row->user->name}}</td>
                                    <td>{{Carbon\Carbon::parse($row->created_at)->diffForHumans()}}</td>
                                    <td><a href="{{url('/department/edit/'.$row->id)}}" class="btn btn-secondary">แก้ไข</a></td>
                                    <td><a href="{{url('/department/softdelete/'.$row->id)}}" class="btn btn-warning">ลบข้อมูล</a></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <!-- link เอาหมายเลขหน้ามาแสดง -->
                        {{$departments->links()}}
                    </div>
                    @if(count($trashDepartment)>0)
                    <!-- ตารางลบข้อมูุล -->
                    <div class="card my-2">
                        <div class="card-header">ถังขยะ</div>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">Department ID</th>
                                    <th scope="col">Department Name</th>
                                    <th scope="col">UserID</th>
                                    <th scope="col">Created At</th>
                                    <th scope="col">กู้คืนข้อมูล</th>
                                    <th scope="col">ลบข้อมูลถาวร</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($trashDepartment as $row)
                                <tr>
                                    <th scope="row">{{$row->id}}</th>
                                    <td>{{$row->department_name}}</td>
                                    <td>{{$row->user->name}}</td>
                                    <td>{{Carbon\Carbon::parse($row->created_at)->diffForHumans()}}</td>
                                    <td><a href="{{url('/department/restore/'.$row->id)}}" class="btn btn-primary">กู้</a></td>
                                    <td><a href="{{url('/department/delete/'.$row->id)}}" class="btn btn-danger">ลบถาวร</a></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{$departments->links()}}
                    </div>
                    @endif
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">เพิ่มชื่อแผนก</div>
                        <div class="card-body">
                            <form action="{{route('addDepartment')}}" method="post">
                                @csrf
                                <div class="form-group">
                                    <label for="department_name">ชื่อแผนก</label>
                                    <input type="text" class="form-control" name="department_name">
                                </div>

                                @error('department_name')
                                <div class="text-danger my-2">
                                    <span>{{$message}}</span>
                                </div>

                                @enderror
                                <br>
                                <input type="submit" value="บันทึก" class="btn btn-primary">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>