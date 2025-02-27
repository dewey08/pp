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
                    <h4 class="mb-sm-0" style="color:rgb(247, 31, 95)">Detail 1102050102.603</h4>

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
                <div class="card card_audit_4c" style="background-color: rgb(246, 235, 247)">
                    {{-- <div class="card-header">
                    รายละเอียด 1102050102_603
                    <div class="btn-actions-pane-right">
                        <button type="button" class="me-2 btn-icon btn-shadow btn-dashed btn btn-outline-danger PulldataAll" >
                            <i class="fa-solid fa-arrows-rotate text-danger me-2"></i>
                            Sync Data All
                        </button>
                    </div>
                    </div> --}}
                    <div class="card-body">

                        <div class="row mb-2">
                            <div class="col"></div>
                            <div class="col-md-2 text-end">
                                {{-- <button type="button"
                                    class="ladda-button me-2 btn-pill btn btn-sm btn-danger cardacc PulldataAll">
                                    <i class="fa-solid fa-arrows-rotate text-write me-2"></i>
                                    Sync Data All
                                </button> --}}
                                <button type="button" class="ladda-button me-2 btn-pill btn btn-danger btn-sm cardacc Savestamp" data-url="{{url('account_603_syncall')}}">
                                    {{-- <img src="{{ asset('images/Stam_white.png') }}" class="me-2 ms-2" height="18px" width="18px"> --}}
                                    <i class="fa-solid fa-arrows-rotate text-write me-2"></i>
                                    Sync Data All
                                </button>
                            </div>
                        </div>
                            {{-- <table id="datatable-buttons" class="table table-sm table-striped table-bordered dt-responsive nowrap myTable" style="border-collapse: collapse; border-spacing: 0; width: 100%;"> --}}
                            <table id="datatable-buttons" class="table table-sm table-striped table-bordered" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th class="text-center">ลำดับ</th>
                                    <th width="5%" class="text-center"><input type="checkbox" class="dcheckbox_" name="stamp" id="stamp"> </th>
                                    <th class="text-center">an</th>
                                    <th class="text-center">hn</th>
                                    <th class="text-center">pttype</th>
                                    <th class="text-center">ptname</th>
                                    <th class="text-center">dchdate</th>
                                    <th class="text-center">ลูกหนี้</th>
                                    <th class="text-center" width="5%">รับชำระ</th>
                                    <th class="text-center">ส่วนต่าง</th>
                                    <th class="text-center">เลขที่หนังสือ</th>
                                    <th class="text-center">วันที่</th>
                                    <th class="text-center">บริษัท</th>

                                    {{-- <th class="text-center">รับชำระ</th> --}}
                                    {{-- <th class="text-center">ส่วนต่าง</th> --}}
                                    {{-- <th class="text-center">เลขที่ใบเสร็จ</th> --}}
                                    {{-- <th class="text-center">วันที่ลงรับ</th> --}}
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
                                            <td class="text-font" style="text-align: center;" width="4%">{{ $number }} </td>
                                            <td class="text-center" width="5%"><input type="checkbox" class="dcheckbox_ sub_chk" data-id="{{$item->acc_1102050102_603_id}}"> </td>
                                            <td class="text-center" width="6%">{{ $item->an }}</td>
                                            <td class="text-center" width="5%">{{ $item->hn }}</td>
                                            <td class="text-center" width="10%">{{ $item->pttype }}</td>
                                            <td class="text-start">{{ $item->ptname }}</td>
                                            <td class="text-center" width="6%">{{ $item->dchdate }}</td>
                                            <td class="text-center" style="color:rgb(73, 147, 231)" width="6%"> {{ number_format($item->debit_total, 2) }}</td>

                                            {{-- <td class="text-center" width="6%" style="color: #06a513">{{ $item->nhso_ownright_pid }}</td> --}}
                                            <td class="text-center" width="6%" style="color: #06a513">{{ $item->nhso_ownright_pid }}</td>
                                            <td class="text-center" width="6%" style="color: #06a513">
                                                @if ($item->debit_total >= $item->nhso_ownright_pid)
                                                @if ($item->debit_total-$item->nhso_ownright_pid =='0')
                                                {{ $item->debit_total-$item->nhso_ownright_pid }}
                                                @else
                                                -{{ $item->debit_total-$item->nhso_ownright_pid }}
                                                @endif

                                                @else
                                                {{ $item->debit_total-$item->nhso_ownright_pid }}
                                                @endif

                                            </td>
                                            <td class="text-center" width="12%">
                                                @if ($item->nhso_docno != '')
                                                    {{-- <button type="button"
                                                        class="me-2 btn-icon btn-shadow btn-dashed btn btn-outline-success">
                                                        <i class="fa-solid fa-book-open text-success me-2"></i>
                                                        {{ $item->nhso_docno }}
                                                    </button> --}}
                                                    <button type="button" class="btn-icon btn-sm btn-shadow btn-dashed btn btn-outline-success">
                                                        {{-- <i class="fa-solid fa-book-open text-success me-2"></i> --}}
                                                        <img src="{{ asset('images/book_new.png') }}" class="me-2 ms-2" height="18px" width="18px">
                                                        {{ $item->nhso_docno }}
                                                    </button>
                                                @else
                                                    {{-- <button type="button"
                                                        class="me-2 btn-icon btn-shadow btn-dashed btn btn-outline-warning">
                                                        <i class="fa-solid fa-book-open text-warning me-2"></i>
                                                        ยังไม่ได้ลงเลขหนังสือ
                                                    </button> --}}
                                                    <button type="button"
                                                    class="me-2 btn-icon btn-sm btn-shadow btn-dashed btn btn-outline-warning">
                                                    {{-- <i class="fa-solid fa-book-open text-warning me-2"></i> --}}
                                                    <img src="{{ asset('images/book_new.png') }}" class="me-2 ms-2" height="18px" width="18px">
                                                    ยังไม่ได้ลงเลขหนังสือ
                                                </button>
                                                @endif
                                            </td>
                                            <td class="text-center" width="7%">{{ $item->nhso_ownright_name }}</td>

                                            <td class="text-start" width="10%">{{ $item->nhso_govname }}</td>

                                            {{-- <td class="text-center" width="10%">{{ $item->recieve_no }}</td> --}}
                                            {{-- <td class="text-center" width="7%" style="color:rgb(216, 95, 14)"> {{ number_format($item->recieve_true, 2) }}</td> --}}
                                            {{-- <td class="text-center" width="6%" style="color:rgb(135, 14, 216)"> 0.00</td> --}}
                                            {{-- <td class="text-center" width="6%" style="color:rgb(135, 14, 216)"> 0.00</td> --}}
                                            {{-- <td class="text-center" width="7%" style="color:rgb(135, 14, 216)"> </td> --}}
                                            {{-- <td class="text-center" width="6%" style="color:rgb(135, 14, 216)"> </td> --}}

                                        </tr>

                                        <?php
                                                $total1 = $total1 + $item->debit_total;
                                                $total2 = $total2 + $item->nhso_ownright_pid;
                                                // $total3 = $total3 + $item->nhso_ownright_pid;
                                        ?>


                                @endforeach

                            </tbody>
                            <tr style="background-color: #f3fca1">
                                <td colspan="7" class="text-end" style="background-color: #fca1a1"></td>
                                <td class="text-end" style="background-color: #47A4FA"><label for="" style="color: #0c71cf">{{ number_format($total1, 2) }}</label></td>
                                <td class="text-end" style="background-color: #04927f" ><label for="" style="color: #04927f">{{ number_format($total2, 2) }}</label></td>
                                {{-- <td colspan="1" class="text-end" style="background-color: #fca1a1"></td> --}}
                                {{-- <td class="text-end" style="background-color: #FCA533" ><label for="" style="color: #f1135d">{{ number_format($total2, 2) }}</label></td> --}}
                                {{-- <td class="text-end" style="background-color: #44E952"><label for="" style="color: #f1135d">{{ number_format($total3, 2) }}</label> </td> --}}
                                <td colspan="7" class="text-end" style="background-color: #fca1a1"></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>


    <input type="hidden" name="months" id="months" value="{{$months}}">
    <input type="hidden" name="year" id="year" value="{{$year}}">


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

            $('#stamp').on('click', function(e) {
                if($(this).is(':checked',true))
                {
                    $(".sub_chk").prop('checked', true);
                } else {
                    $(".sub_chk").prop('checked',false);
                }
            });

            $('.Savestamp').on('click', function(e) {
                // alert('oo');
                var allValls = [];
                $(".sub_chk:checked").each(function () {
                    allValls.push($(this).attr('data-id'));
                });
                if (allValls.length <= 0) {
                    // alert("SSSS");
                    Swal.fire({
                        title: 'คุณยังไม่ได้เลือกรายการ ?',
                        text: "กรุณาเลือกรายการก่อน",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        }).then((result) => {

                        })
                } else {
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "คุณต้องการ Sync รายการนี้ใช่ไหม!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, Sync it.!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                var check = true;
                                if (check == true) {
                                    var join_selected_values = allValls.join(",");
                                    // alert(join_selected_values);
                                    $("#overlay").fadeIn(300);　
                                    $("#spinner").show(); //Load button clicked show spinner

                                    $.ajax({
                                        url:$(this).data('url'),
                                        type: 'POST',
                                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                        data: 'ids='+join_selected_values,
                                        success:function(data){
                                                if (data.status == 200) {
                                                    $(".sub_chk:checked").each(function () {
                                                        $(this).parents("tr").remove();
                                                    });
                                                    Swal.fire({
                                                        title: 'Sync สำเร็จ',
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
                                                } else {

                                                }


                                            // } else {
                                            //     alert("Whoops Something went worng all");
                                            // }
                                        }
                                    });
                                    $.each(allValls,function (index,value) {
                                        $('table tr').filter("[data-row-id='"+value+"']").remove();
                                    });
                                }
                            }
                        })
                    // var check = confirm("Are you want ?");
                }
            });

            $('.PulldataAll').click(function() {
                var months = $('#months').val();
                var year = $('#year').val();
                // alert(months);
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
                                    url: "{{ url('account_603_syncall') }}",
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


        });
    </script>
@endsection
