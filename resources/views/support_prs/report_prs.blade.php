@extends('layouts.support_prs_db')
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
     
        <div id="preloader">
            <div id="status">
                <div id="container_spin">
                    <svg viewBox="0 0 100 100">
                        <defs>
                            <filter id="shadow">
                                <feDropShadow dx="0" dy="0" stdDeviation="2.5" flood-color="#fc6767" />
                            </filter>
                        </defs>
                        <circle id="spinner"
                            style="fill:transparent;stroke:#dd2476;stroke-width: 7px;stroke-linecap: round;filter:url(#shadow);"
                            cx="50" cy="50" r="45" />
                    </svg>
                </div>
            </div>
        </div>

    

            {{-- <div class="col-xl-3 col-md-6">
                <a href="{{url('air_dashboard')}}" target="_blank">
                    <div class="card widget-chart widget-chart-hover" style="height: 200px">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <p class="text-start font-size-14 mb-2 ">เครื่องปรับอากาศ</p>
                                    <h2 class="text-start mb-2"> </h2>   
                                </div>
                                <div class="avatar-sm" style="width: 100px;height:100px">
                                    <span class="avatar-title bg-light text-primary rounded-3"> 
                                        <img src="{{ asset('images/air_conditioner_g.png') }}" height="80px" width="80px" class="text-danger"> 
                                    </span>
                                </div>
                            </div>  
                                                                
                        </div> 

                    
                    </div> 
                </a>
            </div>  --}}
            
            {{-- <div class="col-xl-3 col-md-6">
                <a href="{{url('support_system_dashboard')}}" target="_blank">
                    <div class="card widget-chart widget-chart-hover" style="height: 200px">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <p class="text-start font-size-14 mb-2">ถังดับเพลิง</p>
                                    <h2 class="text-start mb-2"> </h2> 
                                </div>
                                <div class="avatar-sm" style="width: 100px;height:100px">
                                    <span class="avatar-title bg-light text-success rounded-3">
                                        <img src="{{ asset('images/fire-extinguisher.png') }}" height="80px" width="80px" class="text-danger"> 
                                    </span>
                                </div>
                            </div>   
                                                                      
                        </div> 
                    </div> 
                </a>
            </div>  --}}
            <!-- Collapse -->
          <div class="row">
              <div class="col-xl-12">
                  <div class="card">
                      <div class="card-body">

                          <h3>รายงาน</h3>
                          <p class="card-title-desc mb-3" style="font-size: 19px;">
                              รายละเอียด <code class="highlighter-rouge">ประจำเดือน</code> 
                          </p>
                          <p> 
                              <button class="btn btn-info bt_prs mt-1" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                                  เครื่องปรับอากาศ
                              </button>
                              <button class="btn btn-info bt_prs mt-1" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFire" aria-expanded="false" aria-controls="collapseFire">
                                ถังดับเพลิง
                              </button>
                              <button class="btn btn-info bt_prs mt-1" type="button" data-bs-toggle="collapse" data-bs-target="#collapsecctv" aria-expanded="false" aria-controls="collapsecctv">
                                กล้อง CCTV
                              </button>
                              <button class="btn btn-info bt_prs mt-1" type="button" data-bs-toggle="collapse" data-bs-target="#collapsewatersub" aria-expanded="false" aria-controls="collapsewatersub">
                               น้ำสำรอง
                              </button>
                              <button class="btn btn-info bt_prs mt-1" type="button" data-bs-toggle="collapse" data-bs-target="#collapsewaterdrink" aria-expanded="false" aria-controls="collapsewaterdrink">
                                น้ำบริโภค
                               </button>
                               <button class="btn btn-info bt_prs mt-1" type="button" data-bs-toggle="collapse" data-bs-target="#collapseGenerator" aria-expanded="false" aria-controls="collapseGenerator">
                                  เครื่องกำเนิดไฟฟ้า
                              </button>
                              <button class="btn btn-info bt_prs mt-1" type="button" data-bs-toggle="collapse" data-bs-target="#collapsetransformer" aria-expanded="false" aria-controls="collapsetransformer">
                                  หม้อแปลงไฟฟ้า
                              </button>
                              <button class="btn btn-info bt_prs mt-1" type="button" data-bs-toggle="collapse" data-bs-target="#collapseelevator" aria-expanded="false" aria-controls="collapseelevator">
                                ลิฟต์โดยสาร
                              </button>
                              <button class="btn btn-info bt_prs mt-1" type="button" data-bs-toggle="collapse" data-bs-target="#collapseToilet" aria-expanded="false" aria-controls="collapseToilet">
                                ห้องน้ำ/ห้องส้วม
                              </button>
                              <button class="btn btn-info bt_prs mt-1" type="button" data-bs-toggle="collapse" data-bs-target="#collapseMedical" aria-expanded="false" aria-controls="collapseMedical">
                                ก๊าซทางการแพทย์ (O2+Ni)
                              </button>             </p>
                          <div class="collapse" id="collapseExample">
                              <div class="card card-body mb-0">
                                <div class="row mt-3">
                                  <div class="col-xl-12">
                                      <div class="card card_prs_4">
                                          <div class="card-body">
                                             @if ($month_id != '')
                                                  <p class="mb-0">
                                                      <div class="table-responsive">
                                                          <table id="example" class="table table-hover table-sm" style=" border-spacing: 0; width: 100%;">
                                                              <thead>
                                                                      <tr style="font-size:13px">
                                                                          <th class="text-center" width="5%">ลำดับ</th>
                                                                          <th class="text-center">เดือน</th>
                                                                          <th class="text-center">ปี</th>
                                                                          <th class="text-center" width="8%">AIR ทั้งหมด(เครื่อง)</th>
                                                                          <th class="text-center" width="8%">AIR ที่ซ่อม(เครื่อง)</th>
                                                                          <th class="text-center" width="8%">ปัญหาซ่อม AIR(รายการ)</th>
                                                                          <th class="text-center" width="8%">แผนการบำรุงรักษา(ครั้ง)</th>
                                                                          <th class="text-center" width="8%">ผลการบำรุงรักษา(ครั้ง)</th>
                                                                          <th class="text-center" width="8%">ร้อยละ AIR ที่ซ่อม</th>
                                                                          <th class="text-center" width="8%">ร้อยละ AIR ที่บำรุงรักษา</th>
                                                                          <th class="text-center" width="8%">Print</th>
                                                                      </tr>
                                                              </thead>
                                                              <tbody>
                                                                  <?php $i = 0; ?>
                                                                  @foreach ($datashow as $item)
                                                                  <?php $i++  ?>
                                                                  <?php
                                                                          
                                                                          $plan_count = DB::select(
                                                                              'SELECT COUNT(a.air_plan_id) as air_plan_id
                                                                                  FROM air_plan a
                                                                                  LEFT JOIN air_plan_month b ON b.air_plan_month_id = a.air_plan_month_id
                                                                                  WHERE a.air_plan_year = "'.$item->bg_yearnow.'"
                                                                                  AND b.month_no = "'.$item->months.'"
                                                                              ');
                      
                                                                          foreach ($plan_count as $key => $val_count) {
                                                                              $plan_s   = $val_count->air_plan_id;
                                                                          }
                      
                                                                          $repaire_air = DB::select('SELECT COUNT(DISTINCT air_list_num) as air_problems FROM air_repaire
                                                                          WHERE budget_year = "'.$month_years.'" AND MONTH(repaire_date) = "'.$month_ss.'"');
                                                                          foreach ($repaire_air as $key => $rep_air1) {$airproblems1 = $rep_air1->air_problems;}
                      
                                                                          $repaire_air_pro = DB::select('SELECT COUNT(b.repaire_sub_id) as air_problems04 FROM air_repaire a
                                                                              LEFT JOIN air_repaire_sub b ON b.air_repaire_id = a.air_repaire_id
                                                                              WHERE budget_year = "'.$month_years.'" AND MONTH(a.repaire_date) = "'.$month_ss.'" AND b.air_repaire_type_code ="04"');
                                                                          foreach ($repaire_air_pro as $key => $rep_air_pro) {$airproblems04 = $rep_air_pro->air_problems04;}
                      
                                                                          $repaire_air_plan = DB::select(
                                                                              'SELECT COUNT(DISTINCT a.air_list_num) as air_problems_plan
                                                                                  FROM air_repaire a
                                                                                  LEFT JOIN air_repaire_sub b ON b.air_repaire_id = a.air_repaire_id
                                                                                  WHERE a.budget_year= "'.$month_years.'"
                                                                                  AND MONTH(a.repaire_date) = "'.$month_ss.'"
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
                                                                              $percent_ploblames =  (100 / $item->total_qty) * $airproblems1;
                                                                              $percent_plan      =  (100 / $plan) * $airproblems_plan;
                                                                          }
                      
                                                                  ?>
                                                                       <tr>
                                                                          <td class="text-center" style="font-size:13px;width: 5%;color: rgb(13, 134, 185)">{{$i}}</td>
                                                                          <td class="text-start" style="font-size:14px;color: rgb(45, 135, 219)">{{$item->MONTH_NAME}}</td>
                                                                          <td class="text-start" style="font-size:14px;color: rgb(45, 135, 219)">พ.ศ. {{$item->years_ps}}</td>
                                                                          <td class="text-center" style="font-size:13px;color: rgb(236, 36, 210)" width="10%">
                                                                              {{$item->total_qty}}
                                                                          </td>
                                                                          <td class="text-center" style="font-size:13px;color: rgb(253, 65, 81)" width="10%">
                                                                                  {{$airproblems1}}
                                                                          </td>
                                                                          <td class="text-center" style="font-size:13px;color: rgb(252, 90, 203)" width="12%">
                                                                                  {{$airproblems04}}
                                                                          </td>
                                                                          <td class="text-center" style="font-size:13px;color: rgb(5, 179, 170)" width="11%">
                                                                                  {{$plan}}
                                                                          </td>
                                                                          <td class="text-center" style="font-size:13px;color: rgb(253, 102, 15)" width="11%">
                                                                                  {{$airproblems_plan}}
                                                                          </td>
                                                                          <td class="text-center" style="font-size:13px;color: rgb(10, 132, 231)" width="10%">
                                                                                  {{number_format($percent_ploblames, 2)}} %
                                                                          </td>
                                                                          <td class="text-center" style="font-size:13px;color: rgb(250, 128, 138)" width="11%">
                                                                                  {{number_format($percent_plan, 2)}} %
                                                                          </td>
                                                                          <td class="text-center" style="font-size:11px;color: rgb(250, 128, 138)" width="5%">
                                                                              <a href="{{URL('air_report_monthpdfsearch/'.$month_id)}}" class="ladda-button btn-pill btn btn-sm btn-primary bt_prs">
                                                                                  <i class="fa-solid fa-print text-white" style="font-size:11px"></i>
                                                                              </a>
                                                                          </td>
                      
                                                                      </tr>
                                                                  @endforeach
                                                              </tbody>
                                                          </table>
                                                      </div>
                                                  </p>
                                             @else
                                                  <p class="mb-0">
                                                      <div class="table-responsive">
                                                          <table id="example" class="table table-hover table-sm" style=" border-spacing: 0; width: 100%;">
                                                              <thead>
                                                                      <tr style="font-size:13px">
                                                                          <th class="text-center" width="5%" style="background-color: #faddd4">ลำดับ</th>
                                                                          <th class="text-center" style="background-color: #a7e5fd">เดือน</th>
                                                                          <th class="text-center" style="background-color: #a7e5fd">ปี</th>
                                                                          <th class="text-center" width="8%" style="background-color: #a7e5fd">AIR ทั้งหมด(เครื่อง)</th>
                                                                          <th class="text-center" width="8%" style="background-color: #a7e5fd">AIR ที่ซ่อม(เครื่อง)</th>
                                                                          <th class="text-center" width="8%" style="background-color: #a7e5fd">ปัญหาซ่อม AIR(รายการ)</th>
                                                                          <th class="text-center" width="8%" style="background-color: #a7e5fd">แผนการบำรุงรักษา(ครั้ง)</th>
                                                                          <th class="text-center" width="8%" style="background-color: #a7e5fd">ผลการบำรุงรักษา(ครั้ง)</th>
                                                                          <th class="text-center" width="8%" style="background-color: #a7e5fd">ร้อยละ AIR ที่ซ่อม</th>
                                                                          <th class="text-center" width="8%" style="background-color: #a7e5fd">ร้อยละ AIR ที่บำรุงรักษา</th>
                                                                          <th class="text-center" width="8%" style="background-color: #a7e5fd">Print</th>
                                                                      </tr>
                                                              </thead>
                                                              <tbody>
                                                                  <?php $i = 0; ?>
                                                                  @foreach ($datashow as $item)
                                                                  <?php $i++  ?>
                                                                  <?php
                                                                          $plan_count = DB::select(
                                                                              'SELECT COUNT(a.air_plan_id) as air_plan_id
                                                                                  FROM air_plan a
                                                                                  LEFT JOIN air_plan_month b ON b.air_plan_month_id = a.air_plan_month_id
                                                                                  WHERE a.air_plan_year = "'.$item->bg_yearnow.'"
                                                                                  AND b.month_no = "'.$item->months.'"
                                                                              ');
                                                                              // AND b.air_plan_month = "'.$item->months.'"
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
                                                                  ?>
                                                                      <tr>
                                                                          <td class="text-center" style="font-size:13px;width: 5%;color: rgb(13, 134, 185)">{{$i}}</td>
                                                                          <td class="text-start" style="font-size:14px;color: rgb(45, 135, 219)">{{$item->MONTH_NAME}}</td>
                                                                          <td class="text-start" style="font-size:14px;color: rgb(45, 135, 219)">พ.ศ. {{$item->years_ps}}</td>
                                                                          <td class="text-center" style="font-size:13px;color: rgb(236, 36, 210)" width="11%">
                                                                                  {{$item->total_qty}}
                                                                          </td>
                                                                          <td class="text-center" style="font-size:13px;color: rgb(253, 65, 81)" width="10%">
                                                                                   {{$airproblems}}
                                                                          </td>
                                                                          <td class="text-center" style="font-size:13px;color: rgb(252, 90, 203)" width="11%">
                                                                                  {{$airproblems04}}
                                                                          </td>
                                                                          <td class="text-center" style="font-size:13px;color: rgb(5, 179, 170)" width="11%">
                                                                                  {{$plan}}
                                                                          </td>
                                                                          <td class="text-center" style="font-size:13px;color: rgb(253, 102, 15)" width="11%">
                                                                                  {{$airproblems_plan}}
                                                                          </td>
                                                                          <td class="text-center" style="font-size:13px;color: rgb(10, 132, 231)" width="10%">
                                                                                  {{number_format($percent_ploblames, 2)}} %
                                                                          </td>
                                                                          <td class="text-center" style="font-size:13px;color: rgb(250, 128, 138)" width="11%">
                                                                                  {{number_format($percent_plan, 2)}} %
                                                                          </td>
                                                                          <td class="text-center" style="font-size:11px;color: rgb(250, 128, 138)" width="5%">
                                                                              <a href="{{URL('report_prs_air/'.$item->air_stock_month_id)}}" target="_blank" class="ladda-button btn-pill btn btn-sm btn-primary bt_prs">
                                                                                  <i class="fa-solid fa-print text-white" style="font-size:11px"></i>
                                                                              </a>
                                                                          </td>
                      
                                                                      </tr>
                                                                  @endforeach
                                                              </tbody>
                                                          </table>
                                                      </div>
                                                  </p>
                                              @endif
                                          </div>
                                      </div>
                                  </div>
                              </div>
                              </div>
                          </div>

                          <div class="collapse" id="collapseFire">
                            <div class="card card-body mb-0">
                              collapseFire
                            </div>
                          </div>

                          <div class="collapse" id="collapsecctv">
                            <div class="card card-body mb-0">
                              กล้อง CCTV
                            </div>
                          </div>

                          <div class="collapse" id="collapsewatersub">
                            <div class="card card-body mb-0">
                              น้ำสำรอง
                            </div>
                          </div>
                          <div class="collapse" id="collapsewaterdrink">
                            <div class="card card-body mb-0">
                              น้ำบริโภค
                            </div>
                          </div>
                          <div class="collapse" id="collapseGenerator">
                            <div class="card card-body mb-0">
                              เครื่องกำเนิดไฟฟ้า
                            </div>
                          </div>
                          <div class="collapse" id="collapsetransformer">
                            <div class="card card-body mb-0">
                              หม้อแปลงไฟฟ้า
                            </div>
                          </div>
                          <div class="collapse" id="collapseelevator">
                            <div class="card card-body mb-0">
                              ลิฟต์โดยสาร
                            </div>
                          </div>
                          <div class="collapse" id="collapseToilet">
                            <div class="card card-body mb-0">
                              ห้องน้ำ/ห้องส้วม
                            </div>
                          </div>
                          <div class="collapse" id="collapseMedical">
                            <div class="card card-body mb-0">
                              <div class="row mt-3">
                                <div class="col-xl-12">
                                    <div class="card card_prs_4">
                                        <div class="card-body">

                                          <p class="mb-0">
                                            <div class="table-responsive">
                                                <table id="example2" class="table table-hover" style=" border-spacing: 0; width: 100%;">
                                                    <thead>
                                                            {{-- <tr style="font-size:13px">
                                                                <th class="text-center" width="5%">ลำดับ</th>
                                                                <th class="text-center">เดือน</th>
                                                                <th class="text-center">ปี</th>
                                                                <th class="text-center" width="8%">AIR ทั้งหมด(เครื่อง)</th>
                                                                <th class="text-center" width="8%">AIR ที่ซ่อม(เครื่อง)</th>
                                                                <th class="text-center" width="8%">ปัญหาซ่อม AIR(รายการ)</th>
                                                                <th class="text-center" width="8%">แผนการบำรุงรักษา(ครั้ง)</th>
                                                                <th class="text-center" width="8%">ผลการบำรุงรักษา(ครั้ง)</th>
                                                                <th class="text-center" width="8%">ร้อยละ AIR ที่ซ่อม</th>
                                                                <th class="text-center" width="8%">ร้อยละ AIR ที่บำรุงรักษา</th>
                                                                <th class="text-center" width="8%">Print</th>
                                                            </tr> --}}
                                                            <thead>
                                                              <tr style="font-size:12px">
                                                                  <th rowspan="2" class="text-center" style="background-color: #faddd4;color:#4d4b4b;" width= "2%">ลำดับ</th>
                                                                  <th rowspan="2" class="text-center" style="background-color: #92ddca;color:#4d4b4b;" width= "7%">เดือน</th>
                                                                  <th rowspan="2" class="text-center" style="background-color: #92ddca;color:#4d4b4b;" width= "3%">ปี</th>
                                                                  <th rowspan="2" class="text-center" style="background-color: #92ddca;color:#4d4b4b;" width= "3%">จำนวนวัน</th>
                                                                  <th colspan="2" class="text-center" style="background-color: #e9b1f7" width= "8%">Tank Liquid Oxygen(Main)</th>
                                                                  <th colspan="2" class="text-center" style="background-color: #b1e9f7" width= "8%">Tank Liquid Oxygen(Sub)</th>
                                                                  <th colspan="2" class="text-center" style="background-color: #fca8dc" width= "8%">ไนตรัสออกไซด์ (N2O-6Q)</th>
                                                                  <th colspan="2" class="text-center" style="background-color: #d1fdd8" width= "8%">ก๊าซอ๊อกซิเจน (2Q-6Q)</th>
                                                                  <th colspan="2" class="text-center" style="background-color: #f7bcb1" width= "8%">Control Gas</th>
                                                                  <th rowspan="2" class="text-center" width="8%" style="background-color: #a7e5fd">Print</th>
                                                              </tr>
                                                              <tr style="font-size:12px"> 
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
                                                    </thead>                                                   
                                                    <tbody>
                                                      @php $ig = 1;
                                                          $start = new DateTime('first day of this month midnight');
                                                          $end   = new DateTime('first day of next month midnight'); 
                                                          $interval = new DateInterval('P1D'); // ระยะเวลาห่างกัน 1 วัน
                                                          $period = new DatePeriod($start, $interval, $end); 
                                                      @endphp
                                                      @foreach ($datashow_gas as $item_gas)

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
          
                                                          <tr id="tr_{{$item_gas->gas_report_id}}">
                                                              <td class="text-center" width="5%">{{ $ig++ }}</td>
                                                              <td class="text-start" width="10%" style="font-size: 14px">{{ $item_gas->month_name }}</td>
                                                              <td class="text-start" style="font-size: 13px">{{ $item_gas->years_th }}</td>
                                                              <td class="text-center" style="font-size: 13px">{{$data_m1}}</td>
                                                              <td class="text-center" style="font-size: 13px;color:#e268dc">{{ $count_main2*$data_m1 }}</td>
                                                              <td class="text-center" style="font-size: 13px;color:#d135c9">{{ $count_main }}</td>
                                                              <td class="text-center" style="font-size: 13px;color:#269bb8">{{ $count_sub*$data_m1 }}</td>
                                                              <td class="text-center" style="font-size: 13px;color:#54c6e2">{{ $check_sub }}</td>
                                                              <td class="text-center" style="font-size: 13px;color:#f56dc1">{{ $count_n2o*$data_m1 }}</td>
                                                              <td class="text-center" style="font-size: 13px;color:#f88ed0">{{ $check_n2o }}</td>
                                                              <td class="text-center" style="font-size: 13px;color:#1db356">{{ $count_oq2q6*$data_m1 }}</td>
                                                              <td class="text-center" style="font-size: 13px;color:#50e087">{{ $checkoq2q6_count }}</td>
                                                              <td class="text-center" style="font-size: 13px;color:#d135c9"></td>
                                                              <td class="text-center" style="font-size: 13px;color:#d135c9"></td>
                                                              <td class="text-center" style="font-size:13px;color: rgb(250, 128, 138)" width="5%">
                                                                <a href="{{URL('report_prs_gas/'.$item_gas->gas_report_id)}}" target="_blank" class="ladda-button btn-pill btn btn-sm btn-primary bt_prs">
                                                                    <i class="fa-solid fa-print text-white" style="font-size:13px"></i>
                                                                </a>
                                                            </td>
                                                          </tr>

                                                      @endforeach
                                                      
                                                      

                                                    </tbody>
                                                </table>
                                            </div>
                                          </p>
                                        </div>
                                    </div>
                                  </div>
                                </div>
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
                url: "{{ url('support_detail') }}",
                data: {
                    air_location_id: air_location_id
                },
                success: function(result) {
                    $('#detail').html(result);
                },
            });
        });

    </script>

@endsection
