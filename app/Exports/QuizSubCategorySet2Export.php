<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\SubCategory\QuizSubCategorySet2;


class QuizSubCategorySet2Export implements FromCollection, WithHeadings
{
    public function collection()
    {
        return QuizSubCategorySet2::all(['sub_category_name', 'category_id']);
    }

    public function headings(): array
    {
        return ['sub_category_name', 'category_id','related_name'];
    }
}
