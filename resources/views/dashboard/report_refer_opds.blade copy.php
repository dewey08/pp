@extends('layouts.report_font')
@section('title', 'PK-OFFICE || REFER')
@section('content')
    <style>
        #button {
            display: block;
            margin: 20px auto;
            padding: 30px 30px;
            background-color: #eee;
            border: solid #ccc 1px;
            cursor: pointer;
        }

        #overlay {
            position: fixed;
            top: 0;
            z-index: 100;
            width: 100%;
            height: 100%;
            display: none;
            background: rgba(0, 0, 0, 0.6);
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

        .is-hide {
            display: none;
        }
    </style>

    <div class="tabs-animation">

        <div class="row text-center">
            <div id="overlay">
                <div class="cv-spinner">
                    <span class="spinner"></span>
                </div>
            </div>

        </div>
        <div class="row">
            <div class="col-md-5">
                <div class="main-card mb-3 card">
                    <div class="card-header">
                        ผู้ป่วยนอกรับ Refer แยก รพ.(ในจังหวัด)
                        <div class="btn-actions-pane-right">
                            <div role="group" class="btn-group-sm btn-group">

                            </div>
                        </div>
                    </div>
                    <div class="card-body">
 
                        <div class="table-responsive mt-3">
                            <table class="align-middle mb-0 table table-borderless table-striped table-hover" >
                                <thead>
                                    <tr>
                                        <th>ลำดับ</th>
                                        <th>รอบหนังสือ สสจ</th>
                                        <th>จำนวนคนไข้</th> 
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $number = 0; ?>
                                    @foreach ($datashow_ as $item)
                                        <?php $number++; ?>
                                        <tr height="20">
                                            <td class="text-font" style="text-align: center;">{{ $number }}</td> 
                                            <td class="text-font text-pedding" style="text-align: left;"> {{ $item->doc }}</td> 
                                            <td class="text-font text-pedding" style="text-align: center;"> {{ $item->tran }}</td> 
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-md-7">
                <div class="main-card mb-3 card">
                    <div class="card-header">
                        ผู้ป่วยนอกรับ Refer แยก รพ.(ในจังหวัด)
                        <div class="btn-actions-pane-right">
                            <div role="group" class="btn-group-sm btn-group">

                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('rep.report_refer_opds') }}" method="GET">
                            @csrf
                            <div class="row mt-3"> 
                                <div class="col-md-2 text-end">วันที่</div>
                                <div class="col-md-3 text-center">
                                    <div class="input-group" id="datepicker1">
                                        <input type="text" class="form-control" name="startdate" id="datepicker"
                                            data-date-container='#datepicker1' data-provide="datepicker"
                                            data-date-autoclose="true" data-date-language="th-th"
                                            value="{{ $startdate }}">

                                        <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                    </div>
                                </div>
                                <div class="col-md-2 text-center">ถึงวันที่</div>
                                <div class="col-md-3 text-center">
                                    <div class="input-group" id="datepicker1">
                                        <input type="text" class="form-control" name="enddate" id="datepicker2"
                                            data-date-container='#datepicker1' data-provide="datepicker"
                                            data-date-autoclose="true" data-date-language="th-th"
                                            value="{{ $enddate }}">
                                        <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <button type="submit"
                                        class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info">
                                        <i class="pe-7s-search btn-icon-wrapper"></i>ค้นหา
                                    </button>

                                </div>
                               
                            </div>
                        </form>
                        <table class="align-middle mb-0 table table-borderless table-striped table-hover" >
                            <thead>
                                <tr>
                                    <th>ลำดับ</th>
                                    <th>ปี</th>
                                    <th>เดือน</th> 
                                    <th class="text-center">จำนวนผู้ป่วย(คน)</th> 
                                    <th class="text-center">จำนวนผู้ป่วย(ครั้ง) ไฟล์ สสจ</th> 
                                    <th class="text-center">ค่าใช้จ่ายจริง</th> 
                                    <th class="text-center">ค่าใช้จ่ายเงื่อนไข</th> 
                                </tr>
                            </thead>
                            <tbody>
                                <?php $number2 = 0; ?>
                                @foreach ($datashow_2 as $item2)
                                    <?php $number2++; ?>
                                    <tr height="20">
                                        <td class="text-font" style="text-align: center;">{{ $number2 }}</td> 
                                        <td class="text-font text-pedding" style="text-align: center;"> {{ $item2->year }}</td> 

                                        @if ($item2->months == '1')
                                                <td width="15%">มกราคม</td>
                                            @elseif ($item2->months == '2')
                                                <td width="15%">กุมภาพันธ์</td>
                                            @elseif ($item2->months == '3')
                                                <td width="15%">มีนาคม</td>
                                            @elseif ($item2->months == '4')
                                                <td width="15%">เมษายน</td>
                                            @elseif ($item2->months == '5')
                                                <td width="15%">พฤษภาคม</td>
                                            @elseif ($item2->months == '6')
                                                <td width="15%">มิถุนายน</td>
                                            @elseif ($item2->months == '7')
                                                <td width="15%">กรกฎาคม</td>
                                            @elseif ($item2->months == '8')
                                                <td width="15%">สิงหาคม</td>
                                            @elseif ($item2->months == '9')
                                                <td width="15%">กันยายน</td>
                                            @elseif ($item2->months == '10')
                                                <td width="15%">ตุลาคม</td>
                                            @elseif ($item2->months == '11')
                                                <td width="15%">พฤษจิกายน</td>
                                            @else
                                                <td width="15%">ธันวาคม</td>
                                            @endif
                                        <td class="text-font text-pedding" style="text-align: center;"> {{ $item2->hn }}</td> 
                                        <td class="text-font text-pedding" style="text-align: center;"> 
                                            <a href="{{url('report_refer_opds_sub/'.$item2->months.'/'.$startdate.'/'.$enddate)}}" target="_blank">{{ $item2->vn }}</a> 
                                        </td> 
                                        <td class="text-font text-pedding" style="text-align: center;"> {{ number_format($item2->sum_price ,2)}}</td> 
                                        <td class="text-font text-pedding" style="text-align: center;"> {{ number_format($item2->total ,2)}}</td> 
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>



@endsection
@section('footer')

    <script>
        window.setTimeout(function() {
            window.location.reload();
        }, 500000);
        $(document).ready(function() {
            // $("#overlay").fadeIn(300);　

            $('#datepicker').datepicker({
                format: 'yyyy-mm-dd'
            });
            $('#datepicker2').datepicker({
                format: 'yyyy-mm-dd'
            });

            $('#example').DataTable();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $("#spinner-div").hide(); //Request is complete so hide spinner

        });
    </script>
@endsection
