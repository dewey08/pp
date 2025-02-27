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
        /* @keyframes zoom {
            0% {
                scale: 100%
            }
            50% {
                scale: 150%;
            }
            100% {
                scale: 100%;
            }
        } */

        /* .click-zoom img {
            margin: 5px;
            transition: transform 0.25s ease;
            cursor: zoom-in
        } */
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
        {{-- <div class="container">  --}}

            <div class="row mt-2">
                <div class="col-md-4">
                    <h4 style="color:rgb(2, 94, 148)">เลขที่บิล {{ $data_edit->request_no }}</h4>
                </div>

                <div class="col text-end">
                    {{-- <button type="button" id="UpdateData" class="ladda-button me-2 btn-pill btn btn-sm btn-success card_prs_4" >
                        <img src="{{ asset('images/Savewhit.png') }}" class="me-2 ms-2" height="18px" width="18px">
                       บันทึก
                   </button> --}}
                   <div id="headingTwo" class="b-radius-0">
                        <button class="me-2 btn-icon btn-icon-only btn btn-link btn-sm card_red_4" data-bs-toggle="collapse" data-bs-target="#collapseOne2" aria-expanded="false" aria-controls="collapseTwo" class="btn-icon btn-shadow btn-dashed btn btn-outline-secondary">
                            <img src="{{ asset('images/Shopping_Cart.png') }}"  class="me-2 ms-2" height="27px" width="27px">
                            <span class="badge rounded-pill bg-success load_total" style="font-size: 17px;">0</span>
                        </button>
                        <a href="{{url('wh_sub_main_rp')}}" class="ladda-button me-2 btn-pill btn btn-danger card_prs_4">
                            <img src="{{ asset('images/back.png') }}" class="me-2 ms-2" height="25px" width="25px">
                            ยกเลิก
                        </a>
                    </div>



                    {{-- <div id="headingTwo" class="b-radius-0">
                        <button type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne2" aria-expanded="false" aria-controls="collapseTwo" class="btn-icon btn-shadow btn-dashed btn btn-outline-secondary" style="background-color: rgb(176, 205, 243);border-radius: 3em 3em 3em 3em">
                            เพิ่มแผนจัดซื้อพัสดุ-ครุภัณฑ์
                        </button>
                    </div> --}}

                </div>
            </div>

            <div data-parent="#accordion" id="collapseOne2" class="collapse">
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card card_prs">

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
                     <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#office" role="tab">
                                <span class="d-block d-sm-none"> <img src="{{ asset('images/Office_new.png') }}" height="35px" width="35px"></span>
                                <span class="d-none d-sm-block"> วัสดุสำนักงาน</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#kitchen" role="tab">
                                <span class="d-block d-sm-none"><img src="{{ asset('images/chicken_new.png') }}" height="35px" width="35px"></span>
                                <span class="d-none d-sm-block">วัสดุงานบ้านงานครัว</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#nutrition" role="tab">
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
                    <div class="tab-content p-2 text-muted">
                        <div class="tab-pane active" id="office" role="tabpanel">
                            <p class="mb-0">
                                <div class="row">
                                    @foreach ($wh_product_1 as $item)
                                        <div class="col-md-2">
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
                            </p>
                        </div>
                        <div class="tab-pane" id="kitchen" role="tabpanel">
                            <p class="mb-0">
                                <div class="row mt-2">
                                    @foreach ($wh_product_2 as $item2)
                                        <div class="col-md-2">
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
                        <div class="tab-pane" id="nutrition" role="tabpanel">
                            <p class="mb-0">
                                <div class="row mt-2">
                                    <input class="form-control" id="myInput" type="text" placeholder="Search..">
                                    <br>
                                    @foreach ($wh_product_3 as $item3)
                                        <div class="col-md-2">
                                            <div class="card card_prs text-center" style="background-color: rgb(238, 252, 255);height: 170px;">
                                                {{-- <div class="card-body">
                                                    <div class="row">
                                                        <div class="col" style="font-size: 12px;height: 35px;">{{$item3->pro_name}}</div>
                                                        <input type="hidden" class="form-control form-control-sm" id="pro_id" name="pro_id" value="{{$item3->pro_id}}">
                                                    </div>
                                                    <div class="row">
                                                        <div class="col">
                                                            <button type="button" class="ladda-button btn-pill btn btn-sm Addproduct_pic" value="{{ $item3->pro_id }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" title="เพิ่มรายการวัสดุลงใน List">
                                                                @if ($item3->img_base =='')
                                                                <img src="{{ asset('assets/images/default-image.jpg') }}" height="100px" width="100px" alt="Image" class="img-thumbnail zoom">
                                                                @else
                                                                <img src="{{ $item3->img_base }}" alt="Image" height="auto" width="80px" class="img-thumbnail zoom">
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
                                                                        <p class="text-start mb-2" style="font-size: 12px">{{$item3->pro_name}}</p>
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



@endsection
@section('footer')

    <script>
        var Linechart;
        $(document).ready(function() {
            $('select').select2();
            $('#example').DataTable();
            $('#example2').DataTable();
            $("#myInput").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("#card d-flex").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });

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
                                // $('#edit_qty').val("");
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

        });
    </script>


@endsection
