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
    use App\Http\Controllers\StaticController;
    use App\Models\Opitemrece217;

?>
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
        <form action="{{ url('account_pkucs209_search') }}" method="GET">
            @csrf
        <div class="row">
            <div class="col-md-4">
                <h4 class="card-title" style="color:rgb(248, 28, 83)">Detail 1102050101.209 </h4>
                <p class="card-title-desc">รายละเอียดข้อมูล ผัง 1102050101.209</p>
            </div>
            <div class="col"></div>
            <div class="col-md-1 text-end mt-2">วันที่</div>
            <div class="col-md-4 text-end">
                <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker1'>
                    <input type="text" class="form-control-sm cardacc" name="startdate" id="datepicker" placeholder="Start Date" data-date-container='#datepicker1' autocomplete="off"
                     data-provide="datepicker" data-date-autoclose="true" data-date-language="th-th" value="{{ $startdate }}"/>
                    <input type="text" class="form-control-sm cardacc" name="enddate" placeholder="End Date" id="datepicker2" data-date-container='#datepicker1' autocomplete="off"
                    data-provide="datepicker" data-date-autoclose="true" data-date-language="th-th" value="{{ $enddate }}"/>
                    <button type="submit" class="ladda-button btn-pill btn btn-sm btn-info cardacc">
                        <span class="ladda-label">
                            <img src="{{ asset('images/Search02.png') }}" class="me-2 ms-2" height="18px" width="18px">
                            ค้นหา</span>
                    </button>
                </div>
            </div>
        </div>
    </form>
        {{-- <div class="container-fluid"> --}}
            <!-- start page title -->
            {{-- <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h5 class="card-title"  style="color:rgb(247, 31, 95)">Detail 1102050101.209</h5>

                        <form action="{{ URL('account_pkucs209_search') }}" method="GET">
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

                                            <button type="submit" class="ladda-button btn-pill btn btn-sm btn-primary cardacc" data-style="expand-left">
                                                <span class="ladda-label">
                                                    <img src="{{ asset('images/Search02.png') }}" class="me-2 ms-2" height="18px" width="18px">

                                                    ค้นหา</span>
                                            </button>
                                        </div>
                                    </ol>
                                </div>
                        </form>
                    </div>
                </div>
            </div> --}}
            <!-- end page title -->
        {{-- </div>   --}}

        <div class="row ">
            <div class="col-md-12">
                <div class="card card_audit_4c" style="background-color: rgb(246, 235, 247)">
                    <div class="card-body">
                        <div class="table-responsive">
                        {{-- <table id="datatable-buttons" class="table table-sm -hide-pagingtable-sm table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;"> --}}
                        <table id="datatable-buttons" class="table table-sm table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th class="text-center">ลำดับ</th>
                                    <th class="text-center" >vn</th>
                                    <th class="text-center" >hn</th>
                                    <th class="text-center" >cid</th>
                                    <th class="text-center">ptname</th>
                                    <th class="text-center">pttype</th>
                                    <th class="text-center">vstdate</th>
                                    <th class="text-center">vsttime</th>
                                    <th class="text-center">fs</th>
                                    <th class="text-center">ลูกหนี้</th>
                                    <th class="text-center">ส่วนต่าง</th>
                                    <th class="text-center">Stm</th>
                                    <th class="text-center">STMdoc</th>
                                    <th class="text-center">อุทรณ์</th>
                                    <th class="text-center">STMdoc อุทรณ์</th>
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
                                        <td class="text-center" width="7%">{{ $item->vn }}</td>
                                        <td class="text-center" width="4%">{{ $item->hn }}</td>
                                        <td class="text-center" width="7%">{{ $item->cid }}</td>
                                        <td class="text-start" width="8%">{{ $item->ptname }}</td>
                                        <td class="text-center" width="6%">{{ $item->pttype }}</td>
                                        <td class="text-center" width="6%">{{ $item->vstdate }}</td>
                                        <td class="text-center" width="6%">{{ $item->vsttime }}</td>
                                        <td class="text-end" style="color:rgb(5, 144, 179)" width="6%">{{ number_format($item->fs,2)}}</td>
                                        <td class="text-end" style="color:rgb(73, 147, 231)" width="6%">{{ number_format($item->debit_total,2)}}</td>
                                        <td class="text-end" style="color:rgb(184, 12, 169)" width="6%">{{ number_format(($item->debit_total-$item->stm_money),2)}}</td>
                                        <td class="text-end" style="color:rgb(216, 95, 14)" width="6%">{{ number_format($item->stm_money,2)}}</td>
                                        <td class="text-start" width="9%">{{ $item->STMdoc }}</td>
                                        <td class="text-end" style="color:rgb(9, 196, 180)" width="6%">{{ number_format($item->auton,2)}}</td>
                                        <td class="text-start" width="9%">{{ $item->STMdoc_authon }}</td>

                                    </tr>
                                        <?php
                                            $total1 = $total1 + $item->debit_drug;
                                            $total2 = $total2 + $item->debit_instument;
                                            $total3 = $total3 + $item->debit_toa;
                                            $total4 = $total4 + $item->debit_refer;
                                            $total5 = $total5 + $item->fs;
                                            $total6 = $total6 + $item->debit_total;
                                            $total7 = $total7 + ($item->debit_total-$item->stm_money);
                                            $total8 = $total8 + $item->stm_money;
                                            $total9 = $total9 + $item->auton;
                                        ?>
                                @endforeach

                            </tbody>
                                    <tr style="background-color: #f3fca1">
                                        <td colspan="8" class="text-end" style="background-color: #ff9d9d"></td>
                                        <td class="text-end" style="background-color: #088ca3;color:rgb(6, 145, 187)">{{ number_format($total5,2)}}</td>
                                        <td class="text-end" style="background-color: #0783d6;color:rgb(6, 145, 187)">{{ number_format($total6,2)}}</td>
                                        <td class="text-end" style="background-color: #e09be9;color:rgb(6, 145, 187)">{{ number_format($total7,2)}}</td>
                                        <td class="text-end" style="background-color: #f5a382color:rgb(6, 145, 187)">{{ number_format($total8,2)}}</td>
                                        <td class="text-end" style="background-color: #ff9d9dcolor:rgb(6, 145, 187)"></td>
                                        <td class="text-end" style="background-color: #f5a382color:rgb(6, 145, 187)">{{ number_format($total9,2)}}</td>
                                        <td class="text-end" style="background-color: #ff9d9d"></td>
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
