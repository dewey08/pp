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
use App\Models\Env_pond;
use App\Models\Env_pond_sub;
use App\Models\Book_senddep;
use App\Models\Book_senddep_sub;
use App\Models\Book_send_person;
use App\Models\Book_sendteam;
use App\Models\Bookrepdelete;
use App\Models\Car_status;
use App\Models\Car_index;
use App\Models\Article_status;
use App\Models\Car_type;
use App\Models\Product_brand;
use App\Models\Product_color;
use App\Models\Leave_month;
use App\Models\P4p_workload;
use App\Models\P4p_work_position;
use App\Models\P4p_work_score;
use App\Models\P4p_work;
use App\Models\P4p_workset;
use App\Models\P4p_workgroupset_unit;
use App\Models\P4p_workgroupset;

use App\Models\Env_water_parameter;

use App\Models\Env_trash_parameter;
use App\Models\Env_trash_sub;
use App\Models\Env_trash_type;
use App\Models\Env_trash;

use App\Models\Env_water_save;
use App\Models\Env_water_sub;
use App\Models\Env_water;

// use App\Models\Env_pond;
// use App\Models\Env_pond_sub;

use Auth;

class EnvController extends Controller
{

    public function env_dashboard (Request $request)
    {
        $datestart = $request->startdate;
        $dateend = $request->enddate;
        $iduser = Auth::user()->id;
        $data['users'] = User::get();
        $data['leave_month'] = DB::table('leave_month')->get();
        $data['users_group'] = DB::table('users_group')->get();
        $data['p4p_workgroupset'] = P4p_workgroupset::where('p4p_workgroupset_user','=',$iduser)->get();

        $acc_debtors = DB::select('
            SELECT count(*) as I from users u
            left join p4p_workload l on l.p4p_workload_user=u.id
            group by u.dep_subsubtrueid;
        ');

        $water = Env_water::select(DB::raw("COUNT(*) as count"), DB::raw("MONTHNAME(env_water.water_date) as month_name"))
                    // ->leftjoin('env_water_sub','env_water_sub.water_id','=','env_water.water_id')
                    ->whereYear('env_water.water_date', date('Y')-1)
                    ->groupBy(DB::raw("Month(env_water.water_date)"))
                    ->pluck('count', 'month_name');
                    // ->groupBy(DB::raw("Month(env_water.water_date)"),DB::raw("env_water.pond_id"))
        $data['labels'] = $water->keys();
        $data['data'] = $water->values();


        $e1_count_21 = Env_water::where('pond_id','1')->where(DB::raw("Year(water_date)"),'2025')->get()->count();
    	$e1_count_22 = Env_water::where('pond_id','1')->where(DB::raw("Year(water_date)"),'2022')->get()->count();
    	$e1_count_23 = Env_water::where('pond_id','1')->where(DB::raw("Year(water_date)"),'2023')->get()->count();
        $e1_count_24 = Env_water::where('pond_id','1')->where(DB::raw("Year(water_date)"),'2024')->get()->count();


    	$e2_count_21 = Env_water::where('pond_id','2')->where(DB::raw("Year(water_date)"),'2025')->get()->count();
    	$e2_count_22 = Env_water::where('pond_id','2')->where(DB::raw("Year(water_date)"),'2022')->get()->count();
    	$e2_count_23 = Env_water::where('pond_id','2')->where(DB::raw("Year(water_date)"),'2023')->get()->count();
        $e2_count_24 = Env_water::where('pond_id','2')->where(DB::raw("Year(water_date)"),'2024')->get()->count();


    	$e3_count_21 = Env_water::where('pond_id','3')->where(DB::raw("Year(water_date)"),'2025')->get()->count();
    	$e3_count_22 = Env_water::where('pond_id','3')->where(DB::raw("Year(water_date)"),'2022')->get()->count();
    	$e3_count_23 = Env_water::where('pond_id','3')->where(DB::raw("Year(water_date)"),'2023')->get()->count();
        $e3_count_24 = Env_water::where('pond_id','3')->where(DB::raw("Year(water_date)"),'2024')->get()->count();


        $e4_count_21 = Env_water::where('pond_id','4')->where(DB::raw("Year(water_date)"),'2025')->get()->count();
        $e4_count_22 = Env_water::where('pond_id','4')->where(DB::raw("Year(water_date)"),'2022')->get()->count();
        $e4_count_23 = Env_water::where('pond_id','4')->where(DB::raw("Year(water_date)"),'2023')->get()->count();
        $e4_count_24 = Env_water::where('pond_id','4')->where(DB::raw("Year(water_date)"),'2024')->get()->count();


        $w7_1 = Env_water::leftjoin('env_water_sub','env_water_sub.water_id','=','env_water.water_id')->where('env_water_sub.water_list_idd','1')->where(DB::raw("Year(env_water.water_date)"),'2024')->where('env_water_sub.status','=','ปกติ')->get()->count();
        $w7_2 = Env_water::leftjoin('env_water_sub','env_water_sub.water_id','=','env_water.water_id')->where('env_water_sub.water_list_idd','2')->where(DB::raw("Year(env_water.water_date)"),'2024')->where('env_water_sub.status','=','ปกติ')->get()->count();
        $w7_3 = Env_water::leftjoin('env_water_sub','env_water_sub.water_id','=','env_water.water_id')->where('env_water_sub.water_list_idd','3')->where(DB::raw("Year(env_water.water_date)"),'2024')->where('env_water_sub.status','=','ปกติ')->get()->count();
        $w7_4 = Env_water::leftjoin('env_water_sub','env_water_sub.water_id','=','env_water.water_id')->where('env_water_sub.water_list_idd','4')->where(DB::raw("Year(env_water.water_date)"),'2024')->where('env_water_sub.status','=','ปกติ')->get()->count();
        $w7_5 = Env_water::leftjoin('env_water_sub','env_water_sub.water_id','=','env_water.water_id')->where('env_water_sub.water_list_idd','5')->where(DB::raw("Year(env_water.water_date)"),'2024')->where('env_water_sub.status','=','ปกติ')->get()->count();
        $w7_6 = Env_water::leftjoin('env_water_sub','env_water_sub.water_id','=','env_water.water_id')->where('env_water_sub.water_list_idd','6')->where(DB::raw("Year(env_water.water_date)"),'2024')->where('env_water_sub.status','=','ปกติ')->get()->count();
        $w7_7 = Env_water::leftjoin('env_water_sub','env_water_sub.water_id','=','env_water.water_id')->where('env_water_sub.water_list_idd','7')->where(DB::raw("Year(env_water.water_date)"),'2024')->where('env_water_sub.status','=','ปกติ')->get()->count();
        $w7_8 = Env_water::leftjoin('env_water_sub','env_water_sub.water_id','=','env_water.water_id')->where('env_water_sub.water_list_idd','8')->where(DB::raw("Year(env_water.water_date)"),'2024')->where('env_water_sub.status','=','ปกติ')->get()->count();
        $w7_9 = Env_water::leftjoin('env_water_sub','env_water_sub.water_id','=','env_water.water_id')->where('env_water_sub.water_list_idd','9')->where(DB::raw("Year(env_water.water_date)"),'2024')->where('env_water_sub.status','=','ปกติ')->get()->count();
        $w7_10 = Env_water::leftjoin('env_water_sub','env_water_sub.water_id','=','env_water.water_id')->where('env_water_sub.water_list_idd','10')->where(DB::raw("Year(env_water.water_date)"),'2024')->where('env_water_sub.status','=','ปกติ')->get()->count();
        $w7_11 = Env_water::leftjoin('env_water_sub','env_water_sub.water_id','=','env_water.water_id')->where('env_water_sub.water_list_idd','11')->where(DB::raw("Year(env_water.water_date)"),'2024')->where('env_water_sub.status','=','ปกติ')->get()->count();
        $w7_12 = Env_water::leftjoin('env_water_sub','env_water_sub.water_id','=','env_water.water_id')->where('env_water_sub.water_list_idd','12')->where(DB::raw("Year(env_water.water_date)"),'2024')->where('env_water_sub.status','=','ปกติ')->get()->count();
        $w7_13 = Env_water::leftjoin('env_water_sub','env_water_sub.water_id','=','env_water.water_id')->where('env_water_sub.water_list_idd','13')->where(DB::raw("Year(env_water.water_date)"),'2024')->where('env_water_sub.status','=','ปกติ')->get()->count();
        $w7_14 = Env_water::leftjoin('env_water_sub','env_water_sub.water_id','=','env_water.water_id')->where('env_water_sub.water_list_idd','14')->where(DB::raw("Year(env_water.water_date)"),'2024')->where('env_water_sub.status','=','ปกติ')->get()->count();
        $w7_15 = Env_water::leftjoin('env_water_sub','env_water_sub.water_id','=','env_water.water_id')->where('env_water_sub.water_list_idd','15')->where(DB::raw("Year(env_water.water_date)"),'2024')->where('env_water_sub.status','=','ปกติ')->get()->count();
        $w7_16 = Env_water::leftjoin('env_water_sub','env_water_sub.water_id','=','env_water.water_id')->where('env_water_sub.water_list_idd','16')->where(DB::raw("Year(env_water.water_date)"),'2024')->where('env_water_sub.status','=','ปกติ')->get()->count();

        $wm7_1 = Env_water::leftjoin('env_water_sub','env_water_sub.water_id','=','env_water.water_id')->where('env_water_sub.water_list_idd','1')->where(DB::raw("Year(env_water.water_date)"),'2024')->where('env_water_sub.status','=','ผิดปกติ')->get()->count();
        $wm7_2 = Env_water::leftjoin('env_water_sub','env_water_sub.water_id','=','env_water.water_id')->where('env_water_sub.water_list_idd','2')->where(DB::raw("Year(env_water.water_date)"),'2024')->where('env_water_sub.status','=','ผิดปกติ')->get()->count();
        $wm7_3 = Env_water::leftjoin('env_water_sub','env_water_sub.water_id','=','env_water.water_id')->where('env_water_sub.water_list_idd','3')->where(DB::raw("Year(env_water.water_date)"),'2024')->where('env_water_sub.status','=','ผิดปกติ')->get()->count();
        $wm7_4 = Env_water::leftjoin('env_water_sub','env_water_sub.water_id','=','env_water.water_id')->where('env_water_sub.water_list_idd','4')->where(DB::raw("Year(env_water.water_date)"),'2024')->where('env_water_sub.status','=','ผิดปกติ')->get()->count();
        $wm7_5 = Env_water::leftjoin('env_water_sub','env_water_sub.water_id','=','env_water.water_id')->where('env_water_sub.water_list_idd','5')->where(DB::raw("Year(env_water.water_date)"),'2024')->where('env_water_sub.status','=','ผิดปกติ')->get()->count();
        $wm7_6 = Env_water::leftjoin('env_water_sub','env_water_sub.water_id','=','env_water.water_id')->where('env_water_sub.water_list_idd','6')->where(DB::raw("Year(env_water.water_date)"),'2024')->where('env_water_sub.status','=','ผิดปกติ')->get()->count();
        $wm7_7 = Env_water::leftjoin('env_water_sub','env_water_sub.water_id','=','env_water.water_id')->where('env_water_sub.water_list_idd','7')->where(DB::raw("Year(env_water.water_date)"),'2024')->where('env_water_sub.status','=','ผิดปกติ')->get()->count();
        $wm7_8 = Env_water::leftjoin('env_water_sub','env_water_sub.water_id','=','env_water.water_id')->where('env_water_sub.water_list_idd','8')->where(DB::raw("Year(env_water.water_date)"),'2024')->where('env_water_sub.status','=','ผิดปกติ')->get()->count();
        $wm7_9 = Env_water::leftjoin('env_water_sub','env_water_sub.water_id','=','env_water.water_id')->where('env_water_sub.water_list_idd','9')->where(DB::raw("Year(env_water.water_date)"),'2024')->where('env_water_sub.status','=','ผิดปกติ')->get()->count();
        $wm7_10 = Env_water::leftjoin('env_water_sub','env_water_sub.water_id','=','env_water.water_id')->where('env_water_sub.water_list_idd','10')->where(DB::raw("Year(env_water.water_date)"),'2024')->where('env_water_sub.status','=','ผิดปกติ')->get()->count();
        $wm7_11 = Env_water::leftjoin('env_water_sub','env_water_sub.water_id','=','env_water.water_id')->where('env_water_sub.water_list_idd','11')->where(DB::raw("Year(env_water.water_date)"),'2024')->where('env_water_sub.status','=','ผิดปกติ')->get()->count();
        $wm7_12 = Env_water::leftjoin('env_water_sub','env_water_sub.water_id','=','env_water.water_id')->where('env_water_sub.water_list_idd','12')->where(DB::raw("Year(env_water.water_date)"),'2024')->where('env_water_sub.status','=','ผิดปกติ')->get()->count();
        $wm7_13 = Env_water::leftjoin('env_water_sub','env_water_sub.water_id','=','env_water.water_id')->where('env_water_sub.water_list_idd','13')->where(DB::raw("Year(env_water.water_date)"),'2024')->where('env_water_sub.status','=','ผิดปกติ')->get()->count();
        $wm7_14 = Env_water::leftjoin('env_water_sub','env_water_sub.water_id','=','env_water.water_id')->where('env_water_sub.water_list_idd','14')->where(DB::raw("Year(env_water.water_date)"),'2024')->where('env_water_sub.status','=','ผิดปกติ')->get()->count();
        $wm7_15 = Env_water::leftjoin('env_water_sub','env_water_sub.water_id','=','env_water.water_id')->where('env_water_sub.water_list_idd','15')->where(DB::raw("Year(env_water.water_date)"),'2024')->where('env_water_sub.status','=','ผิดปกติ')->get()->count();
        $wm7_16 = Env_water::leftjoin('env_water_sub','env_water_sub.water_id','=','env_water.water_id')->where('env_water_sub.water_list_idd','16')->where(DB::raw("Year(env_water.water_date)"),'2024')->where('env_water_sub.status','=','ผิดปกติ')->get()->count();

        $dabyears = DB::table('budget_year')->get();
        $tra_1 = Env_trash::leftjoin('env_trash_sub','env_trash_sub.trash_id','=','env_trash.trash_id')->where('env_trash_sub.trash_sub_idd','1')->where(DB::raw("Month(env_trash.trash_date)"),'1')->sum('env_trash_sub.trash_sub_qty');
        $tra_2 = Env_trash::leftjoin('env_trash_sub','env_trash_sub.trash_id','=','env_trash.trash_id')->where('env_trash_sub.trash_sub_idd','1')->where(DB::raw("Month(env_trash.trash_date)"),'2')->sum('env_trash_sub.trash_sub_qty');
        $tra_3 = Env_trash::leftjoin('env_trash_sub','env_trash_sub.trash_id','=','env_trash.trash_id')->where('env_trash_sub.trash_sub_idd','1')->where(DB::raw("Month(env_trash.trash_date)"),'3')->sum('env_trash_sub.trash_sub_qty');
        $tra_4 = Env_trash::leftjoin('env_trash_sub','env_trash_sub.trash_id','=','env_trash.trash_id')->where('env_trash_sub.trash_sub_idd','1')->where(DB::raw("Month(env_trash.trash_date)"),'4')->sum('env_trash_sub.trash_sub_qty');
        $tra_5 = Env_trash::leftjoin('env_trash_sub','env_trash_sub.trash_id','=','env_trash.trash_id')->where('env_trash_sub.trash_sub_idd','1')->where(DB::raw("Month(env_trash.trash_date)"),'5')->sum('env_trash_sub.trash_sub_qty');
        $tra_6 = Env_trash::leftjoin('env_trash_sub','env_trash_sub.trash_id','=','env_trash.trash_id')->where('env_trash_sub.trash_sub_idd','1')->where(DB::raw("Month(env_trash.trash_date)"),'6')->sum('env_trash_sub.trash_sub_qty');
        $tra_7 = Env_trash::leftjoin('env_trash_sub','env_trash_sub.trash_id','=','env_trash.trash_id')->where('env_trash_sub.trash_sub_idd','1')->where(DB::raw("Month(env_trash.trash_date)"),'7')->sum('env_trash_sub.trash_sub_qty');
        $tra_8 = Env_trash::leftjoin('env_trash_sub','env_trash_sub.trash_id','=','env_trash.trash_id')->where('env_trash_sub.trash_sub_idd','1')->where(DB::raw("Month(env_trash.trash_date)"),'8')->sum('env_trash_sub.trash_sub_qty');
        $tra_9 = Env_trash::leftjoin('env_trash_sub','env_trash_sub.trash_id','=','env_trash.trash_id')->where('env_trash_sub.trash_sub_idd','1')->where(DB::raw("Month(env_trash.trash_date)"),'9')->sum('env_trash_sub.trash_sub_qty');
        $tra_10 = Env_trash::leftjoin('env_trash_sub','env_trash_sub.trash_id','=','env_trash.trash_id')->where('env_trash_sub.trash_sub_idd','1')->where(DB::raw("Month(env_trash.trash_date)"),'10')->sum('env_trash_sub.trash_sub_qty');
        $tra_11 = Env_trash::leftjoin('env_trash_sub','env_trash_sub.trash_id','=','env_trash.trash_id')->where('env_trash_sub.trash_sub_idd','1')->where(DB::raw("Month(env_trash.trash_date)"),'11')->sum('env_trash_sub.trash_sub_qty');
        $tra_12 = Env_trash::leftjoin('env_trash_sub','env_trash_sub.trash_id','=','env_trash.trash_id')->where('env_trash_sub.trash_sub_idd','1')->where(DB::raw("Month(env_trash.trash_date)"),'12')->sum('env_trash_sub.trash_sub_qty');

        $tra_21 = Env_trash::leftjoin('env_trash_sub','env_trash_sub.trash_id','=','env_trash.trash_id')->where('env_trash_sub.trash_sub_idd','2')->where(DB::raw("Month(env_trash.trash_date)"),'1')->sum('env_trash_sub.trash_sub_qty');
        $tra_22 = Env_trash::leftjoin('env_trash_sub','env_trash_sub.trash_id','=','env_trash.trash_id')->where('env_trash_sub.trash_sub_idd','2')->where(DB::raw("Month(env_trash.trash_date)"),'2')->sum('env_trash_sub.trash_sub_qty');
        $tra_23 = Env_trash::leftjoin('env_trash_sub','env_trash_sub.trash_id','=','env_trash.trash_id')->where('env_trash_sub.trash_sub_idd','2')->where(DB::raw("Month(env_trash.trash_date)"),'3')->sum('env_trash_sub.trash_sub_qty');
        $tra_24 = Env_trash::leftjoin('env_trash_sub','env_trash_sub.trash_id','=','env_trash.trash_id')->where('env_trash_sub.trash_sub_idd','2')->where(DB::raw("Month(env_trash.trash_date)"),'4')->sum('env_trash_sub.trash_sub_qty');
        $tra_25 = Env_trash::leftjoin('env_trash_sub','env_trash_sub.trash_id','=','env_trash.trash_id')->where('env_trash_sub.trash_sub_idd','2')->where(DB::raw("Month(env_trash.trash_date)"),'5')->sum('env_trash_sub.trash_sub_qty');
        $tra_26 = Env_trash::leftjoin('env_trash_sub','env_trash_sub.trash_id','=','env_trash.trash_id')->where('env_trash_sub.trash_sub_idd','2')->where(DB::raw("Month(env_trash.trash_date)"),'6')->sum('env_trash_sub.trash_sub_qty');
        $tra_27 = Env_trash::leftjoin('env_trash_sub','env_trash_sub.trash_id','=','env_trash.trash_id')->where('env_trash_sub.trash_sub_idd','2')->where(DB::raw("Month(env_trash.trash_date)"),'7')->sum('env_trash_sub.trash_sub_qty');
        $tra_28 = Env_trash::leftjoin('env_trash_sub','env_trash_sub.trash_id','=','env_trash.trash_id')->where('env_trash_sub.trash_sub_idd','2')->where(DB::raw("Month(env_trash.trash_date)"),'8')->sum('env_trash_sub.trash_sub_qty');
        $tra_29 = Env_trash::leftjoin('env_trash_sub','env_trash_sub.trash_id','=','env_trash.trash_id')->where('env_trash_sub.trash_sub_idd','2')->where(DB::raw("Month(env_trash.trash_date)"),'9')->sum('env_trash_sub.trash_sub_qty');
        $tra_210 = Env_trash::leftjoin('env_trash_sub','env_trash_sub.trash_id','=','env_trash.trash_id')->where('env_trash_sub.trash_sub_idd','2')->where(DB::raw("Month(env_trash.trash_date)"),'10')->sum('env_trash_sub.trash_sub_qty');
        $tra_211 = Env_trash::leftjoin('env_trash_sub','env_trash_sub.trash_id','=','env_trash.trash_id')->where('env_trash_sub.trash_sub_idd','2')->where(DB::raw("Month(env_trash.trash_date)"),'11')->sum('env_trash_sub.trash_sub_qty');
        $tra_212 = Env_trash::leftjoin('env_trash_sub','env_trash_sub.trash_id','=','env_trash.trash_id')->where('env_trash_sub.trash_sub_idd','2')->where(DB::raw("Month(env_trash.trash_date)"),'12')->sum('env_trash_sub.trash_sub_qty');

        $tra_31 = Env_trash::leftjoin('env_trash_sub','env_trash_sub.trash_id','=','env_trash.trash_id')->where('env_trash_sub.trash_sub_idd','3')->where(DB::raw("Month(env_trash.trash_date)"),'1')->sum('env_trash_sub.trash_sub_qty');
        $tra_32 = Env_trash::leftjoin('env_trash_sub','env_trash_sub.trash_id','=','env_trash.trash_id')->where('env_trash_sub.trash_sub_idd','3')->where(DB::raw("Month(env_trash.trash_date)"),'2')->sum('env_trash_sub.trash_sub_qty');
        $tra_33 = Env_trash::leftjoin('env_trash_sub','env_trash_sub.trash_id','=','env_trash.trash_id')->where('env_trash_sub.trash_sub_idd','3')->where(DB::raw("Month(env_trash.trash_date)"),'3')->sum('env_trash_sub.trash_sub_qty');
        $tra_34 = Env_trash::leftjoin('env_trash_sub','env_trash_sub.trash_id','=','env_trash.trash_id')->where('env_trash_sub.trash_sub_idd','3')->where(DB::raw("Month(env_trash.trash_date)"),'4')->sum('env_trash_sub.trash_sub_qty');
        $tra_35 = Env_trash::leftjoin('env_trash_sub','env_trash_sub.trash_id','=','env_trash.trash_id')->where('env_trash_sub.trash_sub_idd','3')->where(DB::raw("Month(env_trash.trash_date)"),'5')->sum('env_trash_sub.trash_sub_qty');
        $tra_36 = Env_trash::leftjoin('env_trash_sub','env_trash_sub.trash_id','=','env_trash.trash_id')->where('env_trash_sub.trash_sub_idd','3')->where(DB::raw("Month(env_trash.trash_date)"),'6')->sum('env_trash_sub.trash_sub_qty');
        $tra_37 = Env_trash::leftjoin('env_trash_sub','env_trash_sub.trash_id','=','env_trash.trash_id')->where('env_trash_sub.trash_sub_idd','3')->where(DB::raw("Month(env_trash.trash_date)"),'7')->sum('env_trash_sub.trash_sub_qty');
        $tra_38 = Env_trash::leftjoin('env_trash_sub','env_trash_sub.trash_id','=','env_trash.trash_id')->where('env_trash_sub.trash_sub_idd','3')->where(DB::raw("Month(env_trash.trash_date)"),'8')->sum('env_trash_sub.trash_sub_qty');
        $tra_39 = Env_trash::leftjoin('env_trash_sub','env_trash_sub.trash_id','=','env_trash.trash_id')->where('env_trash_sub.trash_sub_idd','3')->where(DB::raw("Month(env_trash.trash_date)"),'9')->sum('env_trash_sub.trash_sub_qty');
        $tra_310 = Env_trash::leftjoin('env_trash_sub','env_trash_sub.trash_id','=','env_trash.trash_id')->where('env_trash_sub.trash_sub_idd','3')->where(DB::raw("Month(env_trash.trash_date)"),'10')->sum('env_trash_sub.trash_sub_qty');
        $tra_311 = Env_trash::leftjoin('env_trash_sub','env_trash_sub.trash_id','=','env_trash.trash_id')->where('env_trash_sub.trash_sub_idd','3')->where(DB::raw("Month(env_trash.trash_date)"),'11')->sum('env_trash_sub.trash_sub_qty');
        $tra_312 = Env_trash::leftjoin('env_trash_sub','env_trash_sub.trash_id','=','env_trash.trash_id')->where('env_trash_sub.trash_sub_idd','3')->where(DB::raw("Month(env_trash.trash_date)"),'12')->sum('env_trash_sub.trash_sub_qty');

        return view('env.env_dashboard',compact('dabyears',
            'e1_count_21','e1_count_22','e1_count_23','e1_count_24'
            ,'e2_count_21','e2_count_22','e2_count_23','e2_count_24'
            ,'e3_count_21','e3_count_22','e3_count_23','e3_count_24'
            ,'e4_count_21','e4_count_22','e4_count_23','e4_count_24'

            //  'e1_count_24'
            // ,'e2_count_24'
            // ,'e3_count_24'
            // ,'e4_count_24'

            ,'w7_1','w7_2','w7_3','w7_4','w7_5','w7_6','w7_7','w7_8','w7_9','w7_10','w7_11','w7_12','w7_13','w7_14','w7_15','w7_16'
            ,'wm7_1','wm7_2','wm7_3','wm7_4','wm7_5','wm7_6','wm7_7','wm7_8','wm7_9','wm7_10','wm7_11','wm7_12','wm7_13','wm7_14','wm7_15','wm7_16'

            ,'tra_1','tra_2','tra_3','tra_4','tra_5','tra_6','tra_7','tra_8','tra_9','tra_10','tra_11','tra_12'
            ,'tra_21','tra_22','tra_23','tra_24','tra_25','tra_26','tra_27','tra_28','tra_29','tra_210','tra_211','tra_212'
            ,'tra_31','tra_32','tra_33','tra_34','tra_35','tra_36','tra_37','tra_38','tra_39','tra_310','tra_311','tra_312'


        ));

    }

//**************************************************************ระบบน้ำเสีย*********************************************

    public function env_water (Request $request)
    {
        $date = date('Y-m-d');
        $y = date('Y') + 543;
        $newweek = date('Y-m-d', strtotime($date . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
        $newDate = date('Y-m-d', strtotime($date . ' -2 months')); //ย้อนหลัง 2 เดือน
        $newyear = date('Y-m-d', strtotime($date . ' -1 year')); //ย้อนหลัง 1 ปี
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        $iduser = Auth::user()->id;
        // dd( $datestart);
        if ($startdate == '') {
                // $data['datashow_1'] = DB::connection('mysql')->select('
                //     SELECT *
                //     FROM env_water_sub
                //     WHERE pond_id ="1"
                // ');
                $data['datashow_1'] = DB::connection('mysql')->select('
                    SELECT w.water_id , w.water_date , w.water_location , CONCAT(u.fname," ",u.lname) as water_user ,w.water_comment
                    FROM env_water w
                    LEFT JOIN users u on u.id = w.water_user
                    WHERE pond_id ="1"
                    ORDER BY water_date DESC
                ');
                $data['datashow_2'] = DB::connection('mysql')->select('
                    SELECT w.water_id , w.water_date , w.water_location , CONCAT(u.fname," ",u.lname) as water_user ,w.water_comment
                    FROM env_water w
                    LEFT JOIN users u on u.id = w.water_user
                    WHERE pond_id ="2"
                    ORDER BY water_date DESC
                ');
                $data['datashow_3'] = DB::connection('mysql')->select('
                    SELECT w.water_id , w.water_date , w.water_location , CONCAT(u.fname," ",u.lname) as water_user ,w.water_comment
                    FROM env_water w
                    LEFT JOIN users u on u.id = w.water_user
                    WHERE pond_id ="3"
                    ORDER BY water_date DESC
                ');
                $data['datashow_4'] = DB::connection('mysql')->select('
                    SELECT w.water_id , w.water_date , w.water_location , CONCAT(u.fname," ",u.lname) as water_user ,w.water_comment
                    FROM env_water w
                    LEFT JOIN users u on u.id = w.water_user
                    WHERE pond_id ="4"
                    ORDER BY water_date DESC
                ');
        } else {
            $datashow = DB::connection('mysql')->select('
                SELECT DISTINCT(w.water_id),w.water_date,w.water_location,water_group_excample,w.water_comment,CONCAT(u.fname," ",u.lname) as water_user
                from env_water w
                LEFT JOIN env_water_sub ws on ws.water_id = w.water_id
                LEFT JOIN users u on u.id = w.water_user
                WHERE w.water_date BETWEEN "'.$startdate.'" AND "'.$enddate.'"
                GROUP BY w.pond_id
                ORDER BY w.water_id DESC
            ');
        }

        return view('env.env_water',$data,[
            'startdate' => $startdate,
            'enddate'   => $enddate,
            // 'datashow'  => $datashow,
        ]);
    }

    public function env_water_add (Request $request) //เพิ่ม รายการ Parameter
    {
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        $iduser = Auth::user()->id;
        $data['users'] = User::get();
        $data['env_pond'] = DB::table('env_pond')->get();
        $data['leave_month'] = DB::table('leave_month')->get();
        $data['users_group'] = DB::table('users_group')->get();
        $data['p4p_workgroupset'] = P4p_workgroupset::where('p4p_workgroupset_user','=',$iduser)->get();

        $data_parameter = DB::table('env_water_parameter')->where('water_parameter_active','=','TRUE')->get();

        return view('env.env_water_add', $data,[
            'start'           => $startdate,
            'end'             => $enddate,
            'dataparameters'  => $data_parameter,
        ]);
    }

    public function env_water_save (Request $request) //บันทึกข้อมูลการตรวจน้ำ
    {
        $startdate = $request->startdate;
        $enddate = $request->enddate;

        $iduser = $request->water_user1;
        $data['users'] = User::get();
        $data['leave_month'] = DB::table('leave_month')->get();
        $data['users_group'] = DB::table('users_group')->get();
        $data['p4p_workgroupset'] = P4p_workgroupset::where('p4p_workgroupset_user','=',$iduser)->get();

        $acc_debtors = DB::select('
            SELECT count(*) as I from users u
            left join p4p_workload l on l.p4p_workload_user=u.id
            group by u.dep_subsubtrueid;
        ');

        $idpon =  $request->env_pond;
        $namepond = Env_pond::where('pond_id','=', $idpon)->first();

        $add = new Env_water();
        $add->water_date            = $request->input('water_date');
        $add->water_user            = $request->input('water_user');
        $add->pond_id               = $namepond->pond_id;
        $add->water_location        = $namepond->pond_name;
        $add->water_group_excample  = $request->input('water_group_excample');
        $add->water_comment         = $request->input('water_comment');

        $add->save();

        $waterid =  Env_water::max('water_id');

        if($request->water_parameter_id != '' || $request->water_parameter_id != null){

            $water_parameter_id                             = $request->water_parameter_id;
            $water_parameter_unit                           = $request->water_parameter_unit;
            $use_analysis_results                           = $request->use_analysis_results;
            $water_parameter_normal                         = $request->water_parameter_normal;
            $water_qty                                      = $request->water_qty;
            $water_parameter_short_name                     = $request->water_parameter_short_name;

            $number =count($water_parameter_id);
            $count = 0;
                for($count = 0; $count< $number; $count++)
                {
                    $idwater = Env_water_parameter::where('water_parameter_id','=',$water_parameter_id[$count])->first();

                    $add_sub = new Env_water_sub();
                    $add_sub->water_id                              = $waterid;
                    $add_sub->water_list_idd                        = $idwater->water_parameter_id;
                    $add_sub->water_list_detail                     = $idwater->water_parameter_name;
                    $add_sub->water_list_unit                       = $water_parameter_unit[$count];
                    $add_sub->water_qty                             = $water_qty[$count];
                    $add_sub->water_results                         = $idwater->water_parameter_icon.''.$idwater->water_parameter_normal;
                    $add_sub->use_analysis_results                  = $idwater->water_parameter_icon_end.''.$idwater->water_parameter_normal_end;

                    $qty = $water_qty[$count];

                    if ($idwater->water_parameter_id == '1' && $qty <= '20' ) {
                        $status = 'ปกติ';
                    }elseif($idwater->water_parameter_id == '2' && $qty <= '120' ) {
                        $status = 'ปกติ';
                    }elseif($idwater->water_parameter_id == '3' && $qty <= '500' ) {
                        $status = 'ปกติ';
                    }elseif($idwater->water_parameter_id == '4' && $qty <= '30' ) {
                        $status = 'ปกติ';
                    }elseif($idwater->water_parameter_id == '5' && $qty <= '0.5' ) {
                        $status = 'ปกติ';
                    }elseif($idwater->water_parameter_id == '6' && $qty <= '35' ) {
                        $status = 'ปกติ';
                    }elseif($idwater->water_parameter_id == '7' && $qty >= '4.9' && $idwater->water_parameter_id == '7' && $qty <= '9') {
                        $status = 'ปกติ';
                    }elseif($idwater->water_parameter_id == '8' && $qty <= '1.0' ) {
                        $status = 'ปกติ';
                    }elseif($idwater->water_parameter_id == '9' && $qty <= '20' ) {
                        $status = 'ปกติ';
                    }elseif($idwater->water_parameter_id == '10' && $qty <= '5000' ) {
                        $status = 'ปกติ';
                    }elseif($idwater->water_parameter_id == '11' && $qty <= '1000' ) {
                        $status = 'ปกติ';
                    }elseif($idwater->water_parameter_id == '12' && $qty <= '1' ) {
                        $status = 'ปกติ';
                    }elseif($idwater->water_parameter_id == '13' && $qty <= '1000' ) {
                        $status = 'ปกติ';
                    }elseif($idwater->water_parameter_id == '14' && $qty >= '2' ) {
                        $status = 'ปกติ';
                    }elseif($idwater->water_parameter_id == '15' && $qty >= '400' ) {
                        $status = 'ปกติ';
                    }elseif($idwater->water_parameter_id == '16' && $qty >= '0.5' && $idwater->water_parameter_id == '16' && $qty <= '1') {
                        $status = 'ปกติ';
                    } else {
                        $status = 'ผิดปกติ';
                    }


                    $add_sub->status                         = $status;
                    $add_sub->water_parameter_short_name     = $water_parameter_short_name[$count];
                    $add_sub->save();
                }
        }

        // $idsub = Env_water_parameter::max('water_parameter_id');
        $data_loob = Env_water_sub::where('water_id','=',$waterid)->get();
        // $name = User::where('id','=',$iduser)->first();
        $data_users = User::where('id','=',$request->water_user)->first();
        $name = $data_users->fname.' '.$data_users->lname;

        $mMessage = array();
        foreach ($data_loob as $key => $value) {

               $mMessage[] = [
                    'water_parameter_short_name'    => $value->water_parameter_short_name,
                    'water_qty'                     => $value->water_qty,
                    'status'                        => $value->status,
                ];
            }

            $linetoken = "q2PXmPgx0iC5IZXjtkeZUFiNwtmEkSGjRp1PsxFUaYe"; //ใส่ token line ENV แล้ว
            //$linetoken = "DVWB9QFYmafdjEl9rvwB0qdPgCdsD59NHoWV7WhqbN4"; //ใส่ token line ENV แล้ว

            // $smessage = [];
            $header = "ข้อมูลตรวจน้ำ";
            $message =  $header.
                    "\n"."วันที่บันทึก : "      . $request->input('water_date').
                   "\n"."ผู้บันทึก  : "        . $name .
                   "\n"."สถานที่เก็บตัวอย่าง : " . $namepond->pond_name;

            foreach ($mMessage as $key => $smes) {
                $na_mesage           = $smes['water_parameter_short_name'];
                $qt_mesage           = $smes['water_qty'];
                $status_mesage       = $smes['status'];

                $message.="\n"."รายการพารามิเตอร์  : " . $na_mesage .
                          "\n"."ผลการวิเคราะห์ : " . $qt_mesage .
                          "\n"."สถานะ : "       . $status_mesage;
            }


                if($linetoken == null){
                    $send_line ='';
                }else{
                    $send_line = $linetoken;
                }
                if($send_line !== '' && $send_line !== null){

                    // function notify_message($smessage,$linetoken)
                    // {
                        $chOne = curl_init();
                        curl_setopt( $chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify");
                        curl_setopt( $chOne, CURLOPT_SSL_VERIFYHOST, 0);
                        curl_setopt( $chOne, CURLOPT_SSL_VERIFYPEER, 0);
                        curl_setopt( $chOne, CURLOPT_POST, 1);
                        // curl_setopt( $chOne, CURLOPT_POSTFIELDS, $message);
                        curl_setopt( $chOne, CURLOPT_POSTFIELDS, "message=$message");
                        curl_setopt( $chOne, CURLOPT_FOLLOWLOCATION, 1);
                        $headers = array( 'Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer '.$linetoken.'', );
                        curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers);
                        curl_setopt( $chOne, CURLOPT_RETURNTRANSFER, 1);
                        $result = curl_exec($chOne);
                        if (curl_error($chOne)) {echo 'error:' . curl_error($chOne);} else { $result_ = json_decode($result, true);
                            echo "status : " . $result_['status'];
                            echo "message : " . $result_['message'];}
                        curl_close($chOne);
                    // }
                    // foreach ($mMessage as $linetoken) {
                    //     notify_message($linetoken,$smessage);
                    // }

                }

        // }
        return redirect()->route('env.env_water');
    }

    public function env_water_edit (Request $request,$id)
    {
        $datestart = $request->startdate;
        $dateend = $request->enddate;
        $iduser = Auth::user()->id;
        $data['users'] = User::get();

        $data['env_pond'] = DB::table('env_pond')->get();

        $data['leave_month'] = DB::table('leave_month')->get();
        $data['users_group'] = DB::table('users_group')->get();
        $data['p4p_workgroupset'] = P4p_workgroupset::where('p4p_workgroupset_user','=',$iduser)->get();

        $water = DB::table('env_water')
        ->leftJoin('env_pond','env_pond.pond_id','=','env_water.pond_id')
        ->where('water_id','=',$id)->first();
        // pond_id
        $data['env_water_sub']  = DB::table('env_water_sub')->where('water_id','=',$id)->get();

        $data['water_parameter']  = DB::table('env_water_parameter')->get();

        $data['products_vendor'] = Products_vendor::get();

        return view('env.env_water_edit', $data,[
            'startdate'        => $datestart,
            'enddate'          => $dateend,
            'water'            => $water,
            'data'             => $data,
        ]);
    }

    public function env_water_edittable(Request $request,$id)
    {
        if ($request->ajax()) {
            if ($request->action == 'Edit') {
                if ($request->water_list_idd == '1' && $request->water_qty <= '20' ) {
                    $status = 'ปกติ';
                }elseif($request->water_list_idd == '2' && $request->water_qty <= '120' ) {
                    $status = 'ปกติ';
                }elseif($request->water_list_idd == '3' && $request->water_qty <= '500' ) {
                    $status = 'ปกติ';
                }elseif($request->water_list_idd == '4' && $request->water_qty <= '30' ) {
                    $status = 'ปกติ';
                }elseif($request->water_list_idd == '5' && $request->water_qty <= '0.5' ) {
                    $status = 'ปกติ';
                }elseif($request->water_list_idd == '6' && $request->water_qty <= '35' ) {
                    $status = 'ปกติ';
                }elseif($request->water_list_idd == '7' && $request->water_qty >= '4.9' && $request->water_list_idd == '7' && $request->water_qty <= '9') {
                    $status = 'ปกติ';
                }elseif($request->water_list_idd == '8' && $request->water_qty <= '1.0' ) {
                    $status = 'ปกติ';
                }elseif($request->water_list_idd == '9' && $request->water_qty <= '20' ) {
                    $status = 'ปกติ';
                }elseif($request->water_list_idd == '10' && $request->water_qty <= '5000' ) {
                    $status = 'ปกติ';
                }elseif($request->water_list_idd == '11' && $request->water_qty <= '1000' ) {
                    $status = 'ปกติ';
                }elseif($request->water_list_idd == '12' && $request->water_qty <= '1' ) {
                    $status = 'ปกติ';
                }elseif($request->water_list_idd == '13' && $request->water_qty <= '1000' ) {
                    $status = 'ปกติ';
                }elseif($request->water_list_idd == '14' && $request->water_qty >= '2' ) {
                    $status = 'ปกติ';
                }elseif($request->water_list_idd == '15' && $request->water_qty >= '400' ) {
                    $status = 'ปกติ';
                }elseif($request->water_list_idd == '16' && $request->water_qty >= '0.5' && $request->water_list_idd == '16' && $request->water_qty <= '1') {
                    $status = 'ปกติ';
                } else {
                    $status = 'ผิดปกติ';
                }
                $data  = array(
                    'water_qty'        => $request->water_qty,
                    'status'           => $status,
                    // 'one_price'     => $request->one_price,
                    // 'total_price'   => $request->qty * $request->one_price,
                );
                DB::connection('mysql')->table('env_water_sub')->where('water_sub_id', $request->water_sub_id)->update($data);
            }
            return response()->json([
                'status'     => '200'
            ]);
        }
    }

    public function water_sub_destroy (Request $request,$id)
    {

       Env_water_sub::where('water_sub_id','=',$id)->delete();

        // return redirect()->back();
        return response()->json([
            'status'     => '200'
        ]);
    }

    public function env_water_update  (Request $request)
    {
        $datenow = date('Y-m-d H:m:s');
        $id = $request->water_id;
        // $ff = $request->trash_bill_on;
        // dd($ff);
        $update = Env_water::find($id);
        $idpon =  $request->env_pond;
        $namepond = Env_pond::where('pond_id','=', $idpon)->first();

        $update->water_date             = $request->water_date;
        $update->water_user             = $request->water_user;
        $update->pond_id                = $namepond->pond_id;
        $update->water_location         = $namepond->pond_name;
        $update->water_group_excample   = $request->water_group_excample;
        $update->water_comment          = $request->water_comment;

        $update->save();

        Env_water_sub::where('water_id','=',$id)->delete();

        if($request->water_list_idd != '' || $request->water_list_idd != null){

            $water_list_idd             = $request->water_list_idd;
            $water_qty                  = $request->water_qty;
            $water_parameter_unit       = $request->water_parameter_unit;

            $number =count($water_list_idd);
            $count = 0;
                for($count = 0; $count< $number; $count++)
                    {
                        $idtrash = Env_water_parameter::where('SET_WATER_ID','=',$water_list_idd[$count])->first();


                        $add_sub = new Env_water_sub();
                        $add_sub->water_id              = $id;

                        $add_sub->water_list_idd        = $idtrash->water_parameter_id;
                        $add_sub->water_list_detail     = $idtrash->water_parameter_name;

                        $add_sub->water_qty             = $water_qty[$count];
                        $add_sub->water_list_unit       = $water_parameter_unit[$count];
                        $add_sub->save();
                    }
        }

        return redirect()->route('env.env_water');

    }

    public function env_water_delete (Request $request,$id)
    {
       Env_water::destroy($id);
       Env_water_sub::where('water_id','=',$id)->delete();

        return redirect()->back();
    }

    public function env_water_datetime (Request $request)
    {
        $startdate = $request->startdate;
        $enddate = $request->enddate;


        return view('env.env_water', [
            'startdate'  =>  $startdate,
            'enddate'    =>  $enddate,

        ]);
    }

    public function env_water_add_pond (Request $request)
    {
        // $startdate = $request->startdate;
        // $enddate = $request->enddate;


        return view('env.env_water_add_pond', [
            // 'startdate'  =>  $startdate,
            // 'enddate'    =>  $enddate,

        ]);
    }

    public function env_water_add_pond1(Request $request,$id) //บ่อปรับเสถียร
    {
        $startdate     = $request->startdate;
        $enddate       = $request->enddate;

        $data_insert   = $request->data_insert;
        $data['users'] = User::get();

        $dabudget_year = DB::table('budget_year')->where('active', '=', true)->first();
        $leave_month_year = DB::table('leave_month')->orderBy('MONTH_ID', 'ASC')->get();
        $date = date('Y-m-d');
        $y = date('Y') + 543;
        $newweek = date('Y-m-d', strtotime($date . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
        $newDate = date('Y-m-d', strtotime($date . ' -5 months')); //ย้อนหลัง 5 เดือน
        $newyear = date('Y-m-d', strtotime($date . ' -1 year')); //ย้อนหลัง 1 ปี

        if ($data_insert == '') {
            # code...
        } else {

        }

        $datashow = DB::connection('mysql')->select('SELECT * FROM env_pond_sub WHERE pond_id = "1"');

        $count    = DB::table('env_pond_sub')->where('pond_id', '=',$id)->where('water_parameter_id', '=',$request->enddate)->count();
        if ($count > 0) {
            # code...
        } else {

        }

        $env_pond_sub = DB::table('env_pond_sub')->where('pond_id', '=',$id )->get();

        return view('env.env_water_add_pond1', $data, [
            'startdate'        => $startdate,
            'enddate'          => $enddate,
            'datashow'         => $datashow,
            'env_pond_sub'     => $env_pond_sub,
            'idpond'           => $id,

        ]);
    }

    public function env_water_add_pond1_save (Request $request)
    {
        $startdate = $request->startdate;
        $enddate = $request->enddate;

        $iduser = $request->water_user1;

        $data['users'] = User::get();
        $data['leave_month'] = DB::table('leave_month')->get();
        $data['users_group'] = DB::table('users_group')->get();
        $data['p4p_workgroupset'] = P4p_workgroupset::where('p4p_workgroupset_user','=',$iduser)->get();

        $acc_debtors = DB::select('
            SELECT count(*) as I from users u
            left join p4p_workload l on l.p4p_workload_user=u.id
            group by u.dep_subsubtrueid;
        ');

        $idpond =  $request->pond_id;
        $namepond = Env_pond::where('pond_id','=', $idpond)->first();
        $idp =  $namepond->pond_id;;

        $add = new Env_water();
        $add->water_date                = $request->input('water_date');
        $add->water_user                = $request->input('water_user');
        $add->pond_id                   = $namepond->pond_id;
        $add->water_location            = $namepond->pond_name;
        $add->water_group_excample      = $request->input('water_group_excample');
        $add->water_comment             = $request->input('water_comment');
        $add->save();


        $waterid =  Env_water::max('water_id');
        $water_parameter_id = $request->water_parameter_id;
        $namepara = Env_water_parameter::where('water_parameter_id','=', $water_parameter_id)->first();

        if($request->water_parameter_id != '' || $request->water_parameter_id != null){

            $water_parameter_id                             = $request->water_parameter_id;
            // dd($water_parameter_id);
            $water_parameter_unit                           = $request->water_parameter_unit;
            $water_qty                                      = $request->water_qty;
            $water_parameter_short_name                     = $namepara->water_parameter_short_name;
            // dd($water_parameter_short_name);

            $number =count($water_parameter_id);
            // $count = 0;
                for($count = 0; $count< $number; $count++)
                {
                    $idwater = Env_water_parameter::where('water_parameter_id','=',$water_parameter_id[$count])->first();

                    $add_sub = new Env_water_sub();
                    $add_sub->water_id                              = $waterid;
                    $add_sub->water_list_idd                        = $idwater->water_parameter_id;
                    $add_sub->water_list_detail                     = $idwater->water_parameter_name;
                    $add_sub->water_parameter_short_name            = $idwater->water_parameter_short_name;
                    $add_sub->water_list_unit                       = $water_parameter_unit[$count];
                    $add_sub->water_qty                             = $water_qty[$count];
                    $add_sub->water_results                         = $idwater->water_parameter_icon.''.$idwater->water_parameter_normal;
                    $add_sub->use_analysis_results                  = $idwater->water_parameter_icon_end.''.$idwater->water_parameter_normal_end;


                    $qty = $water_qty[$count];

                    if ($idwater->water_parameter_id == '1' && $qty <= '20' ) {
                        $status = 'ปกติ';
                    }elseif($idwater->water_parameter_id == '2' && $qty <= '120' ) {
                        $status = 'ปกติ';
                    }elseif($idwater->water_parameter_id == '3' && $qty <= '1000' ) {
                        $status = 'ปกติ';
                    }elseif($idwater->water_parameter_id == '4' && $qty <= '30' ) {
                        $status = 'ปกติ';
                    }elseif($idwater->water_parameter_id == '5' && $qty <= '0.5' ) {
                        $status = 'ปกติ';
                    }elseif($idwater->water_parameter_id == '6' && $qty <= '35' ) {
                        $status = 'ปกติ';
                    }elseif($idwater->water_parameter_id == '7' && $qty >= '4.9' && $idwater->water_parameter_id == '7' && $qty <= '9') {
                        $status = 'ปกติ';
                    }elseif($idwater->water_parameter_id == '8' && $qty <= '1.0' ) {
                        $status = 'ปกติ';
                    }elseif($idwater->water_parameter_id == '9' && $qty <= '20' ) {
                        $status = 'ปกติ';
                    }elseif($idwater->water_parameter_id == '10' && $qty <= '5000' ) {
                        $status = 'ปกติ';
                    }elseif($idwater->water_parameter_id == '11' && $qty <= '1000' ) {
                        $status = 'ปกติ';
                    }elseif($idwater->water_parameter_id == '12' && $qty <= '1' ) {
                        $status = 'ปกติ';
                    }elseif($idwater->water_parameter_id == '13' && $qty <= '1000' ) {
                        $status = 'ปกติ';
                    }elseif($idwater->water_parameter_id == '14' && $qty >= '2' ) {
                        $status = 'ปกติ';
                    }elseif($idwater->water_parameter_id == '15' && $qty >= '400' ) {
                        $status = 'ปกติ';
                    }elseif($idwater->water_parameter_id == '16' && $qty >= '0.5' && $idwater->water_parameter_id == '16' && $qty <= '1') {
                        $status = 'ปกติ';
                    } else {
                        $status = 'ผิดปกติ';
                    }

                    $add_sub->status                         = $status;

                    $add_sub->save();
                }
        }

        $data_loob = Env_water_sub::where('water_id','=',$waterid)->get();
        $data_users = User::where('id','=',$request->water_user)->first();
        $name = $data_users->fname.' '.$data_users->lname;

        $mMessage = array();
        foreach ($data_loob as $key => $value) {
               $mMessage[] = [
                    'water_parameter_short_name'    => $value->water_parameter_short_name,
                    'water_qty'                     => $value->water_qty,
                    'status'                        => $value->status,
                ];
            }
            $linetoken = "q2PXmPgx0iC5IZXjtkeZUFiNwtmEkSGjRp1PsxFUaYe"; //ใส่ token line ENV แล้ว
            $header = "ข้อมูลตรวจน้ำ";
            $message =  $header.
                    "\n"."วันที่บันทึก : "      . $request->input('water_date').
                   "\n"."ผู้บันทึก  : "        . $name .
                   "\n"."สถานที่เก็บตัวอย่าง : " . $namepond->pond_name;
            foreach ($mMessage as $key => $smes) {
                $na_mesage           = $smes['water_parameter_short_name'];
                $qt_mesage           = $smes['water_qty'];
                $status_mesage       = $smes['status'];
                $message.="\n"."รายการพารามิเตอร์  : " . $na_mesage .
                          "\n"."ผลการวิเคราะห์ : " . $qt_mesage . '  ' . $status_mesage;
                        //   "\n"."สถานะ : "       . $status_mesage;
            }
            if($linetoken == null){
                $send_line ='';
            }else{
                $send_line = $linetoken;
            }
            if($send_line !== '' && $send_line !== null){

                    $chOne = curl_init();
                    curl_setopt( $chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify");
                    curl_setopt( $chOne, CURLOPT_SSL_VERIFYHOST, 0);
                    curl_setopt( $chOne, CURLOPT_SSL_VERIFYPEER, 0);
                    curl_setopt( $chOne, CURLOPT_POST, 1);
                    // curl_setopt( $chOne, CURLOPT_POSTFIELDS, $message);
                    curl_setopt( $chOne, CURLOPT_POSTFIELDS, "message=$message");
                    curl_setopt( $chOne, CURLOPT_FOLLOWLOCATION, 1);
                    $headers = array( 'Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer '.$linetoken.'', );
                    curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers);
                    curl_setopt( $chOne, CURLOPT_RETURNTRANSFER, 1);
                    $result = curl_exec($chOne);
                    if (curl_error($chOne)) {echo 'error:' . curl_error($chOne);} else { $result_ = json_decode($result, true);
                        echo "status : " . $result_['status'];
                        echo "message : " . $result_['message'];}
                    curl_close($chOne);

            }


        return redirect()->route('env.env_water_add_pond',[
            'id'  => $idp
        ]);


    }

    public function env_water_add_pond2 (Request $request,$id) //บ่อคลองวนเวียน
    {
        $startdate     = $request->startdate;
        $enddate       = $request->enddate;
        $data_insert   = $request->data_insert;
        $data['users'] = User::get();
        $dabudget_year = DB::table('budget_year')->where('active', '=', true)->first();
        $leave_month_year = DB::table('leave_month')->orderBy('MONTH_ID', 'ASC')->get();
        $date = date('Y-m-d');
        $y = date('Y') + 543;
        $newweek = date('Y-m-d', strtotime($date . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
        $newDate = date('Y-m-d', strtotime($date . ' -5 months')); //ย้อนหลัง 5 เดือน
        $newyear = date('Y-m-d', strtotime($date . ' -1 year')); //ย้อนหลัง 1 ปี

        if ($data_insert == '') {
            # code...
        } else {

        }

        $datashow = DB::connection('mysql')->select('SELECT * FROM env_pond_sub WHERE pond_id = "2"');

        $count    = DB::table('env_pond_sub')->where('pond_id', '=',$id)->where('water_parameter_id', '=',$request->enddate)->count();
        if ($count > 0) {
            # code...
        } else {

        }

        $env_pond_sub = DB::table('env_pond_sub')->where('pond_id', '=',$id )->get();

        return view('env.env_water_add_pond2', $data, [
            'startdate'        => $startdate,
            'enddate'          => $enddate,
            'datashow'         => $datashow,
            'env_pond_sub'     => $env_pond_sub,
            'idpond'           => $id,


        ]);
    }

    public function env_water_add_pond2_save (Request $request)
    {
        $startdate = $request->startdate;
        $enddate = $request->enddate;

        $iduser = $request->water_user1;

        $data['users'] = User::get();
        $data['leave_month'] = DB::table('leave_month')->get();
        $data['users_group'] = DB::table('users_group')->get();
        $data['p4p_workgroupset'] = P4p_workgroupset::where('p4p_workgroupset_user','=',$iduser)->get();

        $acc_debtors = DB::select('
            SELECT count(*) as I from users u
            left join p4p_workload l on l.p4p_workload_user=u.id
            group by u.dep_subsubtrueid;
        ');

        $idpond =  $request->pond_id;
        $namepond = Env_pond::where('pond_id','=', $idpond)->first();
        $idp =  $namepond->pond_id;

        $add = new Env_water();
        $add->water_date                = $request->input('water_date');
        $add->water_user                = $request->input('water_user');
        $add->pond_id                   = $namepond->pond_id;
        $add->water_location            = $namepond->pond_name;
        $add->water_group_excample      = $request->input('water_group_excample');
        $add->water_comment             = $request->input('water_comment');
        $add->save();


        $waterid =  Env_water::max('water_id');
        $water_parameter_id = $request->water_parameter_id;
        $namepara = Env_water_parameter::where('water_parameter_id','=', $water_parameter_id)->first();

        if($request->water_parameter_id != '' || $request->water_parameter_id != null){

            $water_parameter_id                             = $request->water_parameter_id;
            // dd($water_parameter_id);
            $water_parameter_unit                           = $request->water_parameter_unit;
            $water_qty                                      = $request->water_qty;
            $water_parameter_short_name                     = $namepara->water_parameter_short_name;
            // dd($water_parameter_short_name);

            $number =count($water_parameter_id);
            // $count = 0;
                for($count = 0; $count< $number; $count++)
                {
                    $idwater = Env_water_parameter::where('water_parameter_id','=',$water_parameter_id[$count])->first();

                    $add_sub = new Env_water_sub();
                    $add_sub->water_id                              = $waterid;
                    $add_sub->water_list_idd                        = $idwater->water_parameter_id;
                    $add_sub->water_list_detail                     = $idwater->water_parameter_name;
                    $add_sub->water_parameter_short_name            = $idwater->water_parameter_short_name;
                    $add_sub->water_list_unit                       = $water_parameter_unit[$count];
                    $add_sub->water_qty                             = $water_qty[$count];
                    $add_sub->water_results                         = $idwater->water_parameter_icon.''.$idwater->water_parameter_normal;
                    $add_sub->use_analysis_results                  = $idwater->water_parameter_icon_end.''.$idwater->water_parameter_normal_end;


                    $qty = $water_qty[$count];

                    if ($idwater->water_parameter_id == '1' && $qty <= '20' ) {
                        $status = 'ปกติ';
                    }elseif($idwater->water_parameter_id == '2' && $qty <= '120' ) {
                        $status = 'ปกติ';
                    }elseif($idwater->water_parameter_id == '3' && $qty <= '1000' ) {
                        $status = 'ปกติ';
                    }elseif($idwater->water_parameter_id == '4' && $qty <= '30' ) {
                        $status = 'ปกติ';
                    }elseif($idwater->water_parameter_id == '5' && $qty <= '0.5' ) {
                        $status = 'ปกติ';
                    }elseif($idwater->water_parameter_id == '6' && $qty <= '35' ) {
                        $status = 'ปกติ';
                    }elseif($idwater->water_parameter_id == '7' && $qty >= '4.9' && $idwater->water_parameter_id == '7' && $qty <= '9') {
                        $status = 'ปกติ';
                    }elseif($idwater->water_parameter_id == '8' && $qty <= '1.0' ) {
                        $status = 'ปกติ';
                    }elseif($idwater->water_parameter_id == '9' && $qty <= '20' ) {
                        $status = 'ปกติ';
                    }elseif($idwater->water_parameter_id == '10' && $qty <= '5000' ) {
                        $status = 'ปกติ';
                    }elseif($idwater->water_parameter_id == '11' && $qty <= '1000' ) {
                        $status = 'ปกติ';
                    }elseif($idwater->water_parameter_id == '12' && $qty <= '1' ) {
                        $status = 'ปกติ';
                    }elseif($idwater->water_parameter_id == '13' && $qty <= '1000' ) {
                        $status = 'ปกติ';
                    }elseif($idwater->water_parameter_id == '14' && $qty >= '2' ) {
                        $status = 'ปกติ';
                    }elseif($idwater->water_parameter_id == '15' && $qty >= '400' ) {
                        $status = 'ปกติ';
                    }elseif($idwater->water_parameter_id == '16' && $qty >= '0.5' && $idwater->water_parameter_id == '16' && $qty <= '1') {
                        $status = 'ปกติ';
                    } else {
                        $status = 'ผิดปกติ';
                    }


                    $add_sub->status                         = $status;

                    $add_sub->save();
                }
        }


        $data_loob = Env_water_sub::where('water_id','=',$waterid)->get();
        $data_users = User::where('id','=',$request->water_user)->first();
        $name = $data_users->fname.' '.$data_users->lname;

        $mMessage = array();
        foreach ($data_loob as $key => $value) {
               $mMessage[] = [
                    'water_parameter_short_name'    => $value->water_parameter_short_name,
                    'water_qty'                     => $value->water_qty,
                    'status'                        => $value->status,
                ];
            }
            $linetoken = "q2PXmPgx0iC5IZXjtkeZUFiNwtmEkSGjRp1PsxFUaYe"; //ใส่ token line ENV แล้ว
            $header = "ข้อมูลตรวจน้ำ";
            $message =  $header.
                    "\n"."วันที่บันทึก : "      . $request->input('water_date').
                   "\n"."ผู้บันทึก  : "        . $name .
                   "\n"."สถานที่เก็บตัวอย่าง : " . $namepond->pond_name;
            foreach ($mMessage as $key => $smes) {
                $na_mesage           = $smes['water_parameter_short_name'];
                $qt_mesage           = $smes['water_qty'];
                $status_mesage       = $smes['status'];
                $message.="\n"."รายการพารามิเตอร์  : " . $na_mesage .
                          "\n"."ผลการวิเคราะห์ : " . $qt_mesage . '  ' . $status_mesage;
                        //   "\n"."สถานะ : "       . $status_mesage;
            }
            if($linetoken == null){
                $send_line ='';
            }else{
                $send_line = $linetoken;
            }
            if($send_line !== '' && $send_line !== null){


                    $chOne = curl_init();
                    curl_setopt( $chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify");
                    curl_setopt( $chOne, CURLOPT_SSL_VERIFYHOST, 0);
                    curl_setopt( $chOne, CURLOPT_SSL_VERIFYPEER, 0);
                    curl_setopt( $chOne, CURLOPT_POST, 1);
                    // curl_setopt( $chOne, CURLOPT_POSTFIELDS, $message);
                    curl_setopt( $chOne, CURLOPT_POSTFIELDS, "message=$message");
                    curl_setopt( $chOne, CURLOPT_FOLLOWLOCATION, 1);
                    $headers = array( 'Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer '.$linetoken.'', );
                    curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers);
                    curl_setopt( $chOne, CURLOPT_RETURNTRANSFER, 1);
                    $result = curl_exec($chOne);
                    if (curl_error($chOne)) {echo 'error:' . curl_error($chOne);} else { $result_ = json_decode($result, true);
                        echo "status : " . $result_['status'];
                        echo "message : " . $result_['message'];}
                    curl_close($chOne);

            }


        return redirect()->route('env.env_water_add_pond',[
            'id'  => $idp
        ]);


    }

    public function env_water_add_pond3 (Request $request,$id) //บ่อสัมผัสคลอลีน
    {
        $startdate     = $request->startdate;
        $enddate       = $request->enddate;
        $data_insert   = $request->data_insert;
        $data['users'] = User::get();
        $dabudget_year = DB::table('budget_year')->where('active', '=', true)->first();
        $leave_month_year = DB::table('leave_month')->orderBy('MONTH_ID', 'ASC')->get();
        $date = date('Y-m-d');
        $y = date('Y') + 543;
        $newweek = date('Y-m-d', strtotime($date . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
        $newDate = date('Y-m-d', strtotime($date . ' -5 months')); //ย้อนหลัง 5 เดือน
        $newyear = date('Y-m-d', strtotime($date . ' -1 year')); //ย้อนหลัง 1 ปี

        if ($data_insert == '') {
            # code...
        } else {

        }

        $datashow = DB::connection('mysql')->select('SELECT * FROM env_pond_sub WHERE pond_id = "3"');

        $count    = DB::table('env_pond_sub')->where('pond_id', '=',$id)->where('water_parameter_id', '=',$request->enddate)->count();
        if ($count > 0) {
            # code...
        } else {

        }

        $env_pond_sub = DB::table('env_pond_sub')->where('pond_id', '=',$id )->get();

        return view('env.env_water_add_pond3', $data, [
            'startdate'        => $startdate,
            'enddate'          => $enddate,
            'datashow'         => $datashow,
            'env_pond_sub'     => $env_pond_sub,
            'idpond'           => $id,


        ]);
    }

    public function env_water_add_pond3_save (Request $request)
    {
        $startdate = $request->startdate;
        $enddate = $request->enddate;

        $iduser = $request->water_user1;

        $data['users'] = User::get();
        $data['leave_month'] = DB::table('leave_month')->get();
        $data['users_group'] = DB::table('users_group')->get();
        $data['p4p_workgroupset'] = P4p_workgroupset::where('p4p_workgroupset_user','=',$iduser)->get();

        $acc_debtors = DB::select('
            SELECT count(*) as I from users u
            left join p4p_workload l on l.p4p_workload_user=u.id
            group by u.dep_subsubtrueid;
        ');

        $idpond =  $request->pond_id;
        $namepond = Env_pond::where('pond_id','=', $idpond)->first();
        $idp =  $namepond->pond_id;

        $add = new Env_water();
        $add->water_date                = $request->input('water_date');
        $add->water_user                = $request->input('water_user');
        $add->pond_id                   = $namepond->pond_id;
        $add->water_location            = $namepond->pond_name;
        $add->water_group_excample      = $request->input('water_group_excample');
        $add->water_comment             = $request->input('water_comment');
        $add->save();


        $waterid =  Env_water::max('water_id');
        $water_parameter_id = $request->water_parameter_id;
        $namepara = Env_water_parameter::where('water_parameter_id','=', $water_parameter_id)->first();

        if($request->water_parameter_id != '' || $request->water_parameter_id != null){

            $water_parameter_id                             = $request->water_parameter_id;
            // dd($water_parameter_id);
            $water_parameter_unit                           = $request->water_parameter_unit;
            $water_qty                                      = $request->water_qty;
            $water_parameter_short_name                     = $namepara->water_parameter_short_name;
            // dd($water_parameter_short_name);

            $number =count($water_parameter_id);
            // $count = 0;
                for($count = 0; $count< $number; $count++)
                {
                    $idwater = Env_water_parameter::where('water_parameter_id','=',$water_parameter_id[$count])->first();

                    $add_sub = new Env_water_sub();
                    $add_sub->water_id                              = $waterid;
                    $add_sub->water_list_idd                        = $idwater->water_parameter_id;
                    $add_sub->water_list_detail                     = $idwater->water_parameter_name;
                    $add_sub->water_parameter_short_name            = $idwater->water_parameter_short_name;
                    $add_sub->water_list_unit                       = $water_parameter_unit[$count];
                    $add_sub->water_qty                             = $water_qty[$count];
                    $add_sub->water_results                         = $idwater->water_parameter_icon.''.$idwater->water_parameter_normal;
                    $add_sub->use_analysis_results                  = $idwater->water_parameter_icon_end.''.$idwater->water_parameter_normal_end;


                    $qty = $water_qty[$count];

                    if ($idwater->water_parameter_id == '1' && $qty <= '20' ) {
                        $status = 'ปกติ';
                    }elseif($idwater->water_parameter_id == '2' && $qty <= '120' ) {
                        $status = 'ปกติ';
                    }elseif($idwater->water_parameter_id == '3' && $qty <= '1000' ) {
                        $status = 'ปกติ';
                    }elseif($idwater->water_parameter_id == '4' && $qty <= '30' ) {
                        $status = 'ปกติ';
                    }elseif($idwater->water_parameter_id == '5' && $qty <= '0.5' ) {
                        $status = 'ปกติ';
                    }elseif($idwater->water_parameter_id == '6' && $qty <= '35' ) {
                        $status = 'ปกติ';
                    }elseif($idwater->water_parameter_id == '7' && $qty >= '4.9' && $idwater->water_parameter_id == '7' && $qty <= '9') {
                        $status = 'ปกติ';
                    }elseif($idwater->water_parameter_id == '8' && $qty <= '1.0' ) {
                        $status = 'ปกติ';
                    }elseif($idwater->water_parameter_id == '9' && $qty <= '20' ) {
                        $status = 'ปกติ';
                    }elseif($idwater->water_parameter_id == '10' && $qty <= '5000' ) {
                        $status = 'ปกติ';
                    }elseif($idwater->water_parameter_id == '11' && $qty <= '1000' ) {
                        $status = 'ปกติ';
                    }elseif($idwater->water_parameter_id == '12' && $qty <= '1' ) {
                        $status = 'ปกติ';
                    }elseif($idwater->water_parameter_id == '13' && $qty <= '1000' ) {
                        $status = 'ปกติ';
                    }elseif($idwater->water_parameter_id == '14' && $qty >= '2' ) {
                        $status = 'ปกติ';
                    }elseif($idwater->water_parameter_id == '15' && $qty >= '400' ) {
                        $status = 'ปกติ';
                    }elseif($idwater->water_parameter_id == '16' && $qty >= '0.5' && $idwater->water_parameter_id == '16' && $qty <= '1') {
                        $status = 'ปกติ';
                    } else {
                        $status = 'ผิดปกติ';
                    }


                    $add_sub->status                         = $status;

                    $add_sub->save();
                }
        }


        $data_loob = Env_water_sub::where('water_id','=',$waterid)->get();
        $data_users = User::where('id','=',$request->water_user)->first();
        $name = $data_users->fname.' '.$data_users->lname;

        $mMessage = array();
        foreach ($data_loob as $key => $value) {
               $mMessage[] = [
                    'water_parameter_short_name'    => $value->water_parameter_short_name,
                    'water_qty'                     => $value->water_qty,
                    'status'                        => $value->status,
                ];
            }
            $linetoken = "q2PXmPgx0iC5IZXjtkeZUFiNwtmEkSGjRp1PsxFUaYe"; //ใส่ token line ENV แล้ว
            $header = "ข้อมูลตรวจน้ำ";
            $message =  $header.
                    "\n"."วันที่บันทึก : "      . $request->input('water_date').
                   "\n"."ผู้บันทึก  : "        . $name .
                   "\n"."สถานที่เก็บตัวอย่าง : " . $namepond->pond_name;
            foreach ($mMessage as $key => $smes) {
                $na_mesage           = $smes['water_parameter_short_name'];
                $qt_mesage           = $smes['water_qty'];
                $status_mesage       = $smes['status'];
                $message.="\n"."รายการพารามิเตอร์  : " . $na_mesage .
                          "\n"."ผลการวิเคราะห์ : " . $qt_mesage . '  ' . $status_mesage;
                        //   "\n"."สถานะ : "       . $status_mesage;
            }
            if($linetoken == null){
                $send_line ='';
            }else{
                $send_line = $linetoken;
            }
            if($send_line !== '' && $send_line !== null){


                    $chOne = curl_init();
                    curl_setopt( $chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify");
                    curl_setopt( $chOne, CURLOPT_SSL_VERIFYHOST, 0);
                    curl_setopt( $chOne, CURLOPT_SSL_VERIFYPEER, 0);
                    curl_setopt( $chOne, CURLOPT_POST, 1);
                    // curl_setopt( $chOne, CURLOPT_POSTFIELDS, $message);
                    curl_setopt( $chOne, CURLOPT_POSTFIELDS, "message=$message");
                    curl_setopt( $chOne, CURLOPT_FOLLOWLOCATION, 1);
                    $headers = array( 'Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer '.$linetoken.'', );
                    curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers);
                    curl_setopt( $chOne, CURLOPT_RETURNTRANSFER, 1);
                    $result = curl_exec($chOne);
                    if (curl_error($chOne)) {echo 'error:' . curl_error($chOne);} else { $result_ = json_decode($result, true);
                        echo "status : " . $result_['status'];
                        echo "message : " . $result_['message'];}
                    curl_close($chOne);

            }


        return redirect()->route('env.env_water_add_pond',[
            'id'  => $idp
        ]);


    }

    public function env_water_add_pond4 (Request $request,$id) //น้ำประปา
    {
        $startdate     = $request->startdate;
        $enddate       = $request->enddate;
        $data_insert   = $request->data_insert;
        $data['users'] = User::get();
        $dabudget_year = DB::table('budget_year')->where('active', '=', true)->first();
        $leave_month_year = DB::table('leave_month')->orderBy('MONTH_ID', 'ASC')->get();
        $date = date('Y-m-d');
        $y = date('Y') + 543;
        $newweek = date('Y-m-d', strtotime($date . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
        $newDate = date('Y-m-d', strtotime($date . ' -5 months')); //ย้อนหลัง 5 เดือน
        $newyear = date('Y-m-d', strtotime($date . ' -1 year')); //ย้อนหลัง 1 ปี

        if ($data_insert == '') {
            # code...
        } else {

        }

        $datashow = DB::connection('mysql')->select('SELECT * FROM env_pond_sub WHERE pond_id = "4"');

        $count    = DB::table('env_pond_sub')->where('pond_id', '=',$id)->where('water_parameter_id', '=',$request->enddate)->count();
        if ($count > 0) {
            # code...
        } else {

        }
        $data_mm                    = date('H:m:s');
        $env_pond_sub = DB::table('env_pond_sub')->where('pond_id', '=',$id )->get();

        return view('env.env_water_add_pond4', $data, [
            'startdate'        => $startdate,
            'enddate'          => $enddate,
            'datashow'         => $datashow,
            'env_pond_sub'     => $env_pond_sub,
            'idpond'           => $id,
            'data_mm'           => $data_mm,

        ]);
    }

    public function env_water_add_pond4_save (Request $request)
    {
        $startdate = $request->startdate;
        $enddate = $request->enddate;

        $iduser = $request->water_user1;

        $data['users'] = User::get();
        $data['leave_month'] = DB::table('leave_month')->get();
        $data['users_group'] = DB::table('users_group')->get();
        $data['p4p_workgroupset'] = P4p_workgroupset::where('p4p_workgroupset_user','=',$iduser)->get();

        $acc_debtors = DB::select('
            SELECT count(*) as I from users u
            left join p4p_workload l on l.p4p_workload_user=u.id
            group by u.dep_subsubtrueid;
        ');

        $idpond =  $request->pond_id;
        $namepond = Env_pond::where('pond_id','=', $idpond)->first();
        $idp =  $namepond->pond_id;

        $data['m']                  = date('H');
        $data_mm                    = date('H:m:s');
        $data['datefull']           = date('Y-m-d H:m:s');
        $yy1                        = date('Y') + 543;
        $yy2                        = date('Y') + 542;
        $yy3                        = date('Y') + 541;
        // $date_in    = $request->input('water_date');
        $date_save  = $request->input('water_date');
        $date_user  = $request->input('water_user');
        $count_check = DB::table('env_water')->where('water_date','=',$date_save)->count();
        if ($count_check >0) {
             Env_water::where('water_date',$date_save)->where('water_user',$date_user)->where('pond_id',$namepond->pond_id)->update([
                'water_time'  => $data_mm
             ]);
        } else {
                $add = new Env_water();
                $add->water_date                = $date_save;
                $add->water_time                = $request->water_time;
                $add->water_user                = $date_user;
                $add->pond_id                   = $namepond->pond_id;
                $add->water_location            = $namepond->pond_name;
                $add->water_group_excample      = $request->input('water_group_excample');
                $add->water_comment             = $request->input('water_comment');
                $add->save();


                $waterid =  Env_water::max('water_id');
                $water_parameter_id = $request->water_parameter_id;
                $namepara = Env_water_parameter::where('water_parameter_id','=', $water_parameter_id)->first();

                if($request->water_parameter_id != '' || $request->water_parameter_id != null){

                    $water_parameter_id                             = $request->water_parameter_id;
                    // dd($water_parameter_id);
                    $water_parameter_unit                           = $request->water_parameter_unit;
                    $water_qty                                      = $request->water_qty;
                    $water_parameter_short_name                     = $namepara->water_parameter_short_name;
                    // dd($water_parameter_short_name);

                    $number =count($water_parameter_id);
                    // $count = 0;
                        for($count = 0; $count< $number; $count++)
                        {
                            $idwater = Env_water_parameter::where('water_parameter_id','=',$water_parameter_id[$count])->first();

                            $add_sub = new Env_water_sub();
                            $add_sub->water_id                              = $waterid;
                            $add_sub->water_list_idd                        = $idwater->water_parameter_id;
                            $add_sub->water_list_detail                     = $idwater->water_parameter_name;
                            $add_sub->water_parameter_short_name            = $idwater->water_parameter_short_name;
                            $add_sub->water_list_unit                       = $water_parameter_unit[$count];
                            $add_sub->water_qty                             = $water_qty[$count];
                            $add_sub->water_results                         = $idwater->water_parameter_icon.''.$idwater->water_parameter_normal;
                            $add_sub->use_analysis_results                  = $idwater->water_parameter_icon_end.''.$idwater->water_parameter_normal_end;


                            $qty = $water_qty[$count];

                            if ($idwater->water_parameter_id == '1' && $qty <= '20' ) {
                                $status = 'ปกติ';
                            }elseif($idwater->water_parameter_id == '2' && $qty <= '120' ) {
                                $status = 'ปกติ';
                            }elseif($idwater->water_parameter_id == '3' && $qty <= '1000' ) {
                                $status = 'ปกติ';
                            }elseif($idwater->water_parameter_id == '4' && $qty <= '30' ) {
                                $status = 'ปกติ';
                            }elseif($idwater->water_parameter_id == '5' && $qty <= '0.5' ) {
                                $status = 'ปกติ';
                            }elseif($idwater->water_parameter_id == '6' && $qty <= '35' ) {
                                $status = 'ปกติ';
                            }elseif($idwater->water_parameter_id == '7' && $qty >= '4.9' && $idwater->water_parameter_id == '7' && $qty <= '9') {
                                $status = 'ปกติ';
                            }elseif($idwater->water_parameter_id == '8' && $qty <= '1.0' ) {
                                $status = 'ปกติ';
                            }elseif($idwater->water_parameter_id == '9' && $qty <= '20' ) {
                                $status = 'ปกติ';
                            }elseif($idwater->water_parameter_id == '10' && $qty <= '5000' ) {
                                $status = 'ปกติ';
                            }elseif($idwater->water_parameter_id == '11' && $qty <= '1000' ) {
                                $status = 'ปกติ';
                            }elseif($idwater->water_parameter_id == '12' && $qty <= '1' ) {
                                $status = 'ปกติ';
                            }elseif($idwater->water_parameter_id == '13' && $qty <= '1000' ) {
                                $status = 'ปกติ';
                            }elseif($idwater->water_parameter_id == '14' && $qty >= '2' ) {
                                $status = 'ปกติ';
                            }elseif($idwater->water_parameter_id == '15' && $qty >= '400' ) {
                                $status = 'ปกติ';
                            }elseif($idwater->water_parameter_id == '16' && $qty >= '0.5' && $idwater->water_parameter_id == '16' && $qty <= '1') {
                                $status = 'ปกติ';
                            } else {
                                $status = 'ผิดปกติ';
                            }


                            $add_sub->status                         = $status;

                            $add_sub->save();
                        }
                }


                $data_loob = Env_water_sub::where('water_id','=',$waterid)->get();
                $data_users = User::where('id','=',$request->water_user)->first();
                $name = $data_users->fname.' '.$data_users->lname;

                $mMessage = array();
                foreach ($data_loob as $key => $value) {
                    $mMessage[] = [
                            'water_parameter_short_name'    => $value->water_parameter_short_name,
                            'water_qty'                     => $value->water_qty,
                            'status'                        => $value->status,
                        ];
                    }
                    $linetoken = "q2PXmPgx0iC5IZXjtkeZUFiNwtmEkSGjRp1PsxFUaYe"; //ใส่ token line ENV แล้ว
                    $header = "ข้อมูลตรวจน้ำ";
                    $message =  $header.
                            "\n"."วันที่บันทึก : "      . $request->input('water_date').
                        "\n"."ผู้บันทึก  : "        . $name .
                        "\n"."สถานที่เก็บตัวอย่าง : " . $namepond->pond_name;
                    foreach ($mMessage as $key => $smes) {
                        $na_mesage           = $smes['water_parameter_short_name'];
                        $qt_mesage           = $smes['water_qty'];
                        $status_mesage       = $smes['status'];
                        $message.="\n"."รายการพารามิเตอร์  : " . $na_mesage .
                                "\n"."ผลการวิเคราะห์ : " . $qt_mesage . '  ' . $status_mesage;
                                //   "\n"."สถานะ : "       . $status_mesage;
                    }
                    if($linetoken == null){
                        $send_line ='';
                    }else{
                        $send_line = $linetoken;
                    }
                    if($send_line !== '' && $send_line !== null){


                            $chOne = curl_init();
                            curl_setopt( $chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify");
                            curl_setopt( $chOne, CURLOPT_SSL_VERIFYHOST, 0);
                            curl_setopt( $chOne, CURLOPT_SSL_VERIFYPEER, 0);
                            curl_setopt( $chOne, CURLOPT_POST, 1);
                            // curl_setopt( $chOne, CURLOPT_POSTFIELDS, $message);
                            curl_setopt( $chOne, CURLOPT_POSTFIELDS, "message=$message");
                            curl_setopt( $chOne, CURLOPT_FOLLOWLOCATION, 1);
                            $headers = array( 'Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer '.$linetoken.'', );
                            curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers);
                            curl_setopt( $chOne, CURLOPT_RETURNTRANSFER, 1);
                            $result = curl_exec($chOne);
                            if (curl_error($chOne)) {echo 'error:' . curl_error($chOne);} else { $result_ = json_decode($result, true);
                                echo "status : " . $result_['status'];
                                echo "message : " . $result_['message'];}
                            curl_close($chOne);

                }

        }
        return redirect()->route('env.env_water_add_pond',[
            'id'      => $idp
        ]);


    }
//**************************************************************ตั้งค่า parameter น้ำ*********************************************

    public function env_water_parameter (Request $request)
    {
        $datestart = $request->startdate;
        $dateend = $request->enddate;
        $iduser = Auth::user()->id;
        $data['users'] = User::get();
        $data['leave_month'] = DB::table('leave_month')->get();
        $data['users_group'] = DB::table('users_group')->get();
        $data['p4p_workgroupset'] = P4p_workgroupset::where('p4p_workgroupset_user','=',$iduser)->get();

        $data_water_parameter = DB::table('env_water_parameter')->get();

        return view('env.env_water_parameter', $data,[
            'startdate'         => $datestart,
            'enddate'           => $dateend,
            'data_water_parameter' => $data_water_parameter,
        ]);
    }

    public function env_water_parameter_add (Request $request)
    {
        $datestart = $request->startdate;
        $dateend = $request->enddate;
        $iduser = Auth::user()->id;
        $data['users'] = User::get();
        $data['leave_month'] = DB::table('leave_month')->get();
        $data['users_group'] = DB::table('users_group')->get();
        $data['p4p_workgroupset'] = P4p_workgroupset::where('p4p_workgroupset_user','=',$iduser)->get();
        $data['data_water_icon'] = DB::table('env_water_icon')->get();

        $acc_debtors = DB::select('
            SELECT count(*) as I from users u
            left join p4p_workload l on l.p4p_workload_user=u.id
            group by u.dep_subsubtrueid;
        ');

        $data_water_parameter = DB::table('env_water_parameter')->get();



        return view('env.env_water_parameter_add', $data,[
            'startdate'              => $datestart,
            'enddate'                => $dateend,
            'data_water_parameter'   => $data_water_parameter,
        ]);
    }

    public function env_water_parameter_edit (Request $request,$id)
    {
        $datestart = $request->startdate;
        $dateend = $request->enddate;
        $iduser = Auth::user()->id;
        $data['users'] = User::get();
        $data['leave_month'] = DB::table('leave_month')->get();
        $data['users_group'] = DB::table('users_group')->get();
        $data['p4p_workgroupset'] = P4p_workgroupset::where('p4p_workgroupset_user','=',$iduser)->get();
        $data['env_water_icon'] = DB::table('env_water_icon')->get();


        $water_parameter = DB::table('env_water_parameter')->where('water_parameter_id','=',$id)->first();

        return view('env.env_water_parameter_edit', $data,[
            'startdate'        => $datestart,
            'enddate'          => $dateend,
            'water_parameter'  => $water_parameter,
            //'data_edit'        => $data_edit,
        ]);
    }

    public function env_water_parameter_save (Request $request)
    {
        // env_water_icon_name
        $datenow = date('Y-m-d H:m:s');
        Env_water_parameter::insert([
            'water_parameter_name'                   => $request->water_parameter_name,
            'water_parameter_short_name'             => $request->water_parameter_short_name,
            'water_parameter_unit'                   => $request->water_parameter_unit,
            'water_parameter_icon'                   => $request->water_parameter_icon,
            'water_parameter_normal'                 => $request->water_parameter_normal,
            'water_parameter_results'                => $request->water_parameter_results,
            'created_at'                             => $datenow
        ]);
        $data_water_parameter = DB::table('env_water_parameter')->get();

        return redirect()->route('env.env_water_parameter');

    }

    public function env_water_parameter_update  (Request $request)
    {
        $datenow = date('Y-m-d H:m:s');
        $id = $request->water_parameter_id;

        Env_water_parameter::where('water_parameter_id','=',$id)
        ->update([
            'water_parameter_name'                   => $request->water_parameter_name,
            'water_parameter_short_name'             => $request->water_parameter_short_name,
            'water_parameter_unit'                   => $request->water_parameter_unit,
            'water_parameter_normal'                 => $request->water_parameter_normal,
            'water_parameter_normal_end'             => $request->water_parameter_normal,
            'water_parameter_results'                => $request->water_parameter_results,
            'updated_at'                             => $datenow
        ]);

        $data_water_parameter = DB::table('env_water_parameter')->get();
        // return redirect()->back();
        return redirect()->route('env.env_water_parameter');

    }

    function env_water_parameter_switchactive(Request $request)
    {
        $id = $request->idfunc;
        $active = Env_water_parameter::find($id);
        $active->water_parameter_active = $request->onoff;
        $active->save();
    }

    public function env_water_parameter_delete (Request $request,$id)
    {
       $del = Env_water_parameter::find($id);
       $del->delete();

        return redirect()->back();
    }

//**************************************************************ระบบตั้งค่า บ่อบำบัด*********************************************
    public function env_water_parameter_set (Request $request)
    {
        $datestart = $request->startdate;
        $dateend = $request->enddate;
        $iduser = Auth::user()->id;
        $data['users'] = User::get();
        $data['leave_month'] = DB::table('leave_month')->get();
        $data['users_group'] = DB::table('users_group')->get();
        $data['p4p_workgroupset'] = P4p_workgroupset::where('p4p_workgroupset_user','=',$iduser)->get();

        // $data_water_parameter_set = DB::table('env_water_parameter')->get();

        $datashow = DB::connection('mysql')->select('
            SELECT *
            from env_pond
            group by pond_id
            ');


        $data_parameter = DB::connection('mysql')->select('SELECT * from env_water_parameter');

        return view('env.env_water_parameter_set', $data,[
            'startdate'                 => $datestart,
            'enddate'                   => $dateend,
            'datashow'                  => $datashow,
            'data_parameter'            => $data_parameter,
        ]);
    }
    public function env_water_parameter_setsave(Request $request)
    {
        Env_pond::insert([
            'pond_name' => $request->pond_name
        ]);

        return response()->json([
            'status'               => '200'
        ]);
    }

    public function env_water_parameter_para_id(Request $request,$id)
    {
        $data_main = DB::table('env_pond')->where('pond_id','=',$id)->first();
        // $id_main = $data_main->
        // $data_para = DB::table('env_pond_sub')->where('pond_sub_id','=',$id)->first();

        return response()->json([
            'status'               => '200',
            // 'data_para'            =>  $data_para,
            'data_main'            =>  $data_main,
        ]);
    }

    public function env_water_parameter_set_save(Request $request)
    {
        DB::table('env_pond_sub')->insert([
            'pond_id'                     => $request->input('pond_id'),
            'pond_name'                   => $request->input('pond_name'),
            'water_parameter_id'          => $request->input('water_parameter_id'),
            'water_parameter_short_name'  => $request->input('water_parameter_short_name')
        ]);

        return response()->json([
            'status'     => '200',
        ]);
    }

    public function env_parameter_save(Request $request)
    {
        $id                       = $request->editpond_sub_id;
        $water_parameter_id       = $request->editwater_parameter_id;
        $pondid                   = $request->input('editpond_id');
        $pond_name                = $request->input('editpond_name');
        $ids_                      = Env_water_parameter::where('water_parameter_id',$water_parameter_id)->first();
        $ids_id                    = $ids_->water_parameter_id;
        $water_parameter_name      = $ids_->water_parameter_name;
        $ids_shotname              = $ids_->water_parameter_short_name;
        $water_parameter_unit      = $ids_->water_parameter_unit;

        $check_count = DB::table('env_pond_sub')->where('pond_id',$pondid)->where('water_parameter_id',$water_parameter_id)->count();

        if ( $check_count > 0) {
            DB::table('env_pond_sub')->where('pond_id',$pondid)->where('water_parameter_id',$water_parameter_id)->update([
                'pond_name'                   => $pond_name,
                'water_parameter_name'        => $water_parameter_name,
                'water_parameter_short_name'  => $ids_shotname,
                'water_parameter_unit'        => $water_parameter_unit,
            ]);
            return response()->json([
                'status'     => '200',
            ]);
        } else {
            DB::table('env_pond_sub')->insert([
                'pond_id'                     => $pondid,
                'pond_name'                   => $pond_name,
                'water_parameter_id'          => $water_parameter_id,
                'water_parameter_name'        => $water_parameter_name,
                'water_parameter_short_name'  => $ids_shotname,
                'water_parameter_unit'        => $water_parameter_unit,
            ]);
            return response()->json([
                'status'     => '200',
            ]);
        }

    }
    public function env_parameter_destroy(Request $request,$id)
    {
        $del = DB::table('env_pond_sub')->where('pond_sub_id',$id);
        $del->delete();

        return response()->json(['status' => '200']);
    }

//**************************************************************ระบบขยะติดเชื้อ*********************************************

    public function env_trash (Request $request)
    {
        // $datestart = $request->startdate;
        // $dateend = $request->enddate;
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        $iduser = Auth::user()->id;
        $data['users'] = User::get();
        $data['leave_month'] = DB::table('leave_month')->get();
        $data['users_group'] = DB::table('users_group')->get();
        $data['p4p_workgroupset'] = P4p_workgroupset::where('p4p_workgroupset_user','=',$iduser)->get();



        $trash = DB::table('env_trash')
            ->leftjoin('users','env_trash.trash_user','=','users.id')
            ->leftjoin('env_trash_type','env_trash.trash_user','=','env_trash_type.trash_type_id')
            ->leftjoin('products_vendor','env_trash.trash_sub','=','products_vendor.vendor_id')->get();

        $datashow = DB::connection('mysql')->select('
            SELECT DISTINCT(t.trash_bill_on) ,t.trash_id , t.trash_date , t.trash_time ,t.trash_sub , pv.vendor_name ,
            CONCAT(u.fname," ",u.lname) as trash_user
            FROM env_trash t
            LEFT JOIN env_trash_sub ts on ts.trash_id = t.trash_id
		    LEFT JOIN products_vendor pv on pv.vendor_id = t.trash_sub
			LEFT JOIN users u on u.id = t.trash_user
            order by t.trash_id desc;
            ');

        $trash_type = DB::table('env_trash_type') ->get();

        // $acc_debtors = DB::select('SELECT count(*) as I from users u
        //     left join p4p_workload l on l.p4p_workload_user=u.id
        //     group by u.dep_subsubtrueid;
        // ');

        return view('env.env_trash',[
            'startdate'     => $startdate,
            'enddate'       => $enddate,
            'trashs'        => $trash,
            'trash_type'    => $trash_type,
            'datashow'      => $datashow,

        ]);
    }

    public function env_trash_add (Request $request)
    {
        $datestart = $request->startdate;
        $dateend = $request->enddate;
        $iduser = Auth::user()->id;
        $data['users'] = User::get();
        $data['leave_month'] = DB::table('leave_month')->get();
        $data['users_group'] = DB::table('users_group')->get();
        $data['p4p_workgroupset'] = P4p_workgroupset::where('p4p_workgroupset_user','=',$iduser)->get();


        $acc_debtors = DB::select('
            SELECT count(*) as I from users u
            left join p4p_workload l on l.p4p_workload_user=u.id
            group by u.dep_subsubtrueid;
        ');

        $data_parameter = DB::table('env_trash')->get();
        $trash_parameter = DB::table('env_trash_parameter')->where('trash_parameter_active','=',true)->get();
        $data_trash_sub = DB::table('env_trash_sub')->get();
        $data_trash_type = DB::table('env_trash_type')->get();
        $data['products_vendor'] = Products_vendor::get();

        $maxnum = Env_trash::max('trash_bill_on'); //****รันเลขที่อัตโนมัติ */
        if($maxnum != '' ||  $maxnum != null){
         $refmax = Env_trash::where('trash_bill_on','=',$maxnum)->first();

         if($refmax->trash_bill_on != '' ||  $refmax->trash_bill_on != null){
         $maxpo = substr($refmax->trash_bill_on, 4)+1;
         }else{
         $maxref = 1;
         }
         $refe = str_pad($maxpo, 5, "0", STR_PAD_LEFT);
         }else{
        $refe = '00001';
         }
         $billNo = 'TRA'.'-'.$refe;


        return view('env.env_trash_add', $data,[
            'startdate'        => $datestart,
            'enddate'          => $dateend,
            'dataparameters'   => $data_parameter,
            'trash_parameter'  => $trash_parameter,
            'data_trash_sub'   => $data_trash_sub,
            'data_trash_type'  => $data_trash_type,
            'billNos'          => $billNo,
        ]);

    }

    public function env_trash_save (Request $request)
    {

        date_default_timezone_set("Asia/Bangkok");
        $datenow = date('Y-m-d H:i:s');
        $iduser = Auth::user()->id;
        $trash_parameter = DB::table('env_trash_parameter')->get();

        $count = Env_trash::where('trash_bill_on',$request->trash_bill_on)->count();
        if ($count > 0) {
            # code...
        } else {


                $add = new Env_trash();
                $add->trash_bill_on = $request->input('trash_bill_on');
                $add->trash_date    = $request->input('trash_date');
                $add->trash_time    = $request->input('trash_time');
                $add->trash_user    = $request->input('trash_user');
                $add->trash_sub     = $request->input('trash_sub');
                $add->save();

                $trash_id =  Env_trash::max('trash_id');

                if($request->trash_parameter_id != '' || $request->trash_parameter_id != null){

                $trashparameter_id         = $request->trash_parameter_id;
                $trash_sub_qty              = $request->trash_sub_qty;
                $trash_sub_unit             = $request->trash_sub_unit;


                $number =count($trashparameter_id);
                $count = 0;
                    for($count = 0; $count< $number; $count++)
                    {
                        $idtrash = Env_trash_parameter::where('trash_parameter_id','=',$trashparameter_id[$count])->first();

                        $add_sub = new Env_trash_sub();
                        $add_sub->trash_id                = $trash_id;
                        $add_sub->trash_sub_idd           = $idtrash->trash_parameter_id;
                        $add_sub->trash_sub_name          = $idtrash->trash_parameter_name;
                        $add_sub->trash_sub_unit          = $idtrash->trash_parameter_unit;

                        $add_sub->trash_sub_qty           = $trash_sub_qty[$count];


                        $add_sub->save();
                    }
                }

                $data_loob = Env_trash_sub::where('trash_id','=',$trash_id)->get();

                $data_users = User::where('id','=',$request->trash_user)->first();
                $name = $data_users->fname.' '.$data_users->lname;

                $mMessage = array();
                foreach ($data_loob as $key => $value) {

                    $mMessage[] = [
                            'trash_sub_name'    => $value->trash_sub_name,
                            'trash_sub_qty'     => $value->trash_sub_qty,
                            'unit'              => $value->trash_sub_unit,
                        ];
                    }

                    $linetoken = "q2PXmPgx0iC5IZXjtkeZUFiNwtmEkSGjRp1PsxFUaYe"; //ใส่ token line ENV แล้ว
                    //$linetoken = "DVWB9QFYmafdjEl9rvwB0qdPgCdsD59NHoWV7WhqbN4"; //ใส่ token line ENV แล้ว

                    // $smessage = [];
                    $header = "ข้อมูลขยะ";
                    $message =  $header.
                            "\n"."วันที่บันทึก : "      . $request->input('trash_date').
                        "\n"."ผู้บันทึก  : "        . $name .
                        "\n"."เวลา : "           . $request->input('trash_time');

                    foreach ($mMessage as $key => $smes) {
                        $na_mesage           = $smes['trash_sub_name'];
                        $qt_mesage           = $smes['trash_sub_qty'];
                        $unit_mesage         = $smes['unit'];

                        $message.="\n"."ประเภทขยะ : " . $na_mesage .
                                "\n"."ปริมาณ : " . $qt_mesage . " ". $unit_mesage;
                                // "\n"."หน่วย : "   . $unit_mesage;

                    }


                        if($linetoken == null){
                            $send_line ='';
                        }else{
                            $send_line = $linetoken;
                        }
                        if($send_line !== '' && $send_line !== null){

                            // function notify_message($smessage,$linetoken)
                            // {
                                $chOne = curl_init();
                                curl_setopt( $chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify");
                                curl_setopt( $chOne, CURLOPT_SSL_VERIFYHOST, 0);
                                curl_setopt( $chOne, CURLOPT_SSL_VERIFYPEER, 0);
                                curl_setopt( $chOne, CURLOPT_POST, 1);
                                // curl_setopt( $chOne, CURLOPT_POSTFIELDS, $message);
                                curl_setopt( $chOne, CURLOPT_POSTFIELDS, "message=$message");
                                curl_setopt( $chOne, CURLOPT_FOLLOWLOCATION, 1);
                                $headers = array( 'Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer '.$linetoken.'', );
                                curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers);
                                curl_setopt( $chOne, CURLOPT_RETURNTRANSFER, 1);
                                $result = curl_exec($chOne);
                                if (curl_error($chOne)) {echo 'error:' . curl_error($chOne);} else { $result_ = json_decode($result, true);
                                    echo "status : " . $result_['status'];
                                    echo "message : " . $result_['message'];}
                                curl_close($chOne);
                            // }
                            // foreach ($mMessage as $linetoken) {
                            //     notify_message($linetoken,$smessage);
                            // }

                        }
        }

        return redirect()->route('env.env_trash');
        // return redirect()->route('env.env_trash');
    }

    public function env_trash_edit (Request $request,$id)
    {
        $datestart = $request->startdate;
        $dateend = $request->enddate;
        $iduser = Auth::user()->id;
        $data['users'] = User::get();
        $data['leave_month'] = DB::table('leave_month')->get();
        $data['users_group'] = DB::table('users_group')->get();
        $data['p4p_workgroupset'] = P4p_workgroupset::where('p4p_workgroupset_user','=',$iduser)->get();

        $trash = DB::table('env_trash')->where('trash_id','=',$id)->first();
        $data['env_trash_sub']  = DB::table('env_trash_sub')->where('trash_id','=',$id)->get();

        $data['trash_parameter']  = DB::table('env_trash_parameter')->get();
        // $data_trash_sub = DB::table('env_trash_sub')->get();
        // $data_trash_type = DB::table('env_trash_type')->get();
        $data['products_vendor'] = Products_vendor::get();

        return view('env.env_trash_edit', $data,[
            'startdate'        => $datestart,
            'enddate'          => $dateend,
            'trash'            => $trash,
        ]);
    }

    public function env_trash_update  (Request $request)
    {
        $datenow = date('Y-m-d H:m:s');
        $id = $request->trash_id;
        // $ff = $request->trash_bill_on;
        // dd($ff);
        $update = Env_trash::find($id);

        $update->trash_bill_on = $request->trash_bill_on;
        $update->trash_date    = $request->trash_date;
        $update->trash_time    = $request->trash_time;
        $update->trash_user    = $request->trash_user;
        $update->trash_sub     = $request->trash_sub;
        $update->save();

        // Env_trash_sub::where('trash_id','=',$id)->delete();

        if($request->trash_sub_idd != '' || $request->trash_sub_idd != null){

            $trash_sub_idd              = $request->trash_sub_idd;
            $trash_sub_qty              = $request->trash_sub_qty;
            $trash_sub_unit             = $request->trash_sub_unit;
            $trash_parameter_unit       = $request->trash_parameter_unit;

            $number =count($trash_sub_idd);
            $count = 0;
                for($count = 0; $count< $number; $count++)
                    {
                        $idtrash = Env_trash_parameter::where('SET_TRASH_ID','=',$trash_sub_idd[$count])->first();

                        $add_sub = new Env_trash_sub();
                        $add_sub->trash_id          = $id;

                        $add_sub->trash_sub_idd     = $idtrash->trash_parameter_id;
                        $add_sub->trash_sub_name    = $idtrash->trash_parameter_name;

                        $add_sub->trash_sub_qty     = $trash_sub_qty[$count];
                        $add_sub->trash_sub_unit    = $trash_parameter_unit[$count];
                        $add_sub->save();
                    }
        }

        return redirect()->route('env.env_trash');

    }

    public function env_trash_delete (Request $request,$id)
    {
       Env_trash::destroy($id);
       Env_trash_sub::where('trash_id','=',$id)->delete();

        return redirect()->back();
    }

//**************************************************************ตั้งค่า ประเภทขยะ*********************************************

    public function env_trash_parameter (Request $request)
    {
        $datestart = $request->startdate;
        $dateend = $request->enddate;
        $iduser = Auth::user()->id;
        $data['users'] = User::get();
        $data['leave_month'] = DB::table('leave_month')->get();
        $data['users_group'] = DB::table('users_group')->get();
        $data['p4p_workgroupset'] = P4p_workgroupset::where('p4p_workgroupset_user','=',$iduser)->get();

        $data_parameter_list = DB::table('env_trash_parameter')->get();


        return view('env.env_trash_parameter', $data,[
            'startdate' => $datestart,
            'enddate' => $dateend,
            'dataparameterlist' => $data_parameter_list,
        ]);
    }

    public function env_trash_parameter_add (Request $request)
    {
        $datestart = $request->startdate;
        $dateend = $request->enddate;
        $iduser = Auth::user()->id;
        $data['users'] = User::get();
        $data['leave_month'] = DB::table('leave_month')->get();
        $data['users_group'] = DB::table('users_group')->get();
        $data['p4p_workgroupset'] = P4p_workgroupset::where('p4p_workgroupset_user','=',$iduser)->get();

        $acc_debtors = DB::select('
            SELECT count(*) as I from users u
            left join p4p_workload l on l.p4p_workload_user=u.id
            group by u.dep_subsubtrueid;
        ');

        $data_parameter = DB::table('env_trash_parameter')->get();


        return view('env.env_trash_parameter_add', $data,[
            'startdate'        => $datestart,
            'enddate'          => $dateend,
            'dataparameters'   => $data_parameter,
        ]);
    }

    public function env_trash_parameter_edit (Request $request,$id)
    {
        $datestart = $request->startdate;
        $dateend = $request->enddate;
        $iduser = Auth::user()->id;
        $data['users'] = User::get();
        $data['leave_month'] = DB::table('leave_month')->get();
        $data['users_group'] = DB::table('users_group')->get();
        $data['p4p_workgroupset'] = P4p_workgroupset::where('p4p_workgroupset_user','=',$iduser)->get();

        $data_edit = DB::table('env_trash_parameter')->where('trash_parameter_id','=',$id)->first();

        return view('env.env_trash_parameter_edit', $data,[
            'startdate'        => $datestart,
            'enddate'          => $dateend,
            'data_edit'        => $data_edit,
        ]);
    }

    public function env_trash_parameter_save (Request $request)
    {
        $datenow = date('Y-m-d H:m:s');

        Env_trash_parameter::insert([
            // 'trash_parameter_id'                    => $request->trash_parameter_id,
            'trash_parameter_name'                   => $request->trash_parameter_name,
            'trash_parameter_unit'                   => $request->trash_parameter_unit,
            'created_at'                             => $datenow
        ]);
        $data_parameter_list = DB::table('env_trash_parameter')->get();

        return redirect()->route('env.env_trash_parameter');

    }

    public function env_trash_parameter_update  (Request $request)
    {
        $datenow = date('Y-m-d H:m:s');
        $id = $request->trash_parameter_id;
        // DB::table('env_parameter_list')->where('parameter_list_id','=',$id)
        Env_trash_parameter::where('trash_parameter_id','=',$id)
        ->update([
            'trash_parameter_name'                       => $request->trash_parameter_name,
            'trash_parameter_unit'                       => $request->trash_parameter_unit,
            'updated_at'                                 => $datenow
        ]);

        $data_parameter_list = DB::table('env_trash_type')->get();
        // return redirect()->back();
        return redirect()->route('env.env_trash_parameter');
        // return view('env.env_water_parameter',[
        //     'dataparameterlist' => $data_parameter_list,
        // ]);
    }

    function env_trash_parameter_switchactive(Request $request)
    {
        $id = $request->idfunc;
        $active = Env_trash_parameter::find($id);
        $active->trash_parameter_active = $request->onoff;
        $active->save();
    }

    public function env_trash_parameter_delete (Request $request,$id)
    {
       $del = Env_trash_parameter::find($id);
       $del->delete();

        return redirect()->back();
    }


// ************************* Report  *************************
    public function env_water_rep (Request $request)
    {
        $startdate        = $request->startdate;
        $enddate          = $request->enddate;
        $pond_id          = $request->pond_id;

        $iduser = Auth::user()->id;
        $date = date('Y-m-d');
        $newDate = date('Y-m-d', strtotime($date . ' -3 months')); //ย้อนหลัง 5 เดือน
        if ($startdate == '') {

                $datashow = DB::connection('mysql')->select('
                    SELECT
                        DAY(e.water_date) as days
                        ,e.water_date
                        ,es.water_parameter_short_name
                        ,es.water_qty
                        FROM env_water e
                        LEFT OUTER JOIN env_water_sub es ON es.water_id = e.water_id
                        LEFT OUTER JOIN env_water_parameter ep ON ep.water_parameter_id = es. water_list_idd
                        WHERE e.water_date BETWEEN "'.$date.'"  AND "'.$date.'"
                        GROUP BY days
            ');

            $data['qtyph'] =  '';
            $data['qtysv'] =  '';

        } else {
            if ($pond_id != '') {
                $datashow = DB::connection('mysql')->select('
                    SELECT
                        DAY(e.water_date) as days
                        ,e.water_date
                        ,es.water_parameter_short_name
                        ,es.water_qty
                        FROM env_water e
                        LEFT OUTER JOIN env_water_sub es ON es.water_id = e.water_id
                        LEFT OUTER JOIN env_water_parameter ep ON ep.water_parameter_id = es. water_list_idd
                        WHERE e.water_date BETWEEN "'.$startdate.'"  AND "'.$enddate.'" AND e.pond_id = "'.$pond_id.'"
                        GROUP BY days , e.pond_id = "'.$pond_id.'"

                ');
                // GROUP BY days
            } else {
                $datashow = DB::connection('mysql')->select('
                    SELECT
                        DAY(e.water_date) as days
                        ,e.water_date
                        ,es.water_parameter_short_name
                        ,es.water_qty
                        FROM env_water e
                        LEFT OUTER JOIN env_water_sub es ON es.water_id = e.water_id
                        LEFT OUTER JOIN env_water_parameter ep ON ep.water_parameter_id = es. water_list_idd
                        WHERE e.water_date BETWEEN "'.$startdate.'"  AND "'.$enddate.'"

                ');
            }
            // GROUP BY days

        }

        $data['env_pond']  = DB::table('env_pond')->get();


        return view('env.env_water_rep',$data,[
            'startdate'     => $startdate,
            'enddate'       => $enddate,
            'datashow'      => $datashow,
            'pond_id'       => $pond_id,

        ]);
    }

//**************************************************************ตั้งค่า   แจ้งเตือน Line*********************************************

    // public function send_Line(Request $request)
    // {
    //     date_default_timezone_set("Asia/Bangkok");
    //     $date = date('Y-m-d');
    //     // $newday = date('Y-m-d', strtotime($date . ' -30 day')); //ย้อนหลัง 30 วัน
    //     $newweek = date('Y-m-d', strtotime($date . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
    //     $newdate = date('Y-m-d', strtotime($date . ' -1 months')); //ย้อนหลัง 1 เดือน
    //     $treedate = date('Y-m-d', strtotime($date . ' -2 months')); //ย้อนหลัง 3 เดือน
    //     // dd($newdate);
    //     // Db_authen_detail
    //     $water = DB::table('env_water')->where('water_id','=',$id)->first();
    //     $data['env_water_sub']  = DB::table('env_water_sub')->where('water_id','=',$id)->get();
    //     $data['water_parameter']  = DB::table('env_water_parameter')->get();

    //     $detail_auto = DB::connection('mysql')->select('
    //         SELECT w.water_date, CONCAT(u.fname," ",u.lname) as ptname, w.water_group_excample, ws.water_list_idd
    //         , ws.water_list_detail, ws.water_qty, ws.water_list_unit
    //         from env_water w
    //         left outer join env_water_sub ws on ws.water_id = w.water_id
    //         left outer join users u on u.id = w.water_user
    //         wHERE w.water_date BETWEEN "'.$newdate.'" AND "'.$date.'"

    //     ');


    //     foreach ($detail_auto as $key => $value) {
    //             if ($value->claim_code <> '1') {

    //                 $linetoken = "q2PXmPgx0iC5IZXjtkeZUFiNwtmEkSGjRp1PsxFUaYe"; //ใส่ token line ENV แล้ว

    //                 $datesend = date('Y-m-d');
    //                 $header = "ข้อมูลตรวจน้ำ";
    //                 $message = $header.
    //                     "\n"."วันที่แจ้ง : "        . $datesend.
    //                     "\n"."เวลาแจ้ง : "        . date('H:i:s').
    //                     "\n"."สถานที่ตรวจ : "     . $value->water_group_excample.
    //                     "\n"."พารามิเตอร์ : "      . $value->water_list_detail.
    //                     "\n"."ค่าที่ตรวจได้ : "     . $value->water_qty.
    //                     "\n"."ผู้ตรวจน้ำ : "       . $value->vstdate;


    //                     if($linetoken == null){
    //                         $send_line ='';
    //                     }else{
    //                         $send_line = $linetoken;
    //                     }

    //                 if($send_line !== '' && $send_line !== null){
    //                         $chOne = curl_init();
    //                         curl_setopt( $chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify");
    //                         curl_setopt( $chOne, CURLOPT_SSL_VERIFYHOST, 0);
    //                         curl_setopt( $chOne, CURLOPT_SSL_VERIFYPEER, 0);
    //                         curl_setopt( $chOne, CURLOPT_POST, 1);
    //                         curl_setopt( $chOne, CURLOPT_POSTFIELDS, $message);
    //                         curl_setopt( $chOne, CURLOPT_POSTFIELDS, "message=$message");
    //                         curl_setopt( $chOne, CURLOPT_FOLLOWLOCATION, 1);
    //                         $headers = array( 'Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer '.$send_line.'', );
    //                         curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers);
    //                         curl_setopt( $chOne, CURLOPT_RETURNTRANSFER, 1);
    //                         $result = curl_exec( $chOne );
    //                         //  if(curl_error($chOne)) { echo 'error:' . curl_error($chOne); }
    //                         //     else {
    //                         //         $result_ = json_decode($result, true);
    //                         //         echo "status : ".$result_['status']; echo "message : ". $result_['message'];
    //                         //         //  return response()->json([
    //                         //         //      'status'     => 200 ,
    //                         //         //      ]);

    //                         // }
    //                         curl_close( $chOne );

    //                 }
    //                 } else {
    //                     # code...
    //                 }

    //     }
    //     return view('auto.sss_check_claimcode');
    // }
}
