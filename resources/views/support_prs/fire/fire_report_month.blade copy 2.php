@extends('layouts.support_prs_fireback')
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

    ?>

    <div class="tabs-animation">

        <div id="preloader" class="center">
            <div id="status">
                <div id="container_spin">
                    <svg viewBox="0 0 100 100">
                        <defs>
                            <filter id="shadow">
                            <feDropShadow dx="0" dy="0" stdDeviation="3.5"
                                flood-color="#fc6767"/>
                            </filter>
                        </defs>
                        <circle id="spinner" style="fill:transparent;stroke:#dd2476;stroke-width: 5px;stroke-linecap: round;filter:url(#shadow);" cx="50" cy="50" r="45"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="app-main__outer">
            <div class="app-main__inner">
                <div class="app-page-title app-page-title-simple">
                    <div class="page-title-wrapper">
                        <div class="page-title-heading">
                            <div>

                                <div class="row">
                                    <div class="col-md-10">
                                            <h4 style="color: rgb(255, 255, 255)">รายงานผลการตรวจสอบสภาพถังดับเพลิง  โรงพยาบาลภูเขียวเฉลิมพระเกียรติ จังหวัดชัยภูมิ</h4>
                                    </div>
                                    <div class="col-md-2 text-end">

                                    </div>
                                </div>


                            </div>
                        </div>
                        <div class="page-title-actions">
                        </div>
                    </div>
                </div>
            </div>
        </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card card_prs_4 mt-2">
                        <div class="card-body">
                            <div class="row mt-2">
                                <div class="col-md-12">

                                    <div class="table-responsive">
                                            <table id="example" class="table table-hover table-bordered table-sm dt-responsive nowrap" style=" border-spacing: 0; width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th rowspan="3" class="text-center" style="background-color: rgb(255, 251, 228)">ลำดับ</th>
                                                    <th rowspan="3" class="text-center" style="background-color: rgb(255, 251, 228)">เดือนที่ตรวจ</th>
                                                    <th colspan="6" class="text-center" style="background-color: rgb(255, 237, 117)">ถังดับเพลิงทั้งหมดที่มี (ถัง)</th>
                                                    <th colspan="6" class="text-center" style="background-color: rgb(117, 216, 255)">ถังดับเพลิงที่ได้รับการตรวจสอบ (ถัง)</th>
                                                    <th rowspan="3" class="text-center" style="background-color: rgb(247, 157, 151)">จำนวน<br>ที่ไม่ได้ตรวจ<br>รวม(ถัง)</th>
                                                    <th rowspan="3" class="text-center" style="background-color: rgb(250, 211, 226)">จำนวน<br>ที่ชำรุด<br>รวม(ถัง)</th>
                                                    <th colspan="2" class="text-center" style="background-color: rgb(253, 185, 211)">ร้อยละ</th>
                                                </tr>
                                                <tr>
                                                    <th colspan="3" class="text-center" style="background-color: rgb(255, 176, 157)">ชนิดผงเคมีแห้ง (ถังแดง)</th>
                                                    <th colspan="2" class="text-center" style="background-color: rgb(139, 247, 211)">ชนิดน้ำยาระเหย</th>
                                                    <th rowspan="2" class="text-center" style="background-color: rgb(138, 189, 247)">รวมทั้งหมด / เปลี่ยน</th>
                                                    <th colspan="3" class="text-center" style="background-color: rgb(255, 176, 157)">ชนิดผงเคมีแห้ง (ถังแดง)</th>
                                                    <th colspan="2" class="text-center" style="background-color: rgb(139, 247, 211)">ชนิดน้ำยาระเหย</th>
                                                    <th rowspan="2" class="text-center" style="background-color: rgb(138, 189, 247)">รวมทั้งหมด</th>
                                                    <th rowspan="2" class="text-center" style="background-color: rgb(255, 251, 228)">ที่ตรวจ<br> รวม(ถัง)</th>
                                                    <th rowspan="2" class="text-center" style="background-color: rgb(228, 253, 255)">ที่ชำรุด<br> รวม(ถัง)</th>
                                                </tr>
                                                <tr>
                                                    <th class="text-center" style="background-color: rgb(253, 210, 199)">10 ปอนด์/สำรอง</th>
                                                    <th class="text-center" style="background-color: rgb(253, 210, 199)">15 ปอนด์/สำรอง</th>
                                                    <th class="text-center" style="background-color: rgb(253, 210, 199)">20 ปอนด์/สำรอง</th>
                                                    <th colspan="2" class="text-center" style="background-color: rgb(218, 252, 241)">(ถังเขียว) 10 ปอนด์</th>
                                                    <th class="text-center" style="background-color: rgb(253, 210, 199)">10 ปอนด์</th>
                                                    <th class="text-center" style="background-color: rgb(253, 210, 199)">15 ปอนด์</th>
                                                    <th class="text-center" style="background-color: rgb(253, 210, 199)">20 ปอนด์</th>
                                                    <th colspan="2" class="text-center" style="background-color: rgb(218, 252, 241)">(ถังเขียว) 10 ปอนด์</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 0; ?>
                                                @foreach ($datareport as $itemreport)
                                                    <?php $i++ ?>
                                                    <?php
                                                            $dashboard_ = DB::select(
                                                                'SELECT (SELECT COUNT(fire_id) FROM fire WHERE fire_color = "red" AND fire_year = "'.$itemreport->yearsthai.'" ) as red_all
                                                                    ,(SELECT COUNT(fire_id) FROM fire WHERE fire_color = "red" AND fire_size ="10" AND fire_edit ="Narmal" AND active ="Y" AND fire_backup ="N" AND fire_year = "'.$itemreport->yearsthai.'") as redten
                                                                    ,(SELECT COUNT(fire_id) FROM fire WHERE fire_color = "red" AND fire_size ="15" AND fire_edit ="Narmal" AND active ="Y" AND fire_backup ="N" AND fire_year = "'.$itemreport->yearsthai.'") as redfifteen
                                                                    ,(SELECT COUNT(fire_id) FROM fire WHERE fire_color = "red" AND fire_size ="20" AND fire_edit ="Narmal" AND active ="Y" AND fire_backup ="N" AND fire_year = "'.$itemreport->yearsthai.'") as redtwenty
                                                                    ,(SELECT COUNT(fire_id) FROM fire WHERE fire_color = "green" AND fire_size ="10" AND fire_edit ="Narmal" AND active ="Y" AND fire_backup ="N" AND fire_year = "'.$itemreport->yearsthai.'") as greenten

                                                                    ,(SELECT COUNT(fire_id) FROM fire WHERE fire_color = "red" AND fire_size ="10" AND fire_edit ="Narmal" AND active ="Y" AND fire_backup ="N" AND fire_year = "'.$itemreport->yearsthai.'")+
                                                                    (SELECT COUNT(fire_id) FROM fire WHERE fire_color = "red" AND fire_size ="15" AND fire_edit ="Narmal" AND active ="Y" AND fire_backup ="N" AND fire_year = "'.$itemreport->yearsthai.'")+
                                                                    (SELECT COUNT(fire_id) FROM fire WHERE fire_color = "red" AND fire_size ="20" AND fire_edit ="Narmal" AND active ="Y" AND fire_backup ="N" AND fire_year = "'.$itemreport->yearsthai.'")+
                                                                    (SELECT COUNT(fire_id) FROM fire WHERE fire_color = "green" AND fire_size ="10" AND fire_edit ="Narmal" AND active ="Y" AND fire_backup ="N" AND fire_year = "'.$itemreport->yearsthai.'") total_all

                                                                    ,(SELECT COUNT(fc.fire_id) FROM fire_check fc LEFT JOIN fire f ON f.fire_id=fc.fire_id WHERE fc.fire_check_color = "red" AND f.fire_size ="10" AND month(fc.check_date) = "'.$itemreport->months.'" AND fc.fire_year = "'.$itemreport->yearsthai.'") as Check_redten
                                                                    ,(SELECT COUNT(fc.fire_id) FROM fire_check fc LEFT JOIN fire f ON f.fire_id=fc.fire_id WHERE fc.fire_check_color = "red" AND f.fire_size ="15" AND month(fc.check_date) = "'.$itemreport->months.'" AND fc.fire_year = "'.$itemreport->yearsthai.'") as Check_redfifteen
                                                                    ,(SELECT COUNT(fc.fire_id) FROM fire_check fc LEFT JOIN fire f ON f.fire_id=fc.fire_id WHERE fc.fire_check_color = "red" AND f.fire_size ="20" AND month(fc.check_date) = "'.$itemreport->months.'" AND fc.fire_year = "'.$itemreport->yearsthai.'") as Check_redtwenty
                                                                    ,(SELECT COUNT(fc.fire_id) FROM fire_check fc LEFT JOIN fire f ON f.fire_id=fc.fire_id WHERE fc.fire_check_color = "green" AND f.fire_size ="10" AND month(fc.check_date) = "'.$itemreport->months.'" AND fc.fire_year = "'.$itemreport->yearsthai.'") as Check_greenten

                                                                    ,(SELECT COUNT(fc.fire_id) FROM fire_check fc LEFT JOIN fire f ON f.fire_id=fc.fire_id WHERE fc.fire_check_color = "red" AND f.fire_size ="10" AND month(fc.check_date) = "'.$itemreport->months.'" AND fc.fire_year = "'.$itemreport->yearsthai.'")+
                                                                    (SELECT COUNT(fc.fire_id) FROM fire_check fc LEFT JOIN fire f ON f.fire_id=fc.fire_id WHERE fc.fire_check_color = "red" AND f.fire_size ="15" AND month(fc.check_date) = "'.$itemreport->months.'" AND fc.fire_year = "'.$itemreport->yearsthai.'")+
                                                                    (SELECT COUNT(fc.fire_id) FROM fire_check fc LEFT JOIN fire f ON f.fire_id=fc.fire_id WHERE fc.fire_check_color = "red" AND f.fire_size ="20" AND month(fc.check_date) = "'.$itemreport->months.'" AND fc.fire_year = "'.$itemreport->yearsthai.'")+
                                                                    (SELECT COUNT(fc.fire_id) FROM fire_check fc LEFT JOIN fire f ON f.fire_id=fc.fire_id WHERE fc.fire_check_color = "green" AND f.fire_size ="10" AND month(fc.check_date) = "'.$itemreport->months.'" AND fc.fire_year = "'.$itemreport->yearsthai.'") as Checktotal_all_old
                                                                    ,(SELECT COUNT(fc.fire_id) FROM fire_check fc LEFT JOIN fire f ON f.fire_id=fc.fire_id WHERE month(fc.check_date) = "'.$itemreport->months.'" AND year(fc.check_date) = "'.$itemreport->years.'" AND f.active = "N") as camroot

                                                                    ,(SELECT COUNT(fire_id) FROM fire WHERE fire_color = "green") as green_all
                                                                    ,(SELECT COUNT(fire_id) FROM fire_check WHERE fire_check_color = "green") as Checkgreen_all
                                                                    ,(SELECT COUNT(fire_id) FROM fire WHERE fire_color = "red" AND fire_backup = "Y") as backup_red
                                                                    ,(SELECT COUNT(fire_id) FROM fire WHERE fire_color = "green" AND fire_backup = "Y") as backup_green
                                                                    ,(SELECT COUNT(fire_id) FROM fire_check WHERE month(check_date) = "'.$itemreport->months.'" AND fire_year = "'.$itemreport->yearsthai.'" AND fire_backup = "N") as Checktotal_all
                                                                FROM fire_check f
                                                                WHERE month(f.check_date) = "'.$itemreport->months.'"
                                                                AND f.fire_year = "'.$itemreport->yearsthai.'"
                                                                GROUP BY month(f.check_date)
                                                            ');
                                                            //    dd($counts_);
                                                            foreach ($dashboard_ as $key => $value) {
                                                                // $red_all               = $value->red_all;
                                                                $counts_ = DB::select('SELECT COUNT(fc.fire_id) FROM fire_check fc LEFT JOIN fire f ON f.fire_id=fc.fire_id WHERE month(fc.check_date) = "'.$itemreport->months.'" AND fc.fire_year = "'.$itemreport->yearsthai.'"');
                                                                // if ($counts_ < 1) {
                                                                //     $redten                = '0';
                                                                //     $redfifteen            = '0';
                                                                //     $redtwenty             ='0';
                                                                //     $greenten              ='0';
                                                                //     $total_all             = '0';
                                                                //     $Check_redten          = '0';
                                                                //     $Check_redfifteen      = '0';
                                                                //     $Check_redtwenty       = '0';
                                                                //     $Check_greenten        ='0';
                                                                //     $Checktotal_all        = '0';
                                                                //     $camroot               ='0';
                                                                //     $green_all             = '0';
                                                                //     $Checkgreen_all        = '0';
                                                                // } else {
                                                                    $redten                = $value->redten;
                                                                    $redfifteen            = $value->redfifteen;
                                                                    $redtwenty             = $value->redtwenty;
                                                                    $greenten              = $value->greenten;
                                                                    $total_all             = $value->total_all;
                                                                    $Check_redten          = $value->Check_redten;
                                                                    $Check_redfifteen      = $value->Check_redfifteen;
                                                                    $Check_redtwenty       = $value->Check_redtwenty;
                                                                    $Check_greenten        = $value->Check_greenten;
                                                                    $Checktotal_all        = $value->Checktotal_all;
                                                                    $camroot               = $value->camroot;
                                                                    $green_all             = $value->green_all;
                                                                    $Checkgreen_all        = $value->Checkgreen_all;
                                                                // }


                                                            }
                                                            $sumyokma_all_ = DB::select(
                                                                'SELECT COUNT(f.fire_id) as cfire
                                                                    FROM fire_check fc
                                                                    LEFT OUTER JOIN fire f ON f.fire_id = fc.fire_id
                                                                    WHERE month(fc.check_date) = "'.$itemreport->months.'"
                                                                    AND year(fc.check_date) = "'.$itemreport->years.'"
                                                            ');
                                                            // $trut          = 100 / $itemreport->total_all_qty * ($Check_redten+$Check_redfifteen+$Check_redtwenty+$Check_greenten);
                                                            // $chamrootcount = 100 / $itemreport->total_all_qty * $camroot;

                                                            $trut          = 100 / $itemreport->total_all_qty * $Checktotal_all;
                                                            $chamrootcount = 100 / $itemreport->total_all_qty * $camroot;

                                                            $count_check_ = DB::select('SELECT COUNT(fire_id) as checkfire FROM fire_report WHERE check_status = "N" AND months = "'.$itemreport->months.'" AND years = "'.$itemreport->years.'" ');
                                                            foreach ($count_check_ as $key => $v_check) {
                                                                $count_nocheck   = $v_check->checkfire;
                                                            }
                                                            $m       = date('m');
                                                            $chang_ = DB::select(
                                                                'SELECT COUNT(DISTINCT fc.fire_id) as firechang
                                                                FROM fire f
                                                                INNER JOIN fire_chang fc ON fc.fire_id = f.fire_id
                                                                WHERE MONTH(fc.fire_chang_date) = "'.$itemreport->months.'" AND year(fc.fire_chang_date) = "'.$itemreport->years.'"
                                                            ');
                                                            foreach ($chang_ as $key => $vc) {
                                                                $chang = $vc->firechang;
                                                            }
                                                    ?>
                                                    <tr>
                                                        <td class="text-center text-muted" style="width: 5%;background-color: rgb(2255, 251, 228)">{{$i}}</td>
                                                        <td class="text-start" style="width: 10%;background-color: rgb(2255, 251, 228)">
                                                            {{$itemreport->month_name}} พ.ศ.{{$y}}
                                                        </td>
                                                        <td class="text-center" style="background-color: rgb(255, 255, 255)">
                                                            {{-- <a href="javascript:void(0)" class="badge rounded-pill bg-danger me-2 ms-2">
                                                                {{$itemreport->total_red10}}
                                                            </a> --}}
                                                            <span class="badge rounded-pill bg-danger p-2">{{$itemreport->total_red10}}</span> /
                                                            <span class="badge rounded-pill p-2" style="background-color: #FAACB0">{{$itemreport->total_backup_r10}}</span>
                                                        </td>
                                                        <td class="text-center" style="background-color: rgb(255, 255, 255)">
                                                            {{-- <a href="javascript:void(0)" class="badge rounded-pill bg-danger me-2 ms-2">
                                                                {{$itemreport->total_red15}}
                                                            </a> --}}
                                                            <span class="badge rounded-pill bg-danger p-2">{{$itemreport->total_red15}}</span> /
                                                            <span class="badge rounded-pill p-2" style="background-color: #FAACB0">{{$itemreport->total_backup_r15}}</span>
                                                        </td>
                                                        <td class="text-center" style="background-color: rgb(255, 255, 255)">
                                                            {{-- <a href="javascript:void(0)" class="badge rounded-pill bg-danger me-2 ms-2">
                                                                {{$itemreport->total_red20}}
                                                            </a> --}}
                                                            <span class="badge rounded-pill bg-danger p-2">{{$itemreport->total_red20}}</span> /
                                                            <span class="badge rounded-pill p-2" style="background-color: #FAACB0">{{$itemreport->total_backup_r20}}</span>
                                                        </td>
                                                        <td colspan="2" class="text-center" style="background-color: rgb(255, 255, 255)">
                                                            {{-- <a href="javascript:void(0)" class="badge rounded-pill bg-success me-2 ms-2">
                                                                {{$itemreport->total_green10}}
                                                            </a> --}}
                                                            <span class="badge rounded-pill bg-success p-2">{{$itemreport->total_green10}}</span>
                                                        </td>
                                                        <td class="text-center" style="background-color: rgb(255, 255, 255)">
                                                            {{-- <a href="javascript:void(0)" class="badge rounded-pill bg-info me-2 ms-2">
                                                                {{$itemreport->total_all_qty}}
                                                            </a> --}}
                                                            <span class="badge rounded-pill bg-danger p-2">{{$itemreport->total_all_qty}}</span> /
                                                            <a href="{{url('fire_report_month_chang/'.$itemreport->months.'/'.$itemreport->years)}}" target="_blank" class="badge rounded-pill bg-warning p-2 text-danger">
                                                                {{$chang}}
                                                            </a>
                                                            {{-- <span class="badge rounded-pill bg-warning p-2 text-danger">{{$chang}}</span>  --}}
                                                        </td>
                                                        <td class="text-center" style="background-color: rgb(255, 255, 255)">
                                                            {{-- <a href="javascript:void(0)" class="badge rounded-pill me-2 ms-2" style="background-color: rgb(252, 135, 127)">
                                                                {{$Check_redten}}
                                                            </a> --}}
                                                            <span class="badge rounded-pill p-2" style="background-color: rgb(252, 135, 127)">{{$Check_redten}}</span>
                                                        </td>
                                                        <td class="text-center" style="background-color: rgb(255, 255, 255)">
                                                            {{-- <a href="javascript:void(0)" class="badge rounded-pill me-2 ms-2" style="background-color: rgb(252, 135, 127)">
                                                                {{$Check_redfifteen}}
                                                            </a> --}}
                                                            <span class="badge rounded-pill p-2" style="background-color: rgb(252, 135, 127)">{{$Check_redfifteen}}</span>
                                                        </td>
                                                        <td class="text-center" style="background-color: rgb(255, 255, 255)">
                                                            {{-- <a href="javascript:void(0)" class="badge rounded-pill me-2 ms-2" style="background-color: rgb(252, 135, 127)">
                                                                {{$Check_redtwenty}}
                                                            </a> --}}
                                                            <span class="badge rounded-pill p-2" style="background-color: rgb(252, 135, 127)">{{$Check_redtwenty}}</span>
                                                        </td>
                                                        <td colspan="2" class="text-center" style="background-color: rgb(255, 255, 255)">
                                                            {{-- <a href="javascript:void(0)" class="badge rounded-pill bg-success me-2 ms-2">
                                                                {{$Check_greenten}}

                                                            </a> --}}
                                                            <span class="badge rounded-pill bg-success p-2">{{$Check_greenten}}</span>
                                                        </td>
                                                        <td class="text-center" style="background-color: rgb(219, 243, 252)">
                                                            @if ($itemreport->months == $m)
                                                                <a href="{{url('support_system_check/'.$itemreport->months.'/'.$itemreport->yearsthai)}}" target="_blank" class="badge rounded-pill bg-primary p-2">
                                                                    {{$Checktotal_all}}
                                                                </a>
                                                            @else
                                                            <span class="badge rounded-pill bg-primary p-2">{{$Checktotal_all}}</span>

                                                            @endif

                                                        </td>

                                                        <td class="text-center" style="background-color: rgb(253, 202, 198)">
                                                            <a href="{{url('support_system_nocheck/'.$itemreport->months.'/'.$itemreport->yearsthai)}}" target="_blank" class="badge rounded-pill p-2" style="background-color: rgb(252, 123, 114)">
                                                            {{-- <a href="" target="_blank" class="badge rounded-pill p-2" style="background-color: rgb(253, 80, 68)"> --}}
                                                                {{-- {{$count_nocheck}} --}}
                                                                {{$itemreport->total_all_qty-$Checktotal_all}}
                                                            </a>
                                                        </td>
                                                        <td class="text-center" style="background-color: rgb(255, 255, 255)">
                                                            {{-- <a href="javascript:void(0)" class="badge rounded-pill p-2" style="background-color: #da0d06">
                                                                {{$camroot}}
                                                            </a> --}}
                                                            <span class="badge rounded-pill p-2" style="background-color: #da0d06">{{$camroot}}</span>
                                                        </td>
                                                        <td class="text-center" style="background-color: rgb(255, 255, 255)">
                                                            {{-- <a href="javascript:void(0)" class="badge rounded-pill p-2" style="background-color: #4becd1">
                                                                {{ number_format($trut, 2) }}
                                                            </a> --}}
                                                            <span class="badge rounded-pill p-2" style="background-color: #4becd1"> {{ number_format($trut, 2) }}</span>
                                                        </td>
                                                        <td class="text-center" style="background-color: rgb(255, 255, 255)">
                                                            {{-- <a href="javascript:void(0)" class="badge rounded-pill bg-warning p-2">
                                                                {{ number_format($chamrootcount, 2) }}
                                                            </a> --}}
                                                            <span class="badge rounded-pill p-2" style="background-color: #d6413c"> {{ number_format($chamrootcount, 2) }}</span>
                                                        </td>
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

            $('#datepicker').datepicker({
                format: 'yyyy-mm-dd'
            });
            $('#datepicker2').datepicker({
                format: 'yyyy-mm-dd'
            });
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



        });

        $(document).on('click', '.aircountModal', function() {
            var air_location_id = $(this).val();
            $('#aircountModal').modal('show');
            $.ajax({
                type: "GET",
                url:"{{ url('support_detail') }}",
                data: { air_location_id: air_location_id },
                success: function(result) {
                    $('#detail').html(result);
                },
            });
        });

        $(document).on('click', '.problems_1Modal', function() {
            var air_location_id = $(this).val();
            $('#problems_1Modal').modal('show');
            $.ajax({
                type: "GET",
                url:"{{ url('detail_ploblem_1') }}",
                data: { air_location_id: air_location_id },
                success: function(result) {
                    $('#detail_ploblem_1').html(result);
                },
            });
        });



    </script>

@endsection

