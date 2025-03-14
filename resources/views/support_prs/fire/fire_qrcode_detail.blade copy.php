<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' /> 
    <link href='https://fonts.googleapis.com/css?family=Kanit&subset=thai,latin' rel='stylesheet' type='text/css'>
     <!-- Bootstrap Css -->
     <link href="{{ asset('pkclaim/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" /> 
     <!-- App Css-->
     <link href="{{ asset('pkclaim/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
<style>
    body {
        font-family: 'Kanit', sans-serif;
        font-size: 14px;   
        }
</style>
<?php

    use SimpleSoftwareIO\QrCode\Facades\QrCode;

    ?>
<body onload="window.print()">
    <div class="row mt-5">
        <div class="col-md-3">
            <table> 
                {{-- http://smarthos-phukieohos.moph.go.th/pkbackoffice/public/ --}}
                <tr>
                    <td>   
                        {!! QrCode::size(112)->encoding('UTF-8')->generate(asset('http://smarthos-phukieohos.moph.go.th/pkbackoffice/public/fire_detail/'.$id));!!}
                        {{-- {!! QrCode::size(112)->encoding('UTF-8')->generate(asset('/manager_asset/assetinfomation/'.$dataprint->fire_num));!!} --}}
                        {{-- {!! QrCode::size(112)->encoding('UTF-8')->generate($dataprint->fire_num);!!}  --}}
                        <br>
                        {{-- {!!  $qrcode = new BaconQrCodeGenerator;
                        $qrcode->size(100)->generate("your text", asset('/pkbackoffice/public/fire_detail/'.$id));
                        !!}  --}}
                    </td> 
                </tr>
                <tr > 
                    <td style="font-family: 'Kanit', sans-serif;font-size: 14px;font-style: nomal;">  
                        รหัส {{ $dataprint->fire_num }}<br> 
                        {{ $dataprint->fire_name }} <br>  
                        {{ $dataprint->fire_location }} 
                    </td> 
                </tr>
            </table> 
        </div>
        
         
    </div>

     
    
     
     
     <!-- JAVASCRIPT -->
     <script src="{{ asset('pkclaim/libs/jquery/jquery.min.js') }}"></script>

     <script src="{{ asset('pkclaim/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script> 
</body>
        
                     
