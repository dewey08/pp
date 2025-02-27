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
            <form action="{{ url('account_nopaid_ip') }}" method="GET">
                @csrf
                <div class="row ">
                    <div class="col-md-4">

                        <h4 class="card-title" style="color:rgba(21, 177, 164, 0.871)">   Detail Overdue IPD</h4>
                        <p class="card-title-desc">รายละเอียดข้อมูล Visit ที่มีรายการค่าใช้จ่าย แต่ไม่มีการออกใบเสร็จ หรือลงค้าง IPD</p>
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
                    <div class="card cardfinan" style="background-color: rgb(246, 235, 247)">
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
                                                        <td class="text-start" >{{$item->MONTH_NAME}} {{$item->year}}</td>
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
                                                    <th class="text-center" width="5%">วันที่ dchdate</th>
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
                                                        <td class="p-2" >{{$item->dchdate}}</td>
                                                        <td class="text-center" width="10%">{{ number_format($item->sum_income, 2) }}</td>
                                                        <td class="text-center" width="10%">{{ number_format($item->sum_uc_money, 2) }}</td>
                                                        <td class="text-center" width="10%">{{ number_format($item->sum_paid_money, 2) }}</td>
                                                        <td class="text-center" width="10%">{{ number_format($item->sum_remain_money, 2) }}</td>
                                                        <td class="text-center" width="10%" style="color:rgb(7, 167, 113)">{{ number_format($item->sum_rcpt_money, 2) }}</td>
                                                        <td class="text-center" width="10%" style="color:rgb(202, 55, 29)">
                                                            <a href="{{url('account_nopaid_sub_ip/'.$item->dchdate)}}" target="_blank">{{ number_format($item->sum_paid_money-$item->sum_rcpt_money, 2) }} </a>

                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </p>
                            @endif

                        {{-- <div class="grid-menu-col">
                            <div class="g-0 row">
                                <div class="col-sm-12">
                                    <div class="d-flex text-start">
                                        <div class="flex-grow-1 ">

                                            <div class="row">
                                                <div class="col-md-5 text-start mt-4 ms-4">
                                                    <h5 > {{$item->MONTH_NAME}} {{$ynew}}</h5>
                                                </div>
                                                <div class="col"></div>
                                                <div class="col-md-5 text-end mt-2 me-2">

                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-1 text-start ms-4">
                                                    <i class="fa-solid fa-sack-dollar align-middle text-secondary"></i>
                                                </div>
                                                <div class="col-md-4 text-start">
                                                    <p class="text-muted mb-0">
                                                        Visit
                                                    </p>
                                                </div>
                                                <div class="col"></div>
                                                <div class="col-md-5 text-end me-2">
                                                    <a href="{{url('account_nopaid_sub_ip/'.$item->months.'/'.$item->year)}}" target="_blank">
                                                        <p class="text-end mb-0" data-bs-toggle="tooltip" data-bs-placement="top" title="ต้องลงค้าง {{$item->count_an}} Visit" >
                                                            {{$item->count_an}} Visit
                                                            <i class="fa-brands fa-btc text-secondary ms-2 me-2"></i>
                                                        </p>
                                                    </a>
                                                </div>
                                            </div>


                                            <div class="row">
                                                <div class="col-md-1 text-start mt-2 ms-4">
                                                    <i class="fa-brands fa-bitcoin align-middle text-primary"></i>
                                                </div>
                                                <div class="col-md-4 text-start mt-2">
                                                    <p class="text-muted mb-0" >
                                                        income
                                                    </p>
                                                </div>
                                                <div class="col"></div>
                                                <div class="col-md-5 text-end mt-2 me-2">

                                                        <p class="text-end mb-0" data-bs-toggle="tooltip" data-bs-placement="top" title="ยอดเงิน {{ number_format($item->sum_income, 2) }} บาท">
                                                            {{ number_format($item->sum_income, 2) }}
                                                            <i class="fa-brands fa-btc text-primary ms-2 me-2"></i>
                                                        </p>

                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-1 text-start mt-2 ms-4">
                                                    <i class="fa-brands fa-bitcoin align-middle text-info"></i>
                                                </div>
                                                <div class="col-md-4 text-start text-info mt-2">
                                                    <p class="text-muted mb-0">
                                                        ต้องชำระ
                                                    </p>
                                                </div>
                                                <div class="col"></div>
                                                <div class="col-md-5 text-end mt-2 me-2" style="color:rgb(37, 165, 240)">

                                                        <p class="text-end mb-0" data-bs-toggle="tooltip" data-bs-placement="top" title="ยอดเงิน {{ number_format($item->sum_paid_money, 2) }} บาท">
                                                            {{ number_format($item->sum_paid_money, 2) }}
                                                            <i class="fa-brands fa-btc text-info ms-2 me-2"></i>
                                                        </p>

                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-1 text-start mt-2 ms-4">
                                                    <i class="fa-brands fa-bitcoin align-middle text-success"></i>
                                                </div>
                                                <div class="col-md-4 text-start text-success mt-2">
                                                    <p class="text-muted mb-0">
                                                        ชำระแล้ว
                                                    </p>
                                                </div>
                                                <div class="col"></div>
                                                <div class="col-md-5 text-end mt-2 me-2" style="color:rgb(10, 124, 80)">

                                                        <p class="text-end mb-0" data-bs-toggle="tooltip" data-bs-placement="top" title="ยอดเงิน {{ number_format($item->sum_rcpt_money, 2) }} บาท">
                                                            {{ number_format($item->sum_rcpt_money, 2) }}
                                                            <i class="fa-brands fa-btc text-success ms-2 me-2"></i>
                                                        </p>

                                                </div>
                                            </div>


                                            <div class="row mb-4">
                                                <div class="col-md-1 text-start mt-2 ms-4">
                                                    <i class="fa-brands fa-bitcoin align-middle text-danger"></i>
                                                </div>
                                                <div class="col-md-4 text-start mt-2">
                                                    <p class="text-muted mb-0">
                                                        ต้องลงค้าง
                                                    </p>
                                                </div>
                                                <div class="col"></div>
                                                <div class="col-md-5 text-end mt-2 me-2" style="color:red">
                                                    <a href="{{url('account_nopaid_sub_ip/'.$item->months.'/'.$item->year)}}" target="_blank">
                                                        <p class="text-end mb-0" data-bs-toggle="tooltip" data-bs-placement="top" title="ยอดเงิน {{$item->count_an }} Visit">
                                                            {{ number_format($item->sum_Total, 2) }}
                                                            <i class="fa-brands fa-btc text-danger ms-2 me-2"></i>
                                                        </p>
                                                    </a>
                                                </div>
                                            </div>


                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> --}}

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
