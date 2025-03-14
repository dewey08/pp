@extends('layouts.user_layout')
@section('title', 'PK-OFFICE || Where House')

@section('content')
    <script>
        function TypeAdmin() {
            window.location.href = '{{ route('index') }}';
        }
        function wh_approve_stock(wh_request_id) {
            // alert(bookrep_id);
            Swal.fire({
                title: 'ยืนยันการรับใช่ไหม?',
                text: "ถ้ากดยืนยันรายการพัสดุจะถูกรับเข้าคลังย่อย !!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'ใช่, รับเข้าเดี๋ยวนี้ !',
                cancelButtonText: 'ไม่, ยกเลิก'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        type: "POST",
                        url: "{{ url('wh_approve_stock') }}" + '/' + wh_request_id,
                        success: function(response) {
                            Swal.fire({
                                title: 'รับเข้าเรียบร้อย!',
                                text: "You Confirm success",
                                icon: 'success',
                                showCancelButton: false,
                                confirmButtonColor: '#06D177',
                                // cancelButtonColor: '#d33',
                                confirmButtonText: 'เรียบร้อย'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    $("#sid" + wh_request_id).remove();
                                    window.location.reload();
                                    // window.location = "/book/bookmake_index"; //

                                }
                            })
                        }
                    })
                }
            })
        }
        // wh_cancel_req
        function wh_cancel_req(wh_request_id) {
            // alert(bookrep_id);
            Swal.fire({
                title: 'ต้องการยกเลิกใบเบิกนี้ใช่ไหม?',
                text: "ถ้ากดยืนยันรายการพัสดุจะถูกยกเลิก !!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'ใช่, ยกเลิกเดี๋ยวนี้ !',
                cancelButtonText: 'ไม่, ยกเลิก'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        type: "POST",
                        url: "{{ url('wh_cancel_req') }}" + '/' + wh_request_id,
                        success: function(response) {
                            Swal.fire({
                                title: 'ยกเลิกใบเบิกวัสดุเรียบร้อย!',
                                text: "You Confirm success",
                                icon: 'success',
                                showCancelButton: false,
                                confirmButtonColor: '#06D177',
                                // cancelButtonColor: '#d33',
                                confirmButtonText: 'เรียบร้อย'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    $("#sid" + wh_request_id).remove();
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
        $ynow = date('Y') + 543;
        $yb = date('Y') + 542;
            use App\Http\Controllers\StaticController;
            use App\Http\Controllers\WhUserController;
            use App\Models\Products_request_sub;
            $ref_request_number = WhUserController::ref_request_number();
            $pt_name = WhUserController::pt_name();


    ?>

    <style>
        /* body{
            font-family: Verdana, Geneva, Tahoma, sans-serif;
            font-size: 12px;
            font-weight: 400;

        } */

        #button {
            display: block;
            margin: 20px auto;
            padding: 30px 30px;
            background-color: #eee;
            border: solid #ccc 1px;
            cursor: pointer;
        }

        #overlay {
            position: fixed;
            top: 0;
            z-index: 100;
            width: 100%;
            height: 100%;
            display: none;
            background: rgba(0, 0, 0, 0.6);
        }

        .cv-spinner {
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .spinner {
            width: 250px;
            height: 250px;
            border: 5px #ddd solid;
            border-top: 10px rgb(252, 101, 1) solid;
            border-radius: 50%;
            animation: sp-anime 0.8s infinite linear;
        }

        @keyframes sp-anime {
            100% {
                transform: rotate(360deg);
            }
        }

        .is-hide {
            display: none;
        }

        /* ********************************* Modal ********************************* */
        .modal-dialog {
            max-width: 90%;
        }
        .modal-dialog-slideout {
            min-height: 100%;
            margin:auto 90 0 0 90;   /*  ซ้าย ขวา */
            background: #fff;
        }
        .modal.fade .modal-dialog.modal-dialog-slideout {
            -webkit-transform: translate(100%, 0)scale(30);
            transform: translate(100%, 0)scale(5);
        }
        .modal.fade.show .modal-dialog.modal-dialog-slideout {
            -webkit-transform: translate(0, 0);
            transform: translate(0, 0);
            display: flex;
            align-items: stretch;
            -webkit-box-align: stretch;
            height: 100%;
        }
        .modal.fade.show .modal-dialog.modal-dialog-slideout .modal-body {
            overflow-y: auto;
            overflow-x: hidden;
        }
        .modal-dialog-slideout .modal-content {
            border: 0;
        }
        .modal-dialog-slideout .modal-header,
        .modal-dialog-slideout .modal-footer {
            height: 4rem;
            display: block;
        }
        .datepicker {
            z-index: 2051 !important;
        }
    </style>

<div class="tabs-animation">

        <div class="row text-center">
            <div id="overlay">
                <div class="cv-spinner">
                    <span class="spinner"></span>
                </div>
            </div>
        </div>
        <div id="preloader">
            <div id="status">
                <div class="spinner">
                </div>
            </div>
        </div>
        <form action="{{ URL('wh_sub_main_rp') }}" method="GET">
            @csrf
        <div class="row mt-2 mb-3">
            <div class="col-md-5">
                <button type="button" class="ladda-button btn-pill btn btn-sm btn-white card_prs_4">
                    {{-- <i class="fa-regular fa-rectangle-list me-2 ms-2"></i> --}}
                    <img src="{{ asset('images/datail.png') }}" class="me-2" height="23px" width="23px">
                    รายละเอียดการขอเบิก
                </button>
                <a href="{{url('wh_sub_main')}}" class="ladda-button btn-pill btn btn-sm card_prs_4" style="color:rgb(255, 84, 149)">
                    <img src="{{ asset('images/store_sub.png') }}" class="me-2" height="23px" width="23px">
                    คลัง {{$stock_name}}
                </a>

                {{-- <button type="button" class="ladda-button me-2 btn-pill btn btn-sm card_prs_4 showDocument" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" title="คู่มือการใช้งาน">
                    <img src="{{ asset('images/document_new.png') }}" class="me-2 ms-2" height="23px" width="23px">
                </button> --}}
            </div>
            <div class="col"></div>
            <div class="col-md-3 text-end">
                <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker1'>
                        <input type="text" class="form-control-sm card_prs_4" name="startdate" id="datepicker" placeholder="Start Date" data-date-container='#datepicker1' style="font-size: 12px"
                            data-provide="datepicker" data-date-autoclose="true" autocomplete="off" data-date-language="th-th" value="{{ $startdate }}" required />
                        <input type="text" class="form-control-sm card_prs_4" name="enddate" placeholder="End Date" id="datepicker2" data-date-container='#datepicker1' style="font-size: 12px"
                            data-provide="datepicker" data-date-autoclose="true" autocomplete="off" data-date-language="th-th" value="{{ $enddate }}" />
                        <button type="submit" class="ladda-button btn-pill btn btn-sm btn-info card_prs_4" data-style="expand-left">
                            {{-- <span class="ladda-label"> --}}
                                {{-- <i class="fa-solid fa-magnifying-glass text-white me-2"></i> --}}
                                <img src="{{ asset('images/Search02.png') }}" class="ms-2 me-2" height="23px" width="23px">

                                ค้นหา</span>
                            {{-- <span class="ladda-spinner"></span> --}}
                        </button>
                        {{-- @if ($wh_count > 0) --}}
                        {{-- @else --}}
                            {{-- <a href="{{URL('wh_request_add')}}" class="ladda-button btn-pill btn btn-sm card_prs_4">
                                <img src="{{ asset('images/recieve_store.png') }}" class="me-2" height="23px" width="23px">
                                สร้างใบเบิก
                            </a> --}}
                        {{-- @endif --}}
                </div>
            </div>
            <div class="col-md-1 text-end">
                <a href="{{URL('wh_request_add')}}" class="ladda-button btn-pill btn btn-sm card_prs_4">
                    <img src="{{ asset('images/recieve_store.png') }}" class="me-2" height="23px" width="23px">
                    สร้างใบเบิก
                </a>
            </div>
            {{-- <div class="col-md-1 text-end">
                @if ($wh_count > 0)
                @else
                    <a href="{{URL('wh_request_add')}}" class="ladda-button btn-pill btn btn-sm card_prs_4">
                        <img src="{{ asset('images/recieve_store.png') }}" class="me-2" height="23px" width="23px">
                        สร้างใบเบิก
                    </a>
                @endif
            </div> --}}
        </div>

            {{-- <div class="col-md-4 text-end">

                    <a href="{{url('wh_sub_main')}}" class="ladda-button me-2 btn-pill btn btn-sm btn-info card_prs_4 mb-3">
                        <i class="fa-solid fa-clipboard-check text-white me-2 ms-2"></i> คลัง {{$stock_name}}
                    </a>
                    <a href="javascript:void(0);" class="ladda-button me-2 btn-pill btn btn-sm btn-primary card_prs_4 mb-3" data-bs-toggle="modal" data-bs-target="#Request">
                        <i class="fa-solid fa-clipboard-check text-white me-2 ms-2"></i> เปิดบิล
                    </a>
            </div> --}}
        {{-- </div> --}}
    </form>
        <div class="row">
            <div class="col-md-12">
                <div class="card card_prs_4" style="background-color: rgb(238, 252, 255)">

                    <div class="card-body">

                        <div class="row">
                            <div class="col-xl-12">
                                {{-- <table id="example" class="table table-sm table-striped table-bordered nowrap w-100" style="width: 100%;">   --}}
                                {{-- <table id="scroll-vertical-datatable" class="table table-sm table-striped table-bordered nowrap w-100" style="width: 100%;">   --}}
                                    <table id="example" class="table table-sm table-striped table-bordered dt-responsive nowrap myTable" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th class="text-center" style="background-color: rgb(255, 251, 228);font-size: 12px;">ลำดับ</th>
                                            <th class="text-center" style="background-color: rgb(255, 251, 228);font-size: 12px;" width="5%">สถานะ</th>
                                            <th class="text-center" style="background-color: rgb(255, 251, 228);font-size: 12px;" width="5%">ปีงบประมาณ</th>
                                            <th class="text-center" style="background-color: rgb(255, 251, 228);font-size: 12px;" width="7%">เลขที่บิล</th>
                                            <th class="text-center" style="background-color: rgb(255, 251, 228);font-size: 12px;" width="7%">วันที่ขอเบิก</th>
                                            {{-- <th class="text-center" style="background-color: rgb(255, 251, 228);font-size: 12px;" width="7%">เวลา</th> --}}
                                            <th class="text-center" style="background-color: rgb(255, 251, 228);font-size: 12px;" width="7%">วันที่รับเข้าคลัง</th>
                                            <th class="text-center" style="background-color: rgb(174, 236, 245);font-size: 12px;">คลังที่ต้องการเบิก</th>
                                            <th class="text-center" style="background-color: rgb(250, 194, 187);font-size: 12px;">รับเข้าคลัง</th>
                                            <th class="text-center" style="background-color: rgb(222, 201, 248);font-size: 12px;" width="7%">ยอดรวม</th>
                                            <th class="text-center" style="background-color: rgb(248, 201, 221);font-size: 12px;" width="10%">ผู้เบิก</th>
                                            <th class="text-center" style="background-color: rgb(248, 201, 221);font-size: 12px;" width="10%">ผู้จ่าย</th>
                                            <th class="text-center" style="background-color: rgb(248, 201, 221);font-size: 12px;" width="8%">ผู้รับ</th>
                                            <th class="text-center" style="background-color: rgb(122, 175, 245);font-size: 12px;" width="5%">จัดการ</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php $i = 0;$total1 = 0; $total2 = 0;$total3 = 0;$total4 = 0;$total5 = 0;$total6 = 0;$total7 = 0;$total8 = 0;$total9 = 0; ?>
                                        @foreach ($wh_request as $item)
                                        <?php $i++ ?>
                                        <tr id="sid{{ $item->wh_request_id }}" style="font-size:12px;">
                                            <td class="text-center" width="5%">{{$i}}</td>
                                            <td class="text-center" width="5%">

                                                @if ($item->active == 'REQUEST')
                                                    <span class="badge card_prs_4" style="font-size:10px;background-color: #fca471">สร้างใบเบิกพัสดุ</span>
                                                @elseif ($item->active == 'CANCEL')
                                                    <span class="badge card_prs_4" style="font-size:10px;background-color: #fd2a2a">ยกเลิกใบเบิกพัสดุ</span>
                                                @elseif ($item->active == 'APPREQUEST')
                                                    <span class="badge card_prs_4" style="font-size:10px;background-color: #0dd6d6">รายการครบ</span>
                                                @elseif ($item->active == 'APPROVE')
                                                    <span class="bg-info badge card_prs_4" style="font-size:10px">เห็นชอบ</span>
                                                @elseif ($item->active == 'ALLOCATE')
                                                    <span class="bg-secondary badge card_prs_4" style="font-size:10px">กำลังดำเนิน</span>
                                                @elseif ($item->active == 'CONFIRM')
                                                    <span class="badge card_prs_4" style="font-size:10px;background-color: #e00698">รอยืนยันการจ่ายพัสดุ</span>
                                                @elseif ($item->active == 'CONFIRMSEND')
                                                    <span class="badge card_prs_4" style="font-size:10px;background-color: #c183fa">รอรับเข้าคลัง</span>
                                                @elseif ($item->active == 'REPEXPORT')
                                                <span class="badge card_prs_4" style="font-size:10px;background-color: #01c9ae">รับเข้าคลัง</span>
                                                    {{-- <span class="badge card_prs_4" style="font-size:10px;background-color: #0acea3">ยืนยันรับเข้าคลังย่อย</span> --}}
                                                @else
                                                    {{-- <span class="bg-primary badge" style="font-size:10px">รับเข้าคลัง</span> --}}
                                                @endif

                                            </td>
                                            <td class="text-center" width="5%">{{$item->year}}</td>
                                            <td class="text-center" width="7%">{{$item->request_no}}</td>
                                            <td class="text-center" width="7%">{{Datethai($item->request_date)}}</td>
                                            {{-- <td class="text-center" width="7%">{{$item->request_time}}</td>--}}
                                            <td class="text-center" width="7%">{{Datethai($item->repin_date)}}</td>
                                            <td class="text-start" style="color:rgb(3, 93, 145)">{{$item->stock_list_name}}</td>
                                            <td class="text-start" style="color:rgb(3, 93, 145)">{{$item->DEPARTMENT_SUB_SUB_NAME}}</td>

                                            <td class="text-center" style="color:rgb(4, 115, 180)" width="7%">{{number_format($item->total_price, 2)}}</td>
                                            <td class="text-start" style="color:rgb(3, 93, 145)" width="8%">{{$item->ptname}}</td>
                                            <td class="text-start" style="color:rgb(3, 93, 145)" width="8%">{{$item->ptname_send}}</td>
                                            <td class="text-start" style="color:rgb(3, 93, 145)" width="8%">{{$item->ptname_rep}}</td>
                                            <td class="text-center" width="5%">
                                                <div class="dropdown">
                                                    <button class="btn btn-sm card_prs_4 dropdown-toggle menu" type="button"
                                                        data-bs-toggle="dropdown" aria-expanded="false">ทำรายการ</button>
                                                    <ul class="dropdown-menu">

                                                        <a class="dropdown-item menu fontbtn" href="{{ url('wh_request_edit/' . $item->wh_request_id) }}"
                                                            data-bs-toggle="tooltip" data-bs-placement="left"
                                                            data-bs-custom-class="custom-tooltip" title="แก้ไขใบเบิกวัสดุ" style="color: rgb(255, 141, 34)">
                                                            <img src="{{ asset('images/Edit_Pen.png') }}" height="15px" width="15px">
                                                            แก้ไขใบเบิกวัสดุ
                                                        </a>
                                                        <li>
                                                            <hr class="dropdown-divider">
                                                        </li>
                                                        @if ($item->active == 'REQUEST')
                                                            <a class="dropdown-item menu fontbtn" style="color: rgb(10, 202, 193)" href="{{url('wh_request_addsub/'.$item->wh_request_id)}}" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-custom-class="custom-tooltip" title="เพิ่มวัสดุ(รายการ)">
                                                                <img src="{{ asset('images/Add_product.png') }}" height="15px" width="15px">
                                                                เพิ่มวัสดุ(รายการ)
                                                            </a>
                                                            <li>
                                                                <hr class="dropdown-divider">
                                                            </li>
                                                                <a class="dropdown-item menu fontbtn" style="color: rgb(252, 17, 87)" href="javascript:void(0)" onclick="wh_cancel_req({{ $item->wh_request_id }})"
                                                                  data-bs-toggle="tooltip" data-bs-placement="left" data-bs-custom-class="custom-tooltip" title="ยกเลิกใบเบิกวัสดุ">
                                                                    <img src="{{ asset('images/cancel_new.png') }}" height="15px" width="15px">
                                                                    ยกเลิกใบเบิกวัสดุ
                                                                </a>
                                                        @elseif ($item->active == 'ALLOCATE')
                                                            <a class="dropdown-item menu fontbtn" style="color: rgb(255, 141, 34)" href="javascript:void(0)" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-custom-class="custom-tooltip" title="กำลังดำเนินการ">
                                                                <img src="{{ asset('images/Shop_Sign.png') }}" height="15px" width="15px">
                                                                กำลังดำเนินการ
                                                            </a>
                                                        @elseif ($item->active == 'CONFIRM')
                                                            <a class="dropdown-item menu fontbtn" style="color: rgb(34, 211, 255)" href="javascript:void(0)" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-custom-class="custom-tooltip" title="รอยืนยันการจ่ายพัสดุ">
                                                                <img src="{{ asset('images/wait_store.png') }}" height="15px" width="15px">
                                                                รอยืนยันการจ่ายพัสดุ
                                                            </a>
                                                        @elseif ($item->active =='CONFIRMSEND')
                                                            <a class="dropdown-item menu fontbtn" style="color: rgb(198, 103, 253)" href="javascript:void(0)" onclick="wh_approve_stock({{ $item->wh_request_id }})" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-custom-class="custom-tooltip" title="ยืนยันการรับพัสดุเข้า">
                                                                    <img src="{{ asset('images/recievein_store.png') }}" height="15px" width="15px">
                                                                    ยืนยันการรับพัสดุเข้า
                                                            </a>
                                                        @elseif ($item->active == 'REPEXPORT')

                                                        @else
                                                            {{-- <a class="dropdown-item menu fontbtn" style="color: rgb(10, 202, 193)" href="{{url('wh_request_addsub/'.$item->wh_request_id)}}" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-custom-class="custom-tooltip" title="เพิ่มวัสดุ(รายการ)">
                                                                <img src="{{ asset('images/Add_product.png') }}" height="15px" width="15px">
                                                                เพิ่มวัสดุ(รายการ)
                                                            </a> --}}
                                                        @endif
                                                        
                                                        <li>
                                                            <hr class="dropdown-divider">
                                                        </li>
                                                            <button type="button" style="color: rgb(15, 134, 245)" class="btn dropdown-item menu fontbtn detailModal" value="{{$item->wh_request_id }}" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-custom-class="custom-tooltip" title="รายละเอียด">
                                                                <img src="{{ asset('images/datail.png') }}" height="15px" width="15px">
                                                                รายละเอียด
                                                            </button>
                                                        <li>
                                                            <hr class="dropdown-divider">
                                                        </li>
                                                            <a class="dropdown-item menu fontbtn" style="color: rgb(6, 172, 108)" href="{{url('wh_sub_main_rprint/'.$item->wh_request_id)}}" target="_blank" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-custom-class="custom-tooltip" title="พิมพ์ใบเบิกวัสดุ">
                                                                <img src="{{ asset('images/Printer.png') }}" height="15px" width="15px">
                                                                พิมพ์ใบเบิกวัสดุ
                                                            </a>

                                                    </ul>
                                                </div>
                                            </td>
                                            {{-- <td class="text-center" width="10%">

                                                    <a href="{{URL('wh_request_edit/'.$item->wh_request_id)}}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" title="แก้ไขใบเบิกวัสดุ">
                                                        <img src="{{ asset('images/Edit_Pen.png') }}" height="23px" width="23px">
                                                    </a>
                                                    @if ($item->active == 'ALLOCATE')
                                                        <a href="javascript:void(0)" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" title="กำลังดำเนินการ">
                                                            <img src="{{ asset('images/Shop_Sign.png') }}" height="23px" width="23px">
                                                        </a>
                                                    @elseif ($item->active == 'CONFIRM')
                                                        <a href="javascript:void(0)" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" title="รอยืนยันการจ่ายพัสดุ">
                                                            <img src="{{ asset('images/wait_store.png') }}" height="23px" width="23px">
                                                        </a>
                                                    @elseif ($item->active =='CONFIRMSEND')
                                                        <a href="javascript:void(0)" onclick="wh_approve_stock({{ $item->wh_request_id }})" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" title="ยืนยันการรับพัสดุเข้า">
                                                                 <img src="{{ asset('images/recievein_store.png') }}" height="23px" width="23px">
                                                        </a>
                                                    @elseif ($item->active == 'REPEXPORT')
                                                    @else
                                                        <a href="{{url('wh_request_addsub/'.$item->wh_request_id)}}" target="_blank" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" title="เพิ่มวัสดุ(รายการ)">
                                                            <img src="{{ asset('images/Add_product.png') }}" class="ms-2" height="23px" width="23px">
                                                        </a>
                                                    @endif

                                                    <button type="button" class="btn detailModal" value="{{$item->wh_request_id }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" title="รายละเอียด">
                                                            <img src="{{ asset('images/datail.png') }}" height="23px" width="23px">
                                                    </button>
                                                    <a href="{{url('wh_sub_main_rprint/'.$item->wh_request_id)}}" target="_blank" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" title="พิมพ์ใบเบิกวัสดุ">
                                                            <img src="{{ asset('images/Printer.png') }}" class="me-2" height="23px" width="23px">
                                                    </a>
                                            </td> --}}
                                        </tr>
                                        <!--  Modal content EditRequest -->
                                        <div class="modal fade" id="EditRequest{{$item->wh_request_id}}" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title" id="myExtraLargeModalLabel" style="color:rgb(236, 105, 18)">แก้ไขใบเบิกพัสดุ </h4>
                                                        {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> --}}
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-md-3 text-end d12font">เลขที่บิล</div>
                                                            <div class="col-md-8">
                                                                <div class="form-group text-center">
                                                                    <input type="text" class="form-control-sm input_border d12font" id="edit_request_no" name="edit_request_no" value="{{$item->request_no}}" style="width: 100%" readonly>
                                                                </div>
                                                            </div>

                                                        </div>
                                                        <div class="row mt-2">
                                                            <div class="col-md-3 text-end d12font">วันที่เบิกพัสดุ</div>
                                                            <div class="col-md-4 text-start">
                                                                <div class="form-group">
                                                                    {{-- <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker1'>
                                                                        <input type="text" class="form-control form-control-sm cardacc" name="startdate" id="edit_datepicker" placeholder="Start Date" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                                                                            data-date-language="th-th" value="{{$item->request_date}}" required/>

                                                                    </div>  --}}
                                                                    <input type="date" class="form-control-sm input_border d12font" id="edit_request_date" name="request_date" value="{{$item->request_date}}">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-1 text-end d12font">เวลา</div>
                                                            <div class="col-md-4 text-start">
                                                                <div class="form-group">
                                                                    <input type="time" class="form-control-sm input_border d12font" id="edit_request_time" name="edit_request_time" value="{{$item->request_time}}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row mt-2">
                                                            <div class="col-md-3 text-end d12font">คลังที่ต้องการเบิก</div>
                                                            <div class="col-md-8">
                                                                <select name="editstock_list_id" id="editstock_list_id"  class="form-control-sm input_border d12font" style="width: 100%">
                                                                        <option value="">--เลือก--</option>
                                                                        @foreach ($wh_stock_list as $item_sup)
                                                                        @if ($item->stock_list_id == $item_sup->stock_list_id)
                                                                            <option value="{{$item_sup->stock_list_id}}" selected>{{$item_sup->stock_list_name}}</option>
                                                                        @else
                                                                            <option value="{{$item_sup->stock_list_id}}">{{$item_sup->stock_list_name}}</option>
                                                                        @endif

                                                                        @endforeach
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <input type="hidden" id="edit_bg_yearnow" name="edit_bg_yearnow" value="{{$item->year}}">
                                                        <input type="hidden" id="edit_wh_request_id" name="edit_wh_request_id" value="{{$item->wh_request_id}}">

                                                    </div>
                                                    <div class="modal-footer">
                                                        <div class="col-md-12 text-center">
                                                            <div class="form-group">
                                                                <button type="button" id="UpdateRequest" class="ladda-button me-2 btn-pill btn btn-sm btn-success card_prs_4" >
                                                                    <i class="fa-solid fa-pen-to-square text-white me-2 ms-2"></i>
                                                                    บันทึก
                                                                </button>
                                                                <button type="button" class="ladda-button me-2 btn-pill btn btn-sm btn-danger card_prs_4" data-bs-dismiss="modal">
                                                                    <i class="fa-solid fa-xmark text-white me-2 ms-2"></i>Close</button>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        @endforeach
                                    </tbody>

                                </table>

                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>

        <!--  Modal content forRecieve -->
        <div class="modal fade" id="Request" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="text-center" style="color:rgb(236, 105, 18);">สร้างใบเบิกพัสดุ </h4>
                        {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> --}}
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-3 text-end">เลขที่บิล</div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <input type="text" class="form-control-sm d12font input_border" id="request_no" name="request_no" value="{{$ref_request_number}}" style="width: 100%" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-3 text-end">วันที่เบิกพัสดุ</div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="input-daterange input-group" id="request_date" data-date-format="dd M, yyyy" data-date-autoclose="true" >
                                        <input type="text" class="form-control-sm d12font input_border" name="request_date" id="request_date" placeholder="Start Date" data-date-autoclose="true" autocomplete="off"
                                            data-date-language="th-th" value="{{ $date_now }}"/>

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-1 text-end">เวลา</div>
                            <div class="col-md-4 text-start">
                                <div class="form-group">
                                    <input type="time" class="form-control-sm d12font input_border" id="request_time" name="request_time" value="{{$mm}}">
                                </div>
                            </div>
                        </div>
                        {{-- <div class="row mt-2">
                            <div class="col-md-3 text-end">คลังที่ต้องการเบิก</div>
                            <div class="col-md-8">
                                <select name="stock_list_id" id="stock_list_id"  class="form-control-sm input_border d12font" style="width: 100%">
                                        <option value="">--เลือก--</option>
                                        @foreach ($wh_stock_list as $item_sup)
                                            <option value="{{$item_sup->stock_list_id}}">{{$item_sup->stock_list_name}}</option>
                                        @endforeach
                                </select>
                            </div>
                        </div> --}}

                        <div class="row mt-2">
                            <div class="col-md-3 text-end">ผู้เบิก</div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <input type="text" class="form-control-sm d12font input_border" id="user_request" name="user_request" value="{{$pt_name}}" style="width: 100%" readonly>
                                </div>
                            </div>
                        </div>

                        <input type="hidden" id="bg_yearnow" name="bg_yearnow" value="{{$bg_yearnow}}">
                    </div>
                    <div class="modal-footer">
                        <div class="col-md-12 text-center">
                            <div class="form-group">
                                <button type="button" id="InsertRequest" class="ladda-button me-2 btn-pill btn btn-sm btn-success card_prs_4" >
                                     <i class="fa-solid fa-pen-to-square text-white me-2 ms-2"></i>
                                    บันทึก
                                </button>
                                <button type="button" class="ladda-button me-2 btn-pill btn btn-sm btn-danger card_prs_4" data-bs-dismiss="modal">
                                    <i class="fa-solid fa-xmark text-white me-2 ms-2"></i>Close</button>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


         <!-- companymaintanantModal Modal -->
         <div class="modal fade" id="detailModal"  tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content ">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">รายการที่ขอเบิก</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        </button>
                    </div>
                    <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div style='overflow:scroll; height:500px;'>
                                        <div id="detail_showModal"></div>
                                    </div>
                                </div>
                            </div>
                    </div>

                </div>
            </div>
        </div>

         <!-- Update Modal -->
        <div class="modal fade" id="showDocumentModal"  tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-slideout" role="document">
                <div class="modal-content ">
                    <div class="modal-header">
                        <div class="row">
                            <div class="col-md-8">
                                <h4 class="modal-title" id="editModalLabel" style="color:rgb(248, 28, 83)">คู่มือการใช้งาน</h4>
                            </div>
                            <div class="col-md-4 text-end">
                                <div class="form-group">
                                    <button type="button" class="btn-icon btn-shadow btn-dashed btn btn-outline-danger" data-bs-dismiss="modal">
                                        <i class="fa-solid fa-xmark me-2"></i>Close
                                    </button>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-body">
                        <img src="{{ asset('images/doc/doc_01.png') }}" class="rounded" alt="Image" width="auto" height="700px">
                        <br><br><br>
                        <hr style="color: red;border: blueviolet">
                        <hr style="color: red;border: blueviolet">
                        <br><br><br>
                        <img src="{{ asset('images/doc/doc_02.png') }}" class="rounded" alt="Image" width="auto" height="700px">
                        <br><br><br>
                        <hr style="color: red;border: blueviolet">
                        <hr style="color: red;border: blueviolet">

                        <img src="{{ asset('images/doc/doc_03.png') }}" class="rounded" alt="Image" width="auto" height="700px">
                        <br><br><br>

                        <hr style="color: red;border: blueviolet">
                        <hr style="color: red;border: blueviolet">

                        <img src="{{ asset('images/doc/doc_04.png') }}" class="rounded" alt="Image" width="auto" height="700px">
                        <br><br><br>

                        <hr style="color: red;border: blueviolet">
                        <hr style="color: red;border: blueviolet">

                        <img src="{{ asset('images/doc/doc_05.png') }}" class="rounded" alt="Image" width="auto" height="700px">
                        <br><br><br>

                        <hr style="color: red;border: blueviolet">
                        <hr style="color: red;border: blueviolet">

                        <img src="{{ asset('images/doc/doc_06.png') }}" class="rounded" alt="Image" width="auto" height="700px">
                        <br><br><br>

                        <hr style="color: red;border: blueviolet">
                        <hr style="color: red;border: blueviolet">

                        <img src="{{ asset('images/doc/doc_07.png') }}" class="rounded" alt="Image" width="auto" height="700px">
                        <br><br><br>

                        <hr style="color: red;border: blueviolet">
                        <hr style="color: red;border: blueviolet">

                        <img src="{{ asset('images/doc/doc_08.png') }}" class="rounded" alt="Image" width="auto" height="700px">
                        <br><br><br>

                    </div>
                    <div class="modal-footer">
                    </div>
                </div>
            </div>
        </div>

</div>

@endsection
@section('footer')

    <script>
        $(document).ready(function() {
            $('#example').DataTable();
            $('#example2').DataTable();


            $('#datepicker').datepicker({
                format: 'yyyy-mm-dd'
            });
            $('#datepicker2').datepicker({
                format: 'yyyy-mm-dd'
            });
            $('#edit_datepicker').datepicker({
                format: 'yyyy-mm-dd'
            });
            $('#datepicker3').datepicker({
                format: 'yyyy-mm-dd'
            });
            $('#request_date').datepicker({
                format: 'yyyy-mm-dd'
            });

            $('#stock_list_id').select2({
                dropdownParent: $('#Request')
            });
            $('#p4p_work_month').select2({
                placeholder: "--เลือก--",
                allowClear: true
            });
            // $('#editstock_list_id').select2({
            //         dropdownParent: $('#EditRequest')
            // });
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('#InsertRequest').click(function() {
                var request_no    = $('#request_no').val();
                var request_date  = $('#request_date').val();
                var request_time  = $('#request_time').val();
                // var stock_list_id = $('#stock_list_id').val();
                var bg_yearnow    = $('#bg_yearnow').val();

                Swal.fire({ position: "top-end",
                        title: 'ต้องการสร้างใบเบิกพัสดุใช่ไหม ?',
                        text: "You Warn Add Bill No!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, Add it!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $("#overlay").fadeIn(300);　
                                $("#spinner").show(); //Load button clicked show spinner

                                $.ajax({
                                    url: "{{ route('wh.wh_request_save') }}",
                                    type: "POST",
                                    dataType: 'json',
                                    // data: {request_no,request_date,request_time,stock_list_id,bg_yearnow},
                                    data: {request_no,request_date,request_time,bg_yearnow},
                                    success: function(data) {
                                        if (data.status == 200) {
                                            Swal.fire({ position: "top-end",
                                                title: 'สร้างใบเบิกพัสดุสำเร็จ',
                                                text: "You Add data success",
                                                icon: 'success',
                                                showCancelButton: false,
                                                confirmButtonColor: '#06D177',
                                                confirmButtonText: 'เรียบร้อย'
                                            }).then((result) => {
                                                if (result
                                                    .isConfirmed) {
                                                    console.log(
                                                        data);
                                                    window.location.reload();
                                                    $('#spinner').hide();//Request is complete so hide spinner
                                                        setTimeout(function(){
                                                            $("#overlay").fadeOut(300);
                                                        },500);
                                                }
                                            })
                                        } else {

                                        }
                                    },
                                });

                            }
                })
            });
            $('#UpdateRequest').click(function() {
                var request_no    = $('#edit_request_no').val();
                var request_date  = $('#edit_request_date').val();
                var request_time  = $('#edit_request_time').val();
                var stock_list_id = $('#editstock_list_id').val();
                var bg_yearnow    = $('#edit_bg_yearnow').val();
                var wh_request_id = $('#edit_wh_request_id').val();

                Swal.fire({ position: "top-end",
                        title: 'ต้องการแก้ไขข้อมูลใช่ไหม ?',
                        text: "You Warn Edit Bill No!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, Edit it!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $("#overlay").fadeIn(300);　
                                $("#spinner").show(); //Load button clicked show spinner

                                $.ajax({
                                    url: "{{ route('wh.wh_request_update') }}",
                                    type: "POST",
                                    dataType: 'json',
                                    data: {request_no,request_date,request_time,stock_list_id,bg_yearnow,wh_request_id},
                                    success: function(data) {
                                        if (data.status == 200) {
                                            Swal.fire({ position: "top-end",
                                                title: 'แก้ไขข้อมูลสำเร็จ',
                                                text: "You Edit data success",
                                                icon: 'success',
                                                showCancelButton: false,
                                                confirmButtonColor: '#06D177',
                                                confirmButtonText: 'เรียบร้อย'
                                            }).then((result) => {
                                                if (result
                                                    .isConfirmed) {
                                                    console.log(
                                                        data);
                                                    window.location.reload();
                                                    $('#spinner').hide();//Request is complete so hide spinner
                                                        setTimeout(function(){
                                                            $("#overlay").fadeOut(300);
                                                        },500);
                                                }
                                            })
                                        } else {

                                        }
                                    },
                                });

                            }
                })
            });
        });

        $(document).on('click', '.detailModal', function() {
                var wh_request_id = $(this).val();
                // var maintenance_list_num = '2';
                // alert(wh_request_id);
                $('#detailModal').modal('show');
                $.ajax({
                    type: "GET",
                    url:"{{ url('wh_sub_main_detail') }}",
                    data: { wh_request_id: wh_request_id},
                    success: function(result) {
                        $('#detail_showModal').html(result);
                    },
                });
        });

        $(document).on('click', '.showDocument', function() {
                $('#showDocumentModal').modal('show');
        });


    </script>


@endsection
