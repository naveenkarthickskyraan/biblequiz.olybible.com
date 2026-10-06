<?php

namespace App\Http\Controllers\Quiz;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\SubCategory\QuizSubCategorySet2;
use Auth;
Use App\Models\App\ImageAppList;
use App\Models\Module;
Use App\Models\Admin;
use Illuminate\Support\Facades\Validator;
Use App\Models\Category\QuizCategorySet2;
use App\Models\MappedApp\QuizSet2MappedAppCategory;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Helpers\LogActivity;
use DataTables;
use Illuminate\Support\Facades\Response;

use App\Imports\QuizSet2SubCategoryImport;
use App\Exports\QuizSubCategorySet2Export;

use Maatwebsite\Excel\Facades\Excel;

class QuizSet2SubCategoryController extends Controller
{
    function show(Request $request)
    {
        $role = Auth::guard('admin')->user()->role;
        $AccessPrivilege = Auth::guard('admin')->user()->accountAccessPrivilege;
        $AccessModule = Auth::guard('admin')->user()->accountAccessModule;
        $explode = explode('|',$AccessModule);
        $explode_1 = explode('|',$AccessPrivilege);
        $lists = explode('|',Auth::guard('admin')->user()->access_list);
        $list_array = in_array('set_2',$lists);
        $array = in_array('sub_category',$explode);
        $array_1= in_array('view',$explode_1);
        if(($role == "SuperAdmin") || ($array == true && $array_1 == true && $list_array == true))
        {
            
            $quizzes = QuizSubCategorySet2::query()->where('deleted_at',0)->get();

            if($request->ajax())
            {
                return DataTables::of($quizzes)
                    ->addColumn('checkbox', function ($quiz) {
                        return '<td>
                                    <div class="d-flex">
                                        <div class="userDatatable__imgWrapper d-flex align-items-center">
                                            <div class="checkbox-group-wrapper">
                                                <div class="checkbox-group d-flex">
                                                    <div class="checkbox-theme-default custom-checkbox checkbox-group__single d-flex">
                                                        <input class="checkbox" type="checkbox" id="check-grp-'.$quiz->id.'">
                                                        <label for="check-grp-'.$quiz->id.'"></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>';
                    })
                    ->addColumn('id', function ($quiz) {
                        return $quiz->id;
                    })
                    ->addColumn('sub_category_name', function ($quiz) {
                        return '<td>
                                    <div class="app userDatatable-inline-title" style="max-width: 100px;text-overflow:hidden;text-overflow: ellipsis;white-space: nowrap;overflow: hidden;">
                                        <h6>'.$quiz->sub_category_name.'</h6>
                                    </div>
                                </td>';
                    })
                    ->addColumn('sub_category_description', function ($quiz) {
                        return '<td>
                                    <div class="app userDatatable-inline-title" style="max-width: 100px;text-overflow:hidden;text-overflow: ellipsis;white-space: nowrap;overflow: hidden;">
                                        <h6>'.$quiz->sub_category_description.'</h6>
                                    </div>
                                </td>';
                    })
                    ->addColumn('sub_category_image', function ($quiz) {
                        $image = 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQdoCQ7-yS62tALBS9_FY5pExwg8Lvvsie6Iml51YO_JQ&s';
                        
                        if ($quiz->sub_category_image != null) {
                            if ($quiz->image_type == 1) {
                                $image = asset($quiz->sub_category_image);
                            } else {
                                $image = $quiz->sub_category_image;
                            }
                        }
                        
                        return '<td>
                                    <div class="userDatatable-content">
                                        <center><img src="'.$image.'" style="height:50px; width:auto;border-radius:70%;"></center>
                                    </div>
                                </td>';
                    })
                    ->addColumn('category_name', function ($quiz) {
                        if($quiz->category != null){
                            return '<td>
                                        <div class="userDatatable-content">
                                            '.$quiz->category->category_description ?? 'nil'.'
                                        </div>
                                    </td>';
                        }else{
                                
                            return '<td>
                                        <div class="userDatatable-content">
                                            nil
                                        </div>
                                    </td>';
                        }
                    })
                    ->addColumn('created_at', function ($quiz) {
                        return '<td>
                                    <div class="userDatatable-content">
                                        '.date('d-m-Y', strtotime($quiz->created_at)).'
                                    </div>
                                </td>';
                    })
                    ->addColumn('status', function ($quiz) {
                        if ($quiz->is_active == '0') {
                            return '<td>
                                        <div class="userDatatable-content d-inline-block">
                                            <span class="bg-opacity-success color-success rounded-pill userDatatable-content-status active">active</span>
                                        </div>
                                    </td>';
                        } else {
                            return '<td>
                                        <div class="userDatatable-content d-inline-block">
                                            <span class="bg-opacity-warning color-warning rounded-pill userDatatable-content-status active">deactivete</span>
                                        </div>
                                    </td>';
                        }
                    })
                    ->addColumn('action', function ($quiz) {
                        $editUrl = url("Quiz/edit_sub_category/".$quiz->id);
                        $deleteUrl = url("Quiz/delete_sub_category/".$quiz->id);

                        return '<td>
                                    <div class="button-group">
                                        <form action="'.$editUrl.'" method="POST">
                                            '.csrf_field().'
                                            <button type="submit" name="submit" class="btn btn-icon btn-circle text-primary" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Edit Quiz"><i class="fa fa-edit"></i></button>
                                        </form>
                                                
                                        <form action="'.$deleteUrl.'" method="POST" style="right:0">
                                            '.csrf_field().'
                                            <button  type="submit" class="btn btn-icon btn-circle text-danger" onclick="return confirm(\'Are you sure you want to delete this item?\');" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete Quiz"><i class="fa fa-trash"></i></button>
                                        </form>
                                    </div>
                                </td>';
                    })
                    ->addColumn('status_update', function ($quiz) {
                        $statusForm = '<form action="'.url('Quiz/sub_category_status_update').'" method="POST">'
                            . csrf_field()
                            . '<input type="hidden" name="sub_cat_id" value="'.$quiz->id.'">';

                        if ($quiz->is_active == '0') {
                            $statusForm .= '<input type="hidden" name="status" value="0">'
                                . '<button type="submit" data-toggle="tooltip" data-original-title="Enable" id="enable" name="enable" title="" class="btn_status btn-success enable">'
                                . '<i class="mdi mdi-check"></i>Enabled'
                                . '</button>';
                        } else {
                            $statusForm .= '<input type="hidden" name="status" value="1">'
                                . '<button type="submit" data-toggle="tooltip" data-original-title="Disable" id="disable" title="" name="disable" class="btn_status btn-success" style="background: #ffad46!important;border-color: #ffad46!important;color: #fff!important;">'
                                . '<i class="mdi mdi-discord"></i>Disabled'
                                . '</button>';
                        }

                        $statusForm .= '</form>';

                        return '<td>'.$statusForm.'</td>';
                    })
                    ->rawColumns(['checkbox', 'sub_category_name', 'sub_category_description', 'sub_category_image', 'category_name', 'created_at', 'status', 'action', 'status_update'])
                    ->make(true);
            }

            $sub_category = QuizSubCategorySet2::orderBy('id','asc')->where('deleted_at','0')->get();
            return view('admin.set2.subcategory.sub_category_list', ['sub_categorys' => $sub_category]);
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
        $list_array = in_array('set_2',$lists);
        $array = in_array('sub_category',$explode);
        $array_1= in_array('add',$explode_1);
        if(($role == "SuperAdmin") || ($array == true && $array_1 == true && $list_array == true))
        {
            $category = QuizCategorySet2::orderBy('id','asc')->where('deleted_at','0')->get();
            return view('admin.set2.subcategory.add_sub_category', ['category' => $category]);
        }
        else
        {
            return redirect()->route('admin/dashboard')->with("error","Permission Denied");
        }
    }

    public function store(Request $request)
    {
        
        $request->validate([
            'select-alerts2'=>"required",
            'SubCategoryName' => 'required|string|max:255',
            'SubCategoryDescription' => 'required',
        ],
        [
            'select-alerts2.required' => 'You have to choose atleast one Category!'
        ]);   
        $user = new QuizSubCategorySet2;
        $user->category_id = $request['select-alerts2']; 
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

    public function subCat(Request $request)
    {
        $parent_id = $request->cat_id;
        $subcategories = QuizSubCategorySet2::where('category_id', $parent_id)->where('deleted_at','0')->get();
        return response()->json(['subcategories' => $subcategories]);
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
        $list_array = in_array('set_2',$lists);
        $array = in_array('sub_category',$explode);
        $array_1= in_array('edit',$explode_1);
        if(($role == "SuperAdmin") || ($array == true && $array_1 == true && $list_array == true))
        {
            $sub_cat_id = $request->sub_cat_id;
            $status = $request->status;
            if($status == 0)
            {
                $app_active = QuizSubCategorySet2::find($sub_cat_id);
                $app_active->is_active ='1';
                $app_active->save();
                return back()->with('message','Sub-Category Disabled Successfully');
            }
            if($status == 1)
            {
                $app_active = QuizSubCategorySet2::find($sub_cat_id);
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
        $list_array = in_array('set_2',$lists);
        $array = in_array('sub_category',$explode);
        $array_1= in_array('delete',$explode_1);
        if(($role == "SuperAdmin") || ($array == true && $array_1 == true && $list_array == true))
        {
            $Q1 = QuizSubCategorySet2::find($id);
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
        $list_array = in_array('set_2',$lists);
        $array = in_array('sub_category',$explode);
        $array_1= in_array('edit',$explode_1);
        if(($role == "SuperAdmin") || ($array == true && $array_1 == true && $list_array == true))
        {
            $edit = QuizSubCategorySet2::find($id);
            $category = QuizCategorySet2::where('deleted_at','0')->get();
            $array = array($edit);
            return view('admin.set2.subcategory.edit_sub_Category_list', ['edit_sub_category_id'=> $array],['category_id'=>$category]);
        }
        else
        {
            return redirect()->route('admin/dashboard')->with("error","Permission Denied");
        }
    }

    public function EditSubCatList(Request $request, $id)
    {
        
        $request->validate([
            'select-alerts2'=>"required",
            'SubCategoryName' => 'required|string|max:255',
            'SubCategoryDescription' => 'required',
        ]);   
        $user = QuizSubCategorySet2::find($id);
        $user->category_id = $request['select-alerts2']; 
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

    public function export_subcategory(Request $request){
        // $products = QuizSubCategorySet2::all();
        // $csvFileName = 'QuizSubCategorySet2.csv';
        // $headers = [
        //     'Content-Type' => 'text/csv',
        //     'Content-Disposition' => 'attachment; filename="' . $csvFileName . '"',
        //     'Content-Language' => 'ta', // Set to Tamil (ta)
        // ];

        // $handle = fopen('php://output', 'w');
        // fputcsv($handle, ['sub_category_name', 'category_id','related_name']); // Add more headers as needed

        // foreach ($products as $product) {
        //     fputcsv($handle, [$product->sub_category_name, $product->category_id,'']); // Add more fields as needed
        // }

        // fclose($handle);

        // return Response::make('', 200, $headers);

        $fileName = 'QuizSubCategorySet2.xlsx';

        return Excel::download(new QuizSubCategorySet2Export, $fileName);
    }

    public function import_subcategory(Request $request){
        $request->validate([
            'file'=>'required'   
        ]);

        $file = $request->file('file');
        try{
            Excel::import(new QuizSet2SubCategoryImport,$file);
        }catch(\Exception $e){
            return back()->with('error',$e->getMessage());
        }

        // Replace YourImport with the appropriate import class for your model
        return redirect()->back();
    }

}
