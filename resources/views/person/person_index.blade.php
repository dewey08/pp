@extends('layouts.person_new')
@section('title', 'PK-OFFICE || บุคลากร')
@section('content')
<script>
    function TypeAdmin() {
        window.location.href = '{{ route('index') }}';
    }

    function person_destroy(id)
    {
      Swal.fire({
      title: 'ต้องการลบใช่ไหม?',
      text: "ข้อมูลนี้จะถูกลบไปเลย !!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'ใช่, ลบเดี๋ยวนี้ !',
      cancelButtonText: 'ไม่, ยกเลิก'
      }).then((result) => {
      if (result.isConfirmed) {
          $.ajax({
          url:"{{url('person/person_destroy')}}" +'/'+ id,
          type:'DELETE',
          data:{
              _token : $("input[name=_token]").val()
          },
          success:function(response)
          {
              Swal.fire({
                title: 'ลบข้อมูล!',
                text: "You Delet data success",
                icon: 'success',
                showCancelButton: false,
                confirmButtonColor: '#06D177',
                // cancelButtonColor: '#d33',
                confirmButtonText: 'เรียบร้อย'
              }).then((result) => {
                if (result.isConfirmed) {
                  $("#sid"+id).remove();
                  window.location.reload();
                //   window.location = "/person/person_index"; //
                }
              })
          }
          })
        }
        })
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
        border-top: 10px #d22cf3 solid;
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
        <div class="row">
            <div class="col-md-4">
                <h4 style="color:#f80d6f">ข้อมูลบุคลากร</h4>
            </div>
            <div class="col"></div>
            <div class="col-md-2 text-end">
                <a href="{{ url('person/person_index_add') }}" class="ladda-button me-2 btn-pill btn btn-sm btn-info input_new"  >
                    <i class="fa-solid fa-folder-plus text-white me-2"></i>
                    เพิ่มข้อมูลบุคลากร
                </a>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-md-12">
                <div class="card card_audit_4c">

                    <div class="card-body">

                        <div class="table-responsive">
                                <table id="example" class="table table-sm table-striped table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th width="5%" class="text-center">ลำดับ</th>
                                        <th class="text-center" width="13%">ชื่อ-นามสกุล</th>
                                        <th class="text-center" width="15%">ตำแหน่ง</th>
                                        <th class="text-center" width="20%">กลุ่มงาน</th>
                                        <th class="text-center">ฝ่าย/แผนก</th>
                                        <th class="text-center">หน่วยงาน</th>
                                        <th width="7%" class="text-center">Manage</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1;

                                    $date = date('Y');

                                    ?>
                                    @foreach ($users as $mem)
                                        <tr id="sid{{ $mem->id }}">
                                            <td class="text-center" width="5%">{{ $i++ }}</td>
                                            <td class="p-2" width="13%">{{ $mem->prefix_name }}{{ $mem->fname }} {{ $mem->lname }}</td>
                                            <td class="p-2" width="15%">{{ $mem->POSITION_NAME }}</td>
                                            <td class="p-2" width="20%">{{$mem->DEPARTMENT_NAME}}</td>
                                            <td class="p-2">{{$mem->DEPARTMENT_SUB_NAME}}</td>
                                            <td class="p-2">{{$mem->DEPARTMENT_SUB_SUB_NAME}}</td>

                                            <td class="text-center" width="7%">
                                                <div class="btn-group">

                                                    <button type="button" class="btn btn-sm dropdown-toggle input_new" data-bs-toggle="dropdown" aria-expanded="false">
                                                        ทำรายการ
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item text-warning" href="{{ url('person/person_index_edit/' .$mem->id) }}"
                                                            data-bs-toggle="tooltip" data-bs-placement="left" data-bs-custom-class="custom-tooltip" title="แก้ไข">
                                                            <i class="fa-solid fa-pen-to-square me-2"></i>
                                                            <label for="" style="color: rgb(252, 185, 0);font-size:13px">แก้ไข</label>
                                                        </a>

                                                        <div class="dropdown-divider"></div>
                                                        <a class="dropdown-item text-danger" href="javascript:void(0)" onclick="person_destroy({{ $mem->id }})" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-custom-class="custom-tooltip" title="ลบ">
                                                            <i class="fa-solid fa-trash-can me-2"></i>
                                                            <label for="" style="color: rgb(255, 2, 2);font-size:13px">ลบ</label>
                                                        </a>
                                                    </div>
                                                </div>

                                            </td>
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

    <!--Edit  Modal update_type -->
    <div class="modal fade" id="editexampleModal" tabindex="-1" aria-labelledby="editexampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editexampleModalLabel">กำหนดการสิทธิ์เข้าถึง</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" id="update_type">
                        @csrf
                        @method('PUT')
                        <input type="hidden" class="form-control" id="edittype_id" name="edittype_id" />


                        <div class="col-md-12">
                            <div class="form-group">
                                {{-- <input type="text" class="form-control" id="edittype_name" name="type" placeholder=""> --}}
                                <select class="form-control" id="edittype_name" name="type" style="width: 100%">
                                    {{-- <option value=""></option> --}}
                                    <option value="STAFF">STAFF</option>
                                    <option value="ADMIN">ADMIN</option>
                                    <option value="CUSTOMER">CUSTOMER</option>
                                    <option value="MANAGE">MANAGE</option>
                                    <option value="USER">USER</option>
                                    <option value="NOTUSER">NOTUSER</option>
                                </select>
                            </div>
                        </div>


                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-outline-success rounded-pill">
                        <i class="ri-save-3-fill me-1"></i>
                        Save
                    </button>
                    <button type="button" class="btn btn-outline-danger rounded-pill" data-bs-dismiss="modal">
                        <i class="ri-shut-down-line me-1"></i>
                        Cancel
                    </button>

                </div>
                </form>
            </div>
        </div>
    </div>






@endsection

@section('footer')

    <script>
         $(document).ready(function() {
            $('#Recieve').on('shown.bs.modal', function() {
                $('#datepicker').datepicker({format: 'yyyy-mm-dd'});
            });
            $('#stock_list_id').select2({
                placeholder: "--ตัดจากคลัง(หลัก)--",
                allowClear: true
            });
            $('#stock_list_subid').select2({
                placeholder: "--เข้าคลัง(ย่อย)--",
                allowClear: true
            });
            $('#user_request').select2({
                placeholder: "--ผู้ร้องขอ(ย่อย)--",
                allowClear: true
            });

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('#InsertData').click(function() {
                var request_no           = $('#request_no').val();
                var request_date         = $('#request_date').val();
                var request_time         = $('#request_time').val();
                var stock_list_subid     = $('#stock_list_subid').val();
                var stock_list_id        = $('#stock_list_id').val();
                var bg_yearnow           = $('#bg_yearnow').val();
                var user_request         = $('#user_request').val();

                Swal.fire({ position: "top-end",
                        title: 'ต้องการเพิ่มข้อมูลใช่ไหม ?',
                        text: "You Warn Add Bill No!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, Add it!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $("#overlay").fadeIn(300);　
                                $("#spinner").show(); //Load button clicked show spinner

                                $.ajax({
                                    url: "{{ route('wh.wh_main_paysave') }}",
                                    type: "POST",
                                    dataType: 'json',
                                    data: {request_no,request_date,request_time,stock_list_subid,stock_list_id,bg_yearnow,user_request},
                                    success: function(data) {
                                        if (data.status == 200) {
                                            Swal.fire({ position: "top-end",
                                                title: 'เพิ่มข้อมูลสำเร็จ',
                                                text: "You Add data success",
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
        $(document).ready(function() {
            $('#example').DataTable();
            $('#example2').DataTable();

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
        });
        $(document).on('click', '.showDocument', function() {
                $('#showDocumentModal').modal('show');
        });
    </script>


@endsection
