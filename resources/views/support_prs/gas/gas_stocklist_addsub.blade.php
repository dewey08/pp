@extends('layouts.support_prs_gas')
@section('title', 'PK-OFFICE || Support-System')

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
        {{-- <div class="container">  --}}

            <div class="row">
                <div class="col-md-7">
                    <h5 style="color:rgb(236, 105, 18)">เพิ่มรายการ || เลขที่บิล {{ $data_edit->recieve_no }} || บริษัท {{ $supplies_name }} </h5>
                </div>
                <div class="col"></div>
                <div class="col-md-4 text-end">

                    <button type="button" id="UpdateData" class="ladda-button me-2 btn-pill btn btn-sm btn-success input_new" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" title="บันทึกรายการทั้งหมดเข้าคลัง">

                        <img src="{{ asset('images/Savewhit.png') }}" class="me-2 ms-2" height="18px" width="18px">
                       บันทึก
                   </button>
                   <a href="{{url('wh_recieve')}}" class="ladda-button me-2 btn-pill btn btn-sm btn-danger input_new" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" title="ยกเลิก">

                    <img src="{{ asset('images/back.png') }}" class="me-2 ms-2" height="18px" width="18px">
                    ยกเลิก</a>

                </div>
            </div>

            <div class="row mt-2">
                <div class="col-md-12">
                    <div class="card card_audit_4c">
                        <div class="card-body">
                            <div class="row mt-2">
                                <div class="col-md-1 text-end">รายการวัสดุ</div>
                                <div class="col-md-3">
                                    <select name="pro_id" id="pro_id"  class="custom-select custom-select-sm show_pro" style="width: 100%">
                                        <option value="">--เลือก--</option>
                                            @foreach ($wh_product as $item_sup)

                                                 <option value="{{$item_sup->gas_list_id}}">{{$item_sup->gas_list_num}} || {{$item_sup->gas_list_name}}</option>

                                            @endforeach
                                    </select>
                                </div>
                                <div class="col-md-1 text-start">
                                    <input type="text" class="form-control-sm input_border" id="qty" name="qty" placeholder="จำนวน" style="width: 100%">
                                </div>
                                <div class="col-md-2 text-start">
                                    <input type="text" class="form-control-sm input_border" id="one_price" name="one_price" placeholder="ราคา" style="width: 100%">
                                </div>
                                <div class="col-md-1 text-end">LOT</div>
                                <div class="col-md-2 text-start">
                                    <input type="text" class="form-control-sm input_border" id="lot_no" name="lot_no" placeholder="LOT" style="width: 100%">
                                </div>
                                <div class="col-md-2 text-start">
                                    <button type="button" id="Addproduct" class="ladda-button me-2 btn-pill btn btn-sm btn-success input_new" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" title="เพิ่มรายการวัสดุลงใน List">

                                          <img src="{{ asset('images/Addwhite.png') }}" class="me-2 ms-2" height="18px" width="18px">
                                   </button>
                                   <button type="button" class="ladda-button me-2 btn-pill btn btn-sm btn-danger input_new Destroystamp" data-url="{{url('gas_stocklist_destrouy')}}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" title="ลบรายการที่เลือก">

                                        <img src="{{ asset('images/removewhite.png') }}" class="me-2 ms-2" height="18px" width="18px">
                                    </button>
                                </div>
                            </div>
                            <input type="hidden" id="wh_recieve_id" name="wh_recieve_id" value="{{$wh_recieve_id}}">
                            <input type="hidden" id="stock_list_id" name="stock_list_id" value="{{$stock_list_id}}">
                            <input type="hidden" id="data_year" name="data_year" value="{{$data_year}}">


                        <hr>

                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-xl-12">

                                            <div id="getdata_show"></div>

                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>


</div>




@endsection
@section('footer')

    <script>
        var Linechart;
        function add_product() {
            var pros_name     = document.getElementById("PROS_NAME").value;
            var stock_list_id = document.getElementById("stock_list_id").value;
            var data_year     = document.getElementById("data_year").value;
            var pro_type      = document.getElementById("pro_type").value;
            var wh_unit_id       = document.getElementById("wh_unit_id").value;
            var _token        = $('input[name="_token"]').val();
                $.ajax({
                    url: "{{url('add_product')}}",
                    method: "GET",
                    data: {
                        pros_name: pros_name,stock_list_id:stock_list_id,data_year:data_year,pro_type:pro_type,wh_unit_id:wh_unit_id,
                        _token: _token
                    },
                    success: function (result) {
                        $('.show_pro').html(result);
                    }
                })
        }
        function addwh_unit() {
            var unitnew = document.getElementById("UNIT_NAME").value;
            // alert(unitnew);
            var _token = $('input[name="_token"]').val();
            $.ajax({
                url: "{{url('addwh_unitt')}}",
                method: "GET",
                data: {
                    unitnew: unitnew,
                    _token: _token
                },
                success: function (result) {
                    $('.show_unit').html(result);
                }
            })
        }
        $(document).ready(function() {
            $('select').select2();
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

            $('#stamp').on('click', function(e) {
                    if($(this).is(':checked',true))
                    {
                        $(".sub_chk").prop('checked', true);
                    } else {
                        $(".sub_chk").prop('checked',false);
                    }
            });
            $("#spinner-div").hide(); //Request is complete so hide spinner

            load_gasdata_table();
            load_gasdata_lot_no();
            load_gasdata_sum();

            function load_gasdata_table() {
                    var wh_recieve_id = document.getElementById("wh_recieve_id").value;
                    // alert(wh_recieve_id);
                    var _token=$('input[name="_token"]').val();
                    $.ajax({
                            url:"{{route('prs.load_gasdata_table')}}",
                            method:"GET",
                            data:{wh_recieve_id:wh_recieve_id,_token:_token},
                            success:function(result){
                                $('#getdata_show').html(result);

                            }
                    });
            }
            function load_gasdata_lot_no() {
                    var wh_recieve_id = document.getElementById("wh_recieve_id").value;
                    // alert(wh_recieve_id);
                    var _token=$('input[name="_token"]').val();
                    $.ajax({
                            url:"{{route('prs.load_gasdata_lot_no')}}",
                            method:"GET",
                            data:{wh_recieve_id:wh_recieve_id,_token:_token},
                            success:function(result){
                                $('#lot_no').val(result.lot_no)
                            }
                    });
            }
            function load_gasdata_sum() {
                    var wh_recieve_id = document.getElementById("wh_recieve_id").value;
                    // alert(wh_recieve_id);
                    var _token=$('input[name="_token"]').val();
                    $.ajax({
                            url:"{{route('prs.load_gasdata_sum')}}",
                            method:"GET",
                            data:{wh_recieve_id:wh_recieve_id,_token:_token},
                            success:function(result){
                                $('#gettotal_show').val(result.total)
                            }
                    });
            }

            $('#Addproduct').click(function() {
                var pro_id           = $('#pro_id').val();
                var qty              = $('#qty').val();
                var one_price        = $('#one_price').val();
                var lot_no           = $('#lot_no').val();
                var stock_list_id    = $('#stock_list_id').val();
                var wh_recieve_id    = $('#wh_recieve_id').val();
                var data_year        = $('#data_year').val();

                        $.ajax({
                            url: "{{ route('prs.gas_stocklist_addsub_save') }}",
                            type: "POST",
                            dataType: 'json',
                            data: {pro_id,qty,one_price,lot_no,wh_recieve_id,stock_list_id,data_year},
                            success: function(data) {
                                load_gasdata_table();
                                load_gasdata_lot_no();
                                load_gasdata_sum();
                                $('#qty').val("");
                                $('#one_price').val("");
                                $('#pro_id').val("");
                                if (data.status == 200) {

                                } else {

                                }
                            },
                        });

            });

            $('.Destroystamp').on('click', function(e) {
                // alert('oo');
                var allValls = [];
                // $(".sub_destroy:checked").each(function () {
                $(".sub_chk:checked").each(function () {
                    allValls.push($(this).attr('data-id'));
                });
                if (allValls.length <= 0) {
                    // alert("SSSS");
                    Swal.fire({ position: "top-end",
                        title: 'คุณยังไม่ได้เลือกรายการ ?',
                        text: "กรุณาเลือกรายการก่อน",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        }).then((result) => {

                        })
                } else {
                    Swal.fire({ position: "top-end",
                        title: 'Are you Want Delete sure?',
                        text: "คุณต้องการลบรายการนี้ใช่ไหม!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, Delete it.!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                var check = true;
                                if (check == true) {
                                    var join_selected_values = allValls.join(",");
                                    // alert(join_selected_values);
                                    // $("#overlay").fadeIn(300);　
                                    // $("#spinner").show(); //Load button clicked show spinner

                                    $.ajax({
                                        url:$(this).data('url'),
                                        type: 'POST',
                                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                        data: 'ids='+join_selected_values,
                                        success:function(data){
                                                if (data.status == 200) {
                                                    $(".sub_chk:checked").each(function () {
                                                        $(this).parents("tr").remove();
                                                    });
                                                    load_gasdata_table();
                                                    load_gasdata_lot_no();
                                                    load_gasdata_sum();
                                                    $('#qty').val("");
                                                    $('#one_price').val("");
                                                    $('#pro_id').val("");

                                                } else {

                                                }

                                        }
                                    });
                                    $.each(allValls,function (index,value) {
                                        $('table tr').filter("[data-row-id='"+value+"']").remove();
                                    });
                                }
                            }
                        })
                    // var check = confirm("Are you want ?");
                }
            });

            $('#UpdateData').click(function() {
                var stock_list_id    = $('#stock_list_id').val();
                var data_year        = $('#data_year').val();
                var wh_recieve_id    = $('#wh_recieve_id').val();

                Swal.fire({ position: "top-end",
                        title: 'ต้องการบันทึกข้อมูลใช่ไหม ?',
                        text: "You Warn Save Data!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, Save it!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $("#overlay").fadeIn(300);　
                                $("#spinner").show(); //Load button clicked show spinner

                                $.ajax({
                                    url: "{{ route('prs.gas_stocklist_updatestock') }}",
                                    type: "POST",
                                    dataType: 'json',
                                    data: {data_year,wh_recieve_id,stock_list_id},
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
                                                    window.location="{{url('gas_stocklist')}}";
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
    </script>


@endsection
