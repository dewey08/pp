<!doctype html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
<title>รายงานประจำเดือนก๊าซทางการแพทย์</title>

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
            line-height: 25px;
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
            left: 30;
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
    @forelse ($datashow as $item_gas)
          @if ($loop->iteration % $row_in_table == 1)
              <div class="row">
                <div class="col-md-12">
                  <label for="" style="font-size:15px;"><b>รายงานการบำรุงรักษาก๊าซทางการแพทย์ (รายเดือน)</b></label><br>
                  <label for="" style="font-size:15px;"><b>โรงพยาบาลภูเขียวเฉลิมพระเกียรติ จังหวัดชัยภูมิ</b></label>
                </div>
              </div>
              <div class="row mt-3">
                  <div class="col-xl-12">
                          <table class="mb-4" style="width: 100%;">
                              <thead>
                                {{-- <tr style="font-size: 11px;height: 11px;" class="text-center">
                                    <th style="border: 1px solid black;width: 5%;background-color: rgb(209, 178, 255);color:#FFFFFF">ลำดับ</th>                                    
                                </tr> --}}

                                <tr style="font-size:12px">
                                  {{-- <th rowspan="2" class="text-center" style="background-color: #faddd4;color:#272626;" width= "2%">ลำดับ</th> --}}
                                  <th rowspan="2" class="text-center" style="background-color: #92ddca;color:#272626;border: 1px solid black;">เดือน</th>
                                  <th rowspan="2" class="text-center" style="background-color: #92ddca;color:#272626;border: 1px solid black;" width= "4%">ปี</th>
                                  <th rowspan="2" class="text-center" style="background-color: #92ddca;color:#272626;border: 1px solid black;" width= "4%">วัน</th>
                                  <th colspan="2" class="text-center" style="background-color: #e9b1f7;border: 1px solid black;" width= "8%">Tank Liquid Oxygen(Main)</th>
                                  <th colspan="2" class="text-center" style="background-color: #b1e9f7;border: 1px solid black;" width= "8%">Tank Liquid Oxygen(Sub)</th>
                                  <th colspan="2" class="text-center" style="background-color: #fca8dc;border: 1px solid black;" width= "8%">ไนตรัสออกไซด์ (N2O-6Q)</th>
                                  <th colspan="2" class="text-center" style="background-color: #d1fdd8;border: 1px solid black;" width= "7%">ก๊าซอ๊อกซิเจน (2Q-6Q)</th>
                                  <th colspan="2" class="text-center" style="background-color: #f7bcb1;border: 1px solid black;" width= "7%">Control Gas</th>
                                
                              </tr>
                              <tr style="font-size:12px"> 
                                  <th class="text-center" style="background-color: #f3e1f8;border: 1px solid black;">(ทั้งหมด)</th>
                                  <th class="text-center" style="background-color: #f3e1f8;border: 1px solid black;">(ตรวจ)</th>
                                  <th class="text-center" style="background-color: #cdf3fd;border: 1px solid black;">(ทั้งหมด)</th>
                                  <th class="text-center" style="background-color: #cdf3fd;border: 1px solid black;">(ตรวจ)</th>
                                  <th class="text-center" style="background-color: #fcdaef;border: 1px solid black;">(ทั้งหมด)</th>
                                  <th class="text-center" style="background-color: #fcdaef;border: 1px solid black;">(ตรวจ)</th>
                                  <th class="text-center" style="background-color: #e4fde9;border: 1px solid black;">(ทั้งหมด)</th>
                                  <th class="text-center" style="background-color: #e4fde9;border: 1px solid black;">(ตรวจ)</th>
                                  <th class="text-center" style="background-color: #fde1dc;border: 1px solid black;">(ทั้งหมด)</th>
                                  <th class="text-center" style="background-color: #fde1dc;border: 1px solid black;">(ตรวจ)</th>
                              </tr>

                              </thead>
                              <tbody>
          @endif
 
                            @php                                                    
 
                                                    $data_m1_ = DB::select('SELECT month_day FROM months WHERE month_no ="'.$item_gas->months.'"');
                                                        foreach ($data_m1_ as $key => $v1) {$data_m1 = $v1->month_day;}
    
                                                    $main_count = DB::select('SELECT COUNT(gas_list_id) as cmain FROM gas_check WHERE gas_type ="1" AND active ="Ready" AND month(check_date) = "'.$item_gas->months.'" AND year(check_date) = "'.$item_gas->years.'"');
                                                        foreach ($main_count as $key => $val_count) {$count_main = $val_count->cmain;}
                                                    $main_count2 = DB::select('SELECT COUNT(gas_list_id) as cmain FROM gas_list WHERE gas_type ="1" AND active ="Ready"');
                                                        foreach ($main_count2 as $key => $val_count2) {$count_main2 = $val_count2->cmain;}
    
                                                    $sub_count = DB::select('SELECT COUNT(gas_list_id) as cmain FROM gas_list WHERE gas_type ="2" AND active ="Ready"');
                                                        foreach ($sub_count as $key => $val_count3) {$count_sub = $val_count3->cmain;}
                                                    $sub_count2 = DB::select('SELECT COUNT(gas_list_id) as cmain FROM gas_check WHERE gas_type ="2" AND active ="Ready" AND month(check_date) = "'.$item_gas->months.'" AND year(check_date) = "'.$item_gas->years.'"');
                                                        foreach ($sub_count2 as $key => $val_count4) {$check_sub = $val_count4->cmain;}
    
                                                    $n2o_count = DB::select('SELECT COUNT(gas_list_id) as cmain FROM gas_list WHERE gas_type ="5" AND active ="Ready"');
                                                        foreach ($n2o_count as $key => $val_count5) {$count_n2o = $val_count5->cmain;}
                                                    $n2o_count2 = DB::select('SELECT COUNT(gas_list_id) as cmain FROM gas_check WHERE gas_type ="5" AND active ="Ready" AND month(check_date) = "'.$item_gas->months.'" AND year(check_date) = "'.$item_gas->years.'"');
                                                        foreach ($n2o_count2 as $key => $val_count6) {$check_n2o = $val_count6->cmain;}
    
                                                    $oq2q6_count = DB::select('SELECT COUNT(gas_list_id) as cmain FROM gas_list WHERE gas_type IN("3","4") AND active ="Ready"');
                                                        foreach ($oq2q6_count as $key => $val_count7) {$count_oq2q6 = $val_count7->cmain;}
                                                    $oq2q6_countcheck = DB::select('SELECT COUNT(gas_list_id) as cmain FROM gas_check WHERE gas_type IN("3","4") AND active ="Ready" AND month(check_date) = "'.$item_gas->months.'" AND year(check_date) = "'.$item_gas->years.'"');
                                                        foreach ($oq2q6_countcheck as $key => $val_count8) {$checkoq2q6_count = $val_count8->cmain;}
                            @endphp
                                    <tr style="font-size: 11px;height: 11px;">
                                        {{-- <td style="border: 1px solid black;" class="text-center">{{$loop->iteration}}</td> --}}
                                        <td style="border: 1px solid black;" class="text-start">&nbsp;{{$item_gas->month_name}}</td>
                                        <td style="border: 1px solid black;" class="text-start">&nbsp;{{$item_gas->years_th}}</td>
                                        <td style="border: 1px solid black;" class="text-center">&nbsp;{{$data_m1}}</td>
                                        <td style="border: 1px solid black;" class="text-center">&nbsp;{{$count_main2*$data_m1}}</td>
                                        <td style="border: 1px solid black;" class="text-center">&nbsp;{{$count_main}}</td>
                                        <td style="border: 1px solid black;" class="text-center">&nbsp;{{$count_sub*$data_m1}}</td>
                                        <td style="border: 1px solid black;" class="text-center">&nbsp;{{$check_sub}}</td>
                                        <td style="border: 1px solid black;" class="text-center">&nbsp;{{$count_n2o*$data_m1}}</td>
                                        <td style="border: 1px solid black;" class="text-center">&nbsp;{{$check_n2o}}</td>
                                        <td style="border: 1px solid black;" class="text-center">&nbsp;{{$count_oq2q6*$data_m1}}</td>
                                        <td style="border: 1px solid black;" class="text-center">&nbsp;{{$checkoq2q6_count}} </td>
                                        <td style="border: 1px solid black;" class="text-center">&nbsp; </td>
                                        <td style="border: 1px solid black;" class="text-center">&nbsp; </td> 
                                    </tr> 


          @if ($loop->last || $loop->iteration % $row_in_table == 0)

                            </tbody>
                        </table>
 
                        <table class="mt-5">
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
                              <td style="font-size: 12px;width:158px;height: 10px;" class="text-start"> <p style="font-size: 13px;">&nbsp;&nbsp;{{$position}}</p></td>
                              <td style="font-size: 12px;width:80px;height: 10px;" class="text-center"></td>
                              <td style="font-size: 12px;width:190px;height: 10px;" class="text-start"> <p style="font-size: 13px;">หัวหน้ากลุ่มภารกิจด้านอำนวยการ</p></td>
                              <td style="font-size: 12px;width:100px;height: 10px;" class="text-center"></td>
                              <td style="font-size: 12px;width:150px;height: 10px;" class="text-center"> <p style="font-size: 13px;">ผู้อำนวยการโรงพยาบาลภูเขียวเฉลิมพระเกียรติ</p></td>
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



 </div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


</body>

</html>
