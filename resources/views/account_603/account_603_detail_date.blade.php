@extends('layouts.accountpk')
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
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Detail</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Detail</a></li>
                            <li class="breadcrumb-item active">1102050102.603</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->
    </div> <!-- container-fluid -->

        <div class="row ">
            <div class="col-md-12">
                <div class="card cardacc">

                    <div class="card-body">
                        <input type="hidden" name="startdate" id="startdate" value="{{$startdate}}">
                        <input type="hidden" name="enddate" id="enddate" value="{{$enddate}}">
                        <div class="row mb-3">
                            <div class="col"></div>
                            <div class="col-md-2 text-end">
                                <button type="button"
                                    class="ladda-button me-2 btn-pill btn btn-danger cardacc PulldataAll">
                                    <i class="fa-solid fa-arrows-rotate text-write me-2"></i>
                                    Sync Data All
                                </button>
                            </div>
                        </div>
                            <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap myTable"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th class="text-center">ลำดับ</th>
                                    <th class="text-center">vn</th>
                                    <th class="text-center">hn</th>
                                    <th class="text-center">cid</th>
                                    <th class="text-center">ptname</th>
                                    <th class="text-center">dchdate</th>
                                    <th class="text-center">ค่าใช้จ่ายทั้งหมด</th>
                                    <th class="text-center">เลขที่ใบเสร็จรับเงิน</th>
                                    <th class="text-center">ยอดชดเชย</th>
                                    <th class="text-center" width="5%">ลูกหนี้</th>
                                    <th class="text-center">เลขที่หนังสือ</th>
                                    <th class="text-center">วันที่</th>
                                    <th class="text-center">บริษัท</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $number = 0;
                                $total1 = 0;
                                $total2 = 0;
                                $total3 = 0;
                                $total4 = 0;
                                ?>
                                @foreach ($data as $item)
                                    <?php $number++;
                                        $sync = DB::connection('mysql3')->select('
                                            SELECT an,nhso_docno
                                            from ipt_pttype
                                            WHERE an = "' . $item->an . '"
                                        ');
                                        foreach ($sync as $key => $value) {
                                           $docno = $value->nhso_docno;
                                        }

                                    ?>

                                        <tr>
                                            <td class="text-font" style="text-align: center;" width="4%">{{ $number }}
                                            </td>
                                            <td class="text-center" width="10%">{{ $item->vn }}</td>
                                            <td class="text-center" width="10%">{{ $item->hn }}</td>
                                            <td class="text-center" width="10%">{{ $item->cid }}</td>
                                            <td class="p-2">{{ $item->ptname }}</td>
                                            <td class="text-center" width="10%">{{ $item->dchdate }}</td>
                                            <td class="text-end" style="color:rgb(73, 147, 231)" width="7%"> {{ number_format($item->debit_total, 2) }}</td>
                                            <td class="text-center" width="10%">{{ $item->recieve_no }}</td>
                                            <td class="text-end" width="10%" style="color:rgb(216, 95, 14)"> {{ number_format($item->recieve_true, 2) }}</td>

                                            <td class="text-end" width="10%" style="color: #06a513">{{ $item->nhso_ownright_pid }}</td>
                                            <td class="text-center" width="5%">
                                                @if ($item->nhso_docno != '')
                                                    <button type="button"
                                                        class="me-2 btn-icon btn-shadow btn-dashed btn btn-outline-success">
                                                        <i class="fa-solid fa-book-open text-success me-2"></i>
                                                        {{ $item->nhso_docno }}
                                                    </button>
                                                @else
                                                    <button type="button"
                                                        class="me-2 btn-icon btn-shadow btn-dashed btn btn-outline-warning">
                                                        <i class="fa-solid fa-book-open text-warning me-2"></i>
                                                        ยังไม่ได้ลงเลขหนังสือ
                                                    </button>
                                                @endif
                                            </td>
                                            <td class="text-center" width="10%">{{ $item->nhso_ownright_name }}</td>
                                            <td class="text-start" width="10%">{{ $item->nhso_govname }}</td>
                                        </tr>

                                        {{-- <tr height="20" style="font-size: 14px;">
                                            <td class="text-font" style="text-align: center;" width="4%">{{ $number }}</td>
                                            <td class="text-center" width="10%">{{ $item->vn }}</td>
                                            <td class="text-center" width="10%">{{ $item->hn }}</td>
                                            <td class="text-center" width="10%">{{ $item->cid }}</td>
                                            <td class="p-2" >{{ $item->ptname }}</td>
                                            <td class="text-center" width="10%">{{ $item->vstdate }}</td>
                                            <td class="text-end" style="color:rgb(73, 147, 231)" width="7%">{{ number_format($item->debit_total,2)}}</td>
                                            <td class="text-end" width="10%" style="color:rgb(216, 95, 14)">{{ number_format($item->payprice,2)}}</td>
                                            <td class="text-center" width="10%">{{ $item->req_no }}</td>
                                           <td class="text-center" width="10%">{{ $item->money_billno }}</td>

                                                <td class="text-center" width="5%">
                                                    <div class="dropdown d-inline-block">
                                                        <button type="button" aria-haspopup="true" aria-expanded="false" data-bs-toggle="dropdown" class="me-2 dropdown-toggle btn btn-outline-secondary btn-sm">
                                                            ทำรายการ
                                                        </button>
                                                        <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu-hover-link dropdown-menu">
                                                            <button type="button"class="dropdown-item menu edit_data text-success"
                                                                value="{{ $item->acc_1102050102_603_id }}"
                                                                data-bs-toggle="tooltip" data-bs-placement="left"
                                                                title="ตัด STM">
                                                                <i class="fa-solid fa-clipboard-check me-2 text-success" style="font-size:13px"></i>
                                                                <span>ตัด STM</span>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </td>
                                        </tr> --}}

                                        <?php
                                        $total1 = $total1 + $item->debit_total;
                                        $total2 = $total2 + $item->recieve_true;
                                        $total3 = $total3 + $item->nhso_ownright_pid;
                                ?>

                                @endforeach

                            </tbody>
                            <tr style="background-color: #f3fca1">
                                <td colspan="6" class="text-end" style="background-color: #fca1a1"></td>
                                <td class="text-end" style="background-color: #47A4FA"><label for="" style="color: #FFFFFF">{{ number_format($total1, 2) }}</label></td>
                                <td colspan="1" class="text-end" style="background-color: #fca1a1"></td>
                                <td class="text-end" style="background-color: #FCA533" ><label for="" style="color: #FFFFFF">{{ number_format($total2, 2) }}</label></td>
                                <td class="text-end" style="background-color: #44E952"><label for="" style="color: #FFFFFF">{{ number_format($total3, 2) }}</label> </td>
                                <td colspan="3" class="text-end" style="background-color: #fca1a1"></td>
                            </tr>
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

            $('.PulldataAll').click(function() {
                var startdate = $('#startdate').val();
                var enddate = $('#enddate').val();

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
                                    url: "{{ url('account_603_syncall_date') }}",
                                    type: "POST",
                                    dataType: 'json',
                                    data: {startdate,enddate},
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


        });
    </script>
@endsection
