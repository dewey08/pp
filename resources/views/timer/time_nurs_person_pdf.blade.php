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
            top: -10px;
            left: 0px;
            right: 0px;
            height: 10px;
            font-size: 15px !important;

            /** Extra personal styles **/
            background-color: #008B8B;
            color: white;
            text-align: center;
            line-height: 25px;
        }

        footer {
            position: fixed;
            bottom: -10px;
            left: 0px;
            right: 0px;
            height: 10px;
            font-size: 15px !important;

            /** Extra personal styles **/
            background-color: #008B8B;
            color: white;
            text-align: center;
            line-height: 25px;
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
      $row_in_table = 12;

      $datenow = date("Y-m-d");
        $y = date('Y') + 543;
        // $m_ = date('m');

        if ( $m_ == '01') {
            $m = 'มกราคม';
        } else if( $m_ == '02'){
            $m = 'กุมภาพันธ์';
        } else if( $m_ == '03'){
            $m = 'มีนาคม';
        } else if( $m_ == '04'){
            $m = 'เมษายน';
        } else if( $m_ == '05'){
            $m = 'พฤษภาคม';
        } else if( $m_ == '06'){
            $m = 'มิถุนายน';
        } else if( $m_ == '07'){
            $m = 'กรกฎาคม';
        } else if( $m_ == '08'){
            $m = 'สิงหาคม';
        } else if( $m_ == '09'){
            $m = 'กันยายน';
        } else if( $m_ == '10'){
            $m = 'ตุลาคม';
        } else if( $m_ == '11'){
            $m = 'พฤษจิกายน';
        } else{
            $m = 'ธันวาคม';
        }

    @endphp
    @forelse ($datashow as $item)
          @if ($loop->iteration % $row_in_table == 1)
              <div class="row">
                <div class="col-md-12">
                  {{-- <label for="" style="font-size:15px;"><b>บัญชีรายชื่อการปฏิบัติงาน หน่วยงาน {{$deb}}</b></label> --}}
                  <center>

                   {{-- <label for="" style="font-family: 'Kanit', sans-serif;font-size:15px;"><b>บัญชีรายชื่อการปฏิบัติงาน หน่วยงาน {{$debname}} </b></label><br> --}}
                   {{-- <label for="" style="font-family: 'Kanit', sans-serif;font-size:15px;"><b>{{$org}}</b></label><br> --}}
                   {{-- <label for="" style="font-family: 'Kanit', sans-serif;font-size:15px;"><b>ประจำเดือน…{{$m}}….พ.ศ…{{$y}}</b></label><br> --}}

                   <label for="" style="font-size:15px;"><b>บัญชีรายชื่อการปฏิบัติงาน หน่วยงาน {{$debname}} {{$org}}</b></label><br>
                   {{-- <label for="" style="font-size:15px;"><b>{{$org}}</b></label><br> --}}
                   <label for="" style="font-size:15px;"><b>ประจำเดือน {{$m}} พ.ศ {{$newyears}}</b></label><br>

                </center>
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
              <div class="row mt-2">
                  <div class="col-xl-12">
                          <table style="width: 100%;">
                              <thead>
                                <tr style="font-size: 13px;height: 11px;" class="text-center">
                                    <th style="border: 0.5px solid black;width: 5%;background-color: rgb(220, 197, 255);color:#0374b6">ลำดับ</th>
                                    <th style="border: 0.5px solid black;width: 7%;background-color: rgb(220, 197, 255);color:#0374b6">วันที่</th>
                                    <th style="border: 0.5px solid black;width: 14%;background-color: rgb(220, 197, 255);color:#0374b6">ชื่อ-สกุล</th>
                                    <th style="border: 0.5px solid black;width: 15%;background-color: rgb(220, 197, 255);color:#0374b6">หน่วยงาน</th>
                                    <th style="border: 0.5px solid black;width: 7%;background-color: rgb(220, 197, 255);color:#0374b6">เวลาเข้า</th>
                                    <th style="border: 0.5px solid black;width: 7%;background-color: rgb(220, 197, 255);color:#0374b6">เวลาออก</th>
                                    <th style="border: 0.5px solid black;width: 7%;background-color: rgb(220, 197, 255);color:#0374b6">ประเภท</th>
                                </tr>

                              </thead>
                              <tbody>
          @endif

                            @php

                            @endphp
                                    <tr style="font-size: 11px;height: 10px;">
                                      <th style="border: 0.5px solid black;" class="text-center">{{$loop->iteration}}</th>
                                      <td style="border: 0.5px solid black;" class="text-center">&nbsp;{{$item->CHEACKIN_DATE}}</td>
                                      <td style="border: 0.5px solid black;" class="text-start">&nbsp;{{$item->hrname}}</td>
                                      <td style="border: 0.5px solid black;" class="text-start">&nbsp;{{$item->HR_DEPARTMENT_SUB_SUB_NAME}}</td>
                                      <td style="border: 0.5px solid black;" class="text-center">&nbsp;{{$item->CHEACKINTIME}}</td>
                                      <td style="border: 0.5px solid black;" class="text-center">&nbsp;{{$item->CHEACKOUTTIME}}</td>
                                      <td style="border: 0.5px solid black;" class="text-center">&nbsp;{{$item->OPERATE_TYPE_NAME}}</td>
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
                        <table class="mt-2 text-center">
                            <tr> 

                              <td style="font-size: 12px;width:200px"></td>
                              <td style="font-size: 12px;width:600px;height: 10px;">ขอรับรองว่าผู้มาปฏิบัติหน้าที่ราชการตามรายชื่อข้างต้นนี้ ข้าพเจ้าเป็นผู้สั่งให้มาปฏิบัติหน้าที่ราชการ<br>
                                <label style="font-size: 12px;;height: 10px;" class="ms-4">&nbsp;&nbsp;อันเป็นงานที่จำเป็นจะต้องปฏิบัติทำเร่งด่วนเป็นกรณีพิเศษ</label>
                              </td>

                            </tr>

                        </table>
                        <table class="mt-2 text-center">
                            <tr>
                                <td style="font-size: 12px;width:100px"></td>
                                <td style="font-size: 12px;width:300px;height: 10px;">ลงชื่อ..............................................ควบคุม<br>
                                  <label style="font-size: 12px;;height: 10px;" class="ms-1">( ..............................................)</label><br>
                                  <label style="font-size: 12px;;height: 10px;" class="ms-3">หัวหน้ากลุ่มงาน/งาน </label><br>
                                </td>

                                <td style="font-size: 12px;width:100px"></td>
                                <td style="font-size: 12px;width:300px;height: 10px;">ลงชื่อ..............................................ผู้รับรอง<br>
                                    <label style="font-size: 12px;;height: 10px;" class="ms-1">( ..............................................)</label><br>
                                    <label style="font-size: 12px;;height: 10px;" class="ms-3">หัวหน้ากลุ่มภารกิจ </label><br>
                                  </td>

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
