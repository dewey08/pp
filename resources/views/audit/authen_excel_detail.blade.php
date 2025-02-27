@extends('layouts.audit')
@section('title', 'PK-OFFICE || checksit')
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
        border-top: 10px #0dc79f solid;
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
        <div class="row">
            <div class="col-md-12">
                 <div class="card card_audit_4">
                    <div class="card-header" style="color:rgb(248, 102, 97)">
                        Report check Authen
                        <div class="btn-actions-pane-right">
                            <div role="group" class="btn-group-sm btn-group">
                                {{-- <button type="button" class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                    <i class="pe-7s-science btn-icon-wrapper"></i>Token
                                </button> --}}

                            </div>
                        </div>
                    </div>
                    <div class="card-body">

                        <div class="table-responsive">
                            <table id="scroll-vertical-datatable" class="table table-sm table-striped dt-responsive nowrap w-100">
                            {{-- <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;"> --}}
                                <thead>
                                    <tr>
                                        <th>ลำดับ</th>
                                        {{-- <th>vn</th> --}}
                                        <th>hn</th>
                                        <th>cid</th>
                                        <th>tel</th>
                                        <th>vstdate</th>
                                        <th>fullname</th>
                                        <th>pttype Hos</th>
                                        <th>hmain Hos</th>
                                        <th>hsub Hos</th>
                                        <th>pttype สปสช</th>
                                        {{-- <th>hmainสปสช</th> --}}
                                        {{-- <th>hsubสปสช</th> --}}
                                        <th>claimtype</th>
                                        <th>staff</th>
                                        <th>main_dep</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $ia = 1; ?>
                                    @foreach ($data_sit as $item)
                                        <tr>
                                            <td>{{ $ia++ }}</td>
                                            {{-- <td>{{ $item->vn }}</td> --}}
                                            <td>{{ $item->hn }}</td>
                                            <td>{{ $item->cid }}</td>
                                            <td>{{ $item->hometel }}</td>
                                            <td>{{ $item->vstdate }}</td>
                                            <td>{{ $item->fullname }}</td>
                                            <td style="background-color: rgb(255, 255, 255)">{{ $item->pttype }}</td>
                                            <td >{{ $item->hospmain }}</td>
                                            <td>{{ $item->hospsub }}</td>
                                            <td style="background-color: rgb(255, 255, 255)">{{ $item->subinscl }}</td>
                                            {{-- <td>{{ $item->hmain }}</td> --}}
                                            {{-- <td>{{ $item->hsub }}</td> --}}
                                            <td style="background-color: rgb(253, 150, 185)">{{ $item->claimtype }}</td>
                                            <td>{{ $item->staff }}</td>
                                            <td>{{ $item->department }}</td>
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


@endsection
@section('footer')

<script>
    //  window.setTimeout(function() {
    //         window.location.reload();
    //     },500000);
    $(document).ready(function() {
        // $("#overlay").fadeIn(300);　

        $('#datepicker').datepicker({
            format: 'yyyy-mm-dd'
        });
        $('#datepicker2').datepicker({
            format: 'yyyy-mm-dd'
        });

        $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
        });

        $("#spinner-div").hide(); //Request is complete so hide spinner



    });
</script>
@endsection

