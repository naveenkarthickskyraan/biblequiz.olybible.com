<?php

namespace App\Http\Controllers\Quiz;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\SubCategory\QuizSubCategorySet3;
use Auth;
Use App\Models\App\ImageAppList;
use App\Models\Module;
Use App\Models\Admin;
use Illuminate\Support\Facades\Validator;
Use App\Models\Category\QuizCategorySet3;
use App\Models\MappedApp\QuizSet3MappedAppCategory;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Helpers\LogActivity;

class QuizSet3SubCategoryController extends Controller
{
    function show()
    {
        $role = Auth::guard('admin')->user()->role;
        $AccessPrivilege = Auth::guard('admin')->user()->accountAccessPrivilege;
        $AccessModule = Auth::guard('admin')->user()->accountAccessModule;
        $explode = explode('|',$AccessModule);
        $explode_1 = explode('|',$AccessPrivilege);
        $lists = explode('|',Auth::guard('admin')->user()->access_list);
        $list_array = in_array('set_3',$lists);
        $array = in_array('sub_category',$explode);
        $array_1= in_array('view',$explode_1);
        if(($role == "SuperAdmin") || ($array == true && $array_1 == true && $list_array == true))
        {
            $sub_category = QuizSubCategorySet3::orderBy('id','asc')->where('deleted_at','0')->get();
            return view('admin.set3.subcategory.sub_category_list', ['sub_categorys' => $sub_category]);
        }
        else
        {
            return redirect()->route('admin/dashboard')->with("error","Permission Denied");
        }
    }
    


    function add()
    {
        $role = Auth::guard('admin')->user()->role;
        $AccessPrivilege = Auth::guard('admin')->user()->accountAccessPrivilege;
        $AccessModule = Auth::guard('admin')->user()->accountAccessModule;
        $explode = explode('|',$AccessModule);
        $explode_1 = explode('|',$AccessPrivilege);
        $lists = explode('|',Auth::guard('admin')->user()->access_list);
        $list_array = in_array('set_3',$lists);
        $array = in_array('sub_category',$explode);
        $array_1= in_array('add',$explode_1);
        if(($role == "SuperAdmin") || ($array == true && $array_1 == true && $list_array == true))
        {
            return view('admin.set3.subcategory.add_sub_category');
        }
        else
        {
            return redirect()->route('admin/dashboard')->with("error","Permission Denied");
        }
    }

    public function store(Request $request)
    {
        
        $request->validate([
            'SubCategoryName' => 'required|string|max:255',
            'SubCategoryDescription' => 'required',
        ]);   
        $user = new QuizSubCategorySet3;
        $user->sub_category_name = $request['SubCategoryName'];
        $user->sub_category_description = $request['SubCategoryDescription'];
        $user->sub_category_image = $request['file'];

        if($request->file_type == 1)
        {
            $user->image_type = $request->file_type;
            $user->sub_category_image = $request['file'];
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
                $image->move(public_path('storage/Image/subcategory'),$new_name);
                $new_name_2= 'storage/Image/subcategory/'.$new_name;
            }
            $uploaded_file = $new_name_2 ?? '';        
            $user->sub_category_image = $uploaded_file;
        }
        else if($request->file_type == 2)
        {
            $user->sub_category_image = $request->url_image;
            $user->image_type = $request->file_type;
        }
        LogActivity::addToLog();
        $user->save();
        return back()->with('message','Sub - Category Created Successfully');
    }

    public function active(Request $request)
    {
        LogActivity::addToLog();
        $role = Auth::guard('admin')->user()->role;
        $AccessPrivilege = Auth::guard('admin')->user()->accountAccessPrivilege;
        $AccessModule = Auth::guard('admin')->user()->accountAccessModule;
        $explode = explode('|',$AccessModule);
        $explode_1 = explode('|',$AccessPrivilege);
        $lists = explode('|',Auth::guard('admin')->user()->access_list);
        $list_array = in_array('set_3',$lists);
        $array = in_array('sub_category',$explode);
        $array_1= in_array('edit',$explode_1);
        if(($role == "SuperAdmin") || ($array == true && $array_1 == true && $list_array == true))
        {
            $sub_cat_id = $request->sub_cat_id;
            $status = $request->status;
            if($status == 0)
            {
                $app_active = QuizSubCategorySet3::find($sub_cat_id);
                $app_active->is_active ='1';
                $app_active->save();
                return back()->with('message','Sub-Category Disabled Successfully');
            }
            if($status == 1)
            {
                $app_active = QuizSubCategorySet3::find($sub_cat_id);
                $app_active->is_active ='0';
                $app_active->save();
                return back()->with('message','Sub-Category Enabled Successfully');
            }
        }
        else
        {
            return redirect()->route('admin/dashboard')->with("error","Permission Denied");
        }
        
    }

    public function delete(Request $request, $id)
    {
        LogActivity::addToLog();
        $role = Auth::guard('admin')->user()->role;
        $AccessPrivilege = Auth::guard('admin')->user()->accountAccessPrivilege;
        $AccessModule = Auth::guard('admin')->user()->accountAccessModule;
        $explode = explode('|',$AccessModule);
        $explode_1 = explode('|',$AccessPrivilege);
        $lists = explode('|',Auth::guard('admin')->user()->access_list);
        $list_array = in_array('set_3',$lists);
        $array = in_array('sub_category',$explode);
        $array_1= in_array('delete',$explode_1);
        if(($role == "SuperAdmin") || ($array == true && $array_1 == true && $list_array == true))
        {
            $Q1 = QuizSubCategorySet3::find($id);
            $Q1->deleted_at = '1';
            $Q1->save();
            return back()->with('message','Delete Record Successfully');
        }
        else
        {
            return redirect()->route('admin/dashboard')->with("error","Permission Denied");
        }
    }

    public function EditSubCategory($id)
    {
        LogActivity::addToLog();
        $role = Auth::guard('admin')->user()->role;
        $AccessPrivilege = Auth::guard('admin')->user()->accountAccessPrivilege;
        $AccessModule = Auth::guard('admin')->user()->accountAccessModule;
        $explode = explode('|',$AccessModule);
        $explode_1 = explode('|',$AccessPrivilege);
        $lists = explode('|',Auth::guard('admin')->user()->access_list);
        $list_array = in_array('set_3',$lists);
        $array = in_array('sub_category',$explode);
        $array_1= in_array('edit',$explode_1);
        if(($role == "SuperAdmin") || ($array == true && $array_1 == true && $list_array == true))
        {
            $edit = QuizSubCategorySet3::find($id);
            $array = array($edit);
            return view('admin.set3.subcategory.edit_sub_Category_list', ['edit_sub_category_id'=> $array]);
        }
        else
        {
            return redirect()->route('admin/dashboard')->with("error","Permission Denied");
        }
    }

    public function EditSubCatList(Request $request, $id)
    {
        
        $request->validate([
            'SubCategoryName' => 'required|string|max:255',
            'SubCategoryDescription' => 'required',
        ]);   
        $user = QuizSubCategorySet3::find($id);
        $user->sub_category_name = $request['SubCategoryName'];
        $user->sub_category_description = $request['SubCategoryDescription'];
        $user->sub_category_image = $request['file'];
        if($request->file_type == 1)
        {
            $user->image_type = $request->file_type;
            $user->sub_category_image = $request['file'];
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
                $image->move(public_path('storage/Image/subcategory'),$new_name);
                $new_name_2 = 'storage/Image/subcategory/'.$new_name;
            }
            $uploaded_file = $new_name_2 ?? '';        
            $user->sub_category_image = $uploaded_file;
        }
        else if($request->file_type == 2)
        {
            $user->sub_category_image = $request->url_image;
            $user->image_type = $request->file_type;
        }
        LogActivity::addToLog();
        $user->save();
        return back()->with('message','Sub - Category Edit Successfully');
    }
}
