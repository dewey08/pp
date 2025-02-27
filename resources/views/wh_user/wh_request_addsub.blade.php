@extends('layouts.user_layout')
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
        {{-- <div class="container">  --}}
            <div class="container-fluid fixed-top">
                <br><br>
                <div class="row mt-5">
                    {{-- <div class="col-md-6">
                        <h4 style="color:rgb(2, 94, 148)">เพิ่มรายการพัสดุ || เลขที่บิล {{ $data_edit->request_no }}</h4>
                    </div> --}}
                    <div class="col"></div>
                    <div class="col-md-5 text-end">
                         <button class="me-2 btn-icon btn-icon-only btn btn-link btn-sm card_red_4" data-bs-toggle="collapse" data-bs-target="#collapseOne2" aria-expanded="false" aria-controls="collapseTwo" class="btn-icon btn-shadow btn-dashed btn btn-outline-secondary">
                            <img src="{{ asset('images/Shopping_Cart.png') }}"  class="me-3 ms-3 mt-2 mb-2" height="30px" width="30px">
                            <span class="badge rounded-pill bg-success load_total" style="font-size: 19px;">0</span>
                        </button>
                        <button type="button" id="UpdateData" class="ladda-button me-2 btn-pill btn btn-success card_prs_4" >
                            <img src="{{ asset('images/Savewhit.png') }}" class="me-2 ms-2" height="18px" width="18px">
                           บันทึก
                       </button>
                        {{-- <a href="{{url('wh_sub_main_rp')}}" class="ladda-button me-2 btn-pill btn btn-danger card_prs_4">
                            <img src="{{ asset('images/back.png') }}" class="me-2 ms-2" height="18px" width="18px">
                            ยกเลิก
                        </a> --}}
                        <a href="{{url('wh_sub_main_rp')}}" class="ladda-button me-2 btn-pill btn btn-danger card_prs_4">
                            <img src="{{ asset('images/Arrow_Return2.png') }}" class="me-2 ms-2" height="18px" width="18px">
                            ย้อนกลับ
                        </a>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-4">
                        <h4 style="color:rgb(2, 94, 148)">เพิ่มรายการพัสดุ || เลขที่บิล {{ $data_edit->request_no }}</h4>
                    </div>
                    <div class="col text-end">
                    </div>
                </div>

            {{-- <div class="row mt-2">
                <div class="col-md-8">
                    <h4 style="color:rgb(2, 94, 148)">เพิ่มรายการพัสดุ || เลขที่บิล {{ $data_edit->request_no }}</h4>
                </div>
                <div class="col"></div>
                <div class="col-md-3 text-end">

                    <button type="button" id="UpdateData" class="ladda-button me-2 btn-pill btn btn-sm btn-success card_prs_4" >
                        <img src="{{ asset('images/Savewhit.png') }}" class="me-2 ms-2" height="18px" width="18px">
                       บันทึก
                   </button>
                   <a href="{{url('wh_sub_main_rp')}}" class="ladda-button me-2 btn-pill btn btn-sm btn-danger card_prs_4">
                    <img src="{{ asset('images/back.png') }}" class="me-2 ms-2" height="18px" width="18px">
                    ยกเลิก</a>
                </div>
            </div> --}}




            <div class="row mt-3">
                <div class="col-md-12">
                    <div class="card card_prs_4" style="background-color: rgb(238, 252, 255)">
                        <div class="card-body">

                            <div class="row mt-2">
                                <div class="col-md-2 text-end">รายการวัสดุ</div>
                                <div class="col-md-5">
                                    <select name="pro_id" id="pro_id"  class="custom-select custom-select-sm" style="width: 100%" onchange="pro_Sub()">
                                            <option value="">--เลือก--</option>
                                            @foreach ($wh_product as $item_sup)
                                                <?php
                                                    $count_proid = DB::select('SELECT COUNT(pro_id) Cpro_id FROM wh_request_sub WHERE pro_id = "'.$item_sup->pro_id.'" AND wh_request_id = "'.$wh_request_id.'"');
                                                    foreach ($count_proid as $key => $value) {
                                                        $countproid   =  $value->Cpro_id;
                                                    }
                                                ?>
                                                {{-- @if ($countproid < 1 || $countproid == '') --}}
                                                <option value="{{$item_sup->pro_id}}">{{$item_sup->pro_code}} || {{$item_sup->pro_name}} || {{$item_sup->wh_unit_pack_qty}} / {{$item_sup->unit_name}} || {{$item_sup->wh_type_name}}</option>
                                                {{-- @else --}}

                                                {{-- @endif --}}
                                            @endforeach
                                    </select>
                                </div>
                                {{-- <div class="col-md-2">
                                    <div id="show_detail" ></div>
                                </div> --}}
                                <div class="col-md-2 text-start">
                                    <input type="text" class="form-control form-control-sm" id="qty" name="qty" placeholder="จำนวน">
                                </div>

                                <div class="col-md-1 text-start">

                                   <button type="button" id="Addproduct" class="ladda-button me-2 btn-pill btn btn-sm btn-success input_new" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" title="เพิ่มรายการวัสดุลงใน List">

                                        <img src="{{ asset('images/Addwhite.png') }}" class="me-2 ms-2" height="18px" width="18px">
                                 </button>
                                </div>
                                <div class="col"></div>
                                <div class="col-md-1 text-center">
                                    <button type="button" class="ladda-button me-2 btn-pill btn btn-sm btn-danger card_prs_4 Destroystamp" data-url="{{url('wh_request_destroy')}}">
                                        <img src="{{ asset('images/removewhite.png') }}" class="me-2 ms-2" height="18px" width="18px">
                                    </button>
                                </div>
                                {{-- <div class="col-md-1">
                                        <input type="text" class="form-control form-control-sm text-center input_new" id="gettotal_show" name="gettotal_show" style="background-color: #cafdec;color:rgb(238, 15, 89);font-size:15px;width: 100%">

                                </div>
                                <div class="col-md-1 text-start mt-2">รายการ</div> --}}
                            </div>

                            <input type="hidden" id="wh_request_id" name="wh_request_id" value="{{$wh_request_id}}">
                            <input type="hidden" id="stock_list_id" name="stock_list_id" value="{{$stock_list_id}}">
                            <input type="hidden" id="data_year" name="data_year" value="{{$data_year}}">
                            <input type="hidden" id="stock_list_subid" name="stock_list_subid" value="{{$supsup_id}}">


                    <hr>
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-xl-12">

                                            <div id="gettable_show"></div>

                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>






                    </div>
                </div>
            </div>



        {{-- </div> --}}

</div>




@endsection
@section('footer')

    <script>
        var Linechart;
        function pro_Sub() {
            var pro_id = document.getElementById("pro_id").value;
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url: "{{url('wh_request_addsubdetail')}}",
                    method: "GET",
                    data: {pro_id: pro_id,_token: _token
                    },
                    success: function (result) {

                        $('#show_detail').html(result);
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
            load_datauser_table();
            load_data_usersum();
            wh_loadtotal();
            function load_datauser_table() {
                    var wh_request_id = document.getElementById("wh_request_id").value;
                    // alert(wh_recieve_id);
                    var _token=$('input[name="_token"]').val();
                    $.ajax({
                            url:"{{route('wh.load_datauser_table')}}",
                            method:"GET",
                            data:{wh_request_id:wh_request_id,_token:_token},
                            success:function(result){
                                $('#gettable_show').html(result);
                            }
                    });
            }
            function load_data_usersum() {
                    var wh_request_id = document.getElementById("wh_request_id").value;
                    // alert(wh_recieve_id);
                    var _token=$('input[name="_token"]').val();
                    $.ajax({
                            url:"{{route('wh.load_data_usersum')}}",
                            method:"GET",
                            data:{wh_request_id:wh_request_id,_token:_token},
                            success:function(result){
                                $('#gettotal_show').val(result.total)
                            }
                    });
            }
            function wh_loadtotal() {
                    var wh_request_id = document.getElementById("wh_request_id").value;
                    // alert(wh_recieve_id);
                    var _token=$('input[name="_token"]').val();
                    $.ajax({
                            url:"{{route('wh.wh_loadtotal')}}",
                            method:"GET",
                            data:{wh_request_id:wh_request_id,_token:_token},
                            success:function(data){
                                // $('#load_total').val(data.total)
                                $('.load_total').text(data.total);
                                // $('.badge').text(data.total_item);
                            }
                    });
            }

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
                                                    // $(".sub_destroy:checked").each(function () {
                                                    $(".sub_chk:checked").each(function () {
                                                        $(this).parents("tr").remove();
                                                    });
                                                    // Swal.fire({ position: "top-end",
                                                    //     title: 'ลบข้อมูลสำเร็จ',
                                                    //     text: "You Delete data success",
                                                    //     icon: 'success',
                                                    //     showCancelButton: false,
                                                    //     confirmButtonColor: '#06D177',
                                                    //     confirmButtonText: 'เรียบร้อย'
                                                    // }).then((result) => {
                                                    //     if (result
                                                    //         .isConfirmed) {
                                                    //         console.log(
                                                    //             data);
                                                    //         // window.location.reload();
                                                            wh_loadtotal();
                                                            load_datauser_table();
                                                            load_data_usersum();
                                                            $('#qty').val("");

                                                    //     }
                                                    // })
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
                var supsup_id        = $('#supsup_id').val();
                // var stock_list_id    = $('#stock_list_id').val();
                var data_year        = $('#data_year').val();
                var wh_request_id    = $('#wh_request_id').val();

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
                                    url: "{{ route('wh.wh_request_updatestock') }}",
                                    type: "POST",
                                    dataType: 'json',
                                    data: {data_year,wh_request_id,supsup_id},
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
                                                    window.location="{{url('wh_sub_main_rp')}}";
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

            $('#Addproduct').click(function() {
                var pro_id              = $('#pro_id').val();
                var qty                 = $('#qty').val();
                // var one_price        = $('#one_price').val();
                // var lot_no           = $('#lot_no').val();
                var stock_list_id       = $('#stock_list_id').val();
                var wh_request_id       = $('#wh_request_id').val();
                var stock_list_subid    = $('#stock_list_subid').val();
                var data_year           = $('#data_year').val();
                // var pro_color           = $('#pro_color').val();
                // var pro_brand           = $('#pro_brand').val();
                // alert(pro_brand);
                        $.ajax({
                            url: "{{ route('wh.wh_request_addsub_save') }}",
                            type: "POST",
                            dataType: 'json',
                            data: {pro_id,qty,wh_request_id,stock_list_id,data_year,stock_list_subid},
                            success: function(data) {
                                load_datauser_table();
                                load_data_usersum();
                                wh_loadtotal();
                                $('#qty').val("");
                                // $('#pro_id').val("");

                            },
                        });

                    // }
                // })
            });

            // $('#Tabledit').Tabledit({
            //     url:'{{route("wh.wh_request_edittable")}}',

            //     dataType:"json",
            //     removeButton: false,
            //     columns:{
            //         identifier:[1,'wh_request_sub_id'],
            //         editable: [ [5, 'qty']]
            //     },
            //     deleteButton: false,
            //     saveButton: false,
            //     autoFocus: false,
            //     buttons: {
            //         edit: {
            //             class:'btn btn-sm btn-default',
            //             html: '<i class="fa-regular fa-pen-to-square text-danger"></i>',
            //             action: 'Edit'
            //         }
            //     },
            //     onSuccess:function(data)
            //     {
            //        if (data.status == 200) {
            //             Swal.fire({
            //                 position: "top-end",
            //                 icon: "success",
            //                 title: "Your Edit Success",
            //                 showConfirmButton: false,
            //                 timer: 1500
            //                 });
            //                 window.location.reload();
            //        } else {
            //        }
            //     }

            // });

        });
    </script>


@endsection
