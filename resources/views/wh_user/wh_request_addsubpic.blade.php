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

                    </div>
                </div>
            </div>

            <div data-parent="#accordion" id="collapseOne2" class="collapse">
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card">
                                <div id="gettable_shopping"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                     <!-- Nav tabs -->
                     <ul class="nav nav-tabs mb-0" role="tablist">
                        @if ($stock_list_id == '1')
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#office" role="tab" style="background-color: rgb(210, 252, 238)">
                                <span class="d-block d-sm-none"> <img src="{{ asset('images/Office_new.png') }}" height="35px" width="35px"></span>
                                <span class="d-none d-sm-block"> วัสดุสำนักงาน</span>
                            </a>
                        </li>
                        @endif
                        @if ($stock_list_id == '7')
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#kitchen" role="tab" style="background-color: rgb(252, 220, 232)">
                                <span class="d-block d-sm-none"><img src="{{ asset('images/chicken_new.png') }}" height="35px" width="35px"></span>
                                <span class="d-none d-sm-block">วัสดุงานบ้านงานครัว</span>
                            </a>
                        </li>
                        @endif
                        @if ($stock_list_id == '3')
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#nutrition" role="tab" style="background-color: rgb(210, 242, 255)">
                                <span class="d-block d-sm-none"><img src="{{ asset('images/nutrition_new.png') }}" height="35px" width="35px"></span>
                                <span class="d-none d-sm-block">โภชนศาสตร์</span>
                            </a>
                        </li>
                        @endif
                        @if ($stock_list_id == '2')
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#medical" role="tab" style="background-color: rgb(255, 250, 230)">
                                <span class="d-block d-sm-none"><img src="{{ asset('images/medical_new.png') }}" height="35px" width="35px"></span>
                                <span class="d-none d-sm-block">วัสดุการแพทย์</span>
                            </a>
                        </li>
                        @endif
                        {{-- @if ($stock_list_id == '3')
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#nondrugitems" role="tab" style="background-color: rgb(255, 228, 210)">
                                <span class="d-block d-sm-none"><img src="{{ asset('images/syring_new.png') }}" height="35px" width="35px"></span>
                                <span class="d-none d-sm-block">เวชภัณฑ์ที่มิใช่ยา</span>
                            </a>
                        </li>
                        @endif --}}
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content text-muted">
                        {{-- @if ($stock_list_id == '1') --}}
                        <div class="tab-pane" id="office" role="tabpanel" style="background-color: rgb(210, 252, 238)">
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
                                                                        @if ($item->wh_type_id == '1')
                                                                            @if ($item->img_base =='')
                                                                                <button type="button" class="ladda-button btn-pill btn btn-sm Addproduct_pic1" value="{{ $item->pro_id }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" title="เพิ่มรายการวัสดุลงใน List">
                                                                                    <img src="{{ asset('assets/images/default-image.jpg') }}" height="100px" width="100px" alt="Image" class="img-thumbnail zoom">
                                                                                </button>
                                                                            @else
                                                                                <button type="button" class="ladda-button btn-pill btn btn-sm Addproduct_pic1" value="{{ $item->pro_id }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" title="เพิ่มรายการวัสดุลงใน List">
                                                                                    <img src="{{ $item->img_base }}" alt="Image" height="auto" width="80px" class="img-thumbnail zoom">
                                                                                </button>
                                                                            @endif
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
                        </div>

                        <div class="tab-pane" id="kitchen" role="tabpanel" style="background-color: rgb(252, 220, 232)">
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
                                                                        @if ($item2->wh_type_id == '3')
                                                                            @if ($item2->img_base =='')
                                                                                <button type="button" class="ladda-button btn-pill btn btn-sm Addproduct_pic2" value="{{ $item2->pro_id }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" title="เพิ่มรายการวัสดุลงใน List">
                                                                                    <img src="{{ asset('assets/images/default-image.jpg') }}" height="100px" width="100px" alt="Image" class="img-thumbnail zoom">
                                                                                </button>
                                                                            @else
                                                                                <button type="button" class="ladda-button btn-pill btn btn-sm Addproduct_pic2" value="{{ $item2->pro_id }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" title="เพิ่มรายการวัสดุลงใน List">
                                                                                    <img src="{{ $item2->img_base }}" alt="Image" height="auto" width="80px" class="img-thumbnail zoom">
                                                                                </button>
                                                                            @endif
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
                        </div>

                        <div class="tab-pane" id="nutrition" role="tabpanel" style="background-color: rgb(210, 242, 255)">
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
                                                                            @if ($item3->wh_type_id == '18')
                                                                                @if ($item3->img_base =='')
                                                                                    <button type="button" class="ladda-button btn-pill btn btn-sm Addproduct_pic3" value="{{ $item3->pro_id }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" title="เพิ่มรายการวัสดุลงใน List">
                                                                                        <img src="{{ asset('assets/images/default-image.jpg') }}" height="100px" width="100px" alt="Image" class="img-thumbnail zoom">
                                                                                    </button>
                                                                                    @else
                                                                                        <button type="button" class="ladda-button btn-pill btn btn-sm Addproduct_pic3" value="{{ $item3->pro_id }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" title="เพิ่มรายการวัสดุลงใน List">
                                                                                            <img src="{{ $item3->img_base }}" alt="Image" height="auto" width="80px" class="img-thumbnail zoom">
                                                                                        </button>
                                                                                    @endif
                                                                                @else
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
                        </div>

                        <div class="tab-pane" id="medical" role="tabpanel" style="background-color: rgb(255, 250, 230)">

                                <input class="form-control" id="myInput4" type="text" placeholder="Search..">
                                <br>
                                <div class="row">
                                    @foreach ($wh_product_4 as $item4)
                                        <div class="col-md-2 el4">
                                            <div class="card card_prs" style="background-color: rgb(238, 252, 255);height: 170px;">
                                                <div class="grid-menu-col">
                                                    <div class="g-0 row">
                                                        <div class="col-sm-12">
                                                            <div class="widget-chart widget-chart-hover">
                                                                <div class="d-flex">
                                                                    <div class="flex-grow-1">
                                                                        <p class="text-start" style="font-size: 12px">{{$item4->pro_name}}</p>
                                                                        <input type="hidden" id="pro_id" name="pro_id" value="{{$item4->pro_id}}">
                                                                            @if ($item4->wh_type_id == '22')
                                                                                @if ($item4->img_base =='')
                                                                                    <button type="button" class="ladda-button btn-pill btn btn-sm Addproduct_pic2" value="{{ $item4->pro_id }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" title="เพิ่มรายการวัสดุลงใน List">
                                                                                        <img src="{{ asset('assets/images/default-image.jpg') }}" height="100px" width="100px" alt="Image" class="img-thumbnail zoom">
                                                                                    </button>
                                                                                    @else
                                                                                        <button type="button" class="ladda-button btn-pill btn btn-sm Addproduct_pic2" value="{{ $item4->pro_id }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" title="เพิ่มรายการวัสดุลงใน List">
                                                                                            <img src="{{ $item4->img_base }}" alt="Image" height="auto" width="80px" class="img-thumbnail zoom">
                                                                                        </button>
                                                                                    @endif
                                                                                @else
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

                        </div>

                        <div class="tab-pane" id="nondrugitems" role="tabpanel" style="background-color: rgb(255, 228, 210)">

                            <input class="form-control" id="myInput5" type="text" placeholder="Search..">
                            <br>
                            <div class="row">
                                @foreach ($wh_product_5 as $item5)
                                    <div class="col-md-2 el5">
                                        <div class="card card_prs" style="background-color: rgb(238, 252, 255);height: 180px;">
                                            <div class="grid-menu-col">
                                                <div class="g-0 row">
                                                    <div class="col-sm-12">
                                                        <div class="widget-chart widget-chart-hover">
                                                            <div class="d-flex">
                                                                <div class="flex-grow-1">
                                                                    <p class="text-start" style="font-size: 12px">{{$item5->pro_name}}</p>
                                                                    <input type="hidden" id="pro_id" name="pro_id" value="{{$item5->pro_id}}">
                                                                        @if ($item5->wh_type_id == '44')
                                                                            @if ($item5->img_base =='')
                                                                                <button type="button" class="ladda-button btn-pill btn btn-sm Addproduct_pic5" value="{{ $item5->pro_id }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" title="เพิ่มรายการวัสดุลงใน List">
                                                                                    <img src="{{ asset('assets/images/default-image.jpg') }}" height="100px" width="100px" alt="Image" class="img-thumbnail zoom">
                                                                                </button>
                                                                                @else
                                                                                    <button type="button" class="ladda-button btn-pill btn btn-sm Addproduct_pic5" value="{{ $item5->pro_id }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" title="เพิ่มรายการวัสดุลงใน List">
                                                                                        <img src="{{ $item5->img_base }}" alt="Image" height="auto" width="80px" class="img-thumbnail zoom">
                                                                                    </button>
                                                                                @endif
                                                                            @else
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

                        </div>


                    </div>
                </div>

            </div>
</div>

    <div class="modal fade" id="Addproduct_pic1Modal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" style="color: rgb(9, 131, 202)">เพิ่มรายการลงในตะกร้า</h5>
                </div>
                <form action="{{ route('wh.wh_request_addsubpic_save') }}" method="POST" id="Addpro1" enctype="multipart/form-data">
                    @csrf

                    <input type="hidden" id="wh_request_id" name="wh_request_id" value="{{$wh_request_id}}">
                    <input type="hidden" id="data_year" name="data_year" value="{{$data_year}}">
                    <input type="hidden" id="stock_list_subid" name="stock_list_subid" value="{{$supsup_id}}">

                <div class="modal-body">
                    <input id="edit_proid1" name="edit_proid" type="hidden" class="form-control form-control-sm">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <input id="edit_proname1" name="edit_proname" type="text" class="form-control form-control-sm" readonly>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="row mt-2">
                        <div class="col-md-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="edit_pro_kind" id="edit_pro_kind1" value="1">
                                    <p class="form-check-label" for="edit_pro_kind1">
                                        บด
                                    </p>
                                </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="edit_pro_kind" id="edit_pro_kind2" value="2">
                                <p class="form-check-label" for="edit_pro_kind2">
                                    หั่น
                                </p>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="edit_pro_kind" id="edit_pro_kind3" value="3">
                                <p class="form-check-label" for="edit_pro_kind3">
                                    ตัว
                                </p>
                            </div>
                        </div>
                    </div> --}}
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
                                {{-- <button type="button" class="ladda-button me-2 btn-pill btn btn-sm btn-success card_prs_4" id="Addproduct">
                                    <img src="{{ asset('images/Addwhite.png') }}" class="me-2 ms-2" height="18px" width="18px">
                                    ใส่ตะกร้า
                                </button> --}}
                                <button type="submit" class="ladda-button me-2 btn-pill btn btn-sm btn-success card_prs_4">
                                    <img src="{{ asset('images/Addwhite.png') }}" class="me-2 ms-2" height="18px" width="18px">
                                    ใส่ตะกร้า
                                </button>
                                <button type="button" class="ladda-button me-2 btn-pill btn btn-sm btn-danger card_prs_4" data-bs-dismiss="modal">
                                    <img src="{{ asset('images/back.png') }}" class="me-2 ms-2" height="18px" width="18px"> Close
                                </button>
                        </div>
                    </div>
                </div>
            </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="Addproduct_pic2Modal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" style="color: rgb(9, 131, 202)">เพิ่มรายการลงในตะกร้า</h5>
                </div>
                <form action="{{ route('wh.wh_request_addsubpic_save') }}" method="POST" id="Addpro2" enctype="multipart/form-data">
                    @csrf

                    <input type="hidden" id="wh_request_id" name="wh_request_id" value="{{$wh_request_id}}">
                    <input type="hidden" id="data_year" name="data_year" value="{{$data_year}}">
                    <input type="hidden" id="stock_list_subid" name="stock_list_subid" value="{{$supsup_id}}">

                <div class="modal-body">
                    <input id="edit_proid2" name="edit_proid" type="hidden" class="form-control form-control-sm">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <input id="edit_proname2" name="edit_proname" type="text" class="form-control form-control-sm" readonly>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="row mt-2">
                        <div class="col-md-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="edit_pro_kind" id="edit_pro_kind1" value="1">
                                    <p class="form-check-label" for="edit_pro_kind1">
                                        บด
                                    </p>
                                </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="edit_pro_kind" id="edit_pro_kind2" value="2">
                                <p class="form-check-label" for="edit_pro_kind2">
                                    หั่น
                                </p>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="edit_pro_kind" id="edit_pro_kind3" value="3">
                                <p class="form-check-label" for="edit_pro_kind3">
                                    ตัว
                                </p>
                            </div>
                        </div>
                    </div> --}}
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
                                <button type="submit" class="ladda-button me-2 btn-pill btn btn-sm btn-success card_prs_4">
                                    <img src="{{ asset('images/Addwhite.png') }}" class="me-2 ms-2" height="18px" width="18px">
                                    ใส่ตะกร้า
                                </button>
                                <button type="button" class="ladda-button me-2 btn-pill btn btn-sm btn-danger card_prs_4" data-bs-dismiss="modal">
                                    <img src="{{ asset('images/back.png') }}" class="me-2 ms-2" height="18px" width="18px"> Close
                                </button>
                        </div>
                    </div>
                </div>
            </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="Addproduct_pic3Modal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" style="color: rgb(9, 131, 202)">เพิ่มรายการลงในตะกร้า</h5>
                </div>
                <form action="{{ route('wh.wh_request_addsubpic_save') }}" method="POST" id="Addpro3" enctype="multipart/form-data">
                    @csrf

                    <input type="hidden" id="wh_request_id" name="wh_request_id" value="{{$wh_request_id}}">
                    <input type="hidden" id="data_year" name="data_year" value="{{$data_year}}">
                    <input type="hidden" id="stock_list_subid" name="stock_list_subid" value="{{$supsup_id}}">

                <div class="modal-body">
                    <input id="edit_proid3" name="edit_proid" type="hidden" class="form-control form-control-sm">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <input id="edit_proname3" name="edit_proname" type="text" class="form-control form-control-sm" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="edit_pro_kind" id="edit_pro_kind1" value="1">
                                    <p class="form-check-label" for="edit_pro_kind1">
                                        บด
                                    </p>
                                </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="edit_pro_kind" id="edit_pro_kind2" value="2">
                                <p class="form-check-label" for="edit_pro_kind2">
                                    หั่น
                                </p>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="edit_pro_kind" id="edit_pro_kind3" value="3">
                                <p class="form-check-label" for="edit_pro_kind3">
                                    ตัว
                                </p>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="edit_pro_kind" id="edit_pro_kind4" value="4">
                                <p class="form-check-label" for="edit_pro_kind4">
                                    แดง
                                </p>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="edit_pro_kind" id="edit_pro_kind5" value="5">
                                <p class="form-check-label" for="edit_pro_kind5">
                                    เขียว
                                </p>
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
                                <button type="submit" class="ladda-button me-2 btn-pill btn btn-sm btn-success card_prs_4">
                                    <img src="{{ asset('images/Addwhite.png') }}" class="me-2 ms-2" height="18px" width="18px">
                                    ใส่ตะกร้า
                                </button>
                                <button type="button" class="ladda-button me-2 btn-pill btn btn-sm btn-danger card_prs_4" data-bs-dismiss="modal">
                                    <img src="{{ asset('images/back.png') }}" class="me-2 ms-2" height="18px" width="18px"> Close
                                </button>
                        </div>
                    </div>
                </div>
            </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="Addproduct_pic5Modal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" style="color: rgb(9, 131, 202)">เพิ่มรายการลงในตะกร้า</h5>
                </div>
                <form action="{{ route('wh.wh_request_addsubpic_save') }}" method="POST" id="Addpro5" enctype="multipart/form-data">
                    @csrf

                    <input type="hidden" id="wh_request_id" name="wh_request_id" value="{{$wh_request_id}}">
                    <input type="hidden" id="data_year" name="data_year" value="{{$data_year}}">
                    <input type="hidden" id="stock_list_subid" name="stock_list_subid" value="{{$supsup_id}}">

                <div class="modal-body">
                    <input id="edit_proid5" name="edit_proid" type="hidden" class="form-control form-control-sm">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <input id="edit_proname5" name="edit_proname" type="text" class="form-control form-control-sm" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-12">
                            @foreach ($productsub as $item_sub)
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="wh_product_sub_id" id="wh_product_sub_id" value="{{$item_sub->wh_product_sub_id}}">
                                    <p class="form-check-label" for="wh_product_sub_id">{{$item_sub->pro_brand}}</p>
                                </div>
                            @endforeach

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
                                <button type="submit" class="ladda-button me-2 btn-pill btn btn-sm btn-success card_prs_4">
                                    <img src="{{ asset('images/Addwhite.png') }}" class="me-2 ms-2" height="18px" width="18px">
                                    ใส่ตะกร้า
                                </button>
                                <button type="button" class="ladda-button me-2 btn-pill btn btn-sm btn-danger card_prs_4" data-bs-dismiss="modal">
                                    <img src="{{ asset('images/back.png') }}" class="me-2 ms-2" height="18px" width="18px"> Close
                                </button>
                        </div>
                    </div>
                </div>
            </form>
            </div>
        </div>
    </div>


    {{-- <div class="modal" id="Detail_shopping" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" style="color:rgb(2, 94, 148)">เลขที่บิล {{ $data_edit->request_no }}</h5>
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
    </div> --}}



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
            var search4 = document.getElementById("myInput4");
            var els4 = document.querySelectorAll(".el4");
            search4.addEventListener("keyup", function() {
                Array.prototype.forEach.call(els4, function(el4) {
                    if (el4.textContent.trim().indexOf(search4.value) > -1)
                    el4.style.display = 'block';
                    else el4.style.display = 'none';
                });
            });
            var search5 = document.getElementById("myInput5");
            var els5 = document.querySelectorAll(".el5");
            search5.addEventListener("keyup", function() {
                Array.prototype.forEach.call(els5, function(el5) {
                    if (el5.textContent.trim().indexOf(search5.value) > -1)
                    el5.style.display = 'block';
                    else el5.style.display = 'none';
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
                var edit_pro_kind1       = $('#edit_pro_kind1').val();
                var edit_pro_kind2       = $('#edit_pro_kind2').val();
                var edit_pro_kind3       = $('#edit_pro_kind3').val();

                // alert(edit_pro_kind2);
                        $.ajax({
                            url: "{{ route('wh.wh_request_addsubpic_save') }}",
                            type: "POST",
                            dataType: 'json',
                            data: {edit_proid,edit_qty,wh_request_id,data_year,stock_list_subid,edit_pro_kind1,edit_pro_kind2,edit_pro_kind3},
                            success: function(data) {
                                // load_datauser_table();
                                wh_loadtotal();
                                load_shooping_table();
                                $('#edit_qty').val("");
                                $('#updateqtyModal').modal('hide');
                            },
                        });
            });

            $(document).on('click', '.Addproduct_pic1', function() {
                var pro_id               = $(this).val();
                $('#Addproduct_pic1Modal').modal('show');
                $.ajax({
                    type: "GET",
                    url: "{{ url('wh_picid') }}" + '/' + pro_id,
                    success: function(data) {
                        console.log(data.product.pro_id);
                        $('#edit_proid1').val(data.product.pro_id)
                        $('#edit_proname1').val(data.product.pro_name)
                    },
                });
            });
            $(document).on('click', '.Addproduct_pic2', function() {
                var pro_id               = $(this).val();
                $('#Addproduct_pic2Modal').modal('show');
                $.ajax({
                    type: "GET",
                    url: "{{ url('wh_picid') }}" + '/' + pro_id,
                    success: function(data) {
                        console.log(data.product.pro_id);
                        $('#edit_proid2').val(data.product.pro_id)
                        $('#edit_proname2').val(data.product.pro_name)
                    },
                });
            });
            $(document).on('click', '.Addproduct_pic3', function() {
                var pro_id               = $(this).val();
                $('#Addproduct_pic3Modal').modal('show');
                $.ajax({
                    type: "GET",
                    url: "{{ url('wh_picid') }}" + '/' + pro_id,
                    success: function(data) {
                        console.log(data.product.pro_id);
                        $('#edit_proid3').val(data.product.pro_id)
                        $('#edit_proname3').val(data.product.pro_name)
                    },
                });
            });
            $(document).on('click', '.Addproduct_pic5', function() {
                var pro_id               = $(this).val();
                $('#Addproduct_pic5Modal').modal('show');
                $.ajax({
                    type: "GET",
                    url: "{{ url('wh_picidtwo') }}" + '/' + pro_id,
                    success: function(data) {
                        console.log(data.product.pro_id);
                        $('#edit_proid5').val(data.product.pro_id)
                        $('#edit_proname5').val(data.product.pro_name)
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

            $('#Addpro1').on('submit',function(e){
                  e.preventDefault();
                  var form = this;
                    //   alert('OJJJJOL');
                  $.ajax({
                    url:$(form).attr('action'),
                    method:$(form).attr('method'),
                    data:new FormData(form),
                    processData:false,
                    dataType:'json',
                    contentType:false,
                    beforeSend:function(){
                      $(form).find('span.error-text').text('');
                    },
                    success:function(data){
                        if (data.status == 200) {
                            Swal.fire({
                                position: "top-end",
                                title: 'บันทึกข้อมูลสำเร็จ',
                                text: "You Insert data success",
                                icon: 'success',
                                showCancelButton: false,
                                confirmButtonColor: '#06D177',
                                // cancelButtonColor: '#d33',
                                confirmButtonText: 'เรียบร้อย'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                        wh_loadtotal();
                                        load_shooping_table();
                                        $('#edit_qty').val("");
                                        $('#edit_pro_kind1').val("");
                                        $('#edit_pro_kind2').val("");
                                        $('#edit_pro_kind3').val("");
                                        $('#Addproduct_pic1Modal').modal('hide');
                                        $('#Addproduct_pic2Modal').modal('hide');
                                        $('#Addproduct_pic3Modal').modal('hide');
                                }
                            })
                        } else {

                        }
                    }
                  });
            });
            $('#Addpro2').on('submit',function(e){
                  e.preventDefault();
                  var form = this;
                    //   alert('OJJJJOL');
                  $.ajax({
                    url:$(form).attr('action'),
                    method:$(form).attr('method'),
                    data:new FormData(form),
                    processData:false,
                    dataType:'json',
                    contentType:false,
                    beforeSend:function(){
                      $(form).find('span.error-text').text('');
                    },
                    success:function(data){
                        if (data.status == 200) {
                            Swal.fire({
                                position: "top-end",
                                title: 'บันทึกข้อมูลสำเร็จ',
                                text: "You Insert data success",
                                icon: 'success',
                                showCancelButton: false,
                                confirmButtonColor: '#06D177',
                                // cancelButtonColor: '#d33',
                                confirmButtonText: 'เรียบร้อย'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                        wh_loadtotal();
                                        load_shooping_table();
                                        $('#edit_qty').val("");
                                        $('#edit_pro_kind1').val("");
                                        $('#edit_pro_kind2').val("");
                                        $('#edit_pro_kind3').val("");
                                        $('#Addproduct_pic1Modal').modal('hide');
                                        $('#Addproduct_pic2Modal').modal('hide');
                                        $('#Addproduct_pic3Modal').modal('hide');
                                }
                            })
                        } else {

                        }
                    }
                  });
            });
            $('#Addpro3').on('submit',function(e){
                  e.preventDefault();
                  var form = this;
                    //   alert('OJJJJOL');
                  $.ajax({
                    url:$(form).attr('action'),
                    method:$(form).attr('method'),
                    data:new FormData(form),
                    processData:false,
                    dataType:'json',
                    contentType:false,
                    beforeSend:function(){
                      $(form).find('span.error-text').text('');
                    },
                    success:function(data){
                        if (data.status == 200) {
                            Swal.fire({
                                position: "top-end",
                                title: 'บันทึกข้อมูลสำเร็จ',
                                text: "You Insert data success",
                                icon: 'success',
                                showCancelButton: false,
                                confirmButtonColor: '#06D177',
                                // cancelButtonColor: '#d33',
                                confirmButtonText: 'เรียบร้อย'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                        wh_loadtotal();
                                        load_shooping_table();
                                        $('#edit_qty').val("");
                                        $('#edit_pro_kind1').val("");
                                        $('#edit_pro_kind2').val("");
                                        $('#edit_pro_kind3').val("");
                                        $('#Addproduct_pic1Modal').modal('hide');
                                        $('#Addproduct_pic2Modal').modal('hide');
                                        $('#Addproduct_pic3Modal').modal('hide');
                                }
                            })
                        } else {

                        }
                    }
                  });
            });

            $('#Addpro5').on('submit',function(e){
                  e.preventDefault();
                  var form = this;
                    //   alert('OJJJJOL');
                  $.ajax({
                    url:$(form).attr('action'),
                    method:$(form).attr('method'),
                    data:new FormData(form),
                    processData:false,
                    dataType:'json',
                    contentType:false,
                    beforeSend:function(){
                      $(form).find('span.error-text').text('');
                    },
                    success:function(data){
                        if (data.status == 200) {
                            Swal.fire({
                                position: "top-end",
                                title: 'บันทึกข้อมูลสำเร็จ',
                                text: "You Insert data success",
                                icon: 'success',
                                showCancelButton: false,
                                confirmButtonColor: '#06D177',
                                // cancelButtonColor: '#d33',
                                confirmButtonText: 'เรียบร้อย'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                        wh_loadtotal();
                                        load_shooping_table();
                                        $('#edit_qty').val("");
                                        $('#edit_pro_kind1').val("");
                                        $('#edit_pro_kind2').val("");
                                        $('#edit_pro_kind3').val("");
                                        $('#Addproduct_pic1Modal').modal('hide');
                                        $('#Addproduct_pic2Modal').modal('hide');
                                        $('#Addproduct_pic3Modal').modal('hide');
                                        $('#Addproduct_pic5Modal').modal('hide');
                                }
                            })
                        } else {

                        }
                    }
                  });
            });


        });
    </script>


@endsection
