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
    $row_in_table = 15;
  @endphp
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
                      <th class="text-start" width="45%"><label for="" style="font-size:14px;">ชื่อเวชภัณฑ์ {{$pro_name}}</label></th>
                      <th class="text-start" width="15%"><label for="" style="font-size:13px;">แผ่นที่ .........หน้าที่ .........  </label></th>
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
                                       
                                       $data_rep   = DB::table('wh_recieve_sub')->where('wh_recieve_sub.lot_no','=',$item->lot_no)->first();
                                                // ->sum('wh_stock_export_sub.qty_pay'); 
                                        $qty = $data_rep->qty;
                                        $data_countpro   = DB::table('wh_recieve_sub')->where('wh_recieve_sub.pro_id','=',$item->pro_id)->count();
                                        $data_countrep   = DB::table('wh_recieve_sub')->where('wh_recieve_sub.lot_no','=',$item->lot_no)->count();
                                        $rep   = DB::table('wh_recieve_sub')->where('wh_recieve_sub.pro_id','=',$item->pro_id)->groupBy('lot_no')->get();

                                        $datashow = DB::select(
                                              'SELECT a.pro_id,a.pro_code,a.pro_name,d.wh_unit_name,b.qty,b.lot_no,c.recieve_date,b.one_price,b.export_date,b.qty_pay,b.total_pay,b.stock_rep_total
                                              ,c.recieve_no,c.recieve_po_sup,e.supplies_name,e.supplies_namesub
                                              FROM wh_stock a
                                              LEFT JOIN wh_recieve_sub b ON b.pro_id = a.pro_id
                                              LEFT JOIN wh_recieve c ON c.wh_recieve_id = b.wh_recieve_id
                                              LEFT JOIN wh_unit d ON d.wh_unit_id = a.unit_id
                                              LEFT JOIN air_supplies e ON e.air_supplies_id = c.vendor_id
                                              WHERE a.pro_id = "'.$item->pro_id.'" 
                                              GROUP BY b.lot_no ASC
                                              ORDER BY b.lot_no ASC   
                                                          
                                        ');
                            @endphp
                           
                      
                              <tr style="font-size: 11px;height: 11px;">  
                                
                                      <td style="border: 1px solid black;" class="text-center">&nbsp;{{DateThai($item->recieve_date)}}</td>
                                      <td style="border: 1px solid black;" class="text-center">&nbsp;{{$item->supplies_namesub}}</td>
                                      <td style="border: 1px solid black;" class="text-center">&nbsp;{{$item->recieve_po_sup}}</td>
                                      <td style="border: 1px solid black;" class="text-center">&nbsp;{{$item->total_pay}}</td>
                                      <td style="border: 1px solid black;" class="text-center">&nbsp;{{$item->stock_rep_total}}</td>
                                      <td style="border: 1px solid black;" class="text-center">&nbsp;{{$item->one_price}}</td>
                                      <td style="border: 1px solid black;" class="text-center">&nbsp;</td>
                                      
                                      
                                      <td style="border: 1px solid black;" class="text-center">&nbsp;{{DateThai($item->export_date)}}</td>
                                      <td style="border: 1px solid black;" class="text-center">&nbsp;{{$item->qty_pay}}</td>
                                      <td style="border: 1px solid black;" class="text-center">&nbsp;{{$item->qty_pay}}</td>
                                      <td style="border: 1px solid black;" class="text-center">&nbsp;{{$item->total_stock}}</td>
                                      <td style="border: 1px solid black;" class="text-center">&nbsp;{{$item->request_no}}</td> 
                                </tr>   
                        

                                    

          @if ($loop->last || $loop->iteration % $row_in_table == 0)

                            </tbody>
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
{{-- <script type="text/php">
  if ( isset($pdf) ) {
      $pdf->page_text(750, 77, " หน้าที่ {PAGE_NUM}",null, 10, array(255,0,0));
  }
</script> --}}
{{-- <script type="text/php">
  if ( isset($pdf) ) {
      $pdf->page_text(710, 20, "แผ่นที่: {PAGE_NUM} หน้าที่ {PAGE_NUM}",null, 10, array(255,0,0));
  }
</script> --}}

</body>

</html>
{{-- {PAGE_COUNT} --}}