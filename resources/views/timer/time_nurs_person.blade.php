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

        <div class="row text-center">
            <div id="overlay">
                <div class="cv-spinner">
                  <span class="spinner"></span>
                </div>
              </div>
        </div>

        <div class="card input_time" style="background-color: rgb(236, 247, 248)">
            <div class="card-header">
                ลงเวลาเข้า-ออก หน่วยงาน
                <div class="btn-actions-pane-right">
                    <div class="nav">
                        <a href="{{ url('time_nurs_dep') }}" class="btn btn-outline-info btn-sm input_time">กลุ่มภารกิจ</a>
                        <a href="{{ url('time_nurs_depsub') }}" class="btn-pill me-2 ms-2 btn btn-outline-info btn-sm input_time">กลุ่มงาน/ฝ่าย</a>
                        <a href="{{ url('time_nurs_depsubsub') }}" class="btn-pill btn me-2 btn-outline-primary btn-sm input_time">หน่วยงาน</a>
                        <a data-bs-toggle="tab" href="{{ url('time_nurs_person') }}" class="btn-pill btn btn-outline-info btn-sm active input_time">บุคคล</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane active" id="tab-eg2-0" role="tabpanel">

                            <form action="{{ route('t.time_nurs_person') }}" method="POST">
                                @csrf
                                    <div class="row">
                                        <div class="col"></div>
                                        <div class="col-md-1 text-end">วันที่</div>
                                        <div class="col-md-3 text-center">
                                            <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy"
                                                data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker6'>
                                                <input type="text" class="form-control-sm input_time" name="startdate" id="datepicker" placeholder="Start Date"
                                                    data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                                                    data-date-language="th-th" value="{{ $startdate }}" style="font-size: 13px" required/>
                                                <input type="text" class="form-control-sm input_time" name="enddate" placeholder="End Date" id="datepicker2"
                                                    data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                                                    data-date-language="th-th" value="{{ $enddate }}" style="font-size: 13px" required/>
                                            </div>
                                        </div>
                                        <div class="col-md-1 text-center">ชื่อ-นามสกุล</div>
                                        <div class="col-md-2 text-center">
                                            <div class="input-group">
                                                <select id="USERID" name="USERID" class="form-select form-select-lg department_sub_sub" style="width: 100%;font-size: 13px">

                                                    @foreach ($data_users as $item_user)
                                                    @if ($idusershow == $item_user->ID)
                                                    <option value="{{ $item_user->ID }}" selected> {{ $item_user->HR_FNAME }}  {{ $item_user->HR_LNAME }} </option>
                                                    @else
                                                    <option value="{{ $item_user->ID }}"> {{ $item_user->HR_FNAME }}  {{ $item_user->HR_LNAME }} </option>
                                                    @endif

                                                    @endforeach

                                            </select>
                                            </div>
                                        </div>


                                        <div class="col-md-3">
                                            <button type="submit" class="ladda-button btn-pill btn btn-sm btn-info input_time">
                                                <img src="{{ asset('images/Search02.png') }}" class="me-2 ms-2" height="17px" width="17px">
                                                ค้นหา
                                            </button>
                                            <a href="{{url('time_nurs_personexcel/'.$idusershow.'/'.$startdate.'/'.$enddate)}}" class="ladda-button btn-pill btn btn-sm btn-success input_time">
                                                <img src="{{ asset('images/export_whitenew.png') }}" class="me-2 ms-2" height="17px" width="17px">
                                                Export
                                            </a>
                                            <a href="{{URL('time_nurs_person_pdf/'.$idusershow.'/'.$startdate.'/'.$enddate)}}" class="ladda-button me-2 btn-pill btn btn-sm btn-primary input_time">
                                                <i class="fa-solid fa-print me-2 text-white" style="font-size:13px"></i>
                                                <span>Print</span>
                                            </a>
                                        </div>

                                    </div>
                            </form>
                            <hr style="color: rgb(252, 18, 108)">
                            <div class="table-responsive">
                                <table class="align-middle mb-0 table table-sm table-borderless table-striped" id="example2" style="background-color: #fffefe">
                                    <thead>
                                        <tr style="font-size: 13px">
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
                                        @foreach ($datashow_ as $item)

                                            <tr style="font-size: 12px">
                                                <td class="text-center">{{ $ia++ }}</td>
                                                <td class="text-center">{{ Datethai($item->CHEACKIN_DATE )}}</td>
                                                <td class="text-start">{{ $item->hrname }}</td>
                                                <td class="text-start">{{ $item->HR_DEPARTMENT_SUB_SUB_NAME }}</td>
                                                <td class="text-center">{{ $item->CHEACKINTIME }}</td>
                                                <td class="text-center">{{ $item->CHEACKOUTTIME }}</td>
                                                <td class="text-start">{{ $item->OPERATE_TYPE_NAME }}</td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>
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

        $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
        });
        $('#HR_DEPARTMENT_ID').select2({
                placeholder: "--เลือก--",
                allowClear: true
            });
        $('#HR_DEPARTMENT_SUB_ID').select2({
                placeholder: "--เลือก--",
                allowClear: true
            });
        $('#HR_DEPARTMENT_SUB_SUB_ID').select2({
            placeholder: "--เลือก--",
            allowClear: true
        });

        $('#USERID').select2({
            placeholder: "--เลือก--",
            allowClear: true
        });

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

