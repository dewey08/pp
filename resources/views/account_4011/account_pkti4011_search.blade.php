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
            border: 15px #ddd solid;
            border-top: 10px rgb(250, 128, 124) solid;
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
    {{-- <div class="container-fluid"> 
         <form action="{{ route('acc.account_pkti4011_search') }}" method="GET">
            @csrf
        <div class="row"> 
                    <div class="col-md-4">
                        <h4 class="card-title" style="color:rgb(10, 151, 85)">Detail Account ผัง 1102050101.4011</h4>
                        <p class="card-title-desc">รายละเอียดตั้งลูกหนี้</p>
                    </div>
                    <div class="col"></div>
                    <div class="col-md-4"> 
                            <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker6'>
                                <input type="text" class="form-control inputacc" name="startdate" id="datepicker" placeholder="Start Date"
                                    data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                                    data-date-language="th-th" value="{{ $startdate }}" required/>
                                <input type="text" class="form-control inputacc" name="enddate" placeholder="End Date" id="datepicker2"
                                    data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                                    data-date-language="th-th" value="{{ $enddate }}" required/>
                                    
                                <button type="submit" class="ladda-button btn-pill btn btn-primary cardacc" data-style="expand-left">
                                    <span class="ladda-label"> <i class="fa-solid fa-magnifying-glass text-white me-2"></i>ค้นหา</span>
                                    <span class="ladda-spinner"></span>
                                </button> 
                            </form>
                                <button type="button" class="ladda-button me-2 btn-pill btn btn-primary btn-sm input_new Savestamp" data-url="{{url('account_804_send')}}">
                                    <img src="{{ asset('images/send_data.png') }}" class="me-2 ms-2" height="18px" width="18px">
                                    ส่งลูกหนี้บัญชี
                                </button>
                            </div> 
                  
                    </div>
 
        </div>
         
    </div> <!-- container-fluid --> --}}

    <form action="{{ URL('account_pkti4011_search') }}" method="GET">
        @csrf
    <div class="row">
        <div class="col-md-4">
            <h5 class="card-title" style="color:rgb(247, 31, 95)">Search Detail 1102050101.4011</h5>
            <p class="card-title-desc">ค้นหาลูกหนี้ ผัง 1102050101.4011</p>
        </div>
        <div class="col"></div>
        <div class="col-md-1 text-end mt-2">วันที่</div>
        <div class="col-md-5 text-end">
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
                </form>
                <button type="button" class="ladda-button me-2 btn-pill btn btn-primary btn-sm input_new Savestamp" data-url="{{url('account_pkti4011_send')}}">
                    <img src="{{ asset('images/send_data.png') }}" class="me-2 ms-2" height="18px" width="18px">
                    ส่งลูกหนี้บัญชี
                </button>
        </div>
    </div>
</div>

        <div class="row">
            <div class="col-md-12">
                <div class="card card_audit_4c">
                    
                    <div class="card-body">
                        {{-- <input type="hidden" name="months" id="months" value="{{$months}}"> --}}
                        {{-- <input type="hidden" name="year" id="year" value="{{$year}}">  --}}
                        <table id="datatable-buttons" class="table table-sm table-striped table-bordered dt-responsive nowrap myTable"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th class="text-center">ลำดับ</th> 
                                    <th width="5%" class="text-center"><input type="checkbox" class="dcheckbox_" name="stamp" id="stamp"> </th>
                                    <th class="text-center">ส่งลูกหนี้</th>
                                    <th class="text-center">vn</th>
                                    <th class="text-center">hn</th>
                                    <th class="text-center">cid</th>
                                    <th class="text-center">ptname</th>
                                    <th class="text-center">vstdate</th> 
                                    <th class="text-center">pttype</th>   
                                    <th class="text-center">ลูกหนี้</th> 
                                    <th class="text-center">STM</th>  
                                    <th class="text-center">STMdoc</th>  
                                </tr>
                            </thead>
                            <tbody>
                                <?php $number = 1; 
                                 $total1 = 0;
                                $total2 = 0;
                                $total3 = 0;
                                $total4 = 0;
                                ?>
                                @foreach ($datashow as $item) 

                                    <tr>
                                        <td class="text-font" style="text-align: center;" width="4%">{{ $number++ }} </td> 
                                        <td class="text-center" width="5%"><input type="checkbox" class="dcheckbox_ sub_chk" data-id="{{$item->acc_1102050101_4011_id}}"> </td>
                                        <td class="text-center" width="5%">
                                            @if ($item->sendactive =='N') 
                                                <img src="{{ asset('images/Cancel_new2.png') }}" height="23px" width="23px">
                                            @else
                                            <img src="{{ asset('images/check_trueinfo3.png') }}" height="23px" width="23px"> 
                                            @endif
                                        </td>
                                        <td class="text-center" width="8%">{{ $item->vn }}</td>
                                        <td class="text-center" width="5%">{{ $item->hn }}</td>
                                        <td class="text-center" width="10%">{{ $item->cid }}</td>
                                        <td class="p-2">{{ $item->ptname }}</td>
                                        <td class="text-center" width="8%">{{ $item->vstdate }}</td>
                                        <td class="text-center" width="5%">{{ $item->pttype }}</td>
                                        
                                        <td class="text-end" style="color:rgb(73, 147, 231)" width="7%"> {{ number_format($item->debit_total, 2) }}</td> 
                                        @if ($item->stm_total < $item->debit_total)
                                            <td class="text-end" style="color:rgb(243, 74, 45)" width="7%"> {{ number_format($item->stm_total, 2) }}</td>
                                        @else
                                            <td class="text-end" style="color:rgb(6, 187, 157)" width="7%"> {{ number_format($item->stm_total, 2) }}</td>
                                        @endif
                                        <td class="text-center" width="14%">{{ $item->STMdoc }}</td>
                                    </tr>
                                    <?php
                                                $total1 = $total1 + $item->debit_total;
                                                $total2 = $total2 + $item->stm_total; 
                                        ?>
                                @endforeach

                            </tbody>
                            <tr style="background-color: #f3fca1">
                                <td colspan="9" class="text-end" style="background-color: #fca1a1"></td>
                                <td class="text-end" style="background-color: #47A4FA"><label for="" style="color: #0c0c0c">{{ number_format($total1, 2) }}</label></td>
                                <td class="text-end" style="background-color: #06b9a2" ><label for="" style="color: #0c0b0b">{{ number_format($total2, 2) }}</label></td>
                                <td class="text-center" style="background-color: #fca1a1"></td> 
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
                    Swal.fire({ position: "top-end",
                        title: 'คุณยังไม่ได้เลือกรายการ ?',
                        text: "กรุณาเลือกรายการก่อน",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        }).then((result) => {

                        })
                } else {
                    Swal.fire({ position: "top-end",
                        title: 'Are you sure?',
                        text: "คุณต้องการส่งลูกหนี้รายการนี้ใช่ไหม!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, Debtor it.!'
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
                                                    Swal.fire({ position: "top-end",
                                                        title: 'ส่งลูกหนี้สำเร็จ',
                                                        text: "You Send Debtor data success",
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
                }
            });

            $("#spinner-div").hide(); //Request is complete so hide spinner
        
                  
    </script>
@endsection
