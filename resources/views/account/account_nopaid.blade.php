@extends('layouts.account_new')
@section('title', 'PK-OFFICE || ACCOUNT')

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
    $ynow = date('Y')+543;
    $yb =  date('Y')+542;
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
            border-top: 10px #12c6fd solid;
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
        <form action="{{ url('account_nopaid') }}" method="GET">
            @csrf
            <div class="row ">
                <div class="col-md-4">

                    <h4 class="card-title" style="color:rgba(21, 177, 164, 0.871)">   Detail Overdue OPD</h4>
                    <p class="card-title-desc">รายละเอียดข้อมูล Visit ที่มีรายการค่าใช้จ่าย แต่ไม่มีการออกใบเสร็จ หรือลงค้าง OPD</p>
                </div>
                <div class="col"></div>
                <div class="col-md-1 text-end mt-2">เลือก</div>
                <div class="col-md-4">
                    <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker6'>
                        <input type="text" class="form-control cardfinan" name="startdate" id="datepicker" placeholder="Start Date"
                            data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                            data-date-language="th-th" value="{{ $startdate }}" required/>
                        <input type="text" class="form-control cardfinan" name="enddate" placeholder="End Date" id="datepicker2"
                            data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                            data-date-language="th-th" value="{{ $enddate }}" required/>
                            <button type="submit" class="ladda-button btn-pill btn btn-sm btn-info cardfinan" data-style="expand-left">
                                    <img src="{{ asset('images/Search02.png') }}" class="ms-2 me-2" height="23px" width="23px">
                                    ค้นหา</span>
                            </button>
                    </div>
                </div>

            </div>
        </form>
            <div class="row">
                <div class="col-xl-12">
                    <div class="card cardfinan" style="background-color: rgb(250, 230, 242)">
                        <div class="card-body">

                            @if ($startdate =='')
                                <p class="mb-0">
                                    <div class="table-responsive">
                                        <table id="example" class="table table-sm table-striped table-bordered dt-responsive nowrap myTable" style="border-collapse: collapse; border-spacing: 0; width: 100%;">

                                            <thead>
                                                <tr>
                                                    <th width="5%" class="text-center">ลำดับ</th>
                                                    <th class="text-center" width="5%">เดือน</th>
                                                    <th class="text-center" >income</th>
                                                    <th class="text-center" >ลูกหนี้</th>
                                                    <th class="text-center" >ต้องชำระ</th>
                                                    <th class="text-center">ชำระแล้ว</th>
                                                    <th class="text-center">ต้องลงค้าง</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 1; ?>
                                                @foreach ($datashow as $item)
                                                    <?php
                                                        $y = $item->year;
                                                        $ynew = $y + 543;
                                                    ?>
                                                    <tr style="font-size: 13px">
                                                        <td class="text-center" width="5%">{{ $i++ }}</td>
                                                        <td class="p-2" >{{$item->MONTH_NAME}} {{$item->year}}</td>
                                                        <td class="text-center" width="10%">{{ number_format($item->sum_income, 2) }}</td>
                                                        <td class="text-center" width="10%">{{ number_format($item->sum_uc_money, 2) }}</td>
                                                        <td class="text-center" width="10%">{{ number_format($item->sum_paid_money, 2) }}</td>
                                                        <td class="text-center" width="10%" style="color:rgb(7, 167, 113)">{{ number_format($item->sum_rcpt_money, 2) }}</td>
                                                        <td class="text-center" width="10%" style="color:rgb(202, 55, 29)">
                                                            {{-- <a href="{{url('account_nopaid_sub/'.$startdate.'/'.$enddate)}}" target="_blank">{{ number_format($item->sum_paid_money, 2) }} </a> --}}
                                                            {{-- {{ number_format($item->sum_income-$item->sum_remain_money-$item->sum_rcpt_money, 2) }} --}}
                                                            {{ number_format($item->sum_paid_money-$item->sum_rcpt_money, 2) }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </p>
                            @else
                                <p class="mb-0">
                                    <div class="table-responsive">
                                        <table id="example" class="table table-sm table-striped table-bordered dt-responsive nowrap myTable" style="border-collapse: collapse; border-spacing: 0; width: 100%;">

                                            <thead>
                                                <tr>
                                                    <th width="5%" class="text-center">ลำดับ</th>
                                                    <th class="text-center" width="5%">วันที่</th>
                                                    <th class="text-center" >income</th>
                                                    <th class="text-center" >ลูกหนี้</th>
                                                    <th class="text-center" >ต้องชำระ</th>
                                                    <th class="text-center" >ค้างชำระ</th>
                                                    <th class="text-center">ชำระแล้ว</th>
                                                    <th class="text-center">ต้องลงค้าง</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 1; ?>
                                                @foreach ($datashow as $item)
                                                    <?php
                                                        $y = $item->year;
                                                        $ynew = $y + 543;
                                                    ?>
                                                    <tr style="font-size: 13px">
                                                        <td class="text-center" width="5%">{{ $i++ }}</td>
                                                        <td class="p-2" >{{$item->vstdate}}</td>
                                                        <td class="text-center" width="10%">{{ number_format($item->sum_income, 2) }}</td>
                                                        <td class="text-center" width="10%">{{ number_format($item->sum_uc_money, 2) }}</td>
                                                        <td class="text-center" width="10%">{{ number_format($item->sum_paid_money, 2) }}</td>
                                                        <td class="text-center" width="10%">{{ number_format($item->sum_remain_money, 2) }}</td>
                                                        <td class="text-center" width="10%" style="color:rgb(7, 167, 113)">{{ number_format($item->sum_rcpt_money, 2) }}</td>
                                                        <td class="text-center" width="10%" style="color:rgb(202, 55, 29)">
                                                            {{-- <a href="{{url('account_nopaid_sub/'.$startdate.'/'.$enddate)}}" target="_blank">{{ number_format($item->sum_income-$item->sum_remain_money-$item->sum_rcpt_money, 2) }} </a> --}}
                                                            <a href="{{url('account_nopaid_sub/'.$item->vstdate)}}" target="_blank">{{ number_format($item->sum_paid_money-$item->sum_rcpt_money, 2) }} </a>

                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </p>
                            @endif

                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-12">
                </div>
            </div>


            <div data-parent="#accordion" id="myCollapse" class="collapse">
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card cardfinan">
                                <div class="card-body ">
                                    <div class="row">
                                        <div class="col-md-12">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <h4 class="card-title">รายการที่ต้องลงค้าง</h4>
                                                    </div>
                                                    <div class="col"></div>

                                                </div>

                                                <!-- Nav tabs -->
                                                <ul class="nav nav-tabs" role="tablist">
                                                    <li class="nav-item">
                                                        <a class="nav-link active" data-bs-toggle="tab" href="#detail" role="tab">
                                                            <span class="d-block d-sm-none"><i class="fas fa-detail"></i></span>
                                                            <span class="d-none d-sm-block">รายละเอียด</span>
                                                        </a>
                                                    </li>

                                                </ul>

                                                <!-- Tab panes -->
                                                <div class="tab-content p-3 text-muted">
                                                    <div class="tab-pane active" id="detail" role="tabpanel">
                                                        <p class="mb-0">
                                                            <div class="table-responsive">
                                                                <table id="example2" class="table table-hover table-sm dt-responsive nowrap" style=" border-spacing: 0; width: 100%;">
                                                                    <thead>
                                                                        <tr>
                                                                            <th width="5%" class="text-center">ลำดับ</th>
                                                                            <th class="text-center">vn</th>
                                                                            <th class="text-center" width="5%">hn</th>
                                                                            <th class="text-center" width="10%">income</th>
                                                                            <th class="text-center" width="10%">ส่วนลด</th>
                                                                            <th class="text-center" width="10%">ต้องชำระ</th>
                                                                            <th class="text-center" width="10%">ชำระแล้ว</th>
                                                                            <th class="text-center" width="10%">ค้างชำระ</th>
                                                                            <th class="text-center" width="10%">ต้องลงค้าง</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>

                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </p>
                                                    </div>

                                                </div>
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
{{-- <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script> --}}
    <script>
        $(document).ready(function() {
            $('#example').DataTable();
            $('#example2').DataTable();
            $('#example3').DataTable();

            $("#myBtn").click(function(){
                $("#myCollapse").collapse("toggle");
            });

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

            $('#datepicker3').datepicker({
                format: 'yyyy-mm-dd'
            });
            $('#datepicker4').datepicker({
                format: 'yyyy-mm-dd'
            });

        });
    </script>

@endsection
