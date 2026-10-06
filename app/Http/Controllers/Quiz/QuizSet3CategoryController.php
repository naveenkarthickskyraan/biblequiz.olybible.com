<?php

namespace App\Http\Controllers\Quiz;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use Auth;
use App\Models\App\QuizAppSet3;
use App\Models\Module;
Use App\Models\Admin;
use Illuminate\Support\Facades\Validator;
use App\Models\Category\QuizCategorySet3;
use App\Models\SubCategory\QuizSubCategorySet3;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Helpers\LogActivity;
use App\Models\MappedApp\QuizSet3MappedAppCategory;
use App\Models\MappedApp\QuizSet3CategoryMappedApp;


class QuizSet3CategoryController extends Controller
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
        $list_array = in_array('set_3',$lists);
        $array = in_array('category',$explode);
        $array_1= in_array('view',$explode_1);
        if(($role == "SuperAdmin") || ($array == true && $array_1 == true && $list_array == true))
        {
            $category = QuizCategorySet3::orderBy('id','asc')->where('deleted_at','0')->get();
            return view('admin.set3.category.category_list', ['categorys' => $category]);
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
        $list_array = in_array('set_3',$lists);
        $array = in_array('category',$explode);
        $array_1= in_array('add',$explode_1);
        if(($role == "SuperAdmin") || ($array == true && $array_1 == true && $list_array == true))
        {
            return view('admin.set3.category.add_category');
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

        $user = new QuizCategorySet3;
        $user->category_name = $request['category_name'];
        $user->category_description = $request['category_description'];
        $user->category_image = $request['file'];
        if($request->file_type == 1)
        {
            $user->image_type = $request->file_type;
            $user->category_image = $request['file'];
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
                $image->move(public_path('storage/prayers/category'),$new_name);
                $new_name_2 = 'storage/prayers/category/'.$new_name;
            }
            $uploaded_file = $new_name_2 ?? '';        
            $user->category_image = $uploaded_file;
        }
        else if($request->file_type == 2)
        {
            $user->category_image = $request->url_image;
            $user->image_type = $request->file_type;
        }
        $user->save();
        $uesr_id_file_import = $user->id;
        if($request->filecheck == 1)
        {
            if($uesr_id_file_import)
            {
                $file = $request->file('csvfile');
                
                $filename = $file->getClientOriginalName();
                $new_filename = time().'.'.$filename;
                $extension = $file->getClientOriginalExtension();
                $tempPath = $file->getRealPath();
                $fileSize = $file->getSize();
                $mimeType = $file->getMimeType();
                $valid_extension = array("csv");
            
                $maxFileSize = 4194304; 
                if(in_array(strtolower($extension),$valid_extension))
                {   
                    if($fileSize <= $maxFileSize)
                    {
                        $location = 'uploads';
                        
                        $file->move($location,$new_filename);
                
                        $filepath = public_path($location."/".$new_filename);
                        
                        $user = QuizCategorySet3::find($uesr_id_file_import);
                        $user->file_name = 'uploads/'.$new_filename;
                        $user->file_type = $request->filecheck;
                        $user->save();
                        $file = fopen($filepath,"r");
                        
                        $importData_arr = array();
                        $i = 0;
                        
                        while (($filedata = fgetcsv($file, 1000, ",")) !== FALSE) 
                        {
                            $num = count($filedata);
                            for ($c=0; $c < $num; $c++) 
                            {
                                $importData_arr[$i][] = $filedata[$c];
                            }
                            $i++;
                        }      
                        fclose($file);
                        $skip = 0;
                        foreach($importData_arr as $key =>$importData)
                        {
                            $insertData = array(
                                "letters" => $importData[0],
                                "category_id" => $uesr_id_file_import,
                            );  
                            LetterCount::create($insertData);
                        }
                        return back()->with('message','Import Successfully!.....');
                    }
                    else
                    {
                        return back()->with('error','File too large. File must be less than 4MB.');
                    }
                }
                else
                {
                    return back()->with('error','Invalid File Extension.');
                }
            }
        }
        else
        {
            LogActivity::addToLog();
            return back()->with('message','Category Created Successfully');
        }
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
        $array = in_array('category',$explode);
        $array_1= in_array('edit',$explode_1);
        if(($role == "SuperAdmin") || ($array == true && $array_1 == true && $list_array == true))
        {
            $cat_id = $request->cat_id;
            $status = $request->status;
            if($status == 0)
            {
                $app_active = QuizCategorySet3::find($cat_id);
                $app_active->is_active ='1';
                $app_active->save();
                return back()->with('message','Category Disabled Successfully');
            }
            if($status == 1)
            {
                $app_active = QuizCategorySet3::find($cat_id);
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
        $list_array = in_array('set_3',$lists);
        $array = in_array('category',$explode);
        $array_1= in_array('delete',$explode_1);
        if(($role == "SuperAdmin") || ($array == true && $array_1 == true && $list_array == true))
        {
            $Q1 = QuizCategorySet3::find($id);
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
        $list_array = in_array('set_3',$lists);
        $array = in_array('category',$explode);
        $array_1= in_array('edit',$explode_1);
        if(($role == "SuperAdmin") || ($array == true && $array_1 == true && $list_array == true))
        {
            $edit = QuizCategorySet3::find($id);
            $array = array($edit);
            return view('admin.set3.category.edit_Category_list', ['edit_category_id'=> $array]);
        }
        else
        {
            return redirect()->route('category.list')->with("error","Permission Denied");
        }
       
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
            $edit = QuizCategorySet3::find($id);
            $category = QuizSubCategorySet3::where('deleted_at','0')->get();
            $mapped_res = QuizSet3CategoryMappedApp::select(['sub_category_id'])->where('category_id',$id)->get();
            $mapped_app=[];
            foreach($mapped_res as $row)
            {
                $mapped_app[] = $row->sub_category_id;
            }
            return view('admin.set3.category.mapped_app_category', ['edit'=> $edit,'category_list'=>$category,'mapped_app'=>$mapped_app]);
        }
        else
        {
            return redirect()->route('admin/dashboard')->with("error","Permission Denied");
        }

    }
    

    public function EditCatList(Request $request, $id)
    {
        $request->validate([
            'editcatname' => 'required|string|max:255',
            'editcatdescription' => 'required',
            
        ]);

        $user = QuizCategorySet3::find($id);
        $user->category_name = $request->input('editcatname');
        $user->category_description = $request->input('editcatdescription');
        $user->category_image = $request['file']; 
        if($request->file_type == 1)
        {
            $user->image_type = $request->file_type;
            $user->category_image = $request['file'];
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
                $image->move(public_path('storage/prayers/category'),$new_name);
                $new_name_2 = 'storage/prayers/category/'.$new_name;
            
            }
            $uploaded_file = $new_name_2 ?? '';        
            $user->category_image = $uploaded_file;
        }
        else if($request->file_type == 2)
        {
            $user->category_image = $request->url_image;
            $user->image_type = $request->file_type;
        }
        $user->save();
    }
}
