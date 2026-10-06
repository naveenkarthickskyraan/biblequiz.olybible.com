<?php

namespace App\Http\Controllers\Quiz;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;
use App\Helpers\LogActivity;
use App\Models\App\QuizAppSet3;
use App\Models\Category\QuizCategorySet3;
use App\Models\MappedApp\QuizSet3MappedAppCategory;
use App\Models\MappedApp\QuizSet3CategoryMappedApp;


class QuizSet3MappedApp extends Controller
{
    
    public function insert(Request $request, $id)
    {
        $app_id = $id; 
        $res = QuizSet3MappedAppCategory::where('app_id',$app_id)->delete();
        $count = $request->input('countries');
        $countlist = $count ?? '';
        if (is_array($countlist) || is_object($countlist))
        {
            foreach($count as $count)
            {
                        
                LogActivity::addToLog();
                QuizSet3MappedAppCategory::create([
                    'app_id' => $id,
                    'category_id' =>$count
                ]);
            }
        }
        return back()->with('message','Category Mapped Successfully');
    }

    public function categoryinsert(Request $request, $id)
    {
        $app_id = $id; 
        $res = QuizSet3CategoryMappedApp::where('category_id',$app_id)->delete();
        $count = $request->input('countries');
        $countlist = $count ?? '';
        if (is_array($countlist) || is_object($countlist))
        {
            foreach($count as $count)
            {
                        
                LogActivity::addToLog();
                QuizSet3CategoryMappedApp::create([
                    'category_id' => $id,
                    'sub_category_id' =>$count
                ]);
            }
        }
        return back()->with('message','Category Mapped Successfully');
    }
}
