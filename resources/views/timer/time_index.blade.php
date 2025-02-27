@extends('layouts.timesystem')
@section('title', 'PK-OFFICE || Time-Index')
@section('content')
<style>
    #button{
           display:block;
           margin:20px auto;
           padding:30px 30px;
           background-color:#eee;
           border:solid #ccc 1px;
           cursor: pointer;
           }
           #overlay{
           position: fixed;
           top: 0;
           z-index: 100;
           width: 100%;
           height:100%;
           display: none;
           background: rgba(0,0,0,0.6);
           }
           .cv-spinner {
           height: 100%;
           display: flex;
           justify-content: center;
           align-items: center;
           }
           .spinner {
           width: 250px;
           height: 250px;
           border: 10px #ddd solid;
           border-top: 10px #1fdab1 solid;
           border-radius: 50%;
           animation: sp-anime 0.8s infinite linear;
           }
           @keyframes sp-anime {
           100% {
               transform: rotate(390deg);
           }
           }
           .is-hide{
           display:none;
           }
</style>
<script>
    function TypeAdmin() {
        window.location.href = '{{ route('index') }}';
    }
</script>
<?php
if (Auth::check()) {
        $type = Auth::user()->type;
        $iduser = Auth::user()->id;
        $iddep =  Auth::user()->dep_subsubtrueid;
    } else {
        echo "<body onload=\"TypeAdmin()\"></body>";
        exit();
    }
    $url = Request::url();
    $pos = strrpos($url, '/') + 1;

    $datenow = date("Y-m-d");
    $y = date('Y') + 543;
    $newweek = date('Y-m-d', strtotime($datenow . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
    $newDate = date('Y-m-d', strtotime($datenow . ' -1 months')); //ย้อนหลัง 1 เดือน
?>

<div class="tabs-animation">

        {{-- <div class="row text-center">
            <div id="overlay">
                <div class="cv-spinner">
                  <span class="spinner"></span>
                </div>
              </div>
        </div>  --}}
        <div id="preloader">
            <div id="status">
                <div class="spinner">

                </div>
            </div>
        </div>

        <div class="card input_time" style="background-color: rgb(236, 247, 248)">
            <div class="card-body">

                <h4 class="card-title" style="color: #fd1b72">ลงเวลาเข้า-ออก</h4>
                <p class="card-title-desc">รายละเอียดลงเวลาเข้า-ออก แยกตามกลุ่มภารกิจ || กลุ่มงาน/ฝ่าย || หน่วยงาน</p>

                <!-- Nav tabs -->
                <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#department" role="tab">
                            <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                            <span class="d-none d-sm-block">หน่วยงาน</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#departmentsub" role="tab">
                            <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                            <span class="d-none d-sm-block">กลุ่มงาน/ฝ่าย</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#departmentsubsub" role="tab">
                            <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                            <span class="d-none d-sm-block">กลุ่มภารกิจ</span>
                        </a>
                    </li>

                </ul>

                <!-- Tab panes -->
                <div class="tab-content p-3 text-muted">
                    <div class="tab-pane active" id="department" role="tabpanel">
                        <p class="mb-0">
                            <form action="{{ route('t.time_index') }}" method="POST">
                                @csrf
                                    <div class="row mb-2">
                                        <div class="col"></div>
                                        <div class="col-md-1 text-center">หน่วยงาน</div>
                                        <div class="col-md-3 text-center">
                                            <div class="input-group">
                                                    <select name="department_subsub_id" id="department_subsub_id" class="form-control" style="width: 100%">
                                                        <option value="">--เลือก--</option>
                                                            @foreach ($department_subsub as $items2)
                                                            @if ($debsubsub == $items2->HR_DEPARTMENT_SUB_SUB_ID)
                                                                <option value="{{ $items2->HR_DEPARTMENT_SUB_SUB_ID }}" selected> {{ $items2->HR_DEPARTMENT_SUB_SUB_NAME }} </option>
                                                            @else
                                                                <option value="{{ $items2->HR_DEPARTMENT_SUB_SUB_ID }}"> {{ $items2->HR_DEPARTMENT_SUB_SUB_NAME }} </option>
                                                            @endif
                                                            @endforeach
                                                    </select>
                                            </div>
                                        </div>
                                        <div class="col-md-5 text-end">
                                            <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker6'>
                                                <input type="text" class="form-control-sm input_time" name="startdate" id="datepicker" placeholder="Start Date" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                                                        data-date-language="th-th" value="{{ $startdate }}" required/>
                                                <input type="text" class="form-control-sm input_time" name="enddate" placeholder="End Date" id="datepicker2" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                                                    data-date-language="th-th" value="{{ $enddate }}"/>
                                                <button type="submit" class="ladda-button btn-pill btn btn-sm btn-info input_time" data-style="expand-left">
                                                        <span class="ladda-label">
                                                            <img src="{{ asset('images/Search02.png') }}" class="me-2 ms-2" height="18px" width="18px">
                                                            ค้นหา</span>
                                                </button>
                                                <a href="{{url('time_depsubsub_excel_new')}}" class="ladda-button me-2 btn-pill btn btn-success btn-sm input_time">
                                                    <img src="{{ asset('images/export_whitenew.png') }}" class="me-2 ms-2" height="18px" width="18px">
                                                    Export
                                                </a>
                                            </div>
                                        </div>

                                    </div>
                            </form>
                            <hr style="color: #fd1b72">
                            <table class="align-middle mb-0 table table-sm table-borderless table-striped" id="example" style="background-color: #ffffff">
                                <thead>
                                    <tr style="font-size: 13px;">
                                        <th class="text-center">ลำดับ</th>
                                        <th class="text-center">วันที่</th>
                                        <th class="text-center">ชื่อ-นามสกุล</th>
                                        <th class="text-center">หน่วยงาน</th>
                                        <th class="text-center">เวลาเข้า</th>
                                        <th class="text-center">เวลาออก</th>
                                        <th class="text-center">ประเภท</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $ia = 1; ?>
                                    @foreach ($show_subsub as $item)

                                        <tr style="font-size: 12px;">
                                            <td class="text-center" width="5%">{{ $ia++ }}</td>
                                            <td>{{ Datethai($item->CHEACKIN_DATE )}}</td>
                                            <td class="p-2">{{ $item->hrname }}</td>
                                            <td class="p-2">{{ $item->HR_DEPARTMENT_SUB_SUB_NAME }}</td>
                                            <td class="text-center" width="10%">{{ $item->CHEACKINTIME }}</td>
                                            <td class="text-center" width="10%">{{ $item->CHEACKOUTTIME }}</td>
                                            <td width="10%">{{ $item->OPERATE_TYPE_NAME }}</td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </p>
                    </div>
                    <div class="tab-pane" id="departmentsub" role="tabpanel">
                        <p class="mb-0">
                            Food truck fixie locavore, accusamus mcsweeney's marfa nulla
                            single-origin coffee squid. Exercitation +1 labore velit, blog
                            sartorial PBR leggings next level wes anderson artisan four loko
                            farm-to-table craft beer twee. Qui photo booth letterpress,
                            commodo enim craft beer mlkshk aliquip jean shorts ullamco ad
                            vinyl cillum PBR. Homo nostrud organic, assumenda labore
                            aesthetic magna delectus.
                        </p>
                    </div>
                    <div class="tab-pane" id="departmentsubsub" role="tabpanel">
                        <p class="mb-0">
                            <form action="{{ route('t.time_index') }}" method="POST">
                                @csrf
                                    <div class="row mb-2">
                                        <div class="col"></div>
                                        <div class="col-md-1 text-center">กลุ่มภารกิจ</div>
                                        <div class="col-md-3 text-center">
                                            <div class="input-group">
                                                    <select name="department_id" id="department_id" class="form-control" style="width: 100%">
                                                        <option value="">--เลือก--</option>
                                                            @foreach ($department as $items3)
                                                            @if ($debid == $items3->HR_DEPARTMENT_ID)
                                                                <option value="{{ $items3->HR_DEPARTMENT_ID }}" selected> {{ $items3->HR_DEPARTMENT_NAME }} </option>
                                                            @else
                                                                <option value="{{ $items3->HR_DEPARTMENT_ID }}"> {{ $items3->HR_DEPARTMENT_NAME }} </option>
                                                            @endif
                                                            @endforeach
                                                    </select>
                                            </div>
                                        </div>
                                        <div class="col-md-5 text-end">
                                            <div class="input-daterange input-group" id="datepicker7" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker7'>
                                                <input type="text" class="form-control-sm input_time" name="startdate" id="datepicker4" placeholder="Start Date" data-date-container='#datepicker7' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                                                        data-date-language="th-th" value="{{ $startdate }}" required/>
                                                <input type="text" class="form-control-sm input_time" name="enddate" placeholder="End Date" id="datepicker5" data-date-container='#datepicker7' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                                                    data-date-language="th-th" value="{{ $enddate }}"/>
                                                <button type="submit" class="ladda-button btn-pill btn btn-sm btn-info input_time" data-style="expand-left">
                                                        <span class="ladda-label">
                                                            <img src="{{ asset('images/Search02.png') }}" class="me-2 ms-2" height="18px" width="18px">
                                                            ค้นหา</span>
                                                </button>
                                                <a href="{{url('time_dep_excel_new')}}" class="ladda-button me-2 btn-pill btn btn-success btn-sm input_time">
                                                    <img src="{{ asset('images/export_whitenew.png') }}" class="me-2 ms-2" height="18px" width="18px">
                                                    Export
                                                </a>
                                            </div>
                                        </div>

                                    </div>
                            </form>
                            <hr style="color: #fd1b72">
                            <table class="align-middle mb-0 table table-sm table-borderless table-striped" id="example2" style="background-color: #ffffff">
                                <thead>
                                    <tr style="font-size: 13px;">
                                        <th class="text-center">ลำดับ</th>
                                        <th class="text-center">วันที่</th>
                                        <th class="text-center">ชื่อ-นามสกุล</th>
                                        <th class="text-center">หน่วยงาน</th>
                                        <th class="text-center">เวลาเข้า</th>
                                        <th class="text-center">เวลาออก</th>
                                        <th class="text-center">ประเภท</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $ia = 1; ?>
                                    @foreach ($show_dep as $item3)

                                        <tr style="font-size: 12px;">
                                            <td class="text-center" width="5%">{{ $ia++ }}</td>
                                            <td>{{ Datethai($item3->CHEACKIN_DATE )}}</td>
                                            <td class="p-2">{{ $item3->hrname }}</td>
                                            <td class="p-2">{{ $item3->HR_DEPARTMENT_SUB_SUB_NAME }}</td>
                                            <td class="text-center" width="10%">{{ $item3->CHEACKINTIME }}</td>
                                            <td class="text-center" width="10%">{{ $item3->CHEACKOUTTIME }}</td>
                                            <td width="10%">{{ $item3->OPERATE_TYPE_NAME }}</td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </p>
                    </div>

                </div>

            </div>
        </div>

        {{-- <div class="main-card mb-3 card">
            <div class="card-header">
                ลงเวลาเข้า-ออก
                <div class="btn-actions-pane-right">
                    <div class="nav">
                        <a data-bs-toggle="tab" href="{{ url('time_dep') }}" class="btn-pill btn-wide active btn btn-outline-alternate btn-sm">กลุ่มภารกิจ</a>
                        <a href="{{ url('time_depsub') }}" class="btn-pill btn-wide me-1 ms-1  btn btn-outline-alternate btn-sm">กลุ่มงาน/ฝ่าย</a>
                        <a href="{{ url('time_depsubsub') }}" class="btn-pill btn-wide  btn btn-outline-alternate btn-sm">หน่วยงาน</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane active" id="tab-eg2-0" role="tabpanel">
                        <p>
                            <form action="{{ route('t.time_dep') }}" method="POST">
                                @csrf
                                    <div class="row">
                                        <div class="col-md-2 text-end">วันที่</div>
                                        <div class="col-md-4 text-center">
                                            <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy"
                                                data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker6'>
                                                <input type="text" class="form-control" name="startdate" id="datepicker" placeholder="Start Date"
                                                    data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true"
                                                    data-date-language="th-th" value="{{ $startdate }}" required/>
                                                <input type="text" class="form-control" name="enddate" placeholder="End Date" id="datepicker2"
                                                    data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true"
                                                    data-date-language="th-th" value="{{ $enddate }}" required/>
                                            </div>
                                        </div>
                                        <div class="col-md-1 text-center">กลุ่มภารกิจ</div>
                                            <div class="col-md-2 text-center">
                                                <div class="input-group">

                                                        <select name="department_id" id="department_id" class="form-control form-control-sm" style="width: 100%">
                                                        @foreach ($department as $items0)
                                                        @if ($deb == $items0->HR_DEPARTMENT_ID)
                                                            <option value="{{ $items0->HR_DEPARTMENT_ID }}" selected> {{ $items0->HR_DEPARTMENT_NAME }} </option>
                                                        @else
                                                            <option value="{{ $items0->HR_DEPARTMENT_ID }}"> {{ $items0->HR_DEPARTMENT_NAME }} </option>
                                                        @endif
                                                        @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2 me-2">
                                            <button type="submit" class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info">
                                                <i class="pe-7s-search btn-icon-wrapper"></i>ค้นหา
                                            </button>

                                            <a href="{{url('time_dep_excel/'.$deb.'/'.$startdate.'/'.$enddate)}}" class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-success">
                                                <i class="fa-solid fa-file-excel me-2"></i>
                                                Export
                                            </a>

                                        </div>

                                    </div>
                            </form>
                            <div class="table-responsive mt-3">
                                <table class="align-middle mb-0 table table-borderless table-striped table-hover" id="example2">
                                    <thead>
                                        <tr>
                                            <th>ลำดับ</th>
                                            <th>วันที่</th>
                                            <th>ชื่อ-นามสกุล</th>
                                            <th>หน่วยงาน</th>
                                            <th>เวลาเข้า</th>
                                            <th>เวลาออก</th>
                                            <th>ประเภท</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $ia = 1; ?>
                                        @foreach ($datashow_ as $item)

                                            <tr>
                                                <td>{{ $ia++ }}</td>
                                                <td>{{ Datethai($item->CHEACKIN_DATE )}}</td>
                                                <td class="p-2">{{ $item->hrname }}</td>
                                                <td class="p-2">{{ $item->HR_DEPARTMENT_SUB_SUB_NAME }}</td>
                                                <td>{{ $item->CHEACKINTIME }}</td>
                                                <td>{{ $item->CHEACKOUTTIME }}</td>
                                                <td>{{ $item->OPERATE_TYPE_NAME }}</td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </p>
                    </div>

                </div>
            </div>

        </div> --}}
</div>



@endsection
@section('footer')

<script>

    $(document).ready(function() {
        // $("#overlay").fadeIn(300);

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
        $('#datepicker5').datepicker({
            format: 'yyyy-mm-dd'
        });
        $('#datepicker6').datepicker({
            format: 'yyyy-mm-dd'
        });

        $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
        });
        $('#department_id').select2({
                placeholder: "--เลือก--",
                allowClear: true
            });
        $('#HR_DEPARTMENT_SUB_ID').select2({
                placeholder: "--เลือก--",
                allowClear: true
            });
        $('#department_subsub_id').select2({
            placeholder: "--เลือก--",
            allowClear: true
        });
        // $('select').select2({
        //     placeholder: 'This is my placeholder',
        //     allowClear: true
        // });

        $("#spinner-div").hide(); //Request is complete so hide spinner

        $('#Savetime').click(function() {
            var startdate = $('#datepicker').val();
            var enddate = $('#datepicker2').val();
            var HR_DEPARTMENT_SUB_ID = $('#HR_DEPARTMENT_SUB_ID').val();
            var HR_DEPARTMENT_SUB_SUB_ID = $('#HR_DEPARTMENT_SUB_SUB_ID').val();
            $.ajax({
                url: "{{ route('t.time_index_excel') }}",
                type: "POST",
                dataType: 'json',
                data: {
                    startdate,
                    enddate,
                    HR_DEPARTMENT_SUB_ID,
                    HR_DEPARTMENT_SUB_SUB_ID
                },
                success: function(data) {
                    if (data.status == 200) {
                        Swal.fire({
                            title: 'บันทึกข้อมูลสำเร็จ',
                            text: "You Insert data success",
                            icon: 'success',
                            showCancelButton: false,
                            confirmButtonColor: '#06D177',
                            confirmButtonText: 'เรียบร้อย'
                        }).then((result) => {
                            if (result
                                .isConfirmed) {
                                console.log(
                                    data);

                                window.location
                                    .reload();
                            }
                        })
                    } else {

                    }

                },
            });
        });
    });
</script>
<script>
    $('.department').change(function () {
            if ($(this).val() != '') {
                    var select = $(this).val();
                    var _token = $('input[name="_token"]').val();
                    $.ajax({
                            url: "{{route('person.department')}}",
                            method: "GET",
                            data: {
                                    select: select,
                                    _token: _token
                            },
                            success: function (result) {
                                    $('.department_sub').html(result);
                            }
                    })
                    // console.log(select);
            }
    });

    $('.department_sub').change(function () {
            if ($(this).val() != '') {
                    var select = $(this).val();
                    var _token = $('input[name="_token"]').val();
                    $.ajax({
                            url: "{{route('person.departmenthsub')}}",
                            method: "GET",
                            data: {
                                    select: select,
                                    _token: _token
                            },
                            success: function (result) {
                                    $('.department_sub_sub').html(result);
                            }
                    })
                    // console.log(select);
            }
    });
</script>
@endsection

