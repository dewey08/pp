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
      $row_in_table = 19;
    @endphp
    
   
    {{-- <table style="width: 100%;"> 
      <tr> 
        <th class="text-start" width="100%"><label for="" style="font-size:14px;">ชื่อเวชภัณฑ์</label></th> 
      </tr> 
    </table> --}}
    @forelse ($datashow as $item)
          @if ($loop->iteration % $row_in_table == 1)
            <div class="row mt-2">
              <div class="col-md-12">
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
                    {{-- <th class="text-start" width="15%"><label for="" style="font-size:13px;">แผ่นที่  หน้าที่ .........</label></th> --}}
                  </tr> 
                </table>
              </div>
            </div>
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
                                  <th style="border: 1px solid black;width: 12%;background-color: rgb(192, 243, 250);color:#252424">บริษัท</th>
                                  <th style="border: 1px solid black;width: 7%;background-color: rgb(192, 243, 250);color:#252424">เลขที่ใบส่งของ</th>
                                  <th style="border: 1px solid black;width: 6%;background-color: rgb(192, 243, 250);color:#252424">จำนวนรับ</th>
                                  <th style="border: 1px solid black;width: 6%;background-color: rgb(192, 243, 250);color:#252424">รวมรับ</th>
                                  <th style="border: 1px solid black;width: 8%;background-color: rgb(192, 243, 250);color:#252424">ราคา/หน่วย</th>
                                  <th style="border: 1px solid black;width: 8%;background-color: rgb(192, 243, 250);color:#252424">วันหมดอายุ</th> 
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
                                       
                                    $stock_card_pay   = DB::select(
                                        'SELECT b.pro_id,b.pro_code,b.pro_name,d.wh_unit_name,b.qty_pay,b.lot_no,c.export_date,b.one_price,e.DEPARTMENT_SUB_SUB_NAME,b.stock_list_subid,f.request_no,b.total_stock
                                            FROM wh_stock_export_sub b  
                                            LEFT JOIN wh_stock_export c ON c.wh_stock_export_id = b.wh_stock_export_id
                                             LEFT JOIN wh_request f ON f.wh_request_id = b.wh_request_id
                                            LEFT JOIN wh_unit d ON d.wh_unit_id = b.unit_id
                                            LEFT JOIN department_sub_sub e ON e.DEPARTMENT_SUB_SUB_ID = c.stock_list_subid
                                            WHERE b.pro_id = "'.$idpro.'" AND b.lot_no = "'.$item->lot_no.'"
                                            ORDER BY b.wh_stock_export_sub_id ASC 
 
                                    ');
                                    
                                        $data_count   = DB::table('wh_stock_export_sub')
                                          ->leftjoin('wh_stock_export','wh_stock_export.wh_stock_export_id','=','wh_stock_export_sub.wh_stock_export_id')
                                          ->leftjoin('wh_request','wh_request.wh_request_id','=','wh_stock_export_sub.wh_request_id')
                                          ->where('wh_stock_export_sub.lot_no','=',$item->lot_no)
                                          ->count();

                                          $total_last   = DB::select(
                                              'SELECT stock_rep_total
                                                  FROM wh_recieve_sub   
                                                  WHERE lot_no = "'.$item->lot_no.'" 
                                          ');
                                          foreach ($total_last as $key => $value_lasr) {
                                                $lastst = $value_lasr->stock_rep_total;
                                          }

                                          // $total_l = $lastst 
                                          // + $item->stock_rep_total;
                                          // stock_rep_total
                                          //  $data_replast = DB::table('wh_recieve_sub')
                                          // // ->leftjoin('wh_stock_export','wh_stock_export.wh_stock_export_id','=','wh_stock_export_sub.wh_stock_export_id')
                                          // ->where('lot_no','=',$item->lot_no)->latest('stock_rep_total')
                                          // ->first();
                                          $datalast = DB::table('wh_stock_export_sub')
                                          ->where('pro_id','=',$item->pro_id)
                                          // ->leftjoin('wh_stock_export','wh_stock_export.wh_stock_export_id','=','wh_stock_export_sub.wh_stock_export_id')
                                          // ->where('wh_stock_export.export_date','=',$item->export_date)
                                          ->latest('wh_stock_export_sub_id')
                                          ->first();

                                          // wh_stock_export_sub_id
                                          // +{{$datalast->total_stock}}
                                          // ->where('lot_no','=',$item->lot_no)
                            @endphp
                           


                                    <tr style="font-size: 11px;height: 11px;">
                                        {{-- <th style="border: 1px solid black;width: 5%;" class="text-center">{{$loop->iteration}}</th> --}}
                                          <td style="border: 1px solid black;" class="text-center">{{DateThai($item->recieve_date)}} </td>
                                          <td style="border: 1px solid black;" class="text-start">&nbsp;{{$item->supplies_namesub}}</td>
                                          <td style="border: 1px solid black;" class="text-center">&nbsp;{{$item->recieve_po_sup}}</td>
                                          <td style="border: 1px solid black;" class="text-center">&nbsp;{{$item->qty}}</td>
                                          <td style="border: 1px solid black;" class="text-center">&nbsp;{{$item->qty}}</td>
                                          <td style="border: 1px solid black;" class="text-center">&nbsp;{{number_format($item->one_price, 2)}}</td>
                                          <td style="border: 1px solid black;" class="text-center">&nbsp;</td>
                                        

                                          @if ($data_count < 1)
                                            <td style="border: 1px solid black;" class="text-center">&nbsp;</td>
                                            <td style="border: 1px solid black;" class="text-center">&nbsp;{{$item->qty_pay}}</td>  
                                            <td style="border: 1px solid black;" class="text-center">&nbsp;{{$item->total_pay}}</td>
                                            <td style="border: 1px solid black;" class="text-center">&nbsp;{{$item->stock_rep_total+$datalast->total_stock}}</td>
                                            <td style="border: 1px solid black;" class="text-center">&nbsp;</td>
                                          @else

                                          <td colspan="5" style="border: 1px solid black;" class="text-center">&nbsp;</td>                                       

                                                @foreach ($stock_card_pay as $item2)
                                                  @php 
                                                    $data_total   = DB::table('wh_stock_export_sub')
                                                    ->leftjoin('wh_stock_export','wh_stock_export.wh_stock_export_id','=','wh_stock_export_sub.wh_stock_export_id')
                                                    ->leftjoin('wh_request','wh_request.wh_request_id','=','wh_stock_export_sub.wh_request_id')
                                                    ->where('wh_stock_export_sub.lot_no','=',$item2->lot_no)->where('wh_stock_export.export_date','=',$item2->export_date)->where('wh_stock_export_sub.stock_list_subid','=',$item2->stock_list_subid)
                                                    ->sum('wh_stock_export_sub.qty_pay');   
                                                  @endphp
                                                <tr style="font-size: 11px;height: 11px;">
                                                    <td style="border: 1px solid black;" class="text-center">&nbsp;</td>
                                                    <td style="border: 1px solid black;" class="text-center">&nbsp;</td>
                                                    <td style="border: 1px solid black;" class="text-center">&nbsp;</td>
                                                    <td style="border: 1px solid black;" class="text-center">&nbsp;</td>
                                                    <td style="border: 1px solid black;" class="text-center">&nbsp;</td>
                                                    <td style="border: 1px solid black;" class="text-center">&nbsp;</td>
                                                    <td style="border: 1px solid black;" class="text-center">&nbsp;</td>
                                                    <td style="border: 1px solid black;" class="text-center">&nbsp;{{DateThai($item2->export_date)}}</td>
                                                    <td style="border: 1px solid black;" class="text-center">&nbsp;{{$item2->qty_pay}}</td>
                                                    <td style="border: 1px solid black;" class="text-center">&nbsp;{{$item2->qty_pay}}</td>
                                                    {{-- <td style="border: 1px solid black;" class="text-center">&nbsp;{{$data_total}}</td> --}}
                                                    {{-- <td style="border: 1px solid black;" class="text-center">&nbsp;{{($item->qty -$data_total)-$item2->qty_pay}}</td> --}}
                                                    <td style="border: 1px solid black;" class="text-center">&nbsp;{{$item2->total_stock}}</td> 
                                                    <td style="border: 1px solid black;" class="text-center">&nbsp;{{$item2->request_no}}</td> 
                                                </tr>                                                  
                                                @endforeach

                                          @endif
                                     
                                    </tr>   

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
<script type="text/php">
  if ( isset($pdf) ) {
      $pdf->page_text(710, 20, "แผ่นที่: {PAGE_NUM} หน้าที่ {PAGE_NUM}",null, 10, array(255,0,0));
  }
</script>

</body>

</html>
{{-- {PAGE_COUNT} --}}