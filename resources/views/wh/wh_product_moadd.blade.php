@extends('layouts.wh')
@section('title', 'PK-OFFICE || Where House')

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
use App\Http\Controllers\StaticController;
use Illuminate\Support\Facades\DB;
$count_land = StaticController::count_land();
$count_building = StaticController::count_building();
$count_article = StaticController::count_article();
?>


@section('content')
    <script>
        function TypeAdmin() {
            window.location.href = '{{ route('index') }}';
        }

        function addarticle(input) {
            var fileInput = document.getElementById('img');
            var url = input.value;
            var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
            if (input.files && input.files[0] && (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg")) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#edit_upload_preview').attr('src', e.target.result);

                }
                reader.readAsDataURL(input.files[0]);

            } else {
                alert('กรุณาอัพโหลดไฟล์ประเภทรูปภาพ .jpeg/.jpg/.png/.gif .');
                fileInput.value = '';
                return false;
            }
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

    date_default_timezone_set('Asia/Bangkok');
$date = date('Y') + 543;
$datefull = date('Y-m-d H:i:s');
$time = date("H:i:s");
$loter = $date.''.$time

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
    {{-- <div id="preloader">
        <div id="status">
            <div id="container_spin">
                <svg viewBox="0 0 100 100">
                    <defs>
                        <filter id="shadow">
                        <feDropShadow dx="0" dy="0" stdDeviation="2.5"
                            flood-color="#fc6767"/>
                        </filter>
                    </defs>
                    <circle id="spinner" style="fill:transparent;stroke:#dd2476;stroke-width: 7px;stroke-linecap: round;filter:url(#shadow);" cx="50" cy="50" r="45"/>
                </svg>
            </div>
        </div>
    </div> --}}

    <div class="row">
        <div class="col">
            <h4 style="color:rgb(10, 151, 85)">เพิ่มรายการวัสดุ</h4>
            {{-- <p class="card-title-desc" style="font-size: 17px;">เพิ่มรายการวัสดุ</p> --}}
        </div>

        <div class="col-2 text-end">
        <a href="{{url('wh_product')}}" class="ladda-button me-2 btn-pill btn btn-warning input_new">
            <i class="fa-solid fa-arrow-left me-2"></i>
           {{-- ย้อนกลับ --}}
        </a>

    </div>
    </div>

    <form class="custom-validation" action="{{ route('wh.wh_product_mosave') }}" method="POST" id="update_Form" enctype="multipart/form-data">
        @csrf

        <div class="row fsize12 mt-2">
            <div class="col-md-12">
                <div class="card input_new p-3">

                    <div class="card-body">

                        <input type="hidden" name="store_id" id="store_id" value=" {{ Auth::user()->store_id }}">
                        {{-- <input type="hidden" name="air_list_id" id="air_list_id" value=" {{ $data_edit->air_list_id }}"> --}}

                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                        {{-- @if ($data_edit->air_img == null) --}}
                                            <img src="{{ asset('assets/images/default-image.jpg') }}" id="edit_upload_preview"
                                                height="250px" width="300px" alt="Image" class="img-thumbnail input_new">
                                        {{-- @else --}}
                                            {{-- <img src="{{ asset('storage/air/' . $data_edit->air_img) }}"
                                                id="edit_upload_preview" height="100px" width="300px" alt="Image"
                                                class="img-thumbnail bg_prs"> --}}
                                                {{-- <img src="data:image/png;base64,{{ $data_edit->air_img }}" id="edit_upload_preview" height="250px" width="250px" alt="Image"> --}}
                                        {{-- @endif --}}
                                </div>
                            </div>
                        </div>

                        <div class="row ">
                            <div class="col">
                                <div class="form-group">
                                    <div class="input-group mt-3">

                                        <input type="file" class="form-control bg_prs" id="img" name="img"
                                            onchange="addarticle(this)">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col-6">
                                <div class="input-group-prepend">
                                    <label class="input-group-text" for="pro_year">ปีงบประมาณ</label>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="input-group-prepend">
                                    <input type="text" class="form-control bg_prs" name="pro_year" id="pro_year" value="{{ $bg_yearnow }}" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col">
                                <div class="input-group input-group-sm">
                                    <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroup-sizing-sm">วันที่รับเข้า</span>
                                    </div>
                                    <input type="date" style="font-size: 13px" type="text" class="form-control bg_prs" id="recieve_date" name="recieve_date" aria-label="recieve_date" aria-describedby="inputGroup-sizing-sm" value="{{$datenow}}">
                                </div>
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col">
                                <div class="input-group input-group-sm">
                                    <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroup-sizing-sm">รหัสวัสดุ</span>
                                    </div>
                                    <input style="font-size: 13px" type="text" class="form-control bg_prs" id="pro_code" name="pro_code" aria-label="pro_code" aria-describedby="inputGroup-sizing-sm" value="{{$max_pro_code}}">
                                </div>
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col">
                                <div class="input-group input-group-sm">
                                    <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroup-sizing-sm">ราคา</span>
                                    </div>
                                    <input style="font-size: 13px" type="text" class="form-control bg_prs" id="pro_price" name="pro_price" aria-label="pro_price" aria-describedby="inputGroup-sizing-sm">
                                </div>
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col">
                                <div class="input-group input-group-sm">
                                    <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroup-sizing-sm">ชื่อวัสดุ</span>
                                    </div>
                                    <input type="text" style="font-size: 14px" class="form-control bg_prs" id="pro_name" name="pro_name" aria-label="pro_name" aria-describedby="inputGroup-sizing-sm">
                                </div>
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col-5">
                                <div class="input-group-prepend">
                                    <label class="input-group-text" for="pro_type">ประเภท</label>
                                </div>
                            </div>
                            <div class="col-7">
                                <div class="input-group-prepend">
                                    <select class="js-example-basic-single" id="pro_type" name="pro_type" style="width: 100%" >
                                        @foreach ($wh_type as $bra)
                                            <option value="{{ $bra->wh_type_id }}">{{ $bra->wh_type_name }} </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col-5">
                                <div class="input-group-prepend">
                                    <label class="input-group-text" for="unit_id">หน่วยนับ</label>
                                </div>
                            </div>
                            <div class="col-7">
                                <div class="input-group-prepend">
                                    <select class="js-example-basic-single" id="unit_id" name="unit_id" style="width: 100%" >
                                        @foreach ($wh_unit as $uni)
                                            <option value="{{ $uni->wh_unit_id }}">{{ $uni->wh_unit_name }} </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>



                        <div class="row mt-2">
                            <div class="col-4">
                                <div class="input-group-prepend">
                                    <label class="input-group-text" for="active">สถานะ</label>

                                </div>
                            </div>
                            <div class="col-8">
                                <div class="input-group-prepend">
                                    <select class="js-example-basic-single" id="active" name="active" style="width: 100%">
                                        <option value="Y" selected>พร้อมใช้งาน</option>
                                        <option value="N">ไม่พร้อมใช้งาน</option>
                                    </select>
                                </div>
                            </div>
                        </div>


                        <div class="row mt-3 text-center">
                            <div class="col">
                                <div class="form-group">
                                    <button type="submit" class="btn-icon btn-shadow btn-dashed btn btn-info input_new">
                                        {{-- <i class="fa-regular fa-pen-to-square me-2"></i> --}}
                                        <img src="{{ asset('images/Savewhit.png') }}" class="me-2 ms-2" height="18px" width="18px">
                                        บันทึกข้อมูล
                                    </button>
                                    {{-- <button type="button" id="Addproduct" class="ladda-button me-2 btn-pill btn btn-sm btn-success card_prs_4" >
                                        <img src="{{ asset('images/Savewhit.png') }}" class="me-2 ms-2" height="18px" width="18px">
                                        บันทึกข้อมูล
                                   </button> --}}
                                </div>
                            </div>

                        </div>

                    </div>


                </div>
            </div>
        </div>

    </div>
</form>
@endsection
@section('footer')
<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
    <script src="{{ asset('js/gcpdfviewer.js') }}"></script>

<script>
     $(document).ready(function () {
            $('.js-example-basic-single').select2();
            $('.js-example-basic-multiple').select2();
            $("#js-example-responsive").select2({
                width: 'resolve'
            });
            $("#js-example-theme-multiple").select2({
                theme: "classic"
            });
          $('#example').DataTable();
          $('#example2').DataTable();
          $('#example3').DataTable();
          $('#example4').DataTable();
          $('#example5').DataTable();
          $('#table_id').DataTable();

          $('#air_location_id').select2({
              placeholder:"--เลือก--",
              allowClear:true
          });
          $('#air_year').select2({
              placeholder:"--เลือก--",
              allowClear:true
          });
          $('#active').select2({
              placeholder:"--เลือก--",
              allowClear:true
          });

          $('#bran_id').select2({
              placeholder:"--เลือก--",
              allowClear:true
          });



        $('#update_Form').on('submit',function(e){
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
                      if (data.status == 0 ) {

                      } else {
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
                            window.location.reload();
                            // window.location="{{url('air_main')}}";
                          }
                        })
                      }
                    }
                  });
        });

        // $('#Addproduct').click(function() {
        //         var pro_id           = $('#pro_id').val();
        //         var qty              = $('#qty').val();
        //         // var one_price        = $('#one_price').val();
        //         // var lot_no           = $('#lot_no').val();
        //         var stock_list_id    = $('#stock_list_id').val();
        //         var wh_request_id    = $('#wh_request_id').val();
        //         var stock_list_subid    = $('#stock_list_subid').val();
        //         var data_year        = $('#data_year').val();

        //                 $.ajax({
        //                     url: "{{ route('wh.wh_request_addsub_save') }}",
        //                     type: "POST",
        //                     dataType: 'json',
        //                     data: {pro_id,qty,wh_request_id,stock_list_id,data_year,stock_list_subid},
        //                     success: function(data) {
        //                         load_datauser_table();
        //                         load_data_usersum();
        //                         // load_data_sum();
        //                         $('#qty').val("");
        //                         // $('#pro_id').val("");

        //                     },
        //                 });

        //             // }
        //         // })
        // });



      });
</script>
@endsection
