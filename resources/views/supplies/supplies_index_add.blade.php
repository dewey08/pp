@extends('layouts.supplies')
@section('title', 'PK-OFFICE || พัสดุ')
{{-- @section('menu') --}}
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
    .btn {
        font-size: 15px;
    }

    .bgc {
        background-color: #264886;
    }

    .bga {
        background-color: #fbff7d;
    }
</style>
<?php
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\SuppliesController;
use App\Http\Controllers\StaticController;
$refnumber = SuppliesController::refnumber();
$count_product = StaticController::count_product();
$count_service = StaticController::count_service();
?>

@section('content')

    <div class="container-fluid " style="width: 97%">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header"> 
                        <div class="d-flex">
                            <div class="">
                                <label for="">เพิ่มข้อมูลวัสดุ </label>
                            </div>
                            <div class="ms-auto">
                                <form class="custom-validation" action="{{ route('sup.supplies_index_save') }}" method="POST"
                                id="insert_productForm" enctype="multipart/form-data">
                                @csrf

                                <div class="row">  
                                    <div class="col-md-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="product_claim" id="product_claim" value="CLAIM" >
                                            <label class="form-check-label" for="product_claim">
                                            เคลม
                                            </label>
                                        </div> 
                                    </div> 
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="product_claim" id="product_claim" value="NOCLAIM" checked>
                                            <label class="form-check-label" for="product_claim">
                                                ไม่เคลม
                                            </label>
                                            </div>
                                    </div> 
                                    <div class="col me-5"></div>
                                </div> 
                            </div>
                        </div>
                    </div>
                    <div class="card-body shadow-lg">
                       
                            <input type="hidden" name="store_id" id="store_id" value="{{ Auth::user()->store_id }}">

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <img src="{{ asset('assets/images/default-image.jpg') }}" id="add_upload_preview"
                                            alt="Image" class="img-thumbnail" width="350px" height="350px">
                                        <br>
                                        <div class="input-group mb-3">
                                            <label class="input-group-text" for="img">Upload</label>
                                            <input type="file" class="form-control" id="img" name="img"
                                                onchange="addproducts(this)">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="row">
                                        <div class="col-md-2 text-end">
                                            <label for="article_year">รหัสวัสดุ :</label>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <input id="product_code" type="text" class="form-control form-control-sm"
                                                    name="product_code" value="{{ $refnumber }}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-2 text-end">
                                            <label for="article_recieve_date">รายการวัสดุ :</label>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <input id="product_name" type="text" class="form-control form-control-sm"
                                                    name="product_name">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-3">
                                        <div class="col-md-2 text-end">
                                            <label for="article_num">คุณลักษณะ :</label>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <input id="product_attribute" type="text" class="form-control form-control-sm"
                                                    name="product_attribute">
                                            </div>
                                        </div>
                                        <div class="col-md-2 text-end">
                                            <label for="article_name">ชนิดวัสดุ :</label>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <select id="product_groupid" name="product_groupid"
                                                    class="form-select form-select-lg" style="width: 100%">
                                                    <option value="">--เลือก--</option>
                                                    @foreach ($product_group as $progroup)
                                                        <option value="{{ $progroup->product_group_id }}">
                                                            {{ $progroup->product_group_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-3">
                                        <div class="col-md-2 text-end">
                                            <label for="article_attribute">ประเภทวัสดุ :</label>
                                        </div>
                                        <div class="col-md-4 ">
                                            <div class="form-group">
                                                <select id="product_typeid" name="product_typeid"
                                                    class="form-select form-select-lg" style="width: 100%">
                                                    <option value="1">วัสดุ</option>
                                                    <!-- @foreach ($product_type as $protype)
    <option value="{{ $protype->sub_type_id }}"> {{ $protype->sub_type_name }} </option>
    @endforeach -->
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2 text-end">
                                            <label for="vendor_id">หมวดวัสดุ :</label>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <select id="product_categoryid" name="product_categoryid"
                                                    class="form-select form-select-lg" style="width: 100%">
                                                    <option value="">--เลือก--</option>
                                                    @foreach ($product_category as $procat)
                                                        <option value="{{ $procat->category_id }}">
                                                            {{ $procat->category_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row mt-3">
                                        <div class="col-md-2 text-end">
                                            <label for="article_price">ราคาสืบ :</label>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <select id="product_spypriceid" name="product_spypriceid"
                                                    class="form-select form-select-lg" style="width: 100%">
                                                    <option value="">--เลือก--</option>
                                                    @foreach ($product_spyprice as $prospy)
                                                        <option value="{{ $prospy->spyprice_id }}">
                                                            {{ $prospy->spyprice_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <!-- <div class="col-md-2 text-end">
                                                                <label for="article_buy_id">การจัดซื้อ :</label>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <select id="product_unit_bigid" name="product_unit_bigid"
                                                                        class="form-select form-select-lg show_unit" style="width: 100%">
                                                                        <option value=""></option>
                                                                        @foreach ($product_unit as $prounit)
                                                        <option value="{{ $prounit->unit_id }}">
                                                            {{ $prounit->unit_name }}
                                                        </option>
                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div> -->
                                    </div>


                                    <div class="row mt-3">
                                        <div class="col-md-2 text-end">
                                            <label for="product_unit_bigid">หน่วยบรรจุ :</label>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <select id="product_unit_bigid" name="product_unit_bigid"
                                                    class="form-select form-select-lg show_unit" style="width: 100%">
                                                    <option value="">--เลือก--</option>
                                                    @foreach ($product_unit as $prounit)
                                                        <option value="{{ $prounit->unit_id }}">
                                                            {{ $prounit->unit_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-2 text-end">
                                            <label for="" style="color: rgb(255, 145, 0)">* ถ้าไม่มีให้เพิ่ม
                                            </label>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <div class="form-outline bga">
                                                    <input type="text" id="UNIT_INSERT" name="UNIT_INSERT"
                                                        class="form-control form-control-sm shadow" />
                                                    {{-- <label class="form-label" for="UNIT_INSERT" style="color: rgb(255, 72, 0)">เพิ่มหน่วยนับ</label> --}}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                            <div class="form-group">
                                                <button type="button" class="btn btn-primary btn-sm"
                                                    onclick="addunit();">
                                                    เพิ่ม
                                                </button>
                                            </div>
                                        </div>
                                        <div class="col-md-1"> </div>

                                    </div>



                                    <div class="row mt-3">
                                        <div class="col-md-2 text-end">
                                            <label for="product_unit_subid">หน่วยย่อย :</label>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <select id="product_unit_subid" name="product_unit_subid"
                                                    class="form-select form-select-lg show_unitsub" style="width: 100%">
                                                    <option value="">--เลือก--</option>
                                                    @foreach ($product_unit as $uni)
                                                        <option value="{{ $uni->unit_id }}">
                                                            {{ $uni->unit_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-2 text-end">
                                            <label for="" style="color: rgb(255, 145, 0)">* ถ้าไม่มีให้เพิ่ม
                                            </label>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-outline bga">
                                                <input type="text" id="UNIT_SUBINSERT" name="UNIT_SUBINSERT"
                                                    class="form-control form-control-sm shadow" />
                                                {{-- <label class="form-label" for="UNIT_SUBINSERT" style="color: rgb(255, 72, 0)">เพิ่มหน่วยนับ</label> --}}
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                            <div class="form-group">
                                                <button type="button" class="btn btn-primary btn-sm"
                                                    onclick="addunitsub();">
                                                    เพิ่ม
                                                </button>
                                            </div>
                                        </div>

                                    </div>

                                </div>
                            </div>
                    </div>
                    <div class="card-footer">
                        <div class="col-md-12 text-end">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-sm">
                                    <i class="fa-solid fa-floppy-disk me-2"></i>
                                    บันทึกข้อมูล
                                </button>
                                <a href="{{ url('supplies/supplies_index') }}" class="btn btn-danger btn-sm">
                                    <i class="fa-solid fa-xmark me-2"></i>
                                    ยกเลิก
                                </a>
                            </div>
                        </div>
                    </div>

                    </form>
                </div>
            </div>
        </div>
    </div>





@endsection
