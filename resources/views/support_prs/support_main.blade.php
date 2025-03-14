{{-- @extends('layouts.support_prs_new') --}}
@extends('layouts.support_prs_db')
@section('title', 'PK-OFFICE || Support-System')
<link href="{{ asset('acccph/styles/css/base.css') }}" rel="stylesheet">
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
                        <circle id="spinner" style="fill:transparent;stroke:#dd2476;stroke-width: 7px;stroke-linecap: round;filter:url(#shadow);" cx="50" cy="50" r="45"/>
                    </svg>
                </div>
            </div>
        </div>
       
        <!-- start page title -->
        {{-- <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h2 class="mb-sm-0">ตรวจสอบและบำรุงรักษา ระบบสนับสนุนบริการสุขภาพ</h2>                    
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                            <li class="breadcrumb-item active">ระบบสนับสนุนบริการสุขภาพ</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div> --}}

        {{-- <span class="mb-sm-0 pe-2">
            <i class="lnr-apartment opacity-6" style="color:rgb(250, 237, 237)"></i>
        </span> 
        <span class="mb-sm-0">ตรวจสอบและบำรุงรักษา ระบบสนับสนุนบริการสุขภาพ</span> --}}
        <!-- end page title -->
        {{-- <h2 class="mb-sm-0">ตรวจสอบและบำรุงรักษา ระบบสนับสนุนบริการสุขภาพ</h2> --}}
        {{-- <span class="mb-sm-0 pe-2">
            <i class="lnr-apartment opacity-6" style="color:rgb(255, 255, 255)"></i>
        </span> --}}
        <div class="row"> 
            <div class="col-xl-3 col-md-6">
                <a href="{{url('air_dashboard')}}" target="_blank">
                    <div class="card widget-chart widget-chart-hover" style="height: 200px">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <p class="text-start font-size-14 mb-2 ">เครื่องปรับอากาศ</p>
                                    <h2 class="text-start mb-2">{{$count_air}}</h2>   
                                </div>
                                <div class="avatar-sm" style="width: 100px;height:100px">
                                    <span class="avatar-title bg-light text-primary rounded-3"> 
                                        <img src="{{ asset('images/air_conditioner_g.png') }}" height="80px" width="80px" class="text-danger"> 
                                    </span>
                                </div>
                            </div>  
                            <div class="d-flex align-content-center flex-wrap mt-4">
                                <p class="text-muted mb-0">
                                    <span class="text-success fw-bold font-size-20 me-2">
                                        <i class="ri-arrow-right-up-line me-1 align-middle"></i>0.00 %
                                    </span>from previous 
                                </p>
                            </div>                                           
                        </div> 

                     
                    </div> 
                </a>
            </div> 
            
            <div class="col-xl-3 col-md-6">
                <a href="{{url('support_system_dashboard')}}" target="_blank">
                    <div class="card widget-chart widget-chart-hover" style="height: 200px">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <p class="text-start font-size-14 mb-2">ถังดับเพลิง</p>
                                    <h2 class="text-start mb-2">{{$fire}}</h2> 
                                </div>
                                <div class="avatar-sm" style="width: 100px;height:100px">
                                    <span class="avatar-title bg-light text-success rounded-3">
                                        <img src="{{ asset('images/fire-extinguisher.png') }}" height="80px" width="80px" class="text-danger"> 
                                    </span>
                                </div>
                            </div>   
                            <div class="d-flex align-content-center flex-wrap mt-4">
                                <p class="text-muted mb-0">
                                    <span class="text-danger fw-bold font-size-20 me-2">
                                        <i class="ri-arrow-right-down-line me-1 align-middle"></i>0.00 %
                                    </span>from previous 
                                </p>
                            </div>                                              
                        </div> 
                    </div> 
                </a>
            </div> 
            <div class="col-xl-3 col-md-6">
                <a href="{{url('cctv_dashboard')}}" target="_blank">
                    <div class="card widget-chart widget-chart-hover" style="height: 200px">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <p class="text-start font-size-14 mb-2">กล้อง CCTV</p>
                                    <h2 class="text-start mb-2">{{$cctv_list}}</h2> 
                                </div>
                                <div class="avatar-sm" style="width: 100px;height:100px">
                                    <span class="avatar-title bg-light text-primary rounded-3">
                                        <img src="{{ asset('images/cctv_p.png') }}" height="80px" width="80px" class="text-danger"> 
                                    </span>
                                </div>
                            </div>  
                            <div class="d-flex align-content-center flex-wrap mt-4">
                                <p class="text-muted mb-0">
                                    <span class="text-warning fw-bold font-size-20 me-2">
                                        <i class="ri-arrow-right-down-line me-1 align-middle"></i>0.00 %
                                    </span>from previous 
                                </p>
                            </div>                                                
                        </div> 
                    </div> 
                </a>
            </div> 

            <div class="col-xl-3 col-md-6">
                <div class="card widget-chart widget-chart-hover" style="height: 200px">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <p class="text-start font-size-14 mb-2">น้ำใช้สำรอง</p>
                                <h2 class="text-start mb-2">0</h2> 
                            </div> 
                            <div class="avatar-sm" style="width: 100px;height:100px">
                                <span class="avatar-title bg-light text-success rounded-3">
                                    <img src="{{ asset('images/water_pump.png') }}" height="80px" width="80px" class="text-danger"> 
                                </span>
                            </div>
                        </div>  
                        <div class="d-flex align-content-center flex-wrap mt-4">
                            <p class="text-muted mb-0">
                                <span class="text-info fw-bold font-size-20 me-2">
                                    <i class="ri-arrow-right-up-line me-1 align-middle"></i>0.00 %
                                </span>from previous 
                            </p>
                        </div> 
                    </div> 
                </div> 
            </div> 
        </div> 

        <div class="row"> 
            <div class="col-xl-3 col-md-6">
                <a href="{{url('drinking_water_db')}}" target="_blank">
                <div class="card widget-chart widget-chart-hover" style="height: 200px">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <p class="text-start font-size-14 mb-2">น้ำบริโภค</p>
                                <h2 class="text-start mb-2">{{$water_filter}}</h2> 
                            </div> 
                            <div class="avatar-sm" style="width: 100px;height:100px">
                                <span class="avatar-title bg-light text-success rounded-3">
                                    <img src="{{ asset('images/water_glass.png') }}" height="80px" width="80px" class="text-danger"> 
                                </span>
                            </div>
                        </div>  
                        <div class="d-flex align-content-center flex-wrap mt-4">
                            <p class="text-muted mb-0">
                                <span class="text-info fw-bold font-size-20 me-2">
                                    <i class="ri-arrow-right-down-line me-1 align-middle"></i>0.00 %
                                </span>from previous 
                            </p>
                        </div>  
                    </div> 
                </div> 
                </a>
            </div> 
            <div class="col-xl-3 col-md-6">
                <div class="card widget-chart widget-chart-hover" style="height: 200px">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <p class="text-start font-size-14 mb-2">เครื่องกำเนิดไฟฟ้า</p>
                                <h2 class="text-start mb-2">0</h2> 
                            </div> 
                            <div class="avatar-sm" style="width: 100px;height:100px">
                                <span class="avatar-title bg-light text-success rounded-3">
                                    <img src="{{ asset('images/power_generator.png') }}" height="80px" width="80px" class="text-danger"> 
                                </span>
                            </div>
                        </div>  
                        <div class="d-flex align-content-center flex-wrap mt-4">
                            <p class="text-muted mb-0">
                                <span class="text-info fw-bold font-size-20 me-2">
                                    <i class="ri-arrow-right-up-line me-1 align-middle"></i>0.00 %
                                </span>from previous 
                            </p>
                        </div> 
                    </div> 
                </div> 
            </div> 
            <div class="col-xl-3 col-md-6">
                <div class="card widget-chart widget-chart-hover" style="height: 200px">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <p class="text-start font-size-14 mb-2">หม้อแปลงไฟฟ้า</p>
                                <h2 class="text-start mb-2">0</h2> 
                            </div> 
                            <div class="avatar-sm" style="width: 100px;height:100px">
                                <span class="avatar-title bg-light text-success rounded-3">
                                    <img src="{{ asset('images/generator_portable.png') }}" height="80px" width="80px" class="text-danger"> 
                                </span>
                            </div>
                        </div>  
                        <div class="d-flex align-content-center flex-wrap mt-4">
                            <p class="text-muted mb-0">
                                <span class="text-info fw-bold font-size-20 me-2">
                                    <i class="ri-arrow-right-up-line me-1 align-middle"></i>0.00 %
                                </span>from previous 
                            </p>
                        </div> 
                    </div> 
                </div> 
            </div> 
            <div class="col-xl-3 col-md-6">
                <div class="card widget-chart widget-chart-hover" style="height: 200px">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <p class="text-start font-size-14 mb-2">ลิฟต์โดยสาร</p>
                                <h2 class="text-start mb-2">0</h2> 
                            </div> 
                            <div class="avatar-sm" style="width: 100px;height:100px">
                                <span class="avatar-title bg-light text-success rounded-3">
                                    <img src="{{ asset('images/elevator.png') }}" height="80px" width="80px" class="text-danger"> 
                                </span>
                            </div>
                        </div>  
                        <div class="d-flex align-content-center flex-wrap mt-4">
                            <p class="text-muted mb-0">
                                <span class="text-info fw-bold font-size-20 me-2">
                                    <i class="ri-arrow-right-up-line me-1 align-middle"></i>0.00 %
                                </span>from previous 
                            </p>
                        </div> 
                    </div> 
                </div> 
            </div> 
        </div> 
        <div class="row"> 
            <div class="col-xl-3 col-md-6">
                <div class="card widget-chart widget-chart-hover" style="height: 200px">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <p class="text-start font-size-14 mb-2">ห้องน้ำ/ห้องส้วม</p>
                                <h2 class="text-start mb-2">0</h2> 
                            </div> 
                            <div class="avatar-sm" style="width: 100px;height:100px">
                                <span class="avatar-title bg-light text-success rounded-3">
                                    <img src="{{ asset('images/toilet.png') }}" height="80px" width="80px" class="text-danger"> 
                                </span>
                            </div>
                        </div>  
                        <div class="d-flex align-content-center flex-wrap mt-4">
                            <p class="text-muted mb-0">
                                <span class="text-info fw-bold font-size-20 me-2">
                                    <i class="ri-arrow-right-up-line me-1 align-middle"></i>0.00 %
                                </span>from previous 
                            </p>
                        </div> 
                    </div> 
                </div> 
            </div> 
            <div class="col-xl-3 col-md-6">
                <a href="{{url('medicalgas_db')}}" target="_blank">
                    <div class="card widget-chart widget-chart-hover" style="height: 200px">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <p class="text-start font-size-14 mb-2">ก๊าซทางการแพทย์ (O2+Ni)</p>
                                    <h2 class="text-start mb-2">{{$gas_list}}</h2> 
                                </div> 
                                <div class="avatar-sm" style="width: 100px;height:100px">
                                    <span class="avatar-title bg-light text-success rounded-3">
                                        <img src="{{ asset('images/gas_circle.png') }}" height="80px" width="80px" class="text-danger"> 
                                    </span>
                                </div>
                            </div>  
                            <div class="d-flex align-content-center flex-wrap mt-4">
                                <p class="text-muted mb-0">
                                    <span class="text-info fw-bold font-size-20 me-2">
                                        <i class="ri-arrow-right-up-line me-1 align-middle"></i>0.00 %
                                    </span>from previous 
                                </p>
                            </div> 
                        </div> 
                    </div> 
                </a>
            </div> 
            <div class="col-xl-3 col-md-6">
                <a href="{{url('report_prs')}}" target="_blank">
                    <div class="card widget-chart widget-chart-hover" style="height: 200px">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <p class="text-start font-size-14 mb-2">REPORT ALL</p>
                                    <h2 class="text-start mb-2"> </h2> 
                                </div> 
                                <div class="avatar-sm" style="width: 100px;height:100px">
                                    <span class="avatar-title bg-light text-success rounded-3">
                                        <img src="{{ asset('images/db_new5.png') }}" height="80px" width="80px" class="text-danger"> 
                                    </span>
                                </div>
                            </div>  
                            <div class="d-flex align-content-center flex-wrap mt-4">
                                <p class="text-muted mb-0">
                                    <span class="text-info fw-bold font-size-20 me-2">
                                        {{-- <i class="ri-arrow-right-up-line me-1 align-middle"></i>0.00 % --}}
                                        <i class="fa-solid fa-chart-line"></i>
                                    </span>from previous 
                                </p>
                            </div> 
                        </div> 
                    </div> 
                </a>
            </div> 
        </div> 
        
 
    </div> 
@endsection
@section('footer')
  

@endsection

