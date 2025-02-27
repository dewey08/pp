<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\support\Facades\Hash;
use Illuminate\support\Facades\Validator;
use App\Models\User;
use App\Models\Acc_debtor;
use App\Models\Pttype_eclaim;
use App\Models\Account_listpercen;
use App\Models\Leave_month;
use App\Models\Acc_debtor_stamp;
use App\Models\Acc_debtor_sendmoney;
use App\Models\Pttype;
use App\Models\Pttype_acc;
use App\Models\Acc_stm_ti;
use App\Models\Acc_stm_ti_total;
use App\Models\Acc_opitemrece;
use App\Models\Acc_1102050101_202;
use App\Models\Acc_1102050101_217;
use App\Models\Acc_1102050101_216;
use App\Models\Acc_stm_ucs;
use App\Models\Acc_1102050101_301;
use App\Models\Acc_1102050101_304;
use App\Models\Acc_1102050101_308;
use App\Models\Acc_1102050101_4011;
use App\Models\Acc_1102050101_3099;
use App\Models\Acc_1102050101_401;
use App\Models\Acc_1102050101_402;
use App\Models\Acc_1102050102_801;
use App\Models\Acc_1102050102_802;
use App\Models\Acc_1102050102_803;
use App\Models\Acc_1102050102_804;
use App\Models\Acc_1102050101_4022;
use App\Models\Acc_1102050102_602;
use App\Models\Acc_1102050101_209;
use App\Models\Acc_4301020105_228;
use App\Models\Acc_nongtoon_repexcel;
use App\Models\Acc_nongtoon_rep;
use App\Models\Acc_stm_ofc;
use App\Models\acc_stm_ofcexcel;
use App\Models\Acc_stm_lgo;
use App\Models\Acc_stm_lgoexcel;
use App\Models\Check_sit_auto;
use App\Models\Acc_function;

use PDF;
use setasign\Fpdi\Fpdi;
use App\Models\Budget_year;
use Illuminate\Support\Facades\File;
use DataTables;
use Intervention\Image\ImageManagerStatic as Image;
use App\Mail\DissendeMail;
use Mail;
use Illuminate\Support\Facades\Storage;
use Auth;
use Http;
use SoapClient;
// use File;
// use SplFileObject;
use Arr;
// use Storage;
use GuzzleHttp\Client;

use App\Imports\ImportAcc_stm_ti;
use App\Imports\ImportAcc_stm_tiexcel_import;
use App\Imports\ImportAcc_stm_ofcexcel_import;
use App\Imports\ImportAcc_stm_lgoexcel_import;
use App\Models\Acc_1102050101_217_stam;
use App\Models\Acc_opitemrece_stm;

use SplFileObject;
use PHPExcel;
use PHPExcel_IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Reader\Exception;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\IOFactory;

date_default_timezone_set("Asia/Bangkok");


class AccountIMCController extends Controller
 {
    public function kontoon_imc_dash(Request $request)
    {
        // $startdate          = $request->startdate;
        // $enddate            = $request->enddate;
        $budget_year        = $request->budget_year;
        $dabudget_year      = DB::table('budget_year')->where('active','=',true)->get();
        $leave_month_year   = DB::table('leave_month')->orderBy('MONTH_ID', 'ASC')->get();
        $date = date('Y-m-d');
        $y = date('Y') + 543;
        $newweek = date('Y-m-d', strtotime($date . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
        $newDate = date('Y-m-d', strtotime($date . ' -5 months')); //ย้อนหลัง 5 เดือน
        $newyear = date('Y-m-d', strtotime($date . ' -1 year')); //ย้อนหลัง 1 ปี
        $bgs_year      = DB::table('budget_year')->where('years_now','Y')->first();
        $data['bg_yearnow']    = $bgs_year->leave_year_id;

        if ($budget_year == '') {
            $yearnew     = date('Y');
            // $year_old    = date('Y')-1;
            // $startdate   = (''.$year_old.'-10-01');
            // $enddate     = (''.$yearnew.'-09-30');
            $bg           = DB::table('budget_year')->where('years_now','Y')->first();
            $startdate    = $bg->date_begin;
            $enddate      = $bg->date_end;
            // dd($startdate);
            $datashow = DB::select(
                'SELECT month(U1.vstdate) as months,year(U1.vstdate) as year,l.MONTH_NAME
                from acc_4301020105_228 U1
                left outer join leave_month l on l.MONTH_ID = month(U1.vstdate)
                WHERE U1.vstdate between "'.$startdate.'" and "'.$enddate.'"
                group by month(U1.vstdate)
            ');
        } else {
            $bg           = DB::table('budget_year')->where('leave_year_id','=',$budget_year)->first();
            $startdate    = $bg->date_begin;
            $enddate      = $bg->date_end;

            $datashow = DB::select(
                'SELECT month(U1.vstdate) as months,year(U1.vstdate) as year,l.MONTH_NAME
                from acc_4301020105_228 U1
                left outer join leave_month l on l.MONTH_ID = month(U1.vstdate)
                WHERE U1.vstdate between "'.$startdate.'" and "'.$enddate.'"
                group by month(U1.vstdate)
            ');
        }

        return view('kongtoon_imc.kontoon_imc_dash',$data,[
            'startdate'         =>  $startdate,
            'enddate'           =>  $enddate,
            'leave_month_year'  =>  $leave_month_year,
            'datashow'          =>  $datashow,
            'dabudget_year'     =>  $dabudget_year,
            'budget_year'       =>  $budget_year,
            'y'                 =>  $y,
        ]);
    }
    public function kontoon_imc_pull(Request $request)
    {
        $datenow         = date('Y-m-d');
        $months          = date('m');
        $year            = date('Y');
        $newday          = date('Y-m-d', strtotime($datenow . ' -2 Day')); //ย้อนหลัง 1 สัปดาห์
        $startdate       = $request->startdate;
        $enddate         = $request->enddate;

        if ($startdate == '') {
            // $acc_debtor = Acc_debtor::where('stamp','=','N')->whereBetween('dchdate', [$datenow, $datenow])->get();
            $acc_debtor = DB::select('
                SELECT *
                from acc_debtor a
                WHERE a.account_code="4301020105.228" AND vstdate BETWEEN "' . $newday . '" AND "' . $datenow . '"
                AND a.debit_total > 0
                group by a.vn
                order by a.vstdate desc;
            ');
                $data['count_claim'] = Acc_debtor::where('active_claim','=','Y')->where('account_code','=','4301020105.228')->whereBetween('vstdate', [$newday, $datenow])->count();
                $data['count_noclaim'] = Acc_debtor::where('active_claim','=','N')->where('account_code','=','4301020105.228')->whereBetween('vstdate', [$newday, $datenow])->count();

                $data['data_opd'] = DB::connection('mysql')->select('SELECT * from d_opd WHERE d_anaconda_id ="IMC"');
                $data['data_orf'] = DB::connection('mysql')->select('SELECT * from d_orf WHERE d_anaconda_id ="IMC"');
                $data['data_oop'] = DB::connection('mysql')->select('SELECT * from d_oop WHERE d_anaconda_id ="IMC"');
                $data['data_odx'] = DB::connection('mysql')->select('SELECT * from d_odx WHERE d_anaconda_id ="IMC"');
                $data['data_idx'] = DB::connection('mysql')->select('SELECT * from d_idx WHERE d_anaconda_id ="IMC"');
                $data['data_ipd'] = DB::connection('mysql')->select('SELECT * from d_ipd WHERE d_anaconda_id ="IMC"');
                $data['data_irf'] = DB::connection('mysql')->select('SELECT * from d_irf WHERE d_anaconda_id ="IMC"');
                $data['data_aer'] = DB::connection('mysql')->select('SELECT * from d_aer WHERE d_anaconda_id ="IMC"');
                $data['data_iop'] = DB::connection('mysql')->select('SELECT * from d_iop WHERE d_anaconda_id ="IMC"');
                $data['data_adp'] = DB::connection('mysql')->select('SELECT * from d_adp WHERE d_anaconda_id ="IMC"');
                $data['data_pat'] = DB::connection('mysql')->select('SELECT * from d_pat WHERE d_anaconda_id ="IMC"');
                $data['data_cht'] = DB::connection('mysql')->select('SELECT * from d_cht WHERE d_anaconda_id ="IMC"');
                $data['data_cha'] = DB::connection('mysql')->select('SELECT * from d_cha WHERE d_anaconda_id ="IMC"');
                $data['data_ins'] = DB::connection('mysql')->select('SELECT * from d_ins WHERE d_anaconda_id ="IMC"');
                $data['data_dru'] = DB::connection('mysql')->select('SELECT * from d_dru WHERE d_anaconda_id ="IMC"');
        } else {

            $acc_debtor = DB::select('
            SELECT *
             from acc_debtor a
                WHERE a.account_code="4301020105.228" AND vstdate BETWEEN "' . $startdate . '" AND "' . $enddate . '"
                 AND a.debit_total > 0
                group by a.vn
                order by a.vstdate desc;
            ');
            $data['count_claim'] = Acc_debtor::where('active_claim','=','Y')->where('account_code','=','4301020105.228')->whereBetween('vstdate', [$startdate, $enddate])->count();
            $data['count_noclaim'] = Acc_debtor::where('active_claim','=','N')->where('account_code','=','4301020105.228')->whereBetween('vstdate', [$startdate, $enddate])->count();

            $data['data_opd'] = DB::connection('mysql')->select('SELECT * from d_opd WHERE d_anaconda_id ="IMC"');
            $data['data_orf'] = DB::connection('mysql')->select('SELECT * from d_orf WHERE d_anaconda_id ="IMC"');
            $data['data_oop'] = DB::connection('mysql')->select('SELECT * from d_oop WHERE d_anaconda_id ="IMC"');
            $data['data_odx'] = DB::connection('mysql')->select('SELECT * from d_odx WHERE d_anaconda_id ="IMC"');
            $data['data_idx'] = DB::connection('mysql')->select('SELECT * from d_idx WHERE d_anaconda_id ="IMC"');
            $data['data_ipd'] = DB::connection('mysql')->select('SELECT * from d_ipd WHERE d_anaconda_id ="IMC"');
            $data['data_irf'] = DB::connection('mysql')->select('SELECT * from d_irf WHERE d_anaconda_id ="IMC"');
            $data['data_aer'] = DB::connection('mysql')->select('SELECT * from d_aer WHERE d_anaconda_id ="IMC"');
            $data['data_iop'] = DB::connection('mysql')->select('SELECT * from d_iop WHERE d_anaconda_id ="IMC"');
            $data['data_adp'] = DB::connection('mysql')->select('SELECT * from d_adp WHERE d_anaconda_id ="IMC"');
            $data['data_pat'] = DB::connection('mysql')->select('SELECT * from d_pat WHERE d_anaconda_id ="IMC"');
            $data['data_cht'] = DB::connection('mysql')->select('SELECT * from d_cht WHERE d_anaconda_id ="IMC"');
            $data['data_cha'] = DB::connection('mysql')->select('SELECT * from d_cha WHERE d_anaconda_id ="IMC"');
            $data['data_ins'] = DB::connection('mysql')->select('SELECT * from d_ins WHERE d_anaconda_id ="IMC"');
            $data['data_dru'] = DB::connection('mysql')->select('SELECT * from d_dru WHERE d_anaconda_id ="IMC"');

        }
        $data_activeclaim        = Acc_function::where('pang','4301020105.228')->first();
        $data['activeclaim']     = $data_activeclaim->claim_active;
        $data['acc_function_id'] = $data_activeclaim->acc_function_id;

        return view('kongtoon_imc.kontoon_imc_pull',$data,[
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
            'acc_debtor'    =>     $acc_debtor,
        ]);
    }

    public function kontoon_imc_checksit(Request $request)
    {
        $datestart = $request->datestart;
        $dateend   = $request->dateend;
        $date      = date('Y-m-d');
        $id        = $request->ids;

        $data_sitss = Acc_debtor::whereIn('acc_debtor_id',explode(",",$id))->get();
        $token_data = DB::connection('mysql10')->select('SELECT * FROM nhso_token ORDER BY update_datetime desc limit 1');
        foreach ($token_data as $key => $value) {
            $cid_    = $value->cid;
            $token_  = $value->token;
        }
        foreach ($data_sitss as $key => $item) {
            $pids = $item->cid;
            $vn   = $item->vn;
            $an   = $item->an;
                // $token_data = DB::connection('mysql10')->select('SELECT cid,token FROM hos.nhso_token where token <> ""');
                // foreach ($token_data as $key => $value) {
                    $client = new SoapClient("http://ucws.nhso.go.th/ucwstokenp1/UCWSTokenP1?wsdl",
                        array("uri" => 'http://ucws.nhso.go.th/ucwstokenp1/UCWSTokenP1?xsd=1',"trace" => 1,"exceptions" => 0,"cache_wsdl" => 0)
                        );
                        $params = array(
                            'sequence' => array(
                                "user_person_id"   => "$cid_",
                                "smctoken"         => "$token_",
                                // "user_person_id" => "$value->cid",
                                // "smctoken"       => "$value->token",
                                "person_id"        => "$pids"
                        )
                    );
                    $contents = $client->__soapCall('searchCurrentByPID',$params);
                    foreach ($contents as $v) {
                        @$status = $v->status ;
                        @$maininscl = $v->maininscl;
                        @$startdate = $v->startdate;
                        @$hmain = $v->hmain ;
                        @$subinscl = $v->subinscl ;
                        @$person_id_nhso = $v->person_id;

                        @$hmain_op = $v->hmain_op;  //"10978"
                        @$hmain_op_name = $v->hmain_op_name;  //"รพ.ภูเขียวเฉลิมพระเกียรติ"
                        @$hsub = $v->hsub;    //"04047"
                        @$hsub_name = $v->hsub_name;   //"รพ.สต.แดงสว่าง"
                        @$subinscl_name = $v->subinscl_name ; //"ช่วงอายุ 12-59 ปี"

                        IF(@$maininscl == "" || @$maininscl == null || @$status == "003" ){ #ถ้าเป็นค่าว่างไม่ต้อง insert
                            $date = date("Y-m-d");

                            Acc_debtor::where('vn', $vn)
                            ->update([
                                'status'         => 'จำหน่าย/เสียชีวิต',
                                'maininscl'      => @$maininscl,
                                'pttype_spsch'   => @$subinscl,
                                'hmain'          => @$hmain,
                                'subinscl'       => @$subinscl,
                            ]);

                        }elseif(@$maininscl !="" || @$subinscl !=""){
                           Acc_debtor::where('vn', $vn)
                           ->update([
                               'status'         => @$status,
                               'maininscl'      => @$maininscl,
                               'pttype_spsch'   => @$subinscl,
                               'hmain'          => @$hmain,
                               'subinscl'       => @$subinscl,

                           ]);

                        }

                    }

        }

        return response()->json([

           'status'    => '200'
       ]);

    }
    public function kontoon_imc_pulldata(Request $request)
    {
        $datenow = date('Y-m-d');
        $startdate = $request->datepicker;
        $enddate = $request->datepicker2;

        $acc_debtor = DB::connection('mysql2')->select(
            'SELECT v.vn,ifnull(o.an,"") as an,o.hn,pt.cid ,concat(pt.pname,pt.fname," ",pt.lname) as ptname ,v.vstdate,v.hospmain,v.pdx,vp.auth_code
            ,vp.pttype ,"4301020105.228" as account_code ,"บริการฟื้นฟูสมรรถภาพด้านการแพทย์/IMC" as account_name,o.main_dep
            ,v.income,v.uc_money,v.discount_money,v.paid_money,v.rcpt_money ,v.income-v.discount_money-v.rcpt_money as debit
            ,sum(if(op.income="02",sum_price,0)) as debit_instument
            ,sum(if(op.income="14",sum_price,0)) as debit_income14
            ,sum(if(op.icode IN("3010887","3010885","3010884"),sum_price,0)) as debit_imc
            ,sum(if(op.icode IN("1560016","1540073","1530005","1540048","1620015"),sum_price,0)) as debit_drug
            ,op.icode
            from ovst o
            left outer join vn_stat v on v.vn=o.vn
            left outer join visit_pttype vp on vp.vn = v.vn
            left outer join patient pt on pt.hn=o.hn
            left outer join pttype ptt on o.pttype=ptt.pttype
            left outer join pttype_eclaim e on e.code = ptt.pttype_eclaim_id
            left outer join opitemrece op ON op.vn = o.vn
            WHERE v.vstdate BETWEEN "' . $startdate . '" AND "' . $enddate . '"
            AND op.icode IN("3010584","3010585","3010884","3010885","3010887")
            AND ptt.hipdata_code ="UCS"
            AND (o.an="" or o.an is null)
            GROUP BY v.vn
        ');

        foreach ($acc_debtor as $key => $value) {
            if ($value->debit >0) {
                $check = Acc_debtor::where('vn', $value->vn)->where('account_code', '4301020105.228')->count();
                if ($check > 0) {
                    Acc_debtor::where('vn', $value->vn)->where('account_code', '4301020105.228')->update([
                        'pdx'                => $value->pdx,
                        'claim_code'         => $value->auth_code,
                        'debit_total'        => $value->debit_income14,
                    ]);
                }else{

                    if ($value->pttype == "W1") {
                        if ($value->hospmain == "10970" || $value->hospmain == "10971" || $value->hospmain == "10972" || $value->hospmain == "10973" || $value->hospmain == "10974" || $value->hospmain == "10975" || $value->hospmain == "10976" || $value->hospmain == "10977" || $value->hospmain == "10702" || $value->hospmain == "10979" || $value->hospmain == "10980" || $value->hospmain == "10981" || $value->hospmain == "10983" ) {
                            Acc_debtor::insert([
                                'hn'                 => $value->hn,
                                'an'                 => $value->an,
                                'vn'                 => $value->vn,
                                'cid'                => $value->cid,
                                'ptname'             => $value->ptname,
                                'pttype'             => $value->pttype,
                                'vstdate'            => $value->vstdate,
                                'hospmain'           => $value->hospmain,
                                'main_dep'           => $value->main_dep,
                                'account_code'       => $value->account_code,
                                'account_name'       => $value->account_name,
                                'pdx'                => $value->pdx,
                                'claim_code'         => $value->auth_code,
                                'income'             => $value->income,
                                'uc_money'           => $value->uc_money,
                                'discount_money'     => $value->discount_money,
                                'rcpt_money'         => $value->rcpt_money,
                                'debit'              => $value->debit,
                                'debit_drug'         => $value->debit_drug,
                                'debit_instument'    => $value->debit_instument,
                                'debit_total'        => $value->debit_income14,
                                'acc_debtor_userid'  => Auth::user()->id
                            ]);
                        }
                    } else {
                        Acc_debtor::insert([
                            'hn'                 => $value->hn,
                            'an'                 => $value->an,
                            'vn'                 => $value->vn,
                            'cid'                => $value->cid,
                            'ptname'             => $value->ptname,
                            'pttype'             => $value->pttype,
                            'vstdate'            => $value->vstdate,
                            'hospmain'           => $value->hospmain,
                            'main_dep'           => $value->main_dep,
                            'account_code'       => $value->account_code,
                            'account_name'       => $value->account_name,
                            'pdx'                => $value->pdx,
                            'claim_code'         => $value->auth_code,
                            'income'             => $value->income,
                            'uc_money'           => $value->uc_money,
                            'discount_money'     => $value->discount_money,
                            'rcpt_money'         => $value->rcpt_money,
                            'debit'              => $value->debit,
                            'debit_drug'         => $value->debit_drug,
                            'debit_instument'    => $value->debit_instument,
                            'debit_total'        => $value->debit_income14,
                            'acc_debtor_userid'  => Auth::user()->id
                        ]);
                    }


                }
            } else {
                # code...
            }
        }
        return response()->json([
            'status'    => '200'
        ]);
    }
    public function kontoon_imc_stam(Request $request)
    {
        $id = $request->ids;
        $iduser = Auth::user()->id;

        $data = Acc_debtor::whereIn('acc_debtor_id',explode(",",$id))->get();
        foreach ($data as $key => $value) {
            $check = Acc_4301020105_228::where('vn', $value->vn)->count();
            if ( $check > 0) {
                # code...
            } else {
                Acc_4301020105_228::insert([
                    'vn'                => $value->vn,
                    'hn'                => $value->hn,
                    'an'                => $value->an,
                    'cid'               => $value->cid,
                    'ptname'            => $value->ptname,
                    'vstdate'           => $value->vstdate,
                    'regdate'           => $value->regdate,
                    'dchdate'           => $value->dchdate,
                    'pttype'            => $value->pttype,
                    'acc_code'          => $value->acc_code,
                    'account_code'      => $value->account_code,
                    'pdx'                => $value->pdx,
                    'claim_code'         => $value->auth_code,
                    'main_dep'           => $value->main_dep,
                    // 'rw'                 => $value->rw,
                    // 'adjrw'              => $value->adjrw,
                    // 'total_adjrw_income' => $value->total_adjrw_income,
                    'debit_drug'         => $value->debit_drug,
                    'debit_instument'    => $value->debit_instument,
                    'debit_toa'          => $value->debit_toa,
                    'debit_refer'        => $value->debit_refer,
                    'income'             => $value->income,
                    'uc_money'           => $value->uc_money,
                    'discount_money'     => $value->discount_money,
                    'rcpt_money'         => $value->rcpt_money,
                    'debit'              => $value->debit,
                    'debit_total'        => $value->debit_total,
                    'acc_debtor_userid'  => $value->acc_debtor_userid
                ]);
            }
        }
        Acc_debtor::whereIn('acc_debtor_id',explode(",",$id))
        ->update([
            'stamp' => 'Y'
        ]);

        return response()->json([
            'status'    => '200'
        ]);
    }
    public function kontoon_imc_detail(Request $request,$months,$year)
    {
        $datenow         = date('Y-m-d');
        // $months          = date('m');
        // $year            = date('Y');
        $newday          = date('Y-m-d', strtotime($datenow . ' -2 Day')); //ย้อนหลัง 1 สัปดาห์
        $startdate       = $request->startdate;
        $enddate         = $request->enddate;


            $acc_debtor = DB::select('
                SELECT *
                from acc_4301020105_228 a
                WHERE month(a.vstdate) = "' . $months . '"
                 AND year(a.vstdate) = "' . $year . '"
                order by a.vstdate desc;
            ');
                $data['count_claim'] = Acc_debtor::where('active_claim','=','Y')->where('account_code','=','4301020105.228')->whereBetween('vstdate', [$newday, $datenow])->count();
                $data['count_noclaim'] = Acc_debtor::where('active_claim','=','N')->where('account_code','=','4301020105.228')->whereBetween('vstdate', [$newday, $datenow])->count();



        $data_activeclaim        = Acc_function::where('pang','4301020105.228')->first();
        $data['activeclaim']     = $data_activeclaim->claim_active;
        $data['acc_function_id'] = $data_activeclaim->acc_function_id;

        return view('kongtoon_imc.kontoon_imc_detail',$data,[
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
            'acc_debtor'    =>     $acc_debtor,
        ]);
    }

    // public function account_pkucs209_detail(Request $request,$months,$year)
    // {
    //     $datenow = date('Y-m-d');
    //     $startdate = $request->startdate;
    //     $enddate = $request->enddate;
    //     // dd($id);
    //     $data['users'] = User::get();

    //     $data = DB::select('
    //         SELECT *  from acc_1102050101_209
    //         WHERE month(vstdate) = "'.$months.'" and year(vstdate) = "'.$year.'"

    //     ');
    //     // GROUP BY vn
    //     return view('account_209.account_pkucs209_detail', $data, [
    //         'startdate'     =>     $startdate,
    //         'enddate'       =>     $enddate,
    //         'data'          =>     $data,
    //         'months'        =>     $months,
    //         'year'          =>     $year
    //     ]);
    // }
    // public function account_pkucs209_search(Request $request)
    // {
    //     $datenow = date('Y-m-d');
    //     $startdate = $request->startdate;
    //     $enddate = $request->enddate;
    //     $date = date('Y-m-d');
    //     $new_day = date('Y-m-d', strtotime($date . ' -2 day')); //ย้อนหลัง 2 วัน
    //     $data['users'] = User::get();
    //     if ($startdate =='') {
    //        $datashow = DB::select('

    //            SELECT a.*,b.pp,b.fs
    //            from acc_1102050101_209 a
    //            LEFT JOIN acc_stm_ucs b ON b.hn = a.hn AND b.vstdate = a.vstdate
    //            WHERE a.vstdate BETWEEN "'.$new_day.'" AND  "'.$date.'"
    //            GROUP BY a.vn
    //        ');
    //     } else {
    //        $datashow = DB::select('
    //            SELECT a.*,b.pp,b.fs
    //            from acc_1102050101_209 a
    //            LEFT JOIN acc_stm_ucs b ON b.hn = a.hn AND b.vstdate = a.vstdate
    //            WHERE a.vstdate BETWEEN "'.$startdate.'" AND  "'.$enddate.'"
    //            GROUP BY a.vn
    //        ');
    //     }
    //     return view('account_209.account_pkucs209_search', $data, [
    //         'startdate'     => $startdate,
    //         'enddate'       => $enddate,
    //         'datashow'      => $datashow,
    //         'startdate'     => $startdate,
    //         'enddate'       => $enddate
    //     ]);
    // }

    // public function account_pkucs209_stm(Request $request,$months,$year)
    // {
    //     $datenow = date('Y-m-d');
    //     $startdate = $request->startdate;
    //     $enddate = $request->enddate;
    //     // dd($id);
    //     $data['users'] = User::get();

    //     $datashow = DB::select('
    //         SELECT s.tranid,a.vn,a.an,a.hn,a.cid,a.ptname,a.vstdate,a.dchdate,s.dmis_money2
    //         ,a.income_group,s.inst,s.hc,s.hc_drug,s.ae,s.ae_drug,s.STMdoc,a.debit_total,s.ip_paytrue as STM202
    //         ,s.inst+s.hc+s.hc_drug+s.ae+s.ae_drug+s.dmis_money2+s.dmis_drug as stm217,s.pp,s.fs
    //         ,s.total_approve STM_TOTAL
    //         from acc_1102050101_209 a
    //         LEFT JOIN acc_stm_ucs s ON s.hn = a.hn AND s.vstdate = a.vstdate
    //         WHERE month(a.vstdate) = "'.$months.'" and year(a.vstdate) = "'.$year.'"

    //         AND s.pp > 0
    //         group by a.vn
    //     ');
    //     // AND s.rep IS NOT NULL

    //         return view('account_209.account_pkucs209_stm', $data, [
    //             'startdate'         =>     $startdate,
    //             'enddate'           =>     $enddate,
    //             'datashow'          =>     $datashow,
    //             'months'            =>     $months,
    //             'year'              =>     $year,
    //         ]);
    // }

    public function kontoon_imc_destroy(Request $request)
    {
        $id = $request->ids;
        $data = Acc_debtor::whereIn('acc_debtor_id',explode(",",$id))->get();
            Acc_debtor::whereIn('acc_debtor_id',explode(",",$id))->delete();

        return response()->json([
            'status'    => '200'
        ]);
    }

     // **************** REP  *****************************
     public function kontoon_imc_up(Request $request)
     {
         $startdate = $request->startdate;
         $enddate = $request->enddate;
         $data['users'] = User::get();
         $countc = DB::table('acc_nongtoon_repexcel')->count();
         $datashow = DB::table('acc_nongtoon_repexcel')->get();


         return view('kongtoon_imc.kontoon_imc_up',[
             'startdate'     =>     $startdate,
             'enddate'       =>     $enddate,
             'datashow'      =>     $datashow,
             'countc'        =>     $countc
         ]);
     }
     function kontoon_imc_save (Request $request)
    {
        // $this->validate($request, [
        //     'file' => 'required|file|mimes:xls,xlsx'
        // ]);
        $the_file = $request->file('file');
        $file_ = $request->file('file')->getClientOriginalName(); //ชื่อไฟล์

                $spreadsheet = IOFactory::load($the_file);
                $sheet        = $spreadsheet->setActiveSheetIndex(2);
                $row_limit    = $sheet->getHighestDataRow();
                // $column_limit = $sheet->getHighestDataColumn();
                $row_range    = range( 9, $row_limit );
                // $column_range = range( 'AO', $column_limit );
                $startcount = 9;
                $data = array();
                foreach ($row_range as $row ) {
                    $vst = $sheet->getCell( 'K' . $row )->getValue();
                    $day = substr($vst,0,2);
                    $mo = substr($vst,3,2);
                    $year = substr($vst,6,4);
                    $vstdate = $year.'-'.$mo.'-'.$day;

                    $send = $sheet->getCell( 'J' . $row )->getValue();
                    $regday = substr($send, 0, 2);
                    $regmo = substr($send, 3, 2);
                    $regyear = substr($send, 6, 4);
                    $senddate = $regyear.'-'.$regmo.'-'.$regday;

                    $o = $sheet->getCell( 'O' . $row )->getValue();
                    $del_o = str_replace(",","",$o);
                    $p= $sheet->getCell( 'P' . $row )->getValue();
                    $del_p = str_replace(",","",$p);
                    $aq = $sheet->getCell( 'Q' . $row )->getValue();
                    $del_aq = str_replace(",","",$aq);
                    $at = $sheet->getCell( 'T' . $row )->getValue();
                    $del_at = str_replace(",","",$at);
                    $au = $sheet->getCell( 'U' . $row )->getValue();
                    $del_au = str_replace(",","",$au);
                    $av = $sheet->getCell( 'V' . $row )->getValue();
                    $del_av = str_replace(",","",$av);
                    $aw = $sheet->getCell( 'W' . $row )->getValue();
                    $del_aw = str_replace(",","",$aw);


                    $data[] = [
                        'rep_no'                    =>$sheet->getCell( 'B' . $row )->getValue(),
                        'tran_id'                   =>$sheet->getCell( 'C' . $row )->getValue(),
                        'hn'                        =>$sheet->getCell( 'D' . $row )->getValue(),
                        'an'                        =>$sheet->getCell( 'E' . $row )->getValue(),
                        'cid'                       =>$sheet->getCell( 'F' . $row )->getValue(),
                        'ptname'                    =>$sheet->getCell( 'G' . $row )->getValue(),
                        'hipdata_code'              =>$sheet->getCell( 'H' . $row )->getValue(),
                        'hmain_op'                  =>$sheet->getCell( 'I' . $row )->getValue(),
                        'date_send'                 =>$senddate,
                        'vstdate'                   =>$vstdate,
                        'stm_type_no'               =>$sheet->getCell( 'L' . $row )->getValue(),
                        'stm_type_name'             =>$sheet->getCell( 'M' . $row )->getValue(),
                        'stm_req_qty'               =>$sheet->getCell( 'N' . $row )->getValue(),
                        'stm_req_price'             =>$del_o,
                        'stm_burk_price'            =>$del_aq,
                        'stm_chodchey'              =>$del_at,
                        'stm_chodchey_no'           =>$del_au,
                        'stm_chodchey_plus'         =>$del_av,
                        'stm_chodchey_back'         =>$del_aw,
                        'status_pay'                =>$sheet->getCell( 'X' . $row )->getValue(),
                        'comment'                   =>$sheet->getCell( 'Y' . $row )->getValue(),
                        'comment_orther'            =>$sheet->getCell( 'Z' . $row )->getValue(),
                        'icode_inst'                =>$sheet->getCell( 'AA' . $row )->getValue(),
                        'name_inst'                 =>$sheet->getCell( 'AB' . $row )->getValue(),
                        'hospsub'                   =>$sheet->getCell( 'AC' . $row )->getValue(),
                        'STMDoc'                    =>$file_
                    ];
                    $startcount++;

                }

                foreach (array_chunk($data,500) as $t)
                {
                    DB::table('acc_nongtoon_repexcel')->insert($t);
                }

            return redirect()->route('acc.kontoon_imc_up');
    }
    public function kontoon_imc_send(Request $request)
    {

        try{
            $data_ = DB::connection('mysql')->select('SELECT * FROM acc_nongtoon_repexcel');
                foreach ($data_ as $key => $value) {
                    if ($value->stm_chodchey != '') {
                        $check = Acc_nongtoon_rep::where('cid','=',$value->cid)->where('vstdate','=',$value->vstdate)->count();
                        if ($check > 0) {
                        } else {
                            Acc_nongtoon_rep::insert([
                                'rep_no'                   =>$value->rep_no,
                                'tran_id'                    =>$value->tran_id,
                                'hn'                =>$value->hn,
                                'an'                    =>$value->an,
                                'cid'                    =>$value->cid,
                                'ptname'                   =>$value->ptname,
                                'hipdata_code'                =>$value->hipdata_code,
                                'hmain_op'                  =>$value->hmain_op,
                                'date_send'               =>$value->date_send,
                                'vstdate'               =>$value->vstdate,
                                'stm_type_no'                =>$value->stm_type_no,
                                'stm_type_name'              =>$value->stm_type_name,
                                'stm_req_qty'             =>$value->stm_req_qty,
                                'stm_req_price'              =>$value->stm_req_price,
                                'stm_burk_price'           =>$value->stm_burk_price,
                                'stm_chodchey'                 =>$value->stm_chodchey,
                                'stm_chodchey_no'           =>$value->stm_chodchey_no,
                                'stm_chodchey_plus'           =>$value->stm_chodchey_plus,
                                'stm_chodchey_back'           =>$value->stm_chodchey_back,
                                'acc_debtor_userid'          =>$value->acc_debtor_userid,
                                'status'                  =>$value->status,
                                'status_pay'                 =>$value->status_pay,
                                'comment'                 =>$value->comment,
                                'comment_orther'              =>$value->comment_orther,
                                'icode_inst'              =>$value->icode_inst,
                                'hospsub'              =>$value->hospsub,
                                'STMDoc'                  =>$value->STMDoc
                            ]);
                        }

                        $checks = Acc_4301020105_228::where('cid', $value->cid)->where('vstdate', $value->vstdate)->where('account_code','4301020105.228')->count();
                        if ($checks > 0) {
                            if ($value->status =='ชดเชย') {
                                $status_new    = 'Y';
                            } else {
                                $status_new    = 'N';
                            }

                            Acc_4301020105_228::where('cid', $value->cid)->where('vstdate', $value->vstdate)->update(
                                [
                                    'vstdate'           => $value->date_send,
                                    'stm_rep'              => $value->rep_no,
                                    'stm_trainid'          => $value->tran_id,
                                    'stm_type_no'          => $value->stm_type_no,
                                    'stm_type_name'        => $value->stm_type_name,
                                    'stm_req_qty'          => $value->stm_req_qty,
                                    'stm_req_price'        => $value->stm_req_price,
                                    'stm_burk_price'       => $value->stm_burk_price,
                                    'stm_chodchey'         => $value->stm_chodchey,
                                    'stm_chodchey_no'      => $value->stm_chodchey_no,
                                    'stm_chodchey_plus'    => $value->stm_chodchey_plus,
                                    'stm_chodchey_back'    => $value->stm_chodchey_back,
                                    'status'               => $status_new,
                                    'comment'              => $value->comment,
                                    'comment_orther'       => $value->comment_orther,
                                    'icode_inst'           => $value->icode_inst,
                                    'name_inst'            => $value->name_inst,
                                    'hospsub'              => $value->hospsub,
                                    'STMDoc'               => $value->STMDoc,
                                ]
                            );
                        }
                    }


                }
            } catch (Exception $e) {
                $error_code = $e->errorInfo[1];
                return back()->withErrors('There was a problem uploading the data!');
            }






            Acc_nongtoon_repexcel::truncate();

            return response()->json([
                'status'    => '200',
            ]);
        // return redirect()->back();
    }


 }
