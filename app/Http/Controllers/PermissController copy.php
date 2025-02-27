<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\support\Facades\Hash;
use Illuminate\support\Facades\Validator;
use App\Models\User;
use App\Models\Department;
use App\Models\Departmentsub;
use App\Models\Departmentsubsub;
use App\Models\Products_vendor;
use App\Models\Status;
use App\Models\Position;
use App\Models\Products_request;
use App\Models\Products_request_sub;
use App\Models\Products;
use App\Models\Products_type;
use App\Models\Product_group;
use App\Models\User_permiss;
use App\Models\Products_category;
use App\Models\Leave_leader;
use App\Models\Leave_leader_sub;
use App\Models\Line_token;
use App\Models\Permiss_setting;
use DataTables;

class PermissController extends Controller
{

public function permiss(Request $request)
{
    $data['users'] = User::get();
    return view('setting.permiss',$data);
}
public function permiss_liss(Request $request,$id)
{
    $data['users'] = User::get();
    $dataedit = User::leftjoin('users_prefix','users_prefix.prefix_code','=','users.pname')->leftjoin('permiss_setting','permiss_setting.permiss_setting_userid','=','users.id')
    ->where('users.id','=',$id)->first();

    $data['count_vet']     = DB::table('user_permiss')->where('user_id','=',$id)->where('user_permiss_num','=','AUDITVET01')->count();
    $data['count_fdh']     = DB::table('user_permiss')->where('user_id','=',$id)->where('user_permiss_num','=','FDH')->count();
    $data['count_accb']    = DB::table('user_permiss')->where('user_id','=',$id)->where('user_permiss_num','=','ACCB01')->count();
    $data['count_time']    = DB::table('user_permiss')->where('user_id','=',$id)->where('user_permiss_num','=','TIMEOT01')->count();
    $data['count_106']     = DB::table('user_permiss')->where('user_id','=',$id)->where('user_permiss_num','=','OVERSUE_OP')->count();
    $data['count_107']     = DB::table('user_permiss')->where('user_id','=',$id)->where('user_permiss_num','=','OVERSUE_IP')->count();
    $data['count_report']  = DB::table('user_permiss')->where('user_id','=',$id)->where('user_permiss_num','=','ACC_REPORT')->count();
    $data['count_50x']  = DB::table('user_permiss')->where('user_id','=',$id)->where('user_permiss_num','=','ACC_50X')->count();
    $data['count_70x']  = DB::table('user_permiss')->where('user_id','=',$id)->where('user_permiss_num','=','ACC_70X')->count();

    $data['count_201']  = DB::table('user_permiss')->where('user_id','=',$id)->where('user_permiss_num','=','ACC_201')->count();
    $data['count_202']  = DB::table('user_permiss')->where('user_id','=',$id)->where('user_permiss_num','=','ACC_202')->count();
    $data['count_203']  = DB::table('user_permiss')->where('user_id','=',$id)->where('user_permiss_num','=','ACC_203')->count();
    $data['count_209']  = DB::table('user_permiss')->where('user_id','=',$id)->where('user_permiss_num','=','ACC_209')->count();
    $data['count_216']  = DB::table('user_permiss')->where('user_id','=',$id)->where('user_permiss_num','=','ACC_216')->count();
    $data['count_217']  = DB::table('user_permiss')->where('user_id','=',$id)->where('user_permiss_num','=','ACC_217')->count();

    $data['count_301']  = DB::table('user_permiss')->where('user_id','=',$id)->where('user_permiss_num','=','ACC_301')->count();
    $data['count_302']  = DB::table('user_permiss')->where('user_id','=',$id)->where('user_permiss_num','=','ACC_302')->count();
    $data['count_303']  = DB::table('user_permiss')->where('user_id','=',$id)->where('user_permiss_num','=','ACC_303')->count();
    $data['count_304']  = DB::table('user_permiss')->where('user_id','=',$id)->where('user_permiss_num','=','ACC_304')->count();
    $data['count_307']  = DB::table('user_permiss')->where('user_id','=',$id)->where('user_permiss_num','=','ACC_307')->count();
    $data['count_308']  = DB::table('user_permiss')->where('user_id','=',$id)->where('user_permiss_num','=','ACC_308')->count();
    $data['count_309']  = DB::table('user_permiss')->where('user_id','=',$id)->where('user_permiss_num','=','ACC_309')->count();
    $data['count_310']  = DB::table('user_permiss')->where('user_id','=',$id)->where('user_permiss_num','=','ACC_310')->count();

    // dd($dataedit_new);
    return view('setting.permiss_liss',$data,[
       'dataedits'       => $dataedit,
    //    'dataedit_new'    => $dataedit_new
    ]);
}
public function permiss_save(Request $request)
{

        $id = $request->input('id');
        // dd($id);
        $update = User::find($id);
            $update->permiss_person          = $request->input('permiss_person');
            $update->permiss_gleave          = $request->input('permiss_gleave');
            $update->permiss_book            = $request->input('permiss_book');
            $update->permiss_car             = $request->input('permiss_car');
            $update->permiss_meetting        = $request->input('permiss_meetting');
            $update->permiss_repair          = $request->input('permiss_repair');
            $update->permiss_com             = $request->input('permiss_com');
            $update->permiss_medical         = $request->input('permiss_medical');
            $update->permiss_plan            = $request->input('permiss_plan');
            $update->permiss_hosing          = $request->input('permiss_hosing');
            $update->permiss_asset           = $request->input('permiss_asset');
            $update->permiss_supplies        = $request->input('permiss_supplies');
            $update->permiss_store           = $request->input('permiss_store');
            $update->permiss_store_dug       = $request->input('permiss_store_dug');
            $update->permiss_pay             = $request->input('permiss_pay');
            $update->permiss_money           = $request->input('permiss_money');
            $update->permiss_claim           = $request->input('permiss_claim');
            $update->permiss_medicine        = $request->input('permiss_medicine');
            $update->permiss_ot              = $request->input('permiss_ot');
            $update->permiss_p4p             = $request->input('permiss_p4p');
            $update->permiss_time            = $request->input('permiss_time');
            $update->permiss_env             = $request->input('permiss_env');
            $update->permiss_account         = $request->input('permiss_account');
            $update->permiss_setting_account = $request->input('permiss_setting_account');
            $update->permiss_setting_upstm   = $request->input('permiss_setting_upstm');
            $update->permiss_setting_env     = $request->input('permiss_setting_env');
            $update->permiss_rep_money       = $request->input('permiss_rep_money');
            $update->permiss_ucs             = $request->input('permiss_ucs');
            $update->permiss_sss             = $request->input('permiss_sss');
            $update->permiss_ofc             = $request->input('permiss_ofc');
            $update->permiss_lgo             = $request->input('permiss_lgo');
            $update->permiss_prb             = $request->input('permiss_prb');
            $update->permiss_ti              = $request->input('permiss_ti');
            $update->permiss_sot             = $request->input('permiss_sot');
            $update->permiss_clinic_tb       = $request->input('permiss_clinic_tb');
            $update->permiss_medicine_salt   = $request->input('permiss_medicine_salt');
            $update->pesmiss_ct              = $request->input('pesmiss_ct');
            $update->per_prs                 = $request->input('per_prs');
            $update->per_cctv                = $request->input('per_cctv');
            $update->per_fire                = $request->input('per_fire');
            $update->per_air                 = $request->input('per_air');
            $update->per_config              = $request->input('admin');
        $update->save();

        $audit  = $request->input('AUDITVET01');
        $count = DB::table('user_permiss')->where('user_id','=',$id)->where('user_permiss_num','=','AUDITVET01')->count();
        if ($count > 0) {
            if ($audit == '' || $audit == null) {
                User_permiss::where('user_id','=',$id)->where('user_permiss_num','=','AUDITVET01')->delete();
            }
        } else {
            if ($audit == '' || $audit == null) {
                User_permiss::where('user_id','=',$id)->where('user_permiss_num','=','AUDITVET01')->delete();
            } else {
                User_permiss::insert([
                    'user_id'           => $id,
                    'user_permiss_num'   => 'AUDITVET01',
                    'user_permiss_name'  => 'Pre-Audit'
                ]);

            }

        }
        $audit2  = $request->input('FDH');
        $count2 = DB::table('user_permiss')->where('user_id','=',$id)->where('user_permiss_num','=','FDH')->count();
        if ($count2 > 0) {
            if ($audit2 == '' || $audit2 == null) {
                User_permiss::where('user_id','=',$id)->where('user_permiss_num','=','FDH')->delete();
            }
        } else {
            if ($audit2 == '' || $audit2 == null) {
                User_permiss::where('user_id','=',$id)->where('user_permiss_num','=','FDH')->delete();
            } else {
                User_permiss::insert([
                    'user_id'           => $id,
                    'user_permiss_num'   => 'FDH',
                    'user_permiss_name'  => 'FDH'
                ]);

            }

        }
        $audit3  = $request->input('ACCB01');
        $count3 = DB::table('user_permiss')->where('user_id','=',$id)->where('user_permiss_num','=','ACCB01')->count();
        if ($count3 > 0) {
            if ($audit3 == '' || $audit3 == null) {
                User_permiss::where('user_id','=',$id)->where('user_permiss_num','=','ACCB01')->delete();
            }
        } else {
            if ($audit3 == '' || $audit3 == null) {
                User_permiss::where('user_id','=',$id)->where('user_permiss_num','=','ACCB01')->delete();
            } else {
                User_permiss::insert([
                    'user_id'           => $id,
                    'user_permiss_num'   => 'ACCB01',
                    'user_permiss_name'  => 'บัญชี'
                ]);

            }

        }
        $audit4  = $request->input('TIMEOT01');
        $count4 = DB::table('user_permiss')->where('user_id','=',$id)->where('user_permiss_num','=','TIMEOT01')->count();
        // dd($count4);
        if ($count4 > 0) {
            if ($audit4 == '' || $audit4 == null) {
                User_permiss::where('user_id','=',$id)->where('user_permiss_num','=','TIMEOT01')->delete();
            }
        } else {
            // dd($audit4);
            if ($audit4 == '' || $audit4 == null) {
                User_permiss::where('user_id','=',$id)->where('user_permiss_num','=','TIMEOT01')->delete();
            } else {
                User_permiss::insert([
                    'user_id'           => $id,
                    'user_permiss_num'   => 'TIMEOT01',
                    'user_permiss_name'  => 'ระบบลงเวลา'
                ]);

            }

        }
        $audit5  = $request->input('OVERSUE_OP');
        $count5 = DB::table('user_permiss')->where('user_id','=',$id)->where('user_permiss_num','=','OVERSUE_OP')->count();
        // dd($audit5);
        if ($count5 > 0) {
            if ($audit5 == '' || $audit5 == null) {
                User_permiss::where('user_id','=',$id)->where('user_permiss_num','=','TIMEOT01')->delete();
            }
        } else {
            if ($audit5 == '' || $audit5 == null) {
                User_permiss::where('user_id','=',$id)->where('user_permiss_num','=','OVERSUE_OP')->delete();
            } else {
                User_permiss::insert([
                    'user_id'           => $id,
                    'user_permiss_num'   => 'OVERSUE_OP',
                    'user_permiss_name'  => 'ค้างชำระ OP'
                ]);
            }
        }
        $audit6  = $request->input('OVERSUE_IP');
        $count6 = DB::table('user_permiss')->where('user_id','=',$id)->where('user_permiss_num','=','OVERSUE_IP')->count();
        if ($count6 > 0) {
            if ($audit6 == '' || $audit6 == null) {
                User_permiss::where('user_id','=',$id)->where('user_permiss_num','=','OVERSUE_IP')->delete();
            }
        } else {
            if ($audit6 == '' || $audit6 == null) {
                User_permiss::where('user_id','=',$id)->where('user_permiss_num','=','OVERSUE_IP')->delete();
            } else {
                User_permiss::insert([
                    'user_id'           => $id,
                    'user_permiss_num'   => 'OVERSUE_IP',
                    'user_permiss_name'  => 'ค้างชำระ IP'
                ]);
            }
        }
        $audit7  = $request->input('ACC_REPORT');
        $count7 = DB::table('user_permiss')->where('user_id','=',$id)->where('user_permiss_num','=','ACC_REPORT')->count();
        if ($count7 > 0) {
            if ($audit7 == '' || $audit7 == null) {
                User_permiss::where('user_id','=',$id)->where('user_permiss_num','=','ACC_REPORT')->delete();
            }
        } else {
            if ($audit7 == '' || $audit7 == null) {
                User_permiss::where('user_id','=',$id)->where('user_permiss_num','=','ACC_REPORT')->delete();
            } else {
                User_permiss::insert([
                    'user_id'           => $id,
                    'user_permiss_num'   => 'ACC_REPORT',
                    'user_permiss_name'  => 'รายงาน STM'
                ]);
            }
        }
        $audit8  = $request->input('ACC_50X');
        $count8 = DB::table('user_permiss')->where('user_id','=',$id)->where('user_permiss_num','=','ACC_50X')->count();
        if ($count8 > 0) {
            if ($audit8 == '' || $audit8 == null) {
                User_permiss::where('user_id','=',$id)->where('user_permiss_num','=','ACC_50X')->delete();
            }
        } else {
            if ($audit8 == '' || $audit8 == null) {
                User_permiss::where('user_id','=',$id)->where('user_permiss_num','=','ACC_50X')->delete();
            } else {
                User_permiss::insert([
                    'user_id'           => $id,
                    'user_permiss_num'   => 'ACC_50X',
                    'user_permiss_name'  => 'ต่างด้าว'
                ]);
            }
        }
        $audit9  = $request->input('ACC_70X');
        $count9 = DB::table('user_permiss')->where('user_id','=',$id)->where('user_permiss_num','=','ACC_70X')->count();
        if ($count9 > 0) {
            if ($audit9 == '' || $audit9 == null) {
                User_permiss::where('user_id','=',$id)->where('user_permiss_num','=','ACC_70X')->delete();
            }
        } else {
            if ($audit9 == '' || $audit9 == null) {
                User_permiss::where('user_id','=',$id)->where('user_permiss_num','=','ACC_70X')->delete();
            } else {
                User_permiss::insert([
                    'user_id'           => $id,
                    'user_permiss_num'   => 'ACC_70X',
                    'user_permiss_name'  => 'สถานะสิทธิ์'
                ]);
            }
        }
        $audit10  = $request->input('ACC_201');
        $count10 = DB::table('user_permiss')->where('user_id','=',$id)->where('user_permiss_num','=','ACC_201')->count();
        if ($count10 > 0) {
            if ($audit10 == '' || $audit10 == null) {
                User_permiss::where('user_id','=',$id)->where('user_permiss_num','=','ACC_201')->delete();
            }
        } else {
            if ($audit10 == '' || $audit10 == null) {
                User_permiss::where('user_id','=',$id)->where('user_permiss_num','=','ACC_201')->delete();
            } else {
                User_permiss::insert([
                    'user_id'           => $id,
                    'user_permiss_num'   => 'ACC_201',
                    'user_permiss_name'  => '201 UC-OP'
                ]);
            }
        }
        $audit11  = $request->input('ACC_202');
        $count11 = DB::table('user_permiss')->where('user_id','=',$id)->where('user_permiss_num','=','ACC_202')->count();
        if ($count11 > 0) {
            if ($audit11 == '' || $audit11 == null) {
                User_permiss::where('user_id','=',$id)->where('user_permiss_num','=','ACC_202')->delete();
            }
        } else {
            if ($audit11 == '' || $audit11 == null) {
                User_permiss::where('user_id','=',$id)->where('user_permiss_num','=','ACC_202')->delete();
            } else {
                User_permiss::insert([
                    'user_id'           => $id,
                    'user_permiss_num'   => 'ACC_202',
                    'user_permiss_name'  => '202 UC-IP'
                ]);
            }
        }
        $audit12  = $request->input('ACC_203');
        $count12 = DB::table('user_permiss')->where('user_id','=',$id)->where('user_permiss_num','=','ACC_203')->count();
        if ($count12 > 0) {
            if ($audit12 == '' || $audit12 == null) {
                User_permiss::where('user_id','=',$id)->where('user_permiss_num','=','ACC_203')->delete();
            }
        } else {
            if ($audit12 == '' || $audit12 == null) {
                User_permiss::where('user_id','=',$id)->where('user_permiss_num','=','ACC_203')->delete();
            } else {
                User_permiss::insert([
                    'user_id'           => $id,
                    'user_permiss_num'   => 'ACC_203',
                    'user_permiss_name'  => '203 UC-OP นอก CUP'
                ]);
            }
        }
        $audit13  = $request->input('ACC_209');
        $count13 = DB::table('user_permiss')->where('user_id','=',$id)->where('user_permiss_num','=','ACC_209')->count();
        if ($count13 > 0) {
            if ($audit13 == '' || $audit13 == null) {
                User_permiss::where('user_id','=',$id)->where('user_permiss_num','=','ACC_209')->delete();
            }
        } else {
            if ($audit13 == '' || $audit13 == null) {
                User_permiss::where('user_id','=',$id)->where('user_permiss_num','=','ACC_209')->delete();
            } else {
                User_permiss::insert([
                    'user_id'           => $id,
                    'user_permiss_num'   => 'ACC_209',
                    'user_permiss_name'  => '209 (P&P)'
                ]);
            }
        }
        $audit14  = $request->input('ACC_216');
        $count14 = DB::table('user_permiss')->where('user_id','=',$id)->where('user_permiss_num','=','ACC_216')->count();
        if ($count14 > 0) {
            if ($audit14 == '' || $audit14 == null) {
                User_permiss::where('user_id','=',$id)->where('user_permiss_num','=','ACC_216')->delete();
            }
        } else {
            if ($audit14 == '' || $audit14 == null) {
                User_permiss::where('user_id','=',$id)->where('user_permiss_num','=','ACC_216')->delete();
            } else {
                User_permiss::insert([
                    'user_id'           => $id,
                    'user_permiss_num'   => 'ACC_216',
                    'user_permiss_name'  => '216 UC-OP(CR)'
                ]);
            }
        }
        $audit15  = $request->input('ACC_217');
        $count15 = DB::table('user_permiss')->where('user_id','=',$id)->where('user_permiss_num','=','ACC_217')->count();
        if ($count15 > 0) {
            if ($audit15 == '' || $audit15 == null) {
                User_permiss::where('user_id','=',$id)->where('user_permiss_num','=','ACC_217')->delete();
            }
        } else {
            if ($audit15 == '' || $audit15 == null) {
                User_permiss::where('user_id','=',$id)->where('user_permiss_num','=','ACC_217')->delete();
            } else {
                User_permiss::insert([
                    'user_id'           => $id,
                    'user_permiss_num'   => 'ACC_217',
                    'user_permiss_name'  => '217 UC-IP(CR)'
                ]);
            }
        }

        // $data['count_216']  = DB::table('user_permiss')->where('user_id','=',$id)->where('user_permiss_num','=','ACC_216')->count();
        // $data['count_217']  = DB::table('user_permiss')->where('user_id','=',$id)->where('user_permiss_num','=','ACC_217')->count();

        // $update_new = User_permiss::find($id);
        // $update_new->permiss_person          = $request->input('permiss_person');
        // $update_new->save();
        // dd($request->id);
        // dd($request->permiss_setting_name);
        // Permiss_setting
        // $countper = Permiss_setting::where('permiss_setting_userid','=',$request->iduser)->where('permiss_setting_name','=',$request->permiss_setting_name)->count();
        // // dd($countper);
        // if ($countper > 0) {
        //     # code...
        // } else {
            // Permiss_setting::where('permiss_setting_userid')->update([
            //     'permiss_setting_userid' => $request->iduser,
            //     'permiss_setting_name' => $request->permiss_setting_name,
            // ]);
            // if ($request->permiss_setting_name != '' || $request->permiss_setting_name != null) {
            //     $permiss_setting_name = $request->permiss_setting_name;
            //     $iduser = $request->iduser;

            //     $number = count($permiss_setting_name);
            //     $count = 0;
            //     for ($count = 0; $count < $number; $count++) {

            //         $add2 = new Permiss_setting();
            //         $add2->permiss_setting_userid = $iduser[$count];
            //         $add2->permiss_setting_name = $permiss_setting_name[$count];
            //         $add2->save();
            //     }

            // }
        // }



        return response()->json([
            'status'     => '200'
    ]);
}
public function permiss_edit(Request $request,$id)
{
    // $data['department'] = Department::all();
    $data['department'] = Department::leftJoin('users','department.LEADER_ID','=','users.id')->orderBy('DEPARTMENT_ID','DESC')
    // ->select('users.*', 'department.DEPARTMENT_ID', 'department.DEPARTMENT_NAME', 'department.LINE_TOKEN')
    ->get();
    $data['users'] = User::get();
    $dataedit = Department::where('DEPARTMENT_ID','=',$id)->first();

    return view('setting.permiss_edit',$data,[
        'dataedits'=>$dataedit
    ]);
}
public function permiss_update(Request $request)
{
    $iddep = $request->DEPARTMENT_ID;

    $update = Department::find($iddep);
    $update->DEPARTMENT_NAME = $request->input('DEPARTMENT_NAME');
    $update->LINE_TOKEN = $request->input('LINE_TOKEN');

    $iduser = $request->input('LEADER_ID');
    if ($iduser != '') {
        $usersave = DB::table('users')->where('id','=',$iduser)->first();
        $update->LEADER_ID = $usersave->id;
        $update->LEADER_NAME = $usersave->fname. '  ' .$usersave->lname ;
    } else {
        $update->LEADER_ID = '';
        $update->LEADER_NAME ='';
    }

    $update->save();

    return response()->json([
        'status'     => '200'
        ]);

}

public function permiss_destroy(Request $request,$id)
{
   $del = Department::find($id);

   $del->delete();
    return response()->json(['status' => '200','success' => 'Delete Success']);
}
function switchpermiss_person(Request $request)
{
    $id = $request->person;
    $active = User::find($id);
    $active->permiss_person = $request->onoff;
    $active->save();
}
function switchpermiss_book(Request $request)
{
    $id = $request->book;
    $active = User::find($id);
    $active->permiss_book = $request->onoff;
    $active->save();
}
function switchpermiss_car(Request $request)
{
    $id = $request->car;
    $active = User::find($id);
    $active->permiss_car = $request->onoff;
    $active->save();
}
function switchpermiss_meetting(Request $request)
{
    $id = $request->meetting;
    $active = User::find($id);
    $active->permiss_meetting = $request->onoff;
    $active->save();
}
function switchpermiss_repair(Request $request)
{
    $id = $request->repaire;
    $active = User::find($id);
    $active->permiss_repair = $request->onoff;
    $active->save();
}



}
