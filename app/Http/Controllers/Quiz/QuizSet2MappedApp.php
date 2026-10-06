<?php

namespace App\Http\Controllers\Quiz;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;
use App\Helpers\LogActivity;
use App\Models\App\QuizAppSet2;
use App\Models\Category\QuizCategorySet2;
use App\Models\MappedApp\QuizSet2MappedAppCategory;


class QuizSet2MappedApp extends Controller
{
    
    public function insert(Request $request, $id)
    {
        $app_id = $id; 
        $res = QuizSet2MappedAppCategory::where('app_id',$app_id)->delete();
        $count = $request->input('countries');
        $countlist = $count ?? '';
        if (is_array($countlist) || is_object($countlist))
        {
            foreach($count as $count)
            {
                        
                LogActivity::addToLog();
                QuizSet2MappedAppCategory::create([
                    'app_id' => $id,
                    'category_id' =>$count
                ]);
            }
        }
        return back()->with('message','Category Mapped Successfully');
    }
}
