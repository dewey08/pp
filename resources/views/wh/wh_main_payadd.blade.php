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
       
            <div class="row"> 
                <div class="col-md-8"> 
                    {{-- <h5 style="color:rgb(236, 105, 18)">รายการพัสดุที่ขอเบิก => เลขที่บิล {{ $data_edit->request_no }} || เบิกจากคลัง {{ $stock_name }} => เข้าคลัง {{ $supsup_name }}</h5>  --}}
                    <h5 style="color:rgb(236, 105, 18)">รายการพัสดุที่ขอเบิก => เลขที่บิล {{ $data_edit->request_no }} || => เข้าคลัง {{ $supsup_name }}</h5> 
                </div>
                <div class="col"></div>   
                <div class="col-md-2 text-end"> 
                    <button type="button" id="UpdateData" class="ladda-button me-2 btn-pill btn btn-sm btn-success input_new" > 
                        <img src="{{ asset('images/Savewhit.png') }}" class="me-2 ms-2" height="18px" width="18px"> 
                       บันทึก
                   </button>
                   <a href="{{url('wh_main_pay')}}" class="ladda-button me-2 btn-pill btn btn-sm btn-danger input_new"> 
                     <img src="{{ asset('images/back.png') }}" class="me-2 ms-2" height="18px" width="18px"> 
                     ยกเลิก</a>
                </div>
            </div> 

         
            <div class="row mt-3">
                <div class="col-md-12">                
                    <div class="card card_audit_4c">   
                        <div class="card-body"> 
                              
                            <input type="hidden" id="wh_request_id" name="wh_request_id" value="{{$wh_request_id}}"> 
                            <input type="hidden" id="stock_list_id" name="stock_list_id" value="{{$stock_list_id}}"> 
                            <input type="hidden" id="supsup_id" name="supsup_id" value="{{$supsup_id}}"> 
                            <input type="hidden" id="request_date" name="request_date" value="{{$request_date}}"> 
                            <input type="hidden" id="request_time" name="request_time" value="{{$request_time}}"> 
                            <input type="hidden" id="request_no" name="request_no" value="{{$request_no}}"> 
                            <input type="hidden" id="data_year" name="data_year" value="{{$data_year}}"> 
                            
                        
                            <div class="row mt-3"> 
                                <div class="col-xl-6">                                   
                                    <table id="example" class="table table-bordered border-primary table-hover table-sm" style="border-collapse: collapse;border-spacing: 0; width: 100%;">
                                        {{-- <table id="Tabledit" class="table table-bordered border-primary table-hover table-sm" style="border-collapse: collapse;border-spacing: 0; width: 100%;"> --}}
                                            <thead> 
                                                <tr>
                                                    <th class="text-center" style="background-color: rgb(255, 251, 228);font-size: 12px;">ลำดับ</th>  
                                                    <th class="text-center" style="background-color: rgb(174, 236, 245);font-size: 12px;">รายการ</th>  
                                                    <th class="text-center" style="background-color: rgb(174, 236, 245);font-size: 12px;">หน่วยนับ</th> 
                                                    <th class="text-center" style="background-color: rgb(250, 194, 187);font-size: 12px;">Stock</th>  
                                                    {{-- <th class="text-center" style="background-color: rgb(222, 201, 248);font-size: 12px;" width="10%">จ่าย</th>  --}}
                                                    <th class="text-center" style="background-color: rgb(222, 201, 248);font-size: 12px;" width="12%">เลือก LOT</th>  
                                                </tr> 
                                            </thead>
                                            <tbody>
                                                <?php $i = 1;$total1 = 0; $total2 = 0;$total3 = 0;$total4 = 0;$total5 = 0;$total6 = 0;$total7 = 0;$total8 = 0;$total9 = 0; ?>
                                                @foreach ($wh_product as $item)
                                                @php
                                                    // $data_pay_      = DB::select('SELECT SUM(qty_pay) as totalqty_pay FROM wh_request_subpay WHERE wh_request_id = "'.$item->wh_request_id.'"
                                                    // AND pro_id = "'.$item->pro_id.'"'); 
                                                    // foreach ($data_pay_ as $key => $value) {
                                                    //     $data_pay = $value->totalqty_pay;
                                                    // } 
                                                @endphp
                                                <tr id="tr_{{$item->pro_id}}">
                                                    <td class="text-center" width="5%">{{$i++}}</td>    
                                                    <td class="text-start" style="color:rgb(3, 93, 145)">{{$item->pro_code}} {{$item->pro_name}}</td>                                                     
                                                    <td class="text-center" style="color:rgb(3, 93, 145)" width="12%">{{$item->unit_name}}</td> 
                                                    <td class="text-center" style="color:rgb(3, 93, 145)" width="10%">{{($item->stock_rep-$item->stock_pay)}}</td>  
                                                    <td class="text-center" style="color:rgb(3, 93, 145)" width="12%">
                                                        @if ($item->stock_rep-$item->stock_pay < '1')
                                                        <button type="button" class="btn btn-outline-danger btn-sm" data-bs-toggle="modal">หมด</button>
                                                        @else
                                                        <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addsup" onclick="getdetailselect({{$item->pro_id}});">เลือก</button>
                                                        @endif
                                                        
                                                    </td>                                                                                                              
                                                </tr>
                                               
                                                @endforeach                                                
                                            </tbody> 
                                    </table> 
                                </div>
                                <div class="col-xl-6"> 
                                    <div id="gettable_show"></div>                                    
                                </div>  
                            </div>
                                 
                        </div>
                   
                      
                        
                        <div class="modal fade" id="addsup" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" >
                            <div class="modal-dialog modal-xl">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h2 class="modal-title"
                                            style="font-family: 'Kanit', sans-serif; font-size:14px;font-size: 1.5rem;font-weight:normal;">
                                            เลือกวัสดุที่ต้องการจ่าย</h2>
                                    </div>
                                    <div class="modal-body">

                                        <body>
                                            <div class="container mt-3">
                                                <input class="form-control" id="myInput" type="text" placeholder="Search..">
                                                <br>
                                                <div style='overflow:scroll; height:300px;'>

                                                    <div id="getdetailselect"></div>

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
                </div>
            </div>
                   
</div>


 
 
@endsection
@section('footer')
 
    <script>
        var Linechart;
        function getdetailselect(pro_id) {
            // alert(pro_id);
                var wh_request_id = document.getElementById("wh_request_id").value;
                $.ajax({  
                    url:"{{url('wh_main_payselect')}}" +'/'+ pro_id,  
                    method: "GET",
                    data: {
                        wh_request_id: wh_request_id,
                        pro_id: pro_id
                    },
                    success: function(result) {
                        $('#getdetailselect').html(result);
                    }
                })  
        }
        load_datapay_table();
        function load_datapay_table() {
                    var wh_request_id = document.getElementById("wh_request_id").value;
                    // alert(wh_recieve_id);
                    var _token=$('input[name="_token"]').val();
                    $.ajax({
                            url:"{{route('wh.load_datapay_table')}}",
                            method:"GET",
                            data:{wh_request_id:wh_request_id,_token:_token},
                            success:function(result){
                                $('#gettable_show').html(result);
                            }
                    });
        }  
        function selectsupreqs(wh_recieve_sub_id) {
            var wh_request_id = document.getElementById("wh_request_id").value;
            var qty_pay       = document.getElementById("qty_pay"+wh_recieve_sub_id).value;
            // alert(qty_pay);
            var _token = $('input[name="_token"]').val();
            // alert(wh_recieve_sub_id);
            $.ajax({
                url: "{{ route('wh.wh_mainpay_sublot_save') }}",
                method: "POST",
                data: {
                    wh_recieve_sub_id: wh_recieve_sub_id,wh_request_id:wh_request_id,qty_pay:qty_pay,
                    _token: _token
                },
                success: function(result) {
                    // $('.infoselectsupreq' + count).html(result);
                    // $('.infounitname' + count).html(result);
                    if (result.status == 200) {
                        load_datapay_table();
                        // window.location.reload();
                    } else {                        
                    }                    
                }
            })

            $('#addsup').modal('hide');
        }
        function deletesupreqs(wh_request_subpay_id) {
            var wh_request_id = document.getElementById("wh_request_id").value; 
         
            var _token = $('input[name="_token"]').val(); 
            $.ajax({
                url: "{{ route('wh.wh_main_paydestroy') }}",
                method: "POST",
                data: {
                    wh_request_subpay_id: wh_request_subpay_id,wh_request_id:wh_request_id,
                    _token: _token
                },
                success: function(result) { 
                    if (result.status == 200) {
                        load_datapay_table();     
                    }                    
                }
            })

            // $('#addsup').modal('hide');
        }


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
                                    $("#overlay").fadeIn(300);　
                                    $("#spinner").show(); //Load button clicked show spinner 

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
                                                    Swal.fire({ position: "top-end",
                                                        title: 'ลบข้อมูลสำเร็จ',
                                                        text: "You Delete data success",
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
                var request_date     = $('#request_date').val(); 
                var request_time     = $('#request_time').val(); 
                var request_no       = $('#request_no').val(); 
                var supsup_id        = $('#supsup_id').val(); 
                var stock_list_id    = $('#stock_list_id').val(); 
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
                                 
                                // wh_pay_addsub_save
                                $.ajax({
                                    url: "{{ route('wh.wh_main_payaddsave') }}",
                                    type: "POST",
                                    dataType: 'json',
                                    data: {data_year,wh_request_id,supsup_id,request_no,request_date,request_time,stock_list_id},
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
                                                    window.location="{{url('wh_main_pay')}}"; 
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
            //     url:'{{route("wh.wh_pay_edittable")}}',
                
            //     dataType:"json", 
            //     removeButton: false,
            //     columns:{
            //         identifier:[1,'wh_request_sub_id'], 
            //         editable: [[6,'qty_pay']]
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
            //         Swal.fire({
            //                 position: "top-end",
            //                 icon: "warning",
            //                 title: "Stock ไม่เพียงพอ",
            //                 showConfirmButton: false,
            //                 timer: 3000
            //                 });
            //                 window.location.reload(); 
            //        } 
            //     }

            // });

             $('#Tabledit').Tabledit({
                url:'{{route("wh.wh_pay_updatetable")}}',
                
                dataType:"json", 
                removeButton: false,
                columns:{
                    identifier:[0,'wh_request_subpay_id'], 
                    editable: [[2,'qty_pay']]
                }, 
                deleteButton: false,
                saveButton: true,
                autoFocus: false,
                buttons: {
                    edit: {
                        class:'btn btn-sm btn-default', 
                        html: '<i class="fa-regular fa-pen-to-square text-danger"></i>',
                        action: 'Edit'
                    }
                }, 
                onSuccess:function(data)
                {
                   if (data.status == 200) {
                        Swal.fire({
                            position: "top-end",
                            icon: "success",
                            title: "Your Edit Success",
                            showConfirmButton: false,
                            timer: 1500
                            });
                            window.location.reload();
                   } else {
                    Swal.fire({
                            position: "top-end",
                            icon: "warning",
                            title: "Stock ไม่เพียงพอ",
                            showConfirmButton: false,
                            timer: 3000
                            });
                            window.location.reload(); 
                   } 
                }

            });
  
        });
    </script>
  

@endsection
