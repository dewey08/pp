@extends('layouts.accountpk')
@section('title', 'PK-OFFICE || ACCOUNT')
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
            border-top: 10px #ff8897 solid;
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
        <div id="preloader">
            <div id="status">
                <div class="spinner">
                </div>
            </div>
        </div>

            <form action="{{ url('account_203_detail_date') }}" method="GET">
                @csrf
                    <!-- start page title -->
                    <div class="row">
                            <div class="col-md-6">
                                <h4 class="card-title" style="color:rgb(248, 28, 83)">Detail 1102050101.203</h4>
                                <p class="card-title-desc">รายละเอียดข้อมูล ผัง 1102050101.203 วันที่ {{ DateThai($startdate) }} - {{ DateThai($enddate) }}</p>
                            </div>
                            <div class="col"></div>
                            <div class="col-md-2 text-end">
                                <a href="{{url('account_203_detail_date/'.$startdate.'/'.$enddate)}}" class="ladda-button me-2 btn-pill btn btn-sm btn-warning cardacc">
                                    <i class="fa-solid fa-arrow-left me-2"></i>
                                   ย้อนกลับ
                                </a> </div>

                    </div>
            </form>



        <div class="row">
            <div class="col-xl-12">
                <div class="card card_audit_4c" style="background-color: rgb(246, 235, 247)">
                        <div class="card-body">
                            <div class="table-responsive">

                                <table id="datatable-buttons" class="table table-sm table-striped table-bordered dt-responsive nowrap myTable"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th class="text-center">ลำดับ</th>
                                            <th class="text-center">vstdate</th>
                                            <th class="text-center">vn</th>
                                            <th class="text-center">hn</th>
                                            <th class="text-center">cid</th>
                                            <th class="text-center">ptname</th>
                                            <th class="text-center">pttype</th>
                                            <th class="text-center">pdx</th>
                                            <th class="text-center">dx0</th>
                                            <th class="text-center">income</th>
                                            <th class="text-center">ชำระเงินเอง</th>
                                            <th class="text-center">ตั้งลูกหนี้</th>
                                            <th class="text-center">ลูกหนี้ตามข้อตกลง</th>
                                            <th class="text-center">ลูกหนี้CT</th>
                                            <th class="text-center">ส่วนต่าง</th>
                                            <th class="text-center">Hcode</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $number = 0;
                                        $total111 = 0;
                                        $total222 = 0;
                                        $total333 = 0;
                                        $total444 = 0;
                                        $total555 = 0; $total666 = 0;
                                    ?>
                                        @foreach ($data as $item)
                                        <?php $number++; ?>
                                            <tr>
                                                <td class="text-font" style="text-align: center;" width="4%">{{ $number }} </td>
                                                <td class="text-center" width="7%">{{ $item->vstdate }}</td>
                                                <td class="text-center" width="8%">{{ $item->vn }}</td>
                                                <td class="text-center" width="5%">{{ $item->hn }}</td>
                                                <td class="text-center" width="7%">{{ $item->cid }}</td>
                                                <td class="p-2">{{ $item->ptname }}</td>
                                                <td class="text-center" width="5%">{{ $item->pttype }}</td>
                                                <td class="text-end" style="color:rgb(243, 157, 27)" width="7%"> {{ $item->pdx }}</td>
                                                <td class="text-end" style="color:rgb(243, 157, 27)" width="7%"> {{ $item->dx0 }}</td>
                                                <td class="text-end" style="color:rgb(73, 147, 231)" width="7%"> {{ number_format($item->income, 2) }}</td>
                                                <td class="text-end" style="color:rgb(73, 147, 231)" width="7%"> {{ number_format($item->rcpt_money, 2) }}</td>
                                                <td class="text-end" style="color:rgb(207, 28, 37)" width="7%"> {{ number_format($item->income - $item->rcpt_money, 2) }}</td>
                                                <td class="text-end"  width="7%" style="color:rgb(237, 100, 255)"> {{ $item->debit_total }}</td>
                                                <td class="text-end"  width="7%" style="color:#108A1A"> {{ $item->ct_price }}</td>
                                                <td class="text-end"  width="7%" style="color:#E9540F"> {{ number_format(($item->income)-($item->rcpt_money)-($item->debit_total)-($item->ct_price),2) }}</td>

                                                <td class="text-center" width="5%">{{ $item->hospmain }}</td>
                                            </tr>
                                                <?php
                                                    $total111 = $total111 + $item->income;
                                                    $total222 = $total222 + $item->rcpt_money;
                                                    $total666 = $total666 + ($item->income - $item->rcpt_money);
                                                    $total333 = $total333 + $item->debit_total;
                                                    $total444 = $total444 + $item->ct_price;
                                                    $total555 = $total555 + (($item->income)-($item->rcpt_money)-($item->debit_total)-($item->ct_price));
                                                ?>
                                    @endforeach

                                </tbody>
                                <tr style="background-color: #f3fca1">
                                    <td colspan="9" class="text-center" style="background-color: #fca1a1"></td>
                                    <td class="text-center" style="background-color: #1e8aee"><label for="" style="color: #1e8aee">{{ number_format($total111, 2) }}</label></td>
                                    <td class="text-center" style="background-color: #9f4efc" ><label for="" style="color: #9f4efc">{{ number_format($total222, 2) }}</label></td>
                                    <td class="text-center" style="background-color: #c5224b"><label for="" style="color: #c5224b">{{ number_format($total666, 2) }}</label> </td>
                                    <td class="text-center" style="background-color: #f557da"><label for="" style="color: #f557da">{{ number_format($total333, 2) }}</label></td>
                                    <td class="text-center" style="background-color: #0ea080"><label for="" style="color: #0ea080">{{ number_format($total444, 2) }}</label></td>
                                    <td class="text-center" style="background-color: #f89625"><label for="" style="color: #f89625">{{ number_format($total555, 2) }}</label></td>
                                    <td colspan="1" class="text-center" style="background-color: #fca1a1"></td>
                                </tr>

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

            $('#datepicker').datepicker({
                format: 'yyyy-mm-dd'
            });
            $('#datepicker2').datepicker({
                format: 'yyyy-mm-dd'
            });

            $('#example').DataTable();
            $('#hospcode').select2({
                placeholder: "--เลือก--",
                allowClear: true
            });
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        });
        $('.Pulldata').click(function() {
                var vn = $(this).val();
                // alert(vn);
                Swal.fire({
                        title: 'ต้องการซิ้งค์ข้อมูลใช่ไหม ?',
                        text: "You Sync Data!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, Sync it!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $("#overlay").fadeIn(300);　
                                $("#spinner").show();

                                $.ajax({
                                    url: "{{ url('account_307_sync') }}",
                                    type: "POST",
                                    dataType: 'json',
                                    data: {vn},
                                    success: function(data) {
                                        if (data.status == 200) {
                                            Swal.fire({
                                                title: 'ดึงข้อมูลสำเร็จ',
                                                text: "You Sync data success",
                                                icon: 'success',
                                                showCancelButton: false,
                                                confirmButtonColor: '#06D177',
                                                confirmButtonText: 'เรียบร้อย'
                                            }).then((result) => {
                                                if (result
                                                    .isConfirmed) {
                                                    console.log(
                                                        data);
                                                    window.location.reload();
                                                    $('#spinner').hide();//Request is complete so hide spinner
                                                        setTimeout(function(){
                                                            $("#overlay").fadeOut(300);
                                                        },500);
                                                }
                                            })

                                        } else if (data.status == 100) {
                                            Swal.fire({
                                                title: 'ยังไม่ได้ลงเลขที่หนังสือ',
                                                text: "Please enter the number of the book.",
                                                icon: 'warning',
                                                showCancelButton: false,
                                                confirmButtonColor: '#06D177',
                                                confirmButtonText: 'เรียบร้อย'
                                            }).then((result) => {
                                                if (result
                                                    .isConfirmed) {
                                                    console.log(
                                                        data);
                                                    window.location.reload();

                                                }
                                            })

                                        } else {

                                        }
                                    },
                                });

                            }
                })
        });

        $('.PulldataAll').click(function() {
                var months = $('#months').val();
                var year = $('#year').val();
                // alert(startdate);
                Swal.fire({
                        title: 'ต้องการซิ้งค์ข้อมูลใช่ไหม ?',
                        text: "You Sync Data!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, Sync it!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $("#overlay").fadeIn(300);　
                                $("#spinner").show();

                                $.ajax({
                                    url: "{{ url('account_307_syncall') }}",
                                    type: "POST",
                                    dataType: 'json',
                                    data: {months,year},
                                    success: function(data) {
                                        if (data.status == 200) {
                                            Swal.fire({
                                                title: 'ซิ้งค์ข้อมูลสำเร็จ',
                                                text: "You Sync data success",
                                                icon: 'success',
                                                showCancelButton: false,
                                                confirmButtonColor: '#06D177',
                                                confirmButtonText: 'เรียบร้อย'
                                            }).then((result) => {
                                                if (result
                                                    .isConfirmed) {
                                                    console.log(
                                                        data);
                                                    window.location.reload();
                                                    $('#spinner').hide();//Request is complete so hide spinner
                                                        setTimeout(function(){
                                                            $("#overlay").fadeOut(300);
                                                        },500);
                                                }
                                            })

                                        } else if (data.status == 100) {
                                            Swal.fire({
                                                title: 'ยังไม่ได้ลงเลขที่หนังสือ',
                                                text: "Please enter the number of the book.",
                                                icon: 'warning',
                                                showCancelButton: false,
                                                confirmButtonColor: '#06D177',
                                                confirmButtonText: 'เรียบร้อย'
                                            }).then((result) => {
                                                if (result
                                                    .isConfirmed) {
                                                    console.log(
                                                        data);
                                                    window.location.reload();

                                                }
                                            })

                                        } else {

                                        }
                                    },
                                });

                            }
                })
        });


    </script>
@endsection
