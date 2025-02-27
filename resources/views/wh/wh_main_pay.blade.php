@extends('layouts.wh')
@section('title', 'PK-OFFICE || Where House')

@section('content')
    <script>
        function TypeAdmin() {
            window.location.href = '{{ route('index') }}';
        }
        function wh_mainpay_approve(wh_request_id) {
            // alert(wh_request_id);
            Swal.fire({
                title: 'ต้องการตัดจ่ายใช่ไหม?',
                text: "ข้อมูลนี้จะถูกตัดจ่ายไปให้คลังย่อย !!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'ใช่, ตัดจ่ายเดี๋ยวนี้ !',
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
                        url: "{{ url('wh_mainpay_approve') }}" + '/' + wh_request_id,
                        success: function(response) {
                            Swal.fire({
                                title: 'ตัดจ่ายเรียบร้อย!',
                                text: "You Pay success",
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
        use App\Http\Controllers\WhController;
        use App\Http\Controllers\WhUserController;
        use App\Models\Products_request_sub;
        $ref_request_number = WhUserController::ref_request_number();
    ?>

    <style>
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

                <div class="row">
                    <div class="col-md-12">
                        <div class="card card_audit_4c">
                            <div class="card-header">

                                <form action="{{ URL('wh_main_pay') }}" method="GET">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-2">
                                            <h4 style="color:rgb(2, 120, 124)">ตัดจ่ายวัสดุ</h4>
                                        </div>
                                        <div class="col-md-1 text-start">
                                            <button type="button" class="ladda-button me-2 btn-pill btn btn-sm card_prs_4 showDocument" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" title="คู่มือการใช้งาน">
                                                <img src="{{ asset('images/document_new.png') }}" class="me-2 ms-2" height="23px" width="23px">
                                            </button>
                                        </div>
                                        <div class="col"></div>
                                        {{-- <div class="col-md-2">
                                            <select name="stock_list_id" id="stock_list_id" class="form-control card_audit_4c" style="width: 100%;font-size:14px;color:#6409b9">
                                                <option value="">--เลือก--</option>
                                                @foreach ($department_sub_sub as $item)
                                                    <option value="{{$item->DEPARTMENT_SUB_SUB_ID}}">{{$item->DEPARTMENT_SUB_SUB_NAME}}</option>
                                                @endforeach
                                            </select>
                                        </div> --}}
                                        <div class="col-md-1 text-end mt-2">วันที่</div>
                                        <div class="col-md-4 text-end">
                                            <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker1'>
                                                <input type="text" class="form-control-sm input_new" name="startdate" id="datepicker" placeholder="Start Date" style="font-size: 12px" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                                                    data-date-language="th-th" value="{{ $startdate }}" required/>
                                                <input type="text" class="form-control-sm input_new" name="enddate" placeholder="End Date" id="datepicker2" style="font-size: 12px" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                                                    data-date-language="th-th" value="{{ $enddate }}"/>
                                            <button type="submit" class="ladda-button btn-pill btn btn-sm btn-primary input_new" data-style="expand-left">
                                                <span class="ladda-label">
                                                    <img src="{{ asset('images/Search02.png') }}" class="me-2" height="23px" width="23px">
                                                    ค้นหา</span>
                                            </button>
                                        </div>
                                    </div>

                                    </div>
                                </form>

                            </div>

                            <div class="card-body">

                                <input type="hidden" class="form-control-sm" id="request_no" name="request_no" value="{{$ref_request_number}}" style="width: 100%">
                                <input type="hidden" class="form-control-sm" id="request_date" name="request_date" value="{{ $date_now }}" style="width: 100%">
                                <input type="hidden" class="form-control-sm" id="request_time" name="request_time" value="{{$mm}}" style="font-size:13px;width: 100%">
                                <input type="hidden" id="bg_yearnow" name="bg_yearnow" value="{{$bg_yearnow}}">

                                <div class="row mb-2">
                                    <div class="col"></div>
                                    <div class="col-md-3">
                                        <select name="stock_list_id" id="stock_list_id"  class="form-control-sm d12font" style="width: 100%">
                                            <option value="">--เลือก--</option>
                                            @foreach ($wh_stock_list as $item_s)
                                                <option value="{{$item_s->stock_list_id}}">{{$item_s->stock_list_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-3">
                                        <select name="stock_list_subid" id="stock_list_subid"  class="form-control-sm d12font" style="width: 100%">
                                            <option value="">--เลือก--</option>
                                            @foreach ($department_sub_sub as $item_sup)
                                                <option value="{{$item_sup->DEPARTMENT_SUB_SUB_ID}}">{{$item_sup->DEPARTMENT_SUB_SUB_NAME}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <select name="user_request" id="user_request"  class="form-control-sm d12font" style="width: 100%">
                                            <option value="">--เลือก--</option>
                                            @foreach ($user as $item)
                                                <option value="{{$item->id}}">{{$item->fname}}  {{$item->lname}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" id="InsertData" class="ladda-button me-2 btn-pill btn btn-sm btn-success input_new" >
                                            <img src="{{ asset('images/Notes_Add.png') }}" class="me-2" height="21px" width="21px">
                                           สร้างใบตัดจ่ายพัสดุ
                                       </button>
                                    </div>
                                </div>


                            <hr style="color: #f35d06">

                                <div class="row">
                                    <div class="col-xl-12">
                                            <table id="example" class="table table-sm table-striped table-bordered dt-responsive nowrap myTable" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center" style="background-color: rgb(255, 251, 228);font-size: 13px;">ลำดับ</th>
                                                        <th class="text-center" style="background-color: rgb(255, 251, 228);font-size: 13px;" width="5%">สถานะ</th>
                                                        <th class="text-center" style="background-color: rgb(255, 251, 228);font-size: 13px;" width="8%">เลขที่บิล</th>
                                                        <th class="text-center" style="background-color: rgb(255, 251, 228);font-size: 13px;" width="10%">วันที่ตัดจ่าย</th>
                                                        {{-- <th class="text-center" style="background-color: rgb(255, 251, 228);font-size: 13px;" width="10%">วันที่รับเข้าคลังย่อย</th>  --}}
                                                        <th class="text-center" style="background-color: rgb(222, 201, 248);font-size: 13px;">คลังหลัก</th>
                                                        <th class="text-center" style="background-color: rgb(222, 201, 248);font-size: 13px;">คลังย่อย</th>
                                                        <th class="text-center" style="background-color: rgb(222, 201, 248);font-size: 13px;" width="10%">ยอดรวม</th>
                                                        <th class="text-center" style="background-color: rgb(248, 201, 221);font-size: 13px;" width="8%">ผู้ตัด</th>
                                                        {{-- <th class="text-center" style="background-color: rgb(248, 201, 221);font-size: 13px;" width="8%">ผู้จ่าย</th> --}}
                                                        {{-- <th class="text-center" style="background-color: rgb(248, 201, 221);font-size: 13px;" width="8%">ผู้รับเข้าคลังย่อย</th> --}}
                                                        <th class="text-center" style="background-color: rgb(166, 226, 245);font-size: 13px;" width="5%">จัดการ</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $i = 0;$total1 = 0; $total2 = 0;$total3 = 0;$total4 = 0;$total5 = 0;$total6 = 0;$total7 = 0;$total8 = 0;$total9 = 0; ?>
                                                    @foreach ($wh_request as $item)
                                                        <?php $i++ ?>
                                                            <tr id="sid{{ $item->wh_request_id }}" style="font-size:12px;">
                                                                <td class="text-center" width="5%">{{$i}}</td>
                                                                <td class="text-center" width="5%">
                                                                    @if ($item->active == 'PAYNOW')
                                                                        <span class="badge active_4c" style="font-size:10px;background-color: #fca471">สร้างใบตัดจ่ายพัสดุ</span>

                                                                    @elseif ($item->active == 'ADDPAYNOW')
                                                                        <span class="badge active_4c" style="font-size:10px;background-color: #ff91bf">ยืนยันการจ่ายให้คลังย่อย</span>
                                                                    @elseif ($item->active == 'CONFIRMPAYNOW')
                                                                        <span class="badge active_4c" style="font-size:10px;background-color: #0acea3">จ่ายเข้าคลังย่อยเรียร้อย</span>
                                                                    @else
                                                                        {{-- <span class="bg-primary badge active_4c" style="font-size:10px">รับเข้าคลัง</span> --}}
                                                                    @endif
                                                                </td>
                                                                <td class="text-center" width="7%">{{$item->request_no}}</td>
                                                                <td class="text-center" width="8%">{{Datethai($item->request_date)}}</td>
                                                                {{-- <td class="text-center" width="8%">{{Datethai($item->repin_date)}}</td>  --}}
                                                                <td class="text-start" style="color:rgb(3, 93, 145)">{{$item->stock_list_name}}</td>
                                                                <td class="text-start" style="color:rgb(3, 93, 145)">{{$item->DEPARTMENT_SUB_SUB_NAME}}</td>
                                                                <td class="text-end" style="color:rgb(4, 115, 180)" width="10%">{{number_format($item->total_price, 2)}}</td>
                                                                <td class="text-start" style="color:rgb(3, 93, 145)" width="8%">{{$item->ptname}}</td>
                                                                {{-- <td class="text-start" style="color:rgb(3, 93, 145)" width="8%">{{$item->ptname_send}}</td> --}}
                                                                {{-- <td class="text-start" style="color:rgb(3, 93, 145)" width="8%">{{$item->ptname_rep}}</td> --}}
                                                                <td class="text-center" width="7%">
                                                                        <a href="{{URL('wh_main_payedit/'.$item->wh_request_id)}}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" title="แก้ไขใบตัดจ่ายวัสดุ">
                                                                            <img src="{{ asset('images/Edit_Pen.png') }}" height="23px" width="23px">
                                                                        </a>

                                                                        <a href="{{url('wh_main_payadd/'.$item->wh_request_id)}}" class="ms-2" target="_blank" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" title="1-เพิ่มรายการวัสดุ">
                                                                            <img src="{{ asset('images/ShoppingCart01.png') }}" height="25px" width="25px">
                                                                        </a>
                                                                        @if ($item->active == 'ADDPAYNOW')
                                                                        <a href="javascript:void(0)" onclick="wh_mainpay_approve({{ $item->wh_request_id }})"
                                                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                                                            data-bs-custom-class="custom-tooltip" title="2-ยืนยันการจ่าย">
                                                                            <img src="{{ asset('images/Confirm.png') }}" height="25px" width="25px" class="ms-2">
                                                                        </a>
                                                                        @endif
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
                </div>

        <!--  Modal content forRecieve -->
        {{-- <div class="modal fade" id="Recieve" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myExtraLargeModalLabel" style="color:rgb(236, 105, 18)">เบิก-จ่าย พัสดุ </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-2 text-end">เลขที่บิล</div>
                            <div class="col-md-4">
                                <div class="form-group text-center">
                                    <input type="text" class="form-control-sm" id="recieve_no" name="recieve_no" >
                                </div>
                            </div>
                            <div class="col-md-2 text-end">วันที่เบิก-จ่าย</div>
                            <div class="col-md-2">
                                <div class="form-group text-center">
                                    <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker1'>
                                        <input type="text" class="form-control-sm cardacc" name="startdate" id="datepicker" placeholder="Start Date" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                                            data-date-language="th-th" value="{{ $date_now }}" required/>

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group text-center">
                                    <input type="time" class="form-control-sm" id="recieve_time" name="recieve_time" value="{{$mm}}">
                                </div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-2 text-end">รับจากบริษัท</div>
                            <div class="col-md-4">
                                <select name="stock_list_id" id="stock_list_id"  class="form-control-sm" style="width: 100%">
                                        <option value="">--เลือก--</option>
                                        @foreach ($air_supplies as $item_sup)
                                            <option value="{{$item_sup->air_supplies_id}}">{{$item_sup->supplies_name}}</option>
                                        @endforeach
                                </select>
                            </div>
                            <div class="col-md-2 text-end">รับเข้าคลัง</div>
                            <div class="col-md-4">
                                <select name="stock_list_id_sub" id="stock_list_id_sub"  class="form-control-sm" style="width: 100%">
                                    <option value="">--เลือก--</option>
                                    @foreach ($wh_stock_list as $item_st)
                                        <option value="{{$item_st->stock_list_id}}">{{$item_st->stock_list_name}}</option>
                                    @endforeach
                            </select>
                            </div>
                        </div>

                        <input type="hidden" id="bg_yearnow" name="bg_yearnow" value="{{$bg_yearnow}}">
                    </div>
                    <div class="modal-footer">
                        <div class="col-md-12 text-end">
                            <div class="form-group">
                                <button type="button" id="InsertData" class="ladda-button me-2 btn-pill btn btn-sm btn-success input_new" >
                                     <i class="fa-solid fa-pen-to-square text-white me-2 ms-2"></i>
                                    บันทึก
                                </button>
                                <button type="button" class="ladda-button me-2 btn-pill btn btn-sm btn-danger input_new" data-bs-dismiss="modal">
                                    <i class="fa-solid fa-xmark text-white me-2 ms-2"></i>Close</button>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}

          <!-- คู่มือ Modal -->
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
                        <img src="{{ asset('images/doc/store_1.jpg') }}" class="rounded" alt="Image" width="auto" height="700px">
                        <br><br><br>
                        <hr style="color: red;border: blueviolet">
                        <hr style="color: red;border: blueviolet">
                        <br><br><br>
                        <img src="{{ asset('images/doc/store_2.jpg') }}" class="rounded" alt="Image" width="auto" height="700px">
                        <br><br><br>
                        <hr style="color: red;border: blueviolet">
                        <hr style="color: red;border: blueviolet">

                        <img src="{{ asset('images/doc/store_3.jpg') }}" class="rounded" alt="Image" width="auto" height="700px">
                        <br><br><br>

                        <hr style="color: red;border: blueviolet">
                        <hr style="color: red;border: blueviolet">

                        <img src="{{ asset('images/doc/store_4.jpg') }}" class="rounded" alt="Image" width="auto" height="700px">
                        <br><br><br>

                        <hr style="color: red;border: blueviolet">
                        <hr style="color: red;border: blueviolet">

                        <img src="{{ asset('images/doc/store_5.jpg') }}" class="rounded" alt="Image" width="auto" height="700px">
                        <br><br><br>

                        <hr style="color: red;border: blueviolet">
                        <hr style="color: red;border: blueviolet">

                        {{-- <img src="{{ asset('images/doc/doc_06.png') }}" class="rounded" alt="Image" width="auto" height="700px">
                        <br><br><br> --}}

                        {{-- <hr style="color: red;border: blueviolet">
                        <hr style="color: red;border: blueviolet">

                        <img src="{{ asset('images/doc/doc_07.png') }}" class="rounded" alt="Image" width="auto" height="700px">
                        <br><br><br>

                        <hr style="color: red;border: blueviolet">
                        <hr style="color: red;border: blueviolet">

                        <img src="{{ asset('images/doc/doc_08.png') }}" class="rounded" alt="Image" width="auto" height="700px">
                        <br><br><br> --}}

                    </div>
                    <div class="modal-footer">
                    </div>
                </div>
            </div>
        </div>



@endsection
@section('footer')

    <script>
         $(document).ready(function() {
            $('#Recieve').on('shown.bs.modal', function() {
                $('#datepicker').datepicker({format: 'yyyy-mm-dd'});
            });
            $('#stock_list_id').select2({
                placeholder: "--ตัดจากคลัง(หลัก)--",
                allowClear: true
            });
            $('#stock_list_subid').select2({
                placeholder: "--เข้าคลัง(ย่อย)--",
                allowClear: true
            });
            $('#user_request').select2({
                placeholder: "--ผู้ร้องขอ(ย่อย)--",
                allowClear: true
            });

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('#InsertData').click(function() {
                var request_no           = $('#request_no').val();
                var request_date         = $('#request_date').val();
                var request_time         = $('#request_time').val();
                var stock_list_subid     = $('#stock_list_subid').val();
                var stock_list_id        = $('#stock_list_id').val();
                var bg_yearnow           = $('#bg_yearnow').val();
                var user_request         = $('#user_request').val();

                Swal.fire({ position: "top-end",
                        title: 'ต้องการเพิ่มข้อมูลใช่ไหม ?',
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
                                    url: "{{ route('wh.wh_main_paysave') }}",
                                    type: "POST",
                                    dataType: 'json',
                                    data: {request_no,request_date,request_time,stock_list_subid,stock_list_id,bg_yearnow,user_request},
                                    success: function(data) {
                                        if (data.status == 200) {
                                            Swal.fire({ position: "top-end",
                                                title: 'เพิ่มข้อมูลสำเร็จ',
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

            // $('#UpdateData').click(function() {
            //     var recieve_no    = $('#edit_recieve_no').val();
            //     var recieve_date  = $('#edit_datepicker').val();
            //     var recieve_time  = $('#edit_recieve_time').val();
            //     var vendor_id     = $('#edit_vendor_id').val();
            //     var stock_list_id = $('#edit_stock_list_id').val();
            //     var bg_yearnow    = $('#edit_bg_yearnow').val();
            //     var wh_recieve_id = $('#edit_wh_recieve_id').val();

            //     Swal.fire({ position: "top-end",
            //             title: 'ต้องการแก้ไขข้อมูลใช่ไหม ?',
            //             text: "You Warn Edit Bill No!",
            //             icon: 'warning',
            //             showCancelButton: true,
            //             confirmButtonColor: '#3085d6',
            //             cancelButtonColor: '#d33',
            //             confirmButtonText: 'Yes, Edit it!'
            //             }).then((result) => {
            //                 if (result.isConfirmed) {
            //                     $("#overlay").fadeIn(300);　
            //                     $("#spinner").show(); //Load button clicked show spinner

            //                     $.ajax({
            //                         url: "{{ route('wh.wh_recieve_update') }}",
            //                         type: "POST",
            //                         dataType: 'json',
            //                         data: {recieve_no,recieve_date,recieve_time,vendor_id,stock_list_id,bg_yearnow,wh_recieve_id},
            //                         success: function(data) {
            //                             if (data.status == 200) {
            //                                 Swal.fire({ position: "top-end",
            //                                     title: 'แก้ไขข้อมูลสำเร็จ',
            //                                     text: "You Edit data success",
            //                                     icon: 'success',
            //                                     showCancelButton: false,
            //                                     confirmButtonColor: '#06D177',
            //                                     confirmButtonText: 'เรียบร้อย'
            //                                 }).then((result) => {
            //                                     if (result
            //                                         .isConfirmed) {
            //                                         console.log(
            //                                             data);
            //                                         window.location.reload();
            //                                         $('#spinner').hide();//Request is complete so hide spinner
            //                                             setTimeout(function(){
            //                                                 $("#overlay").fadeOut(300);
            //                                             },500);
            //                                     }
            //                                 })
            //                             } else {

            //                             }
            //                         },
            //                     });

            //                 }
            //     })
            // });
        });
        $(document).ready(function() {
            $('#example').DataTable();
            $('#example2').DataTable();

            $('#p4p_work_month').select2({
                placeholder: "--เลือก--",
                allowClear: true
            });
            $('#datepicker').datepicker({
                format: 'yyyy-mm-dd'
            });
            $('#datepicker2').datepicker({
                format: 'yyyy-mm-dd'
            });
        });
        $(document).on('click', '.showDocument', function() {
                $('#showDocumentModal').modal('show');
        });
    </script>


@endsection
