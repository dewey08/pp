@extends('layouts.support_prs_fireback')
@section('title', 'PK-OFFICE || Fire-Service')

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
    {{-- <div class="row text-center">
        <div id="overlay">
            <div class="cv-spinner">
                <span class="spinner"></span>
            </div>
        </div> 
    </div> 
    <div id="preloader">
        <div id="status">
            <div class="spinner"> 
            </div>
        </div>
    </div> --}}
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
    <form action="{{ url('fire_report_ploblems') }}" method="GET">
        @csrf
        <div class="row"> 
            <div class="col-md-6">
                <h4 style="color:rgb(255, 255, 255)">รายงานผลการแก้ไขปัญหาถังดับเพลิงชำรุด โรงพยาบาลภูเขียวเฉลิมพระเกียรติ</h4>
                {{-- <p class="card-title-desc">รายงานถังดับเพลิง</p> --}}
            </div>
             
            <div class="col"></div>
            {{-- <div class="col-md-2 text-end">  --}}
                {{-- <a href="{{url('air_report_building_excel')}}" class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-success">
                    <i class="fa-solid fa-file-excel me-2"></i>
                    Export To Excel
                </a> --}}
                <div class="col-md-5 text-end"> 
                    <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker1'>
                        <input type="text" class="form-control bt_prs" name="startdate" id="datepicker" placeholder="Start Date" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                            data-date-language="th-th" value="{{ $startdate }}" required/>
                        <input type="text" class="form-control bt_prs" name="enddate" placeholder="End Date" id="datepicker2" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                            data-date-language="th-th" value="{{ $enddate }}"/>  
                            <button type="submit" class="ladda-button btn-pill btn btn-info bt_prs" data-style="expand-left">
                                <span class="ladda-label"> <i class="fa-solid fa-magnifying-glass text-white me-2"></i>ค้นหา</span> 
                            </button> 
                            <a href="{{url('fire_report_ploblems_excel')}}" class="ladda-button btn-pill btn btn-success bt_prs">
                                <span class="ladda-label"> <i class="fa-solid fa-file-excel text-white me-2"></i>Export</span>  
                            </a>
                    </div> 
                </div>
               
            
            {{-- </div> --}}
        </div>  
    </form>
 
<div class="row mt-3">
    <div class="col-xl-12">
        <div class="card card_prs_4">
            <div class="card-body">    
                

                <p class="mb-0">
                    <div class="table-responsive">
                        <table id="example" class="table table-hover table-sm dt-responsive nowrap myTable" style=" border-spacing: 0; width: 100%;">
                        {{-- <table id="example" class="table table-striped table-bordered dt-responsive" style="border-collapse: collapse; border-spacing: 0; width: 100%;">                         --}}
                            <thead>                             
                                  
                                    <tr style="font-size:14px">  
                                        <th class="text-center">ลำดับ</th> 
                                        <th class="text-center">วันที่ตรวจ</th> 
                                        <th class="text-center">รหัส</th> 
                                        <th class="text-center">รายการ/ชื่อ</th>   
                                        <th class="text-center">ที่ตั้ง/อาคาร</th> 
                                        <th class="text-center">รายการที่เปลี่ยน</th>  
                                        <th class="text-center">การแก้ไข</th>
                                        <th class="text-center">วันที่แก้ไข</th>
                                    </tr> 
                            </thead>
                            <tbody>
                                <?php $i = 0; ?>
                                @foreach ($datashow as $item) 
                                <?php $i++ ?>                               
                                    <tr>                                                  
                                        <td class="text-center" style="font-size:13px;;color: rgb(13, 134, 185)" width="4%">{{$i}}</td>
                                        <td class="text-center" style="font-size:13px;color: rgb(2, 95, 182)" width="8%">{{DateThai($item->check_date)}}</td>
                                        <td class="text-center" style="font-size:13px;color: rgb(4, 117, 117)" width="10%">{{$item->fire_num}}</td> 
                                        <td class="text-start" style="font-size:13px;color: rgb(50, 3, 68)" width="10%">{{$item->fire_name}}</td>
                                        <td class="text-start" style="font-size:13px;color: rgb(50, 3, 68)">{{$item->fire_location}}</td>
                                        <td class="text-center" style="font-size:13px;color: rgb(50, 3, 68)" width="10%">{{$item->fire_chang_new}}</td>
                                        <td class="text-start" style="font-size:13px;color: rgb(50, 3, 68)" width="10%">{{$item->fire_chang_comment}}</td> 
                                        <td class="text-center" style="font-size:13px;color: rgb(2, 95, 182)" width="10%">{{DateThai($item->fire_chang_date)}}</td>
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
