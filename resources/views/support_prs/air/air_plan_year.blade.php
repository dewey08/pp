@extends('layouts.support_prs_airback')
@section('title', 'PK-OFFICE || Air-Service')

@section('content')
    <script>
        function TypeAdmin() {
            window.location.href = '{{ route('index') }}';
        }
        function air_main_repaire_destroy(air_repaire_id) {
            Swal.fire({
                position: "top-end",
                title: 'ต้องการลบใช่ไหม?',
                text: "ข้อมูลนี้จะถูกลบไปเลย !!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'ใช่, ลบเดี๋ยวนี้ !',
                cancelButtonText: 'ไม่, ยกเลิก'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ url('air_main_repaire_destroy') }}" + '/' + air_repaire_id,
                        type: 'POST',
                        data: {
                            _token: $("input[name=_token]").val()
                        },
                        success: function(response) {
                            if (response.status == 200 ) {
                                Swal.fire({
                                    position: "top-end",
                                    title: 'ลบข้อมูล!',
                                    text: "You Delet data success",
                                    icon: 'success',
                                    showCancelButton: false,
                                    confirmButtonColor: '#06D177',
                                    // cancelButtonColor: '#d33',
                                    confirmButtonText: 'เรียบร้อย'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        $("#sid" + air_repaire_id).remove();
                                        window.location.reload();
                                        // window.location = "{{ url('air_main') }}";
                                    }
                                })
                            } else {  
                            }
                        }
                    })
                }
            })
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

    
    <?php
    $ynow = date('Y') + 543;
    $yb = date('Y') + 542;
    ?>

<div class="tabs-animation">
{{-- <div class="containner-fluid"> --}}
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
                    <circle id="spinner" style="fill:transparent;stroke:#dd2476;stroke-width: 7px;stroke-linecap: round;filter:url(#shadow);" cx="50" cy="50" r="45"/>
                </svg>
            </div>
        </div>
    </div>
    {{-- <form action="{{ url('air_report_building') }}" method="GET">
        @csrf --}}
        <div class="row"> 
            <div class="col-md-7">
                <h4 style="color:rgb(255, 255, 255)">แผนการบำรุงรักษาเครื่องปรับอากาศโรงพยาบาลภูเขียวเฉลิมพะเกียรติ ปีงบประมาณ {{$bg_yearnow}} </h4>
   
            </div>
             
            {{-- <div class="col-md-1 text-end"> --}}
                {{-- <select class="form-control bt_prs" id="air_supplies_id" name="air_supplies_id" style="width: 100%"> --}}
                    {{-- <option value="" class="text-center">เลือกบริษัท</option> --}}
                        {{-- @foreach ($air_supplies as $item_t) --}}
                        {{-- @if ($supplies_id == $item_t->air_supplies_id) --}}
                            {{-- <option value="{{ $item_t->air_supplies_id }}" class="text-center" selected> {{ $item_t->supplies_name }}</option> --}}
                        {{-- @else --}}
                            {{-- <option value="{{ $item_t->air_supplies_id }}" class="text-center"> {{ $item_t->supplies_name }}</option> --}}
                        {{-- @endif  --}}
                        {{-- @endforeach  --}}
                {{-- </select> --}}
            {{-- </div> --}}
            {{-- <div class="col-md-2 text-end">  --}}
                {{-- <select class="form-control bt_prs" id="air_plan_month" name="air_plan_month" style="width: 100%" required> --}}
                    {{-- <option value="" class="text-center">เดือน / ปี</option> --}}
                        {{-- @foreach ($air_plan_month as $item_m) --}}
                        {{-- @if ($air_planmonth == $item_m->air_plan_month && $air_planyears == $item_m->air_plan_year) --}}
                            {{-- <option value="{{ $item_m->air_plan_month_id }}" class="text-center" selected> {{ $item_m->air_plan_name }} {{$item_m->years}}</option> --}}
                        {{-- @else --}}
                            {{-- <option value="{{ $item_m->air_plan_month_id }}" class="text-center"> {{ $item_m->air_plan_name }} {{$item_m->years}}</option> --}}
                        {{-- @endif  --}}
                        {{-- @endforeach  --}}
                {{-- </select> --}}
            {{-- </div> --}}
            <div class="col"></div>
            <div class="col-md-2 text-end"> 
                {{-- <a href="" class="ladda-button btn-pill btn btn-info bt_prs">
                    <span class="ladda-label"><i class="fa-solid fa-print text-white me-2"></i>Print</span>  
                </a> --}}
            {{-- </div> --}}
            {{-- <div class="col-md-2 text-end">  --}}
                <a href="{{url('air_plan_print/'.$bg_yearnow)}}" class="ladda-button btn-pill btn btn-sm btn-primary bt_prs" target="_blank">
                    <span class="ladda-label"> <i class="fa-solid fa-print text-white me-2"></i>Print</span>  
                </a>
          
                <a href="{{url('air_plan_yearexcel')}}" class="ladda-button btn-pill btn btn-sm btn-success bt_prs" target="_blank">
                    <span class="ladda-label"> <i class="fa-solid fa-file-excel text-white me-2"></i>Excel</span>  
                </a>

            
            </div>
        </div>  
    {{-- </form> --}}
 
<div class="row mt-2">
    <div class="col-xl-12">
        <div class="card card_prs_4">
            <div class="card-body">    
                

                <p class="mb-0">
                    <div class="table-responsive">
                        {{-- <table id="example" class="table table-hover table-sm dt-responsive nowrap myTable" style=" border-spacing: 0; width: 100%;"> --}}
                        <table class="table table-hover table-sm dt-responsive nowrap myTable" style=" border-spacing: 0; width: 100%;">
                        {{-- <table id="example" class="table table-hover table-sm dt-responsive" style="width: 100%;"> --}}
                            {{-- <table id="example" class="table table-borderless table-hover table-bordered" style="width: 100%;"> --}}
                                {{-- <table id="example" class="table table-borderless table-hover table-bordered" style="width: 100%;"> --}}
                            <thead>                             
                                    <tr style="font-size:13px"> 
                                        {{-- <th rowspan="2" width="3%" class="text-center" style="background-color: rgb(228, 255, 255);">ลำดับ</th>   --}}
                                        <th rowspan="2" class="text-center" style="background-color: rgb(255, 156, 110);color:#FFFFFF" width= "12%">อาคาร</th>  
                                        {{-- <th rowspan="2" class="text-center" style="background-color: rgb(228, 255, 255);width: 7%">อาคาร</th>   --}}
                                        <th rowspan="2" class="text-center" style="background-color: #06b78b;color:#FFFFFF;" width= "5%">จำนวน</th>  
                                        <th colspan="12" class="text-center" style="background-color: rgb(154, 86, 255);color:#FFFFFF">ระยะเวลาการดำเนินงาน</th>   
                                    </tr> 
                                    <tr style="font-size:11px">  
                                        <th class="text-center" width="5%" style="background-color: rgb(185, 140, 253);color:#FFFFFF">ต.ค</th> 
                                        <th class="text-center" width="5%" style="background-color: rgb(209, 178, 255);color:#FFFFFF">พ.ย</th>   
                                        <th class="text-center" width="5%" style="background-color: rgb(185, 140, 253);color:#FFFFFF">ธ.ค</th> 
                                        <th class="text-center" width="5%" style="background-color: rgb(209, 178, 255);color:#FFFFFF">ม.ค</th>
                                        <th class="text-center" width="5%" style="background-color: rgb(185, 140, 253);color:#FFFFFF">ก.พ</th>
                                        <th class="text-center" width="5%" style="background-color: rgb(209, 178, 255);color:#FFFFFF">มี.ค</th> 
                                        <th class="text-center" width="5%" style="background-color: rgb(185, 140, 253);color:#FFFFFF">เม.ย</th>
                                        <th class="text-center" width="5%" style="background-color: rgb(209, 178, 255);color:#FFFFFF">พ.ค</th>
                                        <th class="text-center" width="5%" style="background-color: rgb(185, 140, 253);color:#FFFFFF">มิ.ย</th>
                                        <th class="text-center" width="5%" style="background-color: rgb(209, 178, 255);color:#FFFFFF">ก.ค</th>
                                        <th class="text-center" width="5%" style="background-color: rgb(185, 140, 253);color:#FFFFFF">ส.ค</th>
                                        <th class="text-center" width="5%" style="background-color: rgb(209, 178, 255);color:#FFFFFF">ก.ย</th>
                                    </tr> 
                            </thead>
                            <tbody>
                                <?php $i = 0;
                                    $total1 = 0; $total2 = 0; $total3 = 0; $total4 = 0; $total5 = 0; $total6 = 0; $total7 = 0; $total8 = 0; $total9 = 0; $total10 = 0; $total11 = 0; $total12 = 0;$total13 = 0;  
                                    $total14 = 0; $total15 = 0; $total16 = 0;$total17 = 0; $total18 = 0; $total19 = 0; $total20 = 0;$total21 = 0;$total22 = 0;$total23 = 0;$total24 = 0;$total25 = 0;
                                    $total26 = 0;$total27 = 0;$total28 = 0;$total29 = 0;$total30 = 0;$total31 = 0;$total32 = 0;$total33 = 0;$total34 = 0;$total35 = 0;$total36 = 0;$total37 = 0;
                                    $total38 = 0;$total39 = 0;$total40 = 0;$total41 = 0;$total42 = 0;$total43 = 0;$total44 = 0;$total45 = 0;$total46 = 0;$total47 = 0;$total48 = 0;$total49 = 0;$total50 = 0;
                                    $total51 = 0;$total52 = 0;$total53 = 0;$total54 = 0;$total55 = 0;$total56 = 0;$total57 = 0;$total58 = 0;$total59 = 0;$total60 = 0;$total61 = 0;
                                ?>
                                @foreach ($datashow as $item) 
                                <?php $i++ ?>               
                                    <tr>     
                                        <td class="text-start" style="font-size:12px;color: rgb(2, 95, 182)">{{$item->building_name}}</td>
                                        {{-- <td class="text-center" style="font-size:13px;color: rgb(4, 117, 117)">{{$item->building_id}}</td> --}}
                                        <td class="text-center" style="font-size:13px;color: rgb(228, 15, 86)">
                                           {{-- <a href="{{url('air_report_building_sub/'.$item->building_id)}}" target="_blank">  --}}
                                                <span class="badge bg-success me-2"> {{$item->qtyall}}</span> 
                                                {{-- <a href="" class="ladda-button btn-pill btn btn-info bt_prs">
                                                    <span class="badge bg-success me-2"><i class="fa-solid fa-print text-white me-2"></i>{{$item->qtyall}}</span>  
                                                </a> --}}
                                                <span class="badge bg-danger"> {{$item->qty_noall}}</span>
                                            {{-- </a>  --}}
                                        </td>
                                        <td class="text-center" style="font-size:13px;color: #fc2783"> 
                                            <a href="{{URL('air_plan_year_detail/'.$item->building_id.'/1/10')}}">
                                                <span class="badge bg-info me-2"> {{$item->tula_saha}} / {{$item->tula_saha_plantrue}}</span>  
                                            </a>
                                            <a href="{{URL('air_plan_year_detail/'.$item->building_id.'/2/10')}}"> 
                                                <span class="badge" style="background: #fc2783"> {{$item->tula_bt}} / {{$item->tula_bt_plantrue}} </span>
                                            </a>
                                        </td>
                                        <td class="text-center" style="font-size:13px;color: #fc2783">
                                            <a href="{{URL('air_plan_year_detail/'.$item->building_id.'/1/11')}}">
                                                <span class="badge bg-info me-2"> {{$item->plusji_saha}} / {{$item->plusji_saha_plantrue}}</span>  
                                            </a>
                                            <a href="{{URL('air_plan_year_detail/'.$item->building_id.'/2/11')}}">
                                                <span class="badge" style="background: #fc2783"> {{$item->plusji_bt}} / {{$item->plusji_bt_plantrue}}</span>
                                            </a>
                                        </td>
                                        <td class="text-center" style="font-size:13px;color: #fc2783">
                                            <a href="{{URL('air_plan_year_detail/'.$item->building_id.'/1/12')}}">
                                                <span class="badge bg-info me-2"> {{$item->tanwa_saha}} / {{$item->tanwa_saha_plantrue}}</span> 
                                            </a>
                                            <a href="{{URL('air_plan_year_detail/'.$item->building_id.'/2/12')}}">
                                                 <span class="badge" style="background: #fc2783"> {{$item->tanwa_bt}} / {{$item->tanwa_bt_plantrue}}</span>
                                            </a>
                                        </td>
                                        <td class="text-center" style="font-size:13px;color: #fc2783">
                                            <a href="{{URL('air_plan_year_detail/'.$item->building_id.'/1/1')}}">
                                                <span class="badge bg-info me-2"> {{$item->makkara_saha}} / {{$item->makkara_saha_plantrue}}</span>  
                                            </a>
                                            <a href="{{URL('air_plan_year_detail/'.$item->building_id.'/2/1')}}">
                                                 <span class="badge" style="background: #fc2783"> {{$item->makkara_bt}} / {{$item->makkara_bt_plantrue}}</span>
                                            </a>
                                        </td>
                                        <td class="text-center" style="font-size:13px;color: #fc2783">
                                            <a href="{{URL('air_plan_year_detail/'.$item->building_id.'/1/2')}}">
                                                <span class="badge bg-info me-2"> {{$item->gumpa_saha}} / {{$item->gumpa_saha_plantrue}}</span>  
                                            </a>
                                            <a href="{{URL('air_plan_year_detail/'.$item->building_id.'/2/2')}}">
                                                  <span class="badge" style="background: #fc2783"> {{$item->gumpa_bt}} / {{$item->gumpa_bt_plantrue}}</span>
                                            </a>
                                        </td>
                                        <td class="text-center" style="font-size:13px;color: #fc2783">
                                            <a href="{{URL('air_plan_year_detail/'.$item->building_id.'/1/3')}}">
                                                <span class="badge bg-info me-2"> {{$item->mena_saha}} / {{$item->mena_saha_plantrue}}</span>  
                                            </a>
                                            <a href="{{URL('air_plan_year_detail/'.$item->building_id.'/2/3')}}">
                                                 <span class="badge" style="background: #fc2783"> {{$item->mena_bt}} / {{$item->mena_bt_plantrue}}</span>
                                            </a>
                                        </td>
                                        <td class="text-center" style="font-size:13px;color: #fc2783">
                                            <a href="{{URL('air_plan_year_detail/'.$item->building_id.'/1/4')}}">
                                                <span class="badge bg-info me-2"> {{$item->mesa_saha}} / {{$item->mesa_saha_plantrue}}</span> 
                                            </a>
                                            <a href="{{URL('air_plan_year_detail/'.$item->building_id.'/2/4')}}">
                                                  <span class="badge" style="background: #fc2783"> {{$item->mesa_bt}} / {{$item->mesa_bt_plantrue}}</span>
                                            </a>
                                        </td>
                                        <td class="text-center" style="font-size:13px;color: #fc2783"> 
                                            <a href="{{URL('air_plan_year_detail/'.$item->building_id.'/1/5')}}">
                                                <span class="badge bg-info me-2"> {{$item->plussapa_saha}} / {{$item->plussapa_saha_plantrue}}</span>  
                                            </a>
                                            <a href="{{URL('air_plan_year_detail/'.$item->building_id.'/2/5')}}">
                                                 <span class="badge" style="background: #fc2783"> {{$item->plussapa_bt}} / {{$item->plussapa_bt_plantrue}}</span>
                                            </a>
                                        </td>
                                        <td class="text-center" style="font-size:13px;color: #fc2783">
                                            <a href="{{URL('air_plan_year_detail/'.$item->building_id.'/1/6')}}">
                                                <span class="badge bg-info me-2"> {{$item->mituna_saha}} / {{$item->mituna_saha_plantrue}}</span>  
                                            </a>
                                            <a href="{{URL('air_plan_year_detail/'.$item->building_id.'/2/6')}}">
                                                  <span class="badge" style="background: #fc2783"> {{$item->mituna_bt}} / {{$item->mituna_bt_plantrue}}</span>
                                            </a>
                                        </td>
                                        <td class="text-center" style="font-size:13px;color: #fc2783">
                                            <a href="{{URL('air_plan_year_detail/'.$item->building_id.'/1/7')}}">
                                                <span class="badge bg-info me-2"> {{$item->karakada_saha}} / {{$item->karakada_saha_plantrue}}</span> 
                                            </a>
                                            <a href="{{URL('air_plan_year_detail/'.$item->building_id.'/2/7')}}">
                                                 <span class="badge" style="background: #fc2783"> {{$item->karakada_bt}} / {{$item->karakada_bt_plantrue}}</span>
                                            </a>
                                        </td>
                                        <td class="text-center" style="font-size:13px;color: #fc2783">   
                                            <a href="{{URL('air_plan_year_detail/'.$item->building_id.'/1/8')}}">
                                                <span class="badge bg-info me-2"> {{$item->singha_saha}} / {{$item->singha_saha_plantrue}}</span>  
                                            </a>
                                            <a href="{{URL('air_plan_year_detail/'.$item->building_id.'/2/8')}}">
                                                  <span class="badge" style="background: #fc2783"> {{$item->singha_bt}} / {{$item->singha_bt_plantrue}}</span>
                                            </a>
                                        </td>
                                        <td class="text-center" style="font-size:13px;color: #fc2783">   
                                            <a href="{{URL('air_plan_year_detail/'.$item->building_id.'/1/9')}}"> 
                                                <span class="badge bg-info me-2"> {{$item->kanya_saha}} / {{$item->kanya_saha_plantrue}}</span> 
                                            </a>
                                            <a href="{{URL('air_plan_year_detail/'.$item->building_id.'/2/9')}}"> 
                                                  <span class="badge" style="background: #fc2783"> {{$item->kanya_bt}} / {{$item->kanya_bt_plantrue}}</span>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php
                                            $total1 = $total1 + $item->qtyall;

                                            $total2 = $total2 + $item->tula_saha;
                                            $total14 = $total14 + $item->tula_bt;
                                            $total3 = $total3 + $item->plusji_saha; 
                                            $total15 = $total15 + $item->plusji_bt; 
                                            $total4 = $total4 + $item->tanwa_saha; 
                                            $total16 = $total16 + $item->tanwa_bt; 
                                            $total5 = $total5 + $item->makkara_saha; 
                                            $total17 = $total17 + $item->makkara_bt; 
                                            $total6 = $total6 + $item->gumpa_saha; 
                                            $total18 = $total18 + $item->gumpa_bt; 
                                            $total7 = $total7 + $item->mena_saha; 
                                            $total19 = $total19 + $item->mena_bt; 
                                            $total8 = $total8 + $item->mesa_saha; 
                                            $total20 = $total20 + $item->mesa_bt;
                                            $total9 = $total9 + $item->plussapa_saha; 
                                            $total21 = $total21 + $item->plussapa_bt; 
                                            $total10 = $total10 + $item->mituna_saha; 
                                            $total22 = $total22 + $item->mituna_bt;
                                            $total11 = $total11 + $item->karakada_saha; 
                                            $total23 = $total23 + $item->karakada_bt; 
                                            $total12 = $total12 + $item->singha_saha; 
                                            $total24 = $total24 + $item->singha_bt;                                            
                                            $total13 = $total13 + $item->kanya_saha; 
                                            $total25 = $total25 + $item->kanya_bt;

                                            $total26 = $total26 + ($item->tula_saha_plantrue+$item->tula_bt_plantrue);
                                            $total27 = $total27 + ($item->plusji_saha_plantrue+$item->plusji_bt_plantrue);
                                            $total28 = $total28 + ($item->tanwa_saha_plantrue+$item->tanwa_bt_plantrue);
                                            $total29 = $total29 + ($item->makkara_saha_plantrue+$item->makkara_bt_plantrue);
                                            $total30 = $total30 + ($item->gumpa_saha_plantrue+$item->gumpa_bt_plantrue);
                                            $total31 = $total31 + ($item->mena_saha_plantrue+$item->mena_bt_plantrue);
                                            $total32 = $total32 + ($item->mesa_saha_plantrue+$item->mesa_bt_plantrue);
                                            $total33 = $total33 + ($item->plussapa_saha_plantrue+$item->plussapa_bt_plantrue);
                                            $total34 = $total34 + ($item->mituna_saha_plantrue+$item->mituna_bt_plantrue);
                                            $total35 = $total35 + ($item->karakada_saha_plantrue+$item->karakada_bt_plantrue);
                                            $total36 = $total36 + ($item->singha_saha_plantrue+$item->singha_bt_plantrue);
                                            $total37 = $total37 + ($item->kanya_saha_plantrue+$item->kanya_bt_plantrue);

                                            $total38 = $total38 + ($item->tula_saha_plantrue);
                                            $total39 = $total39 + ($item->plusji_saha_plantrue);
                                            $total40 = $total40 + ($item->tanwa_saha_plantrue);
                                            $total41 = $total41 + ($item->makkara_saha_plantrue);
                                            $total42 = $total42 + ($item->gumpa_saha_plantrue);
                                            $total43 = $total43 + ($item->mena_saha_plantrue);
                                            $total44 = $total44 + ($item->mesa_saha_plantrue);
                                            $total45 = $total45 + ($item->plussapa_saha_plantrue);
                                            $total46 = $total46 + ($item->mituna_saha_plantrue);
                                            $total47 = $total47 + ($item->karakada_saha_plantrue);
                                            $total48 = $total48 + ($item->singha_saha_plantrue);
                                            $total49 = $total49 + ($item->kanya_saha_plantrue);

                                            $total50 = $total50 + ($item->tula_bt_plantrue);
                                            $total51 = $total51 + ($item->plusji_bt_plantrue);
                                            $total52 = $total52 + ($item->tanwa_bt_plantrue);
                                            $total53 = $total53 + ($item->makkara_bt_plantrue);
                                            $total54 = $total54 + ($item->gumpa_bt_plantrue);
                                            $total55 = $total55 + ($item->mena_bt_plantrue);
                                            $total56 = $total56 + ($item->mesa_bt_plantrue);
                                            $total57 = $total57 + ($item->plussapa_bt_plantrue);
                                            $total58 = $total58 + ($item->mituna_bt_plantrue);
                                            $total59 = $total59 + ($item->karakada_bt_plantrue);
                                            $total60 = $total60 + ($item->singha_bt_plantrue);
                                            $total61 = $total61 + ($item->kanya_bt_plantrue);
                                            
                                               
                                               

                                            $Total_saha = $total2+$total3+$total4+$total5+$total6+$total7+$total8+$total9+$total10+$total11+$total12+$total13;
                                            $Total_bt   = $total14+$total15+$total16+$total17+$total18+$total19+$total20+$total21+$total22+$total23+$total24+$total25;
                                    ?>
                                @endforeach
                            </tbody>
                           
                            <tr>
                                <td colspan="1" class="text-end" style="background-color: #fabcd7;font-size:16px">รวม</td>
                                {{-- <td class="text-center" style="background-color: #fcd3e5"><label for="" style="color: #FFFFFF;font-size:16px">{{$Total_saha+$Total_bt }}</label></td> --}}
                                <td class="text-center" style="background-color: #fcd3e5"><label for="" style="color: #b3064e;font-size:16px">{{$total1 }}</label></td>
                                <td class="text-center" style="background-color: #fabcd7" >
                                    <label for="" style="color: #b3064e;font-size:16px">
                                        {{$total2+$total14}} / {{$total26}}
                                        {{-- <span class="badge bg-primary me-2"> {{$total2+$total14}}</span>  --}}
                                    </label>  
                                </td>
                                <td class="text-center" style="background-color: #fabcd7" >
                                    <label for="" style="color: #b3064e;font-size:16px">
                                        {{$total3+$total15}} / {{$total27}}
                                        {{-- <span class="badge bg-primary me-2"> {{$total3+$total15}}</span>   --}}
                                    </label></td>
                                <td class="text-center" style="background-color: #fabcd7" >
                                    <label for="" style="color: #b3064e;font-size:16px">
                                        {{$total4+$total16}} / {{$total28}}
                                        {{-- <span class="badge bg-primary me-2"> {{$total4+$total16}}</span>    --}}
                                    </label>
                                    </td>
                                <td class="text-center" style="background-color: #fabcd7" >
                                    <label for="" style="color: #b3064e;font-size:16px">
                                        {{$total5+$total17}} / {{$total29}}
                                        {{-- <span class="badge bg-primary me-2"> {{$total5+$total17}}</span>   --}}
                                    </label>
                                </td>
                                <td class="text-center" style="background-color: #fabcd7" >
                                    <label for="" style="color: #b3064e;font-size:16px">
                                        {{$total6+$total18}} / {{$total30}}
                                        {{-- <span class="badge bg-primary me-2"> {{$total6+$total18}}</span>   --}}
                                    </label>
                                </td>
                                <td class="text-center" style="background-color: #fabcd7" >
                                    <label for="" style="color: #b3064e;font-size:16px">
                                        {{$total7+$total19}} / {{$total31}}
                                        {{-- <span class="badge bg-primary me-2"> {{$total7+$total19}}</span>   --}}
                                    </label>
                                </td>
                                <td class="text-center" style="background-color: #fabcd7" >
                                    <label for="" style="color: #b3064e;font-size:16px">
                                        {{$total8+$total20}} / {{$total32}}
                                        {{-- <span class="badge bg-primary me-2"> {{$total8+$total20}}</span>   --}}
                                    </label>
                                </td>
                                <td class="text-center" style="background-color: #fabcd7" >
                                    <label for="" style="color: #b3064e;font-size:16px">
                                        {{$total9+$total21}} / {{$total33}}
                                        {{-- <span class="badge bg-primary me-2"> {{$total9+$total21}}</span>   --}}
                                    </label>
                                </td>
                                <td class="text-center" style="background-color: #fabcd7" >
                                    <label for="" style="color: #b3064e;font-size:16px">
                                        {{$total10+$total22}} / {{$total34}}
                                        {{-- <span class="badge bg-primary me-2"> {{$total10+$total22}}</span>   --}}
                                    </label>
                                </td>
                                <td class="text-center" style="background-color: #fabcd7" >
                                    <label for="" style="color: #b3064e;font-size:16px">
                                        {{$total11+$total23}} / {{$total35}}
                                        {{-- <span class="badge bg-primary me-2"> {{$total11+$total23}}</span>   --}}
                                    </label>
                                </td>
                                <td class="text-center" style="background-color: #fabcd7" >
                                    <label for="" style="color: #b3064e;font-size:16px">
                                        {{$total12+$total24}} / {{$total36}}
                                        {{-- <span class="badge bg-primary me-2"> {{$total12+$total24}}</span>   --}}
                                    </label>
                                </td>
                                <td class="text-center" style="background-color: #fabcd7" >
                                    <label for="" style="color: #b3064e;font-size:16px">
                                        {{$total13+$total25}} / {{$total37}}
                                        {{-- <span class="badge bg-primary me-2"> {{$total13+$total25}}</span>   --}}
                                    </label>
                                </td>
                                
                            </tr>  
                           
                            <tr>
                                <td colspan="1" class="text-end" style="background-color: #fc2783;color:#FFFFFF;font-size:16px"> 
                                    บริษัทบีทีแอร์
                                </td>
                                <td class="text-center" style="background-color: #fc85b9"> 
                                    {{-- <label for="" style="color: #FFFFFF;font-size:16px">{{$Total_bt }}</label> --}}
                                    <a href="{{url('air_plan_year_print_sup/2/'.$bg_yearnow)}}" target="_blank">
                                        <span class="badge me-2" style="background-color: #ffffffbb"><i class="fa-solid fa-print me-2 ms-2" style="color: #fc2783"></i><label style="color: #fc2783;font-size:16px" class="me-2 mt-2">{{$Total_bt }}</label></span>  
                                        {{-- <span class="badge me-2" style="background-color: #ffffffbb"><i class="fa-solid fa-print text-success me-2 ms-2"></i> <label style="color: #04a79e;font-size:16px" class="me-2 mt-2">{{$Total_saha }}</label></span>   --}}
                                    </a>
                                    {{-- <a href="" class="ladda-button btn-pill btn btn-info bt_prs">
                                        <span class="badge bg-success me-2"><i class="fa-solid fa-print text-white me-2"></i> <label for="" style="color: #FFFFFF;font-size:16px">{{$Total_bt }}</label></span>  
                                    </a> --}}
                                </td>
                                <td class="text-center" style="background-color: #fc2783" >
                                    {{-- <label for="" style="color: #FFFFFF;font-size:16px">{{$total14}}</label>   --}}
                                    <a href="{{url('air_plan_year_print/2/10/'.$bg_yearnow)}}" target="_blank">
                                        {{-- <span class="badge bg-success me-2"><i class="fa-solid fa-print text-white me-2 ms-2"></i> <label style="color: #FFFFFF;font-size:16px" class="me-2 mt-2">{{$total14 }}</label></span>   --}}
                                        <span class="badge me-2" style="background-color: #ffffffbb"><i class="fa-solid fa-print me-2 ms-2" style="color: #fc2783"></i><label style="color: #fc2783;font-size:16px" class="me-2 mt-2">{{$total14 }} / {{$total50 }} </label></span>  
                                    </a>
                                </td>
                                <td class="text-center" style="background-color: #fc2783" >
                                    {{-- <label for="" style="color: #FFFFFF;font-size:16px">{{$total15}}</label> --}}
                                    <a href="{{url('air_plan_year_print/2/11/'.$bg_yearnow)}}" target="_blank">
                                        {{-- <span class="badge bg-success me-2"><i class="fa-solid fa-print text-white me-2 ms-2"></i> <label style="color: #FFFFFF;font-size:16px" class="me-2 mt-2">{{$total15 }}</label></span>   --}}
                                        <span class="badge me-2" style="background-color: #ffffffbb"><i class="fa-solid fa-print me-2 ms-2" style="color: #fc2783"></i><label style="color: #fc2783;font-size:16px" class="me-2 mt-2">{{$total15 }} / {{$total51 }}</label></span>  
                                    </a> 
                                </td>
                                <td class="text-center" style="background-color: #fc2783" >
                                    {{-- <label for="" style="color: #FFFFFF;font-size:16px">{{$total16}}</label> --}}
                                    <a href="{{url('air_plan_year_print/2/12/'.$bg_yearnow)}}" target="_blank">
                                        {{-- <span class="badge bg-success me-2"><i class="fa-solid fa-print text-white me-2 ms-2"></i> <label style="color: #FFFFFF;font-size:16px" class="me-2 mt-2">{{$total16 }}</label></span> --}}
                                        <span class="badge me-2" style="background-color: #ffffffbb"><i class="fa-solid fa-print me-2 ms-2" style="color: #fc2783"></i><label style="color: #fc2783;font-size:16px" class="me-2 mt-2">{{$total16 }} / {{$total52 }}</label></span>    
                                    </a> 
                                </td>
                                <td class="text-center" style="background-color: #fc2783" >
                                    {{-- <label for="" style="color: #FFFFFF;font-size:16px"> {{$total17}} </label> --}}
                                    <a href="{{url('air_plan_year_print/2/1/'.$bg_yearnow)}}" target="_blank">
                                        {{-- <span class="badge bg-success me-2"><i class="fa-solid fa-print text-white me-2 ms-2"></i> <label style="color: #FFFFFF;font-size:16px" class="me-2 mt-2">{{$total17 }}</label></span>  --}}
                                        <span class="badge me-2" style="background-color: #ffffffbb"><i class="fa-solid fa-print me-2 ms-2" style="color: #fc2783"></i><label style="color: #fc2783;font-size:16px" class="me-2 mt-2">{{$total17 }} / {{$total53 }}</label></span>   
                                    </a> 
                                </td>
                                <td class="text-center" style="background-color: #fc2783" >
                                    {{-- <label for="" style="color: #FFFFFF;font-size:16px"> {{$total18}} </label> --}}
                                    <a href="{{url('air_plan_year_print/2/2/'.$bg_yearnow)}}" target="_blank">
                                        {{-- <span class="badge bg-success me-2"><i class="fa-solid fa-print text-white me-2 ms-2"></i> <label style="color: #FFFFFF;font-size:16px" class="me-2 mt-2">{{$total18 }}</label></span>   --}}
                                        <span class="badge me-2" style="background-color: #ffffffbb"><i class="fa-solid fa-print me-2 ms-2" style="color: #fc2783"></i><label style="color: #fc2783;font-size:16px" class="me-2 mt-2">{{$total18 }} / {{$total54 }}</label></span>  
                                    </a> 
                                </td>
                                <td class="text-center" style="background-color: #fc2783" >
                                    {{-- <label for="" style="color: #FFFFFF;font-size:16px"> {{$total19}} </label> --}}
                                    <a href="{{url('air_plan_year_print/2/3/'.$bg_yearnow)}}" target="_blank">
                                        {{-- <span class="badge bg-success me-2"><i class="fa-solid fa-print text-white me-2 ms-2"></i> <label style="color: #FFFFFF;font-size:16px" class="me-2 mt-2">{{$total19 }}</label></span>   --}}
                                        <span class="badge me-2" style="background-color: #ffffffbb"><i class="fa-solid fa-print me-2 ms-2" style="color: #fc2783"></i><label style="color: #fc2783;font-size:16px" class="me-2 mt-2">{{$total19 }} / {{$total55 }}</label></span>  
                                    </a> 
                                </td>
                                <td class="text-center" style="background-color: #fc2783" >
                                    {{-- <label for="" style="color: #FFFFFF;font-size:16px"> {{$total20}} </label> --}}
                                    <a href="{{url('air_plan_year_print/2/4/'.$bg_yearnow)}}" target="_blank">
                                        {{-- <span class="badge bg-success me-2"><i class="fa-solid fa-print text-white me-2 ms-2"></i> <label style="color: #FFFFFF;font-size:16px" class="me-2 mt-2">{{$total20 }}</label></span>  --}}
                                        <span class="badge me-2" style="background-color: #ffffffbb"><i class="fa-solid fa-print me-2 ms-2" style="color: #fc2783"></i><label style="color: #fc2783;font-size:16px" class="me-2 mt-2">{{$total20 }} / {{$total56 }}</label></span>   
                                    </a> 
                                </td>
                                <td class="text-center" style="background-color: #fc2783" >
                                    {{-- <label for="" style="color: #FFFFFF;font-size:16px"> {{$total21}} </label> --}}
                                    <a href="{{url('air_plan_year_print/2/5/'.$bg_yearnow)}}" target="_blank">
                                        {{-- <span class="badge bg-success me-2"><i class="fa-solid fa-print text-white me-2 ms-2"></i> <label style="color: #FFFFFF;font-size:16px" class="me-2 mt-2">{{$total21 }}</label></span>  --}}
                                        <span class="badge me-2" style="background-color: #ffffffbb"><i class="fa-solid fa-print me-2 ms-2" style="color: #fc2783"></i><label style="color: #fc2783;font-size:16px" class="me-2 mt-2">{{$total21 }} / {{$total57 }}</label></span>   
                                    </a> 
                                </td>
                                <td class="text-center" style="background-color: #fc2783" >
                                    {{-- <label for="" style="color: #FFFFFF;font-size:16px"> {{$total22}} </label> --}}
                                    <a href="{{url('air_plan_year_print/2/6/'.$bg_yearnow)}}" target="_blank">
                                        {{-- <span class="badge bg-success me-2"><i class="fa-solid fa-print text-white me-2 ms-2"></i> <label style="color: #FFFFFF;font-size:16px" class="me-2 mt-2">{{$total22 }}</label></span>   --}}
                                        <span class="badge me-2" style="background-color: #ffffffbb"><i class="fa-solid fa-print me-2 ms-2" style="color: #fc2783"></i><label style="color: #fc2783;font-size:16px" class="me-2 mt-2">{{$total22 }} / {{$total58 }}</label></span>  
                                    </a> 
                                </td>
                                <td class="text-center" style="background-color: #fc2783" >
                                    {{-- <label for="" style="color: #FFFFFF;font-size:16px"> {{$total23}} </label> --}}
                                    <a href="{{url('air_plan_year_print/2/7/'.$bg_yearnow)}}" target="_blank">
                                        {{-- <span class="badge bg-success me-2"><i class="fa-solid fa-print text-white me-2 ms-2"></i> <label style="color: #FFFFFF;font-size:16px" class="me-2 mt-2">{{$total23 }}</label></span>   --}}
                                        <span class="badge me-2" style="background-color: #ffffffbb"><i class="fa-solid fa-print me-2 ms-2" style="color: #fc2783"></i><label style="color: #fc2783;font-size:16px" class="me-2 mt-2">{{$total23 }} / {{$total59 }}</label></span>  
                                    </a> 
                                </td>
                                <td class="text-center" style="background-color: #fc2783" >
                                    {{-- <label for="" style="color: #FFFFFF;font-size:16px"> {{$total24}} </label> --}}
                                    <a href="{{url('air_plan_year_print/2/8/'.$bg_yearnow)}}" target="_blank">
                                        {{-- <span class="badge bg-success me-2"><i class="fa-solid fa-print text-white me-2 ms-2"></i> <label style="color: #FFFFFF;font-size:16px" class="me-2 mt-2">{{$total24 }}</label></span>   --}}
                                        <span class="badge me-2" style="background-color: #ffffffbb"><i class="fa-solid fa-print me-2 ms-2" style="color: #fc2783"></i><label style="color: #fc2783;font-size:16px" class="me-2 mt-2">{{$total24 }} / {{$total60 }}</label></span>  
                                    </a> 
                                </td>
                                <td class="text-center" style="background-color: #fc2783" >
                                    <a href="{{url('air_plan_year_print/2/9/'.$bg_yearnow)}}" target="_blank">
                                        {{-- <span class="badge bg-success me-2"><i class="fa-solid fa-print text-white me-2 ms-2"></i> <label style="color: #FFFFFF;font-size:16px" class="me-2 mt-2">{{$total25 }}</label></span>  --}}
                                        <span class="badge me-2" style="background-color: #ffffffbb"><i class="fa-solid fa-print me-2 ms-2" style="color: #fc2783"></i><label style="color: #fc2783;font-size:16px" class="me-2 mt-2">{{$total25 }} / {{$total61 }}</label></span>   
                                    </a> 
                                </td> 
                            </tr> 
                            
                            <tr>
                                <td colspan="1" class="text-end" style="background-color: #04a79e;color:#FFFFFF;font-size:16px"> 
                                    บริษัทสหรัตน์แอร์
                                </td>  
                                <td class="text-center" style="background-color: #74faf3">
                                    {{-- <label for="" style="color: #FFFFFF;font-size:16px">{{$Total_saha }}</label>  --}}
                                    <a href="{{url('air_plan_year_print_sup/1/'.$bg_yearnow)}}" target="_blank">
                                        <span class="badge me-2" style="background-color: #ffffffbb"><i class="fa-solid fa-print text-success me-2 ms-2"></i> <label style="color: #04a79e;font-size:16px" class="me-2 mt-2">{{$Total_saha }}</label></span>  
                                    </a> 
                                </td>
                                <td class="text-center" style="background-color: #04a79e" >
                                    {{-- <label for="" style="color: #FFFFFF;font-size:16px"> {{$total2}} </label> --}}
                                    <a href="{{url('air_plan_year_print/1/10/'.$bg_yearnow)}}" target="_blank">
                                        <span class="badge me-2" style="background-color: #ffffffbb"><i class="fa-solid fa-print text-success me-2 ms-2"></i><label style="color: #04a79e;font-size:16px" class="me-2 mt-2">{{$total2 }} / {{$total38}}</label></span>  
                                    </a> 
                                </td>
                                <td class="text-center" style="background-color: #04a79e" >
                                    {{-- <label for="" style="color: #FFFFFF;font-size:16px"> {{$total3}} </label> --}}
                                    <a href="{{url('air_plan_year_print/1/11/'.$bg_yearnow)}}" target="_blank">
                                        <span class="badge me-2" style="background-color: #ffffffbb"><i class="fa-solid fa-print text-success me-2 ms-2"></i><label style="color: #04a79e;font-size:16px" class="me-2 mt-2">{{$total3 }} / {{$total39}}</label></span>  
                                    </a> 
                                </td>
                                <td class="text-center" style="background-color: #04a79e" >
                                    {{-- <label for="" style="color: #FFFFFF;font-size:16px"> {{$total4}} </label> --}}
                                    <a href="{{url('air_plan_year_print/1/12/'.$bg_yearnow)}}" target="_blank">
                                        <span class="badge me-2" style="background-color: #ffffffbb"><i class="fa-solid fa-print text-success me-2 ms-2"></i><label style="color: #04a79e;font-size:16px" class="me-2 mt-2">{{$total4 }} / {{$total40}}</label></span>  
                                    </a> 
                                </td>
                                <td class="text-center" style="background-color: #04a79e" >
                                    {{-- <label for="" style="color: #FFFFFF;font-size:16px"> {{$total5}} </label> --}}
                                    <a href="{{url('air_plan_year_print/1/1/'.$bg_yearnow)}}" target="_blank">
                                        <span class="badge me-2" style="background-color: #ffffffbb"><i class="fa-solid fa-print text-success me-2 ms-2"></i><label style="color: #04a79e;font-size:16px" class="me-2 mt-2">{{$total5 }} / {{$total41}}</label></span>  
                                    </a> 
                                </td>
                                <td class="text-center" style="background-color: #04a79e" >
                                    {{-- <label for="" style="color: #FFFFFF;font-size:16px"> {{$total6}} </label> --}}
                                    <a href="{{url('air_plan_year_print/1/2/'.$bg_yearnow)}}" target="_blank">
                                        <span class="badge me-2" style="background-color: #ffffffbb"><i class="fa-solid fa-print text-success me-2 ms-2"></i> <label style="color: #04a79e;font-size:16px" class="me-2 mt-2">{{$total6 }} / {{$total42}}</label></span>  
                                    </a> 
                                </td>
                                <td class="text-center" style="background-color: #04a79e" >
                                    {{-- <label for="" style="color: #FFFFFF;font-size:16px"> {{$total7}} </label> --}}
                                    <a href="{{url('air_plan_year_print/1/3/'.$bg_yearnow)}}" target="_blank">
                                        <span class="badge me-2" style="background-color: #ffffffbb"><i class="fa-solid fa-print text-success me-2 ms-2"></i> <label style="color: #04a79e;font-size:16px" class="me-2 mt-2">{{$total7 }} / {{$total43}}</label></span>  
                                    </a> 
                                </td>
                                <td class="text-center" style="background-color: #04a79e" >
                                    {{-- <label for="" style="color: #FFFFFF;font-size:16px"> {{$total8}} </label> --}}
                                    <a href="{{url('air_plan_year_print/1/4/'.$bg_yearnow)}}" target="_blank">
                                        <span class="badge me-2" style="background-color: #ffffffbb"><i class="fa-solid fa-print text-success me-2 ms-2"></i><label style="color: #04a79e;font-size:16px" class="me-2 mt-2">{{$total8 }} / {{$total44}}</label></span>  
                                    </a> 
                                </td>
                                <td class="text-center" style="background-color: #04a79e" >
                                    {{-- <label for="" style="color: #FFFFFF;font-size:16px"> {{$total9}} </label> --}}
                                    <a href="{{url('air_plan_year_print/1/5/'.$bg_yearnow)}}" target="_blank">
                                        <span class="badge me-2" style="background-color: #ffffffbb"><i class="fa-solid fa-print text-success me-2 ms-2"></i> <label style="color: #04a79e;font-size:16px" class="me-2 mt-2">{{$total9 }} / {{$total45}}</label></span>  
                                    </a> 
                                </td>
                                <td class="text-center" style="background-color: #04a79e" >
                                    {{-- <label for="" style="color: #FFFFFF;font-size:16px"> {{$total10}} </label> --}}
                                    <a href="{{url('air_plan_year_print/1/6/'.$bg_yearnow)}}" target="_blank">
                                        <span class="badge me-2" style="background-color: #ffffffbb"><i class="fa-solid fa-print text-success me-2 ms-2"></i> <label style="color: #04a79e;font-size:16px" class="me-2 mt-2">{{$total10 }} / {{$total46}}</label></span>  
                                    </a> 
                                </td>
                                <td class="text-center" style="background-color: #04a79e" >
                                    {{-- <label for="" style="color: #FFFFFF;font-size:16px"> {{$total11}} </label> --}}
                                    <a href="{{url('air_plan_year_print/1/7/'.$bg_yearnow)}}" target="_blank">
                                        <span class="badge me-2" style="background-color: #ffffffbb"><i class="fa-solid fa-print text-success me-2 ms-2"></i> <label style="color: #04a79e;font-size:16px" class="me-2 mt-2">{{$total11 }} / {{$total47}}</label></span>  
                                    </a> 
                                </td>
                                <td class="text-center" style="background-color: #04a79e" >
                                    {{-- <label for="" style="color: #FFFFFF;font-size:16px"> {{$total12}} </label> --}}
                                    <a href="{{url('air_plan_year_print/1/8/'.$bg_yearnow)}}" target="_blank">
                                        <span class="badge me-2" style="background-color: #ffffffbb"><i class="fa-solid fa-print text-success me-2 ms-2"></i><label style="color: #04a79e;font-size:16px" class="me-2 mt-2">{{$total12 }} / {{$total48}}</label></span>  
                                    </a> 
                                </td>
                                <td class="text-center" style="background-color: #04a79e" >
                                    {{-- <label for="" style="color: #FFFFFF;font-size:16px"> {{$total13}} </label> --}}
                                    <a href="{{url('air_plan_year_print/1/9/'.$bg_yearnow)}}" target="_blank">
                                        <span class="badge me-2" style="background-color: #ffffffbb"><i class="fa-solid fa-print text-success me-2 ms-2"></i> <label style="color: #04a79e;font-size:16px" class="me-2 mt-2">{{$total13 }} / {{$total49}}</label></span>  
                                    </a> 
                                </td> 
                            </tr> 

                        </table>
                    </div>
                </p>
            </div>
        </div>
    </div>
</div>

{{-- <div class="row">
    <div class="col-xl-1">
        <div class="card"> 
            <span class="badge bg-info me-2 p-2"> บริษัทสหรัตน์แอร์</span> 
        </div>
    </div>
    <div class="col-xl-1">
        <div class="card">
            <span class="badge p-2" style="background: #ba0890">บริษัทบีทีแอร์</span> 
        </div>
    </div>
    <div class="col"></div>
</div> --}}

</div>
</div>

@endsection
@section('footer')
    <script>
        $(document).ready(function() {
           
            // $('select').select2();
     
        
            $('#example2').DataTable();
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

            $('#datepicker3').datepicker({
                format: 'yyyy-mm-dd'
            });
            $('#datepicker4').datepicker({
                format: 'yyyy-mm-dd'
            });

        });
    </script>

@endsection
