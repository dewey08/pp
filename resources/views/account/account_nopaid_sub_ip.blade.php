@extends('layouts.account_new')
@section('title', 'PK-OFFICE || ACCOUNT')
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
    <div id="preloader">
        <div id="status">
            <div class="spinner">
            </div>
        </div>
    </div>
    <form action="{{ url('account_nopaid_sub') }}" method="GET">
        @csrf
    <div class="row">
        <div class="col-md-5">
            <h4 class="card-title" style="color:rgba(21, 177, 164, 0.871)">   Detail Overdue IPD</h4>
            <p class="card-title-desc">รายละเอียดข้อมูล Visit ที่มีรายการค่าใช้จ่าย แต่ไม่มีการออกใบเสร็จ หรือลงค้าง IPD</p>
        </div>
        <div class="col"></div>

    </div>
</form>
        <div class="row ">
            <div class="col-md-12">
                <div class="card cardfinan" style="background-color: rgb(246, 235, 247)">
                    <div class="card-body">
                        <table id="example" class="table table-sm table-bordered" style="width: 100%;">
                            {{-- <table id="example" class="table table-sm table-striped table-bordered dt-responsive nowrap myTable" style="border-collapse: collapse; border-spacing: 0; width: 100%;"> --}}
                            <thead>
                                <tr>
                                    <th class="text-center" width="5%">ลำดับ</th>
                                    <th class="text-center" width="6%">an</th>
                                    <th class="text-center" width="4%">hn</th>
                                    <th class="text-center" width="10%">ptname</th>
                                    <th class="text-center" width="6%">dchdate</th>
                                    <th class="text-center">pttype</th>
                                    <th class="text-center">income</th>
                                    <th class="text-center">ลูกหนี้</th>
                                    <th class="text-center">สิทธิ์ที่ 1</th>
                                    <th class="text-center">สิทธิ์ที่ 2</th>
                                    <th class="text-center">paidmoney</th>
                                    <th class="text-center">ชำระแล้ว</th>
                                    <th class="text-center">ต้องลงค้าง</th>
                                    <th class="text-center">ต้องลงส่วนลด</th>
                                    <th class="text-center">Finance No.</th>
                                    <th class="text-center">total_amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $number = 0; ?>
                                @foreach ($datashow as $item)
                                    <?php $number++; ?>

                                        <tr height="20" style="font-size: 13px;">
                                            <td class="text-center" width="2%">{{ $number }}</td>
                                            <td class="text-center" width="6%">{{ $item->an }}</td>
                                            <td class="text-center" width="4%">{{ $item->hn }}</td>
                                            <td class="text-start" width="10%">{{ $item->ptname }}</td>
                                            <td class="text-center" width="6%">{{ $item->dchdate }}</td>
                                            <td class="text-center">{{ $item->pttype }}</td>
                                            <td class="text-center" style="color:rgb(73, 147, 231)">{{ number_format($item->income,2)}}</td>
                                            <td class="text-center" style="color:rgb(73, 147, 231)">{{ number_format($item->uc_money,2)}}</td>
                                            <td class="text-center" style="color:rgb(73, 147, 231)">{{ number_format($item->pttype_1,2)}}</td>
                                            <td class="text-center" style="color:rgb(73, 147, 231)">{{ number_format($item->pttype_2,2)}}</td>
                                            <td class="text-center" style="color:rgb(243, 61, 55)">{{ number_format($item->paid_money,2)}}</td>
                                            <td class="text-center" style="color:rgb(125, 202, 23)">{{ number_format($item->rcpt_money,2)}}</td>

                                                @if ($item->pttype_1 > 0 || $item->pttype ='15')
                                                    @if ($item->pttype_1 < 1)
                                                        <td class="text-center" style="color:rgb(4, 128, 111)"> {{ number_format($item->pttype_1,2)}} </td>
                                                        <td class="text-center" style="color:rgb(240, 25, 25);font-size:17px"> {{ number_format($item->paid_money- $item->discount_money- $item->rcpt_money,2)}} </td>
                                                    @else
                                                        @if ($item->rcpt_money == $item->pttype_1)
                                                            <td class="text-center" style="background-color:rgb(15, 202, 177);color:white;font-size:17px"> 0.00 </td>
                                                            <td class="text-center" style="background-color:rgb(5, 192, 167);color:white;font-size:17px"> 0.00 </td>
                                                        @else
                                                            <td class="text-center" style="background-color: rgb(248, 55, 21);color:white;font-size:17px"> {{ number_format($item->pttype_1 - $item->discount_money- $item->rcpt_money,2)}} </td>
                                                            <td class="text-center" style="color:rgb(240, 25, 25);font-size:17px"> {{ number_format($item->paid_money- $item->discount_money- $item->rcpt_money,2)}} </td>
                                                        @endif
                                                    @endif

                                                @else
                                                    <td class="text-center" style="color:rgb(235, 146, 30)">  {{ number_format($item->income,2)}} </td>
                                                @endif



                                            @if ($item->book_number == '')
                                            <td class="text-center"></td>
                                            @else
                                            <td class="text-center">{{ $item->book_number }}/{{ $item->finance_number }}</td>
                                            @endif
                                            <td class="text-center" style="color:rgb(125, 202, 23)"> {{ number_format($item->rp_total_amount,2)}}</td>
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
        $(document).ready(function() {
            var table = $('#example').DataTable({
                scrollY: '60vh',
                scrollCollapse: true,
                scrollX: true,
                "autoWidth": false,
                "pageLength": 10,
                "lengthMenu": [10,25,50,100,150,200,300,400,500],
        });

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
    </script>
@endsection
