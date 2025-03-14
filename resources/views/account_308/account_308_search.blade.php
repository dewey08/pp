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

            <!-- start page title -->
            {{-- <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h5 class="card-title" style="color:rgb(248, 28, 83)">Detail Pang 1102050101.308</h5>
                        <form action="{{ route('acc.account_308_search') }}" method="GET">
                            @csrf
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker6'>
                                            <input type="text" class="form-control-sm cardacc" name="startdate" id="datepicker" placeholder="Start Date"
                                                data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                                                data-date-language="th-th" value="{{ $startdate }}" required/>
                                            <input type="text" class="form-control-sm cardacc" name="enddate" placeholder="End Date" id="datepicker2"
                                                data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                                                data-date-language="th-th" value="{{ $enddate }}" required/>

                                                <button type="submit" class="ladda-button btn-pill btn btn-sm btn-info cardacc" data-style="expand-left">
                                                    <span class="ladda-label">
                                                        <img src="{{ asset('images/Search02.png') }}" class="me-2 ms-2" height="18px" width="18px">
                                                        ค้นหา</span>
                                                </button>
                                        </div>
                                    </ol>
                                </div>

                    </div>
                </div>
            </div> --}}
            <!-- end page title -->
            <form action="{{ url('account_308_search') }}" method="GET">
                @csrf
                <div class="row">
                    <div class="col-md-4">
                        <h4 class="card-title" style="color:rgb(248, 28, 83)">Detail 1102050101.308 </h4>
                        <p class="card-title-desc">รายละเอียดข้อมูล ผัง 1102050101.308</p>
                    </div>
                    <div class="col"></div>
                    <div class="col-md-1 text-end mt-2">วันที่</div>
                    <div class="col-md-3 text-end">
                        <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker1'>
                            <input type="text" class="form-control-sm cardacc" name="startdate" id="datepicker" placeholder="Start Date" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                                data-date-language="th-th" value="{{ $startdate }}" required/>
                            <input type="text" class="form-control-sm cardacc" name="enddate" placeholder="End Date" id="datepicker2" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                                data-date-language="th-th" value="{{ $enddate }}"/>
                                <button type="submit" class="ladda-button btn-pill btn btn-sm btn-info cardacc">
                                    <span class="ladda-label">
                                        <img src="{{ asset('images/Search02.png') }}" class="me-2 ms-2" height="18px" width="18px">
                                        ค้นหา</span>
                                </button>
                        </div>
                    </div>
                </div>
            </form>

        <div class="row ">
            <div class="col-md-12">
                <div class="card card_audit_4c" style="background-color: rgb(246, 235, 247)">
                    <div class="card-body">
                        <div class="table-responsive">

                            <table id="datatable-buttons" class="table table-sm table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th class="text-center" width="4%">ลำดับ</th>
                                        {{-- <th class="text-center" >vn</th> --}}
                                        <th class="text-center" >an</th>
                                        <th class="text-center" >hn</th>
                                        <th class="text-center" >cid</th>
                                        <th class="text-center">ptname</th>
                                        <th class="text-center">vstdate</th>
                                        <th class="text-center">dchdate</th>
                                        <th class="text-center">pttype</th>
                                        <th class="text-center">nhso_docno</th>
                                        <th class="text-center">hospmain</th>
                                        <th class="text-center">income</th>
                                        <th class="text-center">claim</th>
                                        <th class="text-center">ลูกหนี้</th>
                                        <th class="text-center">รับชำระ</th>
                                        <th class="text-center">ส่วนต่าง</th>
                                        <th class="text-center">เลขที่ใบเสร็จ</th>
                                        <th class="text-center">ลงวันที่</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $number = 0;
                                    $total1 = 0; $total2 = 0;$total3 = 0;$total4 = 0;$total5 = 0;$total6 = 0;$total7 = 0;$total8 = 0;$total9 = 0;
                                    ?>
                                    @foreach ($datashow as $item)
                                        <?php $number++; ?>
                                        <tr height="20" style="font-size: 14px;">
                                            <td class="text-font" style="text-align: center;" width="4%">{{ $number }}</td>
                                            {{-- <td class="text-center" width="7%">{{ $item->vn }}</td> --}}
                                            <td class="text-center" width="7%">{{ $item->an }}</td>
                                            <td class="text-center" width="5%">{{ $item->hn }}</td>
                                            <td class="text-center" width="8%">{{ $item->cid }}</td>
                                            <td class="text-start" >{{ $item->ptname }}</td>
                                            <td class="text-center" width="7%">{{ $item->vstdate }}</td>
                                            <td class="text-center" width="7%">{{ $item->dchdate }}</td>
                                            <td class="text-center" width="5%">{{ $item->pttype }}</td>
                                            <td class="text-center" width="7%">{{ $item->nhso_docno }}</td>
                                            <td class="text-center" width="5%">{{ $item->hospmain }}</td>
                                            <td class="text-center" style="color:rgb(6, 83, 170)" width="5%">{{ number_format($item->income,2)}}</td>
                                            <td class="text-center" style="color:rgb(6, 83, 170)" width="5%">{{ number_format($item->claim,2)}}</td>
                                            <td class="text-center" style="color:rgb(10, 117, 150)" width="5%">{{ number_format($item->debit_total,2)}}</td>
                                            <td class="text-center" style="color:rgb(4, 156, 118)" width="5%">{{ number_format($item->stm,2)}}</td>
                                            <td class="text-center" style="color:rgb(131, 6, 93)" width="5%">{{ number_format($item->difference,2)}}</td>
                                            <td class="text-center" style="color:rgb(131, 6, 93)" width="7%">{{ $item->stm_no }}</td>
                                            <td class="text-center" style="color:rgb(131, 6, 93)" width="5%">{{ $item->date_save }}</td>

                                        </tr>
                                        <?php
                                            $total1 = $total1 + $item->income;
                                            $total2 = $total2 + $item->claim;
                                            $total3 = $total3 + $item->debit_total;
                                            $total4 = $total4 + $item->stm;
                                            $total5 = $total5 + $item->difference;
                                        ?>
                                    @endforeach

                                </tbody>
                                <tr style="background-color: #f3fca1">
                                    <td colspan="10" class="text-center" style="background-color: #ff9d9d"></td>
                                    <td class="text-center" style="background-color: #04346b;color:rgb(11, 112, 228)">{{ number_format($total1,2)}}</td>
                                    <td class="text-center" style="background-color: #8f0c63;color:rgb(11, 112, 228)">{{ number_format($total2,2)}}</td>
                                    <td class="text-center" style="background-color: #096894;color:rgb(11, 112, 228)">{{ number_format($total3,2)}}</td>
                                    <td class="text-center" style="background-color: #096894;color:rgb(11, 112, 228)">{{ number_format($total4,2)}}</td>
                                    <td class="text-center" style="background-color: #096894;color:rgb(11, 112, 228)">{{ number_format($total5,2)}}</td>
                                    <td colspan="2" class="text-end" style="background-color: #ff9d9d"></td>
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
    </script>
@endsection
