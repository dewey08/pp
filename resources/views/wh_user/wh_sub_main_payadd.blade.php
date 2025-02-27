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

            <div class="row mt-2">
                <div class="col-md-8">
                    <h5 style="color:rgb(236, 105, 18)">ตัดจ่ายรายการพัสดุ || เลขที่บิล {{ $data_edit->pay_no }} </h5>
                </div>
                <div class="col"></div>
                <div class="col-md-3 text-end">
                    {{-- <a href="{{url('wh_recieve_add')}}" class="ladda-button me-2 btn-pill btn btn-sm btn-success input_new" target="_blank">
                        <i class="fa-solid fa-clipboard-check text-white me-2 ms-2"></i>
                        ตรวจรับ
                    </a>  --}}
                    <button type="button" id="UpdateData" class="ladda-button me-2 btn-pill btn btn-sm btn-success card_prs_4" >
                        <i class="fa-solid fa-pen-to-square text-white me-2 ms-2"></i>
                       บันทึก
                   </button>
                   <a href="{{url('wh_sub_main_pay')}}" class="ladda-button me-2 btn-pill btn btn-sm btn-danger card_prs_4"> <i class="fa-solid fa-xmark text-white me-2 ms-2"></i>ยกเลิก</a>
                </div>
            </div>



            <div class="row mt-3">
                <div class="col-md-12">
                    <div class="card card_prs_4">
                        <div class="card-body">
                            <input type="hidden" id="wh_pay_id" name="wh_pay_id" value="{{$wh_pay_id}}">
                            <input type="hidden" id="data_year" name="data_year" value="{{$data_year}}">
                            <input type="hidden" id="supsup_id" name="supsup_id" value="{{$supsup_id}}">


                    <hr>
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-xl-7">
                                            <table class="table table-bordered border-primary table-hover table-sm" style="border-collapse: collapse;border-spacing: 0; width: 100%;">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-center" style="background-color: rgb(255, 251, 228);font-size: 12px;">ลำดับ</th>
                                                            <th class="text-center" style="background-color: rgb(174, 236, 245);font-size: 12px;">รายการ</th>
                                                            <th class="text-center" style="background-color: rgb(174, 236, 245);font-size: 12px;">หน่วยนับ</th>
                                                            <th class="text-center" style="background-color: rgb(187, 250, 221);font-size: 12px;">Stock(จำนวน)</th>
                                                            <th class="text-center" style="background-color: rgb(222, 201, 248);font-size: 12px;" width="7%">เลือก LOT</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $i = 0;$total1 = 0; $total2 = 0;$total3 = 0;$total4 = 0;$total5 = 0;$total6 = 0;$total7 = 0;$total8 = 0;$total9 = 0; ?>
                                                        @foreach ($wh_stock as $item)
                                                        <?php $i++ ?>
                                                            @if ($item->totall_all > 0 || $item->total_pay == '')
                                                                    <tr id="tr_{{$item->wh_stock_sub_id}}">
                                                                        <td class="text-center" width="5%">{{$i}}</td>
                                                                        <td class="text-start" style="color:rgb(3, 93, 145)">{{$item->pro_code}} {{$item->pro_name}}</td>
                                                                        <td class="text-center" style="color:rgb(3, 93, 145)" width="10%">{{$item->unit_name}}</td>
                                                                        <td class="text-center" style="color:rgb(3, 93, 145)" width="10%">
                                                                            @if ($item->total_pay == '')
                                                                                {{$item->total_rep}}
                                                                            @else
                                                                                {{$item->totall_all}}
                                                                            @endif
                                                                        </td>
                                                                        <td class="text-center" style="color:rgb(3, 93, 145)" width="7%">
                                                                            <button type="button" class="btn btn-outline-primary btn-sm addsuppay"
                                                                            value="{{ $item->pro_id }}"
                                                                            >เลือก</button>
                                                                        </td>
                                                                    </tr>
                                                            @endif


                                                        @endforeach
                                                    </tbody>

                                            </table>
                                        </div>
                                        <div class="col-xl-5">
                                            <div id="getdata_show"></div>
                                            {{-- <table id="Tabledit" class="table table-bordered border-primary table-hover table-sm" style="border-collapse: collapse;border-spacing: 0; width: 100%;">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center" style="background-color: rgb(255, 251, 228);font-size: 12px;">ลำดับ</th>
                                                        <th class="text-center" style="background-color: rgb(174, 236, 245);font-size: 12px;">รหัส</th>
                                                        <th class="text-center" style="background-color: rgb(174, 236, 245);font-size: 12px;">รายการ</th>
                                                        <th class="text-center" style="background-color: rgb(174, 236, 245);font-size: 12px;">หน่วยนับ</th>
                                                        <th class="text-center" style="background-color: rgb(250, 194, 187);font-size: 12px;">lot_no</th>
                                                        <th class="text-center" style="background-color: rgb(187, 250, 221);font-size: 12px;">ตัดจ่าย(จำนวน)</th>
                                                        <th width="5%" class="text-center"><input type="checkbox" class="dcheckbox" name="stamp" id="stamp"> </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $i = 0;$total1 = 0; $total2 = 0;$total3 = 0;$total4 = 0;$total5 = 0;$total6 = 0;$total7 = 0;$total8 = 0;$total9 = 0; ?>
                                                    @foreach ($wh_pay_sub as $item)
                                                    <?php $i++ ?>
                                                        <tr id="tr_{{$item->wh_pay_sub_id}}">
                                                            <td class="text-center" width="5%">{{$i}}</td>
                                                            <td class="text-start" style="color:rgb(3, 93, 145)" width="3%">{{$item->wh_pay_sub_id}}</td>
                                                            <td class="text-start" style="color:rgb(3, 93, 145)">{{$item->pro_code}} {{$item->pro_name}}</td>
                                                            <td class="text-center" style="color:rgb(3, 93, 145)" width="10%">{{$item->unit_name}}</td>
                                                            <td class="text-center" style="color:rgb(3, 93, 145)" width="13%">{{$item->lot_no}}</td>
                                                            <td class="text-center" style="color:rgb(3, 93, 145)" width="10%">{{$item->qty}}</td>
                                                            <td class="text-center" width="5%"><input type="checkbox" class="dcheckbox sub_chk" data-id="{{$item->wh_pay_sub_id}}"> </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>     --}}
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>






                    </div>
                </div>
            </div>

            {{-- addsuppayModal --}}

            {{-- <div class="modal fade" id="addsuppay" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" > --}}
                <div class="modal fade" id="addsuppayModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" >
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h2 class="modal-title"
                                style="font-family: 'Kanit', sans-serif; font-size:14px;font-size: 1.5rem;font-weight:normal;">
                                เลือกวัสดุที่ต้องการตัด</h2>
                        </div>
                        <div class="modal-body">

                            <body>
                                <div class="container mt-3">
                                    <input class="form-control" id="myInput" type="text" placeholder="Search..">
                                    <br>
                                    <div style='overflow:scroll; height:300px;'>

                                        <div id="getdetailselectpay"></div>

                                    </div>
                                </div>
                        </div>
                        <div class="modal-footer">
                            <div align="right">
                                <button type="button" class="ladda-button me-2 btn-pill btn btn-sm btn-danger input_new" data-bs-dismiss="modal"> <i
                                        class="fa-solid fa-xmark me-2"></i>ปิดหน้าต่าง</button>

                            </div>
                        </div>
                            </body>
                    </div>
            </div>
        </div>

</div>




@endsection
@section('footer')

    <script>
        var Linechart;
        function getdetailselectpay(count) {
                var wh_pay_id = document.getElementById("wh_pay_id").value;
                $.ajax({
                    url: "{{ route('wh.wh_subpay_select_lot') }}", //wh.wh_pay_select_lot
                    method: "GET",
                    data: {
                        wh_pay_id: wh_pay_id,
                        count: count
                    },
                    success: function(result) {
                        $('#getdetailselectpay').html(result);
                    }
                })
        }


        function selectsuppay(wh_stock_dep_sub_id, count) {
            var wh_pay_id         = document.getElementById("wh_pay_id").value;
            var qty_sub_pay       = document.getElementById("qty_sub_pay"+wh_stock_dep_sub_id).value;

            var _token = $('input[name="_token"]').val();
            $.ajax({
                url: "{{ route('wh.wh_subpay_select_lotsave') }}",
                method: "POST",
                data: {
                    wh_stock_dep_sub_id: wh_stock_dep_sub_id,wh_pay_id:wh_pay_id,qty_sub_pay:qty_sub_pay,count: count,
                    _token: _token
                },
                success: function(result) {
                    if (result.status == 200) {
                        // window.location.reload();
                        load_data_table_pay();
                    } else {
                    }
                }
            })
            $('#addsuppayModal').modal('hide');
        }

        load_data_table_pay();
        function load_data_table_pay() {
                    var wh_pay_id = document.getElementById("wh_pay_id").value;
                    // alert(wh_pay_id);
                    var _token=$('input[name="_token"]').val();
                    $.ajax({
                            url:"{{route('wh.load_data_table_pay')}}",
                            method:"GET",
                            data:{wh_pay_id:wh_pay_id,_token:_token},
                            success:function(result){
                                $('#getdata_show').html(result);
                            }
                    });
        }

        function whsubpay_destroy(wh_stock_dep_sub_export_id, count) {
            var _token = $('input[name="_token"]').val();
            $.ajax({
                url: "{{ route('wh.wh_sub_pay_destroy') }}",
                method: "POST",
                data: {
                    wh_stock_dep_sub_export_id: wh_stock_dep_sub_export_id,count: count,
                    _token: _token
                },
                success: function(result) {
                    if (result.status == 200) {
                        load_data_table_pay();
                    }
                }
            })

        }


        $(document).on('click', '.addsuppay', function() {
                var pro_id = $(this).val();
                var wh_pay_id = document.getElementById("wh_pay_id").value;
                // alert(pro_id);
                $('#addsuppayModal').modal('show');
                $.ajax({
                    type: "GET",
                    url:"{{ url('wh_subpay_select_lot') }}",
                    data: { pro_id: pro_id,wh_pay_id: wh_pay_id},
                    success: function(result) {
                        $('#getdetailselectpay').html(result);
                    },
                });
            });
        $(document).ready(function() {
            $("#myInput").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("#myTable tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
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

            $('.Destroystamp').on('click', function(e) {
                alert('oo');
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
                                                    //         console.log(data);
                                                    load_data_table_pay();
                                                            // window.location.reload();
                                                            // $('#spinner').hide();//Request is complete so hide spinner
                                                        // setTimeout(function(){
                                                        //     $("#overlay").fadeOut(300);
                                                        // },500);
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
                // var recieve_no    = $('#recieve_no').val();
                // var recieve_date  = $('#datepicker').val();
                // var recieve_time  = $('#recieve_time').val();
                // var supsup_id     = $('#supsup_id').val();
                // var stock_list_id    = $('#stock_list_id').val();
                // var data_year        = $('#data_year').val();
                var wh_pay_id    = $('#wh_pay_id').val();

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
                                    // url: "{{ route('wh.wh_sub_main_paysub_update') }}",
                                    url: "{{ route('wh.wh_sub_main_paysub_savenew') }}",
                                    type: "POST",
                                    dataType: 'json',
                                    data: {wh_pay_id},
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
                                                    window.location="{{url('wh_sub_main_pay')}}";
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

            // $('#Tabledit').Tabledit({
            //     url:'{{route("wh.wh_sub_main_payedittable")}}',

            //     dataType:"json",
            //     removeButton: false,
            //     columns:{
            //         identifier:[1,'wh_pay_sub_id'],
            //         editable: [ [5, 'qty']]
            //     },
            //     deleteButton: false,
            //     saveButton: true,
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
