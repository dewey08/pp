@extends('layouts.audit')
@section('title', 'PK-OFFICE || Audit')
@section('content')
    <script>
        function TypeAdmin() {
            window.location.href = '{{ route('index') }}';
        }
        function approve_destroy(d_fdh_id) {
            Swal.fire({
                position: "top-end",
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
                    $.ajax({
                        url: "{{ url('approve_destroy') }}" + '/' + d_fdh_id,
                        type: 'POST',
                        data: {
                            _token: $("input[name=_token]").val()
                        },
                        success: function(response) {
                            if (response.status == 200 ) {
                                Swal.fire({
                                    position: "top-end",
                                    title: 'ลบข้อมูล!',
                                    text: "You Delet data success",
                                    icon: 'success',
                                    showCancelButton: false,
                                    confirmButtonColor: '#06D177',
                                    // cancelButtonColor: '#d33',
                                    confirmButtonText: 'เรียบร้อย'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        $("#sid" + d_fdh_id).remove();
                                        window.location.reload();
                                        // window.location = "{{ url('air_main') }}";
                                    }
                                })
                            } else {  
                            }
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
    
    if ($month == 1) {
        $mm = 'มกราคม';
    } elseif ($month == 2) {
        $mm = 'กุมภาพันธ์';
    } elseif ($month == 3) {
        $mm = 'มีนาคม';
    } elseif ($month == 4) {
        $mm = 'เมษายน';
    } elseif ($month == 5) {
        $mm = 'พฤษภาคม';
    } elseif ($month == 6) {
        $mm = 'มิถุนายน';
    } elseif ($month == 7) {
        $mm = 'กรกฎาคม';
    } elseif ($month == 8) {
        $mm = 'สิงหาคม';
    } elseif ($month == 9) {
        $mm = 'กันยายน';
    } elseif ($month == 10) {
        $mm = 'ตุลาคม';
    } elseif ($month == 11) {
        $mm = 'พฤษจิกายน';
    } else {
        $mm = 'ธันวาคม';
    }
    
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
            border: 10px #ddd solid;
            border-top: 10px #0dc79f solid;
            border-radius: 50%;
            animation: sp-anime 0.8s infinite linear;
        }

        @keyframes sp-anime {
            100% {
                transform: rotate(390deg);
            }
        }

        .is-hide {
            display: none;
        }

        .modal-dis {
            width: 1350px;
            margin: auto;
        }

        @media (min-width: 1200px) {
            .modal-xlg {
                width: 90%;
            }
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

        <form action="{{ URL('audit_approve_code') }}" method="GET">
            @csrf
            <div class="row">
                <div class="col-md-3">
                    <h4 class="card-title" style="color:rgb(250, 128, 124)">Detail Pre-Audit OFC</h4>
                    <p class="card-title-desc">รายละเอียดข้อมูล Pre-Audit OFC</p>
                </div>
                <div class="col"></div> 
                {{-- @if ($budget_year =='')
                <div class="col-md-2"> 
                        <select name="budget_year" id="budget_year" class="form-control input_border text-center" style="width: 100%">
                            @foreach ($dabudget_year as $item_y)
                                @if ($bg_yearnow == $item_y->leave_year_id )
                                    <option value="{{$item_y->leave_year_id}}" selected>{{$item_y->leave_year_name}}</option>
                                @else
                                    <option value="{{$item_y->leave_year_id}}">{{$item_y->leave_year_name}}</option>
                                @endif                                   
                            @endforeach
                        </select>
                </div>
                @else
                <div class="col-md-2"> 
                        <select name="budget_year" id="budget_year" class="form-control input_border text-center" style="width: 100%">
                            @foreach ($dabudget_year as $item_y)
                                @if ($budget_year == $item_y->leave_year_id )
                                    <option value="{{$item_y->leave_year_id}}" selected>{{$item_y->leave_year_name}}</option>
                                @else
                                    <option value="{{$item_y->leave_year_id}}">{{$item_y->leave_year_name}}</option>
                                @endif                                   
                            @endforeach
                        </select>
                </div>
                @endif --}}
                <div class="col-md-1 text-start">  
                    <a href="{{URL('audit_approve_code')}}" class="ladda-button btn-pill btn btn-warning input_border" data-style="expand-left">
                        <span class="ladda-label"> <i class="fa-solid fa-arrow-left text-white me-2"></i>ย้อนกลับ</span> 
                    </a>    
                </div>  
            </div>
        </form>
            <div class="row">
                {{-- <div class="col-xl-6">
                    <div class="card card_audit_4">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <h4 class="card-title" style="color:rgb(241, 137, 155)"">APPROVE OFC</h4>
                                </div>
                                <div class="col"></div>
                                
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-12"> 
                                    <div class="table-responsive">
                                        <table id="example5"
                                            class="table table-striped table-bordered dt-responsive nowrap"
                                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">ลำดับ</th>
                                                    <th class="text-center">Year</th>
                                                    <th class="text-center">Month</th>
                                                    <th class="text-center">Visit ทั้งหมด</th>
                                                    <th class="text-center">Debit-Approve</th>
                                                    <th class="text-center">Debit-ไม่ Approve</th>
                                                    <th class="text-center">Visit ไม่ Approve</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $jj = 1;$total1 = 0; $total2 = 0; $total3 = 0; $total4 = 0; $total5 = 0;$total6 = 0;$total7 = 0; ?>
                                                @foreach ($fdh_ofc as $item)
                                                <?php  
                                                    $no_app = DB::connection('mysql10')->select(
                                                        'SELECT COUNT(rd.vn) as cvn,SUM(rd.total_amount) as total_amount
                                                        FROM rcpt_debt rd
                                                        LEFT JOIN vn_stat v ON v.vn = rd.vn
                                                        WHERE month(v.vstdate) = "'.$item->months.'" AND year(v.vstdate) = "'.$item->years.'"  
                                                        AND rd.pttype IN("O1","O2","O3","O4","O5")AND (rd.sss_approval_code IS NULL OR rd.sss_approval_code ="")   
                                                    ');   
                                                    foreach ($no_app as $key => $value) {
                                                        $sum_total_no = $value->total_amount;
                                                        $countvn      = $value->cvn;
                                                    }
                                                ?>
                                                    <tr>
                                                        <td class="text-center" style="width: 5%">{{ $jj++ }}</td>
                                                        <td class="text-center" width="10%">{{ $item->years }}</td> 
                                                        @if ($item->months == '1')
                                                        <td class="text-center" width="15%">มกราคม</td> 
                                                        @elseif ($item->months == '2')
                                                            <td class="text-center" width="15%">กุมภาพันธ์</td> 
                                                        @elseif ($item->months == '3')
                                                            <td class="text-center" width="15%">มีนาคม</td> 
                                                        @elseif ($item->months == '4')
                                                            <td class="text-center" width="15%">เมษายน</td> 
                                                        @elseif ($item->months == '5')
                                                            <td class="text-center" width="15%">พฤษภาคม</td> 
                                                        @elseif ($item->months == '6')
                                                            <td class="text-center" width="15%">มิถุนายน</td> 
                                                        @elseif ($item->months == '7')
                                                            <td class="text-center" width="15%">กรกฎาคม</td> 
                                                        @elseif ($item->months == '8')
                                                            <td class="text-center" width="15%">สิงหาคม</td> 
                                                        @elseif ($item->months == '9')
                                                            <td class="text-center" width="15%">กันยายน</td> 
                                                        @elseif ($item->months == '10')
                                                            <td class="text-center" width="15%">ตุลาคม</td> 
                                                        @elseif ($item->months == '11')
                                                            <td class="text-center" width="15%">พฤษจิกายน</td> 
                                                        @else
                                                            <td class="text-center" width="15%">ธันวาคม</td> 
                                                        @endif
                                                        <td class="text-center text-primary" width="15%">
                                                            {{ $item->countvn }}                                                             
                                                        </td>
                                                        <td class="text-center" width="15%" style="color:#033a6d">{{ number_format($item->sum_total, 2) }}</td> 
                                               
                                                                @if ($sum_total_no > 0)
                                                                    <td class="text-center" width="20%" style="color:rgb(252, 73, 42)">
                                                                       
                                                                        <a href="{{ url('audit_approve_detail/' . $item->months . '/' . $item->years) }}" class="ladda-button me-2 btn-pill btn btn-sm input_border text-white" style="background-color: rgb(236, 11, 97);font-size: 12px;"> {{ number_format($sum_total_no, 2) }}</a>
                                                                    </td> 
                                                                    <td class="text-center" width="15%" style="color:rgb(168, 22, 83)">{{ $countvn}}</td> 
                                                                @else
                                                                    <td class="text-center" width="20%">
                                                                        <a class="btn-icon btn-sm btn-shadow btn-dashed btn btn-outline-success">
                                                                            ซู๊ดดดดยอดอิหลี
                                                                        </a> 
                                                                    </td> 
                                                                    <td class="text-center" width="15%" style="color:rgb(221, 31, 6)">{{ $countvn}}</td> 
                                                                @endif 
                                                        
                                                    </tr>

                                                    <?php
                                                            $total1 = $total1 + $item->countvn; 
                                                            $total2 = $total2 + $item->sum_total; 
                                                            $total4 = $total4 + $countvn; 
                                                            $total3 = $total3 + $sum_total_no; 
                                                    ?> 
                                                    
                                                @endforeach

                                            </tbody>
                                            <tr style="background-color: #f3fca1">
                                                <td colspan="3" class="text-end" style="background-color: #fca1a1"></td>
                                                <td class="text-center" style="background-color: #47A4FA"><label for="" style="color: #FFFFFF">{{ number_format($total1, 2) }}</label></td>
                                                <td class="text-center" style="background-color: #033a6d"><label for="" style="color: #FFFFFF">{{ number_format($total2, 2) }}</label></td>
                                                <td class="text-center" style="background-color: #fc5089"><label for="" style="color: #FFFFFF">{{ number_format($total3, 2) }}</label></td>
                                                <td class="text-center" style="background-color: #d10404" ><label for="" style="color: #FFFFFF">{{ number_format($total4, 2) }}</label></td>  
                                                
                                             
                                            </tr>  
                                        </table>
                                    </div>
                                </div>
                            </div>
 
                        </div>
                    </div>
                </div> --}}
                <div class="col-xl-12">
                    <div class="card card_audit_4">
                        <div class="card-body">
                            <h4 class="card-title ms-2" style="color:rgb(241, 137, 155)">รายการที่ไม่ลง Approve</h4>  
                                <div class="table-responsive">    
                                    {{-- <table id="example3" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;"> --}}
                                        <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap myTable"
                                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                            <tr>
                                                <th class="text-center">ลำดับ</th> 
                                                <th class="text-center">VN</th> 
                                                <th class="text-center">HN</th> 
                                                <th class="text-center">CID</th>
                                                <th class="text-center">PDX</th>
                                                <th class="text-center">วันที่รับบริการ</th>
                                                <th class="text-center">ชื่อ - สกุล</th>
                                                <th class="text-center">pttype</th> 
                                                <th class="text-center">income</th>
                                                <th class="text-center">ส่วนลด</th>
                                                <th class="text-center">ชำระเงิน</th>
                                                {{-- <th class="text-center">ใบเสร็จ</th>  --}}
                                                <th class="text-center">finance_number</th> 
                                                <th class="text-center">ปิดลูกหนี้</th>

                                                <th class="text-center">Approve_HOSxP</th>
                                              
 
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $jj = 1;$total1 = 0; $total2 = 0; $total3 = 0; $total4 = 0; $total5 = 0;$total6 = 0;$total7 = 0; ?>
                                            @foreach ($ofc_month as $item_n) 
                                                <tr > <td class="text-center" style="width: 5%">{{ $jj++ }}</td>
                                                    <td class="text-center" style="width: 5%">{{ $item_n->vn }}</td>
                                                    <td class="text-center" style="width: 5%">{{ $item_n->hn }}</td>
                                                    <td class="text-center" style="width: 7%">{{ $item_n->cid }}</td>
                                                    <td class="text-center" style="width: 5%">{{ $item_n->pdx }}</td>
                                                    <td class="text-center" style="width: 5%">{{ $item_n->vstdate }}</td>
                                                    <td class="p-2" style="width: 10%">{{ $item_n->ptname }}</td> 
                                                    <td class="text-center" style="width: 5%">{{ $item_n->pttype }}</td> 
                                                    <td class="text-center" style="width: 5%">{{ $item_n->income }}</td>
                                                    <td class="text-center" style="width: 5%">{{ $item_n->discount_money }}</td>
                                                    <td class="text-center" style="width: 5%">{{ $item_n->rcpt_money }}</td> 
                                                    {{-- <td class="text-center" style="width: 5%">{{ $item_n->rcpno }}</td> --}}
                                                    <td class="text-center" style="width: 5%">{{ $item_n->finance_number }}</td> 
                                                    <td class="text-center" style="width: 5%">{{ $item_n->rramont }}</td>
                                                    <td class="text-center" style="width: 5%">{{ $item_n->Apphos }}</td> 
                                                </tr>
                                                <?php
                                                            $total1 = $total1 + $item_n->income;  
                                                    ?> 
                                            @endforeach
                
                                        </tbody>
                                        <tr style="background-color: #f3fca1">
                                            <td colspan="8" class="text-end" style="background-color: #fca1a1"></td>
                                            <td class="text-center" style="background-color: #47A4FA"><label for="" style="color: #FFFFFF">{{ number_format($total1, 2) }}</label></td> 
                                            <td colspan="6" class="text-end" style="background-color: #fca1a1"></td> 
                                         
                                        </tr>  
                                    </table>
                                </div>
                        </div>
                    </div>
                </div> 
            </div>
           
    </div>


@endsection
@section('footer')

    <script>
        $(document).ready(function() {
            var table = $('#example').DataTable({
                scrollY: '60vh',
                scrollCollapse: true,
                scrollX: true,
                "autoWidth": false,
                "pageLength": 100,
                "lengthMenu": [10, 100, 150, 200, 300, 400, 500],
            });
            var table = $('#example2').DataTable({
                scrollY: '60vh',
                scrollCollapse: true,
                scrollX: true,
                "autoWidth": false,
                "pageLength": 10,
                "lengthMenu": [10, 100, 150, 200, 300, 400, 500],
            });
            var table = $('#example3').DataTable({
                scrollY: '60vh',
                scrollCollapse: true,
                scrollX: true,
                "autoWidth": false,
                "pageLength": 10,
                "lengthMenu": [10, 100, 150, 200, 300, 400, 500],
            });

            $('#datepicker').datepicker({
                format: 'yyyy-mm-dd'
            });
            $('#datepicker2').datepicker({
                format: 'yyyy-mm-dd'
            });

            $('#example').DataTable();
            $('#hospcode').select2({
                placeholder: "--เลือก--",
                allowClear: true
            });
            $('#stamp').on('click', function(e) {
                if ($(this).is(':checked', true)) {
                    $(".sub_chk").prop('checked', true);
                } else {
                    $(".sub_chk").prop('checked', false);
                }
            });
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $("#spinner-div").hide(); //Request is complete so hide spinner

            $('.Process_A').click(function() {
                var startdate = $('#datepicker').val();
                var enddate = $('#datepicker2').val();
                Swal.fire({
                    title: 'ต้องการประมวลผลข้อมูลใช่ไหม ?',
                    text: "You Warn Process Data!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Process it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $("#overlay").fadeIn(300);
                        $("#spinner").show(); //Load button clicked show spinner 

                        $.ajax({
                            url: "{{ route('audit.pre_audit_process_a') }}",
                            type: "POST",
                            dataType: 'json',
                            data: {
                                startdate,
                                enddate
                            },
                            success: function(data) {
                                if (data.status == 200) {
                                    Swal.fire({
                                        position: "top-end",
                                        title: 'ประมวลผลข้อมูลสำเร็จ',
                                        text: "You Process data success",
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
                                            $('#spinner')
                                                .hide(); //Request is complete so hide spinner
                                            setTimeout(function() {
                                                $("#overlay").fadeOut(
                                                    300);
                                            }, 500);
                                        }
                                    })
                                } else {

                                    Swal.fire({
                                        position: "top-end",
                                        icon: "warning",
                                        title: "ยังไม่ได้เลือกวันที่",
                                        showCancelButton: false,
                                        confirmButtonColor: '#ed8d29',
                                        confirmButtonText: 'เลือกใหม่'
                                        // timer: 1500
                                    }).then((result) => {
                                        if (result
                                            .isConfirmed) {
                                            window.location.reload();
                                        }
                                    })

                                }
                            },
                        });

                    }
                })
            });




        });
    </script>
@endsection
