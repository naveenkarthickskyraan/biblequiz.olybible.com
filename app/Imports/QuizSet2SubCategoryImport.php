<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use App\Models\SubCategory\QuizSubCategorySet2;

class QuizSet2SubCategoryImport implements ToModel, WithHeadingRow
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

        //validations rules
        
        $validator = Validator::make($request, [
            'sub_category_name' => 'required',
            'category_id' => 'required',
            'related_name'=> 'required',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            // Store the validation errors in the session

            Session::flash('import_errors', $errors->all());
            return;
        }

        $data = $validator->validated();
        $data['sub_category_description'] = "";
        $data['sub_category_image'] = "";
        $data['image_type'] = 1;
        $data['sub_category_name'] = $data['sub_category_name']." - ".$data['related_name'];
        // Output the trimmed data
        $trimmedData = array_map('trim', $data);
        unset($trimmedData['related_name']);
    
        QuizSubCategorySet2::Create($trimmedData);
    
        Session::flash('success_message', 'Question stored or updated successfully!');
    }
}
