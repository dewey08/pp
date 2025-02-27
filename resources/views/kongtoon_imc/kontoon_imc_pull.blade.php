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
        use App\Http\Controllers\StaticController;
        use App\Models\Opitemrece217;

    ?>
    <style>
        #button{
               display:block;
               margin:20px auto;
               padding:30px 30px;
               background-color:#eee;
               border:solid #ccc 1px;
               cursor: pointer;
               }
               #overlay{
               position: fixed;
               top: 0;
               z-index: 100;
               width: 100%;
               height:100%;
               display: none;
               background: rgba(0,0,0,0.6);
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
               border-top: 10px rgb(250, 128, 124) solid;
               border-radius: 50%;
               animation: sp-anime 0.8s infinite linear;
               }
               @keyframes sp-anime {
               100% {
                   transform: rotate(390deg);
               }
               }
               .is-hide{
               display:none;
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
        <form action="{{ route('acc.kontoon_imc_pull') }}" method="GET">
            @csrf
        <div class="row">
            <div class="col-md-4">
                <h5 class="card-title" style="color:rgb(247, 31, 95)">Process data 4301020105.228</h5>
                <p class="card-title-desc">ประมวลผลข้อมูล ตั้งลูกหนี้/เคลม ผัง 4301020105.228</p>
            </div>
            <div class="col"></div>
            <div class="col-md-1 text-end mt-2">วันที่</div>
            <div class="col-md-4 text-end">
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
                        <button type="button" class="ladda-button me-2 btn-pill btn btn-sm btn-primary cardacc" id="Pulldata">
                            <span class="ladda-label">
                                <img src="{{ asset('images/pull_datawhite.png') }}" class="me-2 ms-2" height="18px" width="18px">
                                ดึงข้อมูล
                            </span>
                        </button>
            </div>
        </div>
    </div>

        <div class="row">
            <div class="col-xl-12">
                <div class="card card_audit_4c" style="background-color: rgb(246, 235, 247)">
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-md-6 text-start">
                              {{-- @if ($activeclaim == 'Y')
                                <button class="ladda-button me-2 btn-pill btn btn-info btn-sm cardacc" onclick="check()">Check</button>
                                <input type="checkbox" id="myCheck" class="dcheckbox_ me-2" checked>
                                <button class="ladda-button me-2 btn-pill btn btn-danger btn-sm input_new" onclick="uncheck()">Uncheck</button>
                              @else
                                <button class="ladda-button me-2 btn-pill btn btn-info btn-sm input_new" onclick="check()">Check</button>
                                <input type="checkbox" id="myCheck" class="dcheckbox_ me-2">
                                <button class="ladda-button me-2 btn-pill btn btn-danger btn-sm input_new" onclick="uncheck()">Uncheck</button>
                              @endif
                                <button type="button" class="ladda-button me-2 btn-pill btn btn-sm btn-warning input_new Claim" data-url="{{url('account_401_claim')}}">
                                    <img src="{{ asset('images/loading_white.png') }}" class="me-2 ms-2" height="18px" width="18px">
                                   ประมวลผล
                               </button>
                               <a href="{{url('account_401_claim_zip')}}" class="ladda-button me-2 btn-pill btn btn-sm btn-success input_new">
                                <img src="{{ asset('images/zipwhite.png') }}" class="me-2 ms-2" height="18px" width="18px">
                                    Zip
                                </a>
                                <button type="button" class="ladda-button me-2 btn-pill btn btn-sm input_new" id="Apinhso" style="background-color: rgb(241, 7, 136);color:#ffffff">
                                    <img src="{{ asset('images/Apiwhite.png') }}" class="me-2 ms-2" height="18px" width="18px">
                                    API NHSO
                                </button> --}}
                            </div>

                            <div class="col"></div>
                            <div class="col-md-4 text-end">

                                <button type="button" class="ladda-button me-2 btn-pill btn btn-info btn-sm input_new Check_sit" data-url="{{url('kontoon_imc_checksit')}}">
                                    <img src="{{ asset('images/Check_sitwhite.png') }}" class="me-2 ms-2" height="18px" width="18px">
                                    ตรวจสอบสิทธิ์
                                </button>

                                <button type="button" class="ladda-button me-2 btn-pill btn btn-primary btn-sm input_new Savestamp" data-url="{{url('kontoon_imc_stam')}}">
                                    <img src="{{ asset('images/Stam_white.png') }}" class="me-2 ms-2" height="18px" width="18px">
                                    ตั้งลูกหนี้
                                </button>
                                <button type="button" class="ladda-button me-2 btn-pill btn btn-danger btn-sm input_new Destroystamp" data-url="{{url('kontoon_imc_destroy')}}">
                                    <img src="{{ asset('images/removewhite.png') }}" class="me-2 ms-2" height="18px" width="18px">
                                    ลบ
                                </button>

                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                    <!-- Nav tabs -->
                                <ul class="nav nav-tabs" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-bs-toggle="tab" href="#Main" role="tab">
                                            <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                            <span class="d-none d-sm-block">Detail</span>
                                        </a>
                                    </li>
                                    {{-- <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" href="#OPD" role="tab">
                                            <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                                            <span class="d-none d-sm-block">OPD</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" href="#ORF" role="tab">
                                            <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                                            <span class="d-none d-sm-block">ORF</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" href="#OOP" role="tab">
                                            <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                                            <span class="d-none d-sm-block">OOP</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" href="#ODX" role="tab">
                                            <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                                            <span class="d-none d-sm-block">OOP</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" href="#IDX" role="tab">
                                            <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                                            <span class="d-none d-sm-block">IDX</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" href="#IPD" role="tab">
                                            <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                                            <span class="d-none d-sm-block">IPD</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" href="#IRF" role="tab">
                                            <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                                            <span class="d-none d-sm-block">IRF</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" href="#AER" role="tab">
                                            <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                                            <span class="d-none d-sm-block">AER</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" href="#IOP" role="tab">
                                            <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                                            <span class="d-none d-sm-block">IOP</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" href="#ODX" role="tab">
                                            <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                                            <span class="d-none d-sm-block">ODX</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" href="#PAT" role="tab">
                                            <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                                            <span class="d-none d-sm-block">PAT</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" href="#CHT" role="tab">
                                            <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                                            <span class="d-none d-sm-block">CHT</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" href="#CHA" role="tab">
                                            <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                                            <span class="d-none d-sm-block">CHA</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" href="#INS" role="tab">
                                            <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                                            <span class="d-none d-sm-block">INS</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" href="#ADP" role="tab">
                                            <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                                            <span class="d-none d-sm-block">ADP</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" href="#DRU" role="tab">
                                            <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                                            <span class="d-none d-sm-block">DRU</span>
                                        </a>
                                    </li> --}}
                                </ul>
                                <!-- Tab panes -->
                                <div class="tab-content p-3 text-muted">

                                    <div class="tab-pane active" id="Main" role="tabpanel">
                                        <p class="mb-0">
                                            <div class="table-responsive">
                                                <table id="scroll-vertical-datatable" class="table table-sm table-striped dt-responsive nowrap w-100">
                                                    {{-- <table id="example" class="table table-sm table-striped table-bordered dt-responsive nowrap myTable" style="border-collapse: collapse; border-spacing: 0; width: 100%;">   --}}
                                                    <thead>
                                                        <tr>
                                                            <th width="5%" class="text-center">ลำดับ</th>
                                                            <th width="5%" class="text-center"><input type="checkbox" class="dcheckbox_" name="stamp" id="stamp"> </th>
                                                            <th class="text-center" width="5%">ตั้งลูกหนี้</th>
                                                            {{-- <th class="text-center" width="5%">
                                                                <span class="badge" style="background-color: #05a0b4">{{ $count_claim }}</span> เคลม
                                                                <span class="badge" style="background-color: #f84848">{{ $count_noclaim }}</span>
                                                            </th> --}}
                                                            <th class="text-center" style="width: 10%;">pdx</th>

                                                            <th class="text-center" width="5%">กายภาพ</th>
                                                            <th class="text-center" width="5%">hn</th>
                                                            <th class="text-center" width="10%">cid</th>

                                                            <th class="text-center">ptname</th>
                                                            <th class="text-center">vstdate</th>
                                                            <th class="text-center">pttype</th>
                                                            <th class="text-center">hospmain</th>
                                                            <th class="text-center">spsch</th>
                                                            <th class="text-center">ลูกหนี้</th>
                                                            <th class="text-center">Rep</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $i = 1; ?>
                                                        @foreach ($acc_debtor as $item)
                                                            <?php
                                                                if ($item->vn != '') {
                                                                    $datas = DB::connection('mysql10')->select(
                                                                    'SELECT v.vn SEQ,oo.presc_reason as DRUGREMARK
                                                                        FROM opitemrece v
                                                                        LEFT OUTER JOIN drugitems d on d.icode = v.icode
                                                                        LEFT OUTER JOIN vn_stat vv on vv.vn = v.vn
                                                                        LEFT OUTER JOIN ovst_presc_ned oo on oo.vn = v.vn
                                                                        WHERE v.vn IN("'.$item->vn.'")
                                                                        AND d.did is not null
                                                                        GROUP BY v.vn
                                                                ');
                                                                foreach ($datas as $key => $value) {
                                                                $drugmark = $value->DRUGREMARK;
                                                                }
                                                                } else {
                                                                    $drugmark = '';
                                                                }

                                                                $data_dent = Opitemrece217::where('vn',$item->vn)->where('income',"=","13")->sum('sum_price');
                                                                $datas_kay = Opitemrece217::where('vn',$item->vn)->where('income',"=","14")->sum('sum_price');
                                                                $data_ct   = Opitemrece217::where('vn',$item->vn)->where('income',"=","08")->sum('sum_price');

                                                                if ($datas_kay > 0) {
                                                                    $kayas = $datas_kay;
                                                                } else {
                                                                    $kayas = '';
                                                                }
                                                            ?>
                                                            <tr id="tr_{{$item->acc_debtor_id}}">
                                                                <td class="text-center" width="5%">{{ $i++ }}</td>
                                                                @if ($activeclaim == 'Y')
                                                                    @if ($item->debit_total == '' || $item->pdx =='')
                                                                        <td class="text-center" width="5%">
                                                                            <input class="form-check-input" type="checkbox" id="flexCheckDisabled" disabled>
                                                                        </td>
                                                                    @else
                                                                        <td class="text-center" width="5%"><input type="checkbox" class="dcheckbox_ sub_chk" data-id="{{$item->acc_debtor_id}}"> </td>
                                                                    @endif
                                                                @else
                                                                    <td class="text-center" width="5%"><input type="checkbox" class="dcheckbox_ sub_chk" data-id="{{$item->acc_debtor_id}}"> </td>
                                                                @endif

                                                                <td class="text-center" width="5%">
                                                                    @if ($item->stamp =='N')
                                                                        <img src="{{ asset('images/Cancel_new2.png') }}" height="23px" width="23px">
                                                                    @else
                                                                    <img src="{{ asset('images/check_trueinfo3.png') }}" height="23px" width="23px">
                                                                    @endif
                                                                </td>
                                                                {{-- <td class="text-center" width="5%">
                                                                    @if ($item->active_claim =='N')
                                                                    <img src="{{ asset('images/Cancel_new2.png') }}" height="23px" width="23px">
                                                                    @else
                                                                        <img src="{{ asset('images/check_trueinfo3.png') }}" height="23px" width="23px">
                                                                    @endif
                                                                </td> --}}
                                                                <td class="text-start" width="10%">
                                                                    @if ($item->pdx != NULL)
                                                                        <span class="bg-info badge">{{ $item->pdx }}</span>
                                                                    @else
                                                                        <span class="bg-warning badge">-</span>
                                                                    @endif
                                                                </td>

                                                                <td class="text-start" width="5%">
                                                                    @if ($kayas > 0)
                                                                        <span class="bg-success badge text-center">{{ $kayas }}</span>
                                                                    @else
                                                                        <span class="bg-danger badge text-center">-</span>
                                                                    @endif
                                                                </td>

                                                                <td class="text-start" width="5%">{{ $item->hn }}</td>
                                                                <td class="text-start" width="10%">{{ $item->cid }}</td>
                                                                <td class="text-start">{{ $item->ptname }}</td>


                                                                <td class="text-center" width="8%">{{ $item->vstdate }}</td>
                                                                <td class="text-center" style="color:rgb(73, 147, 231)" width="5%">{{ $item->pttype }}</td>
                                                                <td class="text-center" style="color:rgb(73, 147, 231)" width="5%">{{ $item->hospmain }}</td>
                                                                <td class="text-center" style="color:rgb(216, 95, 14)" width="5%">{{ $item->subinscl }}</td>

                                                                <td class="text-center" width="8%">
                                                                    @if ($item->debit_total < $item->rep_pay)
                                                                        <span class="bg-danger badge me-2"> {{ number_format($item->debit_total, 2) }}</span>
                                                                    @elseif($item->debit_total == $item->rep_pay)
                                                                        <span class="bg-success badge me-2"> {{ number_format($item->debit_total, 2) }}</span>
                                                                    @else
                                                                        <span class="bg-info badge me-2"> {{ number_format($item->debit_total, 2) }}</span>
                                                                    @endif
                                                                </td>
                                                                <td class="text-center" width="6%">
                                                                    @if ($item->rep_pay =='')
                                                                        <span class="bg-danger badge me-2">*-*</span>
                                                                    @else
                                                                        <span class="bg-success badge me-2">{{ number_format($item->rep_pay, 2) }}</span>
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </p>
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
       function check() {
        var onoff;
        document.getElementById("myCheck").checked = true;
        onoff = "Y";
          var _token=$('input[name="_token"]').val();
            $.ajax({
                    url:"{{route('acc.account_401_claimswitch')}}",
                    method:"GET",
                    data:{onoff:onoff,_token:_token},
                    success:function(data){
                        if (data.status == 200) {
                            Swal.fire({
                            position: "top-end",
                            icon: "success",
                            title: "Your open function success",
                            showConfirmButton: false,
                            timer: 1500
                            });

                            window.location.reload();

                        } else {

                        }
                }
            });

        }

        function uncheck() {
            document.getElementById("myCheck").checked = false;
            onoff = "N";
            var _token=$('input[name="_token"]').val();
            $.ajax({
                    url:"{{route('acc.account_401_claimswitch')}}",
                    method:"GET",
                    data:{onoff:onoff,_token:_token},
                    success:function(data){
                        if (data.status == 200) {
                            Swal.fire({
                            position: "top-end",
                            icon: "success",
                            title: "Your Close function success",
                            showConfirmButton: false,
                            timer: 1500
                            });

                            window.location.reload();

                        } else {

                        }
                }
            });

        }

        // function account_401_claimswitch(claim_active){
            // var nameVar = document.getElementById("claim_active").value;
            // var checkBox = document.getElementById(claim_active);
            // alert(checkBox);
            // var onoff;
            // if (checkBox.checked == true){
            //     onoff = "Y";
            // } else {
            //     onoff = "N";
            // }
            // var _token=$('input[name="_token"]').val();
            // $.ajax({
            //         url:"{{route('acc.account_401_claimswitch')}}",
            //         method:"GET",
            //         data:{onoff:onoff,claim_active:claim_active,_token:_token}
            // })
    //    }
        $(document).ready(function() {
            $('#example7').DataTable();
            $('#example8').DataTable();
            var table = $('#example21').DataTable({
                scrollY: '60vh',
                scrollCollapse: true,
                scrollX: true,
                "autoWidth": false,
                "pageLength": 10,
                "lengthMenu": [10,25,50,100,150,200,300,400,500],
            });
            var table = $('#example22').DataTable({
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
                        text: "คุณต้องการตั้งลูกหนี้รายการนี้ใช่ไหม!",
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
                                                        title: 'ตั้งลูกหนี้สำเร็จ',
                                                        text: "You Debtor data success",
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

            $("#spinner-div").hide(); //Request is complete so hide spinner

            $('#Pulldata').click(function() {
                var datepicker = $('#datepicker').val();
                var datepicker2 = $('#datepicker2').val();
                Swal.fire({ position: "top-end",
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
                                    url: "{{ route('acc.kontoon_imc_pulldata') }}",
                                    type: "POST",
                                    dataType: 'json',
                                    data: {
                                        datepicker,
                                        datepicker2
                                    },
                                    success: function(data) {
                                        if (data.status == 200) {
                                            Swal.fire({ position: "top-end",
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

            $('.Check_sit').click(function() {
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
                        position: "top-end",
                        title: 'Are you sure?',
                        text: "ต้องการตรวจสอบสอทธิ์ใช่ไหม!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'You Check Sit Data!.!'
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
                                                        position: "top-end",
                                                        title: 'เช็คสิทธิ์สำเร็จ',
                                                        text: "You Check sit success",
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

            $('.Claim').on('click', function(e) {
                // alert('oo');
                var allValls = [];
                // $(".sub_destroy:checked").each(function () {
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
                        title: 'Are you Want Process sure?',
                        text: "คุณต้องการ ประมวลผล รายการนี้ใช่ไหม!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, Process it.!'
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
                                                    // $(".sub_destroy:checked").each(function () {
                                                    $(".sub_chk:checked").each(function () {
                                                        $(this).parents("tr").remove();
                                                    });
                                                    Swal.fire({ position: "top-end",
                                                        title: 'ประมวลผลสำเร็จ',
                                                        text: "You Process data success",
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

            $('#SenddataAPI').click(function() {
                var datepicker = $('#datepicker').val();
                var datepicker2 = $('#datepicker2').val();
                Swal.fire({
                        title: 'ต้องการส่งข้อมูลไป New Eclaim ใช่ไหม ?',
                        text: "You Warn Send Data!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, send it!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $("#overlay").fadeIn(300);　
                                $("#spinner").show(); //Load button clicked show spinner

                                $.ajax({
                                    url: "{{ route('acc.account_401_send_api') }}",
                                    type: "POST",
                                    dataType: 'json',
                                    data: {
                                        datepicker,
                                        datepicker2
                                    },
                                    success: function(data) {
                                        if (data.status == 200) {
                                            Swal.fire({
                                                title: 'ส่งข้อมูลไป New Eclaim สำเร็จ',
                                                text: "You Send data New Eclaim success",
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

            $('#destroy').on('click', function(e) {
                    if($(this).is(':checked',true))
                        {
                            $(".sub_destroy").prop('checked', true);
                        } else {
                            $(".sub_destroy").prop('checked',false);
                        }
            });

            $('.Destroystamp').on('click', function(e) {
                // alert('oo');
                var allValls = [];
                // $(".sub_destroy:checked").each(function () {
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
                        title: 'Are you Want Delete sure?',
                        text: "คุณต้องการลบรายการนี้ใช่ไหม!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, Delete it.!'
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
                                                    // $(".sub_destroy:checked").each(function () {
                                                    $(".sub_chk:checked").each(function () {
                                                        $(this).parents("tr").remove();
                                                    });
                                                    Swal.fire({ position: "top-end",
                                                        title: 'ลบข้อมูลสำเร็จ',
                                                        text: "You Delete data success",
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

            $('#Apinhso').click(function() {
                var datepicker = $('#datepicker').val();
                var datepicker2 = $('#datepicker2').val();

                // url: "{{ route('acc.account_401_api') }}",
                // url: "{{ route('acc.account_401_send_api') }}",
                Swal.fire({
                    position: "top-end",
                        title: 'ต้องการส่งข้อมูล NHSO ใช่ไหม ?',
                        text: "You Warn Send NHSO Data!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, Send it!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $("#overlay").fadeIn(300);　
                                $("#spinner").show(); //Load button clicked show spinner

                                $.ajax({
                                    url: "{{ route('acc.account_401_send_api') }}",
                                    type: "POST",
                                    dataType: 'json',
                                    data: {
                                        datepicker,
                                        datepicker2
                                    },
                                    success: function(data) {
                                        if (data.status == 200) {
                                            Swal.fire({
                                                position: "top-end",
                                                title: 'ส่งข้อมูล NHSO สำเร็จ',
                                                text: "You Send data NHSO success",
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
