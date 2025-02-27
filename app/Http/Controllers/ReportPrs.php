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
use App\Models\Acc_1102050101_2166;
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
use App\Models\Acc_1102050102_603;
use App\Models\Acc_stm_prb;
use App\Models\Acc_stm_ti_totalhead;
use App\Models\Acc_stm_ti_excel;
use App\Models\Acc_stm_ofc;
use App\Models\acc_stm_ofcexcel;
use App\Models\Acc_stm_lgo;
use App\Models\Acc_stm_lgoexcel;
use App\Models\Check_sit_auto;
use App\Models\Acc_stm_ucs_excel;
use App\Models\Patient;
use App\Models\Oapp;  
use App\Models\Gas_list;
use App\Models\Air_report_dep;
use App\Models\Air_report_depexcel;
use App\Models\Air_stock_month;
use App\Models\Fire;
use App\Models\Product_spyprice;
use App\Models\Products;
use App\Models\Products_type;
use App\Models\Product_group;
use App\Models\Product_unit;
use App\Models\Products_category;
use App\Models\Air_report_ploblems_sub;
use App\Models\Product_prop;
use App\Models\Product_decline;
use App\Models\Department_sub_sub;
use App\Models\Products_vendor;
use App\Models\Status;
use App\Models\Air_plan_excel;
use App\Models\Air_plan;
use App\Models\Cctv_list;
use App\Models\Air_report_ploblems;
use App\Models\Air_repaire_supexcel;
use App\Models\Air_repaire_excel;
use App\Models\Article_status;
use App\Models\Air_repaire;
use App\Models\Air_list;
use App\Models\Product_buy;
use App\Models\Air_repaire_sub;
use App\Models\Air_repaire_ploblem;
use App\Models\Air_repaire_ploblemsub;
use App\Models\Air_maintenance;
use App\Models\Water_filter;
use App\Models\Product_budget;
use App\Models\Air_plan_month;
use App\Models\Air_temp_ploblem;
use App\Models\Air_edit_log;

use App\Models\Department;
use App\Models\Departmentsub;
use App\Models\Departmentsubsub;
use App\Models\Position;
use App\Models\Air_supplies;


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
use App\Models\Dent_appointment;
use App\Models\Dent_appointment_type;
use App\Models\P4p_workgroupset;
use SplFileObject;
use PHPExcel;
use PHPExcel_IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Reader\Exception;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Symfony\Component\Console\Output\Output;

date_default_timezone_set("Asia/Bangkok");


class ReportPrs extends Controller
 {
    // ***************** report********************************

    public function report_prs(Request $request)
    {
        $startdate        = $request->startdate;
        $enddate          = $request->enddate;
        $dabudget_year    = DB::table('budget_year')->where('active','=',true)->first();
        $leave_month_year = DB::table('leave_month')->orderBy('MONTH_ID', 'ASC')->get();
        $date             = date('Y-m-d');
        $y                = date('Y') + 543;
        $newweek = date('Y-m-d', strtotime($date . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
        $newDate = date('Y-m-d', strtotime($date . ' -5 months')); //ย้อนหลัง 5 เดือน
        $newyear = date('Y-m-d', strtotime($date . ' -1 year')); //ย้อนหลัง 1 ปี

        $data['users']    = DB::table('users')->get();
        $iduser        = Auth::user()->id;
        $month_id_      = $request->month_id;
        $bgs_year      = DB::table('budget_year')->where('years_now','Y')->first();
        $bg_yearnow    = $bgs_year->leave_year_id;
        if ($month_id_ != '') {
            $months_         = DB::table('air_plan_month')->where('air_plan_month_id',$month_id_)->first();
            $month_year      = $months_->years; 
            $month_s         = $months_->month_no; 
            $data['month_years']     = $months_->years;
            $data['month_ss']        = $months_->month_no;
            $data['count_air']      = Air_stock_month::where('months','Y')->where('years_th',$bg_yearnow)->count();
            $datashow = DB::select(
                'SELECT a.months,a.total_qty,a.years,a.years_th as years_ps,l.month_name as MONTH_NAME,a.bg_yearnow,a.air_stock_month_id
                FROM air_stock_month a
                LEFT JOIN months l on l.month_id = a.months
                WHERE a.bg_yearnow = "'.$month_year.'" AND a.months = "'.$month_s.'" ORDER BY a.air_stock_month_id ASC
            ');
        } else {        
            $datashow  = DB::select(
                'SELECT a.months,a.total_qty ,l.month_name as MONTH_NAME ,a.years ,a.years_th as years_ps ,a.bg_yearnow,a.air_stock_month_id
                FROM air_stock_month a
                LEFT JOIN months l on l.month_id = a.months
                WHERE a.bg_yearnow = "'.$bg_yearnow.'" ORDER BY a.air_stock_month_id ASC
            ');
            $data['count_air'] = Air_list::where('active','Y')->where('air_year',$bg_yearnow)->count(); 

        }
        $data['month_show']          = DB::table('months')->get();
        $data['air_plan_month']      = DB::table('air_plan_month')->where('active','Y')->get();

        $data['datashow_gas']        = DB::select(
            'SELECT a.*,b.*
            FROM gas_report a
            LEFT JOIN months b ON b.month_id = a.months
            WHERE bg_yearnow = "'.$bg_yearnow.'"
            GROUP BY gas_report_id
            ORDER BY gas_report_id ASC
        ');

        return view('support_prs.report_prs',$data,[
            'startdate'        => $startdate,
            'enddate'          => $enddate, 
            'datashow'         => $datashow,
            'month_id'         => $month_id_,
        ]);
    }

    public function report_prs_air(Request $request,$id)
    {
        $startdate     = $request->startdate;
        $enddate       = $request->enddate;
        $date_now      = date('Y-m-d');
        $y             = date('Y') + 543;
        $months        = date('m');
        $newdays       = date('Y-m-d', strtotime($date_now . ' -1 days')); //ย้อนหลัง 1 วัน
        $newweek       = date('Y-m-d', strtotime($date_now . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
        $newDate       = date('Y-m-d', strtotime($date_now . ' -1 months')); //ย้อนหลัง 1 เดือน
        $newyear       = date('Y-m-d', strtotime($date_now . ' -1 year')); //ย้อนหลัง 1 ปี
        $yearnew       = date('Y');
        $year_old      = date('Y')-1;
        $months_old    = ('10');
        $startdate_b   = (''.$year_old.'-10-01');
        $enddate_b     = (''.$yearnew.'-09-30');
        $iduser        = Auth::user()->id;
        $month_id_      = $request->month_id;
        $bgs_year      = DB::table('budget_year')->where('years_now','Y')->first();
        $bg_yearnow    = $bgs_year->leave_year_id;

                // $months_         = DB::table('air_plan_month')->where('air_plan_month_id',$id)->first();
                // $month_year      = $months_->years;
                // $month_s         = $months_->air_plan_month;

                $months_         = DB::table('air_stock_month')->where('air_stock_month_id',$id)->first();
                $month_year      = $months_->bg_yearnow;
                $month_s         = $months_->months;
                // dd($month_s);
                $data['month_years']     = $months_->bg_yearnow;
                $data['month_ss']        = $months_->months;
                $data['count_air']      = Air_stock_month::where('months','Y')->where('years_th',$bg_yearnow)->count();


                $datashow = DB::select(
                    'SELECT a.months,a.total_qty,a.years,a.years_th as years_ps,l.month_name as MONTH_NAME,a.bg_yearnow
                    FROM air_stock_month a
                    LEFT JOIN months l on l.month_no = a.months
                    WHERE a.bg_yearnow = "'.$month_year.'" AND a.months = "'.$month_s.'" ORDER BY a.air_stock_month_id ASC
                ');

        $data['month_show']          = DB::table('months')->get();
        $data['air_plan_month']      = DB::table('air_plan_month')->where('active','Y')->get();

        // ผอ **************
        $orgpo = DB::table('orginfo')->where('orginfo_id', '=', 1)
            ->leftjoin('users', 'users.id', '=', 'orginfo.orginfo_po_id')
            ->leftjoin('users_prefix', 'users_prefix.prefix_code', '=', 'users.pname')
            ->first();
        $po = $orgpo->prefix_name . ' ' . $orgpo->fname . '  ' . $orgpo->lname;

        // รอง บ
        $rong = DB::table('orginfo')->where('orginfo_id', '=', 1)
        ->leftjoin('users', 'users.id', '=', 'orginfo.orginfo_manage_id')
        ->leftjoin('users_prefix', 'users_prefix.prefix_code', '=', 'users.pname')
        ->first();
        // $rong_bo  = $rong->prefix_name . ' ' . $rong->fname . '  ' . $rong->lname;
        $rong_bo  = $rong->prefix_name . ' ' . $rong->fname . '  ' . $rong->lname;
        $sigrong_ = $rong->signature; //หัวหน้าบริหาร

         // ผู้รายงาน **************
         $datafirst = DB::table('air_setting')->where('air_setting_id', '=','1')->first();
         $count_ = DB::table('users')->where('id', '=', $datafirst->staff_id)->count();
         if ($count_ !='') {
            
            $signa     = DB::table('users')->where('id', '=', $datafirst->staff_id)->leftjoin('users_prefix', 'users_prefix.prefix_id', '=', 'users.pname')->first();
            $ptname    = $signa->prefix_name . ' ' . $signa->fname . '   ' . $signa->lname;
            $position  = $signa->position_name;
            $siguser   = $signa->signature; //ผู้รองขอ
            // $sigstaff = $signature->signature_name_stafftext; //เจ้าหน้าที่
            // $sigrep = $signature->signature_name_reptext; //ผู้รับงาน
            // $sighn = $signature->signature_name_hntext; //หัวหน้า
            $sigrong = $sigrong_; //หัวหน้าบริหาร
         } else {
             # code...
         }

        $pdf = PDF::loadView('support_prs.report_prs_air',[
            'startdate'     => $startdate,
            'enddate'       => $enddate,
            'datashow'      => $datashow,
            'month_id'      => $month_id_,
            'rong_bo'       => $rong_bo,
            'po'            => $po,
            'position'      => $position,
            'ptname'        => $ptname,
        ])
        ->setPaper('a4', 'landscape');

        $dom_pdf = $pdf->getDomPDF();
        $canvas = $dom_pdf ->get_canvas();
        $canvas->page_text(510, 12, "Page {PAGE_NUM} of {PAGE_COUNT}", null, 10, array(255, 0, 0));
        return @$pdf->stream();
    }
    public function report_prs_gas(Request $request,$id)
    {
        $startdate           = $request->startdate;
        $enddate             = $request->enddate;
        $stock_listid        = $request->stock_list_id;
        $datenow             = date('Y-m-d');
        $data['date_now']    = date('Y-m-d');
        $months              = date('m');
        $year                = date('Y');
        $newday              = date('Y-m-d', strtotime($datenow . ' -5 Day')); //ย้อนหลัง 1 สัปดาห์
        $data['department']         = Department::get();
        $data['department_sub']     = Departmentsub::get();
        $data['department_sub_sub'] = Departmentsubsub::get();
        $data['position']           = Position::get();
        $data['status']             = Status::get();
        $data['air_supplies']       = Air_supplies::where('active','=','Y')->get();
        $data['wh_stock_list']      = DB::table('wh_stock_list')->where('stock_type','31')->where('active','=','Y')->get();

        $data['m']                  = date('H');
        $data['mm']                 = date('H:m:s');
        $data['datefull']           = date('Y-m-d H:m:s');
        $data['monthsnew']          = substr($months,1,2);
        $yy1                        = date('Y') + 543;
        $yy2                        = date('Y') + 542;
        $yy3                        = date('Y') + 541;
        $bgs_year      = DB::table('budget_year')->where('years_now','Y')->first();
        $bg_yearnow    = $bgs_year->leave_year_id;
 
        $datashow   = DB::select('SELECT a.*,b.*
            FROM gas_report a
            LEFT JOIN months b ON b.month_id = a.months
            WHERE gas_report_id = "'.$id.'"
            GROUP BY gas_report_id
            ORDER BY gas_report_id ASC 
        ');
         // ผอ **************
         $orgpo = DB::table('orginfo')->where('orginfo_id', '=', 1)
            ->leftjoin('users', 'users.id', '=', 'orginfo.orginfo_po_id')
            ->leftjoin('users_prefix', 'users_prefix.prefix_code', '=', 'users.pname')
            ->first();
        $po = $orgpo->prefix_name . ' ' . $orgpo->fname . '  ' . $orgpo->lname;

        // รอง บ
        $rong = DB::table('orginfo')->where('orginfo_id', '=', 1)
        ->leftjoin('users', 'users.id', '=', 'orginfo.orginfo_manage_id')
        ->leftjoin('users_prefix', 'users_prefix.prefix_code', '=', 'users.pname')
        ->first();
        // $rong_bo  = $rong->prefix_name . ' ' . $rong->fname . '  ' . $rong->lname;
        $rong_bo  = $rong->prefix_name . ' ' . $rong->fname . '  ' . $rong->lname;
        $sigrong_ = $rong->signature; //หัวหน้าบริหาร

        // ผู้รายงาน **************
        $datafirst = DB::table('air_setting')->where('air_setting_id', '=','10')->first();
        $count_ = DB::table('users')->where('id', '=', $datafirst->staff_id)->count();
        if ($count_ !='') {
           
           $signa     = DB::table('users')->where('id', '=', $datafirst->staff_id)->leftjoin('users_prefix', 'users_prefix.prefix_id', '=', 'users.pname')->first();
           $ptname    = $signa->prefix_name . ' ' . $signa->fname . '   ' . $signa->lname;
           $position  = $signa->position_name;
           $siguser   = $signa->signature; //ผู้รองขอ 
           $sigrong = $sigrong_; //หัวหน้าบริหาร
        } else {
            # code...
        }

        $pdf = PDF::loadView('support_prs.report_prs_gas',[
            'startdate'     => $startdate,
            'enddate'       => $enddate,
            'datashow'      => $datashow, 
            'rong_bo'       => $rong_bo,
            'po'            => $po,
            'position'      => $position,
            'ptname'        => $ptname,
        ])
        ->setPaper('a4', 'landscape');

        $dom_pdf = $pdf->getDomPDF();
        $canvas = $dom_pdf ->get_canvas();
        $canvas->page_text(510, 12, "Page {PAGE_NUM} of {PAGE_COUNT}", null, 10, array(255, 0, 0));
        return @$pdf->stream();



        // return view('support_prs.report_prs_gas',$data,[
        //     'startdate'     => $startdate,
        //     'enddate'       => $enddate,
        //     'bg_yearnow'    => $bg_yearnow,
        //     'stock_listid'  => $stock_listid
        // ]);
    }




 }
