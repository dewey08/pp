<!doctype html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
<title>รายงานปัญหาที่มีการแจ้งซ่อมเครื่องปรับอากาศรายเดือน</title>

{{-- <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' /> --}}
{{-- <link href='https://fonts.googleapis.com/css?family=Kanit&subset=thai,latin' rel='stylesheet' type='text/css'> --}}
{{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"> --}}

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"type='text/css'>
{{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous"> --}}
{{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous"> --}}
</head>

<style type="text/css">
  @font-face {
      font-family: 'THSarabunNew';
      src: url({{ storage_path('fonts/THSarabunNew.ttf') }}) format('truetype');
      font-weight: 100; // use the matching font-weight here ( 100, 200, 300, 400, etc).
      font-style: normal; // use the matching font-style here
  }
  body{
      font-family: "THSarabunNew",  //set your font name u can set custom font name also which u set in @font-face css rule

    }
    header {
            position: fixed;
            top: -20px;
            left: 0px;
            right: 0px;
            height: 20px;
            font-size: 20px !important;

            /** Extra personal styles **/
            background-color: #008B8B;
            color: white;
            text-align: center;
            line-height: 35px;
        }

        footer {
            position: fixed;
            bottom: -20px;
            left: 0px;
            right: 0px;
            height: 20px;
            font-size: 20px !important;

            /** Extra personal styles **/
            background-color: #008B8B;
            color: white;
            text-align: center;
            line-height: 35px;
        }

        .bottom-date {
            position: relative;
        }

        .bottom-date-text {
            position: absolute;
            top: -3;
            left: 70;
            width: 140px;
            text-align: center;
        }

        table,
        td {
            border-collapse: collapse; //กรอบด้านในหายไป
        }

        td.o {
            border: 0.1px solid rgb(5, 5, 5);
        }

        table.one {
            border: 0.1px solid rgb(5, 5, 5);
        }
    /* .page-break {
        page-break-after: always;
    } */
    /* .pagenum:before {
        content: counter(page);
    } */
    @media print {
      footer {page-break-after: always;}
    }
</style>
{{-- <h1>Page 1</h1>
<div class="page-break"></div>
<h1>Page 2</h1> --}}
<body>
  <div class="container-fluid text-center">
    @php
      $row_in_table = 13;
    @endphp
    @forelse ($datashow as $item)
          @if ($loop->iteration % $row_in_table == 1)
              <div class="row">
                <div class="col-md-12">
                  <label for="" style="font-size:15px;"><b>รายงานปัญหาที่มีการแจ้งซ่อมเครื่องปรับอากาศรายเดือน</b></label>
                    {{-- <table>
                      <tr style="height: 10px">
                        <td style="font-size: 13px;width: 200px"><b class="me-2">ชื่อหน่วยงาน</b> {{$wh_request->DEPARTMENT_SUB_SUB_NAME}}</td>
                        <td style="font-size: 13px;width: 250px"> </td>
                        <td style="font-size: 13px"><b class="me-2">ใบเบิกวัสดุเลขที่</b> {{$wh_request->request_no}}</td>
                      </tr>
                      <tr style="height: 10px">
                        <td style="font-size: 13px;width: 200px"><b class="me-2">เรื่อง</b> ขออนุมัติเบิก</td>
                        <td style="font-size: 13px;width: 250px"></td>
                        <td style="font-size: 13px"><b class="me-2">วันที่</b> {{DateThai($wh_request->request_date)}}</td>
                      </tr>
                      <tr style="height: 10px">
                        <td style="font-size: 13px;width: 200px"><b class="me-2">เรียน</b> หัวหน้าหน่วยพัสดุ</td>
                        <td style="font-size: 13px;width: 250px"></td>
                        <td style="font-size: 13px"></td>
                      </tr>

                    </table>
                    <table>
                        <tr style="height: 10px">
                            <td style="font-size: 13px;width: 90px"></td>
                            <td style="font-size: 13px;width: auto">ข้าพเจ้าขอเบิกพัสดุตามรายการข้างล่างนี้ เพื่อใช้ในราชการ โรงพยาบาลภูเขียวเฉลิมพระเกียรติ</td>
                        </tr>
                    </table>
                    <table>
                      <tr style="height: 10px">
                          <td style="font-size: 13px;width: auto">และมอบให้................................................................................ตำแหน่ง....................................................................เป็นผู้รับ ตามใบเบิกนี้</td>
                      </tr>
                    </table> --}}
                </div>
              </div>
              <div class="row mt-3">
                  <div class="col-xl-12">
                          <table class="mb-4" style="width: 100%;">
                              <thead>
                                <tr style="font-size: 11px;height: 11px;" class="text-center">
                                    <th style="border: 1px solid black;width: 5%;background-color: rgb(209, 178, 255);color:#FFFFFF">ลำดับ</th>
                                    <th style="border: 1px solid black;width: 10%;background-color: rgb(209, 178, 255);color:#FFFFFF">เดือน</th>
                                    <th style="border: 1px solid black;width: 7%;background-color: rgb(209, 178, 255);color:#FFFFFF">ปี</th>
                                    <th style="border: 1px solid black;width: 11%;background-color: rgb(209, 178, 255);color:#FFFFFF">AIR ทั้งหมด(เครื่อง)</th>
                                    <th style="border: 1px solid black;width: 11%;background-color: rgb(209, 178, 255);color:#FFFFFF">AIR ที่ซ่อม(เครื่อง)</th>
                                    <th style="border: 1px solid black;width: 14%;background-color: rgb(209, 178, 255);color:#FFFFFF">ปัญหาซ่อม AIR(รายการ)</th>
                                    <th style="border: 1px solid black;width: 13%;background-color: rgb(209, 178, 255);color:#FFFFFF">แผนการบำรุงรักษา(ครั้ง)</th>
                                    <th style="border: 1px solid black;width: 12%;background-color: rgb(209, 178, 255);color:#FFFFFF">ผลการบำรุงรักษา(ครั้ง)</th>
                                    <th style="border: 1px solid black;width: 10%;background-color: rgb(209, 178, 255);color:#FFFFFF">ร้อยละ AIR ที่ซ่อม</th>
                                    <th style="border: 1px solid black;width: 13%;background-color: rgb(209, 178, 255);color:#FFFFFF">ร้อยละ AIR ที่บำรุงรักษา</th>
                                </tr>

                              </thead>
                              <tbody>
          @endif

                            @php
                                                    //  $plan_count = DB::select(
                                                    //     'SELECT COUNT(a.air_plan_id) as air_plan_id
                                                    //         FROM air_plan a
                                                    //         LEFT JOIN air_plan_month b ON b.air_plan_month_id = a.air_plan_month_id
                                                    //         WHERE a.air_plan_year = "'.$item->bg_yearnow.'" AND b.air_plan_month = "'.$item->months.'"
                                                    //     ');
                                                    // foreach ($plan_count as $key => $val_count) {
                                                    //     $plan_s   = $val_count->air_plan_id;
                                                    // }

                                                    // $plan_count = DB::select(
                                                    //     'SELECT COUNT(a.air_plan_id) as air_plan_id
                                                    //         FROM air_plan a
                                                    //         LEFT JOIN air_plan_month b ON b.air_plan_month_id = a.air_plan_month_id
                                                    //         WHERE a.air_plan_year = "'.$item->bg_yearnow.'"
                                                    //         AND b.month_no = "'.$item->months.'"
                                                    //     ');
                                                    //     // AND b.air_plan_month = "'.$item->months.'"
                                                    // foreach ($plan_count as $key => $val_count) {
                                                    //     $plan_s   = $val_count->air_plan_id;
                                                    // }

                                                    $plan_count = DB::select(
                                                        'SELECT COUNT(a.air_plan_id) as air_plan_id
                                                            FROM air_plan a
                                                            LEFT JOIN air_plan_month b ON b.air_plan_month_id = a.air_plan_month_id

                                                            WHERE a.air_plan_year = "'.$item->bg_yearnow.'"
                                                            AND b.month_no = "'.$item->months.'"
                                                        ');
                                                        // WHERE a.air_plan_year = "'.$month_years.'" AND b.month_no = "'.$month_ss.'"
                                                    foreach ($plan_count as $key => $val_count) {
                                                        $plan_s   = $val_count->air_plan_id;
                                                    }


                                                    $repaire_air = DB::select('SELECT COUNT(DISTINCT air_list_num) as air_problems FROM air_repaire
                                                    WHERE YEAR(repaire_date) = "'.$item->years.'" AND MONTH(repaire_date) = "'.$item->months.'"');
                                                    foreach ($repaire_air as $key => $rep_air) {$airproblems = $rep_air->air_problems;}

                                                    $repaire_air_pro = DB::select('SELECT COUNT(b.repaire_sub_id) as air_problems04 FROM air_repaire a
                                                        LEFT JOIN air_repaire_sub b ON b.air_repaire_id = a.air_repaire_id
                                                        WHERE YEAR(a.repaire_date) = "'.$item->years.'" AND MONTH(a.repaire_date) = "'.$item->months.'" AND b.air_repaire_type_code ="04"');
                                                    foreach ($repaire_air_pro as $key => $rep_air_pro) {$airproblems04 = $rep_air_pro->air_problems04;}

                                                    $repaire_air_plan = DB::select(
                                                        'SELECT COUNT(DISTINCT a.air_list_num) as air_problems_plan
                                                            FROM air_repaire a
                                                            LEFT JOIN air_repaire_sub b ON b.air_repaire_id = a.air_repaire_id
                                                            WHERE a.budget_year= "'.$item->bg_yearnow.'"
                                                            AND MONTH(a.repaire_date) = "'.$item->months.'"
                                                            AND b.air_repaire_type_code IN("01","02","03")
                                                    ');
                                                    foreach ($repaire_air_plan as $key => $rep_air_plan) {
                                                        $airproblems_plan = $rep_air_plan->air_problems_plan;
                                                    }

                                                    // แผนการบำรุงรักษา
                                                    if ($plan_s < 1) {
                                                        $plan = "0";
                                                        $percent_ploblames =  "0";
                                                        $percent_plan      =  "0";
                                                    } else {
                                                        $plan = $plan_s ;
                                                        $percent_ploblames =  (100 / $item->total_qty) * $airproblems;
                                                        $percent_plan      =  (100 / $plan) * $airproblems_plan;
                                                    }
                            @endphp
                                    <tr style="font-size: 11px;height: 11px;">
                                      <th style="border: 1px solid black;" class="text-center">{{$loop->iteration}}</th>
                                      <td style="border: 1px solid black;" class="text-start">&nbsp;{{$item->MONTH_NAME}}</td>
                                      <td style="border: 1px solid black;" class="text-center">&nbsp;พ.ศ. {{$item->years_ps}}</td>
                                      <td style="border: 1px solid black;" class="text-center">&nbsp;{{$item->total_qty}}</td>
                                      <td style="border: 1px solid black;" class="text-center">&nbsp;{{$airproblems}}</td>
                                      <td style="border: 1px solid black;" class="text-center">&nbsp;{{$airproblems04}}</td>
                                      <td style="border: 1px solid black;" class="text-center">&nbsp;{{$plan}}</td>
                                      <td style="border: 1px solid black;" class="text-center">&nbsp;{{$airproblems_plan}}</td>
                                      <td style="border: 1px solid black;" class="text-center">&nbsp;{{number_format($percent_ploblames, 2)}} %</td>
                                      <td style="border: 1px solid black;" class="text-center">&nbsp;{{number_format($percent_plan, 2)}} %</td>
                                    </tr>

          @if ($loop->last || $loop->iteration % $row_in_table == 0)

                            </tbody>
                        </table>

                        {{-- <table class="mt-5">
                              <tr>
                                <td style="font-size: 12px;width:50px"><b></b></td>
                                <td style="font-size: 12px;width:230px;height: 10px;">ลงชื่อ........................................................ผู้รายงาน<br>
                                  <label style="font-size: 12px;;height: 10px;" class="ms-4">(.......................................................)</label><br>
                                  <label style="font-size: 12px;;height: 10px;" >วันที่ .........................................................</label>
                                </td>
                                <td style="font-size: 12px;width:70px"></td>
                                <td style="font-size: 12px;width:230px;height: 10px;">ลงชื่อ........................................................ผู้ตรวจสอบ<br>
                                  <label style="font-size: 12px;;height: 10px;" class="ms-4">(.......................................................)</label><br>
                                  <label style="font-size: 12px;;height: 10px;" >วันที่ .........................................................</label>
                                </td>
                                <td style="font-size: 12px;width:80px"></td>
                                <td style="font-size: 12px;width:290px;height: 10px;">ลงชื่อ...............................................................................<br>
                                  <label style="font-size: 12px;;height: 10px;" class="ms-4">( ผู้อำนวยการโรงพยาบาลภูเขียวเฉลิมพระเกียรติ )</label><br>
                                  <label style="font-size: 12px;;height: 10px;" >วันที่ .........................................................</label>
                                </td>
                              </tr>
                        </table> --}}
                        <table class="mt-5">
                            <tr>
                              <td style="font-size: 12px;width:18px"><b></b></td>
                              {{-- <td style="font-size: 12px;width:230px;height: 10px;">ลงชื่อ<img src="{{ $siguser }}" class="ms-4 me-4" alt="" height="40px" width="auto">ผู้เสนอแผน<br>
                                <label style="font-size: 12px;;height: 10px;" class="ms-4">&nbsp;&nbsp;&nbsp;{{$ptname}}</label>
                              </td> --}}
                              <td style="font-size: 12px;width:230px;height: 10px;">ลงชื่อ ................................................... ผู้รายงาน<br>
                                <label style="font-size: 12px;;height: 10px;" class="ms-3">(.......................................................)</label>
                              </td>

                              {{-- <td style="font-size: 12px;width:50px"></td>
                              <td style="font-size: 12px;width:230px;height: 10px;">ลงชื่อ<img src="{{ $sigrong }}" class="ms-4 me-4" alt="" height="35px" width="auto">ผู้เห็นชอบ<br>
                                <label style="font-size: 12px;;height: 10px;" class="ms-4">&nbsp;&nbsp;{{$rong_bo}}</label>
                              </td> --}}
                              <td style="font-size: 12px;width:50px"></td>
                              <td style="font-size: 12px;width:230px;height: 10px;">ลงชื่อ ............................................ ผู้ตรวจสอบ<br>
                                <label style="font-size: 12px;;height: 10px;" class="ms-4">&nbsp;&nbsp;{{$rong_bo}}</label>
                              </td>

                              <td style="font-size: 12px;width:50px"></td>
                              <td style="font-size: 12px;width:250px;height: 10px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ลงชื่อ ............................................. ผู้อนุมัติ<br>
                                <label style="font-size: 12px;;height: 10px;" class="ms-4">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{$po}}</label>
                              </td>

                            </tr>
                            <tr>
                              <td style="font-size: 12px;width:18px"><b></b></td>
                              <td style="font-size: 12px;width:150px;height: 10px;"> <p style="font-size: 13px;" class="ms-2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{$position}}</p></td>
                              <td style="font-size: 12px;width:120px;height: 10px;"></td>
                              <td style="font-size: 12px;width:150px;height: 10px;"> <p style="font-size: 13px;" class="ms-2">หัวหน้ากลุ่มภารกิจด้านอำนวยการ</p></td>
                              <td style="font-size: 12px;width:100px;height: 10px;"></td>
                              <td style="font-size: 12px;width:150px;height: 10px;"> <p style="font-size: 13px;" class="ms-2">ผู้อำนวยการโรงพยาบาลภูเขียวเฉลิมพระเกียรติ</p></td>
                            </tr>
                        </table>


                    </div>
                </div>


              @if (!$loop->last)
                  <p style="page-break-after: always;"></p>
              @endif

          @endif
      @empty


    @endforelse


    {{-- <table class="mt-4">
      <tr>
        <td style="font-size: 12px;width:100px"><b></b></td>
        <td style="font-size: 12px;width:230px;height: 10px;">ลงชื่อ........................................................ผู้เบิก<br>
          <label style="font-size: 12px;;height: 10px;" class="ms-4">(.......................................................)</label><br>
          <label style="font-size: 12px;;height: 10px;" >หัวหน้ากลุ่มงาน.....................................................</label>
        </td>
        <td style="font-size: 12px;width:100px"></td>
        <td style="font-size: 12px;width:230px;height: 10px;">ลงชื่อ........................................................ผู้สั่งจ่าย<br>
          <label style="font-size: 12px;;height: 10px;" class="ms-4">(.......................................................)</label><br>
          <label style="font-size: 12px;;height: 10px;" >ตำแหน่ง.....................................................</label>
        </td>
      </tr>
    </table>
    <table  class="mt-2">
        <tr>
          <td style="font-size: 12px;width:130px"><b></b></td>
          <td style="font-size: 12px;width:200px;height: 10px;">ได้รับพัสดุถูกต้องครบถ้วน </td>
          <td style="font-size: 12px;width:130px"><b></b></td>
          <td style="font-size: 12px;width:200px;height: 10px;">ได้จ่ายและลงบัญชีแล้ว </td>
        </tr>
    </table>
    <table class="mt-4">
          <tr>
            <td style="font-size: 12px;width:100px"><b></b></td>
            <td style="font-size: 12px;width:230px;height: 10px;">ลงชื่อ........................................................ผู้รับ<br>
              <label style="font-size: 12px;;height: 10px;" class="ms-4">(.......................................................)</label><br>
              <label style="font-size: 12px;;height: 10px;" >วันที่ .......................................................</label>
            </td>
            <td style="font-size: 12px;width:100px"></td>
            <td style="font-size: 12px;width:230px;height: 10px;">ลงชื่อ........................................................ผู้จ่าย<br>
              <label style="font-size: 12px;;height: 10px;" class="ms-4">(.......................................................)</label><br>
              <label style="font-size: 12px;;height: 10px;" >วันที่ .......................................................</label>
            </td>
          </tr>
    </table>  --}}











 </div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


</body>

</html>
