<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\support\Facades\Hash;
use Illuminate\support\Facades\Validator;
use App\Models\User;
use App\Models\Ot_one;
use PDF;
use setasign\Fpdi\Fpdi;
use App\Models\Budget_year;
use Illuminate\Support\Facades\File;
use DataTables;
use Intervention\Image\ImageManagerStatic as Image;
// use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\OtExport;
// use App\Imports\UsersImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Department;
use App\Models\Departmentsub;
use App\Models\Departmentsubsub;
use App\Models\Position;
use App\Models\Product_spyprice;
use App\Models\Products;
use App\Models\Products_type;
use App\Models\Product_group;
use App\Models\Product_unit;
use App\Models\Products_category;
use App\Models\Article;
use App\Models\Product_prop;
use App\Models\Product_decline;
use App\Models\Department_sub_sub;
use App\Models\Products_vendor;
use App\Models\Status;
use App\Models\Products_request;
use App\Models\Products_request_sub;
use App\Models\Leave_leader;
use App\Models\Leave_leader_sub;
use App\Models\Book_type;
use App\Models\Book_import_fam;
use App\Models\Book_signature;
use App\Models\Bookrep;
use App\Models\Book_objective;
use App\Models\Book_senddep;
use App\Models\Book_senddep_sub;
use App\Models\Book_send_person;
use App\Models\Book_sendteam;
use App\Models\Bookrepdelete;
use App\Models\Car_status;
use App\Models\Check_sit_auto;
use App\Models\Article_status;
use App\Models\Visit_pttype;
use App\Models\Product_brand;
use App\Models\Product_color;
use App\Models\Land;
use App\Models\Building;
use App\Models\Product_budget;
use App\Models\Product_method;
use App\Models\Visit_pttype_205;
use App\Models\Visit_pttype_217;
use App\Models\D_fdh_opd;
use App\Models\D_fdh_ipd;
use App\Models\D_fdh;
use App\Models\D_ins;
use App\Models\D_pat;
use App\Models\D_opd;
use App\Models\D_orf;
use App\Models\D_odx;
use App\Models\D_cht;
use App\Models\D_cha;
use App\Models\D_oop;
use App\Models\D_claim;
use App\Models\D_adp;
use App\Models\D_dru;
use App\Models\D_idx;
use App\Models\D_iop;
use App\Models\D_ipd;
use App\Models\D_aer;
use App\Models\D_irf;
use App\Models\D_ofc_401;
use App\Models\D_ucep24_main;
use App\Models\D_ucep24;
use App\Models\Acc_ucep24;
use App\Models\Fdh_ins;
use App\Models\Fdh_pat;
use App\Models\Fdh_opd;
use App\Models\Fdh_orf;
use App\Models\Fdh_odx;
use App\Models\Fdh_cht;
use App\Models\Fdh_cha;
use App\Models\Fdh_oop;
use App\Models\Fdh_adp;
use App\Models\Fdh_dru;
use App\Models\Fdh_idx;
use App\Models\Fdh_iop;
use App\Models\Fdh_ipd;
use App\Models\Fdh_aer;
use App\Models\Fdh_irf;
use App\Models\Fdh_lvd;
use App\Models\Vn_stat;
use App\Models\Fdh_mini_dataset;
use App\Models\Api_neweclaim;
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
use PhpOffice\PhpSpreadsheet\Reader\Exception;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\IOFactory;
use ZipArchive;
use Illuminate\Support\Facades\Redirect;
use PhpParser\Node\Stmt\If_;
use Stevebauman\Location\Facades\Location;
use Auth;
use Http;
use SoapClient;
use Arr;
use GuzzleHttp\Client;
use DateTime;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\RequestException;

class FdhController extends Controller
{
    public function fdh_report_rep(Request $request)
    {
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        $data['users']     = User::get();
        $date = date('Y-m-d');
        $newweek = date('Y-m-d', strtotime($date . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
        $newDate = date('Y-m-d', strtotime($date . ' -2 months')); //ย้อนหลัง 2 เดือน
        $newyear = date('Y-m-d', strtotime($date . ' -1 year')); //ย้อนหลัง 1 ปี

        if ($startdate == '') {
            // $data['d_fdh']    = DB::connection('mysql')->select('SELECT * from d_fdh WHERE active ="R" AND  vstdate BETWEEN "'.$newDate.'" and "'.$date.'" ORDER BY vn ASC');
            $data['d_fdh']    = DB::connection('mysql')->select('SELECT * from d_fdh WHERE vstdate BETWEEN "' . $newweek . '" and "' . $date . '" ORDER BY vn ASC');
        } else {
            $data['d_fdh']    = DB::connection('mysql')->select('SELECT * from d_fdh WHERE vstdate BETWEEN "' . $startdate . '" and "' . $enddate . '" ORDER BY vn ASC');
        }

        return view('fdh.fdh_report_rep', $data, [
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
        ]);
    }
    public function fdh_dashboard(Request $request)
    {
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        $data['users']     = User::get();
        return view('fdh.fdh_dashboard', $data, [
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
        ]);
    }
    public function fdh_main(Request $request)
    {
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        $data['users']     = User::get();
        if ($startdate == '') {
        } else {
            $iduser = Auth::user()->id;
            $data_main_opd = DB::connection('mysql2')->select(
                'SELECT v.vn,o.an,v.cid,v.hn,concat(p.pname,p.fname," ",p.lname) ptname,h.hospcode
                                ,v.vstdate,v.pttype,v.income,pt.hipdata_code,GROUP_CONCAT(DISTINCT ov.icd10 order by ov.diagtype) AS icd10,v.pdx
                                ,v.income-v.rcpt_money-v.discount_money as debit
                                FROM vn_stat v
                                LEFT OUTER JOIN ovst o ON v.vn=o.vn
                                LEFT OUTER JOIN patient p ON v.hn=p.hn
                                LEFT OUTER JOIN ovstdiag ov ON v.vn=ov.vn
                                LEFT OUTER JOIN pttype pt ON v.pttype=pt.pttype
                                LEFT OUTER JOIN hospcode h on h.hospcode = v.hospmain

                            WHERE o.vstdate BETWEEN "' . $startdate . '" and "' . $enddate . '"
                            AND o.an is null
                            GROUP BY v.vn
                    '
            );
            // ,ca.claimcode as authen
            // LEFT OUTER JOIN pkbackoffice.check_authen ca on ca.cid = v.cid AND ca.vstdate = v.vstdate
            // LEFT OUTER JOIN ipt i on i.vn = v.vn
            foreach ($data_main_opd as $key => $value) {
                $check_opd = D_fdh::where('vn', $value->vn)->count();
                if ($check_opd > 0) {

                } else {
                    D_fdh::insert([
                        'vn'           => $value->vn,
                        'hn'           => $value->hn,
                        'an'           => $value->an,
                        'cid'          => $value->cid,
                        'pttype'       => $value->pttype,
                        // 'authen'       => $value->authen,
                        'ptname'       => $value->ptname,
                        'vstdate'      => $value->vstdate,
                        'hospcode'     => $value->hospcode,
                        'icd10'        => $value->icd10,
                        'debit'        => $value->debit
                    ]);
                }
            }

            $data_main_ipd = DB::connection('mysql2')->select(
                'SELECT i.vn,a.hn HN,a.an AN,p.cid,a.pttype,i.dchdate,concat(p.pname,p.fname," ",p.lname) ptname,o.icd10 DIAG
                        ,a.income-a.rcpt_money-a.discount_money as debit
                            FROM an_stat a
                            LEFT OUTER JOIN ipt i on i.an = a.an
                            LEFT OUTER JOIN pttype pt on pt.pttype = a.pttype
                            LEFT OUTER JOIN patient p on p.hn = a.hn
                            LEFT OUTER JOIN iptdiag o on o.an = a.an
                            WHERE i.dchdate BETWEEN "' . $startdate . '" and "' . $enddate . '"
                            GROUP BY a.an
                    '
            );
            foreach ($data_main_ipd as $key => $value2) {
                $check_ipd = D_fdh::where('vn', $value2->vn)->count();
                if ($check_ipd > 0) {
                    D_fdh::where('vn', $value2->vn)->update([
                        'dchdate'      => $value2->dchdate,
                        'debit'        => $value2->debit
                    ]);
                } else {
                    D_fdh::insert([
                        'vn'           => $value2->vn,
                        'hn'           => $value2->HN,
                        'an'           => $value2->AN,
                        'cid'          => $value2->cid,
                        'pttype'       => $value2->pttype,
                        'ptname'       => $value2->ptname,
                        'dchdate'      => $value2->dchdate,
                        'icd10'        => $value2->DIAG,
                        'debit'        => $value2->debit
                    ]);
                }
            }
            $data_authen_    = DB::connection('mysql')->select('SELECT hncode,cid,vstdate,claimcode FROM check_authen WHERE vstdate BETWEEN "' . $startdate . '" and "' . $enddate . '" ');
            foreach ($data_authen_ as $key => $v_up) {
                D_fdh::where('cid', $v_up->cid)->where('vstdate', $v_up->vstdate)->update([
                    'authen'   => $v_up->claimcode,
                ]);
            }
        }

        $data['d_fdh']    = DB::connection('mysql')->select('SELECT * from d_fdh WHERE active ="N" AND authen IS NOT NULL AND icd10 IS NOT NULL ORDER BY vn ASC');
        $data['data_opd'] = DB::connection('mysql')->select('SELECT * from fdh_opd WHERE d_anaconda_id ="FDH"');
        $data['data_orf'] = DB::connection('mysql')->select('SELECT * from fdh_orf WHERE d_anaconda_id ="FDH"');
        $data['data_oop'] = DB::connection('mysql')->select('SELECT * from fdh_oop WHERE d_anaconda_id ="FDH"');
        $data['data_odx'] = DB::connection('mysql')->select('SELECT * from fdh_odx WHERE d_anaconda_id ="FDH"');
        $data['data_idx'] = DB::connection('mysql')->select('SELECT * from fdh_idx WHERE d_anaconda_id ="FDH"');
        $data['data_ipd'] = DB::connection('mysql')->select('SELECT * from fdh_ipd WHERE d_anaconda_id ="FDH"');
        $data['data_irf'] = DB::connection('mysql')->select('SELECT * from fdh_irf WHERE d_anaconda_id ="FDH"');
        $data['data_aer'] = DB::connection('mysql')->select('SELECT * from fdh_aer WHERE d_anaconda_id ="FDH"');
        $data['data_iop'] = DB::connection('mysql')->select('SELECT * from fdh_iop WHERE d_anaconda_id ="FDH"');
        $data['data_adp'] = DB::connection('mysql')->select('SELECT * from fdh_adp WHERE d_anaconda_id ="FDH"');
        $data['data_pat'] = DB::connection('mysql')->select('SELECT * from fdh_pat WHERE d_anaconda_id ="FDH"');
        $data['data_cht'] = DB::connection('mysql')->select('SELECT * from fdh_cht WHERE d_anaconda_id ="FDH"');
        $data['data_cha'] = DB::connection('mysql')->select('SELECT * from fdh_cha WHERE d_anaconda_id ="FDH"');
        $data['data_ins'] = DB::connection('mysql')->select('SELECT * from fdh_ins WHERE d_anaconda_id ="FDH"');
        $data['data_dru'] = DB::connection('mysql')->select('SELECT * from fdh_dru WHERE d_anaconda_id ="FDH"');

        return view('fdh.fdh_main', $data, [
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
        ]);
    }

    public function fdh_checksit(Request $request)
    {
        $datestart = $request->datestart;
        $dateend = $request->dateend;
        $date = date('Y-m-d');

        $data_sitss = DB::connection('mysql')->select('SELECT vn,an,cid,vstdate,dchdate FROM d_fdh WHERE active = "N" AND subinscl IS NULL GROUP BY cid');

        $token_data = DB::connection('mysql10')->select('SELECT * FROM nhso_token ORDER BY update_datetime desc limit 1');
        foreach ($token_data as $key => $value) {
            $cid_    = $value->cid;
            $token_  = $value->token;
        }
        foreach ($data_sitss as $key => $item) {
            $pids = $item->cid;
            $vn   = $item->vn;
            $an   = $item->an;

            $client = new SoapClient(
                "http://ucws.nhso.go.th/ucwstokenp1/UCWSTokenP1?wsdl",
                array("uri" => 'http://ucws.nhso.go.th/ucwstokenp1/UCWSTokenP1?xsd=1', "trace" => 1, "exceptions" => 0, "cache_wsdl" => 0)
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
            $contents = $client->__soapCall('searchCurrentByPID', $params);
            foreach ($contents as $v) {
                @$status = $v->status;
                @$maininscl = $v->maininscl;
                @$startdate = $v->startdate;
                @$hmain = $v->hmain;
                @$subinscl = $v->subinscl;
                @$person_id_nhso = $v->person_id;

                @$hmain_op = $v->hmain_op;  //"10978"
                @$hmain_op_name = $v->hmain_op_name;  //"รพ.ภูเขียวเฉลิมพระเกียรติ"
                @$hsub = $v->hsub;    //"04047"
                @$hsub_name = $v->hsub_name;   //"รพ.สต.แดงสว่าง"
                @$subinscl_name = $v->subinscl_name; //"ช่วงอายุ 12-59 ปี"

                if (@$maininscl == "" || @$maininscl == null || @$status == "003") { #ถ้าเป็นค่าว่างไม่ต้อง insert
                    $date = date("Y-m-d");

                    D_fdh::where('cid', $pids)
                        ->update([
                            // 'status'         => 'จำหน่าย/เสียชีวิต',
                            // 'maininscl'      => @$maininscl,
                            // 'pttype_spsch'   => @$subinscl,
                            // 'hmain'          => @$hmain,
                            'subinscl'       => @$subinscl,
                        ]);
                } elseif (@$maininscl != "" || @$subinscl != "") {
                    D_fdh::where('cid', $pids)
                        ->update([
                            //    'status'         => @$status,
                            //    'maininscl'      => @$maininscl,
                            //    'pttype_spsch'   => @$subinscl,
                            //    'hmain'          => @$hmain,
                            'subinscl'       => @$subinscl,

                        ]);
                }
            }
        }

        return response()->json([

            'status'    => '200'
        ]);
    }
    public function fdh_data(Request $request)
    {
        $startdate = $request->startdate;
        $enddate = $request->enddate;

        if ($startdate == '') {
        } else {
            D_fdh_opd::truncate();
            D_fdh_ipd::truncate();
            $data_main_ = DB::connection('mysql2')->select('
                        SELECT v.vn,v.cid,v.hn,concat(p.pname,p.fname," ",p.lname) ptname,v.vstdate,v.pttype
                        FROM hos.vn_stat v
                        LEFT OUTER JOIN hos.patient p ON v.hn = p.hn
                        WHERE v.vstdate BETWEEN "' . $startdate . '" and "' . $enddate . '"
                        GROUP BY v.vn
                    ');
            foreach ($data_main_ as $key => $value) {
                D_fdh_opd::insert([
                    'vn'                 => $value->vn,
                    'hn'                 => $value->hn,
                    'cid'                => $value->cid,
                    'ptname'             => $value->ptname,
                    'pttype'             => $value->pttype,
                    'vstdate'            => $value->vstdate
                ]);
            }

            $data_mainipd_ = DB::connection('mysql2')->select('
                        SELECT a.an,p.cid,a.hn,concat(p.pname,p.fname," ",p.lname) ptname,a.dchdate,a.pttype
                        FROM hos.an_stat a
                        LEFT OUTER JOIN hos.patient p ON a.hn = p.hn
                        WHERE a.dchdate BETWEEN "' . $startdate . '" and "' . $enddate . '"
                        GROUP BY a.an
                    ');
            foreach ($data_mainipd_ as $key => $value2) {
                D_fdh_ipd::insert([
                    'an'                 => $value2->an,
                    'hn'                 => $value2->hn,
                    'cid'                => $value2->cid,
                    'ptname'             => $value2->ptname,
                    'pttype'             => $value2->pttype,
                    'dchdate'            => $value2->dchdate
                ]);
            }


            D_opd::truncate();
            D_orf::truncate();
            D_oop::truncate();
            D_odx::truncate();
            D_idx::truncate();
            D_ipd::truncate();
            D_irf::truncate();
            D_aer::truncate();
            D_iop::truncate();
            D_adp::truncate();
            D_dru::truncate();
            D_pat::truncate();
            D_cht::truncate();
            D_cha::truncate();
            D_ins::truncate();
        }


        $data['d_fdh_opd'] = DB::connection('mysql')->select('SELECT * from d_fdh_opd');
        $data['d_fdh_ipd'] = DB::connection('mysql')->select('SELECT * from d_fdh_ipd');
        $data['data_opd'] = DB::connection('mysql')->select('SELECT * from d_opd WHERE d_anaconda_id ="FDH"');
        $data['data_orf'] = DB::connection('mysql')->select('SELECT * from d_orf WHERE d_anaconda_id ="FDH"');
        $data['data_oop'] = DB::connection('mysql')->select('SELECT * from d_oop WHERE d_anaconda_id ="FDH"');
        $data['data_odx'] = DB::connection('mysql')->select('SELECT * from d_odx WHERE d_anaconda_id ="FDH"');
        $data['data_idx'] = DB::connection('mysql')->select('SELECT * from d_idx WHERE d_anaconda_id ="FDH"');
        $data['data_ipd'] = DB::connection('mysql')->select('SELECT * from d_ipd WHERE d_anaconda_id ="FDH"');
        $data['data_irf'] = DB::connection('mysql')->select('SELECT * from d_irf WHERE d_anaconda_id ="FDH"');
        $data['data_aer'] = DB::connection('mysql')->select('SELECT * from d_aer WHERE d_anaconda_id ="FDH"');
        $data['data_iop'] = DB::connection('mysql')->select('SELECT * from d_iop WHERE d_anaconda_id ="FDH"');
        $data['data_adp'] = DB::connection('mysql')->select('SELECT * from d_adp WHERE d_anaconda_id ="FDH"');
        $data['data_pat'] = DB::connection('mysql')->select('SELECT * from d_pat WHERE d_anaconda_id ="FDH"');
        $data['data_cht'] = DB::connection('mysql')->select('SELECT * from d_cht WHERE d_anaconda_id ="FDH"');
        $data['data_cha'] = DB::connection('mysql')->select('SELECT * from d_cha WHERE d_anaconda_id ="FDH"');
        $data['data_ins'] = DB::connection('mysql')->select('SELECT * from d_ins WHERE d_anaconda_id ="FDH"');
        $data['data_dru'] = DB::connection('mysql')->select('SELECT * from d_dru WHERE d_anaconda_id ="FDH"');

        return view('fdh.fdh_data', $data, [
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
        ]);
    }
    public function fdh_data_process(Request $request)
    {
        // $data_vn_1 = DB::connection('mysql')->select('SELECT vn,an,hn,cid from d_fdh WHERE active ="N"');

        Fdh_ins::where('d_anaconda_id', '=', 'FDH')->delete();
        Fdh_pat::where('d_anaconda_id', '=', 'FDH')->delete();
        Fdh_opd::where('d_anaconda_id', '=', 'FDH')->delete();
        Fdh_orf::where('d_anaconda_id', '=', 'FDH')->delete();
        Fdh_odx::where('d_anaconda_id', '=', 'FDH')->delete();
        Fdh_oop::where('d_anaconda_id', '=', 'FDH')->delete();
        Fdh_ipd::where('d_anaconda_id', '=', 'FDH')->delete();
        Fdh_irf::where('d_anaconda_id', '=', 'FDH')->delete();
        Fdh_idx::where('d_anaconda_id', '=', 'FDH')->delete();
        Fdh_iop::where('d_anaconda_id', '=', 'FDH')->delete();
        Fdh_cht::where('d_anaconda_id', '=', 'FDH')->delete();
        Fdh_cha::where('d_anaconda_id', '=', 'FDH')->delete();
        Fdh_aer::where('d_anaconda_id', '=', 'FDH')->delete();
        Fdh_adp::where('d_anaconda_id', '=', 'FDH')->delete();
        Fdh_dru::where('d_anaconda_id', '=', 'FDH')->delete();
        Fdh_lvd::where('d_anaconda_id', '=', 'FDH')->delete();

        $id = $request->ids;
        $iduser = Auth::user()->id;
        $data_vn_1 = D_fdh::whereIn('d_fdh_id', explode(",", $id))->get();

        foreach ($data_vn_1 as $key => $va1) {

            //D_ins OK
            $data_ins_ = DB::connection('mysql2')->select('
                SELECT v.hn HN
                ,if(i.an is null,p.hipdata_code,pp.hipdata_code) INSCL ,if(i.an is null,p.pcode,pp.pcode) SUBTYPE,v.cid CID,v.hcode AS HCODE
                ,DATE_FORMAT(if(i.an is null,v.pttype_begin,ap.begin_date), "%Y%m%d") DATEIN
                ,DATE_FORMAT(if(i.an is null,v.pttype_expire,ap.expire_date), "%Y%m%d") DATEEXP
                ,if(i.an is null,v.hospmain,ap.hospmain) HOSPMAIN,if(i.an is null,v.hospsub,ap.hospsub) HOSPSUB,"" GOVCODE ,"" GOVNAME
                ,ifnull(if(i.an is null,r.sss_approval_code,ap.claim_code),ca.claimcode) PERMITNO
                ,"" DOCNO ,"" OWNRPID,"" OWNNAME ,i.an AN ,v.vn SEQ ,"" SUBINSCL,"" RELINSCL
                ,"" HTYPE
                FROM vn_stat v
                LEFT OUTER JOIN pttype p on p.pttype = v.pttype
                LEFT OUTER JOIN ipt i on i.vn = v.vn
                LEFT OUTER JOIN pttype pp on pp.pttype = i.pttype
                LEFT OUTER JOIN ipt_pttype ap on ap.an = i.an
                LEFT OUTER JOIN visit_pttype vp on vp.vn = v.vn
                LEFT OUTER JOIN rcpt_debt r on r.vn = v.vn
                LEFT OUTER JOIN patient px on px.hn = v.hn
                LEFT OUTER JOIN pkbackoffice.check_authen ca on ca.cid = px.cid AND ca.vstdate = v.vstdate
                WHERE v.vn IN("' . $va1->vn . '")
                GROUP BY v.vn
            ');
            // ,"2" HTYPE
            foreach ($data_ins_ as $va_01) {
                Fdh_ins::insert([
                    'HN'                => $va_01->HN,
                    'INSCL'             => $va_01->INSCL,
                    'SUBTYPE'           => $va_01->SUBTYPE,
                    'CID'               => $va_01->CID,
                    'HCODE'             => $va_01->HCODE,
                    'DATEEXP'           => $va_01->DATEEXP,
                    'HOSPMAIN'          => $va_01->HOSPMAIN,
                    'HOSPSUB'           => $va_01->HOSPSUB,
                    'GOVCODE'           => $va_01->GOVCODE,
                    'GOVNAME'           => $va_01->GOVNAME,
                    'PERMITNO'          => $va_01->PERMITNO,
                    'DOCNO'             => $va_01->DOCNO,
                    'OWNRPID'           => $va_01->OWNRPID,
                    'OWNNAME'           => $va_01->OWNNAME,
                    'AN'                => $va_01->AN,
                    'SEQ'               => $va_01->SEQ,
                    'SUBINSCL'          => $va_01->SUBINSCL,
                    'RELINSCL'          => $va_01->RELINSCL,
                    'HTYPE'             => $va_01->HTYPE,

                    'user_id'           => $iduser,
                    'd_anaconda_id'     => 'FDH'
                ]);
            }
            //D_pat OK
            $data_pat_ = DB::connection('mysql2')->select('
                SELECT v.hcode HCODE,v.hn HN
                ,pt.chwpart CHANGWAT,pt.amppart AMPHUR,DATE_FORMAT(pt.birthday,"%Y%m%d") DOB
                ,pt.sex SEX,pt.marrystatus MARRIAGE ,pt.occupation OCCUPA,lpad(pt.nationality,3,0) NATION,pt.cid PERSON_ID
                ,concat(pt.fname," ",pt.lname,",",pt.pname) NAMEPAT
                ,pt.pname TITLE,pt.fname FNAME,pt.lname LNAME,"1" IDTYPE
                FROM vn_stat v
                LEFT OUTER JOIN pttype p on p.pttype = v.pttype

                LEFT OUTER JOIN patient pt on pt.hn = v.hn
                WHERE v.vn IN("' . $va1->vn . '")
                GROUP BY v.hn,v.vn
            ');
            // LEFT OUTER JOIN ipt i on i.vn = v.vn
            foreach ($data_pat_ as $va_02) {
                $check_hn = Fdh_pat::where('hn', $va_02->HN)->where('d_anaconda_id', '=', 'FDH')->count();
                if ($check_hn > 0) {
                } else {
                    Fdh_pat::insert([
                        'HCODE'              => $va_02->HCODE,
                        'HN'                 => $va_02->HN,
                        'CHANGWAT'           => $va_02->CHANGWAT,
                        'AMPHUR'             => $va_02->AMPHUR,
                        'DOB'                => $va_02->DOB,
                        'SEX'                => $va_02->SEX,
                        'MARRIAGE'           => $va_02->MARRIAGE,
                        'OCCUPA'             => $va_02->OCCUPA,
                        'NATION'             => $va_02->NATION,
                        'PERSON_ID'          => $va_02->PERSON_ID,
                        'NAMEPAT'            => $va_02->NAMEPAT,
                        'TITLE'              => $va_02->TITLE,
                        'FNAME'              => $va_02->FNAME,
                        'LNAME'              => $va_02->LNAME,
                        'IDTYPE'             => $va_02->IDTYPE,

                        'user_id'            => $iduser,
                        'd_anaconda_id'      => 'FDH'
                    ]);
                }
            }
            //D_opd OK
            $data_opd = DB::connection('mysql2')->select('
                    SELECT  v.hn HN,v.spclty CLINIC,DATE_FORMAT(v.vstdate,"%Y%m%d") DATEOPD
                        ,concat(substr(o.vsttime,1,2),substr(o.vsttime,4,2)) TIMEOPD,v.vn SEQ
                        ,"1" UUC ,"" DETAIL,oc.temperature as BTEMP,oc.bps as SBP,oc.bpd as DBP,""PR,""RR
                        ,""OPTYPE
                        ,ot.export_code as TYPEIN,st.export_code as TYPEOUT
                        FROM ovst o
                        LEFT OUTER JOIN vn_stat v on o.vn = v.vn
                        LEFT OUTER JOIN opdscreen oc  on oc.vn = o.vn
                        LEFT OUTER JOIN pttype p on p.pttype = v.pttype
                        LEFT OUTER JOIN ipt i on i.vn = v.vn
                        LEFT OUTER JOIN patient pt on pt.hn = v.hn
                        LEFT OUTER JOIN ovstist ot on ot.ovstist = o.ovstist
                        LEFT OUTER JOIN ovstost st on st.ovstost = o.ovstost
                        WHERE o.vn IN("' . $va1->vn . '")
            ');
            foreach ($data_opd as $val3) {
                Fdh_opd::insert([
                    'HN'                => $val3->HN,
                    'CLINIC'            => $val3->CLINIC,
                    'DATEOPD'           => $val3->DATEOPD,
                    'TIMEOPD'           => $val3->TIMEOPD,
                    'SEQ'               => $val3->SEQ,
                    'UUC'               => $val3->UUC,
                    'DETAIL'            => $val3->DETAIL,
                    'BTEMP'             => $val3->BTEMP,
                    'SBP'               => $val3->SBP,
                    'DBP'               => $val3->DBP,
                    'PR'                => $val3->PR,
                    'RR'                => $val3->RR,
                    'OPTYPE'            => $val3->OPTYPE,
                    'TYPEIN'            => $val3->TYPEIN,
                    'TYPEOUT'           => $val3->TYPEOUT,
                    'user_id'           => $iduser,
                    'd_anaconda_id'     => 'FDH'
                ]);
            }

            //D_orf _OK
            $data_orf_ = DB::connection('mysql2')->select('
                    SELECT v.hn HN
                    ,DATE_FORMAT(v.vstdate,"%Y%m%d") DATEOPD,v.spclty CLINIC,ifnull(r1.refer_hospcode,r2.refer_hospcode) REFER
                    ,"0100" REFERTYPE,v.vn SEQ
                    ,ifnull(DATE_FORMAT(r1.refer_date,"%Y%m%d"),DATE_FORMAT(r2.refer_date,"%Y%m%d")) as REFERDATE
                    FROM vn_stat v
                    LEFT OUTER JOIN ovst o on o.vn = v.vn
                    LEFT OUTER JOIN referin r1 on r1.vn = v.vn
                    LEFT OUTER JOIN referout r2 on r2.vn = v.vn
                    WHERE v.vn IN("' . $va1->vn . '")
                    AND (r1.vn is not null or r2.vn is not null);
            ');
            // ,if(r1.refer_date ="",DATE_FORMAT(r2.refer_date,"%Y%m%d"),DATE_FORMAT(r1.refer_date,"%Y%m%d")) as REFERDATE
            // ,r1.refer_date as REFERDATE
            foreach ($data_orf_ as $va_03) {
                Fdh_orf::insert([
                    'HN'                => $va_03->HN,
                    'DATEOPD'           => $va_03->DATEOPD,
                    'CLINIC'            => $va_03->CLINIC,
                    'REFER'             => $va_03->REFER,
                    'REFERTYPE'         => $va_03->REFERTYPE,
                    'SEQ'               => $va_03->SEQ,
                    'REFERDATE'         => $va_03->REFERDATE,
                    'user_id'           => $iduser,
                    'd_anaconda_id'     => 'FDH'
                ]);
            }
            // D_odx OK
            $data_odx_ = DB::connection('mysql2')->select('
                    SELECT v.hn as HN,DATE_FORMAT(v.vstdate,"%Y%m%d") as DATEDX,v.spclty as CLINIC,o.icd10 as DIAG,o.diagtype as DXTYPE
                    ,if(d.licenseno="","-99999",d.licenseno) as DRDX,v.cid as PERSON_ID ,v.vn as SEQ
                    FROM vn_stat v
                    LEFT OUTER JOIN ovstdiag o on o.vn = v.vn
                    LEFT OUTER JOIN doctor d on d.`code` = o.doctor
                    INNER JOIN icd101 i on i.code = o.icd10
                    WHERE v.vn IN("' . $va1->vn . '")
            ');

            foreach ($data_odx_ as $va_04) {
                Fdh_odx::insert([
                    'HN'                => $va_04->HN,
                    'DATEDX'            => $va_04->DATEDX,
                    'CLINIC'            => $va_04->CLINIC,
                    'DIAG'              => $va_04->DIAG,
                    'DXTYPE'            => $va_04->DXTYPE,
                    'DRDX'              => $va_04->DRDX,
                    'PERSON_ID'         => $va_04->PERSON_ID,
                    'SEQ'               => $va_04->SEQ,
                    'user_id'           => $iduser,
                    'd_anaconda_id'     => 'FDH'
                ]);
            }
            //D_oop OK
            $data_oop_ = DB::connection('mysql2')->select('
                    SELECT v.hn as HN,DATE_FORMAT(v.vstdate,"%Y%m%d") as DATEOPD,v.spclty as CLINIC,o.icd10 as OPER
                    ,if(d.licenseno="","-99999",d.licenseno) as DROPID,pt.cid as PERSON_ID ,v.vn as SEQ ,""SERVPRICE
                    FROM vn_stat v
                    LEFT OUTER JOIN ovstdiag o on o.vn = v.vn
                    LEFT OUTER JOIN patient pt on v.hn=pt.hn
                    LEFT OUTER JOIN doctor d on d.`code` = o.doctor
                    INNER JOIN icd9cm1 i on i.code = o.icd10
                    WHERE v.vn IN("' . $va1->vn . '")
                    AND substring(o.icd10,1,1) in ("0","1","2","3","4","5","6","7","8","9")
            ');
            foreach ($data_oop_ as $va_05) {
                Fdh_oop::insert([
                    'HN'                => $va_05->HN,
                    'DATEOPD'           => $va_05->DATEOPD,
                    'CLINIC'            => $va_05->CLINIC,
                    'OPER'              => $va_05->OPER,
                    'DROPID'            => $va_05->DROPID,
                    'PERSON_ID'         => $va_05->PERSON_ID,
                    'SEQ'               => $va_05->SEQ,
                    'SERVPRICE'         => $va_05->SERVPRICE,
                    'user_id'           => $iduser,
                    'd_anaconda_id'     => 'FDH'
                ]);
            }
            //D_ipd OK
            $data_ipd_ = DB::connection('mysql2')->select('
                    SELECT a.hn HN,a.an AN,DATE_FORMAT(i.regdate,"%Y%m%d") DATEADM,Time_format(i.regtime,"%H%i") TIMEADM
                    ,DATE_FORMAT(i.dchdate,"%Y%m%d") DATEDSC,Time_format(i.dchtime,"%H%i")  TIMEDSC,right(i.dchstts,1) DISCHS
                    ,right(i.dchtype,1) DISCHT,i.ward WARDDSC,i.spclty DEPT,format(i.bw/1000,3) ADM_W,"1" UUC ,"I" SVCTYPE
                    FROM an_stat a
                    LEFT OUTER JOIN ipt i on i.an = a.an
                    LEFT OUTER JOIN pttype p on p.pttype = a.pttype
                    LEFT OUTER JOIN patient pt on pt.hn = a.hn
                    WHERE i.vn IN("' . $va1->vn . '")
            ');
            foreach ($data_ipd_ as $va_06) {
                Fdh_ipd::insert([
                    'HN'                => $va_06->HN,
                    'AN'                => $va_06->AN,
                    'DATEADM'           => $va_06->DATEADM,
                    'TIMEADM'           => $va_06->TIMEADM,
                    'DATEDSC'           => $va_06->DATEDSC,
                    'TIMEDSC'           => $va_06->TIMEDSC,
                    'DISCHS'            => $va_06->DISCHS,
                    'DISCHT'            => $va_06->DISCHT,
                    'WARDDSC'           => $va_06->WARDDSC,
                    'DEPT'              => $va_06->DEPT,
                    'ADM_W'             => $va_06->ADM_W,
                    'UUC'               => $va_06->UUC,
                    'SVCTYPE'           => $va_06->SVCTYPE,
                    'user_id'           => $iduser,
                    'd_anaconda_id'     => 'FDH'
                ]);
            }

            //D_irf OK
            $data_irf_ = DB::connection('mysql2')->select('
                    SELECT a.an AN,ifnull(o.refer_hospcode,oo.refer_hospcode) REFER,"0100" REFERTYPE
                    FROM an_stat a
                    LEFT OUTER JOIN ipt ip on ip.an = a.an
                    LEFT OUTER JOIN referout o on o.vn = a.an
                    LEFT OUTER JOIN referin oo on oo.vn = a.an
                    WHERE ip.vn IN("' . $va1->vn . '")
                    AND (a.an in(SELECT vn FROM referin WHERE vn = oo.vn) or a.an in(SELECT vn FROM referout WHERE vn = o.vn));
            ');
            foreach ($data_irf_ as $va_07) {
                Fdh_irf::insert([
                    'AN'                 => $va_07->AN,
                    'REFER'              => $va_07->REFER,
                    'REFERTYPE'          => $va_07->REFERTYPE,
                    'user_id'            => $iduser,
                    'd_anaconda_id'      => 'FDH',
                ]);
            }
            //D_idx OK
            $data_idx_ = DB::connection('mysql2')->select('
                    SELECT v.an AN,o.icd10 DIAG,o.diagtype DXTYPE,if(d.licenseno="","-99999",d.licenseno) DRDX
                    FROM an_stat v
                    LEFT OUTER JOIN iptdiag o on o.an = v.an
                    LEFT OUTER JOIN doctor d on d.`code` = o.doctor
                    LEFT OUTER JOIN ipt ip on ip.an = v.an
                    INNER JOIN icd101 i on i.code = o.icd10
                    WHERE ip.vn IN("' . $va1->vn . '")
            ');
            foreach ($data_idx_ as $va_08) {
                Fdh_idx::insert([
                    'AN'                => $va_08->AN,
                    'DIAG'              => $va_08->DIAG,
                    'DXTYPE'            => $va_08->DXTYPE,
                    'DRDX'              => $va_08->DRDX,
                    'user_id'           => $iduser,
                    'd_anaconda_id'     => 'FDH'
                ]);
            }
            //D_iop OK
            $data_iop_ = DB::connection('mysql2')->select('
                    SELECT a.an AN,o.icd9 OPER,o.oper_type as OPTYPE,if(d.licenseno="","-99999",d.licenseno) DROPID,DATE_FORMAT(o.opdate,"%Y%m%d") DATEIN,Time_format(o.optime,"%H%i") TIMEIN
                    ,DATE_FORMAT(o.enddate,"%Y%m%d") DATEOUT,Time_format(o.endtime,"%H%i") TIMEOUT
                    FROM an_stat a
                    LEFT OUTER JOIN iptoprt o on o.an = a.an
                    LEFT OUTER JOIN doctor d on d.`code` = o.doctor
                    INNER JOIN icd9cm1 i on i.code = o.icd9
                    LEFT OUTER JOIN ipt ip on ip.an = a.an
                    WHERE ip.vn IN("' . $va1->vn . '")
            ');
            foreach ($data_iop_ as $va_09) {
                Fdh_iop::insert([
                    'AN'                => $va_09->AN,
                    'OPER'              => $va_09->OPER,
                    'OPTYPE'            => $va_09->OPTYPE,
                    'DROPID'            => $va_09->DROPID,
                    'DATEIN'            => $va_09->DATEIN,
                    'TIMEIN'            => $va_09->TIMEIN,
                    'DATEOUT'           => $va_09->DATEOUT,
                    'TIMEOUT'           => $va_09->TIMEOUT,
                    'user_id'           => $iduser,
                    'd_anaconda_id'     => 'FDH'
                ]);
            }
            //D_cht OK
            $data_cht_ = DB::connection('mysql2')->select('
                SELECT o.hn HN,o.an AN,DATE_FORMAT(if(a.an is null,o.vstdate,a.dchdate),"%Y%m%d") DATE,round(if(a.an is null,vv.income,a.income),2) TOTAL,""OPD_MEMO,""INVOICE_NO,""INVOICE_LT
                ,round(if(a.an is null,vv.paid_money,a.paid_money),2) PAID,if(vv.paid_money >"0" or a.paid_money >"0","10",pt.pcode) PTTYPE,pp.cid PERSON_ID ,o.vn SEQ
                FROM ovst o
                LEFT OUTER JOIN vn_stat vv on vv.vn = o.vn
                LEFT OUTER JOIN an_stat a on a.an = o.an
                LEFT OUTER JOIN patient pp on pp.hn = o.hn
                LEFT OUTER JOIN pttype pt on pt.pttype = vv.pttype or pt.pttype=a.pttype
                LEFT OUTER JOIN pttype p on p.pttype = a.pttype
                WHERE o.vn IN("' . $va1->vn . '")

            ');
            foreach ($data_cht_ as $va_10) {
                Fdh_cht::insert([
                    'HN'                => $va_10->HN,
                    'AN'                => $va_10->AN,
                    'DATE'              => $va_10->DATE,
                    'TOTAL'             => $va_10->TOTAL,
                    'PAID'              => $va_10->PAID,
                    'PTTYPE'            => $va_10->PTTYPE,
                    'PERSON_ID'         => $va_10->PERSON_ID,
                    'SEQ'               => $va_10->SEQ,
                    'OPD_MEMO'          => $va_10->OPD_MEMO,
                    'INVOICE_NO'        => $va_10->INVOICE_NO,
                    'INVOICE_LT'        => $va_10->INVOICE_LT,
                    'user_id'           => $iduser,
                    'd_anaconda_id'     => 'FDH'
                ]);
            }
            //D_cha OK
            $data_cha_ = DB::connection('mysql2')->select('
                    SELECT v.hn HN,if(v1.an is null,"",v1.an) AN ,if(v1.an is null,DATE_FORMAT(v.vstdate,"%Y%m%d"),DATE_FORMAT(v1.dchdate,"%Y%m%d")) DATE
                    ,if(v.paidst in("01","03"),dx.chrgitem_code2,dc.chrgitem_code1) CHRGITEM,round(sum(v.sum_price),2) AMOUNT,p.cid PERSON_ID ,ifnull(v.vn,v.an) SEQ
                    FROM opitemrece v
                    LEFT OUTER JOIN vn_stat vv on vv.vn = v.vn
                    LEFT OUTER JOIN patient p on p.hn = v.hn
                    LEFT OUTER JOIN ipt v1 on v1.an = v.an
                    LEFT OUTER JOIN income i on v.income=i.income
                    LEFT OUTER JOIN drg_chrgitem dc on i.drg_chrgitem_id=dc.drg_chrgitem_id
                    LEFT OUTER JOIN drg_chrgitem dx on i.drg_chrgitem_id= dx.drg_chrgitem_id
                    WHERE v.vn IN("' . $va1->vn . '")
                    GROUP BY v.vn,CHRGITEM

                    UNION ALL

                    SELECT v.hn HN,ip.an AN ,if(ip.an is null,DATE_FORMAT(v.vstdate,"%Y%m%d"),DATE_FORMAT(ip.dchdate,"%Y%m%d")) DATE
                    ,if(v.paidst in("01","03"),dx.chrgitem_code2,dc.chrgitem_code1) CHRGITEM,round(sum(v.sum_price),2) AMOUNT,p.cid PERSON_ID ,ifnull(v.vn,v.an) SEQ
                    FROM opitemrece v
                    LEFT OUTER JOIN vn_stat vv on vv.vn = v.vn
                    LEFT OUTER JOIN patient p on p.hn = v.hn
                    LEFT OUTER JOIN ipt ip on ip.an = v.an
                    LEFT OUTER JOIN income i on v.income=i.income
                    LEFT OUTER JOIN drg_chrgitem dc on i.drg_chrgitem_id=dc.drg_chrgitem_id
                    LEFT OUTER JOIN drg_chrgitem dx on i.drg_chrgitem_id= dx.drg_chrgitem_id
                    WHERE ip.vn IN("' . $va1->vn . '")
                    GROUP BY v.an,CHRGITEM;
            ');
            foreach ($data_cha_ as $va_11) {
                Fdh_cha::insert([
                    'HN'                => $va_11->HN,
                    'AN'                => $va_11->AN,
                    'DATE'              => $va_11->DATE,
                    'CHRGITEM'          => $va_11->CHRGITEM,
                    'AMOUNT'            => $va_11->AMOUNT,
                    'PERSON_ID'         => $va_11->PERSON_ID,
                    'SEQ'               => $va_11->SEQ,
                    'user_id'           => $iduser,
                    'd_anaconda_id'     => 'FDH'
                ]);
            }
            //D_aer OK
            $data_aer_ = DB::connection('mysql2')->select('
                    SELECT v.hn HN ,i.an AN ,DATE_FORMAT(v.vstdate,"%Y%m%d") DATEOPD
                    ,c.claimcode AUTHAE
                    ,"" AEDATE,"" AETIME,"" AETYPE,"" REFER_NO,"" REFMAINI ,"" IREFTYPE,"" REFMAINO,"" OREFTYPE,"" UCAE,"" EMTYPE,v.vn SEQ ,"" AESTATUS,"" DALERT,"" TALERT
                    FROM vn_stat v
                    LEFT OUTER JOIN ipt i on i.vn = v.vn
                    LEFT OUTER JOIN ovst o on o.vn = v.vn
                    LEFT OUTER JOIN visit_pttype vv on vv.vn = v.vn
                    LEFT OUTER JOIN pttype pt on pt.pttype =v.pttype
                    LEFT OUTER JOIN pkbackoffice.check_authen c On c.cid = v.cid AND c.vstdate = v.vstdate
                    WHERE v.vn IN("' . $va1->vn . '") and i.an is null
                    AND i.an is null
                    GROUP BY v.vn
                     UNION ALL
                    SELECT a.hn HN,a.an AN,DATE_FORMAT(vs.vstdate,"%Y%m%d") DATEOPD,c.claimcode AUTHAE
                    ,"" AEDATE,"" AETIME,"" AETYPE,"" REFER_NO,"" REFMAINI ,"" IREFTYPE,"" REFMAINO,"" OREFTYPE,"" UCAE,"" EMTYPE,"" SEQ ,"" AESTATUS,"" DALERT,"" TALERT
                    FROM an_stat a
                    LEFT OUTER JOIN ipt_pttype vv on vv.an = a.an
                    LEFT OUTER JOIN pttype pt on pt.pttype =a.pttype
                    LEFT OUTER JOIN vn_stat vs on vs.vn =a.vn
                    LEFT OUTER JOIN pkbackoffice.check_authen c On c.cid = vs.cid AND c.vstdate = vs.vstdate
                    WHERE a.vn IN("' . $va1->vn . '")
                    GROUP BY a.an;
            ');
            foreach ($data_aer_ as $va_12) {
                Fdh_aer::insert([
                    'HN'                => $va_12->HN,
                    'AN'                => $va_12->AN,
                    'DATEOPD'           => $va_12->DATEOPD,
                    'AUTHAE'            => $va_12->AUTHAE,
                    'AEDATE'            => $va_12->AEDATE,
                    'AETIME'            => $va_12->AETIME,
                    'AETYPE'            => $va_12->AETYPE,
                    'REFER_NO'          => $va_12->REFER_NO,
                    'REFMAINI'          => $va_12->REFMAINI,
                    'IREFTYPE'          => $va_12->IREFTYPE,
                    'REFMAINO'          => $va_12->REFMAINO,
                    'OREFTYPE'          => $va_12->OREFTYPE,
                    'UCAE'              => $va_12->UCAE,
                    'EMTYPE'            => $va_12->EMTYPE,
                    'SEQ'               => $va_12->SEQ,
                    'AESTATUS'          => $va_12->AESTATUS,
                    'DALERT'            => $va_12->DALERT,
                    'TALERT'            => $va_12->TALERT,
                    'user_id'           => $iduser,
                    'd_anaconda_id'     => 'FDH'
                ]);
            }
            $data_adp_ = DB::connection('mysql2')->select('
                        SELECT HN,AN,DATEOPD,TYPE,CODE,sum(QTY) QTY,RATE,SEQ,"" CAGCODE,"" DOSE,"" CA_TYPE,""SERIALNO,"0" TOTCOPAY,""USE_STATUS,"0" TOTAL,""QTYDAY
                        ,"" TMLTCODE ,"" STATUS1 ,"" BI ,"" CLINIC ,ITEMSRC ,"" PROVIDER,"" GRAVIDA ,"" GA_WEEK ,"" DCIP ,"" LMP ,""SP_ITEM,icode ,vstdate
                        FROM
                        (SELECT v.hn HN,if(v.an is null,"",v.an) AN,DATE_FORMAT(v.rxdate,"%Y%m%d") DATEOPD,n.nhso_adp_type_id TYPE,n.nhso_adp_code CODE ,sum(v.QTY) QTY,round(v.unitprice,2) RATE,if(v.an is null,v.vn,"") SEQ
                        ,"" CAGCODE,"" DOSE,"" CA_TYPE,""SERIALNO,"0" TOTCOPAY,""USE_STATUS,"0" TOTAL,""QTYDAY
                        ,"" TMLTCODE ,"" STATUS1 ,"" BI ,"" CLINIC ,if(n.nhso_adp_code is null,"1","2") as ITEMSRC
                        ,"" PROVIDER ,"" GRAVIDA ,"" GA_WEEK ,"" DCIP ,"" LMP ,""SP_ITEM,v.icode,v.vstdate
                        FROM opitemrece v
                        JOIN nondrugitems n on n.icode = v.icode
                        LEFT OUTER JOIN ipt i on i.an = v.an
                        AND i.an is not NULL
                        WHERE i.vn IN("' . $va1->vn . '")
                        GROUP BY i.vn,n.nhso_adp_code,rate) a
                        GROUP BY an,CODE,rate
                        UNION
                        SELECT HN,AN,DATEOPD,TYPE,CODE,sum(QTY) QTY,RATE,SEQ,"" CAGCODE,"" DOSE,"" CA_TYPE,""SERIALNO,"0" TOTCOPAY,""USE_STATUS,"0" TOTAL,""QTYDAY
                        ,"" TMLTCODE ,"" STATUS1 ,"" BI ,"" CLINIC ,ITEMSRC ,"" PROVIDER,"" GRAVIDA ,"" GA_WEEK ,"" DCIP ,"" LMP ,""SP_ITEM,icode ,vstdate
                        FROM
                        (SELECT v.hn HN,if(v.an is null,"",v.an) AN,DATE_FORMAT(v.vstdate,"%Y%m%d") DATEOPD,n.nhso_adp_type_id TYPE,n.nhso_adp_code CODE ,sum(v.QTY) QTY,round(v.unitprice,2) RATE,if(v.an is null,v.vn,"") SEQ
                        ,"" CAGCODE,"" DOSE,"" CA_TYPE,""SERIALNO,"0" TOTCOPAY,""USE_STATUS,"0" TOTAL,""QTYDAY,"" TMLTCODE ,"" STATUS1 ,"" BI ,"" CLINIC ,if(n.nhso_adp_code is null,"1","2") as ITEMSRC ,"" PROVIDER,"" GRAVIDA ,"" GA_WEEK ,"" DCIP ,"" LMP ,""SP_ITEM,v.icode,v.vstdate
                        FROM opitemrece v
                        JOIN nondrugitems n on n.icode = v.icode
                        LEFT OUTER JOIN vn_stat vv on vv.vn = v.vn
                        WHERE vv.vn IN("' . $va1->vn . '")
                        AND v.an is NULL
                        GROUP BY vv.vn,n.nhso_adp_code,rate) b
                        GROUP BY seq,CODE,rate;
            ');
            foreach ($data_adp_ as $va_13) {
                Fdh_adp::insert([
                    'HN'                   => $va_13->HN,
                    'AN'                   => $va_13->AN,
                    'DATEOPD'              => $va_13->DATEOPD,
                    'TYPE'                 => $va_13->TYPE,
                    'CODE'                 => $va_13->CODE,
                    'QTY'                  => $va_13->QTY,
                    'RATE'                 => $va_13->RATE,
                    'SEQ'                  => $va_13->SEQ,
                    'CAGCODE'              => $va_13->CAGCODE,
                    'DOSE'                 => $va_13->DOSE,
                    'CA_TYPE'              => $va_13->CA_TYPE,
                    'SERIALNO'             => $va_13->SERIALNO,
                    'TOTCOPAY'             => $va_13->TOTCOPAY,
                    'USE_STATUS'           => $va_13->USE_STATUS,
                    'TOTAL'                => $va_13->TOTAL,
                    'QTYDAY'               => $va_13->QTYDAY,
                    'TMLTCODE'             => $va_13->TMLTCODE,
                    'STATUS1'              => $va_13->STATUS1,
                    'BI'                   => $va_13->BI,
                    'CLINIC'               => $va_13->CLINIC,
                    'ITEMSRC'              => $va_13->ITEMSRC,
                    'PROVIDER'             => $va_13->PROVIDER,
                    'GRAVIDA'              => $va_13->GRAVIDA,
                    'GA_WEEK'              => $va_13->GA_WEEK,
                    'DCIP'                 => $va_13->DCIP,
                    'LMP'                  => $va_13->LMP,
                    'SP_ITEM'              => $va_13->SP_ITEM,
                    'icode'                => $va_13->icode,
                    'vstdate'              => $va_13->vstdate,
                    'user_id'              => $iduser,
                    'd_anaconda_id'        => 'FDH'
                ]);
            }
            //D_dru OK
            $data_dru_ = DB::connection('mysql2')->select('
                SELECT vv.hcode HCODE ,v.hn HN ,v.an AN ,vv.spclty CLINIC ,vv.cid PERSON_ID ,DATE_FORMAT(v.vstdate,"%Y%m%d") DATE_SERV
                ,d.icode DID ,concat(d.`name`," ",d.strength," ",d.units) DIDNAME ,v.qty AMOUNT ,round(v.unitprice,2) DRUGPRICE
                ,"0.00" DRUGCOST ,d.did DIDSTD ,d.units UNIT ,concat(d.packqty,"x",d.units) UNIT_PACK ,v.vn SEQ
                ,oo.presc_reason DRUGREMARK ,"" PA_NO ,"" TOTCOPAY ,if(v.item_type="H","2","1") USE_STATUS
                ,"" TOTAL ,"" as SIGCODE ,"" as SIGTEXT ,"" PROVIDER,v.vstdate
                FROM opitemrece v
                LEFT OUTER JOIN drugitems d on d.icode = v.icode
                LEFT OUTER JOIN vn_stat vv on vv.vn = v.vn
                LEFT OUTER JOIN ovst_presc_ned oo on oo.vn = v.vn and oo.icode=v.icode
                LEFT OUTER JOIN drugitems_ned_reason dn on dn.icode = v.icode
                WHERE v.vn IN("' . $va1->vn . '")
                AND d.did is not null
                GROUP BY v.vn,did

                UNION all

                SELECT pt.hcode HCODE ,v.hn HN ,v.an AN ,v1.spclty CLINIC ,pt.cid PERSON_ID ,DATE_FORMAT((v.vstdate),"%Y%m%d") DATE_SERV
                ,d.icode DID ,concat(d.`name`," ",d.strength," ",d.units) DIDNAME ,sum(v.qty) AMOUNT ,round(v.unitprice,2) DRUGPRICE
                ,"0.00" DRUGCOST ,d.did DIDSTD ,d.units UNIT ,concat(d.packqty,"x",d.units) UNIT_PACK ,v.vn SEQ
                ,oo.presc_reason DRUGREMARK ,"" PA_NO ,"" TOTCOPAY ,if(v.item_type="H","2","1") USE_STATUS
                ,"" TOTAL,"" as SIGCODE,"" as SIGTEXT,""  PROVIDER,v.vstdate
                FROM opitemrece v
                LEFT OUTER JOIN drugitems d on d.icode = v.icode
                LEFT OUTER JOIN patient pt  on v.hn = pt.hn
                INNER JOIN ipt v1 on v1.an = v.an
                LEFT OUTER JOIN ovst_presc_ned oo on oo.vn = v.vn and oo.icode=v.icode
                LEFT OUTER JOIN drugitems_ned_reason dn on dn.icode = v.icode
                WHERE v1.vn IN("' . $va1->vn . '")
                AND d.did is not null AND v.qty<>"0"
                GROUP BY v.an,d.icode,USE_STATUS;
            ');

            foreach ($data_dru_ as $va_14) {
                Fdh_dru::insert([
                    'HCODE'          => $va_14->HCODE,
                    'HN'             => $va_14->HN,
                    'AN'             => $va_14->AN,
                    'CLINIC'         => $va_14->CLINIC,
                    'PERSON_ID'      => $va_14->PERSON_ID,
                    'DATE_SERV'      => $va_14->DATE_SERV,
                    'DID'            => $va_14->DID,
                    'DIDNAME'        => $va_14->DIDNAME,
                    'AMOUNT'         => $va_14->AMOUNT,
                    'DRUGPRICE'      => $va_14->DRUGPRICE,
                    'DRUGCOST'       => $va_14->DRUGCOST,
                    'DIDSTD'         => $va_14->DIDSTD,
                    'UNIT'           => $va_14->UNIT,
                    'UNIT_PACK'      => $va_14->UNIT_PACK,
                    'SEQ'            => $va_14->SEQ,
                    'DRUGREMARK'     => $va_14->DRUGREMARK,
                    'PA_NO'          => $va_14->PA_NO,
                    'TOTCOPAY'       => $va_14->TOTCOPAY,
                    'USE_STATUS'     => $va_14->USE_STATUS,
                    'TOTAL'          => $va_14->TOTAL,
                    'SIGCODE'        => $va_14->SIGCODE,
                    'SIGTEXT'        => $va_14->SIGTEXT,
                    'PROVIDER'       => $va_14->PROVIDER,
                    'vstdate'        => $va_14->vstdate,
                    'user_id'        => $iduser,
                    'd_anaconda_id'  => 'FDH'
                ]);
            }
        }

        D_fdh::whereIn('d_fdh_id', explode(",", $id))
            ->update([
                'active' => 'Y'
            ]);
        Fdh_adp::where('CODE', '=', 'XXXXXX')->delete();
        Fdh_dru::where('HCODE', NULL)->where('d_anaconda_id', '=', 'FDH')->delete();
        return response()->json([
            'status'    => '200'
        ]);
    }

    public function fdh_data_export(Request $request)
    {
        $sss_date_now = date("Y-m-d");
        $sss_time_now = date("H:i:s");

        #ตัดขีด, ตัด : ออก
        $pattern_date = '/-/i';
        $sss_date_now_preg = preg_replace($pattern_date, '', $sss_date_now);
        $pattern_time = '/:/i';
        $sss_time_now_preg = preg_replace($pattern_time, '', $sss_time_now);
        #ตัดขีด, ตัด : ออก

        #delete file in folder ทั้งหมด
        $file = new Filesystem;
        $file->cleanDirectory('Export'); //ทั้งหมด
        // $file->cleanDirectory('UCEP_'.$sss_date_now_preg.'-'.$sss_time_now_preg);
        $folder = 'FDH_' . $sss_date_now_preg . '-' . $sss_time_now_preg;

        mkdir('Export/' . $folder, 0777, true);  //Web
        //  mkdir ('C:Export/'.$folder, 0777, true); //localhost

        header("Content-type: text/txt");
        header("Cache-Control: no-store, no-cache");
        header('Content-Disposition: attachment; filename="content.txt"; charset=tis-620″ ;');

        //1 ins.txt
        $file_d_ins = "Export/" . $folder . "/INS.txt";
        $objFopen_ins = fopen($file_d_ins, 'w');
        // $opd_head = 'HN|INSCL|SUBTYPE|CID|DATEIN|DATEEXP|HOSPMAIN|HOSPSUB|GOVCODE|GOVNAME|PERMITNO|DOCNO|OWNRPID|OWNNAME|AN|SEQ|SUBINSCL|RELINSCL|HTYPE';
        // $opd_head = 'HN|INSCL|SUBTYPE|CID|HCODE|DATEIN|DATEEXP|HOSPMAIN|HOSPSUB|GOVCODE|GOVNAME|PERMITNO|DOCNO|OWNRPID|OWNNAME|AN|SEQ|SUBINSCL|RELINSCL|HTYPE';
        $opd_head = 'HN|INSCL|SUBTYPE|CID|HCODE|DATEEXP|HOSPMAIN|HOSPSUB|GOVCODE|GOVNAME|PERMITNO|DOCNO|OWNRPID|OWNNAME|AN|SEQ|SUBINSCL|RELINSCL|HTYPE';
        // $opd_head = 'HN|INSCL|SUBTYPE|CID|DATEIN|DATEEXP|HOSPMAIN|HOSPSUB|GOVCODE|GOVNAME|PERMITNO|DOCNO|OWNRPID|OWNNAME|AN|SEQ|SUBINSCL|RELINSCL|HTYPE';
        // $opd_head = 'HN|INSCL|SUBTYPE|CID|DATEIN|DATEEXP|HOSPMAIN|HOSPSUB|GOVCODE|GOVNAME|PERMITNO|DOCNO|OWNRPID|OWNNAME|AN|SEQ|SUBINSCL|RELINSCL|HTYPE';
        fwrite($objFopen_ins, $opd_head);
        $ins = DB::connection('mysql')->select('SELECT * from fdh_ins where d_anaconda_id = "FDH"');
        foreach ($ins as $key => $value1) {
            $a1  = $value1->HN;
            $a2  = $value1->INSCL;
            $a3  = $value1->SUBTYPE;
            $a4  = $value1->CID;
            $a5  = $value1->HCODE;
            // $a6  = $value1->DATEIN;
            $a7  = $value1->DATEEXP;
            $a8  = $value1->HOSPMAIN;
            $a9  = $value1->HOSPSUB;
            $a10  = $value1->GOVCODE;
            $a11 = $value1->GOVNAME;
            $a12 = $value1->PERMITNO;
            $a13 = $value1->DOCNO;
            $a14 = $value1->OWNRPID;
            $a15 = $value1->OWNNAME;
            $a16 = $value1->AN;
            $a17 = $value1->SEQ;
            $a18 = $value1->SUBINSCL;
            $a19 = $value1->RELINSCL;
            $a20 = $value1->HTYPE;
            // $str_ins="\n".$a1."|".$a2."|".$a3."|".$a4."|".$a5."|".$a6."|".$a7."|".$a8."|".$a9."|".$a10."|".$a11."|".$a12."|".$a13."|".$a14."|".$a15."|".$a16."|".$a17."|".$a18."|".$a19."|".$a20;
            // $str_ins="\n".$a1."|".$a2."|".$a3."|".$a4."|".$a6."|".$a7."|".$a8."|".$a9."|".$a10."|".$a11."|".$a12."|".$a13."|".$a14."|".$a15."|".$a16."|".$a17."|".$a18."|".$a19."|".$a20;
            $str_ins = "\n" . $a1 . "|" . $a2 . "|" . $a3 . "|" . $a4 . "|" . $a5 . "|" . $a7 . "|" . $a8 . "|" . $a9 . "|" . $a10 . "|" . $a11 . "|" . $a12 . "|" . $a13 . "|" . $a14 . "|" . $a15 . "|" . $a16 . "|" . $a17 . "|" . $a18 . "|" . $a19 . "|" . $a20;

            $str_ins_10 = preg_replace("/\n/", "\r\n", $str_ins);
            $str_ins_11 = mb_convert_encoding($str_ins_10, 'UTF-8');
            fwrite($objFopen_ins, $str_ins_11);
        }
        fclose($objFopen_ins);

        //2 pat.txt
        $file_d_pat = "Export/" . $folder . "/PAT.txt";
        $objFopen_pat = fopen($file_d_pat, 'w');
        // $opd_head_pat = 'HCODE|HN|CHANGWAT|AMPHUR|DOB|SEX|MARRIAGE|OCCUPA|NATION|PERSON_ID|NAMEPAT|TITLE|FNAME|LNAME|IDTYPE';
        $opd_head_pat = 'HCODE|HN|CHANGWAT|AMPHUR|DOB|SEX|MARRIAGE|OCCUPA|NATION|PERSON_ID|NAMEPAT|TITLE|FNAME|LNAME|IDTYPE';
        fwrite($objFopen_pat, $opd_head_pat);
        $pat = DB::connection('mysql')->select('SELECT * from fdh_pat where d_anaconda_id = "FDH"');
        foreach ($pat as $key => $value2) {
            $i1  = $value2->HCODE;
            $i2  = $value2->HN;
            $i3  = $value2->CHANGWAT;
            $i4  = $value2->AMPHUR;
            $i5  = $value2->DOB;
            $i6  = $value2->SEX;
            $i7  = $value2->MARRIAGE;
            $i8  = $value2->OCCUPA;
            $i9  = $value2->NATION;
            $i10 = $value2->PERSON_ID;
            $i11 = $value2->NAMEPAT;
            $i12 = $value2->TITLE;
            $i13 = $value2->FNAME;
            $i14 = $value2->LNAME;
            $i15 = $value2->IDTYPE;
            $str_pat = "\n" . $i1 . "|" . $i2 . "|" . $i3 . "|" . $i4 . "|" . $i5 . "|" . $i6 . "|" . $i7 . "|" . $i8 . "|" . $i9 . "|" . $i10 . "|" . $i11 . "|" . $i12 . "|" . $i13 . "|" . $i14 . "|" . $i15;
            $str_pat_20 = preg_replace("/\n/", "\r\n", $str_pat);
            $str_pat_21 = mb_convert_encoding($str_pat_20, 'UTF-8');
            fwrite($objFopen_pat, $str_pat_21);
        }
        fclose($objFopen_pat);


        //3 opd.txt
        $file_d_opd = "Export/" . $folder . "/OPD.txt";
        $objFopen_opd = fopen($file_d_opd, 'w');

        // $opd_head_opd = 'HN|CLINIC|DATEOPD|TIMEOPD|SEQ|UUC';
        $opd_head_opd = 'HN|CLINIC|DATEOPD|TIMEOPD|SEQ|UUC|DETAIL|BTEMP|SBP|DBP|PR|RR|OPTYPE|TYPEIN|TYPEOUT';
        fwrite($objFopen_opd, $opd_head_opd);
        $opd = DB::connection('mysql')->select('SELECT * from fdh_opd where d_anaconda_id = "FDH"');
        foreach ($opd as $key => $value3) {
            $o1 = $value3->HN;
            $o2 = $value3->CLINIC;
            $o3 = $value3->DATEOPD;
            $o4 = $value3->TIMEOPD;
            $o5 = $value3->SEQ;
            $o6 = $value3->UUC;
            $o7 = $value3->DETAIL;
            $o8 = $value3->BTEMP;
            $o9 = $value3->SBP;
            $o10 = $value3->DBP;
            $o11 = $value3->PR;
            $o12 = $value3->RR;
            $o13 = $value3->OPTYPE;
            $o14 = $value3->TYPEIN;
            $o15 = $value3->TYPEOUT;
            // $str_opd="\n".$o1."|".$o2."|".$o3."|".$o4."|".$o5."|".$o6;
            $str_opd = "\n" . $o1 . "|" . $o2 . "|" . $o3 . "|" . $o4 . "|" . $o5 . "|" . $o6 . "|" . $o7 . "|" . $o8 . "|" . $o9 . "|" . $o10 . "|" . $o11 . "|" . $o12 . "|" . $o13 . "|" . $o14 . "|" . $o15;
            $str_opd_30 = preg_replace("/\n/", "\r\n", $str_opd);
            $str_opd_31 = mb_convert_encoding($str_opd_30, 'UTF-8');
            fwrite($objFopen_opd, $str_opd_31);
        }
        fclose($objFopen_opd);


        //4 orf.txt
        $file_d_orf = "Export/" . $folder . "/ORF.txt";
        $objFopen_orf = fopen($file_d_orf, 'w');
        $opd_head_orf = 'HN|DATEOPD|CLINIC|REFER|REFERTYPE|SEQ|REFERDATE';
        fwrite($objFopen_orf, $opd_head_orf);
        $orf = DB::connection('mysql')->select('SELECT * from fdh_orf where d_anaconda_id = "FDH"');
        foreach ($orf as $key => $value4) {
            $p1 = $value4->HN;
            $p2 = $value4->DATEOPD;
            $p3 = $value4->CLINIC;
            $p4 = $value4->REFER;
            $p5 = $value4->REFERTYPE;
            $p6 = $value4->SEQ;
            $p7 = $value4->REFERDATE;
            $str_orf = "\n" . $p1 . "|" . $p2 . "|" . $p3 . "|" . $p4 . "|" . $p5 . "|" . $p6 . "|" . $p7;
            $str_orf_40 = preg_replace("/\n/", "\r\n", $str_orf);
            $str_orf_41 = mb_convert_encoding($str_orf_40, 'UTF-8');
            fwrite($objFopen_orf, $str_orf_41);
        }
        fclose($objFopen_orf);

        //5 odx.txt
        $file_d_odx = "Export/" . $folder . "/ODX.txt";
        $objFopen_odx = fopen($file_d_odx, 'w');
        $opd_head_odx = 'HN|DATEDX|CLINIC|DIAG|DXTYPE|DRDX|PERSON_ID|SEQ';
        fwrite($objFopen_odx, $opd_head_odx);
        $odx = DB::connection('mysql')->select('SELECT * from fdh_odx where d_anaconda_id = "FDH"');
        foreach ($odx as $key => $value5) {
            $m1 = $value5->HN;
            $m2 = $value5->DATEDX;
            $m3 = $value5->CLINIC;
            $m4 = $value5->DIAG;
            $m5 = $value5->DXTYPE;
            $m6 = $value5->DRDX;
            $m7 = $value5->PERSON_ID;
            $m8 = $value5->SEQ;
            $str_odx = "\n" . $m1 . "|" . $m2 . "|" . $m3 . "|" . $m4 . "|" . $m5 . "|" . $m6 . "|" . $m7 . "|" . $m8;
            $str_odx_50 = preg_replace("/\n/", "\r\n", $str_odx);
            $str_odx_51 = mb_convert_encoding($str_odx_50, 'UTF-8');
            fwrite($objFopen_odx, $str_odx_51);
        }
        fclose($objFopen_odx);

        //6 oop.txt
        $file_d_oop = "Export/" . $folder . "/OOP.txt";
        $objFopen_oop = fopen($file_d_oop, 'w');
        $opd_head_oop = 'HN|DATEOPD|CLINIC|OPER|DROPID|PERSON_ID|SEQ|SERVPRICE';
        fwrite($objFopen_oop, $opd_head_oop);
        $oop = DB::connection('mysql')->select('SELECT * from fdh_oop where d_anaconda_id = "FDH"');
        foreach ($oop as $key => $value6) {
            $n1 = $value6->HN;
            $n2 = $value6->DATEOPD;
            $n3 = $value6->CLINIC;
            $n4 = $value6->OPER;
            $n5 = $value6->DROPID;
            $n6 = $value6->PERSON_ID;
            $n7 = $value6->SEQ;
            $n8 = $value6->SERVPRICE;
            $str_oop = "\n" . $n1 . "|" . $n2 . "|" . $n3 . "|" . $n4 . "|" . $n5 . "|" . $n6 . "|" . $n7 . "|" . $n8;
            $str_oop_60 = preg_replace("/\n/", "\r\n", $str_oop);
            $str_oop_61 = mb_convert_encoding($str_oop_60, 'UTF-8');
            fwrite($objFopen_oop, $str_oop_61);
        }
        fclose($objFopen_oop);

        //7 ipd.txt
        $file_d_ipd = "Export/" . $folder . "/IPD.txt";
        $objFopen_ipd = fopen($file_d_ipd, 'w');
        $opd_head_ipd = 'HN|AN|DATEADM|TIMEADM|DATEDSC|TIMEDSC|DISCHS|DISCHT|WARDDSC|DEPT|ADM_W|UUC|SVCTYPE';
        fwrite($objFopen_ipd, $opd_head_ipd);
        $ipd = DB::connection('mysql')->select('SELECT * from fdh_ipd where d_anaconda_id = "FDH"');
        foreach ($ipd as $key => $value7) {
            $j1 = $value7->HN;
            $j2 = $value7->AN;
            $j3 = $value7->DATEADM;
            $j4 = $value7->TIMEADM;
            $j5 = $value7->DATEDSC;
            $j6 = $value7->TIMEDSC;
            $j7 = $value7->DISCHS;
            $j8 = $value7->DISCHT;
            $j9 = $value7->WARDDSC;
            $j10 = $value7->DEPT;
            $j11 = $value7->ADM_W;
            $j12 = $value7->UUC;
            $j13 = $value7->SVCTYPE;
            $str_ipd = "\n" . $j1 . "|" . $j2 . "|" . $j3 . "|" . $j4 . "|" . $j5 . "|" . $j6 . "|" . $j7 . "|" . $j8 . "|" . $j9 . "|" . $j10 . "|" . $j11 . "|" . $j12 . "|" . $j13;
            $str_ipd_70 = preg_replace("/\n/", "\r\n", $str_ipd);
            $str_ipd_71 = mb_convert_encoding($str_ipd_70, 'UTF-8');
            fwrite($objFopen_ipd, $str_ipd_71);
        }
        fclose($objFopen_ipd);

        //8 irf.txt
        $file_d_irf = "Export/" . $folder . "/IRF.txt";
        $objFopen_irf = fopen($file_d_irf, 'w');
        $opd_head_irf = 'AN|REFER|REFERTYPE';
        fwrite($objFopen_irf, $opd_head_irf);
        $irf = DB::connection('mysql')->select('SELECT * from fdh_irf where d_anaconda_id = "FDH"');
        foreach ($irf as $key => $value8) {
            $k1 = $value8->AN;
            $k2 = $value8->REFER;
            $k3 = $value8->REFERTYPE;
            $str_irf = "\n" . $k1 . "|" . $k2 . "|" . $k3;
            $str_irf_80 = preg_replace("/\n/", "\r\n", $str_irf);
            $str_irf_81 = mb_convert_encoding($str_irf_80, 'UTF-8');
            fwrite($objFopen_irf, $str_irf_81);
        }
        fclose($objFopen_irf);

        //9 idx.txt
        $file_d_idx = "Export/" . $folder . "/IDX.txt";
        $objFopen_idx = fopen($file_d_idx, 'w');
        $opd_head_idx = 'AN|DIAG|DXTYPE|DRDX';
        fwrite($objFopen_idx, $opd_head_idx);
        $idx = DB::connection('mysql')->select('SELECT * from fdh_idx where d_anaconda_id = "FDH"');
        foreach ($idx as $key => $value9) {
            $h1 = $value9->AN;
            $h2 = $value9->DIAG;
            $h3 = $value9->DXTYPE;
            $h4 = $value9->DRDX;
            $str_idx = "\n" . $h1 . "|" . $h2 . "|" . $h3 . "|" . $h4;
            $str_idx_90 = preg_replace("/\n/", "\r\n", $str_idx);
            $str_idx_91 = mb_convert_encoding($str_idx_90, 'UTF-8');
            fwrite($objFopen_idx, $str_idx_91);
        }
        fclose($objFopen_idx);

        //10 iop.txt
        $file_d_iop = "Export/" . $folder . "/IOP.txt";
        $objFopen_iop = fopen($file_d_iop, 'w');
        $opd_head_iop = 'AN|OPER|OPTYPE|DROPID|DATEIN|TIMEIN|DATEOUT|TIMEOUT';
        fwrite($objFopen_iop, $opd_head_iop);
        $iop = DB::connection('mysql')->select('SELECT * from fdh_iop where d_anaconda_id = "FDH"');
        foreach ($iop as $key => $value10) {
            $b1 = $value10->AN;
            $b2 = $value10->OPER;
            $b3 = $value10->OPTYPE;
            $b4 = $value10->DROPID;
            $b5 = $value10->DATEIN;
            $b6 = $value10->TIMEIN;
            $b7 = $value10->DATEOUT;
            $b8 = $value10->TIMEOUT;
            $str_iop = "\n" . $b1 . "|" . $b2 . "|" . $b3 . "|" . $b4 . "|" . $b5 . "|" . $b6 . "|" . $b7 . "|" . $b8;
            $str_iop_100 = preg_replace("/\n/", "\r\n", $str_iop);
            $str_iop_101 = mb_convert_encoding($str_iop_100, 'UTF-8');
            fwrite($objFopen_iop, $str_iop_101);
        }
        fclose($objFopen_iop);

        //11 cht.txt
        $file_d_cht = "Export/" . $folder . "/CHT.txt";
        $objFopen_cht = fopen($file_d_cht, 'w');
        $opd_head_cht = 'HN|AN|DATE|TOTAL|PAID|PTTYPE|PERSON_ID|SEQ|OPD_MEMO|INVOICE_NO|INVOICE_LT';
        // $opd_head_cht = 'HN|AN|DATE|TOTAL|PAID|PTTYPE|PERSON_ID|SEQ';
        fwrite($objFopen_cht, $opd_head_cht);
        $cht = DB::connection('mysql')->select('SELECT * from fdh_cht where d_anaconda_id = "FDH"');
        foreach ($cht as $key => $value11) {
            $f1 = $value11->HN;
            $f2 = $value11->AN;
            $f3 = $value11->DATE;
            $f4 = $value11->TOTAL;
            $f5 = $value11->PAID;
            $f6 = $value11->PTTYPE;
            $f7 = $value11->PERSON_ID;
            $f8 = $value11->SEQ;
            $f9 = $value11->OPD_MEMO;
            $f10 = $value11->INVOICE_NO;
            $f11 = $value11->INVOICE_LT;
            $str_cht = "\n" . $f1 . "|" . $f2 . "|" . $f3 . "|" . $f4 . "|" . $f5 . "|" . $f6 . "|" . $f7 . "|" . $f8 . "|" . $f9 . "|" . $f10 . "|" . $f11;
            // $str_cht="\n".$f1."|".$f2."|".$f3."|".$f4."|".$f5."|".$f6."|".$f7."|".$f8;
            $str_cht_11 = preg_replace("/\n/", "\r\n", $str_cht);
            $str_cht_12 = mb_convert_encoding($str_cht_11, 'UTF-8');
            fwrite($objFopen_cht, $str_cht_12);
        }
        fclose($objFopen_cht);

        //12 cha.txt
        $file_d_cha = "Export/" . $folder . "/CHA.txt";
        $objFopen_cha = fopen($file_d_cha, 'w');
        $opd_head_cha = 'HN|AN|DATE|CHRGITEM|AMOUNT|PERSON_ID|SEQ';
        fwrite($objFopen_cha, $opd_head_cha);
        $cha = DB::connection('mysql')->select('SELECT * from fdh_cha where d_anaconda_id = "FDH"');
        foreach ($cha as $key => $value12) {
            $e1 = $value12->HN;
            $e2 = $value12->AN;
            $e3 = $value12->DATE;
            $e4 = $value12->CHRGITEM;
            $e5 = $value12->AMOUNT;
            $e6 = $value12->PERSON_ID;
            $e7 = $value12->SEQ;
            $str_cha = "\n" . $e1 . "|" . $e2 . "|" . $e3 . "|" . $e4 . "|" . $e5 . "|" . $e6 . "|" . $e7;
            $str_cha_12 = preg_replace("/\n/", "\r\n", $str_cha);
            $str_cha_122 = mb_convert_encoding($str_cha_12, 'UTF-8');
            fwrite($objFopen_cha, $str_cha_122);
        }
        fclose($objFopen_cha);

        //13 aer.txt
        $file_d_aer = "Export/" . $folder . "/AER.txt";
        $objFopen_aer = fopen($file_d_aer, 'w');
        $opd_head_aer = 'HN|AN|DATEOPD|AUTHAE|AEDATE|AETIME|AETYPE|REFER_NO|REFMAINI|IREFTYPE|REFMAINO|OREFTYPE|UCAE|EMTYPE|SEQ|AESTATUS|DALERT|TALERT';
        fwrite($objFopen_aer, $opd_head_aer);
        $aer = DB::connection('mysql')->select('SELECT * from fdh_aer where d_anaconda_id = "FDH"');
        foreach ($aer as $key => $value13) {
            $d1 = $value13->HN;
            $d2 = $value13->AN;
            $d3 = $value13->DATEOPD;
            $d4 = $value13->AUTHAE;
            $d5 = $value13->AEDATE;
            $d6 = $value13->AETIME;
            $d7 = $value13->AETYPE;
            $d8 = $value13->REFER_NO;
            $d9 = $value13->REFMAINI;
            $d10 = $value13->IREFTYPE;
            $d11 = $value13->REFMAINO;
            $d12 = $value13->OREFTYPE;
            $d13 = $value13->UCAE;
            $d14 = $value13->EMTYPE;
            $d15 = $value13->SEQ;
            $d16 = $value13->AESTATUS;
            $d17 = $value13->DALERT;
            $d18 = $value13->TALERT;
            $str_aer = "\n" . $d1 . "|" . $d2 . "|" . $d3 . "|" . $d4 . "|" . $d5 . "|" . $d6 . "|" . $d7 . "|" . $d8 . "|" . $d9 . "|" . $d10 . "|" . $d11 . "|" . $d12 . "|" . $d13 . "|" . $d14 . "|" . $d15 . "|" . $d16 . "|" . $d17 . "|" . $d18;

            $str_aer_13 = preg_replace("/\n/", "\r\n", $str_aer);
            $str_aer_132 = mb_convert_encoding($str_aer_13, 'UTF-8');
            fwrite($objFopen_aer, $str_aer_132);
        }
        fclose($objFopen_aer);

        //14 adp.txt
        $file_d_adp = "Export/" . $folder . "/ADP.txt";
        $objFopen_adp = fopen($file_d_adp, 'w');
        // $opd_head_adp = 'HN|AN|DATEOPD|TYPE|CODE|QTY|RATE|SEQ|CAGCODE|DOSE|CA_TYPE|SERIALNO|TOTCOPAY|USE_STATUS|TOTAL|QTYDAY|TMLTCODE|STATUS1|BI|CLINIC|ITEMSRC|PROVIDER|GRAVIDA|GA_WEEK|DCIP/E_screen|LMP|SP_ITEM';
        // $opd_head_adp = 'HN|AN|DATEOPD|TYPE|CODE|QTY|RATE|SEQ|CAGCODE|DOSE|CA_TYPE|SERIALNO|TOTCOPAY|USE_STATUS|TOTAL|QTYDAY|TMLTCODE|STATUS1|BI|CLINIC|ITEMSRC|PROVIDER|GRAVIDA|GA_WEEK|DCIP/E_screen|LMP|SP_ITEM';
        $opd_head_adp = 'HN|AN|DATEOPD|TYPE|CODE|QTY|RATE|SEQ|CAGCODE|DOSE|CA_TYPE|SERIALNO|TOTCOPAY|USE_STATUS|TOTAL|QTYDAY|TMLTCODE|STATUS1|BI|CLINIC|ITEMSRC|PROVIDER|GRAVIDA|GA_WEEK|DCIP|LMP';
        // $opd_head_adp = 'HN|AN|DATEOPD|TYPE|CODE|QTY|RATE|SEQ|CAGCODE|DOSE|CA_TYPE|SERIALNO|TOTCOPAY|USE_STATUS|TOTAL|QTYDAY|TMLTCODE';

        fwrite($objFopen_adp, $opd_head_adp);
        $adp = DB::connection('mysql')->select('SELECT * from fdh_adp where d_anaconda_id = "FDH"');
        foreach ($adp as $key => $value14) {
            $c1  = $value14->HN;
            $c2  = $value14->AN;
            $c3  = $value14->DATEOPD;
            $c4  = $value14->TYPE;
            $c5  = $value14->CODE;
            $c6  = $value14->QTY;
            $c7  = $value14->RATE;
            $c8  = $value14->SEQ;
            $c9  = $value14->CAGCODE;
            $c10 = $value14->DOSE;
            $c11 = $value14->CA_TYPE;
            $c12 = $value14->SERIALNO;
            $c13 = $value14->TOTCOPAY;
            $c14 = $value14->USE_STATUS;
            $c15 = $value14->TOTAL;
            $c16 = $value14->QTYDAY;
            $c17 = $value14->TMLTCODE;
            $c18 = $value14->STATUS1;
            $c19 = $value14->BI;
            $c20 = $value14->CLINIC;
            $c21 = $value14->ITEMSRC;
            $c22 = $value14->PROVIDER;
            $c23 = $value14->GRAVIDA;
            $c24 = $value14->GA_WEEK;
            $c25 = $value14->DCIP;
            $c26 = $value14->LMP;
            // $c27 = $value14->SP_ITEM;
            // $str_adp="\n".$c1."|".$c2."|".$c3."|".$c4."|".$c5."|".$c6."|".$c7."|".$c8."|".$c9."|".$c10."|".$c11."|".$c12."|".$c13."|".$c14."|".$c15."|".$c16."|".$c17;
            $str_adp = "\n" . $c1 . "|" . $c2 . "|" . $c3 . "|" . $c4 . "|" . $c5 . "|" . $c6 . "|" . $c7 . "|" . $c8 . "|" . $c9 . "|" . $c10 . "|" . $c11 . "|" . $c12 . "|" . $c13 . "|" . $c14 . "|" . $c15 . "|" . $c16 . "|" . $c17 . "|" . $c18 . "|" . $c19 . "|" . $c20 . "|" . $c21 . "|" . $c22 . "|" . $c23 . "|" . $c24 . "|" . $c25 . "|" . $c26;
            // $str_adp="\n".$c1."|".$c2."|".$c3."|".$c4."|".$c5."|".$c6."|".$c7."|".$c8."|".$c9."|".$c10."|".$c11."|".$c12."|".$c13."|".$c14."|".$c15."|".$c16."|".$c17."|".$c18."|".$c19."|".$c20."|".$c21."|".$c22."|".$c23."|".$c24."|".$c25."|".$c26."|".$c27;

            $str_adp_14 = preg_replace("/\n/", "\r\n", $str_adp);
            $str_adp_142 = mb_convert_encoding($str_adp_14, 'UTF-8');
            fwrite($objFopen_adp, $str_adp_142);
        }
        fclose($objFopen_adp);

        //15 lvd.txt
        $file_d_lvd = "Export/" . $folder . "/LVD.txt";
        $objFopen_lvd = fopen($file_d_lvd, 'w');
        $opd_head_lvd = 'SEQLVD|AN|DATEOUT|TIMEOUT|DATEIN|TIMEIN|QTYDAY';
        fwrite($objFopen_lvd, $opd_head_lvd);
        $lvd = DB::connection('mysql')->select('SELECT * from fdh_lvd where d_anaconda_id = "FDH"');
        foreach ($lvd as $key => $value15) {
            $L1 = $value15->SEQLVD;
            $L2 = $value15->AN;
            $L3 = $value15->DATEOUT;
            $L4 = $value15->TIMEOUT;
            $L5 = $value15->DATEIN;
            $L6 = $value15->TIMEIN;
            $L7 = $value15->QTYDAY;
            $str_lvd = "\n" . $L1 . "|" . $L2 . "|" . $L3 . "|" . $L4 . "|" . $L5 . "|" . $L6 . "|" . $L7;

            $str_lvd_15 = preg_replace("/\n/", "\r\n", $str_lvd);
            $str_lvd_152 = mb_convert_encoding($str_lvd_15, 'UTF-8');
            fwrite($objFopen_lvd, $str_lvd_152);
        }
        fclose($objFopen_lvd);

        //16 dru.txt
        $file_d_dru = "Export/" . $folder . "/DRU.txt";
        $objFopen_dru = fopen($file_d_dru, 'w');
        // $objFopen_dru_utf = fopen($file_d_dru, 'w');
        // $opd_head_dru = 'HCODE|HN|AN|CLINIC|PERSON_ID|DATE_SERV|DID|DIDNAME|AMOUNT|DRUGPRIC|DRUGCOST|DIDSTD|UNIT|UNIT_PACK|SEQ|DRUGREMARK|PA_NO|TOTCOPAY|USE_STATUS|TOTAL|SIGCODE|SIGTEXT|PROVIDER|SP_ITEM';
        $opd_head_dru = 'HCODE|HN|AN|CLINIC|PERSON_ID|DATE_SERV|DID|DIDNAME|AMOUNT|DRUGPRICE|DRUGCOST|DIDSTD|UNIT|UNIT_PACK|SEQ|DRUGREMARK|PA_NO|TOTCOPAY|USE_STATUS|TOTAL|SIGCODE|SIGTEXT|PROVIDER';
        fwrite($objFopen_dru, $opd_head_dru);
        // fwrite($objFopen_dru_utf, $opd_head_dru);
        $dru = DB::connection('mysql')->select('SELECT * from fdh_dru where d_anaconda_id = "FDH"');
        foreach ($dru as $key => $value16) {
            $g1 = $value16->HCODE;
            $g2 = $value16->HN;
            $g3 = $value16->AN;
            $g4 = $value16->CLINIC;
            $g5 = $value16->PERSON_ID;
            $g6 = $value16->DATE_SERV;
            $g7 = $value16->DID;
            $g8 = $value16->DIDNAME;
            $g9 = $value16->AMOUNT;
            $g10 = $value16->DRUGPRICE;
            $g11 = $value16->DRUGCOST;
            $g12 = $value16->DIDSTD;
            $g13 = $value16->UNIT;
            $g14 = $value16->UNIT_PACK;
            $g15 = $value16->SEQ;
            // $g16 = $value16->DRUGTYPE;
            $g17 = $value16->DRUGREMARK;
            $g18 = $value16->PA_NO;
            $g19 = $value16->TOTCOPAY;
            $g20 = $value16->USE_STATUS;
            $g21 = $value16->TOTAL;
            $g22 = $value16->SIGCODE;
            $g23 = $value16->SIGTEXT;
            $g24 = $value16->PROVIDER;
            // $g25 = $value16->SP_ITEM;
            $str_dru = "\n" . $g1 . "|" . $g2 . "|" . $g3 . "|" . $g4 . "|" . $g5 . "|" . $g6 . "|" . $g7 . "|" . $g8 . "|" . $g9 . "|" . $g10 . "|" . $g11 . "|" . $g12 . "|" . $g13 . "|" . $g14 . "|" . $g15 . "|" . $g17 . "|" . $g18 . "|" . $g19 . "|" . $g20 . "|" . $g21 . "|" . $g22 . "|" . $g23 . "|" . $g24;
            $ansitxt_dru = iconv('UTF-8', 'UTF-8', $str_dru);

            $str_dru_16 = preg_replace("/\n/", "\r\n", $str_dru);
            $str_dru_162 = mb_convert_encoding($str_dru_16, 'UTF-8');
            fwrite($objFopen_dru, $str_dru_162);
        }
        fclose($objFopen_dru);

        //17 lab.txt
        //  $file_d_lab = "Export/".$folder."/LAB.txt";
        //  $objFopen_lab = fopen($file_d_lab, 'w');
        //  $opd_head_lab = 'HCODE|HN|PERSON_ID|DATESERV|SEQ|LABTEST|LABRESULT';
        //  fwrite($objFopen_lab, $opd_head_lab);
        //  fclose($objFopen_lab);



        $pathdir =  "Export/" . $folder . "/";
        $zipcreated = $folder . ".zip";

        $newzip = new ZipArchive;
        if ($newzip->open($zipcreated, ZipArchive::CREATE) === TRUE) {
            $dir = opendir($pathdir);

            while ($file = readdir($dir)) {
                if (is_file($pathdir . $file)) {
                    $newzip->addFile($pathdir . $file, $file);
                }
            }
            $newzip->close();
            if (file_exists($zipcreated)) {
                header('Content-Type: application/zip');
                header('Content-Disposition: attachment; filename="' . basename($zipcreated) . '"');
                header('Content-Length: ' . filesize($zipcreated));
                flush();
                readfile($zipcreated);
                unlink($zipcreated);
                $files = glob($pathdir . '/*');
                foreach ($files as $file) {
                    if (is_file($file)) {
                        // unlink($file);
                    }
                }
                return redirect()->route('fdh.fdh_main');
            }
        }

        return redirect()->route('fdh.fdh_main');
    }

    // **********************************************************
    public function fdh_mini_dataset(Request $request)
    {
        $startdate = $request->startdate;
        $enddate = $request->enddate;

        $date = date('Y-m-d');
        $y = date('Y') + 543;
        $newweek = date('Y-m-d', strtotime($date . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
        $newDate = date('Y-m-d', strtotime($date . ' -5 months')); //ย้อนหลัง 5 เดือน
        $newyear = date('Y-m-d', strtotime($date . ' -1 year')); //ย้อนหลัง 1 ปี

        $data_auth = DB::connection('mysql')->select('
            SELECT *
            FROM api_neweclaim
        ');
        return view('fdh.fdh_mini_dataset', [
            'startdate'        => $startdate,
            'enddate'          => $enddate,
            'data_auth'        => $data_auth,
        ]);
    }
    public function fdh_mini_dataset_api_old(Request $request)
    {
        $ip = $request->ip();
        if ($ip == '::1') {
            $username        = $request->username;
            $password        = $request->password;
            $password_hash   = strtoupper(hash_hmac('sha256', $password, '$jwt@moph#'));

            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://fdh.moph.go.th/token?Action=get_moph_access_token&user=' . $username . '&password_hash=' . $password_hash . '&hospital_code=10978',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_HTTPHEADER => array(
                    'Cookie: __cfruid=bedad7ad2fc9095d4827bc7be4f52f209543768f-1714445470'
                ),
            ));
            $token = curl_exec($curl);
            // dd($token);
            curl_close($curl);

            $check = Api_neweclaim::where('api_neweclaim_user', $username)->where('api_neweclaim_pass', $password)->count();
            if ($check > 0) {
                Api_neweclaim::where('api_neweclaim_user', $username)->update([
                    'api_neweclaim_token'       => $token,
                    'user_id'                   => Auth::user()->id,
                    'password_hash'             => $password_hash,
                    'hospital_code'             => '10978',
                ]);
            } else {
                Api_neweclaim::insert([
                    'api_neweclaim_user'        => $username,
                    'api_neweclaim_pass'        => $password,
                    'api_neweclaim_token'       => $token,
                    'password_hash'             => $password_hash,
                    'hospital_code'             => '10978',
                    'user_id'                   => Auth::user()->id,
                ]);
            }
        } else {

            $username        = $request->username;
            $password        = $request->password;
            $password_hash   = strtoupper(hash_hmac('sha256', $password, '$jwt@moph#'));
            $basic_auth = base64_encode("$username:$password");
            $context = stream_context_create(array(
                'http' => array(
                    'header' => "Authorization: Basic ".base64_encode("$username:$password")
                )
            ));
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://fdh.moph.go.th/token?Action=get_moph_access_token&user=' . $username . '&password_hash=' . $password_hash . '&hospital_code=10978',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_HTTPHEADER => array(
                    'Cookie: __cfruid=bedad7ad2fc9095d4827bc7be4f52f209543768f-1714445470'
                ),
            ));
            $token = curl_exec($curl);
            // dd($token);
            curl_close($curl);
            $check = Api_neweclaim::where('api_neweclaim_user', $username)->where('api_neweclaim_pass', $password)->count();
            if ($check > 0) {
                Api_neweclaim::where('api_neweclaim_user', $username)->update([
                    'api_neweclaim_token'       => $token,
                    'user_id'                   => Auth::user()->id,
                    'password_hash'             => $password_hash,
                    'hospital_code'             => '10978',
                    'basic_auth'                => $basic_auth,
                ]);
            } else {
                Api_neweclaim::insert([
                    'api_neweclaim_user'        => $username,
                    'api_neweclaim_pass'        => $password,
                    'api_neweclaim_token'       => $token,
                    'password_hash'             => $password_hash,
                    'hospital_code'             => '10978',
                    'basic_auth'                => $basic_auth,
                    'user_id'                   => Auth::user()->id,
                ]);
            }

        }

        return response()->json([
            'status'     => '200'
        ]);
    }
    public function fdh_mini_dataset_api(Request $request)
    {
        $ip = $request->ip();
        // if ($ip == '::1') {
        //     $username        = $request->username;
        //     $password        = $request->password;
        //     $password_hash   = strtoupper(hash_hmac('sha256', $password, '$jwt@moph#'));

        //     $curl = curl_init();
        //     curl_setopt_array($curl, array(
        //         CURLOPT_URL => 'https://fdh.moph.go.th/token?Action=get_moph_access_token&user=' . $username . '&password_hash=' . $password_hash . '&hospital_code=10978',
        //         CURLOPT_RETURNTRANSFER => true,
        //         CURLOPT_ENCODING => '',
        //         CURLOPT_MAXREDIRS => 10,
        //         CURLOPT_TIMEOUT => 0,
        //         CURLOPT_FOLLOWLOCATION => true,
        //         CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        //         CURLOPT_CUSTOMREQUEST => 'POST',
        //         CURLOPT_HTTPHEADER => array(
        //             'Cookie: __cfruid=bedad7ad2fc9095d4827bc7be4f52f209543768f-1714445470'
        //         ),
        //     ));
        //     $token = curl_exec($curl);
        //     // dd($token);
        //     curl_close($curl);

        //     $check = Api_neweclaim::where('api_neweclaim_user', $username)->where('api_neweclaim_pass', $password)->count();
        //     if ($check > 0) {
        //         Api_neweclaim::where('api_neweclaim_user', $username)->update([
        //             'api_neweclaim_token'       => $token,
        //             'user_id'                   => Auth::user()->id,
        //             'password_hash'             => $password_hash,
        //             'hospital_code'             => '10978',
        //         ]);
        //     } else {
        //         Api_neweclaim::insert([
        //             'api_neweclaim_user'        => $username,
        //             'api_neweclaim_pass'        => $password,
        //             'api_neweclaim_token'       => $token,
        //             'password_hash'             => $password_hash,
        //             'hospital_code'             => '10978',
        //             'user_id'                   => Auth::user()->id,
        //         ]);
        //     }
        // } else {

            $username        = $request->username;
            $password        = $request->password;
            $userid          = Auth::user()->id;

            $password_hash   = strtoupper(hash_hmac('sha256', $password, '$jwt@moph#'));
            $basic_auth = base64_encode("$username:$password");
            $context = stream_context_create(array(
                'http' => array(
                    'header' => "Authorization: Basic ".base64_encode("$username:$password")
                )
            ));
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://fdh.moph.go.th/token?Action=get_moph_access_token&user=' . $username . '&password_hash=' . $password_hash . '&hospital_code=10978',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_HTTPHEADER => array(
                    'Cookie: __cfruid=bedad7ad2fc9095d4827bc7be4f52f209543768f-1714445470'
                ),
            ));
            $token = curl_exec($curl);
            // dd($token);
            curl_close($curl);
            // $check = Api_neweclaim::where('api_neweclaim_user', $username)->where('api_neweclaim_pass', $password)->count();
            $check = Api_neweclaim::where('user_id', $userid)->where('api_neweclaim_user', $username)->count();
            if ($check > 0) {
                Api_neweclaim::where('api_neweclaim_user', $username)->update([
                    'api_neweclaim_token'       => $token,
                    // 'user_id'                   => $userid,
                    // 'password_hash'             => $password_hash,
                    // 'hospital_code'             => '10978',
                    // 'basic_auth'                => $basic_auth,
                    'active_mini'               => 'Y'
                ]);
            } else {
                Api_neweclaim::insert([
                    'api_neweclaim_user'        => $username,
                    'api_neweclaim_pass'        => $password,
                    'api_neweclaim_token'       => $token,
                    // 'password_hash'             => $password_hash,
                    'hospital_code'             => '10978',
                    'basic_auth'                => $basic_auth,
                    'active_mini'               => 'Y',
                    'user_id'                   => $userid,
                ]);
            }

        // }

        return response()->json([
            'status'     => '200'
        ]);
    }

    public function fdh_mini_dataset_pull(Request $request)
    {
        $startdate   = $request->startdate;
        $enddate     = $request->enddate;
        $date = date('Y-m-d');
        $newday = date('Y-m-d', strtotime($date . ' -1 days')); //
        $newweek = date('Y-m-d', strtotime($date . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
        $newDate = date('Y-m-d', strtotime($date . ' -1 months')); //ย้อนหลัง 1 เดือน
        $cid_auth    = Auth::user()->cid;
        if ($startdate == '') {
            $data['fdh_mini_dataset']    = DB::connection('mysql')->select(
                'SELECT * from fdh_mini_dataset
                    WHERE vstdate BETWEEN "' . $newday . '" and "' . $date . '"
                    AND (active = "N" OR active_nhso = "N")
                    ORDER BY total_amout DESC');
                    // AND active = "N" AND active_nhso = "N"
                    // (active = "N" OR active_nhso = "N")
                    // AND (active = "N" OR active_nhso = "N")
                    $data['count_fdh_y'] = Fdh_mini_dataset::where('active','=','Y')->whereBetween('vstdate', [$newday, $date])->count();
                    $data['count_fdh_n'] = Fdh_mini_dataset::where('active','=','N')->whereBetween('vstdate', [$newday, $date])->count();
                    $data['count_nhso_y'] = Fdh_mini_dataset::where('active_nhso','=','Y')->whereBetween('vstdate', [$newday, $date])->count();
                    $data['count_nhso_n'] = Fdh_mini_dataset::where('active_nhso','=','N')->whereBetween('vstdate', [$newday, $date])->count();
        } else {

            $iduser = Auth::user()->id;
            $datashow_ = DB::connection('mysql2')->select(
                'SELECT o.vstdate,o.vsttime,Time_format(o.vsttime ,"%H:%i") vsttime2
                    ,pt.cid,"10978" as hcode,IFNULL(rd.total_amount,v.income) as total_amout
                    ,IFNULL(rd.finance_number,v.vn) as invoice_number,v.vn,concat(pt.pname,pt.fname," ",pt.lname) as ptname,v.hn,v.pttype
                    ,v.rcpt_money,v.uc_money,ptt.hipdata_code as mainInsclCode,IFNULL(o.main_dep,"155") as main_dep,IFNULL(k.department,"อายุรกรรมห้องตรวจ 3") as department

                    ,CONCAT(o.vstdate," ",DATE_FORMAT(o.vsttime,"%H:%i")) AS service_date_time,v.income as totalAmount
                    ,v.uc_money AS privilegeAmount,v.paid_money AS paidAmount,rd.finance_number as visitNumber,ov.name as ovstost
                    FROM vn_stat v
                    LEFT OUTER JOIN ovst o ON v.vn = o.vn
                    LEFT OUTER JOIN patient pt on pt.hn = v.hn
                    LEFT OUTER JOIN pttype ptt ON v.pttype=ptt.pttype
                    LEFT OUTER JOIN rcpt_debt rd ON v.vn = rd.vn
                    LEFT OUTER JOIN kskdepartment k ON k.depcode = o.main_dep
                    LEFT OUTER JOIN ovstost ov on ov.ovstost = o.ovstost
                    WHERE o.vstdate BETWEEN "' . $startdate . '" and "' . $enddate . '"
                    AND v.income > 0 AND pt.nationality = "99" AND (o.an IS NULL OR o.an ="")
                    AND v.pttype NOT IN("10")
                    GROUP BY o.vn
            ');

            // foreach ($datashow_ as $key => $value) {
            //     $dateString = $value->vstdate." ".$value->vsttime;
            //     $dateTime = new DateTime($dateString);
            //     $timestampInSeconds = $dateTime->getTimestamp();
            //     $timestampInMilliseconds = $timestampInSeconds * 1000;
            //     $invoiceDateTime = (new DateTime())->format('Uv'); #current_time

            //     if ($value->pttype == 'M1') {
            //         $claimServiceCode = 'PG0130001';
            //     }elseif ($value->pttype == 'M2') {
            //         $claimServiceCode = 'PG0130001';
            //     }elseif ($value->pttype == 'M3') {
            //         $claimServiceCode = 'PG0130001';
            //     }elseif ($value->pttype == 'M4') {
            //         $claimServiceCode = 'PG0130001';
            //     }elseif ($value->pttype == 'M5') {
            //         $claimServiceCode = 'PG0130001';
            //     } else {
            //          $claimServiceCode = 'PG0060001';
            //     }
            //     $check_opd = Fdh_mini_dataset::where('vn', $value->vn)->count();
            //     if ($check_opd > 0) {
            //         Fdh_mini_dataset::where('vn', $value->vn)->update([
            //             'total_amout'         => $value->total_amout,
            //             'invoice_number'      => $value->invoice_number,
            //             'pttype'              => $value->pttype,
            //             'rcpt_money'          => $value->rcpt_money,
            //             'uc_money'            => $value->privilegeAmount,
            //             'paid_money'          => $value->paidAmount,
            //             'ovstost'             => $value->ovstost,
            //             'mainInsclCode'       => $value->mainInsclCode,
            //             'serviceDateTime'     => $timestampInMilliseconds,
            //             'invoiceDateTime'     => $invoiceDateTime,
            //             'transactionId'       => '10978'.$value->vn,
            //             'totalAmount'         => $value->totalAmount,
            //             'paidAmount'          => $value->paidAmount,
            //             'privilegeAmount'     => $value->privilegeAmount,
            //             'claimServiceCode'    => $claimServiceCode,
            //             'sourceId'            => 'PK9999',
            //             'code'                => $value->main_dep,
            //             'name'                => $value->department,
            //             'visitNumber'         => $value->vn,
            //             'recorderPid'         => $cid_auth,
            //         ]);
            //     } else {
            //         Fdh_mini_dataset::insert([
            //             'service_date_time'   => $value->vstdate . ' ' . $value->vsttime,
            //             'cid'                 => $value->cid,
            //             'hcode'               => $value->hcode,
            //             'total_amout'         => $value->total_amout,
            //             'invoice_number'      => $value->invoice_number,
            //             'vn'                  => $value->vn,
            //             'pttype'              => $value->pttype,
            //             'ptname'              => $value->ptname,
            //             'hn'                  => $value->hn,
            //             'vstdate'             => $value->vstdate,
            //             'vsttime'             => $value->vsttime,
            //             'datesave'            => $date,
            //             'user_id'             => $iduser,
            //             'rcpt_money'          => $value->rcpt_money,
            //             'uc_money'            => $value->privilegeAmount,
            //             'paid_money'          => $value->paidAmount,
            //             'ovstost'             => $value->ovstost,
            //             'mainInsclCode'       => $value->mainInsclCode,
            //             'serviceDateTime'     => $timestampInMilliseconds,
            //             'invoiceDateTime'     => $invoiceDateTime,
            //             'transactionId'       => '10978'.$value->vn,
            //             'totalAmount'         => $value->totalAmount,
            //             'paidAmount'          => $value->paidAmount,
            //             'privilegeAmount'     => $value->privilegeAmount,
            //             'claimServiceCode'    => $claimServiceCode,
            //             'sourceId'            => 'PK9999',
            //             'code'                => $value->main_dep,
            //             'name'                => $value->department,
            //             'visitNumber'         => $value->vn,
            //             'recorderPid'         => $cid_auth,
            //         ]);
            //     }

            // }

            $data['fdh_mini_dataset']    = DB::connection('mysql')->select(
                'SELECT * from fdh_mini_dataset
                    WHERE vstdate BETWEEN "' . $startdate . '" and "' . $enddate . '"
                    ORDER BY total_amout DESC');
                    $data['count_fdh_y'] = Fdh_mini_dataset::where('active','=','Y')->whereBetween('vstdate', [$startdate, $enddate])->count();
                    $data['count_fdh_n'] = Fdh_mini_dataset::where('active','=','N')->whereBetween('vstdate', [$startdate, $enddate])->count();
                    $data['count_nhso_y'] = Fdh_mini_dataset::where('active_nhso','=','Y')->whereBetween('vstdate', [$startdate, $enddate])->count();
                    $data['count_nhso_n'] = Fdh_mini_dataset::where('active_nhso','=','N')->whereBetween('vstdate', [$startdate, $enddate])->count();
        }


        return view('fdh.fdh_mini_dataset_pull',$data, [
            'startdate'        => $startdate,
            'enddate'          => $enddate,
        ]);
    }
    // fdh_mini_dataset_pullnoinv
    public function fdh_mini_dataset_pullnoinv(Request $request)
    {
        $startdate   = $request->startdate;
        $enddate     = $request->enddate;
        $date = date('Y-m-d');
        $newday = date('Y-m-d', strtotime($date . ' -2 days')); //
        $newweek = date('Y-m-d', strtotime($date . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
        $newDate = date('Y-m-d', strtotime($date . ' -1 months')); //ย้อนหลัง 1 เดือน
        $cid_auth    = Auth::user()->cid;
        if ($startdate == '') {
            $data['fdh_mini_dataset']    = DB::connection('mysql')->select(
                'SELECT * from fdh_mini_dataset
                    WHERE vstdate = "' . $date . '"
                    ORDER BY vn DESC');
        } else {
            $date = date('Y-m-d');
            $iduser = Auth::user()->id;
            $datashow_ = DB::connection('mysql10')->select(

                'SELECT o.vstdate,o.vsttime,Time_format(o.vsttime ,"%H:%i") vsttime2
                    ,pt.cid,"10978" as hcode,IFNULL(rd.total_amount,v.income) as total_amout
                    ,IFNULL(rd.finance_number,v.vn) as invoice_number,v.vn,concat(pt.pname,pt.fname," ",pt.lname) as ptname,v.hn,v.pttype
                    ,v.rcpt_money,v.uc_money,ptt.hipdata_code as mainInsclCode,IFNULL(o.main_dep,"155") as main_dep,IFNULL(k.department,"อายุรกรรมห้องตรวจ 3") as department

                    ,CONCAT(o.vstdate," ",DATE_FORMAT(o.vsttime,"%H:%i")) AS service_date_time,v.income as totalAmount
                    ,v.uc_money AS privilegeAmount,v.paid_money AS paidAmount,rd.finance_number as visitNumber,ov.name as ovstost
                    FROM vn_stat v
                    LEFT OUTER JOIN ovst o ON v.vn = o.vn
                    LEFT OUTER JOIN patient pt on pt.hn = v.hn
                    LEFT OUTER JOIN pttype ptt ON v.pttype=ptt.pttype
                    LEFT OUTER JOIN rcpt_debt rd ON v.vn = rd.vn
                    LEFT OUTER JOIN kskdepartment k ON k.depcode = o.main_dep
                    LEFT OUTER JOIN ovstost ov on ov.ovstost = o.ovstost
                    WHERE o.vstdate BETWEEN "' . $startdate . '" and "' . $enddate . '"
                    AND v.income > 0 AND pt.nationality = "99" AND (o.an IS NULL OR o.an ="") AND v.pttype NOT IN("10")
                    GROUP BY o.vn
            '
            );
            // NOT IN("M1","M2","M3","M4","M5")  AND v.pttype NOT IN("M1","M4","M5")
            // ,IFNULL(rd.total_amount,v.income) as total_amout
            // ,IFNULL(rd.finance_number,v.vn) as invoice_number
            foreach ($datashow_ as $key => $value) {
                $dateString = $value->vstdate." ".$value->vsttime;
                $dateTime = new DateTime($dateString);
                $timestampInSeconds = $dateTime->getTimestamp();
                $timestampInMilliseconds = $timestampInSeconds * 1000;
                $invoiceDateTime = (new DateTime())->format('Uv'); #current_time

                if ($value->pttype == 'M1') {
                    $claimServiceCode = 'PG0130001';
                }elseif ($value->pttype == 'M2') {
                    $claimServiceCode = 'PG0130001';
                }elseif ($value->pttype == 'M3') {
                    $claimServiceCode = 'PG0130001';
                }elseif ($value->pttype == 'M4') {
                    $claimServiceCode = 'PG0130001';
                }elseif ($value->pttype == 'M5') {
                    $claimServiceCode = 'PG0130001';
                } else {
                     $claimServiceCode = 'PG0060001';
                }


                $check_opd = Fdh_mini_dataset::where('vn', $value->vn)->count();
                if ($check_opd > 0) {
                    Fdh_mini_dataset::where('vn', $value->vn)->update([
                        // 'service_date_time'   => $value->vstdate . ' ' . $value->vsttime,
                        // 'cid'                 => $value->cid,
                        // 'hcode'               => $value->hcode,
                        // 'total_amout'         => $value->total_amout,
                        // 'invoice_number'      => $value->invoice_number,
                        'pttype'              => $value->pttype,
                        // 'rcpt_money'          => $value->rcpt_money,
                        // 'uc_money'            => $value->privilegeAmount,
                        // 'paid_money'          => $value->paidAmount,
                        'ovstost'             => $value->ovstost,
                        // 'mainInsclCode'       => $value->mainInsclCode,
                        // 'serviceDateTime'     => $timestampInMilliseconds,
                        // 'invoiceDateTime'     => $invoiceDateTime,
                        // 'transactionId'       => '10978'.$value->vn,
                        'totalAmount'         => $value->totalAmount,
                        'paidAmount'          => $value->paidAmount,
                        'privilegeAmount'     => $value->privilegeAmount,
                        // 'claimServiceCode'    => $claimServiceCode,
                        // 'sourceId'            => 'PK9999',
                        // 'code'                => $value->main_dep,
                        // 'name'                => $value->department,
                        // 'visitNumber'         => $value->vn,
                        // 'recorderPid'         => $cid_auth,
                    ]);
                } else {
                    Fdh_mini_dataset::insert([
                        'service_date_time'   => $value->vstdate . ' ' . $value->vsttime,
                        'cid'                 => $value->cid,
                        'hcode'               => $value->hcode,
                        'total_amout'         => $value->total_amout,
                        'invoice_number'      => $value->invoice_number,
                        'vn'                  => $value->vn,
                        'pttype'              => $value->pttype,
                        'ptname'              => $value->ptname,
                        'hn'                  => $value->hn,
                        'vstdate'             => $value->vstdate,
                        'vsttime'             => $value->vsttime,
                        'datesave'            => $date,
                        'user_id'             => $iduser,
                        'rcpt_money'          => $value->rcpt_money,
                        'uc_money'            => $value->privilegeAmount,
                        'paid_money'          => $value->paidAmount,
                        'ovstost'             => $value->ovstost,
                        'mainInsclCode'       => $value->mainInsclCode,
                        'serviceDateTime'     => $timestampInMilliseconds,
                        'invoiceDateTime'     => $invoiceDateTime,
                        'transactionId'       => '10978'.$value->vn,
                        'totalAmount'         => $value->totalAmount,
                        'paidAmount'          => $value->paidAmount,
                        'privilegeAmount'     => $value->privilegeAmount,
                        'claimServiceCode'    => $claimServiceCode,
                        'sourceId'            => 'PK9999',
                        'code'                => $value->main_dep,
                        'name'                => $value->department,
                        'visitNumber'         => $value->vn,
                        'recorderPid'         => $cid_auth,
                    ]);
                }

                // $check_opdsit = Check_sit_auto::where('vn', $value->vn)->count();
                // if ( $check_opdsit > 0) {
                // } else {
                //     Check_sit_auto::insert([
                //         'cid'                 => $value->cid,
                //         'hospmain'            => $value->hcode,
                //         'debit'               => $value->total_amout,
                //         'vn'                  => $value->vn,
                //         'pttype'              => $value->pttype,
                //         'fullname'            => $value->ptname,
                //         'hn'                  => $value->hn,
                //         'vstdate'             => $value->vstdate,
                //         'vsttime'             => $value->vsttime,
                //     ]);
                // }

            }
        }
        // $data['fdh_mini_dataset']    = DB::connection('mysql')->select('SELECT * from fdh_mini_dataset WHERE active ="N" ORDER BY total_amout DESC');
        return response()->json([
            'status'     => '200'
        ]);
    }

    // ************************** จองเคลม ****************************
    //Mini Dataset
    public function mini_dataset(Request $request)
    {
        $id = $request->ids;
        $iduser = Auth::user()->id;
        $data_vn_1 = Fdh_mini_dataset::whereIn('fdh_mini_dataset_id', explode(",", $id))->get();
        $data_token_ = DB::connection('mysql')->select('SELECT * FROM api_neweclaim WHERE active_mini = "Y" ORDER BY updated_at desc limit 1');
        foreach ($data_token_ as $key => $val_to) {
            $token_   = $val_to->api_neweclaim_token;
        }
        $token = $token_;

        foreach ($data_vn_1 as $key => $val) {
            $dateString = $val->vstdate." ".$val->vsttime;
            $dateTime = new DateTime($dateString);
            $service_date_time_      = $val->service_date_time;
            $service_date_time    = substr($service_date_time_,0,16);
            $cid                  = $val->cid;
            $hcode                = $val->hcode;
            $total_amout          = $val->total_amout;
            $invoice_number       = $val->invoice_number;
            $vn                   = $val->vn;

                // *************** mini dataset **********
                $curl = curl_init();
                $postData_send = [
                    "service_date_time"  => $service_date_time,
                    "cid"                => $cid,
                    "hcode"              => $hcode,
                    "total_amout"        => $total_amout,
                    "invoice_number"     => $invoice_number,
                    "vn"                 => $vn
                ];
                curl_setopt($curl, CURLOPT_URL,"https://fdh.moph.go.th/api/v1/reservation");
                curl_setopt($curl, CURLOPT_POST, 1);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($postData_send, JSON_UNESCAPED_SLASHES));
                curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                    'Content-Type: application/json',
                    'Authorization: Bearer '.$token,
                    'Cookie: __cfruid=bedad7ad2fc9095d4827bc7be4f52f209543768f-1714445470'
                ));
                $server_output     = curl_exec ($curl);
                $statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
                $content = $server_output;
                $result = json_decode($content, true);
                @$status = $result['status'];
                @$message = $result['message'];
                @$data = $result['data'];
                @$uid = $data['transaction_uid'];
                if (@$message == 'success') {
                        Fdh_mini_dataset::where('vn', $vn)
                        ->update([
                            'transaction_uid' =>  @$uid,
                            'active'          => 'Y'
                        ]);
                } elseif ($status == '400') {
                        Fdh_mini_dataset::where('vn', $vn)
                            ->update([
                                'transaction_uid' =>  @$uid,
                                'active'          => 'Y'
                            ]);
                } else {
                }

            }
            // dd($result);
            return response()->json([
                'status'    => '200'
            ]);

    }
    // END POINT
    public function nhso_endpoint(Request $request)
    {
        $id          = $request->ids;
        $iduser      = Auth::user()->id;
        $cid_auth    = Auth::user()->cid;
        $datenow     = date('Y-m-d');
        // dd($id);
        $data_vn_1 = Fdh_mini_dataset::whereIn('fdh_mini_dataset_id', explode(",", $id))->get();
        $data_token_ = DB::connection('mysql')->select(' SELECT * FROM api_neweclaim WHERE user_id = "'.$iduser.'"');
        foreach ($data_token_ as $key => $val_to) {
            $username     = $val_to->api_neweclaim_user;
            $password     = $val_to->api_neweclaim_pass;
            $token        = $val_to->new_eclaim_token;
        }

        // dd($data_vn_1);
            foreach ($data_vn_1 as $key => $val) {
                $dateString = $val->vstdate." ".$val->vsttime;
                $dateTime = new DateTime($dateString);
                $timestampInSeconds = $dateTime->getTimestamp();
                $timestampInMilliseconds_ = $timestampInSeconds * 1000;
                $invoiceDateTime_ = (new DateTime())->format('Uv'); #current_time

                $service_date_time_   = $val->service_date_time;
                $service_date_time    = substr($service_date_time_,0,16);
                $serviceDateTime      = $val->serviceDateTime;
                $invoiceDateTime      = $val->invoiceDateTime;
                $hcode                = $val->hcode;
                $vn                   = $val->vn;
                $cid                  = $val->cid;
                $transactionld        = $val->transaction_uid;
                $mainInsclCode        = $val->mainInsclCode;

                $paidAmount           = number_format($val->paidAmount, 2);
                $privilegeAmount      = number_format($val->privilegeAmount, 2);
                $totalAmount          = number_format($val->totalAmount, 2);

                $claimServiceCode     = $val->claimServiceCode;
                $transactionId        = $val->transactionId;
                $sourceId             = $val->sourceId;
                $recorderPid          = $val->recorderPid;
                $visitNumber          = $val->visitNumber;
                $code                 = $val->code;
                $name                 = $val->name;

                $token_end = "b4df8b7c-c8c2-445a-a904-960aa4a1a1c9";

                $curl = curl_init();
                $postData_send = [
                    "hcode" => "$hcode",
                    "department" => [
                      "code" => "$code",
                      "name" => "$name"
                    ],
                    "mainInsclCode"    => "$mainInsclCode",
                    "serviceDateTime"  => ($serviceDateTime+0),
                    "invoiceDateTime"  => ($invoiceDateTime+0),
                    "transactionId"    => "$transactionId",
                    "totalAmount"      => $totalAmount,
                    "paidAmount"       => $paidAmount,
                    "privilegeAmount"  => $privilegeAmount,
                    "claimServiceCode" => $claimServiceCode,
                    "pid"              => "$cid",
                    "sourceId"         => "$sourceId",
                    "visitNumber"      => "$visitNumber",
                    "recorderPid"      => "$recorderPid"
                  ];
                // dd($postData_send);
                // $curl = curl_init();
                curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://nhsoapi.nhso.go.th/nhsoendpoint/api/nhso-claim-detail',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => json_encode($postData_send, JSON_UNESCAPED_SLASHES),
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json',
                    'Authorization: Bearer '.$token_end
                ),
                ));
                $response = curl_exec($curl);
                $result = json_decode($response, true);

                @$seq = $result['seq'];
                @$authenCode = $result['authenCode'];
                #echo $transaction_uid;
                // dd($result);

            }

        return response()->json([
            'status'    => '200'
        ]);
    }

    public function nhso_endpoint___(Request $request)
    {
        $id          = $request->ids;
        $iduser      = Auth::user()->id;
        $cid_auth    = Auth::user()->cid;
        $datenow     = date('Y-m-d');
        // dd($id);
        $data_vn_1 = Fdh_mini_dataset::whereIn('fdh_mini_dataset_id', explode(",", $id))->get();
        // ->where('invoice_number','<>',NULL)
        // $data_vn_1 = Fdh_mini_dataset::whereIn('fdh_mini_dataset_id', explode(",", $id))->get();
        // $data_vn_1   = DB::connection('mysql')->select('SELECT * FROM fdh_mini_dataset WHERE vstdate = "'.$datenow.'"');
        // $data_token_ = DB::connection('mysql')->select('SELECT * FROM api_neweclaim WHERE active_mini = "Y" ORDER BY updated_at desc limit 1');
        // foreach ($data_token_ as $key => $val_to) {
        //     $token_   = $val_to->api_neweclaim_token;
        // }
        // $token = $token_;

        // dd($data_vn_1);
            foreach ($data_vn_1 as $key => $val) {
                $dateString = $val->vstdate." ".$val->vsttime;
                $dateTime = new DateTime($dateString);
                $timestampInSeconds = $dateTime->getTimestamp();
                $timestampInMilliseconds = $timestampInSeconds * 1000;
                $invoiceDateTime = (new DateTime())->format('Uv'); #current_time

                $service_date_time_   = $val->service_date_time;
                $service_date_time    = substr($service_date_time_,0,16);
                $hcode                = $val->hcode;
                $vn                   = $val->vn;
                $cid                  = $val->cid;
                $transactionld        = $val->transaction_uid;
                $mainInsclCode        = $val->mainInsclCode;
                $total_amout          = $val->total_amout;
                $invoice_number       = $val->invoice_number;
                $paidAmount           = number_format($val->rcpt_money, 2, '.', '');
                $privilegeAmount      = number_format($val->uc_money, 2, '.', '');
                $totalAmount          = number_format($val->totalAmount, 2, '.', '');
                $claimtype            = $val->claimtype;
                $transactionId        = $val->transactionId;
                $recorderPid          = $val->recorderPid;

                $fdh_jwt = "b4df8b7c-c8c2-445a-a904-960aa4a1a1c9";
                // $fdh_jwt = "3045bba2-3cac-4a74-ad7d-ac6f7b187479";
                // 'Authorization: Bearer '.$fdh_jwt
                $postData_send = [
                    "hcode"      => "$hcode",
                    "department" => array(
                    "code"     => "",
                    "name"     => ""
                    ),
                    "mainInsclCode"    => "$mainInsclCode",
                    "serviceDateTime"  => $timestampInMilliseconds,
                    "invoiceDateTime"  => $invoiceDateTime,
                    "transactionId"    => "$transactionId",
                    "totalAmount"      => $totalAmount,
                    "paidAmount"       => $paidAmount,
                    "privilegeAmount"  => $privilegeAmount,
                    "claimServiceCode" => $claimtype,
                    "pid"              => "$cid",
                    "sourceId"         => "9999",
                    "visitNumber"      => "$vn",
                    "recorderPid"      => $recorderPid
                ];

                $curl = curl_init();

                curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://nhsoapi.nhso.go.th/nhsoendpoint/api/nhso-claim-detail',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => json_encode($postData_send, JSON_UNESCAPED_SLASHES),
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json',
                    'Authorization: Bearer  b4df8b7c-c8c2-445a-a904-960aa4a1a1c9'
                ),
                ));
                $response = curl_exec($curl);
                $result = json_decode($response, true);
                #echo $message_th = $result['message_th'];
                #@$transaction_uid = $result['data']["transaction_uid"];
                @$seq = $result['seq'];
                @$authenCode = $result['authenCode'];
                #echo $transaction_uid;
                dd($response);
                // return response()->json([
                //     'status'    => '200'
                // ]);
            }

        // return response()->json([
        //     'status'    => '200'
        // ]);
    }
                // $response = Http::withHeaders([
                //     'Authorization : Bearer '.$token,
                //     'User-Agent:<platform>/<version> <10978>',
                //     'Accept' => 'application/json',
                // ])->post('https://nhsoapi.nhso.go.th/nhsoendpoint/api/nhso-claim-detail', [
                //     "hcode"              => $hcode,
                //     "visitNumber"        => $vn,
                //     "pid"                => $cid,
                //     "transactionId"      => $transactionld,
                //     "serviceDateTime"    => $service_date_time,
                //     "invoiceDateTime"    => $service_date_time,
                //     "mainInsclCode"      => $mainInsclCode,
                //     "totalAmount"        => $total_amout,
                //     "paidAmount"         => $rcpt_money,
                //     "privilegeAmount"    => $uc_money,
                //     "claimServiceCode"   => $claimtype,
                //     "sourceId"           => 'PKOFFICE',
                //     // "computerName"       => $vn,
                //     "recorderPid"        => $cid_auth
                // ]);
                // $token = $response->json('token');
                // $body = $response->body();
                // dd($body);
                // dd($token);



                // $headers_send  = [
                //     'User-Agent:<platform>/<version> <10978>',
                //     'Content-Type: application/json'
                // ];
                // $postData_send = [
                //     // "service_date_time"  => $service_date_time,
                //     "hcode"              => $hcode,
                //     "visitNumber"        => $vn,
                //     "pid"                => $cid,
                //     "transactionId"      => $transactionld,
                //     "serviceDateTime"    => $service_date_time,
                //     "invoiceDateTime"    => $service_date_time,
                //     "mainInsclCode"      => $mainInsclCode,
                //     "totalAmount"        => $total_amout,
                //     "paidAmount"         => $rcpt_money,
                //     "privilegeAmount"    => $uc_money,
                //     "claimServiceCode"   => $claimtype,
                //     "sourceId"           => 'PKOFFICE',
                //     // "computerName"       => $vn,
                //     "recorderPid"        => $cid_auth,
                // ];
                // $ch = curl_init();
                // curl_setopt($ch, CURLOPT_URL,"https://nhsoapi.nhso.go.th/nhsoendpoint/api/nhso-claim-detail");
                // curl_setopt($ch, CURLOPT_POST, 1);
                // curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                // curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData_send, JSON_UNESCAPED_SLASHES));
                // curl_setopt($ch, CURLOPT_HTTPHEADER, $headers_send);
                // $response     = curl_exec ($ch);
                // $statusCode        = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                // // dd($statusCode);
                // $content           = $response;
                // $response     = curl_exec ($ch);
                // $contents    = $response;
                // $result   = json_decode($contents, true);
                // dd($result);
                // @$content = $result['content'];
                // @$status  = $result['status'];
                // @$message = $result['message'];
                // $token    = $result['token'];

                // $curl = curl_init();
                // curl_setopt_array($curl, array(
                // CURLOPT_URL => 'https://nhsoapi.nhso.go.th/nhsoendpoint/api/nhso-claim-detail?hcode=10978&visitNumber=670829073424&pid=3361000239995&transactionId=1c352ba2-5afe-4b61-a432-765dc2fb5bb6&serviceDateTime=2024-08-29%2007%3A34%3A24&invoiceDateTime=2024-08-29%2007%3A34%3A24&mainInsclCode=UCS&totalAmount=990&paidAmount=0&privilegeAmount=990&claimServiceCode=PG0060001',
                // CURLOPT_RETURNTRANSFER => true,
                // CURLOPT_ENCODING => '',
                // CURLOPT_MAXREDIRS => 10,
                // CURLOPT_TIMEOUT => 0,
                // CURLOPT_FOLLOWLOCATION => true,
                // CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                // CURLOPT_CUSTOMREQUEST => 'POST',
                // CURLOPT_HTTPHEADER => array(
                //     'Authorization: Bearer b4df8b7c-c8c2-445a-a904-960aa4a1a1c9',
                //     'Cookie: TS01304219=013bd252cbab02c3c6ba79ba47acbe2ce609e3ec7ce5b0563916b947d2b2ea01d317dd23a3de79511752a4ad3de7a03220659fa9c1'
                // ),
                // ));
                // $response = curl_exec($curl);
                // $statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
                // $content = $response;
                // $result = json_decode($content, true);
                // dd($result);




                // $postData_send = [
                //     // "service_date_time"  => $service_date_time,
                //     "hcode"              => $hcode,
                //     "visitNumber"        => $vn,
                //     "pid"                => $cid,
                //     "transactionId"      => $transactionld,
                //     "serviceDateTime"    => $service_date_time,
                //     "invoiceDateTime"    => $service_date_time,
                //     "mainInsclCode"      => $mainInsclCode,
                //     "totalAmount"        => $total_amout,
                //     "paidAmount"         => $rcpt_money,
                //     "privilegeAmount"    => $uc_money,
                //     "claimServiceCode"   => $claimtype,
                //     "sourceId"           => 'PKOFFICE',
                //     // "computerName"       => $vn,
                //     "recorderPid"        => $cid_auth,
                // ];
                // $headers_send  = [
                //     'Authorization : Bearer '.$token,
                //     'Content-Type: application/json',
                //     'User-Agent:<platform>/<version><10978>'
                // ];

                // $curl = curl_init();
                // curl_setopt($curl, CURLOPT_URL,"https://nhsoapi.nhso.go.th/nhsoendpoint/api/nhso-claim-detail");
                // curl_setopt($curl, CURLOPT_POST, 1);
                // curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                // curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($postData_send, JSON_UNESCAPED_SLASHES));
                // curl_setopt($curl, CURLOPT_HTTPHEADER, $headers_send);
                // // curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                // //     'Content-Type: application/json',
                // //     'Authorization: Bearer '.$token,
                // //     'Cookie: __cfruid=bedad7ad2fc9095d4827bc7be4f52f209543768f-1714445470'
                // // ));
                // $server_output     = curl_exec ($curl);
                // $statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
                // $content = $server_output;
                // $result = json_decode($content, true);

                // dd($content);

                // @$status = $result['status'];
                // @$message = $result['message'];
                // @$data = $result['data'];
                // @$uid = $data['transaction_uid'];

            // }
            // dd($result);
            // return response()->json([
            //     'status'    => '200'
            // ]);


    // }

    // MINI DATA SET FDH fdh_mini_dataset_apicliam
    public function fdh_mini_dataset_apicliam(Request $request)
    {
        $id = $request->ids;
        $iduser = Auth::user()->id;
        // $data_vn_1 = Fdh_mini_dataset::whereIn('fdh_mini_dataset_id', explode(",", $id))->where('invoice_number','<>',NULL)->get();
        $data_vn_1 = Fdh_mini_dataset::whereIn('fdh_mini_dataset_id', explode(",", $id))->get();
        // $data_vn_1 = DB::connection('mysql')->select('SELECT * FROM fdh_mini_dataset WHERE invoice_number IS NOT NULL AND vstdate = "'.$date_now.'"');
        // $data_token_ = DB::connection('mysql')->select('SELECT * FROM api_neweclaim WHERE user_id = "' . $iduser . '"');
        $data_token_ = DB::connection('mysql')->select('SELECT * FROM api_neweclaim WHERE active_mini = "Y" ORDER BY updated_at desc limit 1');
        foreach ($data_token_ as $key => $val_to) {
            $token_   = $val_to->api_neweclaim_token;
        }
        $token = $token_;
        // $startcount = 1;
        // $data_claim = array();
        foreach ($data_vn_1 as $key => $val) {
            $dateString = $val->vstdate." ".$val->vsttime;
            $dateTime = new DateTime($dateString);
            $timestampInSeconds = $dateTime->getTimestamp();
            $timestampInMilliseconds_ = $timestampInSeconds * 1000;
            $invoiceDateTime_ = (new DateTime())->format('Uv'); #current_time

            $service_date_time_      = $val->service_date_time;
            $service_date_time    = substr($service_date_time_,0,16);
            $cid                  = $val->cid;
            $hcode                = $val->hcode;
            $total_amout          = $val->total_amout;
            $invoice_number       = $val->invoice_number;
            $vn                   = $val->vn;

            $serviceDateTime      = $val->serviceDateTime;
            $invoiceDateTime      = $val->invoiceDateTime;
            // $transactionld        = $val->transaction_uid;
            $mainInsclCode        = $val->mainInsclCode;
            $paidAmount           = $val->paidAmount;
            $privilegeAmount      = $val->privilegeAmount;
            $totalAmount          = $val->totalAmount;
            $claimServiceCode     = $val->claimServiceCode;
            $transactionId        = $val->transactionId;
            $sourceId             = $val->sourceId;
            $recorderPid          = $val->recorderPid;
            $visitNumber          = $val->visitNumber;
            $code                 = $val->code;
            $name                 = $val->name;
            $token_end = "b4df8b7c-c8c2-445a-a904-960aa4a1a1c9";

                // *************** mini dataset **********
                $curl = curl_init();
                $postData_send = [
                    "service_date_time"  => $service_date_time,
                    "cid"                => $cid,
                    "hcode"              => $hcode,
                    "total_amout"        => $total_amout,
                    "invoice_number"     => $invoice_number,
                    "vn"                 => $vn
                ];
                curl_setopt($curl, CURLOPT_URL,"https://fdh.moph.go.th/api/v1/reservation");
                curl_setopt($curl, CURLOPT_POST, 1);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($postData_send, JSON_UNESCAPED_SLASHES));
                curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                    'Content-Type: application/json',
                    'Authorization: Bearer '.$token,
                    'Cookie: __cfruid=bedad7ad2fc9095d4827bc7be4f52f209543768f-1714445470'
                ));
                $server_output     = curl_exec ($curl);
                $statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
                $content = $server_output;
                $result = json_decode($content, true);
                @$status = $result['status'];
                @$message = $result['message'];
                @$data = $result['data'];
                @$uid = $data['transaction_uid'];
                if (@$message == 'success') {
                        Fdh_mini_dataset::where('vn', $vn)
                        ->update([
                            'transaction_uid' =>  @$uid,
                            'active'          => 'Y'
                        ]);
                } elseif ($status == '400') {
                        Fdh_mini_dataset::where('vn', $vn)
                            ->update([
                                'transaction_uid' =>  @$uid,
                                'active'          => 'Y'
                            ]);
                } else {
                }

                // *************** สปสช ENDF POINT **********
                $curl_spsch = curl_init();
                $postData = [
                    "hcode" => "$hcode",
                    "department" => [
                      "code" => "$code",
                      "name" => "$name"
                    ],
                    "mainInsclCode"    => "$mainInsclCode",
                    "serviceDateTime"  => ($serviceDateTime+0),
                    "invoiceDateTime"  => ($invoiceDateTime+0),
                    "transactionId"    => "$transactionId",
                    "totalAmount"      => $totalAmount,
                    "paidAmount"       => $paidAmount,
                    "privilegeAmount"  => $privilegeAmount,
                    "claimServiceCode" => $claimServiceCode,
                    "pid"              => "$cid",
                    "sourceId"         => "$sourceId",
                    "visitNumber"      => "$visitNumber",
                    "recorderPid"      => "$recorderPid"
                ];

                curl_setopt_array($curl_spsch, array(
                CURLOPT_URL => 'https://nhsoapi.nhso.go.th/nhsoendpoint/api/nhso-claim-detail',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => json_encode($postData, JSON_UNESCAPED_SLASHES),
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json',
                    'Authorization: Bearer '.$token_end
                ),
                ));
                $responses   = curl_exec($curl_spsch);
                $results     = json_decode($responses, true);
                // dd($results);
                // foreach ($results as $key => $vss) {
                //     $seq         = $vss['seq'];
                //     $authenCode  = $vss['authenCode'];
                // }
                @$seq         = $results['seq'];
                @$authenCode  = $results['authenCode'];
                @$dataError         = $results['dataError'];
                if (@$seq !='') {
                    Fdh_mini_dataset::where('vn',$vn)->update([
                        'authenCode'   => @$authenCode,
                        'seq'          => @$seq,
                        'active_nhso'  => 'Y'
                    ]);
              }
                if (@$dataError == 'พบข้อมูลซ้ำในระบบ') {
                    Fdh_mini_dataset::where('vn',$vn)->update([
                        'dataError'   => @$dataError,
                        'active_nhso'  => 'Y'
                    ]);
                } else {

                }




            }
            // dd($result);
            return response()->json([
                'status'    => '200'
            ]);

    }

    public function fdh_mini_dataset_rep(Request $request)
    {
        $startdate   = $request->startdate;
        $enddate     = $request->enddate;
        $date        = date('Y-m-d');
        $y           = date('Y') + 543;
        $newdays     = date('Y-m-d', strtotime($date . ' -1 days')); //ย้อนหลัง 1 วัน
        $newweek     = date('Y-m-d', strtotime($date . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
        $newDate     = date('Y-m-d', strtotime($date . ' -5 months')); //ย้อนหลัง 5 เดือน
        $newyear     = date('Y-m-d', strtotime($date . ' -1 year')); //ย้อนหลัง 1 ปี

        if ($startdate == '') {
            $data['fdh_mini_dataset']    = DB::connection('mysql')->select('SELECT * from fdh_mini_dataset WHERE vstdate BETWEEN "'.$newweek.'" AND "'.$date.'" AND transaction_uid IS NOT NULL AND id_booking IS NULL ORDER BY vstdate DESC');
        } else {
            $data['fdh_mini_dataset']    = DB::connection('mysql')->select('SELECT * from fdh_mini_dataset WHERE vstdate BETWEEN "'.$startdate.'" AND "'.$enddate.'" AND transaction_uid IS NOT NULL AND id_booking IS NULL ORDER BY vstdate DESC');
        }


        return view('fdh.fdh_mini_dataset_rep',$data, [
            'startdate'        => $startdate,
            'enddate'          => $enddate,
        ]);
    }
    public function fdh_mini_dataset_pulljong(Request $request)
    {
        $id = $request->ids;
        $iduser = Auth::user()->id;
        $data_vn_1 = Fdh_mini_dataset::whereIn('fdh_mini_dataset_id', explode(",", $id))->get();
        // $data_vn_1 = D_fdh::whereIn('d_fdh_id',explode(",",$id))->get();
        // $data_token_ = DB::connection('mysql')->select(' SELECT * FROM api_neweclaim WHERE user_id = "' . $iduser . '"');
        $data_token_ = DB::connection('mysql')->select('SELECT * FROM api_neweclaim WHERE active_mini = "Y" ORDER BY updated_at desc limit 1');
        foreach ($data_token_ as $key => $val_to) {
            $token_   = $val_to->api_neweclaim_token;
        }
        $token = $token_;

            foreach ($data_vn_1 as $key => $val) {
                $transaction_uid      = $val->transaction_uid;
                $hcode                = $val->hcode;

                    $curl = curl_init();
                    curl_setopt_array($curl, array(
                        CURLOPT_URL => 'https://fdh.moph.go.th/api/v1/reservation',
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => '',
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 0,
                        CURLOPT_FOLLOWLOCATION => true,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => 'GET',
                        CURLOPT_POSTFIELDS => '{
                            "transaction_uid": "'.$transaction_uid.'",
                            "hcode"          : "'.$hcode.'"
                        }',
                        CURLOPT_HTTPHEADER => array(
                            'Content-Type: application/json',
                            'Authorization: Bearer '.$token,
                            'Cookie: __cfruid=bedad7ad2fc9095d4827bc7be4f52f209543768f-1714445470'
                        ),
                    ));
                    $response = curl_exec($curl);
                    // dd($response);
                    $result            = json_decode($response, true);
                    @$status           = $result['status'];
                    @$message          = $result['message'];
                    @$data             = $result['data'];
                    @$uidrep           = $data['transaction_uid'];
                    @$id_booking       = $data['id_booking'];
                    @$uuid_booking     = $data['uuid_booking'];
                    // dd($message);
                    if (@$message == 'success') {
                            Fdh_mini_dataset::where('transaction_uid', $uidrep)
                            ->update([
                                'id_booking'     => @$id_booking,
                                'uuid_booking'   => @$uuid_booking
                            ]);
                    } elseif ($status == '400') {
                            Fdh_mini_dataset::where('transaction_uid', $uidrep)
                                ->update([
                                    'id_booking'     => @$id_booking,
                                    'uuid_booking'   => @$uuid_booking
                                ]);
                    } else {
                        # code...
                    }
            }
            // dd($result);
            return response()->json([
                'status'    => '200'
            ]);

    }

    public function fdh_mini_dataset_line(Request $request)
    {
           $date_now = date('Y-m-d');
           $iduser = "754";

           $count_visit_all_ = DB::connection('mysql')->select('SELECT COUNT(vn) as Cvn FROM fdh_mini_dataset WHERE vstdate = "'.$date_now.'" AND cid <>""');
           foreach ($count_visit_all_ as $key => $value) {
                $count_visit_all = $value->Cvn;
           }
           $sum_total_amount_ = DB::connection('mysql')->select('SELECT sum(total_amout) as sumtotal_amout FROM fdh_mini_dataset WHERE vstdate = "'.$date_now.'" AND cid <>""');
           foreach ($sum_total_amount_ as $key => $value5) {
                $sum_total_amount = $value5->sumtotal_amout;
           }
           $count_invoice_ = DB::connection('mysql')->select('SELECT COUNT(vn) as Cvn FROM fdh_mini_dataset WHERE vstdate = "'.$date_now.'" AND invoice_number IS NOT NULL AND cid <>""');
           foreach ($count_invoice_ as $key => $value2) {
                $count_invoice = $value2->Cvn;
           }
           $count_uuidnull_ = DB::connection('mysql')->select('SELECT COUNT(vn) as Cvn FROM fdh_mini_dataset WHERE vstdate = "'.$date_now.'" AND uuid_booking IS NULL AND cid <>""');
           foreach ($count_uuidnull_ as $key => $value3) {
                $count_uuidnull = $value3->Cvn;
           }
           $count_uuidnotnull_ = DB::connection('mysql')->select('SELECT COUNT(vn) as Cvn FROM fdh_mini_dataset WHERE vstdate = "'.$date_now.'" AND uuid_booking IS NOT NULL AND cid <>""');
           foreach ($count_uuidnotnull_ as $key => $value4) {
                $count_uuidnotnull = $value4->Cvn;
           }
           $jong_success_ = DB::connection('mysql')->select('SELECT COUNT(vn) as Cvn FROM fdh_mini_dataset WHERE vstdate = "'.$date_now.'" AND transaction_uid IS NOT NULL AND cid <>""');
           foreach ($jong_success_ as $key => $value6) {
                $jong_success = $value6->Cvn;
           }
           $jong_nosuccess_ = DB::connection('mysql')->select('SELECT COUNT(vn) as Cvn FROM fdh_mini_dataset WHERE vstdate = "'.$date_now.'" AND transaction_uid ="" AND cid <>""');
           foreach ($jong_nosuccess_ as $key => $value7) {
                $jong_nosuccess = $value7->Cvn;
           }
        //    $authen_success_ = DB::connection('mysql')->select('SELECT COUNT(vn) as Cvn FROM fdh_mini_dataset WHERE vstdate = "'.$date_now.'" AND claimcode IS NOT NULL');
        //    foreach ($authen_success_ as $key => $value8) {
        //         $authen_success = $value8->Cvn;
        //    }
           $authen_success_ = DB::connection('mysql10')->select(
            'SELECT COUNT(v.vn) Cvn,SUM(vv.income)-SUM(vv.discount_money)-SUM(vv.rcpt_money) as sumtotal_amout
                FROM visit_pttype v
                JOIN ovst o ON o.vn = v.vn
                JOIN vn_stat vv ON vv.vn = v.vn
                WHERE o.an IS NULL AND o.vstdate = "'.$date_now.'"
                AND (v.claim_code IS NOT NULL OR v.claim_code <> "")
                AND v.claim_code LIKE "PP%"
            ');
           foreach ($authen_success_ as $key => $value8) {
                $authen_success = $value8->Cvn;
           }
           $sum_total_authen_ = DB::connection('mysql10')->select(
            'SELECT COUNT(v.vn) Cvn,SUM(vv.income)-SUM(vv.discount_money)-SUM(vv.rcpt_money) as sumtotal_amout
            FROM visit_pttype v
            JOIN ovst o ON o.vn = v.vn
            JOIN vn_stat vv ON vv.vn = v.vn
            WHERE o.an IS NULL AND o.vstdate = "'.$date_now.'"
            AND (v.claim_code IS NOT NULL OR v.claim_code <> "")
            AND v.claim_code LIKE "PP%"');
           foreach ($sum_total_authen_ as $key => $value9) {
                $sum_total_authen = $value9->sumtotal_amout;
           }

           $pidsit_success_ = DB::connection('mysql')->select('SELECT COUNT(vn) as Cvn FROM fdh_mini_dataset WHERE vstdate = "'.$date_now.'" AND active_nhso ="Y"');
           foreach ($pidsit_success_ as $key => $value_p) {
                $pidsit_success = $value_p->Cvn;
           }
           $pidsit_sum_ = DB::connection('mysql')->select('SELECT sum(totalAmount) as totalAmount FROM fdh_mini_dataset WHERE vstdate = "'.$date_now.'" AND active_nhso ="Y"');
           foreach ($pidsit_sum_ as $key => $value_su) {
                $pidsit_total = $value_su->totalAmount;
           }
        //    privilegeAmount
           //แจ้งเตือน
            function DateThailine($strDate)
            {
                $strYear = date("Y", strtotime($strDate)) + 543;
                $strMonth = date("n", strtotime($strDate));
                $strDay = date("j", strtotime($strDate));

                $strMonthCut = array("", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
                $strMonthThai = $strMonthCut[$strMonth];
                return "$strDay $strMonthThai $strYear";
            }

            $header = "จองเคลม";
            // $linegroup = DB::table('line_token')->where('line_token_id', '=', 6)->first();
            // $line = $linegroup->line_token_code;

            $link = DB::table('orginfo')->where('orginfo_id', '=', 1)->first();
            $link_line = $link->orginfo_link;

            $datesend = date('Y-m-d');
            $sendate = DateThailine($datesend);
            $user = DB::table('users')->where('id', '=', $iduser)->first();

            function formatetime($strtime)
            {
                $H = substr($strtime, 0, 5);
                return $H;
            }

            $message = $header .
                "\n" . "วันที่ส่ง: " . $sendate.
                "\n" . "Visit All: " . $count_visit_all ." คน".
                 "\n" . "FDH-สำเร็จ : " . $jong_success ." คน".
                "\n" . "FDH-ไม่สำเร็จ : " .$jong_nosuccess ." คน".
                "\n" . "ยอดจอง-FDH : " . number_format($sum_total_amount, 2) . " บาท".
                "\n" . "มีเลข Invoice : " . $count_invoice ." คน".
                "\n" . "ดึงข้อมูลจอง : " . $count_uuidnotnull." คน".
                "\n" . "NHSO-สำเร็จ : " .$pidsit_success. " คน".
                 "\n" . "ยอดจอง-NHSO : " . number_format($pidsit_total, 2) . " บาท".
                  "\n" . "Authenสำเร็จ : " .$authen_success. " คน".
                "\n" . "ยอด Authen: " .number_format($sum_total_authen, 2) ." บาท";

            // $linesend = $line;
            $linesend = "DDpDNOOH6RowPLajt0JUzC2belFNcZOWZPx5lbG8kj1";
            if ($linesend == null) {
                $test = '';
            } else {
                $test = $linesend;
            }

            if ($test !== '' && $test !== null) {
                $chOne = curl_init();
                curl_setopt($chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify");
                curl_setopt($chOne, CURLOPT_SSL_VERIFYHOST, 0);
                curl_setopt($chOne, CURLOPT_SSL_VERIFYPEER, 0);
                curl_setopt($chOne, CURLOPT_POST, 1);
                curl_setopt($chOne, CURLOPT_POSTFIELDS, $message);
                curl_setopt($chOne, CURLOPT_POSTFIELDS, "message=$message");
                curl_setopt($chOne, CURLOPT_FOLLOWLOCATION, 1);
                $headers = array('Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer ' . $test . '',);
                curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($chOne, CURLOPT_RETURNTRANSFER, 1);
                $result = curl_exec($chOne);
                if (curl_error($chOne)) {
                    echo 'error:' . curl_error($chOne);
                } else {
                    $result_ = json_decode($result, true);
                    //return response()->json(['status'=>200]);
                }
                curl_close($chOne);
            }
            return redirect()->back();
        //    return response()->json('200');
    }

    // ***************************************** Mini Auto ************************************
    public function pidsit_pull(Request $request)
    {
        $startdate   = $request->startdate;
        $enddate     = $request->enddate;
        $date = date('Y-m-d');
        $newday = date('Y-m-d', strtotime($date . ' -2 days')); //
        $newweek = date('Y-m-d', strtotime($date . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
        $newDate = date('Y-m-d', strtotime($date . ' -1 months')); //ย้อนหลัง 1 เดือน
        $cid_auth    = Auth::user()->cid;
        if ($startdate == '') {
            $data['fdh_mini_dataset']    = DB::connection('mysql')->select(
                'SELECT * from fdh_mini_dataset
                    WHERE vstdate = "' . $date . '"
                    ORDER BY vn DESC');
        } else {
            $date = date('Y-m-d');
            $iduser = Auth::user()->id;
            $datashow_ = DB::connection('mysql10')->select(

                'SELECT o.vstdate,o.vsttime,Time_format(o.vsttime ,"%H:%i") vsttime2
                    ,pt.cid,"10978" as hcode,IFNULL(rd.total_amount,v.income) as total_amout
                    ,IFNULL(rd.finance_number,v.vn) as invoice_number,v.vn,concat(pt.pname,pt.fname," ",pt.lname) as ptname,v.hn,v.pttype
                    ,v.rcpt_money,v.uc_money,ptt.hipdata_code as mainInsclCode,IFNULL(o.main_dep,"155") as main_dep,IFNULL(k.department,"อายุรกรรมห้องตรวจ 3") as department

                    ,CONCAT(o.vstdate," ",DATE_FORMAT(o.vsttime,"%H:%i")) AS service_date_time,v.income as totalAmount
                    ,v.uc_money AS privilegeAmount,v.paid_money AS paidAmount,rd.finance_number as visitNumber,ov.name as ovstost
                    FROM vn_stat v
                    LEFT OUTER JOIN ovst o ON v.vn = o.vn
                    LEFT OUTER JOIN patient pt on pt.hn = v.hn
                    LEFT OUTER JOIN pttype ptt ON v.pttype=ptt.pttype
                    LEFT OUTER JOIN rcpt_debt rd ON v.vn = rd.vn
                    LEFT OUTER JOIN kskdepartment k ON k.depcode = o.main_dep
                    LEFT OUTER JOIN ovstost ov on ov.ovstost = o.ovstost
                    WHERE o.vstdate BETWEEN "' . $startdate . '" and "' . $enddate . '"
                    AND v.income > 0 AND pt.nationality = "99" AND (o.an IS NULL OR o.an ="")
                    GROUP BY o.vn
            '
            );
            // NOT IN("M1","M2","M3","M4","M5")  AND v.pttype NOT IN("M1","M4","M5")
            // ,IFNULL(rd.total_amount,v.income) as total_amout
            // ,IFNULL(rd.finance_number,v.vn) as invoice_number
            foreach ($datashow_ as $key => $value) {
                $dateString = $value->vstdate." ".$value->vsttime;
                $dateTime = new DateTime($dateString);
                $timestampInSeconds = $dateTime->getTimestamp();
                $timestampInMilliseconds = $timestampInSeconds * 1000;
                $invoiceDateTime = (new DateTime())->format('Uv'); #current_time

                if ($value->pttype == 'M1') {
                    $claimServiceCode = 'PG0130001';
                }elseif ($value->pttype == 'M2') {
                    $claimServiceCode = 'PG0130001';
                }elseif ($value->pttype == 'M3') {
                    $claimServiceCode = 'PG0130001';
                }elseif ($value->pttype == 'M4') {
                    $claimServiceCode = 'PG0130001';
                }elseif ($value->pttype == 'M5') {
                    $claimServiceCode = 'PG0130001';
                } else {
                     $claimServiceCode = 'PG0060001';
                }


                $check_opd = Fdh_mini_dataset::where('vn', $value->vn)->count();
                if ($check_opd > 0) {
                    Fdh_mini_dataset::where('vn', $value->vn)->update([
                        'total_amout'         => $value->total_amout,
                        'invoice_number'      => $value->invoice_number,
                        'pttype'              => $value->pttype,
                        'ovstost'             => $value->ovstost,
                        'totalAmount'         => $value->totalAmount,
                        'paidAmount'          => $value->paidAmount,
                        'privilegeAmount'     => $value->privilegeAmount,
                    ]);
                } else {
                    Fdh_mini_dataset::insert([
                        'service_date_time'   => $value->vstdate . ' ' . $value->vsttime,
                        'cid'                 => $value->cid,
                        'hcode'               => $value->hcode,
                        'total_amout'         => $value->total_amout,
                        'invoice_number'      => $value->invoice_number,
                        'vn'                  => $value->vn,
                        'pttype'              => $value->pttype,
                        'ptname'              => $value->ptname,
                        'hn'                  => $value->hn,
                        'vstdate'             => $value->vstdate,
                        'vsttime'             => $value->vsttime,
                        'datesave'            => $date,
                        'user_id'             => $iduser,
                        'rcpt_money'          => $value->rcpt_money,
                        'uc_money'            => $value->privilegeAmount,
                        'paid_money'          => $value->paidAmount,
                        'ovstost'             => $value->ovstost,
                        'mainInsclCode'       => $value->mainInsclCode,
                        'serviceDateTime'     => $timestampInMilliseconds,
                        'invoiceDateTime'     => $invoiceDateTime,
                        'transactionId'       => '10978'.$value->vn,
                        'totalAmount'         => $value->totalAmount,
                        'paidAmount'          => $value->paidAmount,
                        'privilegeAmount'     => $value->privilegeAmount,
                        'claimServiceCode'    => $claimServiceCode,
                        'sourceId'            => 'PK9999',
                        'code'                => $value->main_dep,
                        'name'                => $value->department,
                        'visitNumber'         => $value->vn,
                        'recorderPid'         => $cid_auth,
                    ]);
                }
            }
        }

        return response()->json([
            'status'     => '200'
        ]);
    }

    public function fdh_mini_dataset_authauto(Request $request)
    {
        $startdate = $request->startdate;
        $enddate = $request->enddate;

        $username        = 'pradit.10978';
        $password        = '8Uk&8Fr&';
        $password_hash   = strtoupper(hash_hmac('sha256', $password, '$jwt@moph#'));

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://fdh.moph.go.th/token?Action=get_moph_access_token&user=' . $username . '&password_hash=' . $password_hash . '&hospital_code=10978',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_HTTPHEADER => array(
                'Cookie: __cfruid=bedad7ad2fc9095d4827bc7be4f52f209543768f-1714445470'
            ),
        ));
        $token = curl_exec($curl);
        // dd($token);
        curl_close($curl);

        $check = Api_neweclaim::where('api_neweclaim_user', $username)->where('api_neweclaim_pass', $password)->count();
        if ($check > 0) {
            Api_neweclaim::where('api_neweclaim_user', $username)->update([
                'api_neweclaim_token'       => $token,
                'user_id'                   => Auth::user()->id,
                'password_hash'             => $password_hash,
                'hospital_code'             => '10978',
                'active_mini'               => 'Y',
            ]);
        } else {
            Api_neweclaim::insert([
                'api_neweclaim_user'        => $username,
                'api_neweclaim_pass'        => $password,
                'api_neweclaim_token'       => $token,
                'password_hash'             => $password_hash,
                'hospital_code'             => '10978',
                'active_mini'               => 'Y',
                'user_id'                   => Auth::user()->id,
            ]);
        }
        // return response()->json([
        //     'status'     => '200'
        // ]);
        return response()->json('200');
        // return view('fdh.fdh_mini_dataset_authauto', [
        //     'startdate'        => $startdate,
        //     'enddate'          => $enddate,
        // ]);
    }

    public function fdh_mini_dataset_pullauto(Request $request)
    {
            $date = date('Y-m-d');
            $datashow_ = DB::connection('mysql10')->select(
                'SELECT v.vstdate,o.vsttime
                    ,Time_format(o.vsttime ,"%H:%i") vsttime2
                    ,pt.cid,"10978" as hcode
                    ,rd.total_amount as total_amout_1
                    ,rd.finance_number as invoice_number_1
					,IFNULL(rd.total_amount,v.income) as total_amout
                    ,IFNULL(rd.finance_number,v.vn) as invoice_number
                    ,v.vn,concat(pt.pname,pt.fname," ",pt.lname) as ptname,v.hn,v.pttype
                    ,IFNULL(vp.claim_code,vp.auth_code) as authen_code
                    FROM vn_stat v
                    LEFT OUTER JOIN ovst o ON v.vn = o.vn
                    LEFT OUTER JOIN patient pt on pt.hn = v.hn
                    LEFT OUTER JOIN pttype ptt ON v.pttype=ptt.pttype
                    LEFT OUTER JOIN rcpt_debt rd ON v.vn = rd.vn
                    LEFT OUTER JOIN visit_pttype vp on vp.vn = o.vn
                WHERE o.vstdate = "' . $date . '"
                AND ptt.hipdata_code ="UCS" AND v.income > 0 AND pt.nationality = "99"
                AND (o.an IS NULL OR o.an ="") AND pt.birthday <> "'.$date.'"
                GROUP BY o.vn LIMIT 50
            ');

            foreach ($datashow_ as $key => $value) {
                $check_opd = Fdh_mini_dataset::where('vn', $value->vn)->count();
                if ($check_opd > 0) {
                    Fdh_mini_dataset::where('vn', $value->vn)->update([
                        'cid'                 => $value->cid,
                        'pttype'              => $value->pttype,
                        'total_amout'         => $value->total_amout,
                        'invoice_number'      => $value->invoice_number,
                        'claimcode'           => $value->authen_code,
                        'ptname'              => $value->ptname,
                        'hn'                  => $value->hn,
                        'vstdate'             => $value->vstdate,
                        'hcode'               => $value->hcode,
                    ]);
                } else {
                    Fdh_mini_dataset::insert([
                        'service_date_time'   => $value->vstdate . ' ' . $value->vsttime,
                        'cid'                 => $value->cid,
                        'hcode'               => $value->hcode,
                        'total_amout'         => $value->total_amout,
                        'invoice_number'      => $value->invoice_number,
                        'vn'                  => $value->vn,
                        'pttype'              => $value->pttype,
                        'ptname'              => $value->ptname,
                        'hn'                  => $value->hn,
                        'vstdate'             => $value->vstdate,
                        'vsttime'             => $value->vsttime,
                        'datesave'            => $date,
                        'claimcode'           => $value->authen_code,
                    ]);
                }
            }
            return response()->json('200');

    }

     // ************************** จองเคลม **************
     public function fdh_mini_dataset_apicliamauto(Request $request)
     {
        $date = date('Y-m-d');
        $iduser = "754";
        $data_vn_1 = DB::connection('mysql')->select('SELECT * from fdh_mini_dataset WHERE active ="N" AND cid <> "" AND (transaction_uid ="" OR transaction_uid IS NULL) AND invoice_number <>"" LIMIT 10');
        $data_token_ = DB::connection('mysql')->select('SELECT * FROM api_neweclaim WHERE active_mini = "Y" ORDER BY updated_at desc limit 1');
        foreach ($data_token_ as $key => $val_to) {
            $token_   = $val_to->api_neweclaim_token;
        }
        $token = $token_;
        $startcount = 1;
        $data_claim = array();
        foreach ($data_vn_1 as $key => $val) {
            $service_date_time_      = $val->service_date_time;
            $service_date_time    = substr($service_date_time_,0,16);
            $cid                  = $val->cid;
            $hcode                = $val->hcode;
            $total_amout          = $val->total_amout;
            $invoice_number       = $val->invoice_number;
            $vn                   = $val->vn;

            $curl = curl_init();
                $postData_send = [
                    "service_date_time"  => $service_date_time,
                    "cid"                => $cid,
                    "hcode"              => $hcode,
                    "total_amout"        => $total_amout,
                    "invoice_number"     => $invoice_number,
                    "vn"                 => $vn
                ];
                curl_setopt($curl, CURLOPT_URL,"https://fdh.moph.go.th/api/v1/reservation");
                curl_setopt($curl, CURLOPT_POST, 1);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($postData_send, JSON_UNESCAPED_SLASHES));
                curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                    'Content-Type: application/json',
                    'Authorization: Bearer '.$token,
                    'Cookie: __cfruid=bedad7ad2fc9095d4827bc7be4f52f209543768f-1714445470'
                ));

                $server_output     = curl_exec ($curl);
                $statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
                // dd($statusCode);
                $content = $server_output;
                $result = json_decode($content, true);
                #echo "<BR>";
                @$status = $result['status'];
                #echo "<BR>";
                @$message = $result['message'];
                @$data = $result['data'];
                @$uid = $data['transaction_uid'];
                #echo "<BR>";
                // dd(@$result);
                if (@$message == 'success') {
                        Fdh_mini_dataset::where('vn', $vn)
                        ->update([
                            'transaction_uid' =>  @$uid,
                            'active'          => 'Y'
                        ]);
                } elseif ($status == '400') {
                        Fdh_mini_dataset::where('vn', $vn)
                            ->update([
                                'transaction_uid' =>  @$uid,
                                'active'          => 'Y'
                            ]);
                } else {
                    # code...
                }
        }
        return response()->json('200');
     }

    public function fdh_mini_dataset_pulljongauto(Request $request)
    {
        $date = date('Y-m-d');
        $iduser = "754";
        $data_vn_1 = DB::connection('mysql')->select('SELECT * FROM fdh_mini_dataset WHERE invoice_number IS NOT NULL AND cid <>"" AND hcode <> "" AND id_booking IS NULL LIMIT 50');
        $data_token_ = DB::connection('mysql')->select('SELECT * FROM api_neweclaim WHERE active_mini = "Y" ORDER BY updated_at desc limit 1');
        foreach ($data_token_ as $key => $val_to) {
            $token_   = $val_to->api_neweclaim_token;
        }
        $token = $token_;
        foreach ($data_vn_1 as $key => $val) {
            $transaction_uid      = $val->transaction_uid;
            $hcode                = $val->hcode;

                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_URL => 'https://fdh.moph.go.th/api/v1/reservation',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'GET',
                    CURLOPT_POSTFIELDS => '{
                        "transaction_uid": "'.$transaction_uid.'",
                        "hcode"          : "'.$hcode.'"
                    }',
                    CURLOPT_HTTPHEADER => array(
                        'Content-Type: application/json',
                        'Authorization: Bearer '.$token,
                        'Cookie: __cfruid=bedad7ad2fc9095d4827bc7be4f52f209543768f-1714445470'
                    ),
                ));
                $response = curl_exec($curl);
                // dd($response);
                $result            = json_decode($response, true);
                @$status           = $result['status'];
                @$message          = $result['message'];
                @$data             = $result['data'];
                @$uidrep           = $data['transaction_uid'];
                @$id_booking       = $data['id_booking'];
                @$uuid_booking     = $data['uuid_booking'];
                if (@$message == 'success') {
                        Fdh_mini_dataset::where('transaction_uid', $uidrep)
                        ->update([
                            'id_booking'     => @$id_booking,
                            'uuid_booking'   => @$uuid_booking
                        ]);
                } elseif ($status == '400') {
                        Fdh_mini_dataset::where('transaction_uid', $uidrep)
                            ->update([
                                'id_booking'     => @$id_booking,
                                'uuid_booking'   => @$uuid_booking
                            ]);
                } else {
                    # code...
                }
        }
        return response()->json('200');
    }

    public function fdh_authen(Request $request)
    {
        $startdate   = $request->startdate;
        $enddate     = $request->enddate;
        $date        = date('Y-m-d');
        $y           = date('Y') + 543;
        $newdays     = date('Y-m-d', strtotime($date . ' -1 days')); //ย้อนหลัง 1 วัน
        $newweek     = date('Y-m-d', strtotime($date . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
        $newDate     = date('Y-m-d', strtotime($date . ' -5 months')); //ย้อนหลัง 5 เดือน
        $newyear     = date('Y-m-d', strtotime($date . ' -1 year')); //ย้อนหลัง 1 ปี

        if ($startdate == '') {

            // $data['fdh_mini_dataset']    = DB::connection('mysql')->select(
            //     'SELECT *
            //     FROM check_sit_auto
            //     WHERE vstdate BETWEEN "'.$newdays.'" AND "'.$date.'"
            //     AND (claimcode IS NULL OR claimcode ="")
            //     AND pttype NOT IN("M1","M2","M3","M4","M5","M6","O1","O2","O3","O4","O5","O6","L1","L2","L3","L4","L5","L6","13","23","91","X7","10","06","C4")
            //     GROUP BY vn
            // ');
            // vn,cid,hn,vstdate,pttype,claimcode,fullname,staff
            $data['fdh_mini_dataset'] = DB::connection('mysql10')->select(
                'SELECT c.vn,c.hn,p.cid,c.vstdate,concat(p.pname,p.fname," ",p.lname) as fullname,c.pttype,"" as subinscl,v.income as debit,vp.auth_code,"" as claimtype,v.hospmain
                ,p.hometel,c.hospsub,c.main_dep,"" as hmain,"" as hsub,"" as subinscl_name,c.staff,k.department,v.pdx
                from ovst c
                LEFT JOIN visit_pttype vp ON vp.vn = c.vn
                LEFT JOIN vn_stat v ON v.vn = c.vn
                LEFT JOIN patient p ON p.hn = v.hn
                LEFT JOIN kskdepartment k ON k.depcode = c.main_dep
                WHERE c.vstdate BETWEEN "'.$newdays.'" AND "'.$date.'"

                AND c.pttype NOT IN("13","23","91","X7","10","11","12","06","C4","L1","L2","L3","L4","l5","l6","A7","O1","O2","O3","O4","O5","O6","A7")

                AND v.pdx NOT IN("Z000") AND p.cid IS NOT NULL
                GROUP BY c.vn
            ');
            // AND vp.auth_code is null
            // AND c.main_dep NOT IN("011","036","107","078","020")
        } else {
            $data['fdh_mini_dataset'] = DB::connection('mysql10')->select(
                'SELECT c.vn,c.hn,p.cid,c.vstdate,concat(p.pname,p.fname," ",p.lname) as fullname,c.pttype,"" as subinscl,v.income as debit,vp.auth_code,"" as claimtype,v.hospmain
                ,p.hometel,c.hospsub,c.main_dep,"" as hmain,"" as hsub,"" as subinscl_name,c.staff,k.department,v.pdx
                from ovst c
                LEFT JOIN visit_pttype vp ON vp.vn = c.vn
                LEFT JOIN vn_stat v ON v.vn = c.vn
                LEFT JOIN patient p ON p.hn = v.hn
                LEFT JOIN kskdepartment k ON k.depcode = c.main_dep
                WHERE c.vstdate BETWEEN "'.$startdate.'" AND "'.$enddate.'"

                AND c.pttype NOT IN("13","23","91","X7","10","11","12","06","C4","L1","L2","L3","L4","l5","l6","A7","O1","O2","O3","O4","O5","O6","A7")

                AND v.pdx NOT IN("Z000") AND p.cid IS NOT NULL
                GROUP BY c.vn
            ');
            // AND (vp.auth_code is null OR vp.auth_code ="")
            // $data_vn_1 = DB::connection('mysql10')->select(
            //     'SELECT v.vn,p.hn,p.cid,v.vstdate,o.pttype,p.birthday,p.hometel,p.citizenship,p.nationality,v.pdx,o.hospmain,o.hospsub
            //     ,concat(p.pname,p.fname," ",p.lname) as fullname
            //     ,o.staff,op.name as sname,v.income-v.discount_money-v.rcpt_money as debit,v.income
            //     FROM vn_stat v
            //     LEFT JOIN visit_pttype vs on vs.vn = v.vn
            //     LEFT JOIN ovst o on o.vn = v.vn
            //     LEFT JOIN patient p on p.hn=v.hn
            //     LEFT JOIN pttype pt on pt.pttype=v.pttype
            //     LEFT JOIN opduser op on op.loginname = o.staff
            //     WHERE o.vstdate BETWEEN "'.$startdate.'" AND "'.$enddate.'"
            //     AND v.pttype NOT IN("13","23","91","X7","10","11","12","06","C4","L1","L2","L3","L4","l5","l6","A7","O1","O2","O3","O4","O5","O6","A7")
            //     AND p.cid IS NOT NULL AND p.nationality ="99" AND p.birthday <> "'.$startdate.'"
            //     AND v.income > 0
            //     GROUP BY o.vn
            // ');
            // AND v.pttype NOT IN("M1","M2","M3","M4","M5","M6","13","23","91","X7","10","11","12","06","C4","L1","L2","L3","L4","l5","l6","A7","O1","O2","O3","O4","O5","O6","A7")
            // AND (vs.claim_code IS NULL OR vs.claim_code ="")
            // foreach ($data_vn_1 as $key => $value_1) {
            //     $check = Check_sit_auto::where('vn', $value_1->vn)->count();
            //         if ($check > 0) {
            //             Check_sit_auto::where('vn', $value_1->vn)->update([
            //                 'vstdate'    => $value_1->vstdate,
            //                 'pttype'     => $value_1->pttype,
            //                 'debit'      => $value_1->debit,
            //                 'debit'      => $value_1->income,
            //             ]);
            //         } else {
            //             Check_sit_auto::insert([
            //                 'vn'         => $value_1->vn,
            //                 'hn'         => $value_1->hn,
            //                 'cid'        => $value_1->cid,
            //                 'vstdate'    => $value_1->vstdate,
            //                 'hometel'    => $value_1->hometel,
            //                 'fullname'   => $value_1->fullname,
            //                 'pttype'     => $value_1->pttype,
            //                 'hospmain'   => $value_1->hospmain,
            //                 'hospsub'    => $value_1->hospsub,
            //                 'staff'      => $value_1->staff,
            //                 'debit'      => $value_1->debit,
            //                 'pdx'        => $value_1->pdx,
            //                 'debit'      => $value_1->income,
            //             ]);
            //         }
            //         // $check2 = Fdh_mini_dataset::where('vn', $value_1->vn)->count();
            //         // if ($check2 > 0) {
            //         // } else {
            //         //     Fdh_mini_dataset::insert([
            //         //         'vn'         => $value_1->vn,
            //         //         'hn'         => $value_1->hn,
            //         //         'cid'        => $value_1->cid,
            //         //         'vstdate'    => $value_1->vstdate,
            //         //         'hcode'      => '10978',
            //         //         'ptname'     => $value_1->fullname,
            //         //         'pttype'     => $value_1->pttype,
            //         //         'hospmain'   => $value_1->hospmain,
            //         //         'hospsub'    => $value_1->hospsub,
            //         //         'staff'      => $value_1->staff,
            //         //         'debit'      => $value_1->debit,
            //         // ]);
            //         // }


            // }

            // $data['fdh_mini_dataset']    = DB::connection('mysql')->select(
            //     'SELECT * FROM check_sit_auto
            //     WHERE vstdate BETWEEN "'.$startdate.'" AND "'.$enddate.'"
            //     AND (claimcode IS NULL OR claimcode ="")
            //     AND pttype NOT IN("M1","M2","M3","M4","M5","M6","O1","O2","O3","O4","O5","O6","L1","L2","L3","L4","L5","L6","13","23","91","X7","10","06","C4")
            //     GROUP BY vn
            // ');
            // $data['fdh_mini_dataset'] = DB::connection('mysql10')->select(
            //     'SELECT c.vn,c.hn,p.cid,c.vstdate,concat(p.pname,p.fname," ",p.lname) as fullname,c.pttype,"" as subinscl,v.income as debit,vp.claim_code,"" as claimtype,v.hospmain
            //     ,p.hometel,c.hospsub,c.main_dep,"" as hmain,"" as hsub,"" as subinscl_name,c.staff,k.department,v.pdx
            //     from ovst c
            //     LEFT JOIN visit_pttype vp ON vp.vn = c.vn
            //     LEFT JOIN vn_stat v ON v.vn = c.vn
            //     LEFT JOIN patient p ON p.hn = v.hn
            //     LEFT JOIN kskdepartment k ON k.depcode = c.main_dep
            //     WHERE c.vstdate BETWEEN "'.$startdate.'" AND "'.$enddate.'"
            //     AND vp.claim_code is null
            //     AND c.pttype NOT IN("M1","M2","M3","M4","M5","M6","13","23","91","X7","10","11","12","06","C4","L1","L2","L3","L4","l5","l6","A7","O1","O2","O3","O4","O5","O6","A7")
            //     AND c.main_dep NOT IN("011","036","107","078","020")
            //     AND v.pdx NOT IN("Z000") AND p.cid IS NOT NULL
            //     GROUP BY c.vn
            // ');

        }


        return view('fdh.fdh_authen',$data, [
            'startdate'        => $startdate,
            'enddate'          => $enddate,
        ]);
    }
    public function fdh_authen_pull(Request $request)
    {
        $startdate   = $request->startdate;
        $enddate     = $request->enddate;


                $iduser      = Auth::user()->id;
                $id          = $request->ids;
                // $data_vn_1 = Vn_stat::whereIn('vn',explode(",",$id))->get();
                $data_vn_1 = Vn_stat::select('cid','vn','vstdate')->whereIn('vn', explode(",", $id))->get();
                foreach ($data_vn_1 as $key => $value) {
                        $cid         = $value->cid;
                        $vn          = $value->vn;
                        $vstdate     = $value->vstdate;
                        $ch = curl_init();
                        $headers = array();
                        $headers[] = "Accept: application/json";
                        $headers[] = "Authorization: Bearer 3045bba2-3cac-4a74-ad7d-ac6f7b187479";
                        // curl_setopt($ch, CURLOPT_URL, "https://authenucws.nhso.go.th/authencodestatus/api/check-authen-status?personalId=$cid&serviceDate=$vstdate&serviceCode=PG0060001");
                        // curl_setopt($ch, CURLOPT_URL, "https://nhso.go.th/authencodestatus/api/check-authen-status?personalId=$cid&serviceDate=$vstdate&serviceCode=PG0060001");
                        curl_setopt($ch, CURLOPT_URL, "https://authenucws.nhso.go.th/authencodestatus/api/check-authen-status?personalId=$cid&serviceDate=$vstdate&serviceCode=PG0060001");
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
                        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                        $response = curl_exec($ch);
                        $contents = $response;
                        $result = json_decode($contents, true);
                        // dd($result);
                        if ($result != null ) {
                                isset( $result['statusAuthen'] ) ? $statusAuthen = $result['statusAuthen'] : $statusAuthen = "";
                                if ($statusAuthen =='false') {
                                    $his = $result['serviceHistories'];
                                    // dd($his);
                                    foreach ($his as $key => $value_s) {
                                        $cd	           = $value_s["claimCode"];
                                        $sv_code	   = $value_s["service"]["code"];
                                        $sv_name	   = $value_s["service"]["name"];
                                        $hcode	       = $value_s["hospital"]["hcode"];
                                        $hname	       = $value_s["hospital"]["hname"];
                                        // dd($hname);
                                        Visit_pttype::where('vn','=', $vn)->where('hospmain','=', $hcode)
                                            ->update([
                                                // 'claim_code'     => $cd,
                                                'auth_code'      => $cd,
                                        ]);

                                        // Check_sit_auto::where('vn','=', $vn)
                                        //     ->update([
                                        //         'claimcode'     => $cd,
                                        //         'claimtype'     => $sv_code,
                                        //         'servicename'   => $sv_name,
                                        // ]);
                                        Fdh_mini_dataset::where('vn','=', $vn)->where('hcode','=', $hcode)
                                            ->update([
                                                'claimcode'     => $cd,
                                                'claimtype'     => $sv_code,
                                                'servicename'   => $sv_name,
                                        ]);

                                        // Visit_pttype_205::where('vn', $vn)
                                        //     ->update([
                                        //         'claim_code'     => $cd,
                                        //         'auth_code'      => $cd,
                                        // ]);
                                        // Visit_pttype_217::where('vn', $vn)
                                        //     ->update([
                                        //         'claim_code'     => $cd,
                                        //         'auth_code'      => $cd,
                                        // ]);

                                    }
                                }
                        }
                }


            // return response()->json('true');
            return response()->json([
                'status'    => '200'
            ]);

    }

    public function fdh_mini_dataset_destroy(Request $request)
    {
        $id = $request->ids;
        Fdh_mini_dataset::whereIn('fdh_mini_dataset_id',explode(",",$id))->delete();
        return response()->json([
            'status'    => '200'
        ]);
    }

    // ********************************** FDH AUTH *********************************
    // public function fdh_mini_dataset_authauto(Request $request)
    // {
    //     $startdate = $request->startdate;
    //     $enddate = $request->enddate;

    //     $username        = 'pradit.10978';
    //     $password        = '8Uk&8Fr&';
    //     $password_hash   = strtoupper(hash_hmac('sha256', $password, '$jwt@moph#'));

    //     $curl = curl_init();
    //     curl_setopt_array($curl, array(
    //         CURLOPT_URL => 'https://fdh.moph.go.th/token?Action=get_moph_access_token&user=' . $username . '&password_hash=' . $password_hash . '&hospital_code=10978',
    //         CURLOPT_RETURNTRANSFER => true,
    //         CURLOPT_ENCODING => '',
    //         CURLOPT_MAXREDIRS => 10,
    //         CURLOPT_TIMEOUT => 0,
    //         CURLOPT_FOLLOWLOCATION => true,
    //         CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    //         CURLOPT_CUSTOMREQUEST => 'POST',
    //         CURLOPT_HTTPHEADER => array(
    //             'Cookie: __cfruid=bedad7ad2fc9095d4827bc7be4f52f209543768f-1714445470'
    //         ),
    //     ));
    //     $token = curl_exec($curl);
    //     // dd($token);
    //     curl_close($curl);

    //     $check = Api_neweclaim::where('api_neweclaim_user', $username)->where('api_neweclaim_pass', $password)->count();
    //     if ($check > 0) {
    //         Api_neweclaim::where('api_neweclaim_user', $username)->update([
    //             'api_neweclaim_token'       => $token,
    //             // 'user_id'                   => Auth::user()->id,
    //             'password_hash'             => $password_hash,
    //             'hospital_code'             => '10978',
    //             'active_mini'               => 'Y',
    //         ]);
    //     } else {
    //         Api_neweclaim::insert([
    //             'api_neweclaim_user'        => $username,
    //             'api_neweclaim_pass'        => $password,
    //             'api_neweclaim_token'       => $token,
    //             'password_hash'             => $password_hash,
    //             'hospital_code'             => '10978',
    //             'active_mini'               => 'Y',
    //             // 'user_id'                   => Auth::user()->id,
    //         ]);
    //     }

    //     return response()->json('200');

    // }
}
