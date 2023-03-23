<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Hello Admin : {{ Auth::user()->name }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    <!-- ตารางแสดงข้อมูล -->
                    <div class="card">
                        <div class="card-header">ตารางข้อมูลบริการ</div>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">ภาพประกอบ</th>
                                    <th scope="col">ชื่อบริการ</th>
                                    <th scope="col">Created At</th>
                                    <th scope="col">Edit</th>
                                    <th scope="col">Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($services as $row)
                                    <tr>
                                        <th scope="row">{{ $row->id }}</th>
                                        <td>
                                            {{-- asset คือ การแสดงไฟล์นั้นๆออกมาในเว็บ --}}
                                            <img src="{{asset($row->service_image)}}" alt="" width="70px">
                                        </td>
                                        <td>{{ $row->service_name }}</td>
                                        <td>{{ Carbon\Carbon::parse($row->created_at)->diffForHumans() }}</td>
                                        <td><a href="{{ url('/service/edit/' . $row->id) }}"
                                                class="btn btn-secondary">แก้ไข</a></td>
                                        <td><a href="{{ url('/service/delete/' . $row->id) }}"
                                                class="btn btn-warning">ลบข้อมูล</a></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <!-- link เอาหมายเลขหน้ามาแสดง -->
                        {{ $services->links() }}
                    </div>
                </div>
                {{-- ตารางเพิ่มแผนก --}}
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">แบบฟอร์มบริการ</div>
                        <div class="card-body">
                            <form action="{{route('addservice')}}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="service_name">ชื่อบริการ</label>
                                    <input type="text" class="form-control" name="service_name">
                                </div>

                                @error('service_name')
                                    <div class="text-danger my-2">
                                        <span>{{ $message }}</span>
                                    </div>
                                @enderror
                                <br>
                                <div class="form-group">
                                    <label for="service_image">ภาพประกอบ</label>
                                    <input type="file" class="form-control" name="service_image">
                                </div>

                                @error('service_image')
                                    <div class="text-danger my-2">
                                        <span>{{ $message }}</span>
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
