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
                    <circle id="spinner" style="fill:transparent;stroke:#dd2476;stroke-width: 5px;stroke-linecap: round;filter:url(#shadow);" cx="50" cy="50" r="45"/>
                </svg>
            </div>
        </div>
    </div>
     
        <div class="row"> 
            <div class="col-md-4 mb-2">
                <h4 style="color:rgb(255, 255, 255)">รายการบำรุงรักษา-เครื่องปรับอากาศ</h4> 
            </div>
            <div class="col"></div>
        
           
        </div>
  

<div class="row">
    <div class="col-xl-12">
        <div class="card card_prs_4">
            <div class="card-body">    
                <div class="row mb-3">
                   
                    <div class="col"></div>
                    <div class="col-md-5 text-end">
                       
                    </div>
                </div>

                <p class="mb-0">
                    <div class="table-responsive">
                        {{-- <table id="example" class="table table-striped table-bordered dt-responsive nowrap myTable" style="border-collapse: collapse; border-spacing: 0; width: 100%;"> --}}
                        <table id="example" class="table table-hover table-sm dt-responsive nowrap myTable" style=" border-spacing: 0; width: 100%;">
                            <thead>
                                <tr style="font-size:13px">
                                  
                                    <th width="3%" class="text-center">ลำดับ</th>  
                                    <th class="text-center" width="7%">ปีงบประมาณ</th>  
                                    <th class="text-center" width="7%">วันที่ซ่อม</th>  
                                    <th class="text-center" width="5%">เวลา</th> 
                                    <th class="text-center" width="5%">รหัส</th>  
                                    <th class="text-center" >รายการ</th>  
                                    <th class="text-center" >สถานที่ตั้ง</th>  
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                @foreach ($datashow as $item) 
                                    <tr id="tr_{{$item->air_list_num}}">                                                  
                                        <td class="text-center" width="3%">{{ $i++ }}</td>  
                                        <td class="text-center" width="7%" style="font-size: 12px">{{ $item->repaire_time }}</td> 
                                        <td class="text-center" width="7%" style="font-size: 12px">{{ DateThai($item->repaire_date )}}</td>   
                                        <td class="text-center" width="5%" style="font-size: 12px">{{ $item->repaire_time }}</td>  
                                        <td class="p-2">
                                            @if ($item->repaire_date =='')
                                                <span class="badge" style="background: #fa134d"> {{ $item->air_list_num }}</span>
                                            @else
                                                <span class="badge" style="background: #03b9b9"> {{ $item->air_list_num }}</span>
                                            @endif
                                            
                                        </td>   
                                        <td class="p-2">{{ $item->air_list_name }}</td>  
                                        <td class="p-2" width="20%">{{ $item->air_location_name }} ห้อง {{ $item->detail }}</td>   

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
            $('#example').DataTable();
            $('#example2').DataTable();
            $('#p4p_work_month').select2({
                placeholder: "--เลือก--",
                allowClear: true
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
