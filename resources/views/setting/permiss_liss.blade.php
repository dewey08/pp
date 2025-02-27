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

    function switchpermiss_person(person){
        var checkBox=document.getElementById(person);
        var onoff;
                if (checkBox.checked == true){
                    onoff = "ON";
                } else {
                        onoff = "OFF";
                }
                var _token=$('input[name="_token"]').val();
                    $.ajax({
                            url:"{{route('setting.switchpermiss_person')}}",
                            method:"GET",
                            data:{onoff:onoff,person:person,_token:_token}
                    })
    }
    function switchpermiss_book(book){
        var checkBox=document.getElementById(book);
        var onoff;
                if (checkBox.checked == true){
                    onoff = "ON";
                } else {
                        onoff = "OFF";
                }
                var _token=$('input[name="_token"]').val();
                    $.ajax({
                            url:"{{route('setting.switchpermiss_book')}}",
                            method:"GET",
                            data:{onoff:onoff,book:book,_token:_token}
                    })
    }
    function switchpermiss_car(car){
        var checkBox=document.getElementById(car);
        var onoff;
                if (checkBox.checked == true){
                    onoff = "ON";
                } else {
                        onoff = "OFF";
                }
                var _token=$('input[name="_token"]').val();
                    $.ajax({
                            url:"{{route('setting.switchpermiss_car')}}",
                            method:"GET",
                            data:{onoff:onoff,car:car,_token:_token}
                    })
    }
    function switchpermiss_meetting(meetting){
        var checkBox=document.getElementById(meetting);
        var onoff;
                if (checkBox.checked == true){
                    onoff = "ON";
                } else {
                        onoff = "OFF";
                }
                var _token=$('input[name="_token"]').val();
                    $.ajax({
                            url:"{{route('setting.switchpermiss_meetting')}}",
                            method:"GET",
                            data:{onoff:onoff,meetting:meetting,_token:_token}
                    })
    }
    function switchpermiss_repair(repaire){
        var checkBox=document.getElementById(repaire);
        var onoff;
                if (checkBox.checked == true){
                    onoff = "ON";
                } else {
                        onoff = "OFF";
                }
                var _token=$('input[name="_token"]').val();
                    $.ajax({
                            url:"{{route('setting.switchpermiss_repair')}}",
                            method:"GET",
                            data:{onoff:onoff,repaire:repaire,_token:_token}
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

use App\Http\Controllers\StaticController;
use App\Models\Products_request_sub;
// $permiss_upstm = StaticController::permiss_upstm($iduser);
$permiss_account          = StaticController::permiss_account($iduser);
$per_config               = StaticController::per_config($iduser);
$settting_admin           = StaticController::settting_admin($iduser);
// $store_normal             = StaticController::store_normal($iduser);
// $store_vip                = StaticController::store_vip($iduser);
// $store_rep          = StaticController::store_rep($iduser);
?>
@section('menu')
    <style>
        .btn {
            font-size: 15px;
        }
    </style>
    <div class="px-3 py-2 border-bottom">
        <div class="container d-flex flex-wrap justify-content-center">
            <!-- Danger -->
            <div class="btn-group">
                <button type="button" class="btn btn-danger btn-sm dropdown-toggle" data-mdb-toggle="dropdown"
                    aria-expanded="false">
                    ตั้งค่าทั่วไป
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="{{ url('setting/setting_index') }}">กลุ่มงาน</a></li>
                    <li><a class="dropdown-item" href="{{ url('setting/depsub_index') }}">ฝ่าย/แผนก</a></li>
                    <li><a class="dropdown-item" href="{{ url('setting/depsubsub_index') }}">หน่วยงาน</a></li>
                    <li><a class="dropdown-item" href="{{url('setting/orginfo')}}">องค์กร</a></li>
                    <li>
                        <hr class="dropdown-divider" />
                    </li>
                    <li><a class="dropdown-item" href="{{ url('setting/leader') }}">กำหนดสิทธิ์การเห็นชอบ</a></li>
                    <li>
                        <hr class="dropdown-divider" />
                    </li>
                    <li><a class="dropdown-item" href="{{ url('setting/permiss') }}">กำหนดสิทธิ์การใช้งาน</a></li>
                    <li>
                        <hr class="dropdown-divider" />
                    </li>
                    <li><a class="dropdown-item" href="{{ url('setting/line_token') }}">ตั้งค่า Line Token</a></li>
                </ul>
            </div>
            <div class="col-4 col-lg-auto mb-2 mb-lg-0 me-lg-auto"></div>

            <div class="text-end">
                <button type="button" class="btn btn-danger btn-sm">กำหนดสิทธิ์การใช้งาน</button>
            </div>
        </div>
    </div>
@endsection
@section('content')
    {{-- <div class="container"> --}}
        <div class="row">
            <div class="col-md-12">
                <div class="card" style="background-color: rgb(249, 234, 250)">
                    <div class="card-header justify-content-md-center">
                               <h3 class="mt-2" style="color:rgb(103, 5, 160)">{{$dataedits->prefix_name}}{{$dataedits->fname}}  {{$dataedits->lname}}</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="card input_new" style="background-color: rgb(249, 234, 250)">
                                    <div class="table-responsive p-2">
                                        <table id="example" class="table table-striped table-bordered dt-responsive nowrap myTable" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                              <thead>
                                                  <tr height="10px">
                                                      <th width="5%" class="text-center">ลำดับ</th>
                                                      <th class="text-center">ชื่อ-นามสกุล</th>
                                                      <th width="10%" class="text-center">เพิ่มสิทธิ์</th>
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
                                                                <td class="p-2">{{ $item->fname }}  {{ $item->lname }}</td>
                                                                <td class="text-center" width="10%">
                                                                    <a href="{{ url('setting/permiss_liss/' . $item->id) }}"
                                                                        class="text-success me-3" data-bs-toggle="tooltip"
                                                                        data-bs-placement="top" data-bs-custom-class="custom-tooltip"
                                                                        title="เพิ่มสิทธิ์การใช้งาน" >
                                                                        <img src="{{ asset('images/Admin_new.png') }}" height="40px" width="40px" class="rounded-circle">
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                              </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">

                                    <form action="{{ route('setting.permiss_save') }}" id="Insert_permissForm" method="POST">
                                        @csrf
                                        <input type="hidden" id="id" name="id" value="{{$dataedits->id}}">
                                        <input type="hidden" id="iduser" name="iduser" value="{{$iduser}}">
                                        <div class="row me-1 mb-1 ms-1">
                                            <div class="col-4 col-md-3 col-xl-3">
                                                <div class="card">
                                                    <div class="card-body shadow-lg">
                                                        <div class="form-check mt-2">
                                                            <i class="fa-solid fa-user-tie text-primary"></i>

                                                            @if ($dataedits->permiss_person == 'on')
                                                            <input class="form-check-input" type="checkbox" id="permiss_person" name="permiss_person" checked/>
                                                            @else
                                                            <input class="form-check-input" type="checkbox" id="permiss_person" name="permiss_person" />
                                                            @endif
                                                            <label class="form-check-label" for="permiss_person">บุคคลากร</label>
                                                        </div>

                                                         <!-- Default checkbox -->
                                                         <div class="form-check mt-2">
                                                            <i class="fa-solid fa-book-open-reader text-secondary"></i>
                                                              @if ($dataedits->permiss_book == 'on')
                                                              <input class="form-check-input" type="checkbox" id="permiss_book" name="permiss_book"  checked/>
                                                              @else
                                                              <input class="form-check-input" type="checkbox" id="permiss_book" name="permiss_book"/>
                                                              @endif
                                                              <label class="form-check-label" for="permiss_book">สารบรรณ</label>
                                                          </div>

                                                          <div class="form-check mt-2">
                                                            <i class="fa-solid fa-truck-medical text-info"></i>

                                                              @if ($dataedits->permiss_car == 'on')
                                                              <input class="form-check-input" type="checkbox" id="permiss_car" name="permiss_car" checked/>
                                                              @else
                                                              <input class="form-check-input" type="checkbox" id="permiss_car" name="permiss_car"/>
                                                              @endif
                                                              <label class="form-check-label" for="permiss_car">ยานพาหนะ</label>
                                                          </div>

                                                          <div class="form-check mt-2">
                                                            <i class="fa-solid fa-house-laptop text-success"></i>

                                                              @if ($dataedits->permiss_meetting == 'on')
                                                              <input class="form-check-input" type="checkbox" id="permiss_meetting" name="permiss_meetting" checked/>
                                                              @else
                                                              <input class="form-check-input" type="checkbox" id="permiss_meetting" name="permiss_meetting"/>
                                                              @endif
                                                              <label class="form-check-label" for="permiss_meetting">ห้องประชุม</label>
                                                          </div>

                                                          <div class="form-check mt-2">
                                                            <i class="fa-solid fa-camera-retro" style="color: rgb(9, 169, 197)"></i>
                                                            @if ($dataedits->permiss_sot == 'on')
                                                                <input class="form-check-input" type="checkbox" id="permiss_sot" name="permiss_sot" checked/>
                                                            @else
                                                                <input class="form-check-input" type="checkbox" id="permiss_sot" name="permiss_sot"/>
                                                            @endif
                                                                <label class="form-check-label" for="permiss_sot">งานโสต</label>
                                                        </div>
                                                        <div class="form-check mt-2">
                                                            <i class="fa-regular fa-clock text-primary"></i>

                                                                @if ($dataedits->permiss_time == 'on')
                                                                <input class="form-check-input" type="checkbox" id="permiss_time" name="permiss_time" checked/>
                                                            @else
                                                            <input class="form-check-input" type="checkbox" id="permiss_time" name="permiss_time"/>
                                                            @endif
                                                            <label class="form-check-label" for="permiss_time">ระบบลงเวลา</label>
                                                        </div>
                                                        <div class="form-check mt-2">
                                                            <i class="fa-solid fa-house-chimney-user text-info"></i>
                                                              @if ($dataedits->permiss_hosing == 'on')
                                                              <input class="form-check-input" type="checkbox" id="permiss_hosing" name="permiss_hosing" checked/>
                                                              @else
                                                              <input class="form-check-input" type="checkbox" id="permiss_hosing" name="permiss_hosing" />
                                                              @endif
                                                              <label class="form-check-label" for="permiss_hosing">บ้านพัก</label>
                                                        </div>
                                                        <div class="form-check mt-2">
                                                            <i class="fa-solid fa-solid fa-people-line" style="color: rgb(9, 106, 197)"></i>
                                                            @if ($dataedits->permiss_ot == 'on')
                                                            <input class="form-check-input" type="checkbox" id="permiss_ot" name="permiss_ot" checked/>
                                                            @else
                                                            <input class="form-check-input" type="checkbox" id="permiss_ot" name="permiss_ot" />
                                                            @endif
                                                            <label class="form-check-label" for="permiss_ot">โอที</label>
                                                        </div>
                                                        <div class="form-check mt-2">
                                                            <i class="fa-solid fa-solid fa-hospital-user" style="color: rgb(170, 7, 97)"></i>
                                                            @if ($dataedits->permiss_gleave == 'on')
                                                            <input class="form-check-input" type="checkbox" id="permiss_gleave" name="permiss_gleave" checked/>
                                                            @else
                                                            <input class="form-check-input" type="checkbox" id="permiss_gleave" name="permiss_gleave" />
                                                            @endif
                                                            <label class="form-check-label" for="permiss_gleave">ระบบการลา</label>
                                                        </div>
                                                        <div class="form-check mt-2">
                                                            <i class="fa-solid fa-screwdriver-wrench text-info"></i>
                                                              @if ($dataedits->permiss_repair == 'on')
                                                              <input class="form-check-input" type="checkbox" id="permiss_repair" name="permiss_repair" checked/>
                                                              @else
                                                              <input class="form-check-input" type="checkbox" id="permiss_repair" name="permiss_repair" />
                                                              @endif
                                                              <label class="form-check-label" for="permiss_repair">ซ่อมบำรุง</label>
                                                        </div>
                                                        <div class="form-check mt-2">
                                                            <i class="fa-solid fa-computer text-secondary"></i>
                                                            @if ($dataedits->permiss_com == 'on')
                                                            <input class="form-check-input" type="checkbox" id="permiss_com" name="permiss_com" checked/>
                                                            @else
                                                            <input class="form-check-input" type="checkbox" id="permiss_com" name="permiss_com" />
                                                            @endif
                                                            <label class="form-check-label" for="permiss_com">คอมพิวเตอร์</label>
                                                        </div>
                                                        <div class="form-check mt-2">
                                                            <i class="fa-solid fa-pump-medical text-warning"></i>
                                                            @if ($dataedits->permiss_medical == 'on')
                                                                <input class="form-check-input" type="checkbox" id="permiss_medical" name="permiss_medical" checked/>
                                                                @else
                                                                <input class="form-check-input" type="checkbox" id="permiss_medical" name="permiss_medical" />
                                                                @endif
                                                            <label class="form-check-label" for="permiss_medical">เครื่องมือแพทย์</label>
                                                        </div>


                                                    </div>
                                                </div>
                                            </div>


                                            <div class="col-4 col-md-3 col-xl-3">
                                                <div class="card">
                                                    <div class="card-body shadow-lg">

                                                        <div class="form-check mt-2">
                                                            <i class="fa-solid fa-building-shield text-secondary"></i>
                                                              @if ($dataedits->permiss_asset == 'on')
                                                              <input class="form-check-input" type="checkbox" id="permiss_asset" name="permiss_asset" checked/>
                                                              @else
                                                              <input class="form-check-input" type="checkbox" id="permiss_asset" name="permiss_asset" />
                                                              @endif
                                                              <label class="form-check-label" for="permiss_asset">ทรัพย์สิน</label>
                                                        </div>
                                                        <div class="form-check mt-2">
                                                            <i class="fa-solid fa-paste text-success"></i>
                                                              @if ($dataedits->permiss_supplies == 'on')
                                                              <input class="form-check-input" type="checkbox" id="permiss_supplies" name="permiss_supplies" checked/>
                                                              @else
                                                              <input class="form-check-input" type="checkbox" id="permiss_supplies" name="permiss_supplies" />
                                                              @endif
                                                              <label class="form-check-label" for="permiss_supplies">พัสดุ</label>
                                                        </div>
                                                        <div class="form-check mt-2">
                                                            <i class="fa-solid fa-shop-lock text-primary"></i>
                                                              @if ($dataedits->permiss_store == 'on')
                                                              <input class="form-check-input" type="checkbox" id="permiss_store" name="permiss_store" checked/>
                                                              @else
                                                              <input class="form-check-input" type="checkbox" id="permiss_store" name="permiss_store" />
                                                              @endif
                                                              <label class="form-check-label" for="permiss_store">คลังวัสดุ</label>
                                                        </div>
                                                        <div class="form-check mt-2">
                                                            <i class="fa-solid fa-shop-lock text-primary"></i>
                                                              @if ($count_storenormal > '0')
                                                              <input class="form-check-input" type="checkbox" id="STORE_NORMAL" name="STORE_NORMAL" checked/>
                                                              @else
                                                              <input class="form-check-input" type="checkbox" id="STORE_NORMAL" name="STORE_NORMAL" />
                                                              @endif
                                                              <label class="form-check-label" for="STORE_NORMAL">คลังวัสดุ(เบิกจ่ายทั่วไป)</label>
                                                        </div>
                                                        <div class="form-check mt-2">
                                                            <i class="fa-solid fa-shop-lock text-primary"></i>
                                                              @if ($count_storevip > '0')
                                                              <input class="form-check-input" type="checkbox" id="STORE_VIP" name="STORE_VIP" checked/>
                                                              @else
                                                              <input class="form-check-input" type="checkbox" id="STORE_VIP" name="STORE_VIP" />
                                                              @endif
                                                              <label class="form-check-label" for="STORE_VIP">คลังวัสดุ(เบิกจ่าย(พัสดุ))</label>
                                                        </div>
                                                        <div class="form-check mt-2">
                                                            <i class="fa-solid fa-shop-lock text-primary"></i>
                                                              @if ($count_rep > '0')
                                                              <input class="form-check-input" type="checkbox" id="STORE_REP" name="STORE_REP" checked/>
                                                              @else
                                                              <input class="form-check-input" type="checkbox" id="STORE_REP" name="STORE_REP" />
                                                              @endif
                                                              <label class="form-check-label" for="STORE_REP">คลังวัสดุ(ตรวจรับ(พัสดุ))</label>
                                                        </div>
                                                        <div class="form-check mt-2">
                                                            <i class="fa-solid fa-prescription text-success"></i>
                                                            @if ($dataedits->permiss_store_dug == 'on')
                                                                <input class="form-check-input" type="checkbox" id="permiss_store_dug" name="permiss_store_dug" checked/>
                                                                @else
                                                                <input class="form-check-input" type="checkbox" id="permiss_store_dug" name="permiss_store_dug" />
                                                                @endif
                                                            <label class="form-check-label" for="permiss_store_dug">คลังยา</label>
                                                        </div>
                                                        {{-- <div class="form-check mt-2">
                                                            <i class="fa-solid fa-file-invoice-dollar" style="color: rgb(9, 169, 197)"></i>
                                                            @if ($count_309 > '0')
                                                                <input class="form-check-input" type="checkbox" id="ACC_309" name="ACC_309" checked/>
                                                            @else
                                                                <input class="form-check-input" type="checkbox" id="ACC_309" name="ACC_309" />
                                                            @endif
                                                                <label class="form-check-label" for="ACC_309">309 ค่าใช้จ่ายสูง OP</label>
                                                        </div> --}}
                                                    </div>
                                                </div>
                                            </div>



                                            <div class="col-4 col-md-3 col-xl-3">
                                                <div class="card">
                                                    <div class="card-body shadow-lg">
                                                        <div class="form-check mt-2">
                                                            <i class="fa-solid fa-clipboard text-danger"></i>
                                                              @if ($dataedits->permiss_plan == 'on')
                                                              <input class="form-check-input" type="checkbox" id="permiss_plan" name="permiss_plan" checked/>
                                                              @else
                                                              <input class="form-check-input" type="checkbox" id="permiss_plan" name="permiss_plan" />
                                                              @endif
                                                              <label class="form-check-label" for="permiss_plan">แผนงาน</label>
                                                        </div>
                                                        <div class="form-check mt-2">
                                                            <i class="fa-solid fa-person-booth text-danger"></i>
                                                            @if ($dataedits->permiss_pay == 'on')
                                                                <input class="form-check-input" type="checkbox" id="permiss_pay" name="permiss_pay" checked/>
                                                                @else
                                                                <input class="form-check-input" type="checkbox" id="permiss_pay" name="permiss_pay" />
                                                                @endif
                                                            <label class="form-check-label" for="permiss_pay">จ่ายกลาง</label>
                                                        </div>
                                                        <div class="form-check mt-2">
                                                            <i class="fa-solid fa-p text-primary"></i><i class="fa-solid fa-4 text-primary"></i><i class="fa-solid fa-p text-primary"></i>
                                                            @if ($dataedits->permiss_p4p == 'on')
                                                            <input class="form-check-input" type="checkbox" id="permiss_p4p" name="permiss_p4p" checked/>
                                                            @else
                                                            <input class="form-check-input" type="checkbox" id="permiss_p4p" name="permiss_p4p" />
                                                            @endif
                                                            <label class="form-check-label" for="permiss_p4p">งาน P4P</label>
                                                        </div>
                                                        <div class="form-check mt-2">
                                                            <i class="fa-solid fa-hand-holding-droplet" style="color: rgb(9, 169, 197)"></i>
                                                            @if ($dataedits->permiss_env == 'on')
                                                                <input class="form-check-input" type="checkbox" id="permiss_env" name="permiss_env" checked/>
                                                            @else
                                                                <input class="form-check-input" type="checkbox" id="permiss_env" name="permiss_env"/>
                                                            @endif
                                                                <label class="form-check-label" for="permiss_env">ระบบ ENV</label>
                                                        </div>
                                                        <div class="form-check mt-2">
                                                            <i class="fa-solid fa-gear text-danger" style="color: rgb(9, 169, 197)"></i>
                                                            @if ($dataedits->permiss_setting_env == 'on')
                                                                <input class="form-check-input" type="checkbox" id="permiss_setting_env" name="permiss_setting_env" checked/>
                                                            @else
                                                                <input class="form-check-input" type="checkbox" id="permiss_setting_env" name="permiss_setting_env" />
                                                            @endif
                                                                <label class="form-check-label" for="permiss_setting_env">ตั้งค่า ENV</label>
                                                        </div>
                                                        <div class="form-check mt-2">
                                                            <i class="fa-solid fa-sack-dollar text-danger"></i>
                                                                @if ($dataedits->permiss_claim == 'on')
                                                                    <input class="form-check-input" type="checkbox" id="permiss_claim" name="permiss_claim" checked/>
                                                                    @else
                                                                    <input class="form-check-input" type="checkbox" id="permiss_claim" name="permiss_claim" />
                                                                    @endif
                                                                <label class="form-check-label" for="permiss_claim">งานประกัน</label>
                                                        </div>
                                                        <div class="form-check mt-2">
                                                            <i class="fa-solid fa-file-invoice-dollar text-warning"></i>
                                                              @if ($dataedits->permiss_money == 'on')
                                                                  <input class="form-check-input" type="checkbox" id="permiss_money" name="permiss_money" checked/>
                                                                  @else
                                                                  <input class="form-check-input" type="checkbox" id="permiss_money" name="permiss_money" />
                                                                  @endif
                                                              <label class="form-check-label" for="permiss_money">การเงิน</label>
                                                          </div>
                                                    </div>
                                                </div>
                                            </div>




                                            <div class="col-4 col-md-3 col-xl-3">
                                                <div class="card">
                                                    <div class="card-body shadow-lg">
                                                        <div class="form-check mt-2">
                                                            <i class="fa-solid fa-square-person-confined" style="color: rgb(9, 169, 197)"></i>
                                                            @if ($dataedits->permiss_medicine_salt == 'on')
                                                                <input class="form-check-input" type="checkbox" id="permiss_medicine_salt" name="permiss_medicine_salt" checked/>
                                                            @else
                                                                <input class="form-check-input" type="checkbox" id="permiss_medicine_salt" name="permiss_medicine_salt"/>
                                                            @endif
                                                                <label class="form-check-label" for="permiss_medicine_salt">แพทย์แผนไทย</label>
                                                        </div>
                                                        <div class="form-check mt-2">
                                                            <i class="fa-solid fa-house-medical-circle-check" style="color: rgb(9, 169, 197)"></i>
                                                            @if ($dataedits->permiss_clinic_tb == 'on')

                                                            <input class="form-check-input" type="checkbox" id="permiss_clinic_tb" name="permiss_clinic_tb" checked/>
                                                            @else
                                                            <input class="form-check-input" type="checkbox" id="permiss_clinic_tb" name="permiss_clinic_tb"/>
                                                            @endif
                                                            <label class="form-check-label" for="permiss_clinic_tb">Clinic TB</label>
                                                        </div>
                                                        <div class="form-check mt-2">
                                                            <i class="fa-solid fa-house-medical-circle-check" style="color: rgb(9, 169, 197)"></i>
                                                            @if ($count_checkup > '0')

                                                            <input class="form-check-input" type="checkbox" id="CHECK_UP" name="CHECK_UP" checked/>
                                                            @else
                                                            <input class="form-check-input" type="checkbox" id="CHECK_UP" name="CHECK_UP"/>
                                                            @endif
                                                            <label class="form-check-label" for="CHECK_UP">ตรวจสุขภาพ</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="col-4 col-md-3 col-xl-3">
                                                <div class="card">
                                                    <div class="card-body shadow-lg">
                                                        <div class="form-check mt-2">
                                                            <i class="fa-regular fa-heart" style="color: rgb(9, 169, 197)"></i>
                                                            @if ($dataedits->pesmiss_ct == 'on')
                                                                <input class="form-check-input" type="checkbox" id="pesmiss_ct" name="pesmiss_ct" checked/>
                                                            @else
                                                                <input class="form-check-input" type="checkbox" id="pesmiss_ct" name="pesmiss_ct"/>
                                                            @endif
                                                                <label class="form-check-label" for="pesmiss_ct">CT</label>
                                                        </div>
                                                        <div class="form-check mt-2">
                                                            <i class="fa-solid fa-gear text-danger" style="color: rgb(109, 105, 107)"></i>
                                                                @if ($dataedits->per_config == 'on')
                                                                    <input class="form-check-input" type="checkbox" id="admin" name="admin" checked/>
                                                                @else
                                                                    <input class="form-check-input" type="checkbox" id="admin" name="admin"/>
                                                                @endif
                                                                     <label class="form-check-label" for="admin">การตั้งค่าของ ADMIN</label>
                                                        </div>
                                                        <div class="form-check mt-2">
                                                            <i class="fa-solid fa-gear text-danger" style="color: rgb(109, 105, 107)"></i>
                                                                @if ($count_vet > '0')
                                                                    <input class="form-check-input" type="checkbox" id="AUDITVET01" name="AUDITVET01" value="AUDITVET01" checked/>
                                                                @else
                                                                    <input class="form-check-input" type="checkbox" id="AUDITVET01" name="AUDITVET01"/>
                                                                @endif
                                                                     <label class="form-check-label" for="AUDITVET01">Pre-Audit เวชระเบียน</label>
                                                        </div>
                                                        <div class="form-check mt-2">
                                                            <i class="fa-solid fa-gear text-danger" style="color: rgb(109, 105, 107)"></i>
                                                                @if ($count_fdh > '0')
                                                                    <input class="form-check-input" type="checkbox" id="FDH" name="FDH" value="FDH" checked/>
                                                                @else
                                                                    <input class="form-check-input" type="checkbox" id="FDH" name="FDH"/>
                                                                @endif
                                                                     <label class="form-check-label" for="FDH">FDH</label>
                                                        </div>
                                                        <div class="form-check mt-2">
                                                            <i class="fa-solid fa-gear text-danger" style="color: rgb(109, 105, 107)"></i>
                                                                @if ($count_accb > '0')
                                                                    <input class="form-check-input" type="checkbox" id="ACCB01" name="ACCB01" value="ACCB01" checked/>
                                                                @else
                                                                    <input class="form-check-input" type="checkbox" id="ACCB01" name="ACCB01"/>
                                                                @endif
                                                                     <label class="form-check-label" for="FDH">บัญชี</label>
                                                        </div>
                                                        <div class="form-check mt-2">
                                                            <i class="fa-solid fa-gear text-danger" style="color: rgb(109, 105, 107)"></i>
                                                                @if ($count_time > '0')
                                                                    <input class="form-check-input" type="checkbox" id="TIMEOT01" name="TIMEOT01" value="TIMEOT01" checked/>
                                                                @else
                                                                    <input class="form-check-input" type="checkbox" id="TIMEOT01" name="TIMEOT01"/>
                                                                @endif
                                                                     <label class="form-check-label" for="TIMEOT01">Time</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card">
                                                    <div class="card-body shadow-lg">
                                                        <div class="form-check mt-2">
                                                            <i class="fa-regular fa-heart" style="color: rgb(110, 4, 54)"></i>
                                                            @if ($dataedits->per_prs == 'on')
                                                                <input class="form-check-input" type="checkbox" id="per_prs" name="per_prs" checked/>
                                                            @else
                                                                <input class="form-check-input" type="checkbox" id="per_prs" name="per_prs"/>
                                                            @endif
                                                                <label class="form-check-label" for="per_prs">สนับสนุนบริการสุขภาพ</label>

                                                        </div>


                                                        <div class="form-check mt-2">
                                                            <i class="fa-solid fa-gear text-danger" style="color: rgb(197, 9, 103)"></i>
                                                            @if ($dataedits->per_cctv == 'on')
                                                                <input class="form-check-input" type="checkbox" id="per_cctv" name="per_cctv" checked/>
                                                            @else
                                                                <input class="form-check-input" type="checkbox" id="per_cctv" name="per_cctv"/>
                                                            @endif
                                                                <label class="form-check-label" for="per_cctv">CCTV</label>
                                                        </div>

                                                        <div class="form-check mt-2">
                                                            <i class="fa-solid fa-gear text-danger" style="color: rgb(9, 169, 197)"></i>
                                                            @if ($dataedits->per_fire == 'on')
                                                                <input class="form-check-input" type="checkbox" id="per_fire" name="per_fire" checked/>
                                                            @else
                                                                <input class="form-check-input" type="checkbox" id="per_fire" name="per_fire"/>
                                                            @endif
                                                                <label class="form-check-label" for="per_fire">ถังดับเพลิง</label>
                                                        </div>

                                                        <div class="form-check mt-2">
                                                            <i class="fa-solid fa-gear text-danger" style="color: rgb(9, 169, 197)"></i>
                                                            @if ($dataedits->per_air == 'on')
                                                                <input class="form-check-input" type="checkbox" id="per_air" name="per_air" checked/>
                                                            @else
                                                                <input class="form-check-input" type="checkbox" id="per_air" name="per_air"/>
                                                            @endif
                                                                <label class="form-check-label" for="per_air">เครื่องปรับอากาศ</label>
                                                        </div>

                                                    </div>
                                                </div>

                                            </div>
                                            {{-- <div class="col-4 col-md-3 col-xl-3">
                                                <div class="card">
                                                    <div class="card-body shadow-lg">
                                                        <div class="form-check mt-2">
                                                            <i class="fa-regular fa-heart" style="color: rgb(110, 4, 54)"></i>
                                                            @if ($dataedits->per_prs == 'on')
                                                                <input class="form-check-input" type="checkbox" id="per_prs" name="per_prs" checked/>
                                                            @else
                                                                <input class="form-check-input" type="checkbox" id="per_prs" name="per_prs"/>
                                                            @endif
                                                                <label class="form-check-label" for="per_prs">สนับสนุนบริการสุขภาพ</label>

                                                        </div>


                                                        <div class="form-check mt-2">
                                                            <i class="fa-solid fa-gear text-danger" style="color: rgb(197, 9, 103)"></i>
                                                            @if ($dataedits->per_cctv == 'on')
                                                                <input class="form-check-input" type="checkbox" id="per_cctv" name="per_cctv" checked/>
                                                            @else
                                                                <input class="form-check-input" type="checkbox" id="per_cctv" name="per_cctv"/>
                                                            @endif
                                                                <label class="form-check-label" for="per_cctv">CCTV</label>
                                                        </div>

                                                        <div class="form-check mt-2">
                                                            <i class="fa-solid fa-gear text-danger" style="color: rgb(9, 169, 197)"></i>
                                                            @if ($dataedits->per_fire == 'on')
                                                                <input class="form-check-input" type="checkbox" id="per_fire" name="per_fire" checked/>
                                                            @else
                                                                <input class="form-check-input" type="checkbox" id="per_fire" name="per_fire"/>
                                                            @endif
                                                                <label class="form-check-label" for="per_fire">ถังดับเพลิง</label>
                                                        </div>

                                                        <div class="form-check mt-2">
                                                            <i class="fa-solid fa-gear text-danger" style="color: rgb(9, 169, 197)"></i>
                                                            @if ($dataedits->per_air == 'on')
                                                                <input class="form-check-input" type="checkbox" id="per_air" name="per_air" checked/>
                                                            @else
                                                                <input class="form-check-input" type="checkbox" id="per_air" name="per_air"/>
                                                            @endif
                                                                <label class="form-check-label" for="per_air">เครื่องปรับอากาศ</label>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div> --}}
                                            <div class="col-4 col-md-3 col-xl-3">
                                                <div class="card">
                                                    <div class="card-body shadow-lg">
                                                        <div class="form-check mt-2">
                                                            <i class="fa-solid fa-file-invoice-dollar" style="color: rgb(109, 105, 107)"></i>
                                                                @if ($dataedits->permiss_account == 'on')
                                                                <input class="form-check-input" type="checkbox" id="permiss_account" name="permiss_account" checked/>
                                                            @else
                                                            <input class="form-check-input" type="checkbox" id="permiss_account" name="permiss_account"/>
                                                            @endif
                                                            <label class="form-check-label" for="permiss_account">บัญชี-งานประกัน</label>
                                                        </div>

                                                        <div class="form-check mt-2">
                                                            <i class="fa-solid fa-gear text-danger" style="color: rgb(9, 169, 197)"></i>
                                                            @if ($dataedits->permiss_ofc == 'on')
                                                                <input class="form-check-input" type="checkbox" id="permiss_ofc" name="permiss_ofc" checked/>
                                                            @else
                                                                <input class="form-check-input" type="checkbox" id="permiss_ofc" name="permiss_ofc"/>
                                                            @endif
                                                                <label class="form-check-label" for="permiss_ofc">OFC</label>
                                                        </div>
                                                        <div class="form-check mt-2">
                                                            <i class="fa-solid fa-gear text-danger" style="color: rgb(9, 169, 197)"></i>
                                                            @if ($dataedits->permiss_lgo == 'on')
                                                                <input class="form-check-input" type="checkbox" id="permiss_lgo" name="permiss_lgo" checked/>
                                                            @else
                                                                <input class="form-check-input" type="checkbox" id="permiss_lgo" name="permiss_lgo"/>
                                                            @endif
                                                                <label class="form-check-label" for="permiss_lgo">LGO</label>
                                                        </div>
                                                        <div class="form-check mt-2">
                                                            <i class="fa-solid fa-gear text-danger" style="color: rgb(9, 169, 197)"></i>
                                                            @if ($dataedits->permiss_prb == 'on')
                                                                <input class="form-check-input" type="checkbox" id="permiss_prb" name="permiss_prb" checked/>
                                                            @else
                                                                <input class="form-check-input" type="checkbox" id="permiss_prb" name="permiss_prb"/>
                                                            @endif
                                                                <label class="form-check-label" for="permiss_prb">พรบ</label>
                                                        </div>
                                                        <div class="form-check mt-2">
                                                            <i class="fa-solid fa-gear text-danger" style="color: rgb(9, 169, 197)"></i>
                                                            @if ($dataedits->permiss_ti == 'on')
                                                                <input class="form-check-input" type="checkbox" id="permiss_ti" name="permiss_ti" checked/>
                                                            @else
                                                                <input class="form-check-input" type="checkbox" id="permiss_ti" name="permiss_ti"/>
                                                            @endif
                                                                <label class="form-check-label" for="permiss_ti">ไต</label>
                                                        </div>

                                                        <div class="form-check mt-2">
                                                            <i class="fa-solid fa-file-invoice-dollar text-danger" style="color: rgb(9, 169, 197)"></i>
                                                            @if ($count_50x > '0')
                                                                <input class="form-check-input" type="checkbox" id="ACC_50X" name="ACC_50X" checked/>
                                                            @else
                                                                <input class="form-check-input" type="checkbox" id="ACC_50X" name="ACC_50X" />
                                                            @endif
                                                                <label class="form-check-label" for="ACC_50X">ต่างด้าว</label>
                                                        </div>

                                                        <div class="form-check mt-2">
                                                            <i class="fa-solid fa-file-invoice-dollar text-danger" style="color: rgb(9, 169, 197)"></i>
                                                            @if ($count_70x > '0')
                                                                <input class="form-check-input" type="checkbox" id="ACC_70X" name="ACC_70X" checked/>
                                                            @else
                                                                <input class="form-check-input" type="checkbox" id="ACC_70X" name="ACC_70X" />
                                                            @endif
                                                                <label class="form-check-label" for="ACC_70X">สถานะสิทธิ์</label>
                                                        </div>


                                                        <div class="form-check mt-2">
                                                            <i class="fa-solid fa-gear text-danger" style="color: rgb(9, 169, 197)"></i>
                                                            @if ($dataedits->permiss_setting_account == 'on')
                                                                <input class="form-check-input" type="checkbox" id="permiss_setting_account" name="permiss_setting_account" checked/>
                                                            @else
                                                                <input class="form-check-input" type="checkbox" id="permiss_setting_account" name="permiss_setting_account"/>
                                                            @endif
                                                                <label class="form-check-label" for="permiss_setting_name">ตั้งค่า Account</label>
                                                        </div>

                                                        <div class="form-check mt-2">
                                                            <i class="fa-solid fa-gear text-danger" style="color: rgb(9, 169, 197)"></i>
                                                            @if ($dataedits->permiss_setting_upstm == 'on')
                                                                <input class="form-check-input" type="checkbox" id="permiss_setting_upstm" name="permiss_setting_upstm" checked/>
                                                            @else
                                                                <input class="form-check-input" type="checkbox" id="permiss_setting_upstm" name="permiss_setting_upstm" />
                                                            @endif
                                                                <label class="form-check-label" for="permiss_setting_upstm">UP STM</label>
                                                        </div>

                                                        <div class="form-check mt-2">
                                                            <i class="fa-solid fa-gear text-danger" style="color: rgb(9, 169, 197)"></i>
                                                            @if ($dataedits->permiss_rep_money == 'on')
                                                                <input class="form-check-input" type="checkbox" id="permiss_rep_money" name="permiss_rep_money" checked/>
                                                            @else
                                                                <input class="form-check-input" type="checkbox" id="permiss_rep_money" name="permiss_rep_money" />
                                                            @endif
                                                                <label class="form-check-label" for="permiss_rep_money">เปลี่ยนสิทธิ-ปรับผัง</label>
                                                        </div>


                                                        <div class="form-check mt-2">
                                                            <i class="fa-solid fa-file-invoice-dollar text-danger" style="color: rgb(9, 169, 197)"></i>
                                                            @if ($count_106 > '0')
                                                                <input class="form-check-input" type="checkbox" id="OVERSUE_OP" name="OVERSUE_OP" checked/>
                                                            @else
                                                                <input class="form-check-input" type="checkbox" id="OVERSUE_OP" name="OVERSUE_OP" />
                                                            @endif
                                                                <label class="form-check-label" for="OVERSUE_OP">ค้างชำระ OP</label>
                                                        </div>

                                                        <div class="form-check mt-2">
                                                            <i class="fa-solid fa-file-invoice-dollar text-danger" style="color: rgb(9, 169, 197)"></i>
                                                            @if ($count_107 > '0')
                                                                <input class="form-check-input" type="checkbox" id="OVERSUE_IP" name="OVERSUE_IP" checked/>
                                                            @else
                                                                <input class="form-check-input" type="checkbox" id="OVERSUE_IP" name="OVERSUE_IP" />
                                                            @endif
                                                                <label class="form-check-label" for="OVERSUE_IP">ค้างชำระ IP</label>
                                                        </div>

                                                        <div class="form-check mt-2">
                                                            <i class="fa-solid fa-file-invoice-dollar text-danger" style="color: rgb(9, 169, 197)"></i>
                                                            @if ($count_report > '0')
                                                                <input class="form-check-input" type="checkbox" id="ACC_REPORT" name="ACC_REPORT" checked/>
                                                            @else
                                                                <input class="form-check-input" type="checkbox" id="ACC_REPORT" name="ACC_REPORT" />
                                                            @endif
                                                                <label class="form-check-label" for="ACC_REPORT">REPORT</label>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-4 col-md-3 col-xl-3">
                                                <div class="card">

                                                    <div class="card-body shadow-lg">
                                                        <div class="form-check mt-2">
                                                            <i class="fa-solid fa-gear text-danger" style="color: rgb(9, 169, 197)"></i>
                                                            @if ($dataedits->permiss_ucs == 'on')
                                                                <input class="form-check-input" type="checkbox" id="permiss_ucs" name="permiss_ucs" checked/>
                                                            @else
                                                                <input class="form-check-input" type="checkbox" id="permiss_ucs" name="permiss_ucs"/>
                                                            @endif
                                                                <label class="form-check-label" for="permiss_ucs">UCS</label>
                                                        </div>
                                                        <div class="form-check mt-2">
                                                            <i class="fa-solid fa-file-invoice-dollar text-danger" style="color: rgb(9, 169, 197)"></i>
                                                            @if ($count_201 > '0')
                                                                <input class="form-check-input" type="checkbox" id="ACC_201" name="ACC_201" checked/>
                                                            @else
                                                                <input class="form-check-input" type="checkbox" id="ACC_201" name="ACC_201" />
                                                            @endif
                                                                <label class="form-check-label" for="ACC_201">201 UC-OP</label>
                                                        </div>
                                                        <div class="form-check mt-2">
                                                            <i class="fa-solid fa-file-invoice-dollar text-danger" style="color: rgb(9, 169, 197)"></i>
                                                            @if ($count_202 > '0')
                                                                <input class="form-check-input" type="checkbox" id="ACC_202" name="ACC_202" checked/>
                                                            @else
                                                                <input class="form-check-input" type="checkbox" id="ACC_202" name="ACC_202" />
                                                            @endif
                                                                <label class="form-check-label" for="ACC_202">202 UC-IP</label>
                                                        </div>
                                                        <div class="form-check mt-2">
                                                            <i class="fa-solid fa-file-invoice-dollar text-danger" style="color: rgb(9, 169, 197)"></i>
                                                            @if ($count_203 > '0')
                                                                <input class="form-check-input" type="checkbox" id="ACC_203" name="ACC_203" checked/>
                                                            @else
                                                                <input class="form-check-input" type="checkbox" id="ACC_203" name="ACC_203" />
                                                            @endif
                                                                <label class="form-check-label" for="ACC_203">203 UC-OP นอก CUP</label>
                                                        </div>
                                                        <div class="form-check mt-2">
                                                            <i class="fa-solid fa-file-invoice-dollar text-danger" style="color: rgb(9, 169, 197)"></i>
                                                            @if ($count_209 > '0')
                                                                <input class="form-check-input" type="checkbox" id="ACC_209" name="ACC_209" checked/>
                                                            @else
                                                                <input class="form-check-input" type="checkbox" id="ACC_209" name="ACC_209" />
                                                            @endif
                                                                <label class="form-check-label" for="ACC_209">209 (P&P)</label>
                                                        </div>
                                                        <div class="form-check mt-2">
                                                            <i class="fa-solid fa-file-invoice-dollar text-danger" style="color: rgb(9, 169, 197)"></i>
                                                            @if ($count_216 > '0')
                                                                <input class="form-check-input" type="checkbox" id="ACC_216" name="ACC_216" checked/>
                                                            @else
                                                                <input class="form-check-input" type="checkbox" id="ACC_216" name="ACC_216" />
                                                            @endif
                                                                <label class="form-check-label" for="ACC_216">216 UC-OP (CR)</label>
                                                        </div>
                                                        <div class="form-check mt-2">
                                                            <i class="fa-solid fa-file-invoice-dollar text-danger" style="color: rgb(9, 169, 197)"></i>
                                                            @if ($count_217 > '0')
                                                                <input class="form-check-input" type="checkbox" id="ACC_217" name="ACC_217" checked/>
                                                            @else
                                                                <input class="form-check-input" type="checkbox" id="ACC_217" name="ACC_217" />
                                                            @endif
                                                                <label class="form-check-label" for="ACC_217">217 UC-IP (CR)</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-4 col-md-3 col-xl-3">
                                                <div class="card">

                                                    <div class="card-body shadow-lg">
                                                        <div class="form-check mt-2">
                                                            <i class="fa-solid fa-gear" style="color: rgb(9, 169, 197)"></i>
                                                            @if ($dataedits->permiss_sss == 'on')
                                                                <input class="form-check-input" type="checkbox" id="permiss_sss" name="permiss_sss" checked/>
                                                            @else
                                                                <input class="form-check-input" type="checkbox" id="permiss_sss" name="permiss_sss"/>
                                                            @endif
                                                                <label class="form-check-label" for="permiss_sss">SSS</label>
                                                        </div>
                                                        <div class="form-check mt-2">
                                                            <i class="fa-solid fa-file-invoice-dollar" style="color: rgb(9, 169, 197)"></i>
                                                            @if ($count_301 > '0')
                                                                <input class="form-check-input" type="checkbox" id="ACC_301" name="ACC_301" checked/>
                                                            @else
                                                                <input class="form-check-input" type="checkbox" id="ACC_301" name="ACC_301" />
                                                            @endif
                                                                <label class="form-check-label" for="ACC_301">301 OP-เครือข่าย</label>
                                                        </div>
                                                        <div class="form-check mt-2">
                                                            <i class="fa-solid fa-file-invoice-dollar" style="color: rgb(9, 169, 197)"></i>
                                                            @if ($count_302 > '0')
                                                                <input class="form-check-input" type="checkbox" id="ACC_302" name="ACC_302" checked/>
                                                            @else
                                                                <input class="form-check-input" type="checkbox" id="ACC_302" name="ACC_302" />
                                                            @endif
                                                                <label class="form-check-label" for="ACC_302">302 IP-เครือข่าย</label>
                                                        </div>
                                                        <div class="form-check mt-2">
                                                            <i class="fa-solid fa-file-invoice-dollar" style="color: rgb(9, 169, 197)"></i>
                                                            @if ($count_303 > '0')
                                                                <input class="form-check-input" type="checkbox" id="ACC_303" name="ACC_303" checked/>
                                                            @else
                                                                <input class="form-check-input" type="checkbox" id="ACC_303" name="ACC_303" />
                                                            @endif
                                                                <label class="form-check-label" for="ACC_303">303 OP-นอกเครือข่าย</label>
                                                        </div>
                                                        <div class="form-check mt-2">
                                                            <i class="fa-solid fa-file-invoice-dollar" style="color: rgb(9, 169, 197)"></i>
                                                            @if ($count_304 > '0')
                                                                <input class="form-check-input" type="checkbox" id="ACC_304" name="ACC_304" checked/>
                                                            @else
                                                                <input class="form-check-input" type="checkbox" id="ACC_304" name="ACC_304" />
                                                            @endif
                                                                <label class="form-check-label" for="ACC_304">304 IP-นอกเครือข่าย</label>
                                                        </div>
                                                        <div class="form-check mt-2">
                                                            <i class="fa-solid fa-file-invoice-dollar" style="color: rgb(9, 169, 197)"></i>
                                                            @if ($count_307 > '0')
                                                                <input class="form-check-input" type="checkbox" id="ACC_307" name="ACC_307" checked/>
                                                            @else
                                                                <input class="form-check-input" type="checkbox" id="ACC_307" name="ACC_307" />
                                                            @endif
                                                                <label class="form-check-label" for="ACC_307">307 กองทุนทดแทน</label>
                                                        </div>
                                                        <div class="form-check mt-2">
                                                            <i class="fa-solid fa-file-invoice-dollar" style="color: rgb(9, 169, 197)"></i>
                                                            @if ($count_308 > '0')
                                                                <input class="form-check-input" type="checkbox" id="ACC_308" name="ACC_308" checked/>
                                                            @else
                                                                <input class="form-check-input" type="checkbox" id="ACC_308" name="ACC_308" />
                                                            @endif
                                                                <label class="form-check-label" for="ACC_308">308 72 ชั่วโมงแรก</label>
                                                        </div>
                                                        <div class="form-check mt-2">
                                                            <i class="fa-solid fa-file-invoice-dollar" style="color: rgb(9, 169, 197)"></i>
                                                            @if ($count_309 > '0')
                                                                <input class="form-check-input" type="checkbox" id="ACC_309" name="ACC_309" checked/>
                                                            @else
                                                                <input class="form-check-input" type="checkbox" id="ACC_309" name="ACC_309" />
                                                            @endif
                                                                <label class="form-check-label" for="ACC_309">309 ค่าใช้จ่ายสูง OP</label>
                                                        </div>
                                                        <div class="form-check mt-2">
                                                            <i class="fa-solid fa-file-invoice-dollar" style="color: rgb(9, 169, 197)"></i>
                                                            @if ($count_310 > '0')
                                                                <input class="form-check-input" type="checkbox" id="ACC_310" name="ACC_310" checked/>
                                                            @else
                                                                <input class="form-check-input" type="checkbox" id="ACC_310" name="ACC_310" />
                                                            @endif
                                                                <label class="form-check-label" for="ACC_310">310 ค่าใช้จ่ายสูง IP</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>




                                        </div>

                            </div>
                        </div>
                    </div>
                    <div class="card-footer justify-content-md-center">
                        <button type="submit" class="ladda-button me-2 btn-pill btn btn-sm btn-success input_new">
                            <img src="{{ asset('images/Savewhit.png') }}" class="me-2 ms-2" height="18px" width="18px">
                            บันทึกข้อมูล
                        </button>
                    </div>
                </form>
                </div>
            </div>
        </div>


@endsection
@section('footer')

@endsection
