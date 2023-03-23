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
                    <div class="card">
                        <div class="card-header">
                            <b>แก้ไขข้อมูล</b> <br>
                            <label for="">บริการที่ต้องการเปลี่ยน : {{ $service->service_name }}</label>
                            <br>                                                            
                        </div>
                        <div class="card-body">
                            <form action="{{url('/service/update/'.$service->id)}}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="service_name">ชื่อบริการใหม่</label>
                                    <input type="text" class="form-control" name="service_name" value="{{ $service->service_name }}">
                                </div>

                                @error('service_name')
                                    <div class="text-danger my-2">
                                        <span>{{ $message }}</span>
                                    </div>
                                @enderror
                                <br>
                                <div>รุปเก่า</div>
                                <div class="form-group">
                                    <img src="{{asset($service->service_image)}}" alt="" width="150px">
                                </div>
                                <br>
                                <div class="form-group">
                                    <label for="service_image">รูปภาพใหม่</label>
                                    <input type="file" class="form-control" name="service_image">
                                </div>

                                @error('service_image')
                                    <div class="text-danger my-2">
                                        <span>{{ $message }}</span>
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
