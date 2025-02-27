<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>

        <!-- Font Awesome -->
        <link href="{{ asset('assets/fontawesome/css/all.css') }}" rel="stylesheet">
        <!-- App favicon -->
        <link rel="shortcut icon" href="{{ asset('pkclaim/images/logo150.ico') }}">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <link rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css"
            integrity="sha512-mSYUmp1HYZDFaVKK//63EcZq4iFWFjxSL+Z3T/aCt4IO9Cejm03q3NKKYN6pFQzY0SBOr8h+eCIAZHPXcpZaNw=="
            crossorigin="anonymous" referrerpolicy="no-referrer" />

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Thai+Looped:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Srisakdi:wght@400;700&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Thai:wght@300&display=swap" rel="stylesheet">


        <link href="{{ asset('pkclaim/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
        <link href="{{ asset('pkclaim/libs/spectrum-colorpicker2/spectrum.min.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ asset('pkclaim/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css') }}" rel="stylesheet">
        <!-- jquery.vectormap css -->
        <link href="{{ asset('pkclaim/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css') }}" rel="stylesheet" type="text/css"/>
        <!-- DataTables -->
        <link href="{{ asset('pkclaim/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('pkclaim/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('pkclaim/libs/datatables.net-select-bs4/css//select.bootstrap4.min.css') }}" rel="stylesheet" type="text/css"/>
        <!-- Responsive datatable examples -->
        <link href="{{ asset('pkclaim/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css"/>
        <!-- Bootstrap Css -->
        <link href="{{ asset('pkclaim/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="{{ asset('pkclaim/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="{{ asset('pkclaim/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
        <link href="{{ asset('css/fullcalendar.css') }}" rel="stylesheet">
        <!-- select2 -->
        <link rel="stylesheet" href="{{asset('asset/js/plugins/select2/css/select2.min.css')}}">
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <link rel="stylesheet" href="{{ asset('disacc/vendors/pixeden-stroke-7-icon-master/pe-icon-7-stroke/dist/pe-icon-7-stroke.css') }}">
        <!-- Plugins css -->
        <link href="{{ asset('assets/libs/dropzone/min/dropzone.min.css') }}" rel="stylesheet" type="text/css" />
        {{-- <link href="{{ asset('css/loginheader.css') }}" rel="stylesheet" /> --}}
        {{-- <link href="{{ asset('acccph/styles/css/base.css') }}" rel="stylesheet"> --}}
        {{-- <link href="{{ asset('assets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css"> --}}
</head>
 <style>
        body{
        background:
            /* url(/pkbackoffice/public/images/bg2.jpg); */
            /* -webkit-background-size: cover; */
        background-repeat: no-repeat;
		background-attachment: fixed;
		/* background-size: cover; */
        background-size: 100% 100%;
        /* font-family: Arial, Helvetica, sans-serif; */

        font-size:13px;
        /* font-family: "Noto Sans Thai Looped", sans-serif; */
            font-weight: 100;
            font-style: normal;
        }
        * {box-sizing: border-box;}
        /* Button used to open the contact form - fixed at the bottom of the page */
        .open-button {
            background-color: #fc2968;
            color: white;
            padding: 14px 17px;
            border: none;
            cursor: pointer;
            opacity: 0.9;
            position: fixed;
            bottom: 17px;
            right: 23px;
            width: 150px;
        }
        .open-button_new {

            padding: 14px 17px;
            cursor: pointer;
            opacity: 0.9;
            position: fixed;
            bottom: 2px;
            right: 23px;
            width: 100px;
            height: 100px;
        }
        /* The popup form - hidden by default */
        .form-popup {
            display: none;
            position: fixed;
            bottom: 0;
            right: 15px;
            border: 3px solid #f1f1f1;
            z-index: 9;
        }
        /* Add styles to the form container */
        .form-container {
            max-width: 320px;
            padding: 10px;
            background-color: white;
        }
        /* Full-width input fields */
        .form-container input[type=text], .form-container input[type=password] {
            width: 100%;
            padding: 15px;
            margin: 5px 0 22px 0;
            border: none;
            background: #f1f1f1;
        }
        /* When the inputs get focus, do something */
        .form-container input[type=text]:focus, .form-container input[type=password]:focus {
            background-color: #ddd;
            outline: none;
        }
        /* Set a style for the submit/login button */
        .form-container .btn {
            box-sizing : content-box;
            background-color: #04AA6D;
            text-align: center;
            color: white;
            /* padding: 15px 15px; */
            padding: 10px;
            border: none;
            cursor: pointer;
            width: 40%;
            height: 10px;
            /* position: absolute; */
            margin-bottom:10px;
            opacity: 0.8;
        }
        /* Add a red background color to the cancel button */
        .form-container .cancel {
            background-color: red;
        }
        /* Add some hover effects to buttons */
        .form-container .btn:hover, .open-button:hover {
            opacity: 1;
        }

 </style>

<style>
    @font-face {
        font-family: 'Poppins';
        font-style: normal;
        font-weight: 400;
        src: url('fonts/TorsilpSuChatBold.tff');
        font-size: 57px;
    }

    *{
        margin: 0;
        padding: 0;
    }
    .headerZ{
        z-index: 1;
        background:linear-gradient(-45deg,red,rgb(201, 241, 154),rgb(184, 230, 226),rgb(238, 238, 107));
        background-size: 400% 400%;
        width: 100%;
        height: 100vh;
        animation: animate 5s ease infinite;
    }
    @keyframes animate{
        0%{
            background-position: 0 50%;
        }
        50%{
            background-position: 100% 50%;
        }
        0%{
            background-position: 0 50%;
        }
    }
    @keyframes colorShift {
        0% {
            background-color: #22dcdf
        }
        50% {
            background-color: #2ed82e
        }
        100% {
            background-color: #e95a5a
        }
    }
    .loadingIcon {
        width: 40px;
        height: 40px;
        border: 2px solid rgb(255, 255, 255);
        /* border-bottom: 4px solid transparent; */
        border-radius: 100%;
        animation: 6s infinite linear spin;
    }
    .loadingIcon2 {
        width: 40px;
        height: 40px;
        border: 2px solid rgb(255, 255, 255);
        /* border-bottom: 4px solid transparent; */
        border-radius: 100%;
        animation: 3s infinite linear spin;
    }
    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }
        100% {
            transform: rotate(360deg);
        }
    }

    .input_border{
        /* border-radius: 2em 2em 2em 2em; */
        box-shadow: 0 0 15px rgb(124, 225, 250);
        /* border-color: #0583cc */
        border:solid 1px #0583cc;
    }
    .card_prs_2b{
        border-radius: 0em 0em 2em 2em;
        box-shadow: 0 0 15px rgb(124, 225, 250);
        /* border-color: #0583cc */
        border:solid 1px #0583cc;
    }
    .card_prs{
        border-radius: 1em 1em 1em 1em;
        box-shadow: 0 0 15px rgb(124, 225, 250);
        border:solid 1px #0583cc;
    }
    .card_borderlist{
        border-radius: 1em 1em 1em 1em;
        box-shadow: 0 0 15px rgb(124, 225, 250);
        border:solid 1px #93d0f3;
    }
    .card_prs_4{
        border-radius: 2em 2em 2em 2em;
        box-shadow: 0 0 15px rgb(124, 225, 250);
        /* border-color: #0583cc */
        border:solid 1px #0583cc;
    }
    .card_red_4{
        border-radius: 2em 2em 2em 2em;
        box-shadow: 0 0 15px rgb(124, 225, 250);
        /* border-color: #0583cc */
        border:solid 1px #f50d66;
    }
    .card_video{
        /* border-radius: 2em 2em 2em 2em; */
        box-shadow: 0 0 35px rgb(124, 225, 250);
        /* border-color: #0583cc */
        border:solid 1px #0583cc;
    }
    .prscheckbox{
        width: 20px;
        height: 20px;
        /* border-radius: 2em 2em 2em 2em; */
        border: 10px solid #0583cc;
        /* color: teal; */
        /* border-color: teal; */
        box-shadow: 0 0 10px #0583cc;
        /* box-shadow: 0 0 10px teal; */
    }
    .dcheckbox{
        width: 25px;
        height: 25px;
        /* border-radius: 2em 2em 2em 2em; */
        border: 2px solid #0583cc;
        /* color: teal; */
        /* border-color: teal; */
        box-shadow: 0 0 5px #0583cc;
        /* box-shadow: 0 0 10px teal; */
    }
    .dcheckboxsm{
        width: 17px;
        height: 17px;
        /* border-radius: 2em 2em 2em 2em; */
        border: 2px solid #93d0f3;
        /* color: teal; */
        /* border-color: teal; */
        box-shadow: 0 0 15px #93d0f3;
        /* box-shadow: 0 0 10px teal; */
    }
    .d12font{
        font-size: 12px;
    }
    .d13font{
        font-size: 13px;
    }
    .d14font{
        font-size: 14px;
    }
    .headerthai{
        /* font-family: 'Poppins', sans-serif; */
        font-family: Muli-Bold; src: url('fonts/TorsilpSuChatBold.tff');
    }
    .Head2{
			font-family: 'Srisakdi', sans-serif;
            /* font-size: 17px; */
            font-style: normal;
          font-weight: 500;
	}

        /* ********************************* Modal ********************************* */
        /* .modal-dialog {
        max-width: 50%;
    } */
    /* .modal-dialog modal-lg{
        max-width: 40%;
    } */
    .modal-dialog-slideout {
        min-height: 100%;
        margin:auto 90 0 0 90;   /*  ซ้าย ขวา */
        background: #fff;
    }
    .modal.fade .modal-dialog.modal-dialog-slideout {
        -webkit-transform: translate(100%, 0)scale(30);
        transform: translate(100%, 0)scale(5);
    }
    .modal.fade.show .modal-dialog.modal-dialog-slideout {
        -webkit-transform: translate(0, 0);
        transform: translate(0, 0);
        display: flex;
        align-items: stretch;
        -webkit-box-align: stretch;
        height: 100%;
    }
    .modal.fade.show .modal-dialog.modal-dialog-slideout .modal-body {
        overflow-y: auto;
        overflow-x: hidden;
    }
    .modal-dialog-slideout .modal-content {
        border: 0;
    }
    .modal-dialog-slideout .modal-header,
    .modal-dialog-slideout .modal-footer {
        height: 4rem;
        display: block;
    }
    .datepicker {
        z-index: 2051 !important;
    }
    .fontbtn{
            font-family: Verdana, Geneva, Tahoma, sans-serif;
            font-size: 12px;
            font-weight: 500;
    }

</style>

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
    use App\Http\Controllers\UsersuppliesController;
    use App\Http\Controllers\StaticController;
    use App\Models\Products_request_sub;
    $per_config               = StaticController::per_config($iduser);

    $org = DB::connection('mysql')->select('SELECT * FROM orginfo WHERE orginfo_id = 1');

?>
 {{-- <body data-topbar="dark" data-layout="horizontal"> --}}
 <body data-topbar="dark">

    <!-- Begin page -->
    <div id="layout-wrapper">

         <header id="page-topbar" class="input_border">
            <div class="navbar-header" style="background-color: rgb(10, 125, 151)" >

                <div class="d-flex">
                    <!-- LOGO -->
                    <div class="navbar-brand-box">
                        <a href="{{url('user/home')}}" class="logo logo-dark">
                            <span class="logo-sm">
                                <img src="assets/images/p.png" alt="logo-sm" height="22">
                                {{-- <img src="{{ asset('images/Logo_pk.png') }}" alt="logo-sm-light" height="110"> --}}
                            </span>
                            <span class="logo-lg">
                                <img src="assets/images/logo-dark.png" alt="logo-dark" height="20">
                                {{-- <img src="{{ asset('images/Logo_pk.png') }}" alt="logo-sm-light" height="110"> --}}
                            </span>
                        </a>

                        <a href="{{url('user/home')}}" class="logo logo-light">
                            <span class="logo-sm me-2">

                                {{-- <img src="{{ asset('images/Logo_pk.png') }}" alt="logo-sm-light" height="110"> --}}
                                <img src="{{ asset('images/pk_logo_new_white.png') }}" alt="logo-sm-light" height="110">
                            </span>
                            <span class="logo-lg">
                                <img src="{{ asset('images/pk_logo_new_white.png') }}" alt="logo-sm-light" height="110">

                                {{-- <img src="{{ asset('images/Logo_pk.png') }}" alt="logo-sm-light" height="110"> --}}
                            </span>

                        </a>
                    </div>

                        {{-- <button type="button" class="hamburger hamburger--elastic open-right-drawer mt-2" data-bs-toggle="collapse" data-bs-target="#topnav-menu-content">
                            <span class="hamburger-box">
                                <span class="hamburger-inner"></span>
                            </span>
                        </button> --}}
                        <button type="button" class="btn btn-sm px-3 font-size-24 d-lg-none header-item mt-2" data-bs-toggle="collapse" data-bs-target="#topnav-menu-content">
                            <i class="fa-solid fa-sliders"></i>
                        </button>

                        {{-- <form class="app-search d-none d-lg-block mt-3 ms-3">
                            <div class="position-relative">
                                <input type="text" class="form-control" placeholder="Search...">
                                <span class="ri-search-line"></span>
                            </div>
                         </form> --}}
                    <form class="app-search d-none d-lg-block mt-3 ms-4">
                        <div class="position-relative">
                            @foreach ($org as $item)
                            <h2 style="color:rgb(255, 255, 255)" class="mt-2 noto-sans-thai-looped-light Head2">{{$item->orginfo_name}}</h2>
                            @endforeach

                        </div>
                    </form>
                </div>

                <div class="d-flex">

                        <div class="header-btn-lg">
                            <button type="button" class="btn header-item noti-icon waves-effect mt-3">
                               <p>V.680128-09.30</p>
                            </button>
                            <button type="button" class="btn header-item noti-icon waves-effect showDocument" data-toggle="คู่มือการใช้งาน">
                                <img src="{{ asset('images/Video_Player.png') }}" class="me-2" height="27px" width="27px" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="คู่มือการใช้งาน">
                            </button>
                        </div>

                        <div class="header-btn-lg">
                            <button type="button" class="btn header-item noti-icon waves-effect mt-2" data-toggle="fullscreen">
                                <i class="ri-fullscreen-line" style="color: rgb(255, 255, 255);font-size:30px;" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="Fullscreen"></i>

                            </button>
                        </div>
                        {{-- <div class="header-btn-lg">
                            <a id="TooltipDemo" class="btn-open-options btn hamburger hamburger--elastic open-right-drawer text-danger" target="_blank">
                                <i class="fa-solid fa-universal-access fa-w-16 fa-spin fa-2x text-info" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="ผู้ใช้งานทั่วไป"></i>
                            </a>
                        </div> --}}

                        {{-- <div class="header-btn-lg pe-0">
                            <div class="widget-content p-0">
                                <div class="widget-content-wrapper">
                                    <div class="widget-content-left">
                                        <div class="btn-group">
                                            <a data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="p-0 btn">
                                                @if (Auth::user()->img == null)
                                                    <img src="{{ asset('assets/images/default-image.jpg') }}" width="42" class="rounded-circle loadingIcon" alt="">
                                                @else
                                                    <img src="{{ asset('storage/person/' . Auth::user()->img) }}"width="42" class="rounded-circle loadingIcon" alt="">
                                                @endif
                                                <i class="fa fa-angle-down ms-2 opacity-8"></i>
                                            </a>
                                            <div tabindex="-1" role="menu" aria-hidden="true" class="rm-pointers dropdown-menu-lg dropdown-menu dropdown-menu-right">
                                                <div class="dropdown-menu-header">
                                                    <div class="dropdown-menu-header-inner bg-primary">

                                                        <div class="menu-header-content text-start">
                                                            <div class="widget-content p-0">
                                                                <div class="widget-content-wrapper">
                                                                    <div class="widget-content-left me-3">
                                                                            @if (Auth::user()->img == null)
                                                                                <img src="{{ asset('assets/images/default-image.jpg') }}" width="42" class="rounded-circle" alt="">
                                                                            @else
                                                                                <img src="{{ asset('storage/person/' . Auth::user()->img) }}"width="42" class="rounded-circle" alt="">
                                                                            @endif
                                                                    </div>
                                                                    <div class="widget-content-left">
                                                                        <div class="widget-heading"> {{ Auth::user()->fname }} {{ Auth::user()->lname }}</div>
                                                                        <div class="widget-subheading opacity-8">{{ Auth::user()->position_name }}</div>
                                                                    </div>
                                                                    <div class="widget-content-right me-2">

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="scroll-area-xs" style="height: 100px;">
                                                    <div class="scrollbar-container ps">
                                                        <ul class="nav flex-column">
                                                            <li class="nav-item">
                                                                <a href="javascript:void(0);" class="nav-link">
                                                                    Messages
                                                                    <div class="ms-auto badge rounded-pill bg-primary">2</div>
                                                                </a>
                                                            </li>
                                                            <li class="nav-item">
                                                                <a href="javascript:void(0);" class="nav-link" data-bs-toggle="modal" data-bs-target="#Keypassword">
                                                                    Change Password<i class="fa-solid fa-key ms-4" style="color: rgb(207, 34, 115)"></i>
                                                                    <div class="ms-auto badge rounded-pill bg-info">1</div>
                                                                </a>
                                                            </li>

                                                        </ul>
                                                    </div>
                                                </div>
                                                <ul class="nav flex-column">
                                                    <li class="nav-item-divider mb-0 nav-item"></li>
                                                </ul>
                                                <div class="grid-menu grid-menu-2col">
                                                    <div class="g-0 row">
                                                        <div class="col-sm-6">

                                                            <a class="btn-icon-vertical btn-transition btn-transition-alt btn btn-outline-warning"  href="{{ url('user_profile_edit/' . Auth::user()->id) }}">
                                                                <button class="btn-icon-vertical btn-transition btn-transition-alt pb-2 btn btn-outline-warning">
                                                                    <i class="ri-user-line btn-icon-wrapper mb-2"></i>
                                                                    Profile
                                                                </button>
                                                            </a>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                                                @csrf
                                                            </form>
                                                            <a class="btn-icon-vertical btn-transition btn-transition-alt btn btn-outline-danger" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                                <button class="btn-icon-vertical btn-transition btn-transition-alt pb-2 btn btn-outline-danger">
                                                                    <i class="ri-shut-down-line align-middle btn-icon-wrapper mb-2"></i>
                                                                    Logout
                                                                </button>
                                                            </a>

                                                        </div>


                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="widget-content-left  ms-3 header-user-info">
                                        <div class="widget-heading"> {{ Auth::user()->fname }} {{ Auth::user()->lname }}</div>
                                        <div class="widget-subheading"> {{ Auth::user()->position_name }}</div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="header-btn-lg">
                            <button type="button" class="hamburger hamburger--elastic open-right-drawer">
                                <span class="hamburger-box">
                                    <span class="hamburger-inner"></span>
                                </span>
                            </button>
                        </div> --}}

                        <div class="dropdown d-inline-block user-dropdown mt-2">
                            <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                                @if (Auth::user()->img == null)
                                    <img src="{{ asset('assets/images/default-image.jpg') }}" width="42" class="rounded-circle header-profile-user" alt="Header Avatar">
                                @else
                                    <img src="{{ asset('storage/person/' . Auth::user()->img) }}"width="42" class="rounded-circle header-profile-user" alt="Header Avatar">
                                @endif
                                <span class="d-none d-xl-inline-block ms-1 fontbtn">{{ Auth::user()->fname }} {{ Auth::user()->lname }}</span>
                                <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>

                            </button>
                            <div class="dropdown-menu dropdown-menu-end">
                                <!-- item-->
                                <a class="dropdown-item" href="{{ url('user_profile_edit/' . Auth::user()->id) }}"><i class="ri-user-line align-middle me-2"></i> Profile</a>

                                <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#Keypassword"><i class="fa-solid fa-key me-2"></i> Change Password</a>
                                <div class="dropdown-divider"></div>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                                <a class="dropdown-item text-danger" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="ri-shut-down-line align-middle me-2 text-danger"></i> Logout</a>
                            </div>
                        </div>

                </div>

            </div>
        </header>

        <div class="topnav">
            <div class="container-fluid">
                <nav class="navbar navbar-light navbar-expand-lg topnav-menu">

                    <div class="collapse navbar-collapse" id="topnav-menu-content">
                        <ul class="navbar-nav">

                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="{{ url('user/home') }}" id="topnav-apps" role="button">
                                    {{-- <i class="fa-solid fa-chart-pie me-2" style="font-size: 20px;color:rgb(4, 194, 169)"></i> --}}
                                    <img src="{{ asset('images/Performance.png') }}" class="me-2" height="27px" width="27px">
                                    Dashboard
                                </a>
                            </li>


                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-apps" role="button"
                                >
                                    {{-- <i class="fa-solid fa-user-check me-2" style="font-size: 20px;color:rgb(10, 116, 187)"></i> --}}
                                    <img src="{{ asset('images/Face_user.png') }}" class="me-2" height="27px" width="27px">
                                    งานบริหารบุคคล
                                </a>
                                {{-- target="_blank" --}}
                                <div class="dropdown-menu" aria-labelledby="topnav-apps">

                                    {{-- <a href="{{ url('user_otone') }}" class="dropdown-item">
                                        <img src="{{ asset('images/timeot.png') }}" class="me-2" height="27px" width="27px">
                                        บันทึก OT
                                    </a> --}}
                                    <a href="{{ url('user_timeindex') }}" class="dropdown-item">
                                        <img src="{{ asset('images/Time_ot.png') }}" class="me-2" height="27px" width="27px">
                                        เวลาเข้า-ออก (backoffice)
                                    </a>
                                    <a href="{{ url('user_timeindex_nurh') }}" class="dropdown-item">
                                        <img src="{{ asset('images/Time_ot.png') }}" class="me-2" height="27px" width="27px">
                                        เวลาเข้า-ออก (Nurs)
                                    </a>

                                    <!-- <div class="dropdown">
                                        <a class="dropdown-item" href="#" id="topnav-email">
                                            Email  <div class="arrow-down"></div>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="topnav-email">
                                            <a href="email-inbox.html" class="dropdown-item">Inbox</a>
                                            <a href="email-read.html" class="dropdown-item">Read Email</a>
                                        </div>
                                    </div> -->
                                </div>
                            </li>
                            {{-- <div class="dropdown">
                                <a class="dropdown-item" href="#" id="topnav-email">
                                    <i class="fa-solid fa-warehouse me-2" style="font-size: 20px;color:rgb(255, 99, 177)"></i>คลังพัสดุ  <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-email">
                                    <a href="{{ url('wh_sub_main') }}" class="dropdown-item">คลังย่อย</a>
                                    <a href="{{ url('wh_sub_main_rp') }}" class="dropdown-item">เบิก-จ่าย</a>
                                </div>
                            </div> --}}

                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-apps" role="button"
                                >
                                    {{-- <i class="fa-solid fa-user-check me-2" style="font-size: 20px;color:rgb(247, 46, 146)"></i> --}}
                                    <img src="{{ asset('images/User_narmal.png') }}" class="me-2" height="27px" width="27px">
                                    งานบริหารทั่วไป
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-apps">

                                    <!-- <a href="{{ url('user_otone') }}" class="dropdown-item" target="_blank">บันทึก OT</a>   -->

                                    <div class="dropdown">
                                        <a class="dropdown-item" href="#" id="topnav-email">
                                            {{-- <i class="fa-solid fa-paintbrush me-2" style="font-size: 20px;color:rgb(255, 99, 177)"></i> --}}
                                            <img src="{{ asset('images/Paint.png') }}" class="me-2" height="27px" width="27px">
                                            งานโสตทัศนูปกรณ์  <div class="arrow-down"></div>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="topnav-email">
                                            <a href="{{ url('audiovisual_work') }}" class="dropdown-item">ขอใช้บริการ</a>
                                        </div>
                                    </div>

                                    <div class="dropdown">
                                        <a class="dropdown-item" href="#" id="topnav-email">
                                            {{-- <i class="fa-solid fa-warehouse me-2" style="font-size: 20px;color:rgb(255, 99, 177)"></i> --}}
                                            <img src="{{ asset('images/store_sub.png') }}" class="me-2" height="27px" width="27px">
                                            คลังพัสดุ  <div class="arrow-down"></div>
                                        </a>
                                        <div class="dropdown-menu mb-4" aria-labelledby="topnav-email">
                                            <a href="{{ url('wh_sub_main') }}" class="dropdown-item">คลังย่อย</a>
                                            <a href="{{ url('wh_sub_main_rp') }}" class="dropdown-item">เบิกพัสดุ</a>
                                            <a href="{{ url('wh_sub_main_pay') }}" class="dropdown-item">ตัดจ่ายพัสดุ</a>
                                            <a href="{{ url('wh_sub_report') }}" class="dropdown-item">รายงานคลัง</a>
                                        </div>
                                    </div>

                                    {{-- <div class="dropdown">
                                        <a class="dropdown-item" href="#" id="topnav-email">
                                            <img src="{{ asset('images/Computer_repaire.png') }}" class="me-2" height="27px" width="27px">
                                            แจ้งซ่อมคอมพิวเตอร์  <div class="arrow-down"></div>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="topnav-email">
                                            <a href="{{ url('user_com/repair_com_add') }}" class="dropdown-item">แจ้งซ่อมคอมพิวเตอร์</a>
                                        </div>
                                    </div> --}}

                                </div>
                            </li>




                            {{-- <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-apps" role="button"
                                >
                                    <i class="fa-solid fa-user-check me-2" style="font-size: 20px;color:rgb(10, 116, 187)"></i>งานบริหารบุคคล
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-apps">

                                    <a href="{{ url('user_otone') }}" class="dropdown-item" target="_blank">บันทึก OT</a>
                                    <a href="{{ url('user_timeindex') }}" class="dropdown-item" target="_blank">เวลาเข้า-ออก (backoffice)</a>
                                    <a href="{{ url('user_timeindex_nurh') }}" class="dropdown-item" target="_blank">เวลาเข้า-ออก (Nurs)</a>

                                    <div class="dropdown">
                                        <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-email" role="button">
                                            Email
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="topnav-email">
                                            <a href="email-inbox.html" class="dropdown-item">Inbox</a>
                                            <a href="email-read.html" class="dropdown-item">Read Email</a>
                                        </div>
                                    </div>
                                </div>
                            </li>



                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-apps" role="button">
                                <i class="fa-solid fa-paintbrush me-2" style="font-size: 20px;color:rgb(10, 116, 187)"></i>งานโสตทัศนูปกรณ์
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-apps">
                                    <a href="{{ url('audiovisual_work') }}" class="dropdown-item" target="_blank">ขอใช้บริการ</a>
                                </div>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-apps" role="button">
                                <i class="fas fa-desktop me-2" style="font-size: 20px;color:rgb(10, 116, 187)"></i>แจ้งซ่อมคอมพิวเตอร์
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-apps">
                                    <a href="{{ url('user_com/repair_com_add') }}" class="dropdown-item" target="_blank">แจ้งซ่อมคอมพิวเตอร์</a>
                                </div>
                            </li>  --}}




                        </ul>
                    </div>
                </nav>
            </div>
        </div>

         <!--  Modal content for the Keypassword example -->
         <div class="modal fade" id="Keypassword" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myExtraLargeModalLabel">Edit Password New </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-3 text-end"><label for="">Password New</label></div>
                            <div class="col-md-7">
                                <div class="form-group text-center">
                                    <input type="password" class="form-control form-control-sm" id="password" name="password">
                                </div>
                            </div>
                            <div class="col"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="col-md-12 text-end">
                            <div class="form-group">
                                <button type="button" id="SaveChang" class="btn btn-outline-info btn-sm" >
                                    <i class="fa-solid fa-floppy-disk me-1 text-info"></i>
                                    Update
                                </button>
                                <button type="button" class="btn btn-outline-danger btn-sm" data-bs-dismiss="modal"><i
                                        class="fa-solid fa-xmark text-danger me-2"></i>Close</button>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-popup mb-5" id="myFormchat" style="width: 320px">
            <form action="" class="form-container">
              <h3 class="text-center">Support PK-OFFICE</h3>
              <p class="text-center"><b>Message || Tel -> 555</b></p>

                {{-- <span class="badge text-start" style="font-size:10px;background-color: #06c7bd">
                     11111
                </span>
              <br>
                <span class="badge text-end" style="font-size:10px;background-color: #ff568e">
                    2222
                </span>  --}}
                <div class="row">
                    <div class="col-sm-6 text-start">
                        <span class="badge" style="font-size:10px;background-color: #06c7bd">
                            ตอบ
                       </span>
                    </div>
                    <div class="col-sm-6 text-end">
                        <span class="badge" style="font-size:10px;background-color: #ff568e">
                            ถาม
                        </span>
                    </div>
                </div>

              <textarea name="message" id="message" rows="2" class="form-control mt-2"></textarea>

              {{-- <label for="psw"><b>Password</b></label> --}}
              {{-- <input type="password" placeholder="Enter Password" name="psw" required> --}}

              <div class="row">
                <div class="col-sm-6 text-end">
                    <button type="button" class="btn mt-3 mb-3">
                         ส่ง
                    </button>
                </div>
                <div class="col-sm-6 text-start">
                    <button type="button" class="btn cancel mt-3 mb-3" onclick="closeForm()">
                         ปิด
                    </button>
                </div>
            </div>
              {{-- <button type="submit" class="btn mt-3">ส่งข้อความ</button> --}}
              {{-- <br> --}}
              {{-- <button type="button" class="btn cancel" onclick="closeForm()">ปิด</button> --}}
            </form>
        </div>
        <br><br>

         <!-- Update Modal -->
         <div class="modal fade" id="showDocumentModal"  tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-slideout" role="document">
                <div class="modal-content ">
                    <div class="modal-header">
                        <div class="row">
                            <div class="col-md-8">
                                <h4 class="modal-title" id="editModalLabel" style="color:rgb(248, 28, 83)">คู่มือการใช้งาน</h4>
                            </div>
                            <div class="col-md-4 text-end">
                                <div class="form-group">
                                    <button type="button" class="btn-icon btn-shadow btn-dashed btn btn-outline-danger" data-bs-dismiss="modal">
                                        <i class="fa-solid fa-xmark me-2"></i>Close
                                    </button>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-body">
                        <img src="{{ asset('images/doc/doc_01.png') }}" class="rounded" alt="Image" width="auto" height="430px">
                        <br><br><br>
                        <hr style="color: red;border: blueviolet">
                        <hr style="color: red;border: blueviolet">
                        <br><br><br>
                        <img src="{{ asset('images/doc/doc_02.png') }}" class="rounded" alt="Image" width="auto" height="400px">
                        <br><br><br>
                        <hr style="color: red;border: blueviolet">
                        <hr style="color: red;border: blueviolet">

                        <img src="{{ asset('images/doc/doc_03.png') }}" class="rounded" alt="Image" width="auto" height="430px">
                        <br><br><br>

                        <hr style="color: red;border: blueviolet">
                        <hr style="color: red;border: blueviolet">

                        <img src="{{ asset('images/doc/doc_04.png') }}" class="rounded" alt="Image" width="auto" height="430px">
                        <br><br><br>

                        <hr style="color: red;border: blueviolet">
                        <hr style="color: red;border: blueviolet">

                        <img src="{{ asset('images/doc/doc_05.png') }}" class="rounded" alt="Image" width="auto" height="430px">
                        <br><br><br>

                        <hr style="color: red;border: blueviolet">
                        <hr style="color: red;border: blueviolet">

                        <img src="{{ asset('images/doc/doc_06.png') }}" class="rounded" alt="Image" width="auto" height="430px">
                        <br><br><br>

                        <hr style="color: red;border: blueviolet">
                        <hr style="color: red;border: blueviolet">

                        <img src="{{ asset('images/doc/doc_07.png') }}" class="rounded" alt="Image" width="auto" height="430px">
                        <br><br><br>

                        <hr style="color: red;border: blueviolet">
                        <hr style="color: red;border: blueviolet">

                        <img src="{{ asset('images/doc/doc_08.png') }}" class="rounded" alt="Image" width="auto" height="430px">
                        <br><br><br>

                    </div>
                    <div class="modal-footer">
                    </div>
                </div>
            </div>
        </div>

         {{-- <div class="mt-5">
            @yield('content')
         </div> --}}
         {{-- <div class="main-content"> --}}
            <div class="page-content">
                    @yield('content')
            </div>

        {{-- <footer class="footer"> --}}
            <div class="container-fluid fixed-bottom mb-3 card_prs_4" style="background-color: rgb(238, 252, 255);height: 50px;">
            {{-- <div class="container-fluid mb-3 card_prs_4" style="background-color: rgb(238, 252, 255);height: 50px;"> --}}
                <div class="row mt-3">
                    <div class="col-sm-7">
                        <script>
                            document.write(new Date().getFullYear())
                        </script> © โรงพยาบาลภูเขียวเฉลิมพระเกียรติ
                    </div>
                    <div class="col-sm-4">
                        <div class="text-sm-end d-none d-sm-block me-3">
                            Created with <i class="mdi mdi-heart text-danger"></i> by ประดิษฐ์ ระหา - งานสุขภาพดิจิทัล
                        </div>
                    </div>
                    <div class="col-sm-1">
                        <div class="text-sm-end d-none d-sm-block me-3">
                            {{-- <button class="open-button" onclick="openForm()">Open Chat</button> --}}
                            <img src="{{ asset('images/support_new.png') }}" class="rounded-circle open-button_new" onclick="openForm()">
                        </div>
                    </div>
                </div>
            </div>
        {{-- </footer> --}}


    {{-- </div> --}}
    <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->




    <!-- Right bar overlay-->
    <div class="rightbar-overlay"></div>


    <!-- JAVASCRIPT -->
    <script src="{{ asset('pkclaim/libs/jquery/jquery.min.js') }}"></script>
    {{-- <script type="text/javascript" src="{{ asset('vendors/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script> --}}
    <script src="{{ asset('pkclaim/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('pkclaim/libs/metismenu/metisMenu.min.js') }}"></script>
    <script src="{{ asset('pkclaim/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('pkclaim/libs/node-waves/waves.min.js') }}"></script>

    <script src="{{ asset('js/select2.min.js') }}"></script>
    {{-- <script src="{{ asset('pkclaim/libs/select2/js/select2.min.js') }}"></script> --}}
    <script src="{{ asset('pkclaim/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('pkclaim/libs/spectrum-colorpicker2/spectrum.min.js') }}"></script>
    <script src="{{ asset('pkclaim/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js') }}"></script>
    <script src="{{ asset('pkclaim/libs/admin-resources/bootstrap-filestyle/bootstrap-filestyle.min.js') }}"></script>
    <script src="{{ asset('pkclaim/libs/bootstrap-maxlength/bootstrap-maxlength.min.js') }}"></script>

    <script src="{{ asset('pkclaim/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/locales/bootstrap-datepicker.th.min.js"
        integrity="sha512-cp+S0Bkyv7xKBSbmjJR0K7va0cor7vHYhETzm2Jy//ZTQDUvugH/byC4eWuTii9o5HN9msulx2zqhEXWau20Dg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- jquery.vectormap map -->
    <script src="{{ asset('pkclaim/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.min.js') }}"></script>
    <script src="{{ asset('pkclaim/libs/admin-resources/jquery.vectormap/maps/jquery-jvectormap-us-merc-en.js') }}">
    </script>

    <!-- Required datatable js -->
    <script src="{{ asset('pkclaim/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('pkclaim/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>

    <!-- Buttons examples -->
    <script src="{{ asset('pkclaim/libs/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('pkclaim/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('pkclaim/libs/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('pkclaim/libs/pdfmake/build/pdfmake.min.js') }}"></script>
    <script src="{{ asset('pkclaim/libs/pdfmake/build/vfs_fonts.js') }}"></script>
    <script src="{{ asset('pkclaim/libs/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('pkclaim/libs/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('pkclaim/libs/datatables.net-buttons/js/buttons.colVis.min.js') }}"></script>

    <script src="{{ asset('pkclaim/libs/datatables.net-keytable/js/dataTables.keyTable.min.js') }}"></script>
    <script src="{{ asset('pkclaim/libs/datatables.net-select/js/dataTables.select.min.js') }}"></script>

    <!-- Responsive examples -->
    <script src="{{ asset('pkclaim/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('pkclaim/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>

     <!-- Datatable init js -->
     <script src="{{ asset('pkclaim/js/pages/datatables.init.js') }}"></script>
     <script src="{{ asset('pkclaim/libs/twitter-bootstrap-wizard/jquery.bootstrap.wizard.min.js') }}"></script>

     <script src="{{ asset('pkclaim/libs/twitter-bootstrap-wizard/prettify.js') }}"></script>


     <script src="{{ asset('pkclaim/js/pages/form-wizard.init.js') }}"></script>
     <script type="text/javascript" src="{{ asset('fullcalendar/lib/moment.min.js') }}"></script>
     <script type="text/javascript" src="{{ asset('fullcalendar/fullcalendar.min.js') }}"></script>
     <script type="text/javascript" src="{{ asset('fullcalendar/lang/th.js') }}"></script>

     <script type="text/javascript" src="{{ asset('acccph/vendors/daterangepicker/daterangepicker.js') }}"></script>

     <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
     <script src="{{ asset('assets/jquery-tabledit/jquery.tabledit.min.js') }}"></script>

     <!-- App js -->
     <script src="{{ asset('pkclaim/js/app.js') }}"></script>
     <script src="{{ asset('js/bootstrap-timepicker.js') }}"></script>
    {{-- <!-- Datatable init js -->
    <script src="{{ asset('pkclaim/js/pages/datatables.init.js') }}"></script>
    <script src="{{ asset('pkclaim/libs/twitter-bootstrap-wizard/jquery.bootstrap.wizard.min.js') }}"></script>
    <script src="{{ asset('pkclaim/libs/twitter-bootstrap-wizard/prettify.js') }}"></script>
    <script src="{{ asset('pkclaim/js/pages/form-wizard.init.js') }}"></script>
    <script type="text/javascript" src="{{ asset('fullcalendar/lib/moment.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('fullcalendar/fullcalendar.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('fullcalendar/lang/th.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('assets/jquery-tabledit/jquery.tabledit.min.js') }}"></script>
    <!-- App js -->
    <script src="{{ asset('pkclaim/js/app.js') }}"></script>
    <script src="{{ asset('js/bootstrap-timepicker.js') }}"></script> --}}
    @yield('footer')

    <script>

        function openForm() {
          document.getElementById("myFormchat").style.display = "block";
        }
        function closeForm() {
          document.getElementById("myFormchat").style.display = "none";
        }
        $(document).on('click', '.showDocument', function() {
                $('#showDocumentModal').modal('show');
        });
        $(document).ready(function() {
            $('#example').DataTable();
            $('#example2').DataTable();
            $('#example3').DataTable();
            $('#example4').DataTable();
            $('#example5').DataTable();
            $('#example_user').DataTable();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('#SaveChang').click(function() {
                var password = $('#password').val();
                // alert(password);
                $.ajax({
                    url: "{{ route('pro.profile_password_update') }}",
                    type: "POST",
                    dataType: 'json',
                    data: {
                        password
                    },
                    success: function(data) {
                        if (data.status == 200) {
                            Swal.fire({
                                title: 'เปลี่ยนรหัสผ่านสำเร็จ',
                                text: "You Chang password success",
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

                                }
                            })
                        } else {

                        }

                    },
                });
            });
        });
    </script>

</body>

</html>
