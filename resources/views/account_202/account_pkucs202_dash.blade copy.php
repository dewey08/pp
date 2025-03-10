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
        <form action="{{ route('acc.account_pkucs202_dash') }}" method="GET">
            @csrf
            <div class="row">
                <div class="col-md-3 ">
                    <h5 class="card-title">Detail 1102050101.202</h5>
                    <p class="card-title-desc">รายละเอียดข้อมูล ผัง 1102050101.202</p>
                </div>
                <div class="col"></div>
                <div class="col-md-1 text-end mt-2">วันที่</div>
                <div class="col-md-5 text-end"> 
                    <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker6'>
                        <input type="text" class="form-control inputacc" name="startdate" id="datepicker" placeholder="Start Date"
                            data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                            data-date-language="th-th" value="{{ $startdate }}" required/>
                        <input type="text" class="form-control inputacc" name="enddate" placeholder="End Date" id="datepicker2"
                            data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                            data-date-language="th-th" value="{{ $enddate }}" required/>   
                    <button type="submit" class="ladda-button btn-pill btn btn-primary cardacc" data-style="expand-left">
                        <span class="ladda-label"> <i class="fa-solid fa-magnifying-glass text-white me-2"></i>ค้นหา</span>
                        <span class="ladda-spinner"></span>
                    </button> 
                    <button type="button" class="ladda-button btn-pill btn btn-danger cardacc" data-style="expand-left" id="Processdata">
                        <span class="ladda-label"> <i class="fa-solid fa-file-circle-plus text-white me-2"></i>ประมวลผล</span>
                        <span class="ladda-spinner"></span>
                    </button>
                     
                </div>

            </div>
        </form>
        <div class="row">
            @foreach ($datashow as $item)
            <div class="col-xl-4 col-md-12">
                <div class="card cardacc" style="background-color: rgb(246, 235, 247)">
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
                                                    SELECT count(DISTINCT an) as Can
                                                        ,SUM(debit) as sumdebit
                                                        from acc_debtor
                                                            WHERE account_code="1102050101.202"
                                                            AND stamp = "N"
                                                            and month(dchdate) = "'.$item->months.'"
                                                            and year(dchdate) = "'.$item->year.'";
                                                ');
                                                foreach ($datas as $key => $value) {
                                                    $count_N = $value->Can;
                                                    $sum_N = $value->sumdebit;
                                                }
                                                // ตั้งลูกหนี้
                                                $datasum_ = DB::select('
                                                    SELECT sum(debit_total) as debit_total,count(DISTINCT an) as Cvit
                                                            from acc_1102050101_202
                                                            WHERE month(dchdate) = "'.$item->months.'"
                                                            and year(dchdate) = "'.$item->year.'"
                                                          
                                                ');
                                                // AND status = "N"
                                                // AND status = "N"
                                                foreach ($datasum_ as $key => $value2) {
                                                    $sum_Y = $value2->debit_total;
                                                    $count_Y = $value2->Cvit;
                                                }
                                                // สีเขียว STM
                                                $sumapprove_ = DB::select('
                                                        SELECT count(DISTINCT a.an) as Apvit ,sum(U2.ip_paytrue) as ip_paytrue
                                                            FROM acc_1102050101_202 a
                                                            INNER JOIN acc_stm_ucs U2 ON U2.an = a.an
                                                            WHERE month(a.dchdate) = "'.$item->months.'"
                                                            AND year(a.dchdate) = "'.$item->year.'"
                                                            AND U2.ip_paytrue > "0.00"
                                                    ');
                                                    // WHERE month(a.dchdate) = "'.$item->months.'"
                                                    //         and year(a.dchdate) = "'.$item->year.'"

                                                    // AND au.ip_paytrue > "0.00"
                                                    // AND au.ip_paytrue IS NOT NULL
                                                    foreach ($sumapprove_ as $key => $value3) {
                                                        $amountpay = $value3->ip_paytrue;
                                                        $stm_count = $value3->Apvit;
                                                    }
                                                    // สีส้ม ยกยอดไป
                                                    // $sumyokma_ = DB::select('
                                                    //     SELECT count(DISTINCT an) as anyokma ,sum(debit_total) as debityokma
                                                    //             FROM acc_1102050101_202
                                                    //             WHERE year(dchdate) = "'.$item->year.'"
                                                    //             AND month(dchdate) = "'.$item->months.'"
                                                               
                                                    // ');
                                                    // // AND status ="N"
                                                    // foreach ($sumyokma_ as $key => $value5) {
                                                    //     $total_yokma = $value5->debityokma;
                                                    //     $count_yokma = $value5->anyokma;
                                                    // }
                                                     // ยกยอดไป
                                                    // $mo = $item->months;
                                                    $sumyokma_all_ = DB::select('
                                                        SELECT count(DISTINCT U1.an) as anyokma ,sum(U1.debit_total) as debityokma
                                                                FROM acc_1102050101_202 U1
                                                                LEFT JOIN acc_stm_ucs U2 ON U2.an = U1.an
                                                                WHERE year(U1.dchdate) = "'.$item->year.'" 
                                                                AND month(U1.dchdate) = "'.$item->months.'"   
                                                    ');
                                                    // AND U2.ip_paytrue = "0.00"

                                                    // AND (U2.rep IS NULL OR U2.ip_paytrue < "1")
                                                    // AND U2.ip_paytrue = "0.00"
                                                    // AND U2.rep IS NULL
                                                    // AND month(U1.dchdate) < "'.$mo.'"
                                                    foreach ($sumyokma_all_ as $key => $value6) {
                                                        $total_yokma_alls = $value6->debityokma ;
                                                        $count_yokma_alls = $value6->anyokma ;
                                                    }
                                                     
                                                    // if ( $sum_Y > $amountpay) {
                                                    //     $yokpai = $sum_Y - $amountpay;
                                                    //     $count_Yok = $count_Y - $stm_count;
                                                    // } else {
                                                    //     $yokpai = $amountpay - $sum_Y;
                                                    //     $count_Yok = $stm_count - $amountpay;
                                                    // }

                                                    // $count_Y

                                            ?>
                                            <div class="row">
                                                <div class="col-md-5 text-start mt-4 ms-4">
                                                    <h5 > {{$item->MONTH_NAME}} {{$ynew}}</h5>
                                                </div>
                                                <div class="col"></div>
                                                <div class="col-md-5 text-end mt-2 me-2">
                                                    <a href="{{url('account_pkucs202')}}" target="_blank">
                                                        <div class="widget-chart widget-chart-hover" data-bs-toggle="tooltip" data-bs-placement="top" title="จำนวนลูกหนี้ที่ต้องตั้ง">
                                                            <h6 class="text-end">{{$count_N}} Visit</h6>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-1 text-start ms-4">
                                                    <i class="fa-solid fa-2x fa-sack-dollar me-2 align-middle text-secondary"></i>
                                                </div>
                                                <div class="col-md-4 text-start mt-3">
                                                    <p class="text-muted mb-0">
                                                        {{-- <span class="text-secondary fw-bold font-size-15 me-2" style="font-family: sans-serif">ลูกหนี้ทั้งหมด</span> --}}
                                                        ลูกหนี้ที่ต้องตั้ง
                                                    </p>
                                                </div>
                                                <div class="col"></div>
                                                <div class="col-md-5 text-end me-2">
                                                    <a href="" target="_blank">
                                                        <div class="widget-chart widget-chart-hover" >
                                                            <p class="text-end mb-0"  data-bs-toggle="tooltip" data-bs-placement="top" title="ลูกหนี้ที่ต้องตั้ง {{$count_N}} Visit" >
                                                                    {{ number_format($sum_N, 2) }}
                                                                    <i class="fa-brands fa-btc text-secondary ms-2"></i>
                                                            </p>
                                                        </div>
                                                    </a>
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
                                                    <a href="{{url('account_pkucs202_detail/'.$item->months.'/'.$item->year)}}" target="_blank">
                                                        <div class="widget-chart widget-chart-hover">
                                                            <p class="text-end mb-0" data-bs-toggle="tooltip" data-bs-placement="top" title="ตั้งลูกหนี้ {{$count_Y}} Visit">
                                                                    {{ number_format($sum_Y, 2) }}
                                                                    <i class="fa-brands fa-btc text-danger ms-2"></i>
                                                            </p>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-1 text-start ms-4">
                                                    <i class="fa-brands fa-2x fa-bitcoin me-2 align-middle text-success"></i>
                                                </div>
                                                <div class="col-md-4 text-start mt-3">
                                                    <p class="text-muted mb-0">
                                                            Statement
                                                    </p>
                                                </div>
                                                <div class="col"></div>
                                                <div class="col-md-5 text-end me-2">
                                                    <a href="{{url('account_pkucs202_stm/'.$item->months.'/'.$item->year)}}" target="_blank">
                                                        <div class="widget-chart widget-chart-hover">
                                                            <p class="text-end mb-0" data-bs-toggle="tooltip" data-bs-placement="top" title="Statement {{$stm_count}} Visit">
                                                                    {{ number_format($amountpay, 2) }}
                                                                    <i class="fa-brands fa-btc text-success ms-2"></i>
                                                            </p>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-1 text-start ms-4">
                                                    <i class="fa-brands fa-2x fa-bitcoin me-2 align-middle" style="color: rgb(160, 12, 98)"></i>
                                                </div>
                                                <div class="col-md-4 text-start mt-3">
                                                    <p class="text-muted mb-0">
                                                            ยกยอดไปเดือนนี้
                                                    </p>
                                                </div>
                                                <div class="col"></div>
                                                <div class="col-md-5 text-end me-2">
                                                    <a href="{{url('account_pkucs202_stmnull/'.$item->months.'/'.$item->year)}}" target="_blank">
                                                        <div class="widget-chart widget-chart-hover">
                                                            <p class="text-end mb-0" data-bs-toggle="tooltip" data-bs-placement="top" title="ยกยอดไปเดือนนี้ {{$count_yokma_alls}} Visit">
                                                                    {{-- {{ number_format($total_yokma, 2) }} --}} 
                                                                     {{ number_format($total_yokma_alls, 2) }}
                                                                    <i class="fa-brands fa-btc ms-2" style="color: rgb(160, 12, 98)"></i>
                                                            </p>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>

                                            {{-- <div class="row">
                                                <div class="col-md-1 text-start ms-4">
                                                    <i class="fa-brands fa-2x fa-bitcoin me-2 align-middle" style="color: rgb(10, 124, 201)"></i>
                                                </div>
                                                <div class="col-md-4 text-start mt-3">
                                                    <p class="text-muted mb-0">
                                                            ยกยอดไปรวมทั้งหมด
                                                    </p>
                                                </div>
                                                <div class="col"></div>
                                                <div class="col-md-5 text-end me-2">
                                                    <a href="{{url('account_pkucs202_stmnull_all/'.$item->months.'/'.$item->year)}}" target="_blank">
                                                        <div class="widget-chart widget-chart-hover">
                                                            <p class="text-end mb-0" data-bs-toggle="tooltip" data-bs-placement="top" title="ยกยอดไปรวมทั้งหมด {{$count_yokma_all}} Visit">
                                                                    {{ number_format($total_yokma_all, 2) }}
                                                                    <i class="fa-brands fa-btc ms-2" style="color: rgb(10, 124, 201)"></i>
                                                            </p>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div> --}}


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
                                                SELECT count(DISTINCT an) as Can
                                                    ,SUM(debit) as sumdebit
                                                    from acc_debtor
                                                        WHERE account_code="1102050101.202"
                                                        AND stamp = "N"
                                                        AND dchdate BETWEEN "'.$startdate.'" AND "'.$enddate.'" 
                                            ');
                                            foreach ($datas as $key => $value) {
                                                $count_N2 = $value->Can;
                                                $sum_N2 = $value->sumdebit;
                                            }
                                            // ตั้งลูกหนี้
                                            $datasum_ = DB::select('
                                                SELECT sum(debit_total) as debit_total,count(DISTINCT an) as Cvit
                                                        from acc_1102050101_202
                                                        WHERE dchdate BETWEEN "'.$startdate.'" AND "'.$enddate.'" 
                                            ');
                                            // AND status = "N"
                                            // AND status = "N"
                                            foreach ($datasum_ as $key => $value2) {
                                                $sum_Y = $value2->debit_total;
                                                $count_Y = $value2->Cvit;
                                            }
                                            // สีเขียว STM
                                            $sumapprove_ = DB::select('
                                                    SELECT count(DISTINCT a.an) as Apvit ,sum(au.ip_paytrue) as ip_paytrue
                                                        FROM acc_1102050101_202 a
                                                        LEFT JOIN acc_stm_ucs au ON au.an = a.an
                                                        WHERE a.dchdate BETWEEN "'.$startdate.'" AND "'.$enddate.'" 
                                                        AND au.ip_paytrue > "0.00"

                                                ');
                                                foreach ($sumapprove_ as $key => $value3) {
                                                    $amountpay = $value3->ip_paytrue;
                                                    $stm_count = $value3->Apvit;
                                                }
                                                // AND au.ip_paytrue IS NOT NULL
                                                // > "0.00"
                                                // สีส้ม ยกยอดไป
                                                // $sumyokma_ = DB::select('
                                                //     SELECT count(DISTINCT an) as anyokma ,sum(debit_total) as debityokma
                                                //             FROM acc_1102050101_202
                                                //             WHERE dchdate BETWEEN "'.$startdate.'" AND "'.$enddate.'" 
                                                //             AND status ="N"
                                                // ');
                                                // foreach ($sumyokma_ as $key => $value5) {
                                                //     $total_yokma = $value5->debityokma;
                                                //     $count_yokma = $value5->anyokma;
                                                // }
                                                
                                                // $mo = $item->months;
                                                $sumyokma_all_ = DB::select('
                                                    SELECT count(DISTINCT U1.an) as anyokma ,sum(U1.debit_total) as debityokma
                                                            FROM acc_1102050101_202 U1
                                                            LEFT JOIN acc_stm_ucs U2 ON U2.an = U1.an
                                                            WHERE U1.dchdate BETWEEN "'.$startdate.'" AND "'.$enddate.'" 
                                                          
                                                            AND (U2.rep IS NULL OR U2.ip_paytrue = "0.00")
                                                ');
                                                // AND U2.ip_paytrue = "0.00"
                                                foreach ($sumyokma_all_ as $key => $value6) {
                                                    $total_yokma_all = $value6->debityokma ;
                                                    $count_yokma_all = $value6->anyokma;
                                                }
                                                // foreach ($sumyokma_all_ as $key => $value6) {
                                                //     $total_yokma_all = $value6->debityokma + $total_yokma;
                                                //     $count_yokma_all = $value6->anyokma + $count_yokma;
                                                // }

                                                // if ( $sum_Y > $amountpay) {
                                                //     $yokpai = $sum_Y - $amountpay;
                                                //     $count_Yok = $count_Y - $stm_count;
                                                // } else {
                                                //     $yokpai = $amountpay - $sum_Y;
                                                //     $count_Yok = $stm_count - $amountpay;
                                                // }

                                                // $sumyokma_all_ = DB::select('
                                                //     SELECT count(DISTINCT U1.an) as anyokma ,sum(U1.debit_total) as debityokma
                                                //             FROM acc_1102050101_202 U1
                                                //             LEFT JOIN acc_stm_ucs U2 ON U2.an = U1.an
                                                //             WHERE U1.status ="N" AND U1.dchdate BETWEEN "'.$startdate.'" AND "'.$enddate.'" 
                                                //             AND U2.rep IS NULL
                                                // ');

                                                // $count_Y

                                        ?>
                                        <div class="row">
                                            <div class="col-md-5 text-start mt-4 ms-4">
                                                <h5 > {{$item->MONTH_NAME}} {{$ynew}}</h5>
                                            </div>
                                            <div class="col"></div>
                                            <div class="col-md-5 text-end mt-2 me-2">
                                            
                                                    <div class="widget-chart widget-chart-hover" data-bs-toggle="tooltip" data-bs-placement="top" title="จำนวนลูกหนี้ที่ต้องตั้ง">
                                                        <h6 class="text-end">{{$count_N2}} Visit</h6>
                                                    </div>
                                             
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-1 text-start ms-4">
                                                <i class="fa-solid fa-2x fa-sack-dollar me-2 align-middle text-secondary"></i>
                                            </div>
                                            <div class="col-md-4 text-start mt-3">
                                                <p class="text-muted mb-0">
                                                    {{-- <span class="text-secondary fw-bold font-size-15 me-2" style="font-family: sans-serif">ลูกหนี้ทั้งหมด</span> --}}
                                                    ลูกหนี้ที่ต้องตั้ง
                                                </p>
                                            </div>
                                            <div class="col"></div>
                                            <div class="col-md-5 text-end me-2">
                                             
                                                    <div class="widget-chart widget-chart-hover" >
                                                        <p class="text-end mb-0"  data-bs-toggle="tooltip" data-bs-placement="top" title="ลูกหนี้ที่ต้องตั้ง {{$count_N2}} Visit" >
                                                                {{ number_format($sum_N2, 2) }}
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
                                                <a href="{{url('account_pkucs202_detail_date/'.$startdate.'/'.$enddate)}}" target="_blank">
                                                    <div class="widget-chart widget-chart-hover">
                                                        <p class="text-end mb-0" data-bs-toggle="tooltip" data-bs-placement="top" title="ตั้งลูกหนี้ {{$count_Y}} Visit">
                                                                {{ number_format($sum_Y, 2) }}
                                                                <i class="fa-brands fa-btc text-danger ms-2"></i>
                                                        </p>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-1 text-start ms-4">
                                                <i class="fa-brands fa-2x fa-bitcoin me-2 align-middle text-success"></i>
                                            </div>
                                            <div class="col-md-4 text-start mt-3">
                                                <p class="text-muted mb-0">
                                                        Statement
                                                </p>
                                            </div>
                                            <div class="col"></div>
                                            <div class="col-md-5 text-end me-2">
                                                <a href="{{url('account_pkucs202_stm_date/'.$startdate.'/'.$enddate)}}" target="_blank">
                                                    <div class="widget-chart widget-chart-hover">
                                                        <p class="text-end mb-0" data-bs-toggle="tooltip" data-bs-placement="top" title="Statement {{$stm_count}} Visit">
                                                                {{ number_format($amountpay, 2) }}
                                                                <i class="fa-brands fa-btc text-success ms-2"></i>
                                                        </p>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-1 text-start ms-4">
                                                <i class="fa-brands fa-2x fa-bitcoin me-2 align-middle" style="color: rgb(160, 12, 98)"></i>
                                            </div>
                                            <div class="col-md-4 text-start mt-3">
                                                <p class="text-muted mb-0">
                                                        ยกยอดไปเดือนนี้
                                                </p>
                                            </div>
                                            <div class="col"></div>
                                            <div class="col-md-5 text-end me-2">
                                                <a href="{{url('account_pkucs202_stmnull_date/'.$startdate.'/'.$enddate)}}" target="_blank">
                                                    <div class="widget-chart widget-chart-hover">
                                                        <p class="text-end mb-0" data-bs-toggle="tooltip" data-bs-placement="top" title="ยกยอดไปเดือนนี้ {{$count_yokma_all}} Visit">
                                                                {{-- {{ number_format($total_yokma, 2) }} --}} 
                                                                 {{ number_format($total_yokma_all, 2) }}
                                                                <i class="fa-brands fa-btc ms-2" style="color: rgb(160, 12, 98)"></i>
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

            $('#Processdata').click(function() {
                var datepicker = $('#datepicker').val(); 
                var datepicker2 = $('#datepicker2').val(); 
                Swal.fire({
                        title: 'ต้องการประมวลผลใหม่ใช่ไหม ?',
                        text: "You Warn Process Data!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, pull it!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $("#overlay").fadeIn(300);　
                                $("#spinner").show(); //Load button clicked show spinner 
                                
                                $.ajax({
                                    url: "{{ route('acc.account_pkucs202_processdata') }}",
                                    type: "POST",
                                    dataType: 'json',
                                    data: {
                                        datepicker,
                                        datepicker2                        
                                    },
                                    success: function(data) {
                                        if (data.status == 200) { 
                                            Swal.fire({
                                                title: 'ประมวลผลสำเร็จ',
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
