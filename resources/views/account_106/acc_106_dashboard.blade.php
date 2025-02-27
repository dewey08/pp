@extends('layouts.accountpk')
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
        body{
            font-family: sans-serif;
            font: normal;
            font-style: normal;
        }
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

    <?php
        $ynow = date('Y')+543;
        $yb =  date('Y')+542;
    ?>

   <div class="container-fluid">
        <div id="preloader">
            <div id="status">
                <div class="spinner">
                </div>
            </div>
        </div>
        {{-- <form action="{{ route('acc.acc_106_dashboard') }}" method="GET">
            @csrf
            <div class="row ms-2 me-2 mt-2">
                <div class="col-md-3">
                    <h5 class="card-title">Detail 1102050102.106</h5>
                    <p class="card-title-desc">รายละเอียดข้อมูล ผัง 1102050102.106</p>
                </div>
                <div class="col"></div>
                <div class="col-md-1 text-end mt-2">วันที่</div>
                <div class="col-md-4 text-end">
                    <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker6'>
                        <input type="text" class="form-control" name="startdate" id="datepicker" placeholder="Start Date"
                            data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                            data-date-language="th-th" value="{{ $startdate }}" required/>
                        <input type="text" class="form-control" name="enddate" placeholder="End Date" id="datepicker2"
                            data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                            data-date-language="th-th" value="{{ $enddate }}" required/>

                    <button type="submit" class="btn-icon btn-shadow btn-dashed btn btn-outline-info">
                        <i class="fa-solid fa-magnifying-glass text-info me-2"></i>
                        ค้นหา
                    </button>
                </div>
                </div>

            </div>
        </form> --}}

        <form action="{{ route('acc.acc_106_dashboard') }}" method="GET">
            @csrf
            <div class="row">
                <div class="col"></div>
                <div class="col-md-7">
                    <h4 class="card-title" style="color:rgb(247, 31, 95)">Detail 1102050102.106</h4>
                    <p class="card-title-desc">รายละเอียดข้อมูล ผัง 1102050102.106</p>
                </div>
                {{-- <div class="col"></div> --}}

                @if ($budget_year =='')
                <div class="col-md-2">
                        <select name="budget_year" id="budget_year" class="form-control-sm text-center card_audit_4c" style="width: 100%;font-size:13px">
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
                        <select name="budget_year" id="budget_year" class="form-control-sm text-center card_audit_4c" style="width: 100%;font-size:13px">
                            @foreach ($dabudget_year as $item_y)
                                @if ($budget_year == $item_y->leave_year_id )
                                    <option value="{{$item_y->leave_year_id}}" selected>{{$item_y->leave_year_name}}</option>
                                @else
                                    <option value="{{$item_y->leave_year_id}}">{{$item_y->leave_year_name}}</option>
                                @endif
                            @endforeach
                        </select>
                </div>
                @endif
                <div class="col-md-1 text-start">
                    <button type="submit" class="ladda-button btn-pill btn btn-sm btn-info cardacc">
                        <span class="ladda-label">
                            <img src="{{ asset('images/Search02.png') }}" class="me-2 ms-2" height="18px" width="18px">
                            ค้นหา</span>
                    </button>
                </div>

                <div class="col"></div>

        </div>
        </form>


        {{-- <div class="row ">
            @foreach ($datashow as $item)
                <div class="col-xl-4 col-md-12">
                    <div class="main-card mb-3 card shadow" style="background-color: rgb(246, 235, 247)">
                        @if ($startdate == '')
                            <div class="grid-menu-col">
                                <div class="g-0 row">
                                    <div class="col-sm-12">
                                        <div class="d-flex text-start">
                                            <div class="flex-grow-1 ">
                                                <?php
                                                    $y = $item->year;
                                                    $ynew = $y + 543;
                                                    // ลูกหนี้ทั้งหมด
                                                    $datas = DB::select('
                                                        SELECT count(DISTINCT vn) as Can
                                                            ,SUM(debit_total) as sumdebit
                                                            from acc_debtor
                                                            WHERE account_code="1102050102.106"
                                                            AND stamp = "N"
                                                            AND month(vstdate) = "'.$item->months.'"
                                                            AND year(vstdate) = "'.$item->year.'";
                                                    ');
                                                    foreach ($datas as $key => $value) {
                                                        $count_N = $value->Can;
                                                        $sum_N = $value->sumdebit;
                                                    }
                                                    // ตั้งลูกหนี้
                                                    $datasum_ = DB::select('
                                                        SELECT sum(debit_total) as debit_total,count(DISTINCT vn) as Cvit
                                                        from acc_1102050102_106
                                                        where month(vstdate) = "'.$item->months.'"
                                                        AND year(vstdate) = "'.$item->year.'";

                                                    ');
                                                    foreach ($datasum_ as $key => $value2) {
                                                        $sum_Y = $value2->debit_total;
                                                        $count_Y = $value2->Cvit;
                                                    }
                                                ?>
                                                <div class="row">
                                                    <div class="col-md-5 text-start mt-4 ms-4">
                                                        <h5 > {{$item->MONTH_NAME}} {{$ynew}}</h5>
                                                    </div>
                                                    <div class="col"></div>
                                                    <div class="col-md-5 text-end mt-2 me-2">
                                                            <div class="widget-chart widget-chart-hover" data-bs-toggle="tooltip" data-bs-placement="top" title="จำนวนลูกหนี้ที่ต้องตั้ง">
                                                                <h6 class="text-end">{{$count_N}} Visit</h6>
                                                            </div>

                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-1 text-start ms-4">
                                                        <i class="fa-solid fa-2x fa-sack-dollar me-2 align-middle text-secondary"></i>
                                                    </div>
                                                    <div class="col-md-4 text-start mt-3">
                                                        <p class="text-muted mb-0">
                                                            ลูกหนี้ที่ต้องตั้ง
                                                        </p>
                                                    </div>
                                                    <div class="col"></div>
                                                    <div class="col-md-5 text-end me-2">
                                                            <div class="widget-chart widget-chart-hover" >
                                                                <p class="text-end mb-0" data-bs-toggle="tooltip" data-bs-placement="top" title="ลูกหนี้ที่ต้องตั้ง {{$count_N}} Visit" >
                                                                        {{ number_format($sum_N, 2) }}
                                                                        <i class="fa-brands fa-btc text-secondary ms-2"></i>
                                                                </p>
                                                            </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-1 text-start ms-4">
                                                        <i class="fa-brands fa-2x fa-bitcoin me-2 align-middle text-danger"></i>
                                                    </div>
                                                    <div class="col-md-4 text-start mt-3">
                                                        <p class="text-muted mb-0" >
                                                            ตั้งลูกหนี้
                                                        </p>
                                                    </div>
                                                    <div class="col"></div>
                                                    <div class="col-md-5 text-end me-2">
                                                        <a href="{{url('acc_106_detail/'.$item->months.'/'.$item->year)}}" target="_blank">
                                                            <div class="widget-chart widget-chart-hover">
                                                                <p class="text-end mb-0" data-bs-toggle="tooltip" data-bs-placement="top" title="ตั้งลูกหนี้ {{$count_Y}} Visit">
                                                                        {{ number_format($sum_Y, 2) }}
                                                                        <i class="fa-brands fa-btc text-danger ms-2"></i>
                                                                </p>
                                                            </div>
                                                        </a>
                                                    </div>
                                                </div>


                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                        <div class="grid-menu-col">
                            <div class="g-0 row">
                                <div class="col-sm-12">
                                    <div class="d-flex text-start">
                                        <div class="flex-grow-1 ">
                                            <?php
                                                $y = $item->year;
                                                $ynew = $y + 543;
                                                // ลูกหนี้ทั้งหมด
                                                $datas = DB::select('
                                                    SELECT count(DISTINCT vn) as Can
                                                        ,SUM(debit_total) as sumdebit
                                                        from acc_debtor
                                                        WHERE account_code="1102050102.106"
                                                        AND stamp = "N"
                                                        AND vstdate BETWEEN "'.$startdate.'" AND "'.$enddate.'"
                                                ');
                                                foreach ($datas as $key => $value) {
                                                    $count_N = $value->Can;
                                                    $sum_N = $value->sumdebit;
                                                }
                                                // ตั้งลูกหนี้
                                                $datasum_ = DB::select('
                                                    SELECT sum(debit_total) as debit_total,count(DISTINCT vn) as Cvit
                                                    from acc_1102050102_106
                                                    where vstdate BETWEEN "'.$startdate.'" AND "'.$enddate.'"

                                                ');
                                                foreach ($datasum_ as $key => $value2) {
                                                    $sum_Y = $value2->debit_total;
                                                    $count_Y = $value2->Cvit;
                                                }
                                            ?>
                                            <div class="row">
                                                <div class="col-md-5 text-start mt-4 ms-4">
                                                    <h5 > {{$item->MONTH_NAME}} {{$ynew}}</h5>
                                                </div>
                                                <div class="col"></div>
                                                <div class="col-md-5 text-end mt-2 me-2">
                                                        <div class="widget-chart widget-chart-hover" data-bs-toggle="tooltip" data-bs-placement="top" title="จำนวนลูกหนี้ที่ต้องตั้ง">
                                                            <h6 class="text-end">{{$count_N}} Visit</h6>
                                                        </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-1 text-start ms-4">
                                                    <i class="fa-solid fa-2x fa-sack-dollar me-2 align-middle text-secondary"></i>
                                                </div>
                                                <div class="col-md-4 text-start mt-3">
                                                    <p class="text-muted mb-0">
                                                        ลูกหนี้ที่ต้องตั้ง
                                                    </p>
                                                </div>
                                                <div class="col"></div>
                                                <div class="col-md-5 text-end me-2">
                                                        <div class="widget-chart widget-chart-hover" >
                                                            <p class="text-end mb-0" data-bs-toggle="tooltip" data-bs-placement="top" title="ลูกหนี้ที่ต้องตั้ง {{$count_N}} Visit" >
                                                                    {{ number_format($sum_N, 2) }}
                                                                    <i class="fa-brands fa-btc text-secondary ms-2"></i>
                                                            </p>
                                                        </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-1 text-start ms-4">
                                                    <i class="fa-brands fa-2x fa-bitcoin me-2 align-middle text-danger"></i>
                                                </div>
                                                <div class="col-md-4 text-start mt-3">
                                                    <p class="text-muted mb-0" >
                                                        ตั้งลูกหนี้
                                                    </p>
                                                </div>
                                                <div class="col"></div>
                                                <div class="col-md-5 text-end me-2">
                                                    <a href="{{url('acc_106_detail_date/'.$startdate.'/'.$enddate)}}" target="_blank">
                                                        <div class="widget-chart widget-chart-hover">
                                                            <p class="text-end mb-0" data-bs-toggle="tooltip" data-bs-placement="top" title="ตั้งลูกหนี้ {{$count_Y}} Visit">
                                                                    {{ number_format($sum_Y, 2) }}
                                                                    <i class="fa-brands fa-btc text-danger ms-2"></i>
                                                            </p>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>




                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @endif
                    </div>
                </div>
            @endforeach
        </div> --}}
        <div class="row">
            <div class="col"></div>
            @if ($startdate !='')
                <div class="col-xl-10 col-md-10">
                    <div class="card card_audit_4c" style="background-color: rgb(246, 235, 247)">
                        <div class="table-responsive p-3">
                            <table id="example" class="table table-sm table-striped table-bordered dt-responsive nowrap myTable"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th class="text-center" style="background-color: rgb(219, 247, 232)">ลำดับ</th>
                                        <th class="text-center" style="background-color: rgb(219, 247, 232)">เดือน</th>
                                        <th class="text-center" style="background-color: rgb(219, 247, 232)">income</th>
                                        {{-- <th class="text-center" style="background-color: rgb(219, 247, 232)">Claim</th>  --}}
                                        <th class="text-center" style="background-color: rgb(135, 190, 253)">ลูกหนี้ที่ต้องตั้ง</th>
                                        <th class="text-center" style="background-color: rgb(135, 190, 253)">ตั้งลูกหนี้</th>
                                        <th class="text-center" style="background-color: rgb(182, 210, 252)">Rep</th>
                                        <th class="text-center" style="background-color: rgb(135, 190, 253)">Stm</th>
                                        <th class="text-center" style="background-color: rgb(250, 225, 234)">ยกยอดไป</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $number = 0; $total1 = 0; $total2 = 0; $total3 = 0; $total4 = 0; $total5 = 0;$total6 = 0;$total7 = 0;
                                    ?>
                                    @foreach ($datashow as $item)
                                        <?php
                                            $number++;
                                            $y = $item->year;
                                                $ynew = $y + 543;
                                            // ลูกหนี้ที่ต้องตั้ง 401
                                            $datas = DB::select(
                                                'SELECT count(DISTINCT vn) as Can,SUM(debit_total) as sumdebit
                                                    FROM acc_debtor
                                                    WHERE account_code="1102050102.106"
                                                    AND stamp = "N"
                                                    AND debit_total > 0
                                                    AND month(vstdate) = "'.$item->months.'"
                                                    AND year(vstdate) = "'.$item->year.'"
                                            ');
                                            foreach ($datas as $key => $value) {
                                                $count_N = $value->Can;
                                                $sum_N = $value->sumdebit;
                                            }

                                            $dataclaimsum_ = DB::select(
                                                'SELECT sum(income) as total_incom,count(DISTINCT vn) as CCvit
                                                FROM acc_debtor
                                                WHERE month(vstdate) = "'.$item->months.'" AND account_code ="1102050102.106"
                                                AND year(vstdate) = "'.$item->year.'"
                                                AND active_claim = "Y"
                                            ');
                                            foreach ($dataclaimsum_ as $key => $vc) {
                                                $total_claim = $vc->total_incom;
                                            }
                                            $dataclaimrepsum_ = DB::select(
                                                'SELECT sum(rep_pay) as total_reppay,count(DISTINCT vn) as CCvit
                                                FROM acc_debtor
                                                WHERE month(vstdate) = "'.$item->months.'" AND account_code ="1102050102.106"
                                                AND year(vstdate) = "'.$item->year.'"
                                                AND active_claim = "Y"
                                            ');
                                            foreach ($dataclaimrepsum_ as $key => $vcrep) {
                                                $total_claim_rep = $vcrep->total_reppay;
                                            }

                                            // ตั้งลูกหนี้ OPD 401
                                            $datasum_ = DB::select(
                                                'SELECT sum(debit_total) as debit_total,count(DISTINCT vn) as Cvit
                                                FROM acc_1102050102_106
                                                WHERE month(vstdate) = "'.$item->months.'"
                                                AND year(vstdate) = "'.$item->year.'"

                                            ');
                                            foreach ($datasum_ as $key => $value2) {
                                                $total_sumY = $value2->debit_total;
                                                $total_countY = $value2->Cvit;
                                            }

                                            // STM 401
                                            $stm_ = DB::select(
                                                'SELECT count(DISTINCT U1.vn) as Countvisit ,sum(U1.stm_money) as stm_money
                                                    FROM acc_1102050102_106 U1
                                                    WHERE month(U1.vstdate) = "'.$item->months.'"
                                                    AND year(U1.vstdate) = "'.$item->year.'"
                                                    AND U1.stm_money >= "0.00"
                                            ');
                                            foreach ($stm_ as $key => $value3) {
                                                $sum_stm_money  = $value3->stm_money;
                                                $count_stm      = $value3->Countvisit;
                                            }

                                            // ยกไป
                                            $yokpai_ = DB::select(
                                                'SELECT sum(debit_total) as debit_total,count(vn) as Countvi
                                                    FROM acc_1102050102_106
                                                    WHERE month(vstdate) = "'.$item->months.'"
                                                    AND year(vstdate) = "'.$item->year.'"
                                                    AND (stm_money IS NULL OR stm_money = "")
                                            ');
                                            foreach ($yokpai_ as $key => $valpai) {
                                                $sum_yokpai = $valpai->debit_total;
                                                $count_yokpai = $valpai->Countvi;
                                            }


                                        ?>

                                            <tr>
                                                <td class="text-font" style="text-align: center;" width="4%">{{ $number }} </td>
                                                <td class="p-2">
                                                    {{$item->MONTH_NAME}} {{$ynew}}
                                                </td>
                                                <td class="text-end" style="color:rgb(73, 147, 231)" width="10%"> {{ number_format($item->income, 2) }}</td>
                                                {{-- <td class="text-end" style="color:rgb(6, 82, 170);background-color: rgb(203, 227, 255)" width="10%">
                                                    <a href="{{url('account_401_claim_detail/'.$item->months.'/'.$item->year)}}" target="_blank" style="color:rgb(4, 170, 134);"> {{ number_format($total_claim, 2) }}</a>
                                                </td>  --}}


                                                <td class="text-end" style="color:rgb(6, 82, 170);background-color: rgb(203, 227, 255)" width="10%">
                                                    <a href="{{url('acc_106_pull_wait/'.$item->months.'/'.$item->year)}}" target="_blank" style="color:rgb(5, 58, 173);"> {{ number_format($sum_N, 2) }}</a>
                                                </td>
                                                <td class="text-end" style="color:rgb(231, 73, 139);background-color: rgb(203, 227, 255)" width="10%">
                                                    <a href="{{url('acc_106_detail/'.$item->months.'/'.$item->year)}}" target="_blank" style="color:rgb(231, 73, 139);"> {{ number_format($total_sumY, 2) }}</a>

                                                </td>
                                                <td class="text-end" style="color:rgb(6, 82, 170);background-color: rgb(203, 227, 255)" width="10%">
                                                    <a style="color:#0962b6;"> {{ number_format($total_claim_rep, 2) }}</a>
                                                </td>
                                                <td class="text-end" style="color:rgb(2, 116, 63);background-color: rgb(203, 227, 255)" width="10%">
                                                    {{ number_format($sum_stm_money, 2) }}
                                                </td>

                                                <td class="text-end" style="color:rgb(224, 128, 17)" width="10%">
                                                     {{ number_format($sum_yokpai, 2) }}
                                                </td>
                                            </tr>
                                        <?php
                                                $total1 = $total1 + $item->income;
                                                // $total2 = $total2 + $total_claim;
                                                $total3 = $total3 + $sum_N;
                                                $total7 = $total7 + $total_claim_rep;

                                                $total4 = $total4 + $total_sumY;
                                                $total5 = $total5 + $sum_stm_money;
                                                $total6 = $total6 + $sum_yokpai;
                                        ?>
                                    @endforeach

                                </tbody>
                                <tr style="background-color: #f3fca1">
                                    <td colspan="2" class="text-end" style="background-color: #fca1a1"></td>
                                    <td class="text-end" style="background-color: #47A4FA"><label for="" style="color: #0962b6">{{ number_format($total1, 2) }}</label></td>
                                    <td class="text-end" style="background-color: #033a6d"><label for="" style="color: #0962b6">{{ number_format($total3, 2) }}</label></td>
                                    <td class="text-end" style="background-color: #fc5089"><label for="" style="color: #0962b6">{{ number_format($total4, 2) }}</label></td>
                                    <td class="text-end" style="background-color: #2e41e9" ><label for="" style="color: #0962b6">{{ number_format($total7, 2) }}</label></td>
                                    <td class="text-end" style="background-color: #149966" ><label for="" style="color: #0962b6">{{ number_format($total5, 2) }}</label></td>
                                    <td class="text-end" style="background-color: #f89625"><label for="" style="color: #0962b6">{{ number_format($total6, 2) }}</label></td>

                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            @else

            @endif
            <div class="col"></div>
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
