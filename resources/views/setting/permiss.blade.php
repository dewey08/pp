@extends('layouts.admin_setting')
@section('title', 'PK-OFFICE || กำหนดสิทธิ์การใช้งาน')
<script>
    function TypeAdmin() {
        window.location.href = '{{ route('index') }}';
    }
</script>
<script>
    function settingdep_destroy(DEPARTMENT_ID) {
        // alert(bookrep_id);
        Swal.fire({
            title: 'ต้องการลบใช่ไหม?',
            text: "ข้อมูลนี้จะถูกลบไปเลย !!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'ใช่, ลบเดี๋ยวนี้ !',
            cancelButtonText: 'ไม่, ยกเลิก'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: "delete",
                    url: "{{ url('setting_index_destroy') }}" + '/' + DEPARTMENT_ID,
                    success: function(response) {
                        Swal.fire({
                            title: 'ลบข้อมูล!',
                            text: "You Delet data success",
                            icon: 'success',
                            showCancelButton: false,
                            confirmButtonColor: '#06D177',
                            // cancelButtonColor: '#d33',
                            confirmButtonText: 'เรียบร้อย'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $("#sid" + DEPARTMENT_ID).remove();
                                window.location.reload();
                                // window.location = "/book/bookmake_index"; //

                            }
                        })
                    }
                })
            }
        })
    }
</script>
<?php
if (Auth::check()) {
    $type = Auth::user()->type;
    $iduser = Auth::user()->id;
} else {
    echo "<body onload=\"TypeAdmin()\"></body>";
    exit();
}
$url = Request::url();
$pos = strrpos($url, '/') + 1;
?>

@section('content')
    <div class="container-fluid">
        <div class="card input_new" style="background-color: rgb(249, 234, 250)">

            <div class="row p-2">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table id="example" class="table table-sm table-striped table-bordered dt-responsive nowrap myTable" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        {{-- <table class="table table-hover table-bordered table-sm myTable" style="width: 100%;" id="example"> --}}
                            <thead>
                                <tr style="font-size: 14px">
                                    <th width="5%" class="text-center">ลำดับ</th>
                                    <th class="text-center">ชื่อ-นามสกุล</th>
                                    <th width="10%" class="text-center">Manage</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $num = 0;
                                $date = date('Y');
                                ?>
                                @foreach ($users as $item)
                                    <?php $num++; ?>
                                    <tr id="sid{{ $item->id }}">
                                        <td class="text-center">{{ $num }}</td>
                                        <td class="p-2">{{ $item->fname }} {{ $item->lname }}</td>
                                        <td class="text-center" width="10%">
                                            <a href="{{ url('setting/permiss_liss/' . $item->id) }}"
                                                class="text-success me-3" data-bs-toggle="tooltip"
                                                data-bs-placement="bottom" data-bs-custom-class="custom-tooltip"
                                                title="กำหนดสิทธิ์การใช้งาน">
                                                {{-- <i class="fa-solid fa-user-shield"></i> --}}
                                                <img src="{{ asset('images/Admin_new.png') }}" height="25px" width="25px" class="rounded-circle">
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>

            </div>


        </div>
    </div>
@endsection
