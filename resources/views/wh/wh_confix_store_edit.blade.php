@extends('layouts.wh')
@section('title', 'PK-OFFICE || Where House')

@section('content')
    <script>
        function TypeAdmin() {
            window.location.href = '{{ route('index') }}';
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


        <div class="app-main__outer">
            <div class="app-main__inner">


                    <div class="row">

                        <div class="col-md-2">
                            <h3 style="color:rgb(247, 103, 68)">คลังพัสดุ</h3>
                        </div>
                        <div class="col-md-4">
                            <input type="text" class="form-control-sm d12font input_border" id="stock_list_name" name="stock_list_name" style="width: 100%" placeholder="ชื่อคลังพัสดุ" value="{{$data_edit->stock_list_name}}">
                        </div>

                        <input type="hidden" class="form-control-sm d12font input_border" id="stock_list_id" name="stock_list_id" style="width: 100%" value="{{$data_edit->stock_list_id}}">

                        <div class="col-md-2">
                            <select name="userid" id="userid"  class="custom-select custom-select-sm d12font" style="width: 100%">
                                <option value="">--เลือกผู้สั่งจ่าย--</option>
                                @foreach ($users as $item_)
                                @if ($data_edit->userid == $item_->id)
                                <option value="{{$item_->id}}" selected>{{$item_->fname}}  {{$item_->lname}}</option>
                                @else
                                <option value="{{$item_->id}}">{{$item_->fname}}  {{$item_->lname}}</option>
                                @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select name="userpay" id="userpay"  class="custom-select custom-select-sm" style="width: 100%">
                                <option value="">--เลือกผู้จ่าย--</option>
                                @foreach ($users as $item_)
                                @if ($data_edit->userpay == $item_->id)
                                    <option value="{{$item_->id}}" selected>{{$item_->fname}}  {{$item_->lname}}</option>
                                @else
                                    <option value="{{$item_->id}}">{{$item_->fname}}  {{$item_->lname}}</option>
                                @endif
                                @endforeach
                            </select>
                        </div>


                        <div class="col-md-2 text-start">

                            <button type="button" id="UpdateData" class="ladda-button me-2 btn-pill btn btn-sm btn-success input_new" >
                                <img src="{{ asset('images/Notes_Add.png') }}" class="me-2" height="21px" width="21px">
                                แก้ไขคลังพัสดุ
                           </button>
                        </div>
                    </div>

                <div class="row mt-2">

                    <div class="col-xl-12">
                        <div class="card card_audit_4c" style="background-color: rgb(248, 241, 237)">
                            <div class="table-responsive p-3">
                                <table id="example" class="table table-sm table-striped table-bordered dt-responsive nowrap myTable" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th class="text-center" style="background-color: rgb(219, 247, 232)">ลำดับ</th>
                                            <th class="text-center" style="background-color: rgb(219, 247, 232)">รายการคลังพัสดุ</th>
                                            <th class="text-center" style="background-color: rgb(192, 220, 252)">ผู้สั่งจ่าย</th>
                                            <th class="text-center" style="background-color: rgb(192, 220, 252)">ผู้จ่าย</th>
                                            <th class="text-center" style="background-color: rgb(192, 220, 252)">active</th>
                                            <th class="text-center" style="background-color: rgb(192, 220, 252)">จัดการ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $number = 0; $total1 = 0; $total2 = 0; $total3 = 0; $total4 = 0; $total5 = 0;$total6 = 0;$total7 = 0;
                                        ?>
                                        @foreach ($wh_stock_list as $item)
                                            <?php $number++; ?>
                                                <tr style="font-size: 13px;">
                                                    <td class="text-font" style="text-align: center;" width="4%">{{ $number }} </td>
                                                    <td class="text-start" style="font-size: 13px;color:#022f57">{{$item->stock_list_name}}</td>
                                                    <td class="text-start" style="color:rgb(29, 102, 185)" width="10%"> {{ $item->uname}}</td>
                                                    <td class="text-start" style="color:rgb(29, 102, 185)" width="10%"> {{ $item->ptname_pay}}</td>
                                                    <td class="text-center" style="color:rgb(29, 102, 185)" width="4%">
                                                        <div class="form-check form-switch">
                                                            @if ($item->active == 'Y')
                                                                <input type="checkbox" class="form-check-input" id="{{ $item->stock_list_id }}" name="{{ $item->stock_list_id }}" onchange="switchactive({{ $item->stock_list_id }});" checked>
                                                            @else
                                                                <input type="checkbox" class="form-check-input" id="{{ $item->stock_list_id }}" name="{{ $item->stock_list_id }}" onchange="switchactive({{ $item->stock_list_id }});">
                                                            @endif
                                                            <label class="form-check-label" for="{{ $item->stock_list_id }}"></label>
                                                        </div>
                                                    </td>
                                                    <td class="text-center" style="color:rgb(29, 102, 185)" width="5%">
                                                        <div class="dropdown">
                                                            <button class="btn btn-sm active_4c dropdown-toggle menu" type="button"
                                                                data-bs-toggle="dropdown" aria-expanded="false">ทำรายการ</button>
                                                            <ul class="dropdown-menu">

                                                                <a class="dropdown-item menu fontbtn" href="{{ url('wh_confix_store_edit/' . $item->stock_list_id) }}"
                                                                    data-bs-toggle="tooltip" data-bs-placement="left"
                                                                    data-bs-custom-class="custom-tooltip" title="แก้ไขรายการ" style="color: rgb(255, 141, 34)">
                                                                    <img src="{{ asset('images/Edit_Pen.png') }}" height="15px" width="15px">
                                                                    แก้ไขรายการ
                                                                </a>
                                                            </ul>
                                                        </div>
                                                    </td>
                                                </tr>
                                        @endforeach

                                    </tbody>

                                </table>
                            </div>
                        </div>
                    </div>

                </div>

                 <!--  Modal content forRecieve -->
                <!-- <div class="modal fade" id="Request" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="text-center" style="color:rgb(236, 105, 18);">เพิ่มคลังพัสดุ </h4>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-2 text-end">ชื่อคลังพัสดุ</div>
                                    <div class="col-md-10">
                                        <div class="form-group">
                                            <input type="text" class="form-control-sm d12font input_border" id="stock_list_name" name="stock_list_name" style="width: 100%">
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-md-2 text-end">ผู้สั่งจ่าย</div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <select name="userid" id="userid"  class="custom-select custom-select-sm" style="width: 100%">
                                                <option value="">--เลือก--</option>
                                                @foreach ($users as $item_)
                                                    <option value="{{$item_->id}}">{{$item_->fname}}  {{$item_->lname}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2 text-end">ผู้จ่าย</div>
                                    <div class="col-md-4 text-start">
                                        <div class="form-group">
                                            <select name="userpay" id="userpay"  class="custom-select custom-select-sm" style="width: 100%">
                                                <option value="">--เลือก--</option>
                                                @foreach ($users as $item_)
                                                    <option value="{{$item_->id}}">{{$item_->fname}}  {{$item_->lname}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <input type="hidden" id="bg_yearnow" name="bg_yearnow">
                            </div>
                            <div class="modal-footer">
                                <div class="col-md-12 text-center">
                                    <div class="form-group">
                                        <button type="button" id="AddSupplies" class="ladda-button me-2 btn-pill btn btn-sm btn-success active_4c" >
                                            <img src="{{ asset('images/Savewhit.png') }}" class="me-2 ms-2" height="18px" width="18px">
                                            บันทึก
                                        </button>
                                        <button type="button" class="ladda-button me-2 btn-pill btn btn-sm btn-danger active_4c" data-bs-dismiss="modal">
                                            <img src="{{ asset('images/back.png') }}" class="me-2 ms-2" height="18px" width="18px">
                                            Close
                                        </button>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>  -->

            </div>
        </div>
    </div>


    </div>

@endsection
@section('footer')
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.2.0/dist/chartjs-plugin-datalabels.min.js"> </script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns@3.0.0/dist/chartjs-adapter-date-fns.bundle.min.js"></script>
    <script>
        var Linechart;

        function switchactive(idfunc){
            var checkBox = document.getElementById(idfunc);
            var onoff;
            if (checkBox.checked == true){
                onoff = "Y";
            } else {
                onoff = "N";
            }
            var _token=$('input[name="_token"]').val();
            $.ajax({
                    url:"{{route('wh.wh_confix_storeswitch')}}",
                    method:"GET",
                    data:{onoff:onoff,idfunc:idfunc,_token:_token}
            })
        }
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

            // $('#userid').select2({
            //     dropdownParent: $('#Request')
            // });
            // $('#userpay').select2({
            //     dropdownParent: $('#Request')
            // });
            $('#userid').select2({
                placeholder: "--เลือกผู้สั่งจ่าย--",
                allowClear: true
            });
            $('#userpay').select2({
                placeholder: "--เลือกผู้จ่าย--",
                allowClear: true
            });
            $('#p4p_work_monthdd').select2({
                placeholder: "--เลือก--",
                allowClear: true
            });

            $('#UpdateData').click(function() {
                var stock_list_id       = $('#stock_list_id').val();
                var stock_list_name     = $('#stock_list_name').val();
                var userid              = $('#userid').val();
                var userpay             = $('#userpay').val();
                $.ajax({
                    url: "{{ route('wh.wh_confix_store_update') }}",
                    type: "POST",
                    dataType: 'json',
                    data: {stock_list_name,userid,userpay,stock_list_id},
                    success: function(data) {
                        if (data.status == 200) {
                            Swal.fire({ position: "top-end",
                                title: 'บันทึกข้อมูลสำเร็จ',
                                text: "You Save data success",
                                icon: 'success',
                                showCancelButton: false,
                                confirmButtonColor: '#06D177',
                                confirmButtonText: 'เรียบร้อย'
                            }).then((result) => {
                                if (result
                                    .isConfirmed) {
                                    console.log(
                                        data);
                                    // window.location.reload();
                                    window.location="{{url('wh_confix_store')}}";
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
            });
        });
    </script>


@endsection
