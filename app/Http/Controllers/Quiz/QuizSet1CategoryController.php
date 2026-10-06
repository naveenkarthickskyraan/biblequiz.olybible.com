<?php

namespace App\Http\Controllers\Quiz;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use Auth;
use App\Models\App\QuizAppSet1;
use App\Models\Module;
Use App\Models\Admin;
use Illuminate\Support\Facades\Validator;
use App\Models\Category\QuizCategorySet1;
use App\Models\SubCategory;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Helpers\LogActivity;
use App\Models\MappedApp\QuizSet1MappedAppCategory;


class QuizSet1CategoryController extends Controller
{
    function show()
    {
        LogActivity::addToLog();
        $role = Auth::guard('admin')->user()->role;
        $AccessPrivilege = Auth::guard('admin')->user()->accountAccessPrivilege;
        $AccessModule = Auth::guard('admin')->user()->accountAccessModule;
        $explode = explode('|',$AccessModule);
        $explode_1 = explode('|',$AccessPrivilege);
        $lists = explode('|',Auth::guard('admin')->user()->access_list);
        $list_array = in_array('set_1',$lists);
        $array = in_array('category',$explode);
        $array_1= in_array('view',$explode_1);
        if(($role == "SuperAdmin") || ($array == true && $array_1 == true && $list_array == true))
        {
            $category = QuizCategorySet1::orderBy('id','asc')->where('deleted_at','0')->get();
            return view('admin.set1.category.category_list', ['categorys' => $category]);
        }
        else
        {
            return redirect()->route('admin/dashboard')->with("error","Permission Denied");
        }
    }

    function Add_list()
    {
        LogActivity::addToLog();
        $role = Auth::guard('admin')->user()->role;
        $AccessPrivilege = Auth::guard('admin')->user()->accountAccessPrivilege;
        $AccessModule = Auth::guard('admin')->user()->accountAccessModule;
        $explode = explode('|',$AccessModule);
        $explode_1 = explode('|',$AccessPrivilege);
        $lists = explode('|',Auth::guard('admin')->user()->access_list);
        $list_array = in_array('set_1',$lists);
        $array = in_array('category',$explode);
        $array_1= in_array('add',$explode_1);
        if(($role == "SuperAdmin") || ($array == true && $array_1 == true && $list_array == true))
        {
            return view('admin.set1.category.add_category');
        }
        else
        {
            return redirect()->route('category.list')->with("error","Permission Denied");
        }
        
    }

    public function store(Request $request)
    {
        
        $request->validate([
            'category_name' => 'required|string|max:255',
            'category_description' => 'required',
        ]);

        $user = new QuizCategorySet1;
        $user->category_name = $request['category_name'];
        $user->category_description = $request['category_description'];
        $user->category_image = $request['file'];
        if($request->file_type == 1)
        {
            if($request->hasFile('file'))
            { 
                $user->image_type = $request->file_type;
                $user->category_image = $request['file'];
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
                $image->move(public_path('storage/prayers/category'),$new_name);
                $new_name_2 = 'storage/prayers/category/'.$new_name;
                $uploaded_file = $new_name_2 ?? '';        
                $user->category_image = $uploaded_file;
            }
            else
            {
                $user->category_image = "";
                $user->image_type = "";
            }
        }
        else if($request->file_type == 2)
        {
            $user->category_image = $request->url_image;
            $user->image_type = $request->file_type;
        }
        else
        {
            $user->category_image = "";
            $user->image_type = "";
        }
        $user->save();
        LogActivity::addToLog();
        return back()->with('message','Category Created Successfully');
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
        $list_array = in_array('set_1',$lists);
        $array = in_array('category',$explode);
        $array_1= in_array('edit',$explode_1);
        if(($role == "SuperAdmin") || ($array == true && $array_1 == true && $list_array == true))
        {
            $cat_id = $request->cat_id;
            $status = $request->status;
            if($status == 0)
            {
                $app_active = QuizCategorySet1::find($cat_id);
                $app_active->is_active ='1';
                $app_active->save();
                return back()->with('message','Category Disabled Successfully');
            }
            if($status == 1)
            {
                $app_active = QuizCategorySet1::find($cat_id);
                $app_active->is_active ='0';
                $app_active->save();
                return back()->with('message','Category Enabled Successfully');
            }
        }
        else
        {
            return redirect()->route('category.list')->with("error","Permission Denied");
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
        $list_array = in_array('set_1',$lists);
        $array = in_array('category',$explode);
        $array_1= in_array('delete',$explode_1);
        if(($role == "SuperAdmin") || ($array == true && $array_1 == true && $list_array == true))
        {
            $Q1 = QuizCategorySet1::find($id);
            $Q1->deleted_at = '1';
            $Q1->save();
            return back()->with('message','Delete Record Successfully');
        }
        else
        {
            return redirect()->route('category.list')->with("error","Permission Denied");
        }
    }

    public function EditCategory($id)
    {
        LogActivity::addToLog();
        $role = Auth::guard('admin')->user()->role;
        $AccessPrivilege = Auth::guard('admin')->user()->accountAccessPrivilege;
        $AccessModule = Auth::guard('admin')->user()->accountAccessModule;
        $explode = explode('|',$AccessModule);
        $explode_1 = explode('|',$AccessPrivilege);
        $lists = explode('|',Auth::guard('admin')->user()->access_list);
        $list_array = in_array('set_1',$lists);
        $array = in_array('category',$explode);
        $array_1= in_array('edit',$explode_1);
        if(($role == "SuperAdmin") || ($array == true && $array_1 == true && $list_array == true))
        {
            $edit = QuizCategorySet1::find($id);
            $array = array($edit);
            return view('admin.set1.category.edit_Category_list', ['edit_category_id'=> $array]);
        }
        else
        {
            return redirect()->route('category.list')->with("error","Permission Denied");
        }
       
    }

    public function EditCatList(Request $request, $id)
    {
        $request->validate([
            'editcatname' => 'required|string|max:255',
            'editcatdescription' => 'required',
            
        ]);

        $user = QuizCategorySet1::find($id);
        $user->category_name = $request->input('editcatname');
        $user->category_description = $request->input('editcatdescription');
        $user->category_image = $request['file']; 
        if($request->file_type == 1)
        {
            if($request->hasFile('file'))
            { 
                $user->image_type = $request->file_type;
                $user->category_image = $request['file'];
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
                $image->move(public_path('storage/prayers/category'),$new_name);
                $new_name_2 = 'storage/prayers/category/'.$new_name;
                $uploaded_file = $new_name_2 ?? '';        
                $user->category_image = $uploaded_file;
            }
        }
        else if($request->file_type == 2)
        {
            $user->category_image = $request->url_image;
            $user->image_type = $request->file_type;
        }
        $user->save();
    }
}
