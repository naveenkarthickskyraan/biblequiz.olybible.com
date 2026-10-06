<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\App;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use App\Models\Quiz\QuizSet1;
use App\Models\Quiz\QuizSet2;
use App\Models\Quiz\QuizSet3;
use App\Models\Quiz\QuizSet4;

class Set1Import implements ToModel, WithHeadingRow
{
    public function model(array $request)
    {
        
        $fileValidator = Validator::make(
            ['file' => request()->file('file')],
            ['file' => 'required|mimes:csv,xlsx,xls']
        );

        if ($fileValidator->fails()) {
            $errors = $fileValidator->errors();
            // Store the file validation errors in the session
            Session::flash('import_errors', $errors->all());

            return;
        }

        $validator = Validator::make($request, [
            'question_name' => 'required',
            'option_count' => 'required|integer',
            'option_1' => 'required_if:option_count,1',
            'option_2' => 'required_if:option_count,2',
            'option_3' => 'required_if:option_count,3',
            'option_4' => 'required_if:option_count,4',
            'option_5' => 'required_if:option_count,5',
            'option_6' => 'required_if:option_count,6',
            'quiz_answer'=> 'required',
            'quiz_answer_value' => 'required',
            'category_id' => 'required|exists:quiz_category_set1s,id',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            // Store the validation errors in the session
            Session::flash('import_errors', $errors->all());
            return;
        }

        $data = $validator->validated();
        $data['question_format_type'] = 1;
        $data['option_format_type'] = 0;

        $questionId = $request['id'];
    
        QuizSet1::updateOrCreate(['id' => $questionId], $data);
    
        Session::flash('success_message', 'Question stored or updated successfully!');
    }
}
