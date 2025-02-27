@extends('layouts.fdh')
@section('title', 'PK-OFFICE || FDH')
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
        border-top: 10px #0ca886 solid;
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
    .modal-dis {
        width: 1350px;
        margin: auto;
    }
    @media (min-width: 1200px) {
        .modal-xlg {
            width: 90%;
        }
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

    <form action="{{ url('fdh_authen') }}" method="GET">
        @csrf
    <div class="row">
            <div class="col-md-3">
                <h4 class="card-title" style="color:rgba(21, 177, 164, 0.871)">Detail Financial Data Hub</h4>
                <p class="card-title-desc">รายละเอียดข้อมูล FDH</p>
            </div>
            <div class="col"></div>
            <div class="col-md-1 text-end mt-2">วันที่</div>
            <div class="col-md-4 text-end">
                {{-- <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker1'> --}}
                    <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker1'>
                    <input type="text" class="form-control card_fdh_4" name="startdate" id="datepicker" placeholder="Start Date" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                    data-date-language="th-th" value="{{ $startdate }}" required/>
                <input type="text" class="form-control card_fdh_4" name="enddate" placeholder="End Date" id="datepicker2" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                    data-date-language="th-th" value="{{ $enddate }}"/>

                <button type="submit" class="btn-icon btn-shadow btn-dashed btn btn-outline-info">
                    <i class="fa-solid fa-magnifying-glass text-info me-2"></i>
                    ค้นหา
                </button>
                    </form>

                    {{-- <button type="button" class="btn-icon btn-shadow btn-dashed btn btn-outline-success card_fdh_4 Pulldata"  data-url="{{url('fdh_authen_pull')}}">
                        <i class="fa-solid fa-spinner text-success me-2"></i>
                        ดึง Authen
                    </button> --}}

                </div>
            </div>
    </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card card_fdh_4">
                    <div class="card-header">
                        รายชื่อที่ยังไม่มี AUTHEN
                        <div class="btn-actions-pane-right">

                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                 <!-- Nav tabs -->
                                 <ul class="nav nav-tabs mb-0" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-bs-toggle="tab" href="#authen" role="tab" style="background-color: rgb(210, 252, 238)">
                                            <span class="d-block d-sm-none"> <img src="{{ asset('images/Office_new.png') }}" height="35px" width="35px"></span>
                                            <span class="d-none d-sm-block">AUTHEN(PG0060001)</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" href="#authenti" role="tab" style="background-color: rgb(178, 214, 252)">
                                            <span class="d-block d-sm-none"> <img src="{{ asset('images/Office_new.png') }}" height="35px" width="35px"></span>
                                            <span class="d-none d-sm-block">AUTHEN(PG0130001)</span>
                                        </a>
                                    </li>
                                    {{-- <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" href="#endpoint" role="tab" style="background-color: rgb(252, 220, 232)">
                                            <span class="d-block d-sm-none"><img src="{{ asset('images/chicken_new.png') }}" height="35px" width="35px"></span>
                                            <span class="d-none d-sm-block">ENDPOINT</span>
                                        </a>
                                    </li> --}}
                                </ul>
                                  <!-- Tab panes -->
                                <div class="tab-content text-muted">
                                    <div class="tab-pane active" id="authen" role="tabpanel" style="background-color: rgb(231, 255, 249)">
                                        <table id="example" class="table table-sm" style="width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">ลำดับ</th>
                                                    <th width="5%" class="text-center"><input type="checkbox" class="fdhcheckbox" name="stamp" id="stamp"> </th>
                                                    <th class="text-center" width="10%">vstdate</th>
                                                    <th class="text-center" width="10%">cid</th>
                                                    <th class="text-center" width="10%">vn</th>
                                                    <th class="text-center" width="5%">hn</th>
                                                    <th class="text-center" width="5%">pttype</th>
                                                    <th class="text-center">ptname</th>
                                                    <th class="text-center" width="10%">CLAIM CODE</th>
                                                    <th class="text-center" width="10%">ช่องทางการขอ</th>
                                                    <th class="text-center" width="10%">Staff</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $number = 0; ?>
                                                @foreach ($data_authen as $item)
                                                    <?php $number++; ?>
                                                        <tr height="20" style="font-size: 13px;">
                                                            <td class="text-center" width="5%">{{ $number}}</td>
                                                            @if ($item->auth_code != '')
                                                            <td class="text-center" width="5%">
                                                                <input class="form-check-input" type="checkbox" id="flexCheckDisabled" disabled>
                                                            </td>
                                                            @else
                                                                <td class="text-center" width="5%"><input type="checkbox" class="fdhcheckbox sub_chk" data-id="{{$item->vn}}"> </td>
                                                            @endif
                                                            <td class="text-center" width="9%">{{ $item->vstdate }}</td>
                                                            <td class="text-center" width="10%">{{ $item->cid }}</td>
                                                            <td class="text-center" width="10%">{{ $item->vn }}</td>
                                                            <td class="text-center" width="5%">{{ $item->hn }}</td>
                                                            <td class="text-center" width="5%">{{ $item->pttype }}</td>
                                                            <td class="text-start">{{ $item->fullname }}</td>
                                                            <td class="text-center" width="9%">{{ $item->auth_code }}</td>
                                                            <td class="text-center" width="9%">{{ $item->repauthen }}</td>
                                                            <td class="text-start" width="10%">{{ $item->staff }}</td>
                                                        </tr>
                                                @endforeach

                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="tab-pane" id="authenti" role="tabpanel" style="background-color: rgb(218, 242, 253)">
                                        <div class="table-responsive">
                                            <table id="example2" class="table table-sm" style="width: 100%;">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">ลำดับ</th>
                                                        <th width="5%" class="text-center"><input type="checkbox" class="fdhcheckbox" name="stamp2" id="stamp2"> </th>
                                                        <th class="text-center">vstdate</th>
                                                        <th class="text-center">cid</th>
                                                        <th class="text-center">vn</th>
                                                        <th class="text-center">hn</th>
                                                        <th class="text-center">pttype</th>
                                                        <th class="text-center">ptname</th>
                                                        <th class="text-center">CLAIM CODE</th>
                                                        <th class="text-center">ช่องทางการขอ</th>
                                                        <th class="text-center">Staff</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $number2 = 0; ?>
                                                    @foreach ($data_authenti as $item2)
                                                        <?php $number2++; ?>

                                                            <tr height="20" style="font-size: 13px;">
                                                                <td class="text-center" width="5%">{{ $number2}}</td>
                                                                @if ($item2->auth_code != '')
                                                                <td class="text-center" width="5%">
                                                                    <input class="form-check-input" type="checkbox" id="flexCheckDisabled" disabled>
                                                                </td>
                                                                @else
                                                                    <td class="text-center" width="5%"><input type="checkbox" class="fdhcheckbox sub_chk2" data-id="{{$item2->vn}}"> </td>
                                                                @endif
                                                                <td class="text-center" width="9%">{{ $item2->vstdate }}</td>
                                                                <td class="text-center" width="10%">{{ $item2->cid }}</td>
                                                                <td class="text-center" width="10%">{{ $item2->vn }}</td>
                                                                <td class="text-center" width="5%">{{ $item2->hn }}</td>
                                                                <td class="text-center" width="5%">{{ $item2->pttype }}</td>
                                                                <td class="text-start">{{ $item2->fullname }}</td>
                                                                <td class="text-center" width="9%">{{ $item2->auth_code }}</td>
                                                                <td class="text-center" width="9%">{{ $item2->repauthen }}</td>
                                                                <td class="text-start" width="10%">{{ $item2->staff }}</td>
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
            // var table = $('#example2').DataTable({
            //     scrollY: '60vh',
            //     scrollCollapse: true,
            //     scrollX: true,
            //     "autoWidth": false,
            //     "pageLength": 15,
            //     "lengthMenu": [10,25,50,100,150,200,300,400,500],
            // });
            // var table = $('#example3').DataTable({
            //     scrollY: '60vh',
            //     scrollCollapse: true,
            //     scrollX: true,
            //     "autoWidth": false,
            //     "pageLength": 15,
            //     "lengthMenu": [10,25,50,100,150,200,300,400,500],
            // });
        $('#datepicker').datepicker({
            format: 'yyyy-mm-dd'
        });
        $('#datepicker2').datepicker({
            format: 'yyyy-mm-dd'
        });

        // $('#example').DataTable();
        $('#hospcode').select2({
            placeholder: "--เลือก--",
            allowClear: true
        });
        $('#stamp').on('click', function(e) {
                    if($(this).is(':checked',true))
                    {
                        $(".sub_chk").prop('checked', true);
                    } else {
                        $(".sub_chk").prop('checked',false);
                    }
        });
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $("#spinner-div").hide(); //Request is complete so hide spinner

        $('.Pulldata').on('click', function(e) {
            // alert('oo');
            var allValls = [];
            // $(".sub_destroy:checked").each(function () {
            $(".sub_chk:checked").each(function () {
                allValls.push($(this).attr('data-id'));
            });
            if (allValls.length <= 0) {
                // alert("SSSS");
                Swal.fire({
                    position: "top-end",
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
                    position: "top-end",
                    title: 'Are you Want Pull sure?',
                    text: "คุณต้องการ Pull รายการนี้ใช่ไหม!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Pull it.!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            var check = true;
                            if (check == true) {
                                var join_selected_values = allValls.join(",");
                                // alert(join_selected_values);
                                $("#overlay").fadeIn(500);　
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
                                                    position: "top-end",
                                                    title: 'ดึงข้อมูลสำเร็จ',
                                                    text: "You Pull data success",
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

        $('#Pulldata222').click(function() {
                var startdate = $('#datepicker').val();
                var enddate = $('#datepicker2').val();
                Swal.fire({
                        title: 'ต้องการดึงข้อมูลใช่ไหม ?',
                        text: "You Warn Pull Data!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, pull it!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $("#overlay").fadeIn(300);　
                                $("#spinner").show(); //Load button clicked show spinner

                                $.ajax({
                                    url: "{{ route('fdh.fdh_authen_pull') }}",
                                    type: "POST",
                                    dataType: 'json',
                                    data: {startdate,enddate},
                                    success: function(data) {
                                        if (data.status == 200) {
                                            Swal.fire({
                                                position: "top-end",
                                                title: 'ดึงข้อมูลสำเร็จ',
                                                text: "You Pull data success",
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
                                    },
                                });

                            }
                })
            });



        });

    </script>
@endsection
