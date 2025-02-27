@extends('layouts.accountpk')
@section('title', 'PK-OFFICE || ACCOUNT')

@section('content')
    <script>
        function TypeAdmin() {
            window.location.href = '{{ route('index') }}';
        }
        function acc_107_debt_syncnew(months)
        {
            var bgyearnow = $('#bgyearnow').val();
            Swal.fire({
                title: 'ต้องการ Sync Data ใช่ไหม?',
                text: "ข้อมูลนี้จะถูก Sync!!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'ใช่, Sync เดี๋ยวนี้ !',
                cancelButtonText: 'ไม่, ยกเลิก'
            }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url:"{{url('acc_107_debt_syncnew')}}" +'/'+ months,
                    type:'POST',
                    data:{bgyearnow,
                        _token : $("input[name=_token]").val()
                    },
                    success:function(response)
                    {
                        Swal.fire({
                            title: 'Sync Data. สำเร็จ !',
                            text: "You Sync Data success",
                            icon: 'success',
                            showCancelButton: false,
                            confirmButtonColor: '#06D177',
                            // cancelButtonColor: '#d33',
                            confirmButtonText: 'เรียบร้อย'
                        }).then((result) => {
                            if (result.isConfirmed) {
                            $("#sid"+months).remove();
                            window.location.reload();
                            //   window.location = "/person/person_index"; //
                            }
                        })
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
    $ynow = date('Y')+543;
    $yb =  date('Y')+542;
    ?>

     <style>
        body{
            font-family: sans-serif;
            font: normal;
            font-style: normal;
        }
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
            border: 5px #ddd solid;
            border-top: 10px #12c6fd solid;
            border-radius: 50%;
            animation: sp-anime 0.8s infinite linear;
        }

        @keyframes sp-anime {
            100% {
                transform: rotate(360deg);
            }
        }

        .is-hide {
            display: none;
        }
    </style>

    <?php
        $ynow = date('Y')+543;
        $yb =  date('Y')+542;
    ?>

   <div class="container-fluid">
        <div id="preloader">
            <div id="status">
                <div class="spinner">
                </div>
            </div>
        </div>
        {{-- <form action="{{ route('acc.acc_106_dashboard') }}" method="GET">
            @csrf
            <div class="row ms-2 me-2 mt-2">
                <div class="col-md-3">
                    <h5 class="card-title">Detail 1102050102.106</h5>
                    <p class="card-title-desc">รายละเอียดข้อมูล ผัง 1102050102.106</p>
                </div>
                <div class="col"></div>
                <div class="col-md-1 text-end mt-2">วันที่</div>
                <div class="col-md-4 text-end">
                    <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker6'>
                        <input type="text" class="form-control" name="startdate" id="datepicker" placeholder="Start Date"
                            data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                            data-date-language="th-th" value="{{ $startdate }}" required/>
                        <input type="text" class="form-control" name="enddate" placeholder="End Date" id="datepicker2"
                            data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                            data-date-language="th-th" value="{{ $enddate }}" required/>

                    <button type="submit" class="btn-icon btn-shadow btn-dashed btn btn-outline-info">
                        <i class="fa-solid fa-magnifying-glass text-info me-2"></i>
                        ค้นหา
                    </button>
                </div>
                </div>

            </div>
        </form> --}}

        <form action="{{ route('acc.acc_107_dashboard') }}" method="GET">
            @csrf
            <div class="row">
                <div class="col"></div>
                <div class="col-md-7">
                    <h4 class="card-title" style="color:rgb(247, 31, 95)">Detail 1102050102.107</h4>
                    <p class="card-title-desc">รายละเอียดข้อมูล ผัง 1102050102.107</p>
                </div>
                {{-- <div class="col"></div> --}}
                <input type="hidden" name="bgyearnow" id="bgyearnow" value="{{$bg_yearnow}}">

                @if ($budget_year =='')
                <div class="col-md-2">
                        <select name="budget_year" id="budget_year" class="form-control-sm text-center card_audit_4c" style="width: 100%;font-size:13px">
                            @foreach ($dabudget_year as $item_y)
                                @if ($bg_yearnow == $item_y->leave_year_id )
                                    <option value="{{$item_y->leave_year_id}}" selected>{{$item_y->leave_year_name}}</option>
                                @else
                                    <option value="{{$item_y->leave_year_id}}">{{$item_y->leave_year_name}}</option>
                                @endif
                            @endforeach
                        </select>
                </div>
                @else
                <div class="col-md-2">
                        <select name="budget_year" id="budget_year" class="form-control-sm text-center card_audit_4c" style="width: 100%;font-size:13px">
                            @foreach ($dabudget_year as $item_y)
                                @if ($budget_year == $item_y->leave_year_id )
                                    <option value="{{$item_y->leave_year_id}}" selected>{{$item_y->leave_year_name}}</option>
                                @else
                                    <option value="{{$item_y->leave_year_id}}">{{$item_y->leave_year_name}}</option>
                                @endif
                            @endforeach
                        </select>
                </div>
                @endif
                <div class="col-md-1 text-start">
                    <button type="submit" class="ladda-button btn-pill btn btn-sm btn-info cardacc">
                        <span class="ladda-label">
                            <img src="{{ asset('images/Search02.png') }}" class="me-2 ms-2" height="18px" width="18px">
                            ค้นหา</span>
                    </button>
                </div>

                <div class="col"></div>

        </div>
        </form>


        <div class="row">
            <div class="col"></div>
            @if ($startdate !='')
                <div class="col-xl-10 col-md-10">
                    <div class="card card_audit_4c" style="background-color: rgb(246, 235, 247)">
                        <div class="table-responsive p-3">
                            <table id="example" class="table table-sm table-striped table-bordered dt-responsive nowrap myTable"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th class="text-center" style="background-color: rgb(219, 247, 232)">ลำดับ</th>
                                        <th class="text-center" style="background-color: rgb(219, 247, 232)">เดือน</th>
                                        <th class="text-center" style="background-color: rgb(219, 247, 232)">income</th>
                                        <th class="text-center" style="background-color: rgb(135, 190, 253)">ลูกหนี้ที่ต้องตั้ง</th>
                                        <th class="text-center" style="background-color: rgb(135, 190, 253)">ตั้งลูกหนี้</th>
                                        <th class="text-center" style="background-color: rgb(182, 210, 252)">รับชำระ(ชำระแล้ว)</th>
                                        <th class="text-center" style="background-color: rgb(250, 225, 234)">ยกยอดไป</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $number = 0; $total1 = 0; $total2 = 0; $total3 = 0; $total4 = 0; $total5 = 0;$total6 = 0;$total7 = 0;
                                    ?>
                                    @foreach ($datashow as $item)
                                        <?php
                                            $number++;
                                            $y = $item->year;
                                                $ynew = $y + 543;
                                            // ลูกหนี้ที่ต้องตั้ง 107
                                            $datas = DB::select(
                                                'SELECT count(DISTINCT an) as Can,SUM(debit_total) as sumdebit
                                                    FROM acc_debtor
                                                    WHERE account_code="1102050102.107"
                                                    AND stamp = "N"
                                                    AND debit_total > 0
                                                    AND month(dchdate) = "'.$item->months.'"
                                                    AND year(dchdate) = "'.$item->year.'"
                                            ');
                                            foreach ($datas as $key => $value) {
                                                $count_N = $value->Can;
                                                $sum_N = $value->sumdebit;
                                            }

                                            // ตั้งลูกหนี้ 107
                                            $datasum_ = DB::select(
                                                'SELECT sum(debit_total) as debit_total,count(DISTINCT an) as Cvit
                                                FROM acc_1102050102_107
                                                WHERE month(dchdate) = "'.$item->months.'"
                                                AND year(dchdate) = "'.$item->year.'"

                                            ');
                                            foreach ($datasum_ as $key => $value2) {
                                                $total_sumY = $value2->debit_total;
                                                $total_countY = $value2->Cvit;
                                            }

                                            // รับชำระ107
                                            $datasum_rec = DB::select(
                                                'SELECT sum(sumtotal_amount) as debit_total,count(DISTINCT an) as Cvit
                                                FROM acc_1102050102_107
                                                WHERE month(dchdate) = "'.$item->months.'"
                                                AND year(dchdate) = "'.$item->year.'"

                                            ');
                                            foreach ($datasum_rec as $key => $value3) {
                                                    $total_recsumY = $value3->debit_total;
                                                    $total_reccountY = $value3->Cvit;
                                            }

                                        ?>

                                            <tr id="sid{{ $item->months }}">
                                                <td class="text-font" style="text-align: center;" width="4%">{{ $number }} </td>
                                                <td class="p-2">
                                                    {{$item->MONTH_NAME}} {{$ynew}}
                                                </td>
                                                <td class="text-center" style="color:rgb(73, 147, 231)" width="10%"> {{ number_format($item->income, 2) }}</td>

                                                <td class="text-center" style="color:rgb(6, 82, 170);background-color: rgb(203, 227, 255)" width="10%">
                                                    <a href="{{url('acc_107_pull_wait/'.$item->months.'/'.$item->year)}}" target="_blank" style="color:rgb(5, 58, 173);"> {{ number_format($sum_N, 2) }}</a>
                                                </td>
                                                <td class="text-center" style="color:rgb(231, 73, 139);background-color: rgb(203, 227, 255)" width="10%">
                                                    <a href="{{url('acc_107_detail/'.$item->months.'/'.$item->year)}}" target="_blank" style="color:rgb(231, 73, 139);"> {{ number_format($total_sumY, 2) }}</a>
                                                </td>
                                                <td class="text-center" style="color:rgb(6, 82, 170);background-color: rgb(203, 227, 255)" width="15%">
                                                    {{-- <input type="checkbox" class="dcheckbox_ sub_chk" data-id="{{$item->months}}"> --}}
                                                    {{-- <button type="button" class="ladda-button btn-pill btn btn-sm btn-danger card_audit_4c SyncdataAll" data-url="{{url('acc_107_debt_syncnew')}}"> --}}
                                                    {{-- <button type="button" class="ladda-button btn-pill btn btn-sm btn-danger card_audit_4c SyncdataAllNew" data-id="{{$item->months}}">
                                                        <i class="fa-solid fa-arrows-rotate text-whhite me-2"></i>
                                                        ................
                                                    </button> --}}
                                                    <a class="ladda-button btn-pill btn btn-sm btn-danger card_audit_4c" href="javascript:void(0)"
                                                        onclick="acc_107_debt_syncnew({{$item->months}})"
                                                        data-bs-toggle="tooltip" data-bs-placement="left"
                                                        data-bs-custom-class="custom-tooltip" title="Sync Data">
                                                        <i class="fa-solid fa-arrows-rotate text-whhite me-2"></i>
                                                    </a>
                                                    <a class="ladda-button btn-pill btn btn-sm btn-danger card_audit_4c" href="{{url('acc_107_detail_money/'.$item->months.'/'.$item->year)}}">
                                                        {{ number_format($total_recsumY, 2) }}
                                                    </a>

                                                </td>
                                                <td class="text-center" style="color:rgb(224, 128, 17)" width="10%">
                                                    {{ number_format($total_sumY-$total_recsumY, 2) }}
                                                </td>
                                            </tr>
                                        <?php
                                                $total1 = $total1 + $item->income;
                                                $total2 = $total2 + $sum_N;
                                                $total3 = $total3 + $total_sumY;
                                                $total4 = $total4 + $total_recsumY;
                                                // $total5 = $total5 + $sum_stm_money;
                                                // $total6 = $total6 + $sum_yokpai;
                                        ?>
                                    @endforeach

                                </tbody>
                                <tr style="background-color: #f3fca1">
                                    <td colspan="2" class="text-end" style="background-color: #fca1a1"></td>
                                    <td class="text-end" style="background-color: #47A4FA"><label for="" style="color: #0962b6">{{ number_format($total1, 2) }}</label></td>
                                    <td class="text-end" style="background-color: #033a6d"><label for="" style="color: #0962b6">{{ number_format($total2, 2) }}</label></td>
                                    <td class="text-end" style="background-color: #fc5089"><label for="" style="color: #0962b6">{{ number_format($total3, 2) }}</label></td>
                                    <td class="text-end" style="background-color: #fc5089"><label for="" style="color: #0962b6">{{ number_format($total4, 2) }}</label></td>
                                    <td class="text-end" style="background-color: #fc5089"><label for="" style="color: #0962b6"></label></td>
                                    {{-- <td class="text-end" style="background-color: #2e41e9" ><label for="" style="color: #0962b6">{{ number_format($total7, 2) }}</label></td> --}}
                                    {{-- <td class="text-end" style="background-color: #149966" ><label for="" style="color: #0962b6">{{ number_format($total5, 2) }}</label></td> --}}
                                    {{-- <td class="text-end" style="background-color: #f89625"><label for="" style="color: #0962b6">{{ number_format($total6, 2) }}</label></td> --}}

                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            @else

            @endif
            <div class="col"></div>
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

            $('#stamp').on('click', function(e) {
                if($(this).is(':checked',true))
                {
                    $(".sub_chk").prop('checked', true);
                } else {
                    $(".sub_chk").prop('checked',false);
                }
            });

            // $('.SyncdataAllNew').click(function() {
            //         var bgyearnow = $('#bgyearnow').val();
            //         // var id = $('#datepicker2').val();
            //         // alert(startdate);
            //         Swal.fire({
            //                 title: 'ต้องการซิ้งค์ข้อมูลใช่ไหม ?',
            //                 text: "You Sync Data!",
            //                 icon: 'warning',
            //                 showCancelButton: true,
            //                 confirmButtonColor: '#3085d6',
            //                 cancelButtonColor: '#d33',
            //                 confirmButtonText: 'Yes, Sync it!'
            //                 }).then((result) => {
            //                     if (result.isConfirmed) {
            //                         $("#overlay").fadeIn(300);
            //                         $("#spinner").show();

            //                         $.ajax({
            //                             url: "{{ url('acc_107_debt_sync') }}",
            //                             type: "POST",
            //                             dataType: 'json',
            //                             data: {bgyearnow,enddate},
            //                             success: function(data) {
            //                                 if (data.status == 200) {
            //                                     Swal.fire({
            //                                         title: 'ซิ้งค์ข้อมูลสำเร็จ',
            //                                         text: "You Sync data success",
            //                                         icon: 'success',
            //                                         showCancelButton: false,
            //                                         confirmButtonColor: '#06D177',
            //                                         confirmButtonText: 'เรียบร้อย'
            //                                     }).then((result) => {
            //                                         if (result
            //                                             .isConfirmed) {
            //                                             console.log(
            //                                                 data);
            //                                             window.location.reload();
            //                                             $('#spinner').hide();//Request is complete so hide spinner
            //                                                 setTimeout(function(){
            //                                                     $("#overlay").fadeOut(300);
            //                                                 },500);
            //                                         }
            //                                     })

            //                                 } else if (data.status == 100) {
            //                                     Swal.fire({
            //                                         title: 'ซิ้งค์ข้อมูลไม่สำเร็จ',
            //                                         text: "You Sync data Unsuccess.",
            //                                         icon: 'warning',
            //                                         showCancelButton: false,
            //                                         confirmButtonColor: '#06D177',
            //                                         confirmButtonText: 'เรียบร้อย'
            //                                     }).then((result) => {
            //                                         if (result
            //                                             .isConfirmed) {
            //                                             console.log(
            //                                                 data);
            //                                             window.location.reload();

            //                                         }
            //                                     })

            //                                 } else {

            //                                 }
            //                             },
            //                         });

            //                     }
            //         })
            // });

            // $('.SyncdataAll').click(function() {
            //     // var bgyearnow = $('#bgyearnow').val();
            //     // alert(bgyearnow);
            //     var allValls = [];
            //     $(".sub_chk:checked").each(function () {
            //         allValls.push($(this).attr('data-id'));
            //         // allVallss.push($(this).attr('data-name'));
            //     });
            //     if (allValls.length <= 0) {
            //         // alert("SSSS");
            //         Swal.fire({
            //             title: 'คุณยังไม่ได้เลือกรายการ ?',
            //             text: "กรุณาเลือกรายการก่อน",
            //             icon: 'warning',
            //             showCancelButton: true,
            //             confirmButtonColor: '#3085d6',
            //             cancelButtonColor: '#d33',
            //             }).then((result) => {

            //             })
            //     } else {

            //         Swal.fire({
            //             title: 'Are you sure?',
            //             text: "ต้องการตรวจสอบสอทธิ์ใช่ไหม!",
            //             icon: 'warning',
            //             showCancelButton: true,
            //             confirmButtonColor: '#3085d6',
            //             cancelButtonColor: '#d33',
            //             confirmButtonText: 'You Check Sit Data!.!'
            //             }).then((result) => {
            //                 if (result.isConfirmed) {
            //                     var check = true;
            //                     if (check == true) {
            //                         var join_selected_values = allValls.join(",");
            //                         // var join_selected_valuess = allVallss.join(",");
            //                         var bgyearnow = $('#bgyearnow').val();
            //                         alert(bgyearnow);
            //                         // alert(join_selected_values);
            //                         $("#overlay").fadeIn(300);
            //                         $("#spinner").show(); //Load button clicked show spinner

            //                         $.ajax({
            //                             url:$(this).data('url'),
            //                             type: 'POST',
            //                             headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            //                             data: 'ids='+join_selected_values,bgyearnow,
            //                             success:function(data){
            //                                     if (data.status == 200) {
            //                                         $(".sub_chk:checked").each(function () {
            //                                             $(this).parents("tr").remove();
            //                                         });
            //                                         Swal.fire({
            //                                             title: 'เช็คสิทธิ์สำเร็จ',
            //                                             text: "You Check sit success",
            //                                             icon: 'success',
            //                                             showCancelButton: false,
            //                                             confirmButtonColor: '#06D177',
            //                                             confirmButtonText: 'เรียบร้อย'
            //                                         }).then((result) => {
            //                                             if (result
            //                                                 .isConfirmed) {
            //                                                 console.log(
            //                                                     data);
            //                                                 window.location.reload();
            //                                                 $('#spinner').hide();//Request is complete so hide spinner
            //                                             setTimeout(function(){
            //                                                 $("#overlay").fadeOut(300);
            //                                             },500);
            //                                             }
            //                                         })
            //                                     } else {

            //                                     }

            //                             }
            //                         });
            //                         $.each(allValls,function (index,value) {
            //                             $('table tr').filter("[data-row-id='"+value+"']").remove();
            //                         });
            //                     }
            //                 }
            //             })


            //         }
            //     });

            });
    </script>

@endsection
