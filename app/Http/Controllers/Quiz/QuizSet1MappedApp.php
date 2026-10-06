<?php

namespace App\Http\Controllers\Quiz;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;
use App\Helpers\LogActivity;
use App\Models\App\QuizAppSet1;
use App\Models\Category\QuizCategorySet1;
use App\Models\MappedApp\QuizSet1MappedAppCategory;


class QuizSet1MappedApp extends Controller
{
    
    public function insert(Request $request, $id)
    {
        $app_id = $id; 
        $res = QuizSet1MappedAppCategory::where('app_id',$app_id)->delete();
        $count = $request->input('countries');
        $countlist = $count ?? '';
        if (is_array($countlist) || is_object($countlist))
        {
            foreach($count as $count)
            {
                        
                LogActivity::addToLog();
                QuizSet1MappedAppCategory::create([
                    'app_id' => $id,
                    'category_id' =>$count
                ]);
            }
        }
        return back()->with('message','Category Mapped Successfully');
    }
}
