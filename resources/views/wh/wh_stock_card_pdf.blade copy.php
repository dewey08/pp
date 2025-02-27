<!doctype html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
<title>ทะเบียนควบคุมเวชภัณฑ์</title>

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
 
    @media print {
      footer {page-break-after: always;}
    }
</style>
 
<body>
 
  <div class="container-fluid text-center">
    @php
      $row_in_table = 13;
    @endphp
    
    <table style="width: 100%;">
      <tr>
        <th width="20%"></th>
        <th class="text-center" width="50%"><label for="" style="font-size:15px;"><b>ทะเบียนควบคุมเวชภัณฑ์</b></label>  </th>
        <th width="20%"></th>
      </tr>  
    </table>
    <table style="width: 100%;"> 
      <tr> 
        <th class="text-start" width="40%"><label for="" style="font-size:14px;">คลังเวชภัณฑ์ {{$stock_name}}</label></th>
        <th class="text-start" width="40%"><label for="" style="font-size:14px;">ชื่อเวชภัณฑ์ {{$pro_name}}</label></th>
        <th class="text-start" width="15%"><label for="" style="font-size:13px;">แผ่นที่ ......... หน้าที่ .........</label></th>
      </tr> 
    </table>
    {{-- <table style="width: 100%;"> 
      <tr> 
        <th class="text-start" width="100%"><label for="" style="font-size:14px;">ชื่อเวชภัณฑ์</label></th> 
      </tr> 
    </table> --}}
    @forelse ($datashow as $item)
          @if ($loop->iteration % $row_in_table == 1)
             
              <div class="row mt-2">
                  <div class="col-xl-12">
                          <table class="mb-4" style="width: 100%;">
                              <thead>
                                <tr style="font-size: 12px;height: 11px;" class="text-center">                            
                                    <th colspan="7" style="border: 1px solid black;width: 10%;background-color: rgb(145, 225, 235);color:#252424">รับ</th>
                                    <th colspan="5" style="border: 1px solid black;width: 7%;background-color: rgb(247, 226, 171);color:#252424">จ่าย</th> 
                                </tr>
                                <tr style="font-size: 11px;height: 11px;" class="text-center">                            
                                  <th style="border: 1px solid black;width: 8%;background-color: rgb(192, 243, 250);color:#252424">ว/ด/ป</th>
                                  <th style="border: 1px solid black;width: 10%;background-color: rgb(192, 243, 250);color:#252424">บริษัท</th>
                                  <th style="border: 1px solid black;width: 7%;background-color: rgb(192, 243, 250);color:#252424">เลขที่ใบส่งของ</th>
                                  <th style="border: 1px solid black;width: 6%;background-color: rgb(192, 243, 250);color:#252424">จำนวนรับ</th>
                                  <th style="border: 1px solid black;width: 6%;background-color: rgb(192, 243, 250);color:#252424">รวมรับ</th>
                                  <th style="border: 1px solid black;width: 8%;background-color: rgb(192, 243, 250);color:#252424">ราคา/หน่วย</th>
                                  <th style="border: 1px solid black;width: 12%;background-color: rgb(192, 243, 250);color:#252424">วันหมดอายุ</th> 
                                  <th style="border: 1px solid black;width: 10%;background-color: rgb(250, 238, 209);color:#252424">ว/ด/ป</th>
                                  <th style="border: 1px solid black;width: 8%;background-color: rgb(250, 238, 209);color:#252424">จำนวนจ่าย</th>
                                  <th style="border: 1px solid black;width: 8%;background-color: rgb(250, 238, 209);color:#252424">รวมจ่าย</th>
                                  <th style="border: 1px solid black;width: 8%;background-color: rgb(250, 238, 209);color:#252424">คงเหลือ</th>
                                  <th style="border: 1px solid black;width: 14%;background-color: rgb(250, 238, 209);color:#252424">เลขที่ใบเบิก</th>
                              </tr>

                              </thead>
                              <tbody>
          @endif

                            @php
                                                 

                                                    // $plan_count = DB::select(
                                                    //     'SELECT COUNT(a.air_plan_id) as air_plan_id
                                                    //         FROM air_plan a
                                                    //         LEFT JOIN air_plan_month b ON b.air_plan_month_id = a.air_plan_month_id

                                                    //         WHERE a.air_plan_year = "'.$item->bg_yearnow.'"
                                                    //         AND b.month_no = "'.$item->months.'"
                                                    //     ');
                                                         
                                                    // foreach ($plan_count as $key => $val_count) {
                                                    //     $plan_s   = $val_count->air_plan_id;
                                                    // }


                                                    // $repaire_air = DB::select('SELECT COUNT(DISTINCT air_list_num) as air_problems FROM air_repaire
                                                    // WHERE YEAR(repaire_date) = "'.$item->years.'" AND MONTH(repaire_date) = "'.$item->months.'"');
                                                    // foreach ($repaire_air as $key => $rep_air) {$airproblems = $rep_air->air_problems;}

                                                    // $repaire_air_pro = DB::select('SELECT COUNT(b.repaire_sub_id) as air_problems04 FROM air_repaire a
                                                    //     LEFT JOIN air_repaire_sub b ON b.air_repaire_id = a.air_repaire_id
                                                    //     WHERE YEAR(a.repaire_date) = "'.$item->years.'" AND MONTH(a.repaire_date) = "'.$item->months.'" AND b.air_repaire_type_code ="04"');
                                                    // foreach ($repaire_air_pro as $key => $rep_air_pro) {$airproblems04 = $rep_air_pro->air_problems04;}

                                                    // $repaire_air_plan = DB::select(
                                                    //     'SELECT COUNT(DISTINCT a.air_list_num) as air_problems_plan
                                                    //         FROM air_repaire a
                                                    //         LEFT JOIN air_repaire_sub b ON b.air_repaire_id = a.air_repaire_id
                                                    //         WHERE a.budget_year= "'.$item->bg_yearnow.'"
                                                    //         AND MONTH(a.repaire_date) = "'.$item->months.'"
                                                    //         AND b.air_repaire_type_code IN("01","02","03")
                                                    // ');
                                                    // foreach ($repaire_air_plan as $key => $rep_air_plan) {
                                                    //     $airproblems_plan = $rep_air_plan->air_problems_plan;
                                                    // }

                                                    // // แผนการบำรุงรักษา
                                                    // if ($plan_s < 1) {
                                                    //     $plan = "0";
                                                    //     $percent_ploblames =  "0";
                                                    //     $percent_plan      =  "0";
                                                    // } else {
                                                    //     $plan = $plan_s ;
                                                    //     $percent_ploblames =  (100 / $item->total_qty) * $airproblems;
                                                    //     $percent_plan      =  (100 / $plan) * $airproblems_plan;
                                                    // }
                            @endphp
                                   <tr style="font-size: 11px;height: 11px;">
                                      <td style="border: 1px solid black;" class="text-center">{{DateThai($item->recieve_date)}}</td>
                                      <td style="border: 1px solid black;" class="text-start">&nbsp;{{$item->supplies_namesub}}</td>
                                      <td style="border: 1px solid black;" class="text-center">&nbsp;{{$item->recieve_po_sup}}</td>
                                      <td style="border: 1px solid black;" class="text-center">&nbsp;</td>
                                      <td style="border: 1px solid black;" class="text-center">&nbsp;</td>
                                      <td style="border: 1px solid black;" class="text-center">&nbsp;</td>
                                      <td style="border: 1px solid black;" class="text-center">&nbsp;</td>
                                      <td style="border: 1px solid black;" class="text-center">&nbsp;</td>
                                      <td style="border: 1px solid black;" class="text-center">&nbsp;</td>
                                      <td style="border: 1px solid black;" class="text-center">&nbsp;</td>
                                      <td style="border: 1px solid black;" class="text-center">&nbsp;</td>
                                      <td style="border: 1px solid black;" class="text-center">&nbsp;</td>
                                    </tr>
                                    {{-- <tr style="font-size: 11px;height: 11px;">
                                      <td style="border: 1px solid black;" class="text-center">{{$loop->iteration}}</td>
                                      <td style="border: 1px solid black;" class="text-start">&nbsp;{{$item->MONTH_NAME}}</td>
                                      <td style="border: 1px solid black;" class="text-center">&nbsp;พ.ศ. {{$item->years_ps}}</td>
                                      <td style="border: 1px solid black;" class="text-center">&nbsp;{{$item->total_qty}}</td>
                                      <td style="border: 1px solid black;" class="text-center">&nbsp;{{$airproblems}}</td>
                                      <td style="border: 1px solid black;" class="text-center">&nbsp;{{$airproblems04}}</td>
                                      <td style="border: 1px solid black;" class="text-center">&nbsp;{{$plan}}</td>
                                      <td style="border: 1px solid black;" class="text-center">&nbsp;{{$airproblems_plan}}</td>
                                      <td style="border: 1px solid black;" class="text-center">&nbsp;{{number_format($percent_ploblames, 2)}} %</td>
                                      <td style="border: 1px solid black;" class="text-center">&nbsp;{{number_format($percent_plan, 2)}} %</td>
                                    </tr> --}}

          @if ($loop->last || $loop->iteration % $row_in_table == 0)

                            </tbody>
                        </table>

                       
                        {{-- <table class="mt-5">
                            <tr>
                              <td style="font-size: 12px;width:18px"><b></b></td>
                         
                              <td style="font-size: 12px;width:230px;height: 10px;">ลงชื่อ ................................................... ผู้รายงาน<br>
                                <label style="font-size: 12px;;height: 10px;" class="ms-4">&nbsp;&nbsp;&nbsp;{{$ptname}}</label>
                              </td>
 
                              <td style="font-size: 12px;width:50px"></td>
                              <td style="font-size: 12px;width:230px;height: 10px;">ลงชื่อ ............................................... ผู้ตรวจสอบ<br>
                                <label style="font-size: 12px;;height: 10px;" class="ms-4">&nbsp;&nbsp;{{$rong_bo}}</label>
                              </td>

                              <td style="font-size: 12px;width:50px"></td>
                              <td style="font-size: 12px;width:250px;height: 10px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ลงชื่อ ............................................. ผู้อนุมัติ<br>
                                <label style="font-size: 12px;;height: 10px;" class="ms-4">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{$po}}</label>
                              </td>

                            </tr>
                            <tr>
                              <td style="font-size: 12px;width:10px" class="text-center"><b></b></td>
                              <td style="font-size: 12px;width:158px;height: 10px;" class="text-start"> <p style="font-size: 13px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{$position}}</p></td>
                              <td style="font-size: 12px;width:80px;height: 10px;" class="text-center"></td>
                              <td style="font-size: 12px;width:190px;height: 10px;" class="text-start"> <p style="font-size: 13px;">หัวหน้ากลุ่มภารกิจด้านอำนวยการ</p></td>
                              <td style="font-size: 12px;width:100px;height: 10px;" class="text-center"></td>
                              <td style="font-size: 12px;width:150px;height: 10px;" class="text-center"> <p style="font-size: 13px;">ผู้อำนวยการโรงพยาบาลภูเขียวเฉลิมพระเกียรติ</p></td>
                            </tr>
                        </table> --}}


                    </div>
                </div>


              @if (!$loop->last)
                  <p style="page-break-after: always;"></p>
              @endif

          @endif
      @empty


    @endforelse

  
 </div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


</body>

</html>
