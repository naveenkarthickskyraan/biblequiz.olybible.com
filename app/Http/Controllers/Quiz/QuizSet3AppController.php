<?php

namespace App\Http\Controllers\Quiz;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\Module;
Use App\Models\Admin;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\App\QuizAppSet3;
use App\Models\Category\QuizCategorySet3;
use App\Models\MappedApp\QuizSet3MappedAppCategory;
use App\Helpers\LogActivity;

class QuizSet3AppController extends Controller
{
    public function show()
    {
        $role = Auth::guard('admin')->user()->role;
        $AccessPrivilege = Auth::guard('admin')->user()->accountAccessPrivilege;
        $AccessModule = Auth::guard('admin')->user()->accountAccessModule;
        $explode = explode('|',$AccessModule);
        $explode_1 = explode('|',$AccessPrivilege);
        $lists = explode('|',Auth::guard('admin')->user()->access_list);
        $list_array = in_array('set_3',$lists);
        $array = in_array('app',$explode);
        $array_1= in_array('view',$explode_1);
        if(($role == "SuperAdmin") || ($array == true && $array_1 == true && $list_array == true))
        {
            $app = QuizAppSet3::orderBy('id','asc')->where('deleted_at','0')->get();
            $active = QuizAppSet3::where('is_active','1')->get();
            return view('admin.set3.applist.app_list', ['apps' => $app],['app_active'=>$active]);
        }
        else
        {
            return redirect()->route('admin/dashboard')->with("error","Permission Denied");
        }
    }

    function Add_list()
    {
        $role = Auth::guard('admin')->user()->role;
        $AccessPrivilege = Auth::guard('admin')->user()->accountAccessPrivilege;
        $AccessModule = Auth::guard('admin')->user()->accountAccessModule;
        $explode = explode('|',$AccessModule);
        $explode_1 = explode('|',$AccessPrivilege);
        $lists = explode('|',Auth::guard('admin')->user()->access_list);
        $list_array = in_array('set_3',$lists);
        $array = in_array('app',$explode);
        $array_1= in_array('add',$explode_1);
        if(($role == "SuperAdmin") || ($array == true && $array_1 == true && $list_array == true))
        {
            return view('admin.set3.applist.add_app');
        }
        else
        {
            return redirect()->route('admin/dashboard')->with("error","Permission Denied");
        }
    }

    public function store(Request $request)
    {
        
        $request->validate([
            'app_name' => 'required|string|max:255',
            'app_description' => 'required',
            
        ]);

        $user = new QuizAppSet3;
        $user->app_name = $request['app_name'];
        $user->app_description = $request['app_description'];
        $user->app_image = $request['file'];

        if($request->file_type == 1)
        {
            $user->image_type = $request->file_type;
            $user->app_image = $request['file'];
            if($request->hasFile('file'))
            { 
                $image = $request['file'];
                $image_name = $image->getClientOriginalName();
                $extension = pathinfo($image_name, PATHINFO_EXTENSION);
                $encrpt = round(microtime(true)*1000);
                $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                $charactersLength = strlen($characters);
                $randomString = '';
                for ($i = 0; $i < $charactersLength; $i++) 
                {
                    $randomString .= $characters[rand(0, $charactersLength - 1)];
                }
                $new_name = ($encrpt).'_'.$randomString.'.'.$extension;
                $image->move(public_path('storage/prayers/app'),$new_name);
                $new_name_2 = 'storage/prayers/app/'.$new_name;
            }
            $uploaded_file = $new_name_2 ?? '';        
            $user->app_image = $uploaded_file;
        }
        else if($request->file_type == 2)
        {
            $user->app_image = $request->url_image;
            $user->image_type = $request->file_type;
        }
        LogActivity::addToLog();
        $user->save();
        return back()->with('message','App Created Successfully');
    }

    public function edit($id)
    {
        $role = Auth::guard('admin')->user()->role;
        $AccessPrivilege = Auth::guard('admin')->user()->accountAccessPrivilege;
        $AccessModule = Auth::guard('admin')->user()->accountAccessModule;
        $explode = explode('|',$AccessModule);
        $explode_1 = explode('|',$AccessPrivilege);
        $lists = explode('|',Auth::guard('admin')->user()->access_list);
        $list_array = in_array('set_3',$lists);
        $array = in_array('app',$explode);
        $array_1= in_array('edit',$explode_1);
        if(($role == "SuperAdmin") || ($array == true && $array_1 == true && $list_array == true))
        {
            $edit = QuizAppSet3::find($id);
            $category = QuizCategorySet3::where('deleted_at','0')->get();
            $mapped_res = QuizSet3MappedAppCategory::select(['category_id'])->where('app_id',$id)->get();
            $mapped_app=[];
            foreach($mapped_res as $row)
            {
                    $mapped_app[] = $row->category_id;
            }
            return view('admin.set3.applist.mapped_app_category', ['edit'=> $edit,'category_list'=>$category,'mapped_app'=>$mapped_app]);
        }
        else
        {
            return redirect()->route('admin/dashboard')->with("error","Permission Denied");
        }

    }

    public function active(Request $request)
    {
        $role = Auth::guard('admin')->user()->role;
        $AccessPrivilege = Auth::guard('admin')->user()->accountAccessPrivilege;
        $AccessModule = Auth::guard('admin')->user()->accountAccessModule;
        $explode = explode('|',$AccessModule);
        $explode_1 = explode('|',$AccessPrivilege);
        $lists = explode('|',Auth::guard('admin')->user()->access_list);
        $list_array = in_array('set_3',$lists);
        $array = in_array('app',$explode);
        $array_1= in_array('edit',$explode_1);
        if(($role == "SuperAdmin") || ($array == true && $array_1 == true && $list_array == true))
        {
            $parent_id = $request->app_id;
            $status = $request->status;
            if($status == 0)
            {
                $app_active = QuizAppSet3::find($parent_id);
                $app_active->is_active ='1';
                $app_active->save();
                return back()->with('message','App Disabled Successfully');
            }
            if($status == 1)
            {
                $app_active = QuizAppSet3::find($parent_id);
                $app_active->is_active ='0';
                $app_active->save();
                return back()->with('message','App Enabled Successfully');
            }
        }
        else
        {
            return redirect()->route('admin/dashboard')->with("error","Permission Denied");
        }
        
    }

    public function delete(Request $request, $id)
    {
        $role = Auth::guard('admin')->user()->role;
        $AccessPrivilege = Auth::guard('admin')->user()->accountAccessPrivilege;
        $AccessModule = Auth::guard('admin')->user()->accountAccessModule;
        $explode = explode('|',$AccessModule);
        $explode_1 = explode('|',$AccessPrivilege);
        $lists = explode('|',Auth::guard('admin')->user()->access_list);
        $list_array = in_array('set_3',$lists);
        $array = in_array('app',$explode);
        $array_1= in_array('delete',$explode_1);
        if(($role == "SuperAdmin") || ($array == true && $array_1 == true && $list_array == true))
        {
            $Q1 = QuizAppSet3::find($id);
            $Q1->deleted_at = '1';
            $Q1->save();
            return back()->with('message','Delete Record Successfully');
        }
        else
        {
            return redirect()->route('admin/dashboard')->with("error","Permission Denied");
        }
    }

    public function EditApp($id)
    {
        $role = Auth::guard('admin')->user()->role;
        $AccessPrivilege = Auth::guard('admin')->user()->accountAccessPrivilege;
        $AccessModule = Auth::guard('admin')->user()->accountAccessModule;
        $explode = explode('|',$AccessModule);
        $explode_1 = explode('|',$AccessPrivilege);
        $lists = explode('|',Auth::guard('admin')->user()->access_list);
        $list_array = in_array('set_3',$lists);
        $array = in_array('app',$explode);
        $array_1= in_array('edit',$explode_1);
        if(($role == "SuperAdmin") || ($array == true && $array_1 == true && $list_array == true))
        {
            $edit = QuizAppSet3::find($id);
            $array = array($edit);
            return view('admin.set3.applist.edit_app_list', ['edit_app_id'=> $array]);
        }
        else
        {
            return redirect()->route('admin/dashboard')->with("error","Permission Denied");
        }
    }
    
    public function EditAppList(Request $request, $id)
    {
        
        $request->validate([
            'edited_app_name' => 'required|string|max:255',
            'edited_app_description' => 'required',
            
        ]);

        $user = QuizAppSet3::find($id);
        $user->app_name = $request->input('edited_app_name');
        $user->app_description = $request->input('edited_app_description');
        if($request->file_type == 1)
        {
            $user->image_type = $request->file_type;
            $user->app_image = $request['file'];
            if($request->hasFile('file'))
            { 
                $image = $request['file'];
                $image_name = $image->getClientOriginalName();
                $extension = pathinfo($image_name, PATHINFO_EXTENSION);
                $encrpt = round(microtime(true)*1000);
                $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                $charactersLength = strlen($characters);
                $randomString = '';
                for ($i = 0; $i < $charactersLength; $i++) 
                {
                    $randomString .= $characters[rand(0, $charactersLength - 1)];
                }
                $new_name = ($encrpt).'_'.$randomString.'.'.$extension;
                $image->move(public_path('storage/prayers/app'),$new_name);
                $new_name_2 = 'storage/prayers/app/'.$new_name;
            }
            $uploaded_file = $new_name_2 ?? '';        
            $user->app_image = $uploaded_file;
        }
        else if($request->file_type == 2)
        {
            $user->app_image = $request->url_image;
            $user->image_type = $request->file_type;
        }
        LogActivity::addToLog();
        $user->save();
        return back()->with('message','App Edit Successfully');
    }
}
