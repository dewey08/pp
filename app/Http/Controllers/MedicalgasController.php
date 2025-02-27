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
use App\Models\Department;
use App\Models\Departmentsub;
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
use App\Models\Wh_recieve_sub;
use App\Models\Wh_unit;
use App\Models\Gas_list;
use App\Models\Gas_check;
use App\Models\Air_repaire_sub;
use App\Models\Gas_report;
use App\Models\Wh_stock;
use App\Models\Wh_stock_list;
use App\Models\Wh_recieve;
use App\Models\Air_supplies;
use App\Models\Position;
use App\Models\Departmentsubsub;
use App\Models\Gas_dot_control;
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
use Str;
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


class MedicalgasController extends Controller
 {
    public static function ref_gasnonumber()
    {
        $year = date('Y');
        $bgs_year      = DB::table('budget_year')->where('years_now','Y')->first();
        $bg_yearnow    = $bgs_year->leave_year_id;
        $maxnumber = DB::table('wh_recieve')->max('wh_recieve_id');
        if ($maxnumber != '' ||  $maxnumber != null) {
            $refmax = DB::table('wh_recieve')->where('wh_recieve_id', '=', $maxnumber)->first();
            if ($refmax->recieve_no != '' ||  $refmax->recieve_no != null) {
                $maxref = substr($refmax->recieve_no, -7) + 1;
            } else {
                $maxref = 1;
            }
            $ref = str_pad($maxref, 8, "0", STR_PAD_LEFT);
        } else {
            $ref = '00000001';
        }
        $ye = date('Y') + 543;
        $y = substr($ye, -2);
        $ynew   = substr($bg_yearnow,2,2);
        $ref_nonumber = $ynew.''.$ref;
        return $ref_nonumber;
    }

    public function medicalgas_db(Request $request)
    {
        $months = date('m');
        $year = date('Y');
        $startdate   = $request->startdate;
        $enddate     = $request->enddate;
        $date_now    = date('Y-m-d');
        $y           = date('Y') + 543;
        $data['budget_year'] = DB::table('budget_year')->get();
        $newdays     = date('Y-m-d', strtotime($date_now . ' -1 days')); //ย้อนหลัง 1 วัน
        $newweek     = date('Y-m-d', strtotime($date_now . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
        $newDate     = date('Y-m-d', strtotime($date_now . ' -1 months')); //ย้อนหลัง 1 เดือน
        $newyear     = date('Y-m-d', strtotime($date_now . ' -1 year')); //ย้อนหลัง 1 ปี
        $yearnew     = date('Y');
        $year_old    = date('Y')-1;
        $iduser      = Auth::user()->id;
        $bgs_year                   = DB::table('budget_year')->where('years_now','Y')->first();
        $data['bg_yearnow']         = $bgs_year->leave_year_id;
        $bg_yearnow                  = $bgs_year->leave_year_id;

        $data['wh_stock_list']         = DB::select(
            'SELECT b.stock_year,a.stock_list_id,a.stock_list_name,c.gas_type_name,b.stock_type
            -- ,(SELECT SUM(qty) FROM wh_recieve_sub WHERE stock_list_id = a.stock_list_id) as rec_total_qty
            -- ,(SELECT SUM(total_price) FROM wh_recieve_sub WHERE stock_list_id = a.stock_list_id) as rec_total_price
            -- ,(SELECT SUM(qty_pay) FROM wh_stock_export_sub WHERE stock_list_id = a.stock_list_id) as pay_total_qty
            -- ,(SELECT SUM(total_price) FROM wh_stock_export_sub WHERE stock_list_id = a.stock_list_id) as pay_total_price
            FROM wh_stock_list a
            LEFT JOIN wh_stock b ON b.stock_list_id = a.stock_list_id
            LEFT JOIN gas_type c ON c.gas_type_id = b.stock_type
            WHERE b.stock_year ="'.$bg_yearnow.'"
            AND a.stock_list_id ="10"
            GROUP BY b.stock_type
        ');
        // $datashow = DB::select(
        //     'SELECT s.air_supplies_id,s.supplies_name,COUNT(air_repaire_id) as c_repaire
        //         FROM air_repaire a
        //         LEFT JOIN air_list al ON al.air_list_id = a.air_list_id
        //         LEFT JOIN users p ON p.id = a.air_staff_id
        //         LEFT JOIN air_supplies s ON s.air_supplies_id = a.air_supplies_id
        //         GROUP BY a.air_supplies_id
        // ');

        // $data['count_air'] = Air_list::where('active','Y')->count();


        return view('support_prs.gas.medicalgas_db',$data,[
            'startdate'     => $startdate,
            'enddate'       => $enddate,
            // 'datashow'      => $datashow,
        ]);
    }
    public function medicalgas_list(Request $request)
    {
        $datenow = date('Y-m-d');
        $months = date('m');
        $year = date('Y');
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        $bgs_year      = DB::table('budget_year')->where('years_now','Y')->first();
        $bg_yearnow    = $bgs_year->leave_year_id;
        $datashow = DB::select('SELECT * FROM gas_list WHERE active ="Ready" ORDER BY gas_list_id DESC');
        // gas_year = "'.$bg_yearnow.'" AND
        // WHERE active="Y"
        return view('support_prs.gas.medicalgas_list',[
            'startdate'     => $startdate,
            'enddate'       => $enddate,
            'datashow'      => $datashow,
        ]);
    }
    public function gas_check_list(Request $request)
    {
        $datenow   = date('Y-m-d');
        $months    = date('m');
        $year      = date('Y');
        $startdate = $request->startdate;
        $enddate   = $request->enddate;
        $newweek   = date('Y-m-d', strtotime($datenow . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
        $newDate   = date('Y-m-d', strtotime($datenow . ' -1 months')); //ย้อนหลัง 1 เดือน
        $newyear   = date('Y-m-d', strtotime($datenow . ' -1 year')); //ย้อนหลัง 1 ปี
        $bgs_year      = DB::table('budget_year')->where('years_now','Y')->first();
        $bg_yearnow    = $bgs_year->leave_year_id;

        if ($startdate =='') {
            $datashow = DB::select(
                'SELECT a.gas_list_num,a.gas_list_name,a.detail,a.size
                ,b.check_year,b.check_date,b.check_time,b.gas_check_body,b.gas_check_body_name,b.gas_check_valve,b.gas_check_valve_name
                ,b.gas_check_pressure,b.gas_check_pressure_name,b.gas_check_pressure_min,b.gas_check_pressure_max,b.standard_value
                ,b.standard_value_min,b.standard_value_max,concat(p.fname," ",p.lname) as ptname
                FROM gas_check b
                LEFT JOIN gas_list a ON a.gas_list_id = b.gas_list_id
                LEFT JOIN users p ON p.id = a.user_id
                WHERE b.check_date BETWEEN "'.$newDate.'" AND "'.$datenow.'" AND a.gas_year = "'.$bg_yearnow.'"
                ORDER BY b.gas_check_id DESC
            ');
        } else {
            $datashow = DB::select(
                'SELECT a.gas_list_num,a.gas_list_name,a.detail,a.size
                ,b.check_year,b.check_date,b.check_time,b.gas_check_body,b.gas_check_body_name,b.gas_check_valve,b.gas_check_valve_name
                ,b.gas_check_pressure,b.gas_check_pressure_name,b.gas_check_pressure_min,b.gas_check_pressure_max,b.standard_value
                ,b.standard_value_min,b.standard_value_max,concat(p.fname," ",p.lname) as ptname
                FROM gas_check b
                LEFT JOIN gas_list a ON a.gas_list_id = b.gas_list_id
                LEFT JOIN users p ON p.id = a.user_id
                WHERE b.check_date BETWEEN "'.$startdate.'" AND "'.$enddate.'" AND a.gas_year = "'.$bg_yearnow.'"
                ORDER BY b.gas_check_id DESC
            ');
        }

        return view('support_prs.gas.gas_check_list',[
            'startdate'     => $startdate,
            'enddate'       => $enddate,
            'datashow'      => $datashow,
        ]);
    }
    public function gas_add(Request $request)
    {
        $datenow   = date('Y-m-d');
        $months    = date('m');
        $year      = date('Y');
        $startdate = $request->startdate;
        $enddate   = $request->enddate;
        $newweek   = date('Y-m-d', strtotime($datenow . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
        $newDate   = date('Y-m-d', strtotime($datenow . ' -1 months')); //ย้อนหลัง 1 เดือน
        $newyear   = date('Y-m-d', strtotime($datenow . ' -1 year')); //ย้อนหลัง 1 ปี

        $data_                  = DB::table('gas_list')->where('gas_type','1')->first();
        $data['gas_list_id']    = $data_->gas_list_id;
        $data['gas_type']       = $data_->gas_type;
        $data['budget_year']        = DB::table('budget_year')->orderBy('leave_year_id', 'DESC')->get();
        $data['product_unit']       = Product_unit::get();
        $data['product_brand']      = DB::table('product_brand')->get();
        $data['building_data']      = DB::table('building_data')->get();

        return view('support_prs.gas.gas_add',$data,[
            'startdate'     => $startdate,
            'enddate'       => $enddate,
            // 'data_edit'     => $data_edit,
        ]);
    }
    public function gas_save(Request $request)
    {
        $gas_listnum = $request->gas_list_num;
        $add                     = new Gas_list();
        $add->gas_year           = $request->gas_year;
        $add->gas_recieve_date   = $request->gas_recieve_date;
        $add->gas_list_num       = $gas_listnum;
        $add->gas_list_name      = $request->gas_list_name;
        $add->gas_price          = $request->gas_price;
        $add->active             = $request->active;
        $add->size               = $request->size;
        $add->class              = $request->class;
        $add->detail             = $request->detail;

        $loid = $request->input('location_id');
        if ($loid != '') {
            $losave = DB::table('building_data')->where('building_id', '=', $loid)->first();
            $add->location_id   = $losave->building_id;
            $add->location_name = $losave->building_name;
        } else {
            $add->location_id   = '';
            $add->location_name = '';
        }

        $branid = $request->input('gas_brand');
        if ($branid != '') {
            $bransave = DB::table('product_brand')->where('brand_id', '=', $branid)->first();
            $add->gas_brand = $bransave->brand_id;
        } else {
            $add->gas_brand = '';
        }

        $uniid = $request->input('gas_unit');
        if ($uniid != '') {
            $unisave = DB::table('product_unit')->where('unit_id', '=', $uniid)->first();
            $add->gas_unit = $unisave->unit_id;
        } else {
            $add->gas_unit = '';
        }

        if ($request->hasfile('gas_img')) {
            $image_64 = $request->file('gas_img');
            $extention = $image_64->getClientOriginalExtension();
            $filename = $gas_listnum. '.' . $extention;
            $request->gas_img->storeAs('gas', $filename, 'public');
            $add->gas_img            = $filename;
            $add->gas_imgname        = $filename;
            if ($extention =='.jpg') {
                $file64 = "data:image/jpg;base64,".base64_encode(file_get_contents($request->file('gas_img')));
            } else {
                $file64 = "data:image/png;base64,".base64_encode(file_get_contents($request->file('gas_img')));
            }
            $add->gas_img_base       = $file64;
        }

        $add->save();
        return response()->json([
            'status'     => '200'
        ]);
    }
    public function gas_edit(Request $request,$id)
    {
        $datenow   = date('Y-m-d');
        $months    = date('m');
        $year      = date('Y');
        $startdate = $request->startdate;
        $enddate   = $request->enddate;
        $newweek   = date('Y-m-d', strtotime($datenow . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
        $newDate   = date('Y-m-d', strtotime($datenow . ' -1 months')); //ย้อนหลัง 1 เดือน
        $newyear   = date('Y-m-d', strtotime($datenow . ' -1 year')); //ย้อนหลัง 1 ปี

        $data_                  = DB::table('gas_list')->where('gas_type','1')->first();
        $data['gas_list_id']    = $data_->gas_list_id;
        $data['gas_type']       = $data_->gas_type;
        $data['budget_year']        = DB::table('budget_year')->orderBy('leave_year_id', 'DESC')->get();
        $data['product_unit']       = Product_unit::get();
        $data['product_brand']      = DB::table('product_brand')->get();
        $data['building_data']      = DB::table('building_data')->get();

        $data_edit              = DB::table('gas_list')->where('gas_list_id',$id)->first();

        return view('support_prs.gas.gas_edit',$data,[
            'startdate'     => $startdate,
            'enddate'       => $enddate,
            'data_edit'     => $data_edit,
        ]);
    }
    public function gas_update(Request $request)
    {
        $id = $request->gas_list_id;
        $gas_listnum = $request->gas_list_num;
        $update                     = Gas_list::find($id);
        $update->gas_year           = $request->gas_year;
        $update->gas_recieve_date   = $request->gas_recieve_date;
        $update->gas_list_num       = $gas_listnum;
        $update->gas_list_name      = $request->gas_list_name;
        $update->gas_price          = $request->gas_price;
        $update->active             = $request->active;
        $update->size               = $request->size;
        $update->class              = $request->class;
        $update->detail             = $request->detail;

        $loid = $request->input('location_id');
        if ($loid != '') {
            $losave = DB::table('building_data')->where('building_id', '=', $loid)->first();
            $update->location_id   = $losave->building_id;
            $update->location_name = $losave->building_name;
        } else {
            $update->location_id   = '';
            $update->location_name = '';
        }

        $branid = $request->input('gas_brand');
        if ($branid != '') {
            $bransave = DB::table('product_brand')->where('brand_id', '=', $branid)->first();
            $update->gas_brand = $bransave->brand_id;
        } else {
            $update->gas_brand = '';
        }

        $uniid = $request->input('gas_unit');
        if ($uniid != '') {
            $unisave = DB::table('product_unit')->where('unit_id', '=', $uniid)->first();
            $update->gas_unit = $unisave->unit_id;
        } else {
            $update->gas_unit = '';
        }

        if ($request->hasfile('gas_img')) {
            $description = 'storage/gas/' . $update->gas_img;
            if (File::exists($description)) {
                File::delete($description);
            }
            $image_64 = $request->file('gas_img');
            $extention = $image_64->getClientOriginalExtension();
            $filename = $gas_listnum. '.' . $extention;
            $request->gas_img->storeAs('gas', $filename, 'public');
            $update->gas_img            = $filename;
            $update->gas_imgname        = $filename;
            if ($extention =='.jpg') {
                $file64 = "data:image/jpg;base64,".base64_encode(file_get_contents($request->file('gas_img')));
            } else {
                $file64 = "data:image/png;base64,".base64_encode(file_get_contents($request->file('gas_img')));
            }
            $update->gas_img_base       = $file64;
        }

        $update->save();
        return response()->json([
            'status'     => '200'
        ]);
    }

    // Tank Main
    public function gas_check_tank(Request $request)
    {
        $datenow   = date('Y-m-d');
        $months    = date('m');
        $year      = date('Y');
        $startdate = $request->startdate;
        $enddate   = $request->enddate;
        $newweek   = date('Y-m-d', strtotime($datenow . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
        $newDate   = date('Y-m-d', strtotime($datenow . ' -1 months')); //ย้อนหลัง 1 เดือน
        $newyear   = date('Y-m-d', strtotime($datenow . ' -1 year')); //ย้อนหลัง 1 ปี
        $bgs_year      = DB::table('budget_year')->where('years_now','Y')->first();
        $bg_yearnow    = $bgs_year->leave_year_id;

        if ($startdate =='') {
            $datashow = DB::select(
                'SELECT a.gas_list_num,a.gas_list_name,a.detail,a.size,b.gas_list_id,b.gas_check_id
                ,b.check_year,b.check_date,b.check_time,b.gas_check_body,b.gas_check_body_name,b.gas_check_valve,b.gas_check_valve_name
                ,b.gas_check_pressure,b.gas_check_pressure_name,b.gas_check_pressure_min,b.gas_check_pressure_max,b.standard_value
                ,b.standard_value_min,b.standard_value_max,concat(p.fname," ",p.lname) as ptname,b.pariman_value,b.pressure_value,b.active
                FROM gas_check b
                LEFT JOIN gas_list a ON a.gas_list_id = b.gas_list_id
                LEFT JOIN users p ON p.id = b.user_id
                WHERE b.check_date BETWEEN "'.$newDate.'" AND "'.$datenow.'" AND b.gas_type ="1"
                ORDER BY b.gas_check_id DESC
            ');
            // AND a.gas_year = "'.$bg_yearnow.'"
        } else {
            $datashow = DB::select(
                'SELECT a.gas_list_num,a.gas_list_name,a.detail,a.size,b.gas_list_id,b.gas_check_id
                ,b.check_year,b.check_date,b.check_time,b.gas_check_body,b.gas_check_body_name,b.gas_check_valve,b.gas_check_valve_name
                ,b.gas_check_pressure,b.gas_check_pressure_name,b.gas_check_pressure_min,b.gas_check_pressure_max,b.standard_value
                ,b.standard_value_min,b.standard_value_max,concat(p.fname," ",p.lname) as ptname ,b.pariman_value,b.pressure_value,b.active
                FROM gas_check b
                LEFT JOIN gas_list a ON a.gas_list_id = b.gas_list_id
                LEFT JOIN users p ON p.id = b.user_id
                WHERE b.check_date BETWEEN "'.$startdate.'" AND "'.$enddate.'" AND b.gas_type ="1"
                ORDER BY b.gas_check_id DESC
            ');
            // AND a.gas_year = "'.$bg_yearnow.'"
        }

        // $data_                  = DB::table('gas_list')->where('gas_type','1')->where('gas_year',$bg_yearnow)->first();
        // $data['gas_list_id']    = $data_->gas_list_id;
        // $data['gas_type']       = $data_->gas_type;

        return view('support_prs.gas.gas_check_tank',[
            'startdate'     => $startdate,
            'enddate'       => $enddate,
            'datashow'      => $datashow,
        ]);
    }
    public function gas_check_tankadd(Request $request)
    {
        $datenow   = date('Y-m-d');
        $months    = date('m');
        $year      = date('Y');
        $startdate = $request->startdate;
        $enddate   = $request->enddate;
        $newweek   = date('Y-m-d', strtotime($datenow . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
        $newDate   = date('Y-m-d', strtotime($datenow . ' -1 months')); //ย้อนหลัง 1 เดือน
        $newyear   = date('Y-m-d', strtotime($datenow . ' -1 year')); //ย้อนหลัง 1 ปี
        $bgs_year      = DB::table('budget_year')->where('years_now','Y')->first();
        $bg_yearnow    = $bgs_year->leave_year_id;

        if ($startdate =='') {
            $datashow = DB::select(
                'SELECT a.gas_list_num,a.gas_list_name,a.detail,a.size
                ,b.check_year,b.check_date,b.check_time,b.gas_check_body,b.gas_check_body_name,b.gas_check_valve,b.gas_check_valve_name
                ,b.gas_check_pressure,b.gas_check_pressure_name,b.gas_check_pressure_min,b.gas_check_pressure_max,b.standard_value
                ,b.standard_value_min,b.standard_value_max,concat(p.fname," ",p.lname) as ptname
                FROM gas_check b
                LEFT JOIN gas_list a ON a.gas_list_id = b.gas_list_id
                LEFT JOIN users p ON p.id = a.user_id
                WHERE b.check_date BETWEEN "'.$newDate.'" AND "'.$datenow.'" AND b.gas_type ="1"
                ORDER BY b.gas_check_id DESC
            ');
        } else {
            $datashow = DB::select(
                'SELECT a.gas_list_num,a.gas_list_name,a.detail,a.size
                ,b.check_year,b.check_date,b.check_time,b.gas_check_body,b.gas_check_body_name,b.gas_check_valve,b.gas_check_valve_name
                ,b.gas_check_pressure,b.gas_check_pressure_name,b.gas_check_pressure_min,b.gas_check_pressure_max,b.standard_value
                ,b.standard_value_min,b.standard_value_max,concat(p.fname," ",p.lname) as ptname
                FROM gas_check b
                LEFT JOIN gas_list a ON a.gas_list_id = b.gas_list_id
                LEFT JOIN users p ON p.id = a.user_id
                WHERE b.check_date BETWEEN "'.$startdate.'" AND "'.$enddate.'" AND b.gas_type ="1"
                ORDER BY b.gas_check_id DESC
            ');
        }
        // $data_                  = DB::table('gas_list')->where('gas_type','1')->where('gas_year',$bg_yearnow)->first();
        $data_                  = DB::table('gas_list')->where('gas_type','1')->first();
        $data['gas_list_id']    = $data_->gas_list_id;
        $data['gas_type']       = $data_->gas_type;

        return view('support_prs.gas.gas_check_tankadd',$data,[
            'startdate'     => $startdate,
            'enddate'       => $enddate,
            'datashow'      => $datashow,
        ]);
    }
    public function gas_check_tank_save(Request $request)
    {
        $datenow       = date('Y-m-d');
        $months        = date('m');
        $year          = date('Y');
        $m             = date('H');
        $mm            = date('H:m:s');
        $datefull      = date('Y-m-d H:m:s');
        $bgs_year      = DB::table('budget_year')->where('years_now','Y')->first();
        $bg_yearnow    = $bgs_year->leave_year_id;
        $startdate     = $request->startdate;
        $enddate       = $request->enddate;
        $iduser        = Auth::user()->id;
        $name_         = User::where('id', '=',$iduser)->first();
        $name_check    = $name_->fname. '  '.$name_->lname;
        // $list      = DB::table('gas_list')->where('gas_list_id',$request->gas_list_id)->where('gas_year',$bg_yearnow)->first();
        $list          = DB::table('gas_list')->where('gas_list_id',$request->gas_list_id)->first();
        $check_count   = DB::table('gas_check')->where('check_date',$datenow)->where('gas_type','1')->count();
        // dd($check_count);
            if ($check_count > 0) {
                # code...
            } else {
                Gas_check::insert([
                    'check_year'           =>  $bg_yearnow,
                    'check_date'           =>  $request->check_date,
                    'check_time'           =>  $mm,
                    'gas_list_id'          =>  $request->gas_list_id,
                    'gas_list_num'         =>  $list->gas_list_num,
                    'gas_list_name'        =>  $list->gas_list_name,
                    'size'                 =>  $list->size,
                    'gas_type'             =>  $request->gas_type,
                    'standard_value'       =>  $request->standard_value,
                    'standard_value_min'   =>  $request->standard_value_min,
                    'pressure_value'       =>  $request->pressure_value,
                    'pariman_value'        =>  $request->pariman_value,
                    'active'               =>  $request->active,
                    'user_id'              =>  $iduser
                ]);

                //แจ้งเตือนไลน์
                // if ($request->pariman_value < '50') {
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
                $header = "ตรวจสอบออกซิเจนเหลว(Main)";
                $message =  $header.
                "\n" . "วันที่ตรวจสอบ: " . DateThailine($request->check_date).
                "\n" . "เวลา : " . $mm ."".
                "\n" . "ปริมาณมาตรฐาน : 124 inH2O".
                "\n" . "ปริมาณวัดได้ : " . $request->pariman_value .
                "\n" . "แรงดันมาตรฐาน : 5-12 bar".
                "\n" . "ค่าแรงดันวัดได้ : " . $request->pressure_value.
                "\n" . "ผู้ตรวจสอบ : " . $name_check;

                $linesend_tech = "YNWHjzi9EA6mr5myMrcTvTaSlfOMPHMOiCyOfeSJTHr"; //ช่างซ่อม
                $linesend      = "u0prMwfXLUod8Go1E0fJUxmMaLUmC40tBgcHgbHFgNG";  // พรส

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
                    }
                    curl_close($chOne);
                }

                if ($linesend_tech == null) {
                    $test2 = '';
                } else {
                    $test2 = $linesend_tech;
                }
                if ($test2 !== '' && $test2 !== null) {
                    $chOne_tech = curl_init();
                    curl_setopt($chOne_tech, CURLOPT_URL, "https://notify-api.line.me/api/notify");
                    curl_setopt($chOne_tech, CURLOPT_SSL_VERIFYHOST, 0);
                    curl_setopt($chOne_tech, CURLOPT_SSL_VERIFYPEER, 0);
                    curl_setopt($chOne_tech, CURLOPT_POST, 1);
                    curl_setopt($chOne_tech, CURLOPT_POSTFIELDS, $message);
                    curl_setopt($chOne_tech, CURLOPT_POSTFIELDS, "message=$message");
                    curl_setopt($chOne_tech, CURLOPT_FOLLOWLOCATION, 1);
                    $headers2 = array('Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer ' . $test2 . '',);
                    curl_setopt($chOne_tech, CURLOPT_HTTPHEADER, $headers2);
                    curl_setopt($chOne_tech, CURLOPT_RETURNTRANSFER, 1);
                    $result2 = curl_exec($chOne_tech);
                    if (curl_error($chOne_tech)) {
                        echo 'error:' . curl_error($chOne_tech);
                    } else {
                        $result_2 = json_decode($result2, true);
                    }
                    curl_close($chOne_tech);
                }
                // }
                //แจ้งเตือนไลน์
                // if ($request->pressure_value < '5') {
                // }
            }
            return response()->json([
                'status'     => '200'
            ]);
    }
    public function gas_check_tankedit(Request $request,$id)
    {
        $datenow   = date('Y-m-d');
        $months    = date('m');
        $year      = date('Y');
        $startdate = $request->startdate;
        $enddate   = $request->enddate;
        $newweek   = date('Y-m-d', strtotime($datenow . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
        $newDate   = date('Y-m-d', strtotime($datenow . ' -1 months')); //ย้อนหลัง 1 เดือน
        $newyear   = date('Y-m-d', strtotime($datenow . ' -1 year')); //ย้อนหลัง 1 ปี

        $data_                  = DB::table('gas_list')->where('gas_type','1')->first();
        $data['gas_list_id']    = $data_->gas_list_id;
        $data['gas_type']       = $data_->gas_type;

        $data_edit              = DB::table('gas_check')->where('gas_check_id',$id)->first();

        return view('support_prs.gas.gas_check_tankedit',$data,[
            'startdate'     => $startdate,
            'enddate'       => $enddate,
            'data_edit'     => $data_edit,
        ]);
    }
    public function gas_check_tank_update(Request $request)
    {
        $gas_check_id  = $request->gas_check_id;

        Gas_check::where('gas_check_id',$gas_check_id)->update([
            'pressure_value'       =>  $request->pressure_value,
            'pariman_value'        =>  $request->pariman_value,
        ]);

        return response()->json([
            'status'     => '200'
        ]);
    }
    public function gas_qrcode(Request $request)
    {
            $dataprint_main = Gas_list::get();

        return view('support_prs.gas.gas_qrcode', [
            'dataprint_main'  =>  $dataprint_main,
            // 'dataprint'        =>  $dataprint
        ]);

    }
    public function gas_check_destroy(Request $request,$id)
    {
        $del = Gas_check::find($id);
        // $description = 'storage/air/'.$del->air_imgname;
        // if (File::exists($description)) {
        //     File::delete($description);
        // }
        $del->delete();
        // Fire::whereIn('fire_id',explode(",",$id))->delete();

        return response()->json(['status' => '200']);
    }

    //Thank Sub
    public function gas_check_tanksub(Request $request)
    {
        $datenow   = date('Y-m-d');
        $months    = date('m');
        $year      = date('Y');
        $startdate = $request->startdate;
        $enddate   = $request->enddate;
        $newweek   = date('Y-m-d', strtotime($datenow . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
        $newDate   = date('Y-m-d', strtotime($datenow . ' -1 months')); //ย้อนหลัง 1 เดือน
        $newyear   = date('Y-m-d', strtotime($datenow . ' -1 year')); //ย้อนหลัง 1 ปี
        $bgs_year      = DB::table('budget_year')->where('years_now','Y')->first();
        $bg_yearnow    = $bgs_year->leave_year_id;

        if ($startdate =='') {
            $datashow = DB::select(
                'SELECT a.gas_list_num,a.gas_list_name,a.detail,a.size,b.gas_list_id,b.gas_check_id
                ,b.check_year,b.check_date,b.check_time,b.gas_check_body,b.gas_check_body_name,b.gas_check_valve,b.gas_check_valve_name
                ,b.gas_check_pressure,b.gas_check_pressure_name,b.gas_check_pressure_min,b.gas_check_pressure_max,b.standard_value
                ,b.standard_value_min,b.standard_value_max,concat(p.fname," ",p.lname) as ptname,b.pariman_value,b.pressure_value
                FROM gas_check b
                LEFT JOIN gas_list a ON a.gas_list_id = b.gas_list_id
                LEFT JOIN users p ON p.id = b.user_id
                WHERE b.check_date BETWEEN "'.$newDate.'" AND "'.$datenow.'" AND b.gas_type ="2"
                ORDER BY b.gas_check_id DESC
            ');
            // AND a.gas_year = "'.$bg_yearnow.'"
        } else {
            $datashow = DB::select(
                'SELECT a.gas_list_num,a.gas_list_name,a.detail,a.size,b.gas_list_id,b.gas_check_id
                ,b.check_year,b.check_date,b.check_time,b.gas_check_body,b.gas_check_body_name,b.gas_check_valve,b.gas_check_valve_name
                ,b.gas_check_pressure,b.gas_check_pressure_name,b.gas_check_pressure_min,b.gas_check_pressure_max,b.standard_value
                ,b.standard_value_min,b.standard_value_max,concat(p.fname," ",p.lname) as ptname ,b.pariman_value,b.pressure_value
                FROM gas_check b
                LEFT JOIN gas_list a ON a.gas_list_id = b.gas_list_id
                LEFT JOIN users p ON p.id = b.user_id
                WHERE b.check_date BETWEEN "'.$startdate.'" AND "'.$enddate.'" AND b.gas_type ="2"
                ORDER BY b.gas_check_id DESC
            ');
            // AND a.gas_year = "'.$bg_yearnow.'"
        }

        // $data_                  = DB::table('gas_list')->where('gas_type','1')->first();
        // $data['gas_list_id']    = $data_->gas_list_id;
        // $data['gas_type']       = $data_->gas_type;

        return view('support_prs.gas.gas_check_tanksub',[
            'startdate'     => $startdate,
            'enddate'       => $enddate,
            'datashow'      => $datashow,
        ]);
    }
    public function gas_check_tanksub_add(Request $request)
    {
        $datenow   = date('Y-m-d');
        $months    = date('m');
        $year      = date('Y');
        $startdate = $request->startdate;
        $enddate   = $request->enddate;
        $newweek   = date('Y-m-d', strtotime($datenow . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
        $newDate   = date('Y-m-d', strtotime($datenow . ' -1 months')); //ย้อนหลัง 1 เดือน
        $newyear   = date('Y-m-d', strtotime($datenow . ' -1 year')); //ย้อนหลัง 1 ปี
        $bgs_year      = DB::table('budget_year')->where('years_now','Y')->first();
        $bg_yearnow    = $bgs_year->leave_year_id;
        $data['month_now']         = date('m');
        $m             = date('H');
        $data['mm']    = date('H:m:s');
        $datefull = date('Y-m-d H:m:s');
        $iduser        = Auth::user()->id;
        // $datashow = DB::select(
        //     'SELECT a.*,b.gas_check_body,b.gas_check_body_name,b.gas_check_valve,b.gas_check_valve_name,b.gas_check_pressure,b.gas_check_pressure_name,month(b.check_date) as months,b.check_date
        //     FROM gas_list a
        //     LEFT JOIN gas_check b ON b.gas_list_id = a.gas_list_id
        //     WHERE a.active = "Ready" AND a.gas_type ="2" AND a.gas_year = "'.$bg_yearnow.'"
        //     GROUP BY a.gas_list_id
        //     ORDER BY a.gas_list_id ASC
        // ');
        $datashow = DB::select(
            'SELECT a.gas_list_id,a.gas_list_num,a.gas_list_name,a.size

            ,(SELECT month(check_date) FROM gas_check WHERE month(check_date) ="'.$months.'" LIMIT 1) as months
            ,(SELECT gas_check_body FROM gas_check WHERE gas_list_num = a.gas_list_num AND check_date ="'.$datenow.'") as gas_check_body
            ,(SELECT gas_check_body_name FROM gas_check WHERE gas_list_num = a.gas_list_num AND check_date ="'.$datenow.'") as gas_check_body_name
            ,(SELECT gas_check_valve FROM gas_check WHERE gas_list_num = a.gas_list_num AND check_date ="'.$datenow.'") as gas_check_valve
            ,(SELECT gas_check_valve_name FROM gas_check WHERE gas_list_num = a.gas_list_num AND check_date ="'.$datenow.'") as gas_check_valve_name
            ,(SELECT gas_check_pressure FROM gas_check WHERE gas_list_num = a.gas_list_num AND check_date ="'.$datenow.'") as gas_check_pressure
            ,(SELECT gas_check_pressure_name FROM gas_check WHERE gas_list_num = a.gas_list_num AND check_date ="'.$datenow.'") as gas_check_pressure_name
            ,(SELECT check_date FROM gas_check WHERE gas_list_num = a.gas_list_num AND check_date ="'.$datenow.'") as check_date
            ,(SELECT check_date FROM gas_check WHERE gas_list_num = a.gas_list_num AND check_date ="'.$datenow.'") as check_date_b
            FROM gas_list a
            WHERE a.gas_type IN("2") AND a.active = "Ready"
            GROUP BY a.gas_list_num
            ORDER BY a.gas_list_id ASC
        ');
        // AND a.gas_year = "'.$bg_yearnow.'"
        // AND month(b.check_date) = "'.$month.'"
        // $datashow = DB::select(
        //     'SELECT a.*
        //     FROM gas_list a
        //     WHERE a.active = "Ready" AND a.gas_type ="2" AND a.gas_year = "'.$bg_yearnow.'"
        //     GROUP BY a.gas_list_id
        //     ORDER BY a.gas_list_id ASC
        // ');
        return view('support_prs.gas.gas_check_tanksub_add',$data,[
            'startdate'     => $startdate,
            'enddate'       => $enddate,
            'datashow'      => $datashow,
        ]);
    }

    public function gas_check_tanksub_save(Request $request)
    {
        if ($request->ajax()) {
            if ($request->action == 'Edit') {
                $bgs_year      = DB::table('budget_year')->where('years_now','Y')->first();
                $bg_yearnow    = $bgs_year->leave_year_id;
                // $idgas         = Gas_list::where('gas_list_num', $request->gas_list_num)->where('gas_year',$bg_yearnow)->first();
                $idgas         = Gas_list::where('gas_list_num', $request->gas_list_num)->first();
                $gas_list_id   = $idgas->gas_list_id;
                $gas_list_num  = $idgas->gas_list_num;
                $gas_list_name = $idgas->gas_list_name;
                $size          = $idgas->size;
                $gas_type      = $idgas->gas_type;

                $date          = date('Y-m-d');
                $y             = date('Y')+543;
                $m             = date('H');
                $mm            = date('H:m:s');
                $datefull      = date('Y-m-d H:m:s');
                $check         = Gas_check::where('gas_list_id', $gas_list_id)->where('check_date', $date)->count();
                $iduser        = Auth::user()->id;



                $body_    = $request->gas_check_body;
                if ($body_ == '0') {
                    $body  = 'พร้อมใช้';
                } else {
                    $body  = 'ไม่พร้อมใช้';
                }

                $check_valve_     = $request->gas_check_valve;
                if ($check_valve_ == '0') {
                    $check_valve  = 'พร้อมใช้';
                } else {
                    $check_valve  = 'ไม่พร้อมใช้';
                }

                $pressure_        = $request->gas_check_pressure;
                if ($pressure_ == '0') {
                    $pressure  = 'พร้อมใช้';
                } else {
                    $pressure  = 'ไม่พร้อมใช้';
                }

                if ($check > 0) {
                    Gas_check::where('gas_list_id', $gas_list_id)->where('check_date', $date)->update([
                        // 'check_year'               => $y,
                        'gas_check_body'           => $body_,
                        'gas_check_body_name'      => $body,
                        'gas_check_valve'          => $check_valve_,
                        'gas_check_valve_name'     => $check_valve,
                        'gas_check_pressure'       => $pressure_,
                        'gas_check_pressure_name'  => $pressure,
                        'user_id'                  => $iduser,
                    ]);
                    if ($body_ == '1' || $check_valve_ == '1' || $pressure_ == '1') {
                        Gas_list::where('gas_list_id',$gas_list_id)->update(['active' => 'NotReady']);
                    } else {
                        Gas_list::where('gas_list_id',$gas_list_id)->update(['active' => 'Ready']);
                    }
                } else {
                    Gas_check::insert([
                        'check_year'               => $bg_yearnow,
                        'check_date'               => $date,
                        'check_time'               => $mm,
                        'gas_list_id'              => $gas_list_id,
                        'gas_list_num'             => $gas_list_num,
                        'gas_list_name'            => $gas_list_name,
                        'size'                     => $size,
                        'gas_type'                 => $gas_type,
                        'gas_check_body'           => $body_,
                        'gas_check_body_name'      => $body,
                        'gas_check_valve'          => $check_valve_,
                        'gas_check_valve_name'     => $check_valve,
                        'gas_check_pressure'       => $pressure_,
                        'gas_check_pressure_name'  => $pressure,
                        'user_id'                  => $iduser,
                    ]);

                    if ($body_ == '1' || $check_valve_ == '1' || $pressure_ == '1') {
                        Gas_list::where('gas_list_id',$gas_list_id)->update(['active' => 'NotReady']);
                    } else {
                        Gas_list::where('gas_list_id',$gas_list_id)->update(['active' => 'Ready']);
                    }
                }

                // $data  = array(
                //     // 'cctv_check_date'            => $date,
                //     'gas_check_body'        => $request->gas_check_body,
                //     'gas_check_valve'       => $request->gas_check_valve,
                //     'gas_check_pressure'    => $request->gas_check_pressure,
                // );
                // DB::connection('mysql')->table('cctv_list')
                //     ->where('cctv_list_num', $request->cctv_list_num)
                //     ->update($data);
            }
            return response()->json([
                'status'     => '200'
            ]);
            // return request()->json($request);
        }
    }

    //ไนตรัสออกไซด์ (N2O-6Q)
    public function gas_check_nitrus(Request $request)
    {
        $datenow   = date('Y-m-d');
        $months    = date('m');
        $year      = date('Y');
        $startdate = $request->startdate;
        $enddate   = $request->enddate;
        $newweek   = date('Y-m-d', strtotime($datenow . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
        $newDate   = date('Y-m-d', strtotime($datenow . ' -1 months')); //ย้อนหลัง 1 เดือน
        $newyear   = date('Y-m-d', strtotime($datenow . ' -1 year')); //ย้อนหลัง 1 ปี
        $bgs_year      = DB::table('budget_year')->where('years_now','Y')->first();
        $bg_yearnow    = $bgs_year->leave_year_id;

        if ($startdate =='') {
            $datashow = DB::select(
                'SELECT a.gas_list_num,a.gas_list_name,a.detail,a.size,b.gas_list_id,b.gas_check_id
                ,b.check_year,b.check_date,b.check_time,b.gas_check_body,b.gas_check_body_name,b.gas_check_valve,b.gas_check_valve_name
                ,b.gas_check_pressure,b.gas_check_pressure_name,b.gas_check_pressure_min,b.gas_check_pressure_max,b.standard_value
                ,b.standard_value_min,b.standard_value_max,concat(p.fname," ",p.lname) as ptname,b.pariman_value,b.pressure_value
                FROM gas_check b
                LEFT JOIN gas_list a ON a.gas_list_id = b.gas_list_id
                LEFT JOIN users p ON p.id = b.user_id
                WHERE b.check_date BETWEEN "'.$newDate.'" AND "'.$datenow.'" AND b.gas_type ="5"
                ORDER BY b.gas_check_id DESC
            ');
            // AND a.gas_year = "'.$bg_yearnow.'"
        } else {
            $datashow = DB::select(
                'SELECT a.gas_list_num,a.gas_list_name,a.detail,a.size,b.gas_list_id,b.gas_check_id
                ,b.check_year,b.check_date,b.check_time,b.gas_check_body,b.gas_check_body_name,b.gas_check_valve,b.gas_check_valve_name
                ,b.gas_check_pressure,b.gas_check_pressure_name,b.gas_check_pressure_min,b.gas_check_pressure_max,b.standard_value
                ,b.standard_value_min,b.standard_value_max,concat(p.fname," ",p.lname) as ptname ,b.pariman_value,b.pressure_value
                FROM gas_check b
                LEFT JOIN gas_list a ON a.gas_list_id = b.gas_list_id
                LEFT JOIN users p ON p.id = b.user_id
                WHERE b.check_date BETWEEN "'.$startdate.'" AND "'.$enddate.'" AND b.gas_type ="5"
                ORDER BY b.gas_check_id DESC
            ');
        }

        return view('support_prs.gas.gas_check_nitrus',[
            'startdate'     => $startdate,
            'enddate'       => $enddate,
            'datashow'      => $datashow,
        ]);
    }
    public function gas_check_nitrus_add(Request $request)
    {
        $datenow   = date('Y-m-d');
        $months    = date('m');
        $year      = date('Y');
        $startdate = $request->startdate;
        $enddate   = $request->enddate;
        $newweek   = date('Y-m-d', strtotime($datenow . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
        $newDate   = date('Y-m-d', strtotime($datenow . ' -1 months')); //ย้อนหลัง 1 เดือน
        $newyear   = date('Y-m-d', strtotime($datenow . ' -1 year')); //ย้อนหลัง 1 ปี
        $bgs_year      = DB::table('budget_year')->where('years_now','Y')->first();
        $bg_yearnow    = $bgs_year->leave_year_id;
        $data['month_now']         = date('m');
        $m             = date('H');
        $data['mm']    = date('H:m:s');
        $datefull = date('Y-m-d H:m:s');
        $iduser        = Auth::user()->id;
        $datashow = DB::select(
            'SELECT a.gas_list_id,a.gas_list_num,a.gas_list_name,a.size
            ,(SELECT gas_check_body FROM gas_check WHERE gas_list_num = a.gas_list_num AND check_date ="'.$datenow.'") as gas_check_body
            ,(SELECT gas_check_body_name FROM gas_check WHERE gas_list_num = a.gas_list_num AND check_date ="'.$datenow.'") as gas_check_body_name
            ,(SELECT gas_check_valve FROM gas_check WHERE gas_list_num = a.gas_list_num AND check_date ="'.$datenow.'") as gas_check_valve
            ,(SELECT gas_check_valve_name FROM gas_check WHERE gas_list_num = a.gas_list_num AND check_date ="'.$datenow.'") as gas_check_valve_name
            ,(SELECT gas_check_pressure FROM gas_check WHERE gas_list_num = a.gas_list_num AND check_date ="'.$datenow.'") as gas_check_pressure
            ,(SELECT gas_check_pressure_name FROM gas_check WHERE gas_list_num = a.gas_list_num AND check_date ="'.$datenow.'") as gas_check_pressure_name
            ,(SELECT check_date FROM gas_check WHERE gas_list_num = a.gas_list_num AND check_date ="'.$datenow.'") as check_date
            ,(SELECT check_date FROM gas_check WHERE gas_list_num = a.gas_list_num AND check_date ="'.$datenow.'") as check_date_b
            FROM gas_list a
            WHERE a.gas_type IN("5") AND a.active = "Ready"
            GROUP BY a.gas_list_num
            ORDER BY a.gas_list_id ASC
        ');
        // ,b.check_date
        return view('support_prs.gas.gas_check_nitrus_add',$data,[
            'startdate'     => $startdate,
            'enddate'       => $enddate,
            'datashow'      => $datashow,
            'datenow'       => $datenow,
        ]);
    }
    public function gas_check_nitrus_save(Request $request)
    {
        if ($request->ajax()) {
            // dd($request->action);
            if ($request->action == 'Edit') {
                $idgas         = Gas_list::where('gas_list_num', $request->gas_list_num)->first();
                $gas_list_id   = $idgas->gas_list_id;
                $gas_list_num  = $idgas->gas_list_num;
                $gas_list_name = $idgas->gas_list_name;
                $size          = $idgas->size;
                $gas_type      = $idgas->gas_type;

                $date          = date('Y-m-d');
                $y             = date('Y')+543;
                $m             = date('H');
                $mm            = date('H:m:s');
                $datefull      = date('Y-m-d H:m:s');
                // dd($gas_list_id);

                $check         = Gas_check::where('gas_list_id', $gas_list_id)->where('check_date', $date)->count();
                $iduser        = Auth::user()->id;
                // dd($check);
                $bgs_year      = DB::table('budget_year')->where('years_now','Y')->first();
                $bg_yearnow    = $bgs_year->leave_year_id;
                // $active    = $request->active;
                $body_    = $request->gas_check_body;
                if ($body_ == '0') {
                    $body  = 'พร้อมใช้';
                } else {
                    $body  = 'ไม่พร้อมใช้';
                }

                $check_valve_     = $request->gas_check_valve;
                if ($check_valve_ == '0') {
                    $check_valve  = 'พร้อมใช้';
                } else {
                    $check_valve  = 'ไม่พร้อมใช้';
                }

                $pressure_        = $request->gas_check_pressure;
                if ($pressure_ == '0') {
                    $pressure  = 'พร้อมใช้';
                } else {
                    $pressure  = 'ไม่พร้อมใช้';
                }


                if ($check > 0) {
                    Gas_check::where('gas_list_id', $gas_list_id)->where('check_date', $date)->update([
                        'check_date'         => $date,
                        // 'active'             => $active,
                        'user_id'            => $iduser,
                        'gas_check_body'           => $body_,
                        'gas_check_body_name'      => $body,
                        'gas_check_valve'          => $check_valve_,
                        'gas_check_valve_name'     => $check_valve,
                        'gas_check_pressure'       => $pressure_,
                        'gas_check_pressure_name'  => $pressure,
                        'user_id'                  => $iduser,
                    ]);
                    if ($body_ == '1' || $check_valve_ == '1' || $pressure_ == '1') {
                        Gas_list::where('gas_list_id',$gas_list_id)->update(['active' => 'NotReady']);
                    } else {
                        Gas_list::where('gas_list_id',$gas_list_id)->update(['active' => 'Ready']);
                    }
                } else {
                    Gas_check::insert([
                        'check_year'               => $bg_yearnow,
                        'check_date'               => $date,
                        'check_time'               => $mm,
                        'gas_list_id'              => $gas_list_id,
                        'gas_list_num'             => $gas_list_num,
                        'gas_list_name'            => $gas_list_name,
                        'size'                     => $size,
                        'gas_type'                 => $gas_type,
                        'gas_check_body'           => $body_,
                        'gas_check_body_name'      => $body,
                        'gas_check_valve'          => $check_valve_,
                        'gas_check_valve_name'     => $check_valve,
                        'gas_check_pressure'       => $pressure_,
                        'gas_check_pressure_name'  => $pressure,
                        'user_id'                  => $iduser,
                        // 'active'                   => $active,
                    ]);

                    if ($body_ == '1' || $check_valve_ == '1' || $pressure_ == '1') {
                        Gas_list::where('gas_list_id',$gas_list_id)->update(['active' => 'NotReady']);
                    } else {
                        Gas_list::where('gas_list_id',$gas_list_id)->update(['active' => 'Ready']);
                    }
                }



                // if ($check > 0) {
                //     // Gas_check::where('gas_list_id', $gas_list_id)->where('check_date', $date)->update([
                //     //     'check_date'         => $date,
                //     //     'active'             => $active,
                //     //     'user_id'            => $iduser,
                //     // ]);
                //     // Gas_list::where('gas_list_id', $gas_list_id)->update([
                //     //     'active'             => $active,
                //     //     'user_id'            => $iduser,
                //     // ]);
                // } else {
                //     Gas_check::insert([
                //         'check_year'               => $y,
                //         'check_date'               => $date,
                //         'check_time'               => $mm,
                //         'gas_list_id'              => $gas_list_id,
                //         'gas_list_num'             => $gas_list_num,
                //         'gas_list_name'            => $gas_list_name,
                //         'size'                     => $size,
                //         'gas_type'                 => $gas_type,
                //         'active'                   => $active,
                //         // 'gas_check_body'           => $body_,
                //         // 'gas_check_body_name'      => $body,
                //         // 'gas_check_valve'          => $check_valve_,
                //         // 'gas_check_valve_name'     => $check_valve,
                //         // 'gas_check_pressure'       => $pressure_,
                //         // 'gas_check_pressure_name'  => $pressure,
                //         'user_id'                  => $iduser,
                //     ]);
                //     Gas_list::where('gas_list_id', $gas_list_id)->update([
                //         'active'             => $active,
                //         'user_id'            => $iduser,
                //     ]);
                //     // if ($body_ == '1' || $check_valve_ == '1' || $pressure_ == '1') {
                //     //     Gas_list::where('gas_list_id',$gas_list_id)->update(['active' => 'NotReady']);
                //     // } else {
                //     //     Gas_list::where('gas_list_id',$gas_list_id)->update(['active' => 'Ready']);
                //     // }
                // }

            }
            return response()->json([
                'status'     => '200'
            ]);
            // return request()->json($request);
        }
    }

    //ก๊าซอ๊อกซิเจน (2Q-6Q)
    public function gas_check_o2(Request $request)
    {
        $datenow   = date('Y-m-d');
        $months    = date('m');
        $year      = date('Y');
        $startdate = $request->startdate;
        $enddate   = $request->enddate;
        $newweek   = date('Y-m-d', strtotime($datenow . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
        $newDate   = date('Y-m-d', strtotime($datenow . ' -1 months')); //ย้อนหลัง 1 เดือน
        $newyear   = date('Y-m-d', strtotime($datenow . ' -1 year')); //ย้อนหลัง 1 ปี
        $bgs_year      = DB::table('budget_year')->where('years_now','Y')->first();
        $bg_yearnow    = $bgs_year->leave_year_id;

        if ($startdate =='') {
            $datashow = DB::select(
                'SELECT a.gas_list_num,a.gas_list_name,a.detail,a.size,b.gas_list_id,b.gas_check_id
                ,b.check_year,b.check_date,b.check_time,b.gas_check_body,b.gas_check_body_name,b.gas_check_valve,b.gas_check_valve_name
                ,b.gas_check_pressure,b.gas_check_pressure_name,b.gas_check_pressure_min,b.gas_check_pressure_max,b.standard_value
                ,b.standard_value_min,b.standard_value_max,concat(p.fname," ",p.lname) as ptname,b.pariman_value,b.pressure_value,a.active
                FROM gas_check b
                LEFT JOIN gas_list a ON a.gas_list_id = b.gas_list_id
                LEFT JOIN users p ON p.id = b.user_id
                WHERE b.check_date BETWEEN "'.$newweek.'" AND "'.$datenow.'" AND b.gas_type IN("3","4")
                ORDER BY b.gas_check_id DESC
            ');
            // AND a.gas_year = "'.$bg_yearnow.'"
        } else {
            $datashow = DB::select(
                'SELECT a.gas_list_num,a.gas_list_name,a.detail,a.size,b.gas_list_id,b.gas_check_id
                ,b.check_year,b.check_date,b.check_time,b.gas_check_body,b.gas_check_body_name,b.gas_check_valve,b.gas_check_valve_name
                ,b.gas_check_pressure,b.gas_check_pressure_name,b.gas_check_pressure_min,b.gas_check_pressure_max,b.standard_value
                ,b.standard_value_min,b.standard_value_max,concat(p.fname," ",p.lname) as ptname ,b.pariman_value,b.pressure_value,a.active
                FROM gas_check b
                LEFT JOIN gas_list a ON a.gas_list_id = b.gas_list_id
                LEFT JOIN users p ON p.id = b.user_id
                WHERE b.check_date BETWEEN "'.$startdate.'" AND "'.$enddate.'" AND b.gas_type IN("3","4")
                ORDER BY b.gas_check_id DESC
            ');
        }

        return view('support_prs.gas.gas_check_o2',[
            'startdate'     => $startdate,
            'enddate'       => $enddate,
            'datashow'      => $datashow,
        ]);
    }
    public function gas_check_o2_add(Request $request)
    {
        $datenow   = date('Y-m-d');
        $months    = date('m');
        $year      = date('Y');
        $startdate = $request->startdate;
        $enddate   = $request->enddate;
        $newweek   = date('Y-m-d', strtotime($datenow . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
        $newDate   = date('Y-m-d', strtotime($datenow . ' -1 months')); //ย้อนหลัง 1 เดือน
        $newyear   = date('Y-m-d', strtotime($datenow . ' -1 year')); //ย้อนหลัง 1 ปี
        $bgs_year      = DB::table('budget_year')->where('years_now','Y')->first();
        $bg_yearnow    = $bgs_year->leave_year_id;
        $data['month_now']         = date('m');
        $m             = date('H');
        $data['mm']    = date('H:m:s');
        $datefull = date('Y-m-d H:m:s');
        $iduser        = Auth::user()->id;
        // $datashow = DB::select(
        //     'SELECT a.*,b.gas_check_body,b.gas_check_body_name,b.gas_check_valve,b.gas_check_valve_name,b.gas_check_pressure,b.gas_check_pressure_name,b.check_date
        //     ,(SELECT check_date FROM gas_check WHERE gas_list_id = a.gas_list_id AND check_date ="'.$datenow.'") as check_date_b
        //     FROM gas_list a
        //     LEFT JOIN gas_check b ON b.gas_list_id = a.gas_list_id
        //     WHERE a.gas_type IN("3","4") AND a.gas_year = "'.$bg_yearnow.'"
        //     GROUP BY a.gas_list_num
        //     ORDER BY a.gas_list_id ASC
        // ');
        $datashow = DB::select(
            'SELECT a.gas_list_id,a.gas_list_num,a.gas_list_name,a.size
            ,(SELECT active FROM gas_check WHERE gas_list_num = a.gas_list_num AND check_date ="'.$datenow.'") as active
            ,(SELECT check_date FROM gas_check WHERE gas_list_num = a.gas_list_num AND check_date ="'.$datenow.'") as check_date
            ,(SELECT check_date FROM gas_check WHERE gas_list_num = a.gas_list_num AND check_date ="'.$datenow.'") as check_date_b
                FROM gas_list a
                WHERE a.gas_type IN("3","4") AND a.active = "Ready"
                GROUP BY a.gas_list_num
                ORDER BY a.gas_list_id ASC
        ');
        // ,b.check_date
        return view('support_prs.gas.gas_check_o2_add',$data,[
            'startdate'     => $startdate,
            'enddate'       => $enddate,
            'datashow'      => $datashow,
            'datenow'       => $datenow,
        ]);
    }
    public function gas_check_o2_save(Request $request)
    {
        if ($request->ajax()) {
            if ($request->action == 'Edit') {
                $idgas         = Gas_list::where('gas_list_num', $request->gas_list_num)->first();
                $gas_list_id   = $idgas->gas_list_id;
                $gas_list_num  = $idgas->gas_list_num;
                $gas_list_name = $idgas->gas_list_name;
                $size          = $idgas->size;
                $gas_type      = $idgas->gas_type;

                $date          = date('Y-m-d');
                $y             = date('Y')+543;
                $m             = date('H');
                $mm            = date('H:m:s');
                $datefull      = date('Y-m-d H:m:s');
                $check         = Gas_check::where('gas_list_id', $gas_list_id)->where('check_date', $date)->count();
                $iduser        = Auth::user()->id;
                // dd($gas_list_id);
                $bgs_year      = DB::table('budget_year')->where('years_now','Y')->first();
                $bg_yearnow    = $bgs_year->leave_year_id;

                $active    = $request->active;
                // if ($active_ == '0') {
                //     $active  = 'พร้อมใช้';
                // } elseif($active_ == '1') {
                //     $active  = 'NotReady';
                // } elseif($active_ == '2') {
                //     $active  = 'รอเติม';
                // } elseif($active_ == '3') {
                //     $active  = 'ยืมคืน';
                // } else {
                //     $active  = 'จำหน่าย';
                // }

                if ($check > 0) {
                    Gas_check::where('gas_list_id', $gas_list_id)->where('check_date', $date)->update([
                        'check_date'         => $date,
                        'active'             => $active,
                        'user_id'            => $iduser,
                    ]);
                    Gas_list::where('gas_list_id', $gas_list_id)->update([
                        'active'             => $active,
                        'user_id'            => $iduser,
                    ]);
                } else {
                    Gas_check::insert([
                        'check_year'               => $bg_yearnow,
                        'check_date'               => $date,
                        'check_time'               => $mm,
                        'gas_list_id'              => $gas_list_id,
                        'gas_list_num'             => $gas_list_num,
                        'gas_list_name'            => $gas_list_name,
                        'size'                     => $size,
                        'gas_type'                 => $gas_type,
                        'active'                   => $active,
                        // 'gas_check_body'           => $body_,
                        // 'gas_check_body_name'      => $body,
                        // 'gas_check_valve'          => $check_valve_,
                        // 'gas_check_valve_name'     => $check_valve,
                        // 'gas_check_pressure'       => $pressure_,
                        // 'gas_check_pressure_name'  => $pressure,
                        'user_id'                  => $iduser,
                    ]);
                    Gas_list::where('gas_list_id', $gas_list_id)->update([
                        'active'             => $active,
                        'user_id'            => $iduser,
                    ]);
                    // if ($body_ == '1' || $check_valve_ == '1' || $pressure_ == '1') {
                    //     Gas_list::where('gas_list_id',$gas_list_id)->update(['active' => 'NotReady']);
                    // } else {
                    //     Gas_list::where('gas_list_id',$gas_list_id)->update(['active' => 'Ready']);
                    // }
                }

            }
            return response()->json([
                'status'     => '200'
            ]);
            // return request()->json($request);
        }
    }
    public function gas_control(Request $request)
    {
        $datenow   = date('Y-m-d');
        $months    = date('m');
        $year      = date('Y');
        $startdate = $request->startdate;
        $enddate   = $request->enddate;
        $newweek   = date('Y-m-d', strtotime($datenow . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
        $newDate   = date('Y-m-d', strtotime($datenow . ' -1 months')); //ย้อนหลัง 1 เดือน
        $newyear   = date('Y-m-d', strtotime($datenow . ' -1 year')); //ย้อนหลัง 1 ปี
        $bgs_year      = DB::table('budget_year')->where('years_now','Y')->first();
        $bg_yearnow    = $bgs_year->leave_year_id;

        if ($startdate =='') {
            $datashow = DB::select(
                'SELECT a.gas_list_num,a.gas_list_name,a.detail,a.size,b.gas_list_id,b.gas_check_id
                ,b.check_year,b.check_date,b.check_time,b.gas_check_body,b.gas_check_body_name,b.gas_check_valve,b.gas_check_valve_name
                ,b.gas_check_pressure,b.gas_check_pressure_name,b.gas_check_pressure_min,b.gas_check_pressure_max,b.standard_value
                ,b.standard_value_min,b.standard_value_max,concat(p.fname," ",p.lname) as ptname,b.pariman_value,b.pressure_value,a.active
                ,b.oxygen_check,b.nitrous_oxide_check,b.pneumatic_air_check,b.vacuum_check
                ,c.location_name,c.detail,c.class
                FROM gas_check b
                LEFT JOIN gas_list a ON a.gas_list_id = b.gas_list_id
                LEFT JOIN gas_dot_control c ON c.gas_list_id = b.gas_list_id
                LEFT JOIN users p ON p.id = b.user_id
                WHERE b.check_date BETWEEN "'.$newweek.'" AND "'.$datenow.'" AND b.gas_type IN("6","7","8","9")
                ORDER BY b.gas_check_id DESC
            ');
        } else {
            $datashow = DB::select(
                'SELECT a.gas_list_num,a.gas_list_name,a.detail,a.size,b.gas_list_id,b.gas_check_id
                ,b.check_year,b.check_date,b.check_time,b.gas_check_body,b.gas_check_body_name,b.gas_check_valve,b.gas_check_valve_name
                ,b.gas_check_pressure,b.gas_check_pressure_name,b.gas_check_pressure_min,b.gas_check_pressure_max,b.standard_value
                ,b.standard_value_min,b.standard_value_max,concat(p.fname," ",p.lname) as ptname ,b.pariman_value,b.pressure_value,a.active
                ,b.oxygen_check,b.nitrous_oxide_check,b.pneumatic_air_check,b.vacuum_check
                ,c.location_name,c.detail,c.class
                FROM gas_check b
                LEFT JOIN gas_list a ON a.gas_list_id = b.gas_list_id
                LEFT JOIN gas_dot_control c ON c.gas_list_id = b.gas_list_id
                LEFT JOIN users p ON p.id = b.user_id
                WHERE b.check_date BETWEEN "'.$startdate.'" AND "'.$enddate.'" AND b.gas_type IN("6","7","8","9")
                ORDER BY b.gas_check_id DESC
            ');
        }

        return view('support_prs.gas.gas_control',[
            'startdate'     => $startdate,
            'enddate'       => $enddate,
            'datashow'      => $datashow,
        ]);
    }
    public function gas_control_add(Request $request)
    {
        $datenow   = date('Y-m-d');
        $months    = date('m');
        $year      = date('Y');
        $startdate = $request->startdate;
        $enddate   = $request->enddate;
        $newweek   = date('Y-m-d', strtotime($datenow . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
        $newDate   = date('Y-m-d', strtotime($datenow . ' -1 months')); //ย้อนหลัง 1 เดือน
        $newyear   = date('Y-m-d', strtotime($datenow . ' -1 year')); //ย้อนหลัง 1 ปี
        $bgs_year      = DB::table('budget_year')->where('years_now','Y')->first();
        $bg_yearnow    = $bgs_year->leave_year_id;
        if ($startdate =='') {
            $datashow = DB::select(
                'SELECT a.gas_list_num,a.gas_list_name,a.detail,a.size
                ,b.check_year,b.check_date,b.check_time,b.gas_check_body,b.gas_check_body_name,b.gas_check_valve,b.gas_check_valve_name
                ,b.gas_check_pressure,b.gas_check_pressure_name,b.gas_check_pressure_min,b.gas_check_pressure_max,b.standard_value
                ,b.standard_value_min,b.standard_value_max,concat(p.fname," ",p.lname) as ptname
                FROM gas_check b
                LEFT JOIN gas_list a ON a.gas_list_id = b.gas_list_id
                LEFT JOIN users p ON p.id = a.user_id
                WHERE b.check_date BETWEEN "'.$newDate.'" AND "'.$datenow.'" AND b.gas_type IN("6","7","8","9")
                ORDER BY b.gas_check_id DESC
            ');
        } else {
            $datashow = DB::select(
                'SELECT a.gas_list_num,a.gas_list_name,a.detail,a.size
                ,b.check_year,b.check_date,b.check_time,b.gas_check_body,b.gas_check_body_name,b.gas_check_valve,b.gas_check_valve_name
                ,b.gas_check_pressure,b.gas_check_pressure_name,b.gas_check_pressure_min,b.gas_check_pressure_max,b.standard_value
                ,b.standard_value_min,b.standard_value_max,concat(p.fname," ",p.lname) as ptname
                FROM gas_check b
                LEFT JOIN gas_list a ON a.gas_list_id = b.gas_list_id
                LEFT JOIN users p ON p.id = a.user_id
                WHERE b.check_date BETWEEN "'.$startdate.'" AND "'.$enddate.'" AND b.gas_type IN("6","7","8","9")
                ORDER BY b.gas_check_id DESC
            ');
        }

        $data_                  = DB::table('gas_list')->where('gas_type','1')->first();
        $data['gas_list_id']    = $data_->gas_list_id;
        $data['gas_type']       = $data_->gas_type;
        $m             = date('H');
        $data['mm']    = date('H:m:s');
        $datefull = date('Y-m-d H:m:s');
        $data['gas_list_group'] = $datashow = DB::select('SELECT gas_list_id,dot,dot_name,location_name,detail,class FROM gas_list WHERE dot IS NOT NULL GROUP BY dot');
        // AND gas_year ="'.$bg_yearnow.'"
        return view('support_prs.gas.gas_control_add',$data,[
            'startdate'     => $startdate,
            'enddate'       => $enddate,
            'datashow'      => $datashow,
        ]);
    }
    public function gas_control_addsave(Request $request)
    {
        Gas_dot_control::truncate();
        $id = $request->dot;
        $bgs_year      = DB::table('budget_year')->where('years_now','Y')->first();
        $bg_yearnow    = $bgs_year->leave_year_id;

        $data_  = DB::table('gas_list')->where('gas_list_id',$id)->first();
        // ->where('gas_year',$bg_yearnow)
            Gas_dot_control::insert([
                'dot'               => $data_->dot,
                'gas_list_id'       => $id,
                'gas_list_num'      => $data_->gas_list_num,
                'gas_list_name'     => $data_->gas_list_name,
                'gas_type'          => $data_->gas_type,
                'dot_name'          => $data_->dot_name,
                'location_id'       => $data_->location_id,
                'location_name'     => $data_->location_name,
                'detail'            => $data_->detail,
                'class'             => $data_->class,
            ]);

            return response()->json([
                'status'     => '200'
            ]);

    }
    public function gas_control_addsub(Request $request)
    {
        $datenow   = date('Y-m-d');
        $months    = date('m');
        $year      = date('Y');
        $startdate = $request->startdate;
        $enddate   = $request->enddate;
        $newweek   = date('Y-m-d', strtotime($datenow . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
        $newDate   = date('Y-m-d', strtotime($datenow . ' -1 months')); //ย้อนหลัง 1 เดือน
        $newyear   = date('Y-m-d', strtotime($datenow . ' -1 year')); //ย้อนหลัง 1 ปี
        if ($startdate =='') {
            $datashow = DB::select(
                'SELECT a.gas_list_num,a.gas_list_name,a.detail,a.size
                ,b.check_year,b.check_date,b.check_time,b.gas_check_body,b.gas_check_body_name,b.gas_check_valve,b.gas_check_valve_name
                ,b.gas_check_pressure,b.gas_check_pressure_name,b.gas_check_pressure_min,b.gas_check_pressure_max,b.standard_value
                ,b.standard_value_min,b.standard_value_max,concat(p.fname," ",p.lname) as ptname
                FROM gas_check b
                LEFT JOIN gas_list a ON a.gas_list_id = b.gas_list_id
                LEFT JOIN users p ON p.id = a.user_id
                WHERE b.check_date BETWEEN "'.$newDate.'" AND "'.$datenow.'" AND b.gas_type IN("6","7","8","9")
                ORDER BY b.gas_check_id DESC
            ');
        } else {
            $datashow = DB::select(
                'SELECT a.gas_list_num,a.gas_list_name,a.detail,a.size
                ,b.check_year,b.check_date,b.check_time,b.gas_check_body,b.gas_check_body_name,b.gas_check_valve,b.gas_check_valve_name
                ,b.gas_check_pressure,b.gas_check_pressure_name,b.gas_check_pressure_min,b.gas_check_pressure_max,b.standard_value
                ,b.standard_value_min,b.standard_value_max,concat(p.fname," ",p.lname) as ptname
                FROM gas_check b
                LEFT JOIN gas_list a ON a.gas_list_id = b.gas_list_id
                LEFT JOIN users p ON p.id = a.user_id
                WHERE b.check_date BETWEEN "'.$startdate.'" AND "'.$enddate.'" AND b.gas_type IN("6","7","8","9")
                ORDER BY b.gas_check_id DESC
            ');
        }

        $data_                  = DB::table('gas_dot_control')->where('gas_dot_control_id','1')->first();
        $data['gas_list_id']    = $data_->gas_list_id;
        $data['gas_list_num']   = $data_->gas_list_num;
        $data['gas_list_name']  = $data_->gas_list_name;
        $data['gas_type']       = $data_->gas_type;
        $data['dot']            = $data_->dot;
        $data['dot_name']       = $data_->dot_name;
        $data['location_id']    = $data_->location_id;
        $data['location_name']  = $data_->location_name;
        $data['detail']         = $data_->detail;
        $data['class']          = $data_->class;



        $m             = date('H');
        $data['mm']    = date('H:m:s');
        $datefull = date('Y-m-d H:m:s');
        $data['gas_list_group'] = $datashow = DB::select('SELECT gas_list_id,dot,dot_name,location_name,detail,class FROM gas_list WHERE dot IS NOT NULL GROUP BY dot');

        return view('support_prs.gas.gas_control_addsub',$data,[
            'startdate'     => $startdate,
            'enddate'       => $enddate,
            'datashow'      => $datashow,
        ]);
    }
    public function gas_control_addsub_save(Request $request)
    {
            $idgas         = Gas_list::where('gas_list_id', $request->gas_list_id)->first();
            $gas_list_id   = $idgas->gas_list_id;
            $gas_list_num  = $idgas->gas_list_num;
            $gas_list_name = $idgas->gas_list_name;
            $size          = $idgas->size;
            $gas_type      = $idgas->gas_type;

            $date          = date('Y-m-d');
            $y             = date('Y')+543;
            $m             = date('H');
            $mm            = date('H:m:s');
            $datefull      = date('Y-m-d H:m:s');
            $check         = Gas_check::where('gas_list_id', $gas_list_id)->where('check_date', $date)->count();
            $iduser        = Auth::user()->id;
            $name_         = User::where('id', '=',$iduser)->first();
            $name_check    = $name_->fname. '  '.$name_->lname;
            if ($check > 0) {
                // Gas_check::where('gas_list_id', $gas_list_id)->where('check_date', $date)->update([
                //     'check_date'         => $date,
                //     'active'             => $active,
                //     'user_id'            => $iduser,
                // ]);
                // Gas_list::where('gas_list_id', $gas_list_id)->update([
                //     'active'             => $active,
                //     'user_id'            => $iduser,
                // ]);
            } else {
                Gas_check::insert([
                    'check_year'               => $y,
                    'check_date'               => $date,
                    'check_time'               => $mm,
                    'gas_list_id'              => $gas_list_id,
                    'gas_list_num'             => $gas_list_num,
                    'gas_list_name'            => $gas_list_name,
                    'size'                     => $size,
                    'gas_type'                 => $gas_type,
                    'active'                   => $request->active_edit,
                    'user_id'                  => $iduser,

                    'oxygen_check'            => $request->oxygen_check,
                    'nitrous_oxide_check'     => $request->nitrous_oxide_check,
                    'pneumatic_air_check'     => $request->pneumatic_air_check,
                    'vacuum_check'            => $request->vacuum_check,
                ]);
                // Gas_list::where('gas_list_id', $gas_list_id)->update([
                    // 'active'             => $active,
                    // 'user_id'            => $iduser,
                // ]);

                if ( $request->active_edit == 'Ready') {
                    $active = 'พร้อมใช้งาน';
                } else {
                    $active = 'ไม่พร้อมใช้งาน';
                }


                //แจ้งเตือนไลน์
                // if ($request->pariman_value < '50') {
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
                $header = "ตรวจสอบ Control Gas";
                $message =  $header.
                "\n" . "วันที่ตรวจสอบ: " . DateThailine($date).
                "\n" . "เวลา : " . $mm ."".
                "\n" . "อาคาร : " . $request->location_name .
                "\n" . "ชั้น : " . $request->class_edit .
                "\n" . "จุดตรวจเช็ค : " . $request->dot_name .
                "\n" . "Oxygen Control : " . $request->oxygen_check .
                "\n" . "Nitrous oxide Control : " . $request->nitrous_oxide_check .
                "\n" . "Pneumatic Air Control : " . $request->pneumatic_air_check .
                "\n" . "Vacuum Control : " . $request->vacuum_check.
                "\n" . "ผู้ตรวจสอบ : " . $name_check.
                "\n" . "สถานะ : " . $active;

                $linesend_tech = "YNWHjzi9EA6mr5myMrcTvTaSlfOMPHMOiCyOfeSJTHr"; //ช่างซ่อม
                $linesend      = "u0prMwfXLUod8Go1E0fJUxmMaLUmC40tBgcHgbHFgNG";  // พรส

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
                    }
                    curl_close($chOne);
                }

                if ($linesend_tech == null) {
                    $test2 = '';
                } else {
                    $test2 = $linesend_tech;
                }
                if ($test2 !== '' && $test2 !== null) {
                    $chOne_tech = curl_init();
                    curl_setopt($chOne_tech, CURLOPT_URL, "https://notify-api.line.me/api/notify");
                    curl_setopt($chOne_tech, CURLOPT_SSL_VERIFYHOST, 0);
                    curl_setopt($chOne_tech, CURLOPT_SSL_VERIFYPEER, 0);
                    curl_setopt($chOne_tech, CURLOPT_POST, 1);
                    curl_setopt($chOne_tech, CURLOPT_POSTFIELDS, $message);
                    curl_setopt($chOne_tech, CURLOPT_POSTFIELDS, "message=$message");
                    curl_setopt($chOne_tech, CURLOPT_FOLLOWLOCATION, 1);
                    $headers2 = array('Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer ' . $test2 . '',);
                    curl_setopt($chOne_tech, CURLOPT_HTTPHEADER, $headers2);
                    curl_setopt($chOne_tech, CURLOPT_RETURNTRANSFER, 1);
                    $result2 = curl_exec($chOne_tech);
                    if (curl_error($chOne_tech)) {
                        echo 'error:' . curl_error($chOne_tech);
                    } else {
                        $result_2 = json_decode($result2, true);
                    }
                    curl_close($chOne_tech);
                }

                return response()->json([
                    'status'     => '200'
                ]);

            }

            return response()->json([
                'status'     => '100'
            ]);
    }

    // ************************ คลัง ****************************
    public function gas_stocklist(Request $request)
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

        // $data['wh_product']         = DB::select(
        //     'SELECT a.pro_id,a.pro_num,a.pro_year,a.pro_code,a.pro_name,b.wh_type_name,c.wh_unit_name
        //     ,e.stock_qty,e.stock_rep,e.stock_pay,e.stock_total,e.stock_price
        //     ,a.active
        //         ,IFNULL(d.wh_unit_pack_qty,"1") as wh_unit_pack_qty
        //         ,IFNULL(d.wh_unit_pack_name,c.wh_unit_name) as unit_name,f.stock_list_name

        //         FROM wh_stock e
        //         LEFT JOIN wh_product a ON a.pro_id = e.pro_id
        //         LEFT JOIN wh_type b ON b.wh_type_id = a.pro_type
        //         LEFT JOIN wh_unit c ON c.wh_unit_id = a.unit_id
        //         LEFT JOIN wh_unit_pack d ON d.wh_unit_id = a.pro_id
        //         LEFT JOIN wh_stock_list f ON f.stock_list_id = e.stock_list_id
        //     WHERE a.active ="Y" AND e.stock_year ="'.$bg_yearnow.'"
        //     GROUP BY e.pro_id
        // ');
        if ($startdate =='') {
            $data['wh_recieve']         = DB::select(
                'SELECT r.wh_recieve_id,r.year,r.recieve_date,r.recieve_time,r.recieve_no,r.stock_list_id,r.vendor_id,r.active
                ,a.supplies_name,r.recieve_po_sup,s.stock_list_name,concat(u.fname," ",u.lname) as ptname
                ,(SELECT SUM(total_price) FROM wh_recieve_sub WHERE wh_recieve_id = r.wh_recieve_id) as total_price
                FROM wh_recieve r
                LEFT JOIN wh_stock_list s ON s.stock_list_id = r.stock_list_id
                LEFT JOIN air_supplies a ON a.air_supplies_id = r.vendor_id
                LEFT JOIN users u ON u.id = r.user_recieve
                WHERE s.stock_list_id = "10"
                ORDER BY wh_recieve_id DESC
            ');
        } else {
            $data['wh_recieve']         = DB::select(
                'SELECT r.wh_recieve_id,r.year,r.recieve_date,r.recieve_time,r.recieve_no,r.stock_list_id,r.vendor_id,r.active
                ,a.supplies_name,r.recieve_po_sup,s.stock_list_name,concat(u.fname," ",u.lname) as ptname
                ,(SELECT SUM(total_price) FROM wh_recieve_sub WHERE wh_recieve_id = r.wh_recieve_id) as total_price
                FROM wh_recieve r
                LEFT JOIN wh_stock_list s ON s.stock_list_id = r.stock_list_id
                LEFT JOIN air_supplies a ON a.air_supplies_id = r.vendor_id
                LEFT JOIN users u ON u.id = r.user_recieve
                WHERE r.recieve_date BETWEEN "'.$startdate.'" AND "'.$enddate.'" AND r.stock_list_id = "'.$stock_listid.'" AND s.stock_list_id = "10"
                ORDER BY wh_recieve_id DESC
            ');
        }



        return view('support_prs.gas.gas_stocklist',$data,[
            'startdate'     => $startdate,
            'enddate'       => $enddate,
            'bg_yearnow'    => $bg_yearnow,
            'stock_listid'  => $stock_listid
        ]);
    }
    public function gas_stocklist_add(Request $request)
    {
        $startdate           = $request->startdate;
        $enddate             = $request->enddate;
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

        $data['wh_product']         = DB::select(
            'SELECT a.gas_list_id,a.gas_list_name,a.gas_type,b.gas_type_name,c.wh_unit_name,a.size,a.active
            FROM wh_stock e
            LEFT JOIN gas_list a ON a.gas_list_id = e.pro_id
            LEFT JOIN gas_type b ON b.gas_type_id = a.gas_type
            LEFT JOIN wh_unit c ON c.wh_unit_id = e.unit_id
            LEFT JOIN wh_stock_list f ON f.stock_list_id = e.stock_list_id
            WHERE e.stock_year = "'.$bg_yearnow.'" AND e.stock_list_id="10"
            GROUP BY e.pro_id
            ORDER BY a.gas_list_id ASC
        ');


        return view('support_prs.gas.gas_stocklist_add', $data,[
            'startdate'   => $startdate,
            'enddate'     => $enddate,
            'bg_yearnow'  => $bg_yearnow,
        ]);
    }
    public function gas_stocklist_save(Request $request)
    {
        Wh_recieve::insert([
            'year'                 => $request->bg_yearnow,
            'recieve_date'         => $request->recieve_date,
            'recieve_time'         => $request->recieve_time,
            'recieve_no'           => $request->recieve_no,
            'stock_list_id'        => $request->stock_list_id,
            'vendor_id'            => $request->vendor_id,
            'recieve_po_sup'       => $request->recieve_po_sup,
            // 'total_price'          => $request->total_price,
            'user_recieve'         => Auth::user()->id
        ]);
        return response()->json([
            'status'    => '200'
        ]);
    }
    public function gas_stocklist_edit(Request $request,$id)
    {
        $startdate           = $request->startdate;
        $enddate             = $request->enddate;
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

        $data['wh_product']         = DB::select(
            'SELECT a.gas_list_id,a.gas_list_name,a.gas_type,b.gas_type_name,c.wh_unit_name,a.size,a.active
            FROM wh_stock e
            LEFT JOIN gas_list a ON a.gas_list_id = e.pro_id
            LEFT JOIN gas_type b ON b.gas_type_id = a.gas_type
            LEFT JOIN wh_unit c ON c.wh_unit_id = e.unit_id
            LEFT JOIN wh_stock_list f ON f.stock_list_id = e.stock_list_id
            WHERE e.stock_year = "'.$bg_yearnow.'" AND e.stock_list_id="10"
            GROUP BY e.pro_id
            ORDER BY a.gas_list_id ASC
        ');
        $data_edit             = DB::table('wh_recieve')->where('wh_recieve_id','=',$id)->first();

        return view('support_prs.gas.gas_stocklist_edit', $data,[
            'startdate'   => $startdate,
            'enddate'     => $enddate,
            'bg_yearnow'  => $bg_yearnow,
            'data_edit'  => $data_edit,
        ]);
    }
    public function gas_stocklist_update(Request $request)
    {
        $id            = $request->wh_recieve_id;
        Wh_recieve::where('wh_recieve_id',$id)->update([
            'year'                 => $request->bg_yearnow,
            'recieve_date'         => $request->recieve_date,
            'recieve_time'         => $request->recieve_time,
            'recieve_no'           => $request->recieve_no,
            'stock_list_id'        => $request->stock_list_id,
            'recieve_po_sup'       => $request->recieve_po_sup,
            'vendor_id'            => $request->vendor_id,
            'user_recieve'         => Auth::user()->id
        ]);
        return response()->json([
            'status'    => '200'
        ]);
    }

    public function gas_stocklist_addsub(Request $request,$id)
    {
        $startdate  = $request->datepicker;
        $enddate    = $request->datepicker2;

        $data['department']         = Department::get();
        $data['department_sub']     = Departmentsub::get();
        $data['department_sub_sub'] = Departmentsubsub::get();
        $data['position']           = Position::get();
        $data['status']             = Status::get();
        $data['product_unit']       = Product_unit::get();
        $data['wh_unit']            = Wh_unit::get();
        // $data['product_category']   = Products_category::get();
        $data['product_category']   = DB::table('wh_type')->get();
        $yy1                        = date('Y') + 543;
        $yy2                        = date('Y') + 542;
        $yy3                        = date('Y') + 541;
        $bgs_year                   = DB::table('budget_year')->where('years_now','Y')->first();
        $bg_yearnow                 = $bgs_year->leave_year_id;
        $data['air_supplies']       = Air_supplies::where('active','=','Y')->get();
        $data['wh_stock_list']      = DB::table('wh_stock_list')->where('stock_type','=','1')->get();
        $data_edit                  = DB::table('wh_recieve')->where('wh_recieve_id','=',$id)->first();
        $data['wh_recieve_id']      = $data_edit->wh_recieve_id;
        $data['data_year']          = $data_edit->year;
        $data['stock_list_id']      = $data_edit->stock_list_id;

        $data_supplies              = DB::table('air_supplies')->where('air_supplies_id','=',$data_edit->vendor_id)->first();
        $data['supplies_name']      = $data_supplies->supplies_name;
        $data['supplies_tax']       = $data_supplies->supplies_tax;

        $data['wh_product']         = DB::select(
            'SELECT a.gas_list_id,a.gas_list_num,a.gas_list_name,a.gas_type,b.gas_type_name,c.wh_unit_name,a.size,a.active
            FROM wh_stock e
            LEFT JOIN gas_list a ON a.gas_list_id = e.pro_id
            LEFT JOIN gas_type b ON b.gas_type_id = a.gas_type
            LEFT JOIN wh_unit c ON c.wh_unit_id = e.unit_id
            LEFT JOIN wh_stock_list f ON f.stock_list_id = e.stock_list_id
            WHERE e.stock_year ="'.$bg_yearnow.'" AND e.stock_list_id="10"
            GROUP BY e.pro_id
            ORDER BY a.gas_list_id ASC
        ');
        $data['wh_recieve_sub']      = DB::select('SELECT * FROM wh_recieve_sub WHERE wh_recieve_id = "'.$id.'" ORDER BY wh_recieve_sub_id DESC');
        $year                        = substr(date("Y"),2) + 43;
        $mounts                      = date('m');
        $day                         = date('d');
        $time                        = date("His");
        $data['lot_no']              = $year.''.$mounts.''.$day.''.$time;

        return view('support_prs.gas.gas_stocklist_addsub', $data,[
            'startdate'  => $startdate,
            'enddate'    => $enddate,
            'data_edit'  => $data_edit,
        ]);
    }
    public function gas_stocklist_addsub_save(Request $request)
    {
        $ynew          = substr($request->bg_yearnow,2,2);
        $idpro         = $request->pro_id;
        if ($idpro == '') {
            return back();
        } else {

            $pro           = Gas_list::where('gas_list_id',$idpro)->first();
            $proid         = $pro->gas_list_id;
            $pro_code      = $pro->gas_list_num;
            $proname       = $pro->gas_list_name;
            $size          = $pro->size;
            $unitid        = $pro->unit_id;

            $unit          = Wh_unit::where('wh_unit_id',$unitid)->first();
            $idunit        = $unit->wh_unit_id;
            $nameunit      = $unit->wh_unit_name;

            $pro_check     = Wh_recieve_sub::where('wh_recieve_id',$request->wh_recieve_id)->where('pro_id',$proid)->where('recieve_year',$request->data_year)->where('stock_list_id',$request->stock_list_id)->count();
            if ($pro_check > 0) {
                Wh_recieve_sub::where('wh_recieve_id',$request->wh_recieve_id)->where('pro_id',$proid)->where('recieve_year',$request->data_year)->where('stock_list_id',$request->stock_list_id)->update([
                    'pro_code'             => $pro_code,
                    'qty'                  => $request->qty,
                    'one_price'            => $request->one_price,
                    'total_price'          => $request->one_price*$request->qty,
                    'user_id'              => Auth::user()->id
                ]);
            } else {
                Wh_recieve_sub::insert([
                    'wh_recieve_id'        => $request->wh_recieve_id,
                    'stock_list_id'        => $request->stock_list_id,
                    'recieve_year'         => $request->data_year,
                    'pro_id'               => $proid,
                    'pro_code'             => $pro_code,
                    'pro_name'             => $proname,
                    'unit_id'              => $idunit,
                    'unit_name'            => $nameunit,
                    'qty'                  => $request->qty,
                    'one_price'            => $request->one_price,
                    'total_price'          => $request->one_price*$request->qty,
                    'lot_no'               => $request->lot_no,
                    'user_id'              => Auth::user()->id
                ]);
            }

        }

        return response()->json([
            'status'    => '200'
        ]);
    }
    public function load_gasdata_lot_no(Request $request)
    {
        $year                        = substr(date("Y"),2) + 43;
        $mounts                      = date('m');
        $day                         = date('d');
        $time                        = date("His");
        $lot_no                      = $year.''.$mounts.''.$day.''.$time;
        // $output = "'.$lot_no.'";
        // $output.=' "'.$lot_no.'"';
        // echo $output;
        return response()->json([
            'status'    => '200',
             'lot_no'    => $lot_no
        ]);
    }
    public function load_gasdata_table(Request $request)
    {
        $id  = $request->wh_recieve_id;
        $wh_recieve_sub      = DB::select('SELECT * FROM wh_recieve_sub WHERE wh_recieve_id = "'.$id.'" ORDER BY wh_recieve_sub_id DESC');

        $output='
                <table id="Tabledit" class="table table-bordered border-primary table-hover table-sm" style="border-collapse: collapse;border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th class="text-center" style="background-color: rgb(255, 251, 228);font-size: 12px;">ลำดับ</th>
                                <th class="text-center" style="background-color: rgb(174, 236, 245);font-size: 12px;">รหัส</th>
                                <th class="text-center" style="background-color: rgb(174, 236, 245);font-size: 12px;">รายการ</th>
                                <th class="text-center" style="background-color: rgb(174, 236, 245);font-size: 12px;">หน่วยนับ</th>
                                <th class="text-center" style="background-color: rgb(250, 194, 187);font-size: 12px;">LOT</th>
                                <th class="text-center" style="background-color: rgb(187, 250, 221);font-size: 12px;">จำนวน</th>
                                <th class="text-center" style="background-color: rgb(222, 201, 248);font-size: 12px;" width="10%">ราคา</th>
                                <th class="text-center" style="background-color: rgb(248, 201, 221);font-size: 12px;" width="10%">ราคารวม</th>
                                <th width="5%" class="text-center"><input type="checkbox" class="dcheckbox_" name="stamp" id="stamp"> </th>
                            </tr>
                        </thead>
                    <tbody>
                        ';

                        $i = 1;
                        foreach ($wh_recieve_sub as $key => $value) {

                            $output.='
                              <tr id="tr_'.$value->wh_recieve_sub_id.'">
                                <td>'.$i++.'</td>
                                <td>'.$value->wh_recieve_sub_id.'</td>
                                <td>'.$value->pro_code.' || '.$value->pro_name.'</td>
                                <td>'.$value->unit_name.'</td>
                                <td>'.$value->lot_no.'</td>
                                <td>'.$value->qty.'</td>
                                <td>'.number_format($value->one_price, 2).'</td>
                                <td>'.number_format($value->total_price, 2).'</td>
                                <td class="text-center" width="5%"><input type="checkbox" class="dcheckbox_ sub_chk" data-id="'.$value->wh_recieve_sub_id.'"> </td>
                            </tr>';
                        }

                        $output.='
                    </tbody>
                </table>

        ';
        echo $output;
    }
    public function load_gasdata_sum(Request $request)
    {
        $year                        = substr(date("Y"),2) + 43;
        $mounts                      = date('m');
        $day                         = date('d');
        $time                        = date("His");
        $lot_no                      = $year.''.$mounts.''.$day.''.$time;
        $id                          = $request->wh_recieve_id;
        $wh_recieve_sub              = DB::select('SELECT SUM(total_price) as total_price FROM wh_recieve_sub WHERE wh_recieve_id = "'.$id.'"');
        foreach ($wh_recieve_sub as $key => $value) {
            $total   = $value->total_price;
        }

        return response()->json([
            'status'    => '200',
             'total'    => $total
        ]);
    }
    public function gas_stocklist_destrouy(Request $request)
    {
        $id             = $request->ids;

        Wh_recieve_sub::whereIn('wh_recieve_sub_id',explode(",",$id))->delete();
        // Wh_stock_card::whereIn('wh_recieve_sub_id',explode(",",$id))->delete();

        return response()->json([
            'status'    => '200'
        ]);
    }
    public function gas_stocklist_updatestock(Request $request)
    {
        $id              = $request->wh_recieve_id;
        $data_year       = $request->data_year;
        $stock_list_id   = $request->stock_list_id;
        $stock_name_     = Wh_stock_list::where('stock_list_id',$stock_list_id)->first();
        $stock_name      = $stock_name_->stock_list_name;

        $getdate         = Wh_recieve_sub::where('wh_recieve_id',$id)->get();
        foreach ($getdate as $key => $value) {
            $stock_check   = Wh_stock::where('stock_year',$data_year)->where('stock_list_id',$stock_list_id)->where('pro_id',$value->pro_id)->count();

            $pro           = Gas_list::where('gas_list_id',$value->pro_id)->first();
            $pro_          = $pro->gas_list_id;
            $pro_code      = $pro->gas_list_num;
            $pro_name      = $pro->gas_list_name;
            $size          = $pro->size;
            $unitid        = $pro->unit_id;


            if ($stock_check > 0) {
                # code...
            } else {
                Wh_stock::insert([
                    'stock_year'       => $data_year,
                    'stock_list_id'    => $stock_list_id,
                    'stock_list_name'  => $stock_name,
                    'pro_id'           => $value->pro_id,
                    'pro_code'         => $pro_code,
                    'pro_name'         => $pro_name,
                    'unit_id'          => $value->unit_id,
                    'stock_price'      => $value->one_price,
                    'stock_qty'        => $value->qty,
                ]);
            }

        }

        $sum_total       = Wh_recieve_sub::where('wh_recieve_id',$id)->sum('total_price');
        Wh_recieve::where('wh_recieve_id',$id)->update([
            'total_price'  => $sum_total,
            'active'       => 'RECIVE',
        ]);


        return response()->json([
            'status'    => '200'
        ]);

    }

    public function report_gas(Request $request)
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

        if ($startdate =='') {
            $data['datashow']         = DB::select(
                'SELECT a.*,b.*
                FROM gas_report a
                LEFT JOIN months b ON b.month_id = a.months
                WHERE bg_yearnow = "'.$bg_yearnow.'"
                GROUP BY gas_report_id
                ORDER BY gas_report_id ASC
            ');
        } else {
            $data['datashow']         = DB::select(
                'SELECT a.*,b.*
                FROM gas_report a
                LEFT JOIN months b ON b.month_id = a.months
                WHERE bg_yearnow = "'.$bg_yearnow.'"
                GROUP BY gas_report_id
                ORDER BY gas_report_id ASC
            ');
            // $data['wh_recieve']         = DB::select(
            //     'SELECT r.wh_recieve_id,r.year,r.recieve_date,r.recieve_time,r.recieve_no,r.stock_list_id,r.vendor_id,r.active
            //     ,a.supplies_name,r.recieve_po_sup,s.stock_list_name,concat(u.fname," ",u.lname) as ptname
            //     ,(SELECT SUM(total_price) FROM wh_recieve_sub WHERE wh_recieve_id = r.wh_recieve_id) as total_price
            //     FROM wh_recieve r
            //     LEFT JOIN wh_stock_list s ON s.stock_list_id = r.stock_list_id
            //     LEFT JOIN air_supplies a ON a.air_supplies_id = r.vendor_id
            //     LEFT JOIN users u ON u.id = r.user_recieve
            //     WHERE r.recieve_date BETWEEN "'.$startdate.'" AND "'.$enddate.'" AND r.stock_list_id = "'.$stock_listid.'" AND s.stock_list_id = "10"
            //     ORDER BY wh_recieve_id DESC
            // ');
        }



        return view('support_prs.gas.report_gas',$data,[
            'startdate'     => $startdate,
            'enddate'       => $enddate,
            'bg_yearnow'    => $bg_yearnow,
            'stock_listid'  => $stock_listid
        ]);
    }

    public function gas_ypkyodauto(Request $request)
    {
        $date_now        = date('Y-m-d');
        $monthsnew       = date('m');
        $yearnew         = date('Y');
        // $iduser          = Auth::user()->id;
        $month_no1       = $request->month_no1;
        $bgs_year        = DB::table('budget_year')->where('years_now','Y')->first();
        $bg_yearnow      = $bgs_year->leave_year_id;
                    $check     = Gas_report::where('months',$monthsnew)->where('bg_yearnow',$bg_yearnow)->count();
                    $count_gas = Gas_list::where('active','Ready')->count();
                        if ($check > 0) {
                        } else {
                            Gas_report::insert([
                                'bg_yearnow'     => $bg_yearnow,
                                'months'         => $monthsnew,
                                'years'          => $yearnew,
                                'years_th'       => $yearnew+543,
                                'total_qty'      => $count_gas,
                                'datesave'       => $date_now,
                                'userid'         => 'Auto',
                            ]);
                        }


                return response()->json([
                    'status'     => '200'
                ]);
    }


 }
