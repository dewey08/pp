@extends('layouts.support_prs_gas')
@section('title', 'PK-OFFICE || ก๊าซทางการแพทย์')

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
    ?>

    <div class="tabs-animation">

        <div id="preloader">
            <div id="status">
                <div id="container_spin">
                    <svg viewBox="0 0 100 100">
                        <defs>
                            <filter id="shadow">
                            <feDropShadow dx="0" dy="0" stdDeviation="2.5"
                                flood-color="#fc6767"/>
                            </filter>
                        </defs>
                        <circle id="spinner" style="fill:transparent;stroke:#dd2476;stroke-width: 5px;stroke-linecap: round;filter:url(#shadow);" cx="50" cy="50" r="45"/>
                    </svg>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-md-4">
                <h4 style="color:rgb(255, 255, 255)">รายงานประจำเดือนก๊าซทางการแพทย์</h4>
            </div>
            <div class="col"></div>

            <div class="col-md-2 text-center">

                <button type="submit" class="ladda-button btn-pill btn btn-sm btn-info bt_prs me-2" data-style="expand-left">
                    <span class="ladda-label"> <i class="fa-solid fa-magnifying-glass text-white me-2"></i>ค้นหา</span>
                </button>
                <a href="{{URL('air_report_monthpdf')}}" class="ladda-button me-2 btn-pill btn btn-sm btn-primary bt_prs">
                    <i class="fa-solid fa-print me-2 text-white" style="font-size:13px"></i>
                    <span>Print all</span>
                </a>

            </div>
            {{-- <div class="col-md-1 text-end mt-2">วันที่</div>
            <div class="col-md-5 text-end">
                <form action="{{ url('gas_control') }}" method="GET">
                    @csrf
                <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker1'>
                    <input type="text" class="form-control bt_prs" name="startdate" id="datepicker" placeholder="Start Date" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                        data-date-language="th-th" value="{{ $startdate }}" required/>
                    <input type="text" class="form-control bt_prs" name="enddate" placeholder="End Date" id="datepicker2" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                        data-date-language="th-th" value="{{ $enddate }}"/>
                        <button type="submit" class="ladda-button btn-pill btn btn-primary bt_prs" data-style="expand-left">
                            <span class="ladda-label"> <i class="fa-solid fa-magnifying-glass text-white me-2"></i>ค้นหา</span>
                        </button>
                    </form>

                <a href="{{url('gas_control_add')}}" target="_blank" class="ladda-button me-2 btn-pill btn btn-info bt_prs">
                    <i class="fa-solid fa-circle-plus text-white me-2"></i>
                    Check
                </a>
            </div> --}}
        </div>
    </div>

        <div class="row mt-3">
            <div class="col-xl-12">
                <div class="card card_prs_4">
                    <div class="card-body">
                        <div class="table-responsive">
                        {{-- <table id="example" class="table table-hover table-sm dt-responsive nowrap myTable" style=" border-spacing: 0; width: 100%;"> --}}
                        <table class="table table-hover table-sm dt-responsive nowrap myTable" style=" border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr style="font-size:12px">
                                            <th rowspan="2" class="text-center" style="background-color: #f5cbbe;color:#4d4b4b;" width= "2%">ลำดับ</th>
                                            <th rowspan="2" class="text-center" style="background-color: #92ddca;color:#4d4b4b;" width= "7%">เดือน</th>
                                            <th rowspan="2" class="text-center" style="background-color: #92ddca;color:#4d4b4b;" width= "3%">ปี</th>
                                            <th rowspan="2" class="text-center" style="background-color: #92ddca;color:#4d4b4b;" width= "3%">จำนวนวัน</th>
                                            <th colspan="2" class="text-center" style="background-color: #e9b1f7" width= "8%">Tank Liquid Oxygen(Main)</th>
                                            <th colspan="2" class="text-center" style="background-color: #b1e9f7" width= "8%">Tank Liquid Oxygen(Sub)</th>
                                            <th colspan="2" class="text-center" style="background-color: #fca8dc" width= "8%">ไนตรัสออกไซด์ (N2O-6Q)</th>
                                            <th colspan="2" class="text-center" style="background-color: #d1fdd8" width= "8%">ก๊าซอ๊อกซิเจน (2Q-6Q)</th>
                                            <th colspan="2" class="text-center" style="background-color: #f7bcb1" width= "8%">Control Gas</th>
                                        </tr>
                                        <tr style="font-size:12px">
                                            {{-- <th class="text-center" style="background-color: #f3e1f8">(วัน)</th> --}}
                                            <th class="text-center" style="background-color: #f3e1f8">(ทั้งหมด)</th>
                                            <th class="text-center" style="background-color: #f3e1f8">(ตรวจ)</th>
                                            <th class="text-center" style="background-color: #cdf3fd">(ทั้งหมด)</th>
                                            <th class="text-center" style="background-color: #cdf3fd">(ตรวจ)</th>
                                            <th class="text-center" style="background-color: #fcdaef">(ทั้งหมด)</th>
                                            <th class="text-center" style="background-color: #fcdaef">(ตรวจ)</th>
                                            <th class="text-center" style="background-color: #e4fde9">(ทั้งหมด)</th>
                                            <th class="text-center" style="background-color: #e4fde9">(ตรวจ)</th>
                                            <th class="text-center" style="background-color: #fde1dc">(ทั้งหมด)</th>
                                            <th class="text-center" style="background-color: #fde1dc">(ตรวจ)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1;
                                        $start = new DateTime('first day of this month midnight');
                                        $end   = new DateTime('first day of next month midnight');
                                            // echo $start->format('Y-m-d H:i:s'); // 2022-12-01 00:00:00
                                            // echo $end->format('Y-m-d H:i:s'); // 2023-01-01 00:00:00
                                            $interval = new DateInterval('P1D'); // ระยะเวลาห่างกัน 1 วัน
                                            $period = new DatePeriod($start, $interval, $end);
                                            // foreach ($period as $dt) {
                                                // echo $dt->format("Y-m-d")."<br>";
                                                //   echo $dt->format("Y-m-d")."<br>";
                                            // }
                                            // echo $period[];
                                            // echo $end->format('Y-m-d H:i:s');
                                        ?>
                                        @foreach ($datashow as $item)

                                            @php
                                               $data_m1_ = DB::select('SELECT month_day FROM months WHERE month_no ="'.$item->months.'"');
                                                    foreach ($data_m1_ as $key => $v1) {$data_m1 = $v1->month_day;}

                                                $main_count = DB::select('SELECT COUNT(gas_list_id) as cmain FROM gas_check WHERE gas_type ="1" AND active ="Ready" AND month(check_date) = "'.$item->months.'" AND year(check_date) = "'.$item->years.'"');
                                                    foreach ($main_count as $key => $val_count) {$count_main = $val_count->cmain;}
                                                $main_count2 = DB::select('SELECT COUNT(gas_list_id) as cmain FROM gas_list WHERE gas_type ="1" AND active ="Ready"');
                                                    foreach ($main_count2 as $key => $val_count2) {$count_main2 = $val_count2->cmain;}

                                                $sub_count = DB::select('SELECT COUNT(gas_list_id) as cmain FROM gas_list WHERE gas_type ="2" AND active ="Ready"');
                                                    foreach ($sub_count as $key => $val_count3) {$count_sub = $val_count3->cmain;}
                                                $sub_count2 = DB::select('SELECT COUNT(gas_list_id) as cmain FROM gas_check WHERE gas_type ="2" AND active ="Ready" AND month(check_date) = "'.$item->months.'" AND year(check_date) = "'.$item->years.'"');
                                                    foreach ($sub_count2 as $key => $val_count4) {$check_sub = $val_count4->cmain;}

                                                $n2o_count = DB::select('SELECT COUNT(gas_list_id) as cmain FROM gas_list WHERE gas_type ="5" AND active ="Ready"');
                                                    foreach ($n2o_count as $key => $val_count5) {$count_n2o = $val_count5->cmain;}
                                                $n2o_count2 = DB::select('SELECT COUNT(gas_list_id) as cmain FROM gas_check WHERE gas_type ="5" AND active ="Ready" AND month(check_date) = "'.$item->months.'" AND year(check_date) = "'.$item->years.'"');
                                                    foreach ($n2o_count2 as $key => $val_count6) {$check_n2o = $val_count6->cmain;}

                                                $oq2q6_count = DB::select('SELECT COUNT(gas_list_id) as cmain FROM gas_list WHERE gas_type IN("3","4") AND active ="Ready"');
                                                    foreach ($oq2q6_count as $key => $val_count7) {$count_oq2q6 = $val_count7->cmain;}
                                                $oq2q6_countcheck = DB::select('SELECT COUNT(gas_list_id) as cmain FROM gas_check WHERE gas_type IN("3","4") AND active ="Ready" AND month(check_date) = "'.$item->months.'" AND year(check_date) = "'.$item->years.'"');
                                                    foreach ($oq2q6_countcheck as $key => $val_count8) {$checkoq2q6_count = $val_count8->cmain;}

                                            @endphp

                                            <tr id="tr_{{$item->gas_report_id}}">
                                                <td class="text-center" width="5%">{{ $i++ }}</td>
                                                <td class="text-start" width="10%" style="font-size: 12px">{{ $item->month_name }}</td>
                                                <td class="text-start" style="font-size: 11px">{{ $item->years_th }}</td>
                                                <td class="text-center" style="font-size: 11px">{{$data_m1}}</td>
                                                <td class="text-center" style="font-size: 11px;color:#d135c9">{{ $count_main2*$data_m1 }}</td>
                                                <td class="text-center" style="font-size: 11px;color:#05b186">{{ $count_main }}</td>
                                                <td class="text-center" style="font-size: 11px;color:#269bb8">{{ $count_sub*$data_m1 }}</td>
                                                <td class="text-center" style="font-size: 11px;color:#54c6e2">{{ $check_sub }}</td>
                                                <td class="text-center" style="font-size: 11px;color:#f56dc1">{{ $count_n2o*$data_m1 }}</td>
                                                <td class="text-center" style="font-size: 11px;color:#f88ed0">{{ $check_n2o }}</td>
                                                <td class="text-center" style="font-size: 11px;color:#1db356">{{ $count_oq2q6*$data_m1 }}</td>
                                                <td class="text-center" style="font-size: 11px;color:#50e087">{{ $checkoq2q6_count }}</td>
                                                <td class="text-center" style="font-size: 11px;color:#d135c9"></td>
                                                <td class="text-center" style="font-size: 11px;color:#d135c9"></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
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
        $(document).ready(function() {
            var table = $('#example').DataTable({
                scrollY: '60vh',
                scrollCollapse: true,
                scrollX: true,
                "autoWidth": false,
                "pageLength": 10,
                "lengthMenu": [10,25,30,31,50,100,150,200,300],
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


        });
    </script>
    @endsection
