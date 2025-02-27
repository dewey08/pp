@extends('layouts.user_layout')
@section('title', 'PK-OFFICE || Where House')

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
    $ynow = date('Y') + 543;
    $yb = date('Y') + 542;
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
            border: 5px #ddd solid;
            border-top: 10px rgb(252, 101, 1) solid;
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
    <style>
        * {
          box-sizing: border-box;
        }
        .zoom {
          padding: 2px;
          transition: transform .2s;
          width: 100px;
          height: 100px;
          margin: 0 auto;
        }
        .zoom:hover {
          -ms-transform: scale(3.5);
          -webkit-transform: scale(3.5);
          z-index:3;
          transform: scale(5.5,5.5);
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

            <div class="container-fluid fixed-top">
                <br><br>
                <div class="row mt-5">
                    <div class="col"></div>
                    <div class="col-md-5 text-end">
                         <button class="me-2 btn-icon btn-icon-only btn btn-link btn-sm card_red_4" data-bs-toggle="collapse" data-bs-target="#collapseOne2" aria-expanded="false" aria-controls="collapseTwo" class="btn-icon btn-shadow btn-dashed btn btn-outline-secondary">
                            <img src="{{ asset('images/Shopping_Cart.png') }}"  class="me-3 ms-3 mt-2 mb-2" height="30px" width="30px">
                            <span class="badge rounded-pill bg-success load_total" style="font-size: 19px;">0</span>
                        </button>
                        {{-- <button class="me-2 btn-icon btn-icon-only btn btn-link btn-sm card_red_4" data-bs-toggle="modal" data-bs-target="#Detail_shopping">
                            <img src="{{ asset('images/Shopping_Cart.png') }}"  class="me-3 ms-3 mt-2 mb-2" height="30px" width="30px">
                            <span class="badge rounded-pill bg-success load_total" style="font-size: 19px;">0</span>
                        </button> --}}
                        <button type="button" id="UpdateData" class="ladda-button me-2 btn-pill btn btn-success card_prs_4" >
                            <img src="{{ asset('images/Savewhit.png') }}" class="me-2 ms-2" height="18px" width="18px">
                           บันทึก
                       </button>
                        <a href="{{url('wh_sub_main_rp')}}" class="ladda-button me-2 btn-pill btn btn-danger card_prs_4">
                            <img src="{{ asset('images/back.png') }}" class="me-2 ms-2" height="18px" width="18px">
                            ยกเลิก
                        </a>
                    </div>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-md-4">
                    <h4 style="color:rgb(2, 94, 148)">เลขที่บิล {{ $data_edit->request_no }}</h4>
                </div>
                <div class="col text-end">
                   <div id="headingTwo" class="b-radius-0">
                        {{-- <button class="me-2 btn-icon btn-icon-only btn btn-link btn-sm card_red_4" data-bs-toggle="collapse" data-bs-target="#collapseOne2" aria-expanded="false" aria-controls="collapseTwo" class="btn-icon btn-shadow btn-dashed btn btn-outline-secondary">
                            <img src="{{ asset('images/Shopping_Cart.png') }}"  class="me-2 ms-2" height="27px" width="27px">
                            <span class="badge rounded-pill bg-success load_total" style="font-size: 17px;">0</span>
                        </button> --}}
                        {{-- <button type="button" id="UpdateData" class="ladda-button me-2 btn-pill btn btn-success card_prs_4" >
                            <img src="{{ asset('images/Savewhit.png') }}" class="me-2 ms-2" height="18px" width="18px">
                           บันทึก
                       </button>
                        <a href="{{url('wh_sub_main_rp')}}" class="ladda-button me-2 btn-pill btn btn-danger card_prs_4">
                            <img src="{{ asset('images/back.png') }}" class="me-2 ms-2" height="18px" width="18px">
                            ยกเลิก
                        </a> --}}
                    </div>
                </div>
            </div>

            <div data-parent="#accordion" id="collapseOne2" class="collapse">
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card">

                                <div id="gettable_shopping"></div>
                               <!-- <table id="Tabledit" class="table table-bordered border-primary table-hover table-sm mt-2" style="border-collapse: collapse;border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th class="text-center" style="background-color: rgb(255, 251, 228);font-size: 12px;">ลำดับ</th>
                                            <th class="text-center" style="background-color: rgb(174, 236, 245);font-size: 12px;">รหัส</th>
                                            <th class="text-center" style="background-color: rgb(174, 236, 245);font-size: 12px;">รายการ</th>
                                            <th class="text-center" style="background-color: rgb(187, 250, 221);font-size: 12px;">จำนวน</th>
                                            <th class="text-center" style="background-color: rgb(174, 236, 245);font-size: 12px;">หน่วยนับ</th>
                                            <th width="5%" class="text-center"><input type="checkbox" class="dcheckbox" name="stamp" id="stamp"> </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $i = 1;
                                        @endphp
                                        @foreach ($wh_request_sub as $key => $value)
                                            <tr id="tr_{{$value->wh_request_sub_id}}">
                                                <td class="text-center" width:10%;>{{$i++}}</td>
                                                <td class="text-center" width:10%;>{{$value->pro_code}}</td>
                                                <td >{{$value->pro_name}}</td>
                                                <td class="text-center" width:10%;>{{$value->qty}}</td>
                                                <td class="text-center" width:10%;>{{$value->unit_name}}</td>
                                                <td class="text-center" width="5%"><input type="checkbox" class="dcheckbox sub_chk" data-id="{{$value->wh_request_sub_id}}"> </td>
                                            </tr>
                                        @endforeach



                                    </tbody>
                                </table> -->

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <input type="hidden" id="wh_request_id" name="wh_request_id" value="{{$wh_request_id}}">
            <input type="hidden" id="data_year" name="data_year" value="{{$data_year}}">
            <input type="hidden" id="stock_list_subid" name="stock_list_subid" value="{{$supsup_id}}">

            <div class="row">
                <div class="col-md-12">
                    {{-- <div id="accordion" class="custom-accordion">
                        <div class="card mb-1 shadow-none">
                            <a href="#collapseOne" class="text-dark" data-bs-toggle="collapse"
                                            aria-expanded="true"
                                            aria-controls="collapseOne">
                                <div class="card-header" id="headingOne">
                                    <h6 class="m-0">
                                        วัสดุสำนักงาน
                                        <i class="mdi mdi-minus float-end accor-plus-icon"></i>
                                    </h6>
                                </div>
                            </a>

                            <div id="collapseOne" class="collapse show"
                                    aria-labelledby="headingOne" data-bs-parent="#accordion">
                                <div class="card-body">
                                    <div class="row mt-2">
                                        @foreach ($wh_product_1 as $item)
                                            <div class="col-md-3">
                                                <div class="card card_prs text-center" style="background-color: rgb(238, 252, 255)">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col" style="font-size: 12px">{{$item->pro_name}}</div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col"> <img src="{{ asset('images/product/a4.jpg') }}" width="50" height="50"></div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col"><input type="number" class="form-control form-control-sm"></div>
                                                            <div class="col-4">
                                                                <button type="button" id="Addproduct" class="ladda-button -mb-2btn-pill btn btn-sm btn-success card_prs" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" title="เพิ่มรายการวัสดุลงใน List">
                                                                    <img src="{{ asset('images/Addwhite.png') }}" height="10px" width="10px">
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-1 shadow-none">
                            <a href="#collapseTwo" class="text-dark collapsed" data-bs-toggle="collapse"
                                            aria-expanded="false"
                                            aria-controls="collapseTwo">
                                <div class="card-header" id="headingTwo">
                                    <h6 class="m-0">
                                        วัสดุงานบ้านงานครัว
                                        <i class="mdi mdi-minus float-end accor-plus-icon"></i>
                                    </h6>
                                </div>
                            </a>
                            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo"
                                    data-bs-parent="#accordion">
                                <div class="card-body">
                                    sunt aliqua put a bird on it squid single-origin coffee
                                    nulla assumenda shoreditch et. Nihil anim keffiyeh
                                    helvetica, craft beer labore wes anderson cred nesciunt
                                    Leggings occaecat craft beer farm-to-table, raw denim
                                    accusamus labore sustainable VHS.
                                </div>
                            </div>
                        </div>
                        <div class="card mb-0 shadow-none">
                            <a href="#collapseThree" class="text-dark collapsed" data-bs-toggle="collapse"
                                            aria-expanded="false"
                                            aria-controls="collapseThree">
                                <div class="card-header" id="headingThree">
                                    <h6 class="m-0">
                                        วัสดุบริโภค
                                        <i class="mdi mdi-minus float-end accor-plus-icon"></i>
                                    </h6>
                                </div>
                            </a>
                            <div id="collapseThree" class="collapse"
                                    aria-labelledby="headingThree" data-bs-parent="#accordion">
                                <div class="card-body">
                                    Anim pariatur cliche reprehenderit, enim eiusmod high life
                                    accusamus terry richardson ad squid. 3 wolf moon officia
                                    aute, non cupidatat skateboard dolor brunch. Food truck
                                    sunt aliqua put a bird on it squid single-origin coffee
                                    nulla assumenda anderson cred nesciunt
                                </div>
                            </div>
                        </div>
                    </div> --}}
                     <!-- Nav tabs -->
                     <ul class="nav nav-tabs mb-0" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#office" role="tab" style="background-color: rgb(210, 252, 238)">
                                <span class="d-block d-sm-none"> <img src="{{ asset('images/Office_new.png') }}" height="35px" width="35px"></span>
                                <span class="d-none d-sm-block"> วัสดุสำนักงาน</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#kitchen" role="tab" style="background-color: rgb(252, 220, 232)">
                                <span class="d-block d-sm-none"><img src="{{ asset('images/chicken_new.png') }}" height="35px" width="35px"></span>
                                <span class="d-none d-sm-block">วัสดุงานบ้านงานครัว</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#nutrition" role="tab" style="background-color: rgb(210, 242, 255)">
                                <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                                <span class="d-none d-sm-block">โภชนศาสตร์</span>
                            </a>
                        </li>
                        {{-- <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#Cart_shopping" role="tab">
                                <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                                <span class="d-none d-sm-block">
                                    <button type="button" class="ladda-button me-2 btn-pill btn btn-white card_prs_4" >
                                            <img src="{{ asset('images/Shopping_Cart.png') }}" class="me-2 ms-2" height="27px" width="27px">
                                            <span class="load_total card_red_4" style="color:rgb(233, 15, 80);font-size:21px;background-color:#e0fdf4;padding: 6px;">0</span>
                                    </button>
                                </span>
                            </a>
                        </li> --}}
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content text-muted">
                        <div class="tab-pane active" id="office" role="tabpanel" style="background-color: rgb(210, 252, 238)">
                            {{-- <p class="mb-0"> --}}
                                <input class="form-control" id="myInput" type="text" placeholder="Search..">
                                <br>
                                <div class="row">
                                    @foreach ($wh_product_1 as $item)
                                        <div class="col-md-2 el">
                                            <div class="card card_prs text-center" style="background-color: rgb(238, 252, 255);height: 170px;">
                                                {{-- <div class="card-body">
                                                    <div class="grid-menu-col">
                                                        <div class="row">
                                                            <div class="col" style="font-size: 12px;height: 35px;">
                                                                {{$item->pro_name}}
                                                            </div>
                                                            <input type="hidden" class="form-control form-control-sm" id="pro_id" name="pro_id" value="{{$item->pro_id}}">
                                                        </div>
                                                        <div class="row">
                                                                    @if ($item->img_base =='')
                                                                        <div class="col widget-chart widget-chart-hover">
                                                                            <button type="button" class="ladda-button btn-pill btn btn-sm Addproduct_pic" value="{{ $item->pro_id }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" title="เพิ่มรายการวัสดุลงใน List">
                                                                                    <img src="{{ asset('assets/images/default-image.jpg') }}" height="100px" width="100px" alt="Image" class="img-thumbnail zoom">
                                                                            </button>
                                                                        </div>
                                                                    @else
                                                                        <div class="col widget-chart widget-chart-hover">
                                                                            <button type="button" class="ladda-button btn-pill btn btn-sm Addproduct_pic" value="{{ $item->pro_id }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" title="เพิ่มรายการวัสดุลงใน List">
                                                                                <img src="{{ $item->img_base }}" alt="Image" height="auto" width="80px" class="img-thumbnail zoom">
                                                                            </button>
                                                                        </div>
                                                                    @endif

                                                        </div>
                                                    </div>
                                                </div> --}}
                                                <div class="grid-menu-col">
                                                    <div class="g-0 row">
                                                        <div class="col-sm-12">
                                                            <div class="widget-chart widget-chart-hover">
                                                                <div class="d-flex">
                                                                    <div class="flex-grow-1">
                                                                        <p class="text-start mb-2" style="font-size: 12px">{{$item->pro_name}}</p>
                                                                        <input type="hidden" id="pro_id" name="pro_id" value="{{$item->pro_id}}">
                                                                        @if ($item->img_base =='')
                                                                            <button type="button" class="ladda-button btn-pill btn btn-sm Addproduct_pic" value="{{ $item->pro_id }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" title="เพิ่มรายการวัสดุลงใน List">
                                                                                <img src="{{ asset('assets/images/default-image.jpg') }}" height="100px" width="100px" alt="Image" class="img-thumbnail zoom">
                                                                            </button>
                                                                        @else
                                                                            <button type="button" class="ladda-button btn-pill btn btn-sm Addproduct_pic" value="{{ $item->pro_id }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" title="เพิ่มรายการวัสดุลงใน List">
                                                                                <img src="{{ $item->img_base }}" alt="Image" height="auto" width="80px" class="img-thumbnail zoom">
                                                                            </button>
                                                                        @endif
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            {{-- </p> --}}
                        </div>
                        <div class="tab-pane" id="kitchen" role="tabpanel" style="background-color: rgb(252, 220, 232)">
                            <p class="mb-0">
                                <input class="form-control" id="myInput2" type="text" placeholder="Search..">
                                <br>
                                <div class="row">
                                    @foreach ($wh_product_2 as $item2)
                                        <div class="col-md-2 el2">
                                            <div class="card card_prs text-center" style="background-color: rgb(238, 252, 255);height: 170px;">
                                                {{-- <div class="card-body">
                                                    <div class="row">
                                                        <div class="col" style="font-size: 12px;height: 35px;">{{$item2->pro_name}}</div>
                                                        <input type="hidden" class="form-control form-control-sm" id="pro_id" name="pro_id" value="{{$item2->pro_id}}">
                                                    </div>

                                                    <div class="row">
                                                        <div class="col">
                                                            <button type="button" class="ladda-button btn-pill btn btn-sm Addproduct_pic" value="{{ $item2->pro_id }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" title="เพิ่มรายการวัสดุลงใน List">
                                                                @if ($item2->img_base =='')
                                                                <img src="{{ asset('assets/images/default-image.jpg') }}" height="100px" width="100px" alt="Image" class="img-thumbnail zoom">
                                                                @else
                                                                <img src="{{ $item2->img_base }}" alt="Image" height="auto" width="80px" class="img-thumbnail zoom">
                                                                @endif
                                                            </button>
                                                        </div>

                                                    </div>
                                                </div> --}}
                                                <div class="grid-menu-col">
                                                    <div class="g-0 row">
                                                        <div class="col-sm-12">
                                                            <div class="widget-chart widget-chart-hover">
                                                                <div class="d-flex">
                                                                    <div class="flex-grow-1">
                                                                        <p class="text-start mb-2" style="font-size: 12px">{{$item2->pro_name}}</p>
                                                                        <input type="hidden" id="pro_id" name="pro_id" value="{{$item2->pro_id}}">
                                                                        @if ($item2->img_base =='')
                                                                            <button type="button" class="ladda-button btn-pill btn btn-sm Addproduct_pic" value="{{ $item2->pro_id }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" title="เพิ่มรายการวัสดุลงใน List">
                                                                                <img src="{{ asset('assets/images/default-image.jpg') }}" height="100px" width="100px" alt="Image" class="img-thumbnail zoom">
                                                                            </button>
                                                                        @else
                                                                            <button type="button" class="ladda-button btn-pill btn btn-sm Addproduct_pic" value="{{ $item2->pro_id }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" title="เพิ่มรายการวัสดุลงใน List">
                                                                                <img src="{{ $item2->img_base }}" alt="Image" height="auto" width="80px" class="img-thumbnail zoom">
                                                                            </button>
                                                                        @endif
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </p>
                        </div>
                        <div class="tab-pane" id="nutrition" role="tabpanel" style="background-color: rgb(210, 242, 255)">
                            <p class="mb-0">
                                <input class="form-control" id="myInput3" type="text" placeholder="Search..">
                                <br>
                                <div class="row">
                                    @foreach ($wh_product_3 as $item3)
                                        <div class="col-md-2 el3">
                                            <div class="card card_prs" style="background-color: rgb(238, 252, 255);height: 170px;">
                                                <div class="grid-menu-col">
                                                    <div class="g-0 row">
                                                        <div class="col-sm-12">
                                                            <div class="widget-chart widget-chart-hover">
                                                                <div class="d-flex">
                                                                    <div class="flex-grow-1">
                                                                        <p class="text-start" style="font-size: 12px">{{$item3->pro_name}}</p>
                                                                        <input type="hidden" id="pro_id" name="pro_id" value="{{$item3->pro_id}}">
                                                                        @if ($item3->img_base =='')
                                                                            <button type="button" class="ladda-button btn-pill btn btn-sm Addproduct_pic" value="{{ $item3->pro_id }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" title="เพิ่มรายการวัสดุลงใน List">
                                                                                <img src="{{ asset('assets/images/default-image.jpg') }}" height="100px" width="100px" alt="Image" class="img-thumbnail zoom">
                                                                            </button>
                                                                        @else
                                                                            <button type="button" class="ladda-button btn-pill btn btn-sm Addproduct_pic" value="{{ $item3->pro_id }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" title="เพิ่มรายการวัสดุลงใน List">
                                                                                <img src="{{ $item3->img_base }}" alt="Image" height="auto" width="80px" class="img-thumbnail zoom">
                                                                            </button>
                                                                        @endif
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </p>
                        </div>
                        <div class="tab-pane" id="settings" role="tabpanel">
                            <p class="mb-0">
                                Trust fund seitan letterpress, keytar raw denim keffiyeh etsy
                                art party before they sold out master cleanse gluten-free squid
                                scenester freegan cosby sweater. Fanny pack portland seitan DIY,
                                art party locavore wolf cliche high life echo park Austin. Cred
                                vinyl keffiyeh DIY salvia PBR, banh mi before they sold out
                                farm-to-table VHS.
                            </p>
                        </div>
                    </div>
                </div>

            </div>
</div>

    <div class="modal fade" id="updateqtyModal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" style="color: rgb(9, 131, 202)">เพิ่มรายการลงในตะกร้า</h5>
                </div>
                <div class="modal-body">
                    <input id="edit_proid" name="edit_proid" type="hidden" class="form-control form-control-sm">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <input id="edit_proname" name="edit_proname" type="text" class="form-control form-control-sm" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-12">
                            <div class="form-group">
                                <input id="edit_qty" name="edit_qty" type="number" class="form-control form-control-sm" placeholder="ใส่จำนวน">
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <div class="row">
                        <div class="col">
                                <button type="button" class="ladda-button me-2 btn-pill btn btn-sm btn-success card_prs_4" id="Addproduct">
                                    <img src="{{ asset('images/Addwhite.png') }}" class="me-2 ms-2" height="18px" width="18px">
                                    ใส่ตะกร้า
                                </button>
                                <button type="button" class="ladda-button me-2 btn-pill btn btn-sm btn-danger card_prs_4" data-bs-dismiss="modal">
                                    <img src="{{ asset('images/back.png') }}" class="me-2 ms-2" height="18px" width="18px"> Close
                                </button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>


    <div class="modal" id="Detail_shopping" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" style="color:rgb(2, 94, 148)">เลขที่บิล {{ $data_edit->request_no }}</h5>
              {{-- <h4 style="color:rgb(2, 94, 148)">เลขที่บิล {{ $data_edit->request_no }}</h4> --}}
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="gettable_shopping"></div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>



@endsection
@section('footer')

    <script>
        var Linechart;
        load_shooping_tables();
        function load_shooping_tables() {
                var wh_request_id = document.getElementById("wh_request_id").value;
                // alert(wh_recieve_id);
                var _token=$('input[name="_token"]').val();
                $.ajax({
                        url:"{{route('wh.load_shooping_tables')}}",
                        method:"GET",
                        data:{wh_request_id:wh_request_id,_token:_token},
                        success:function(result){
                            $('#gettable_shopping').html(result);
                        }
                });
        }
        wh_loadtotals();
        function wh_loadtotals() {
                    var wh_request_id = document.getElementById("wh_request_id").value;
                    // alert(wh_recieve_id);
                    var _token=$('input[name="_token"]').val();
                    $.ajax({
                            url:"{{route('wh.wh_loadtotal')}}",
                            method:"GET",
                            data:{wh_request_id:wh_request_id,_token:_token},
                            success:function(data){
                                // $('#load_total').val(data.total)
                                $('.load_total').text(data.total);
                                // $('.badge').text(data.total_item);
                            }
                    });
            }
        function select_destpic(wh_request_sub_id) {
            var _token = $('input[name="_token"]').val();
            $.ajax({
                    url: "{{ route('wh.wh_request_picdestroy') }}",
                    method: "POST",
                    data: {wh_request_sub_id: wh_request_sub_id,_token: _token},
                    success: function(result) {
                        if (result.status == 200) {
                            load_shooping_tables();
                            wh_loadtotals();
                        } else {
                        }
                    }
                })
            }

        $(document).ready(function() {
            var search = document.getElementById("myInput");
            var els = document.querySelectorAll(".el");
            search.addEventListener("keyup", function() {
                Array.prototype.forEach.call(els, function(el) {
                    if (el.textContent.trim().indexOf(search.value) > -1)
                    el.style.display = 'block';
                    else el.style.display = 'none';
                });
            });
            var search2 = document.getElementById("myInput2");
            var els2 = document.querySelectorAll(".el2");
            search2.addEventListener("keyup", function() {
                Array.prototype.forEach.call(els2, function(el2) {
                    if (el2.textContent.trim().indexOf(search2.value) > -1)
                    el2.style.display = 'block';
                    else el2.style.display = 'none';
                });
            });
            var search3 = document.getElementById("myInput3");
            var els3 = document.querySelectorAll(".el3");
            search3.addEventListener("keyup", function() {
                Array.prototype.forEach.call(els3, function(el3) {
                    if (el3.textContent.trim().indexOf(search3.value) > -1)
                    el3.style.display = 'block';
                    else el3.style.display = 'none';
                });
            });

            $('select').select2();
            $('#example').DataTable();
            $('#example2').DataTable();
            $('#example3').DataTable();

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

            $('#stamp').on('click', function(e) {
                    if($(this).is(':checked',true))
                    {
                        $(".sub_chk").prop('checked', true);
                    } else {
                        $(".sub_chk").prop('checked',false);
                    }
            });
            $("#spinner-div").hide(); //Request is complete so hide spinner
            load_datauser_table();
            load_data_usersum();
            wh_loadtotal();
            function load_datauser_table() {
                    var wh_request_id = document.getElementById("wh_request_id").value;
                    // alert(wh_recieve_id);
                    var _token=$('input[name="_token"]').val();
                    $.ajax({
                            url:"{{route('wh.load_datauser_table')}}",
                            method:"GET",
                            data:{wh_request_id:wh_request_id,_token:_token},
                            success:function(result){
                                $('#gettable_show').html(result);
                            }
                    });
            }
            function load_data_usersum() {
                    var wh_request_id = document.getElementById("wh_request_id").value;
                    // alert(wh_recieve_id);
                    var _token=$('input[name="_token"]').val();
                    $.ajax({
                            url:"{{route('wh.load_data_usersum')}}",
                            method:"GET",
                            data:{wh_request_id:wh_request_id,_token:_token},
                            success:function(result){
                                $('#gettotal_show').val(result.total)
                            }
                    });
            }
            function wh_loadtotal() {
                    var wh_request_id = document.getElementById("wh_request_id").value;
                    // alert(wh_recieve_id);
                    var _token=$('input[name="_token"]').val();
                    $.ajax({
                            url:"{{route('wh.wh_loadtotal')}}",
                            method:"GET",
                            data:{wh_request_id:wh_request_id,_token:_token},
                            success:function(data){
                                // $('#load_total').val(data.total)
                                $('.load_total').text(data.total);
                                // $('.badge').text(data.total_item);
                            }
                    });
            }
            load_shooping_table();
            function load_shooping_table() {
                    var wh_request_id = document.getElementById("wh_request_id").value;
                    // alert(wh_recieve_id);
                    var _token=$('input[name="_token"]').val();
                    $.ajax({
                            url:"{{route('wh.load_shooping_table')}}",
                            method:"GET",
                            data:{wh_request_id:wh_request_id,_token:_token},
                            success:function(result){
                                $('#gettable_shopping').html(result);
                            }
                    });
            }
            $('#Addproduct').click(function() {
                var edit_proid           = $('#edit_proid').val();
                var edit_qty             = $('#edit_qty').val();
                var wh_request_id        = $('#wh_request_id').val();
                var stock_list_subid     = $('#stock_list_subid').val();
                var data_year            = $('#data_year').val();
                // alert(wh_request_id);
                        $.ajax({
                            url: "{{ route('wh.wh_request_addsubpic_save') }}",
                            type: "POST",
                            dataType: 'json',
                            data: {edit_proid,edit_qty,wh_request_id,data_year,stock_list_subid},
                            success: function(data) {
                                // load_datauser_table();
                                wh_loadtotal();
                                load_shooping_table();
                                $('#edit_qty').val("");
                                $('#updateqtyModal').modal('hide');
                            },
                        });
            });
            $(document).on('click', '.Addproduct_pic', function() {
                var pro_id               = $(this).val();
                $('#updateqtyModal').modal('show');
                $.ajax({
                    type: "GET",
                    url: "{{ url('wh_picid') }}" + '/' + pro_id,
                    success: function(data) {
                        console.log(data.product.pro_id);
                        $('#edit_proid').val(data.product.pro_id)
                        $('#edit_proname').val(data.product.pro_name)
                    },
                });
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
                                                        title: 'ลบข้อมูลสำเร็จ',
                                                        text: "You Delete data success",
                                                        icon: 'success',
                                                        showCancelButton: false,
                                                        confirmButtonColor: '#06D177',
                                                        confirmButtonText: 'เรียบร้อย'
                                                    }).then((result) => {
                                                        if (result
                                                            .isConfirmed) {
                                                                wh_loadtotal();
                                                                load_shooping_table();
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

            $('#UpdateData').click(function() {
                var supsup_id        = $('#supsup_id').val();
                var data_year        = $('#data_year').val();
                var wh_request_id    = $('#wh_request_id').val();

                Swal.fire({ position: "top-end",
                        title: 'ต้องการบันทึกข้อมูลใช่ไหม ?',
                        text: "You Warn Save Data!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, Save it!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $("#overlay").fadeIn(300);　
                                $("#spinner").show(); //Load button clicked show spinner

                                $.ajax({
                                    url: "{{ route('wh.wh_request_updatestock') }}",
                                    type: "POST",
                                    dataType: 'json',
                                    data: {data_year,wh_request_id,supsup_id},
                                    success: function(data) {
                                        if (data.status == 200) {
                                            Swal.fire({ position: "top-end",
                                                title: 'บันทึกข้อมูลสำเร็จ',
                                                text: "You Save data success",
                                                icon: 'success',
                                                showCancelButton: false,
                                                confirmButtonColor: '#06D177',
                                                confirmButtonText: 'เรียบร้อย'
                                            }).then((result) => {
                                                if (result
                                                    .isConfirmed) {
                                                    console.log(
                                                        data);
                                                    // window.location.reload();
                                                    window.location="{{url('wh_sub_main_rp')}}";
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
