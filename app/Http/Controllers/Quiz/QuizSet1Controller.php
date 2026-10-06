<?php

namespace App\Http\Controllers\Quiz;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use Auth;
use App\Models\App\QuizAppSet1;
use App\Models\Quiz\QuizSet1;
use App\Models\Quiz\QuizSet2;
use App\Models\SubCategory\QuizSubCategorySet2;
use App\Models\Module;
Use App\Models\Admin;
use Illuminate\Support\Facades\Validator;
use App\Models\Category\QuizCategorySet1;
use App\Models\SubCategory;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Helpers\LogActivity;
use App\Models\MappedApp\QuizSet1MappedAppCategory;
use DataTables;
use Goutte\Client;

class QuizSet1Controller extends Controller
{

    public function show(Request $request)
    {
        $role = Auth::guard('admin')->user()->role;
        $AccessPrivilege = Auth::guard('admin')->user()->accountAccessPrivilege;
        $AccessModule = Auth::guard('admin')->user()->accountAccessModule;
        $explode = explode('|',$AccessModule);
        $explode_1 = explode('|',$AccessPrivilege);
        $lists = explode('|',Auth::guard('admin')->user()->access_list);
        $list_array = in_array('set_1',$lists);
        $array_1= in_array('view',$explode_1);
        if(($role == "SuperAdmin") || ( $array_1 == true && $list_array == true))
        {
            $quizzes = QuizSet1::where('deleted_at',0)->get();

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
                    ->addColumn('question_id', function ($quiz) {
                        return $quiz->id;
                    })
                    ->addColumn('question_name', function ($quiz) {
                        return '<td>
                                    <div class="app userDatatable-inline-title" style="max-width: 100px;text-overflow:hidden;text-overflow: ellipsis;white-space: nowrap;overflow: hidden;">
                                        <h6>'.$quiz->question_name.'</h6>
                                    </div>
                                </td>';
                    })
                    ->addColumn('question_content', function ($quiz) {
                        if (($quiz->question_format_type == 3) || ($quiz->question_format_type == 4)) {
                            return '<td>
                                        <div class="app userDatatable-inline-title" style="max-width: 100px;text-overflow:hidden;text-overflow: ellipsis;white-space: nowrap;overflow: hidden;">
                                            <a href="#" class="text-dark fw-500">
                                                <h6><center><img src="'.asset($quiz->question_content).'"  style="height:50px; width:auto;border-radius:70%;"></center></h6>
                                            </a>
                                        </div>
                                    </td>';
                        } else {
                            return '<td>
                                        <div class="app userDatatable-inline-title">
                                            <a href="#" class="text-dark fw-500">
                                                <center><h6>Nil</h6></center>
                                            </a>
                                        </div>
                                    </td>';
                        }
                    })
                    ->addColumn('quiz_image', function ($quiz) {
                        $image = 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQdoCQ7-yS62tALBS9_FY5pExwg8Lvvsie6Iml51YO_JQ&s';

                        if ($quiz->quiz_image != null) {
                            if ($quiz->image_type == 1) {
                                $image = asset($quiz->quiz_image);
                            } else {
                                $image = $quiz->quiz_image;
                            }
                        }

                        return '<td>
                                    <div class="userDatatable-content">
                                        <center><img src="'.$image.'" style="height:50px; width:auto;border-radius:70%;"></center>
                                    </div>
                                </td>';
                    })
                    ->addColumn('category_name', function ($quiz) {
                        return '<td>
                                    <div class="userDatatable-content">
                                        '.$quiz->category->category_name ?? 'nil'.'
                                    </div>
                                </td>';
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
                        $editUrl = url("admin/edit_Quiz/".$quiz->id);
                        $deleteUrl = url("admin/delete_Quiz/".$quiz->id);

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
                        $statusForm = '<form action="'.url('admin/Quiz_status_update').'" method="POST">'
                            . csrf_field()
                            . '<input type="hidden" name="Quiz_id" value="'.$quiz->id.'">';

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
                    ->rawColumns(['checkbox', 'question_name', 'question_content', 'quiz_image', 'category_name', 'created_at', 'status', 'action', 'status_update'])
                    ->toJson();
            }

            return view('admin.set1.events.event_list');
        }
        else
        {
            return redirect()->route('admin/dashboard')->with("error","Permission Denied");
        }
    }

    function add()
    {

        // $url = 'https://tamil.telugubiblequiz.online/2023/03/tamil-bible-quiz-new-testament.html';

        // $client = new Client();
        // $crawler = $client->request('GET', $url);

        // $content = $crawler->filter('.K2-grid > ul li a')->each(function ($node) {
        //     $link = $node->attr('href');

        //     return [
        //         'link' => $link,
        //     ];
        // });

        // $content_1 = $crawler->filter('.K2-grid > ul li span')->each(function ($node) {
        //     $link = $node->text();
        //     return $link;
        // });

        // foreach($content as $key => $row)
        // {
        //     if($key == 3){
        //         $category = new QuizSubCategorySet2();
        //         $category->sub_category_name = $content_1[$key];
        //         $category->sub_category_description = "";
        //         $category->sub_category_image = "";
        //         $category->image_type = 1;
        //         $category->category_id = 1;
        //         $category->save();
        //         $id = $category->id;
        //         $url =  $row['link'];

        //         $client_1 = new Client();
        //         $crawler_1 = $client_1->request('GET', $url);

        //         $content_2 = $crawler_1->filter('.post-body a')->each(function ($node) {
        //             $link_1 = $node->attr('href');
        //             // $text_1 = $node->filter('a button')->text();
        //             $buttonNode = $node->filter('a button');
        //             if (!$buttonNode->count()) {
        //                 $text_1 =  null;
        //             }else{
        //                 $text_1 = $buttonNode->text();
        //             }

        //             return [
        //                 'link' => $link_1,
        //                 'text' => $text_1,
        //             ];
        //         });
        //         if($content_2[0]['text'] == null)
        //         {
        //             $content_3 = $crawler_1->filter('.single-question-container')->each(function ($node) use ($id) {
        //                 $link_2 = $node->filter('div > .questionName')->text();

        //                 $text_2 = $node->filter('div .label-div')->each(function ($childran) {
        //                     return $childran->text();
        //                 });

        //                 $trimmedData = array_map('trim', $text_2);

        //                 $answer = $node->filter('.correct')->each(function ($correct) {
        //                     return $correct->text();
        //                 });

        //                 $count = count($trimmedData);
        //                 $QuizSet2 = new QuizSet2();

        //                 $input = $link_2;
        //                 $output = preg_replace('/^\d+[➤]\s+/u', '', $input);
        //                 $QuizSet2->question_name = $output;

        //                 $QuizSet2->question_content = null;
        //                 $QuizSet2->question_format_type = 1;
        //                 $QuizSet2->option_format_type = 0;

        //                 $options = [
        //                     'option_1',
        //                     'option_2',
        //                     'option_3',
        //                     'option_4',
        //                     'option_5',
        //                     'option_6'
        //                 ];

        //                 $option_label = [];
        //                 for ($i = 0; $i < count($options); $i++) {
        //                     if ($count > $i) {
        //                         $explode = explode(" ",$trimmedData[$i]);
        //                         unset($explode[0]);
        //                         $QuizSet2->{$options[$i]} = implode(' ',$explode);
        //                         $option_label[$i + 1] = implode(' ',$explode);
        //                     } else {
        //                         $QuizSet2->{$options[$i]} = "";
        //                     }
        //                 }

        //                 $QuizSet2->category_id = 1;

        //                 $explode_1 = explode(" ",$answer[0]);
        //                 unset($explode_1[0]);

        //                 $answers_original = implode(' ',$explode_1);
        //                 $answers_original_key = array_search($answers_original, $option_label);
        //                 $QuizSet2->quiz_answer_value = implode(' ',$explode_1);
        //                 $QuizSet2->quiz_answer = $answers_original_key;

        //                 $QuizSet2->sub_category_id = $id;
        //                 $QuizSet2->option_count = $count;
        //                 $QuizSet2->save();
        //             });

        //             if(count($content_3) == 0 || $content_3[0] == "null")
        //             {
        //                 $content_3 = $crawler_1->filter('fieldset')->each(function ($node) use ($id) {
        //                     $link_2 = $node->filter('h3')->text();

        //                     $text_2 = $node->filter('label')->each(function ($childran) {
        //                         return $childran->text();
        //                     });

        //                     $answer = $node->filter('.Acorrect')->each(function ($correct) {
        //                         return $correct->text();
        //                     });

        //                     $trimmedData = array_map('trim', $text_2);

        //                     $count = count($trimmedData);
        //                     $QuizSet2 = new QuizSet2();

        //                     $input = $link_2;
        //                     $output = preg_replace('/^\d+[➤]\s+/u', '', $input);
        //                     $QuizSet2->question_name = $output;

        //                     $QuizSet2->question_content = null;
        //                     $QuizSet2->question_format_type = 1;
        //                     $QuizSet2->option_format_type = 0;

        //                     $options = [
        //                         'option_1',
        //                         'option_2',
        //                         'option_3',
        //                         'option_4',
        //                         'option_5',
        //                         'option_6'
        //                     ];

        //                     $option_label = [];
        //                     for ($i = 0; $i < count($options); $i++) {
        //                         if ($count > $i) {
        //                             $explode = explode(" ",$trimmedData[$i]);
        //                             unset($explode[0]);
        //                             $QuizSet2->{$options[$i]} = implode(' ',$explode);
        //                             $option_label[$i + 1] = implode(' ',$explode);
        //                         } else {
        //                             $QuizSet2->{$options[$i]} = "";
        //                         }
        //                     }

        //                     $QuizSet2->category_id = 1;

        //                     $explode_1 = explode(" ",$answer[0]);
        //                     unset($explode_1[0]);

        //                     $answers_original = implode(' ',$explode_1);
        //                     $answers_original_key = array_search($answers_original, $option_label);
        //                     $QuizSet2->quiz_answer_value = implode(' ',$explode_1);
        //                     $QuizSet2->quiz_answer = $answers_original_key;

        //                     $QuizSet2->sub_category_id = $id;
        //                     $QuizSet2->option_count = $count;
        //                     $QuizSet2->save();
        //                 });
        //             }
        //         }

        //         else{
        //             foreach($content_2 as $key_1 => $row_1)
        //             {
        //                 if($key_1 == 0)
        //                 {
        //                     $url =  $row_1['link'];
        //                     $client_2 = new Client();
        //                     $crawler_2 = $client_2->request('GET', $url);

        //                     $content_3 = $crawler_2->filter('.quiz-form  .quiz-form__quiz')->each(function ($node) use ($id) {
        //                         if($node->filter('.quiz-form__question')->count() > 0)
        //                         {
        //                             $link_2 = $node->filter('.quiz-form__question')->text();

        //                             $text_2 = $node->filter('label')->each(function ($childran) {
        //                                 return $childran->text();
        //                             });

        //                             $answer = $node->filter('.quiz-form__ans .wrong')->each(function ($correct) {
        //                                 return $correct->text();
        //                             });
        //                             dd($answer);

        //                             $trimmedData = array_map('trim', $text_2);

        //                             $count = count($trimmedData);
        //                             $QuizSet2 = new QuizSet2();

        //                             $input = $link_2;
        //                             $output = preg_replace('/^\d+[➤]\s+/u', '', $input);
        //                             $QuizSet2->question_name = $output;

        //                             $QuizSet2->question_content = null;
        //                             $QuizSet2->question_format_type = 1;
        //                             $QuizSet2->option_format_type = 0;

        //                             $options = [
        //                                 'option_1',
        //                                 'option_2',
        //                                 'option_3',
        //                                 'option_4',
        //                                 'option_5',
        //                                 'option_6'
        //                             ];

        //                             $option_label = [];
        //                             for ($i = 0; $i < count($options); $i++) {
        //                                 if ($count > $i) {
        //                                     $explode = explode(" ",$trimmedData[$i]);
        //                                     unset($explode[0]);
        //                                     $QuizSet2->{$options[$i]} = implode(' ',$explode);
        //                                     $option_label[$i + 1] = implode(' ',$explode);
        //                                 } else {
        //                                     $QuizSet2->{$options[$i]} = "";
        //                                 }
        //                             }

        //                             $QuizSet2->category_id = 1;

        //                             if(!empty($answer) )
        //                             {
        //                                 $explode_1 = explode(" ",$answer[0]);
        //                                 unset($explode_1[0]);
        //                                 $answers_original = implode(' ',$explode_1);
        //                                 $answers_original_key = array_search($answers_original, $option_label);
        //                                 $QuizSet2->quiz_answer_value = implode(' ',$explode_1);
        //                                 $QuizSet2->quiz_answer = $answers_original_key;
        //                                 $QuizSet2->sub_category_id = $id;
        //                                 $QuizSet2->option_count = $count;
        //                                 $QuizSet2->save();
        //                             }
        //                         }else{
        //                             return "null";
        //                         }
        //                     });
        //                     if(count($content_3) == 0 || $content_3[0] == "null")
        //                     {
        //                         $content_3 = $crawler_2->filter('fieldset')->each(function ($node) use ($id) {
        //                             $link_2 = $node->filter('h3')->text();

        //                             $text_2 = $node->filter('label')->each(function ($childran) {
        //                                 return $childran->text();
        //                             });

        //                             $answer = $node->filter('.Acorrect')->each(function ($correct) {
        //                                 return $correct->text();
        //                             });

        //                             $trimmedData = array_map('trim', $text_2);

        //                             $count = count($trimmedData);
        //                             $QuizSet2 = new QuizSet2();

        //                             $input = $link_2;
        //                             $output = preg_replace('/^\d+[➤]\s+/u', '', $input);
        //                             $QuizSet2->question_name = $output;

        //                             $QuizSet2->question_content = null;
        //                             $QuizSet2->question_format_type = 1;
        //                             $QuizSet2->option_format_type = 0;

        //                             $options = [
        //                                 'option_1',
        //                                 'option_2',
        //                                 'option_3',
        //                                 'option_4',
        //                                 'option_5',
        //                                 'option_6'
        //                             ];

        //                             $option_label = [];
        //                             for ($i = 0; $i < count($options); $i++) {
        //                                 if ($count > $i) {
        //                                     $explode = explode(" ",$trimmedData[$i]);
        //                                     unset($explode[0]);
        //                                     $QuizSet2->{$options[$i]} = implode(' ',$explode);
        //                                     $option_label[$i + 1] = implode(' ',$explode);
        //                                 } else {
        //                                     $QuizSet2->{$options[$i]} = "";
        //                                 }
        //                             }

        //                             $QuizSet2->category_id = 1;

        //                             $explode_1 = explode(" ",$answer[0]);
        //                             unset($explode_1[0]);

        //                             $answers_original = implode(' ',$explode_1);
        //                             $answers_original_key = array_search($answers_original, $option_label);
        //                             $QuizSet2->quiz_answer_value = implode(' ',$explode_1);
        //                             $QuizSet2->quiz_answer = $answers_original_key;

        //                             $QuizSet2->sub_category_id = $id;
        //                             $QuizSet2->option_count = $count;
        //                             $QuizSet2->save();
        //                         });
        //                     }

        //                 }
        //             }
        //         }
        //     }
        // }
        // dd('added successfully');
        // //
        // $url = 'https://tamil.telugubiblequiz.online/2023/03/tamil-bible-quiz-new-testament.html';

        // $client = new Client();
        // $crawler = $client->request('GET', $url);

        // $content = $crawler->filter('.K2-grid > ul li a')->each(function ($node) {
        //     $link = $node->attr('href');

        //     return [
        //         'link' => $link,
        //     ];
        // });

        // $content_1 = $crawler->filter('.K2-grid > ul li span')->each(function ($node) {
        //     $link = $node->text();
        //     return $link;
        // });

        // foreach($content as $key => $row)
        // {
        //     if($key == 0)
        //     {
        //         $url =  $row['link'];
        //         $client_1 = new Client();
        //         $crawler_1 = $client_1->request('GET', $url);

        //         $content_2 = $crawler_1->filter('.post-body a')->each(function ($node) {
        //             $link_1 = $node->attr('href');
        //             // $text_1 = $node->filter('a button')->text();
        //             $buttonNode = $node->filter('a button');
        //             if (!$buttonNode->count()) {
        //                 $text_1 =  null;
        //             }else{
        //                 $text_1 = $buttonNode->text();
        //             }

        //             return [
        //                 'link' => $link_1,
        //                 'text' => $text_1,
        //             ];
        //         });

        //         if($content_2[0]['text'] == null)
        //         {
        //             $content_3 = $crawler_1->filter('.single-question-container')->each(function ($node) {
        //                 $link_2 = $node->filter('div > .questionName')->text();
        //                 $text_2 = $node->filter('div .label-div')->each(function ($childran) {
        //                     return $childran->text();
        //                 });

        //                 $trimmedData = array_map('trim', $text_2);

        //                 $answer = $node->filter('.correct')->text();
        //                 return [
        //                     'link' => $link_2 ?? '',
        //                     'text' => $text_2 ?? '',
        //                     'correct_answers' => $answer ?? ''
        //                 ];
        //             });
        //         }

        //         else{
        //             foreach($content_2 as $key_1 => $row_1)
        //             {
        //                 if($key_1 == 0)
        //                 {
        //                     $url =  $row_1['link'];
        //                     $client_2 = new Client();
        //                     $crawler_2 = $client_2->request('GET', $url);

        //                     $content_3 = $crawler_2->filter('.quiz-form  .quiz-form__quiz')->each(function ($node) {
        //                         if($node->filter('.quiz-form__question')->count() > 0)
        //                         {
        //                             $link_2 = $node->filter('.quiz-form__question')->text();

        //                             $text_2 = $node->filter('label')->each(function ($childran) {
        //                                 return $childran->text();
        //                             });

        //                             $answer = $node->filter('.correct')->each(function ($childran) {
        //                                 return $childran->text();
        //                             });

        //                             return [
        //                                 'link' => $link_2,
        //                                 'text' => $text_2,
        //                                 'correct_answers' => $answer
        //                             ];
        //                         }else{
        //                             return "null";
        //                         }
        //                     });

        //                     if($content_3[0] == "null")
        //                     {
        //                         $content_3 = $crawler_2->filter('fieldset')->each(function ($node) {
        //                             $link_2 = $node->filter('h3')->text();

        //                             $text_2 = $node->filter('label')->each(function ($childran) {
        //                                 return $childran->text();
        //                             });

        //                             $trimmedData = array_map('trim', $text_2);

        //                             $answer = $node->filter('.Acorrect')->text();

        //                             $count = count($trimmedData);
        //                             $category = new QuizSet1();
        //                             $category->question_name = $link_2;
        //                             $category->question_content = null;
        //                             $category->question_format_type = 1;
        //                             $category->option_format_type = 0;

        //                             $options = [
        //                                 'option_1',
        //                                 'option_2',
        //                                 'option_3',
        //                                 'option_4',
        //                                 'option_5',
        //                                 'option_6'
        //                             ];
        //                             $option_label = [];
        //                             for ($i = 0; $i < count($options); $i++) {
        //                                 if ($count > $i) {
        //                                     $explode = explode(" ",$trimmedData[$i]);
        //                                     unset($explode[0]);
        //                                     $category->{$options[$i]} = implode(' ',$explode);
        //                                     $option_label[$i + 1] = implode(' ',$explode);
        //                                 } else {
        //                                     $category->{$options[$i]} = "";
        //                                 }
        //                             }
        //                             $category->category_id = 2;

        //                             $explode_1 = explode(" ",$answer);
        //                             unset($explode_1[0]);
        //                             $answers_original = implode(' ',$explode_1);
        //                             $answers_original_key = array_search($answers_original, $option_label);
        //                             $category->quiz_answer_value = implode(' ',$explode_1);
        //                             $category->quiz_answer = $answers_original_key;

        //                             $category->sub_category_id = $category->id;
        //                             $category->option_count = $count;
        //                             $category->save();
        //                             return [
        //                                 'link' => $link_2,
        //                                 'text' => $text_2,
        //                                 'correct_answers' => $answer
        //                             ];
        //                         });
        //                     }
        //                 }
        //             }
        //         }
        //     }
        // }

        // $url = 'https://tamil.telugubiblequiz.online/2023/03/tamil-bible-quiz-new-testament.html';

        // $client = new Client();
        // $crawler = $client->request('GET', $url);

        // $content = $crawler->filter('.K2-grid > ul li a')->each(function ($node) {
        //     $link = $node->attr('href');

        //     return [
        //         'link' => $link,
        //     ];
        // });

        // $content_1 = $crawler->filter('.K2-grid > ul li span')->each(function ($node) {
        //     $link = $node->text();
        //     return $link;
        // });

        // foreach($content as $key => $row)
        // {
        //     if($key == 0)
        //     {
        //         $category = new QuizSubCategorySet2();
        //         $category->sub_category_name = $content_1[$key];
        //         $category->sub_category_description = "";
        //         $category->sub_category_image = "";
        //         $category->image_type = 1;
        //         $category->category_id = 2;
        //         $category->save();

        //         $url =  $row['link'];
        //         $client_1 = new Client();
        //         $crawler_1 = $client_1->request('GET', $url);

        //         $content_2 = $crawler_1->filter('.post-body a')->each(function ($node) {
        //             $link_1 = $node->attr('href');
        //             // $text_1 = $node->filter('a button')->text();
        //             $buttonNode = $node->filter('a button');
        //             if (!$buttonNode->count()) {
        //                 $text_1 =  null;
        //             }else{
        //                 $text_1 = $buttonNode->text();
        //             }

        //             return [
        //                 'link' => $link_1,
        //                 'text' => $text_1,
        //             ];
        //         });

        //         if($content_2[0]['text'] == null)
        //         {
        //             $content_3 = $crawler_1->filter('.single-question-container')->each(function ($node,$category) {
        //                 $link_2 = $node->filter('div > .questionName')->text();

        //                 $text_2 = $node->filter('div .label-div')->each(function ($childran) {
        //                     return $childran->text();
        //                 });

        //                 $trimmedData = array_map('trim', $text_2);

        //                 $answer = $node->filter('.correct')->each(function ($correct) {
        //                     return $correct->text();
        //                 });

        //                 $count = count($trimmedData);
        //                 $QuizSet2 = new QuizSet2();
        //                 $QuizSet2->question_name = $link_2;
        //                 $QuizSet2->question_content = null;
        //                 $QuizSet2->question_format_type = 1;
        //                 $QuizSet2->option_format_type = 0;

        //                 $options = [
        //                     'option_1',
        //                     'option_2',
        //                     'option_3',
        //                     'option_4',
        //                     'option_5',
        //                     'option_6'
        //                 ];

        //                 $option_label = [];
        //                 for ($i = 0; $i < count($options); $i++) {
        //                     if ($count > $i) {
        //                         $explode = explode(" ",$trimmedData[$i]);
        //                         unset($explode[0]);
        //                         $QuizSet2->{$options[$i]} = implode(' ',$explode);
        //                         $option_label[$i + 1] = implode(' ',$explode);
        //                     } else {
        //                         $QuizSet2->{$options[$i]} = "";
        //                     }
        //                 }

        //                 $QuizSet2->category_id = 2;

        //                 $explode_1 = explode(" ",$answer[0]);
        //                 unset($explode_1[0]);

        //                 $answers_original = implode(' ',$explode_1);
        //                 $answers_original_key = array_search($answers_original, $option_label);
        //                 $QuizSet2->quiz_answer_value = implode(' ',$explode_1);
        //                 $QuizSet2->quiz_answer = $answers_original_key;

        //                 $QuizSet2->sub_category_id = $category->id;
        //                 $QuizSet2->option_count = $count;
        //                 $QuizSet2->save();
        //             });
        //         }

        //         else{
        //             foreach($content_2 as $key_1 => $row_1)
        //             {
        //                 if($key_1 == 0)
        //                 {
        //                     $url =  $row_1['link'];
        //                     $client_2 = new Client();
        //                     $crawler_2 = $client_2->request('GET', $url);

        //                     $content_3 = $crawler_2->filter('.quiz-form  .quiz-form__quiz')->each(function ($node,$category) {
        //                         if($node->filter('.quiz-form__question')->count() > 0)
        //                         {
        //                             $link_2 = $node->filter('.quiz-form__question')->text();

        //                             $text_2 = $node->filter('label')->each(function ($childran) {
        //                                 return $childran->text();
        //                             });

        //                             $answer = $node->filter('.correct')->each(function ($correct) {
        //                                 return $correct->text();
        //                             });

        //                             $trimmedData = array_map('trim', $text_2);

        //                             $count = count($trimmedData);
        //                             $QuizSet2 = new QuizSet2();
        //                             $QuizSet2->question_name = $link_2;
        //                             $QuizSet2->question_content = null;
        //                             $QuizSet2->question_format_type = 1;
        //                             $QuizSet2->option_format_type = 0;

        //                             $options = [
        //                                 'option_1',
        //                                 'option_2',
        //                                 'option_3',
        //                                 'option_4',
        //                                 'option_5',
        //                                 'option_6'
        //                             ];

        //                             $option_label = [];
        //                             for ($i = 0; $i < count($options); $i++) {
        //                                 if ($count > $i) {
        //                                     $explode = explode(" ",$trimmedData[$i]);
        //                                     unset($explode[0]);
        //                                     $QuizSet2->{$options[$i]} = implode(' ',$explode);
        //                                     $option_label[$i + 1] = implode(' ',$explode);
        //                                 } else {
        //                                     $QuizSet2->{$options[$i]} = "";
        //                                 }
        //                             }

        //                             $QuizSet2->category_id = 2;

        //                             if(!empty($answer) )
        //                             {
        //                                 $explode_1 = explode(" ",$answer[0]);
        //                                 unset($explode_1[0]);
        //                                 $answers_original = implode(' ',$explode_1);
        //                                 $answers_original_key = array_search($answers_original, $option_label);
        //                                 $QuizSet2->quiz_answer_value = implode(' ',$explode_1);
        //                                 $QuizSet2->quiz_answer = $answers_original_key;
        //                                 $QuizSet2->sub_category_id = $category->id;
        //                                 $QuizSet2->option_count = $count;
        //                                 $QuizSet2->save();
        //                             }
        //                         }else{
        //                             return "null";
        //                         }
        //                     });

        //                     if(count($content_3) == 0 || $content_3[0] == "null")
        //                     {
        //                         $content_3 = $crawler_2->filter('fieldset')->each(function ($node,$category) {
        //                             $link_2 = $node->filter('h3')->text();

        //                             $text_2 = $node->filter('label')->each(function ($childran) {
        //                                 return $childran->text();
        //                             });

        //                             $answer = $node->filter('.Acorrect')->each(function ($correct) {
        //                                 return $correct->text();
        //                             });

        //                             $trimmedData = array_map('trim', $text_2);

        //                             $count = count($trimmedData);
        //                             $QuizSet2 = new QuizSet2();
        //                             $QuizSet2->question_name = $link_2;
        //                             $QuizSet2->question_content = null;
        //                             $QuizSet2->question_format_type = 1;
        //                             $QuizSet2->option_format_type = 0;

        //                             $options = [
        //                                 'option_1',
        //                                 'option_2',
        //                                 'option_3',
        //                                 'option_4',
        //                                 'option_5',
        //                                 'option_6'
        //                             ];

        //                             $option_label = [];
        //                             for ($i = 0; $i < count($options); $i++) {
        //                                 if ($count > $i) {
        //                                     $explode = explode(" ",$trimmedData[$i]);
        //                                     unset($explode[0]);
        //                                     $QuizSet2->{$options[$i]} = implode(' ',$explode);
        //                                     $option_label[$i + 1] = implode(' ',$explode);
        //                                 } else {
        //                                     $QuizSet2->{$options[$i]} = "";
        //                                 }
        //                             }

        //                             $QuizSet2->category_id = 2;

        //                             $explode_1 = explode(" ",$answer[0]);
        //                             unset($explode_1[0]);

        //                             $answers_original = implode(' ',$explode_1);
        //                             $answers_original_key = array_search($answers_original, $option_label);
        //                             $QuizSet2->quiz_answer_value = implode(' ',$explode_1);
        //                             $QuizSet2->quiz_answer = $answers_original_key;

        //                             $QuizSet2->sub_category_id = $category->id;
        //                             $QuizSet2->option_count = $count;
        //                             $QuizSet2->save();
        //                         });
        //                     }
        //                 }
        //             }
        //         }
        //     }
        // }


        // return response()->json(['content'=>$content,'content_1'=>$content_1,'content_2'=>$content_2,'content_3'=>$content_3]);

        $role = Auth::guard('admin')->user()->role;
        $AccessPrivilege = Auth::guard('admin')->user()->accountAccessPrivilege;
        $AccessModule = Auth::guard('admin')->user()->accountAccessModule;
        $explode = explode('|',$AccessModule);
        $explode_1 = explode('|',$AccessPrivilege);
        $lists = explode('|',Auth::guard('admin')->user()->access_list);
        $list_array = in_array('set_1',$lists);
        $array_1= in_array('add',$explode_1);
        if(($role == "SuperAdmin") || ( $array_1 == true && $list_array == true))
        {
            $category = QuizCategorySet1::where('deleted_at','0')->get();
            return view('admin.set1.events.add_event', ['category' => $category]);
        }
        else
        {
            return redirect()->route('admin.Events')->with("error","Permission Denied");
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
        $list_array = in_array('set_1',$lists);
        $array_1= in_array('edit',$explode_1);
        if(($role == "SuperAdmin") || ( $array_1 == true && $list_array == true))
        {
            $cat_id = $request->Quiz_id;
            $status = $request->status;
            if($status == 0)
            {
                $app_active = QuizSet1::find($cat_id);
                $app_active->is_active ='1';
                $app_active->save();
                return back()->with('message','Quiz Disabled Successfully');
            }
            if($status == 1)
            {
                $app_active = QuizSet1::find($cat_id);
                $app_active->is_active ='0';
                $app_active->save();
                return back()->with('message','Quiz Enabled Successfully');
            }
        }
        else
        {
            return redirect()->route('admin.Events')->with("error","Permission Denied");
        }
    }

    public function store(Request $request)
    {
        $rules=[
                'category_id' => 'required',
                'option_count' => 'required',
                'quiz_answer' => 'required',
            ];
        if($request->option_format_type == 0)
        {
            $rules['option_1'] = 'required_if:option_count,1,2,3,4,5,6';
            $rules['option_2'] = 'required_if:option_count,2,3,4,5,6';
            $rules['option_3'] = 'required_if:option_count,3,4,5,6';
            $rules['option_4'] = 'required_if:option_count,4,5,6';
            $rules['option_5'] = 'required_if:option_count,5,6';
            $rules['option_6'] = 'required_if:option_count,6';
        }

        if($request->option_format_type == 1)
        {
            $rules['option_1_html'] = 'required_if:option_count,1,2,3,4,5,6';
            $rules['option_2_html'] = 'required_if:option_count,2,3,4,5,6';
            $rules['option_3_html'] = 'required_if:option_count,3,4,5,6';
            $rules['option_4_html'] = 'required_if:option_count,4,5,6';
            $rules['option_5_html'] = 'required_if:option_count,5,6';
            $rules['option_6_html'] = 'required_if:option_count,6';
        }

        if($request->option_format_type == 2)
        {
            $rules['quiz_option1_file'] = 'required_if:option_count,1,2,3,4,5,6';
            $rules['quiz_option2_file'] = 'required_if:option_count,2,3,4,5,6';
            $rules['quiz_option3_file'] = 'required_if:option_count,3,4,5,6';
            $rules['quiz_option4_file'] = 'required_if:option_count,4,5,6';
            $rules['quiz_option5_file'] = 'required_if:option_count,5,6';
            $rules['quiz_option6_file'] = 'required_if:option_count,6';
        }

        if($request->option_format_type == 3)
        {
            $rules['jumpled_words'] = 'required';
            $rules['rearranging_words'] = 'required';
        }

        $request->validate($rules);
        $quiz = new QuizSet1;

        $quiz->category_id = $request->category_id;
        $quiz->question_format_type = $request->question_format_type;

        $quiz->option_format_type = $request->option_format_type;

        if($request->question_format_type == 1)
        {
            $rules['question_name'] = 'required';
            $quiz->question_name = $request->question_name;
        }

        if($request->question_format_type == 2)
        {
            $rules['question_name_html'] = 'required';
            $quiz->question_name = $request->question_name_html;
        }

        if($request->question_format_type == 3)
        {
            $rules['question_name'] = 'required';
            $rules['image_file'] = 'required';

            if($request->hasFile('image_file'))
            {
                $image = $request['image_file'];
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
                $image->move(public_path('storage/events/events_images'),$new_name);
                $new_name_3 = 'storage/events/events_images/'.$new_name;

                $uploaded_file_2 = $new_name_3 ?? '';
                $quiz->question_content = $uploaded_file_2;
                $quiz->question_name = $request->question_name_image;
            }
        }

        if($request->question_format_type == 4)
        {
            $rules['question_name'] = 'required';
            $rules['video_file'] = 'required';

            if($request->hasFile('video_file'))
            {
                $video = $request['video_file'];
                $image_name = $video->getClientOriginalName();
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
                $video->move(public_path('storage/events/events_video'),$new_name);
                $upload_video_3 = 'storage/events/events_video/'.$new_name;

                $uploaded_file1_4 = $upload_video_3 ?? '';
                $quiz->question_content = $uploaded_file1_4;
                $quiz->question_name = $request->question_name_video;
            }
        }

        if($request->option_format_type == 0){
            $quiz->option_1 = $request->option_1;
            $quiz->option_2 = $request->option_2;
            $quiz->option_3 = $request->option_3;
            $quiz->option_4 = $request->option_4;
            $quiz->option_5 = $request->option_5;
            $quiz->option_6 = $request->option_6;
        }

        if($request->option_format_type == 1){
            $quiz->option_1 = $request->option_1_html;
            $quiz->option_2 = $request->option_2_html;
            $quiz->option_3 = $request->option_3_html;
            $quiz->option_4 = $request->option_4_html;
            $quiz->option_5 = $request->option_5_html;
            $quiz->option_6 = $request->option_6_html;
        }

        if($request->option_format_type == 2){
            if ($request->hasFile('quiz_option1_file')) {
                $quiz->option_1 = $request->file('quiz_option1_file')->store('uploads', 'public');
            }
            if ($request->hasFile('quiz_option2_file')) {
                $quiz->option_2 = $request->file('quiz_option2_file')->store('uploads', 'public');
            }
            if ($request->hasFile('quiz_option3_file')) {
                $quiz->option_3 = $request->file('quiz_option3_file')->store('uploads', 'public');
            }
            if ($request->hasFile('quiz_option4_file')) {
                $quiz->option_4 = $request->file('quiz_option4_file')->store('uploads', 'public');
            }
            if ($request->hasFile('quiz_option5_file')) {
                $quiz->option_5 = $request->file('quiz_option5_file')->store('uploads', 'public');
            }
            if ($request->hasFile('quiz_option6_file')) {
                $quiz->option_6 = $request->file('quiz_option6_file')->store('uploads', 'public');
            }

        }

        if($request->option_format_type == 3){
            $quiz->jumpled_words = $request->jumpled_words ?? '' ;
            $quiz->rearranging_words = $request->rearranging_words ?? '' ;
        }

        $quiz->quiz_answer = $request->quiz_answer;
        if($request->quiz_answer == 1)
        {
            if(empty($quiz->quiz_answer_value = $request->option_1))
            {
                if(empty($quiz->quiz_answer_value = $request->option_1_html)){
                    $quiz->quiz_answer_value = $quiz->option_1;
                }
            }
        }
        if($request->quiz_answer == 2)
        {
            if(empty($quiz->quiz_answer_value = $request->option_2))
            {
                if(empty($quiz->quiz_answer_value = $request->option_2_html)){
                    $quiz->quiz_answer_value = $quiz->option_2;
                }
            }
        }

        if($request->quiz_answer == 3)
        {
            if(empty($quiz->quiz_answer_value = $request->option_3))
            {
                if(empty($quiz->quiz_answer_value = $request->option_3_html)){
                    $quiz->quiz_answer_value = $quiz->option_3;
                }
            }
        }

        if($request->quiz_answer == 4)
        {
            if(empty($quiz->quiz_answer_value = $request->option_4))
            {
                if(empty($quiz->quiz_answer_value = $request->option_4_html)){
                    $quiz->quiz_answer_value = $quiz->option_4;
                }
            }
        }

        if($request->quiz_answer == 5)
        {
            if(empty($quiz->quiz_answer_value = $request->option_5))
            {
                if(empty($quiz->quiz_answer_value = $request->option_5_html)){
                    $quiz->quiz_answer_value = $quiz->option_5;
                }
            }
        }

        if($request->quiz_answer == 6)
        {
            if(empty($quiz->quiz_answer_value = $request->option_6))
            {
                if(empty($quiz->quiz_answer_value = $request->option_6_html)){
                    $quiz->quiz_answer_value = $quiz->option_6;
                }
            }
        }
        $quiz->quiz_hint = $request->quiz_hint;
        $quiz->quiz_exp = $request->quiz_exp;
        $quiz->option_count = $request->option_count;

        if($request->file_type == 1)
        {
            $quiz->image_type = $request->file_type;
            $quiz->quiz_image = $request['file'];
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
                $image->move(public_path('storage/prayers/app'),$new_name);
                $new_name_2 = 'storage/prayers/app/'.$new_name;
            }
            $uploaded_file = $new_name_2 ?? '';
            $quiz->quiz_image = $uploaded_file;
        }
        else if($request->file_type == 2)
        {
            $quiz->quiz_image = $request->url_image;
            $quiz->image_type = $request->file_type;
        }

        $quiz->save();

        return back()->with('message','Quiz Added Successfully');

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
        $array_1= in_array('delete',$explode_1);
        if(($role == "SuperAdmin") || ( $array_1 == true && $list_array == true))
        {
            $Q1 = QuizSet1::find($id);
            $Q1->deleted_at = '1';
            $Q1->save();
            return back()->with('message','Delete Record Successfully');
        }
        else
        {
            return redirect()->route('admin.Events')->with("error","Permission Denied");
        }
    }
    public function EditQuestion($id)
    {
        $role = Auth::guard('admin')->user()->role;
        $AccessPrivilege = Auth::guard('admin')->user()->accountAccessPrivilege;
        $AccessModule = Auth::guard('admin')->user()->accountAccessModule;
        $explode = explode('|',$AccessModule);
        $explode_1 = explode('|',$AccessPrivilege);
        $lists = explode('|',Auth::guard('admin')->user()->access_list);
        $list_array = in_array('set_1',$lists);
        $array_1= in_array('edit',$explode_1);
        if(($role == "SuperAdmin") || ( $array_1 == true && $list_array == true))
        {
            $edit = QuizSet1::find($id);
            $category = QuizCategorySet1::where('deleted_at','0')->get();
            $array = array($edit);
            return view('admin.set1.events.edit_event_list', ['edit_question_id'=> $array],['category_id' => $category]);
        }
        else
        {
            return redirect()->route('admin.Events')->with("error","Permission Denied");
        }
    }

    public function EditQuestionList(Request $request, $id)
    {
        $rules=[
            'category_id' => 'required',
            'option_count' => 'required',
            'quiz_answer' => 'required',
        ];

        if($request->option_format_type == 0)
        {
            $rules['option_1'] = 'required_if:option_count,1,2,3,4,5,6';
            $rules['option_2'] = 'required_if:option_count,2,3,4,5,6';
            $rules['option_3'] = 'required_if:option_count,3,4,5,6';
            $rules['option_4'] = 'required_if:option_count,4,5,6';
            $rules['option_5'] = 'required_if:option_count,5,6';
            $rules['option_6'] = 'required_if:option_count,6';
        }

        if($request->option_format_type == 1)
        {
            $rules['option_1_html'] = 'required_if:option_count,1,2,3,4,5,6';
            $rules['option_2_html'] = 'required_if:option_count,2,3,4,5,6';
            $rules['option_3_html'] = 'required_if:option_count,3,4,5,6';
            $rules['option_4_html'] = 'required_if:option_count,4,5,6';
            $rules['option_5_html'] = 'required_if:option_count,5,6';
            $rules['option_6_html'] = 'required_if:option_count,6';
        }

        if($request->option_format_type == 3)
        {
            $rules['jumpled_words'] = 'required';
            $rules['rearranging_words'] = 'required';
        }
        // if($request->option_format_type == 2)
        // {
        //     $rules['quiz_option1_file'] = 'required_if:option_count,1,2,3,4,5,6';
        //     $rules['quiz_option2_file'] = 'required_if:option_count,2,3,4,5,6';
        //     $rules['quiz_option3_file'] = 'required_if:option_count,3,4,5,6';
        //     $rules['quiz_option4_file'] = 'required_if:option_count,4,5,6';
        //     $rules['quiz_option5_file'] = 'required_if:option_count,5,6';
        //     $rules['quiz_option6_file'] = 'required_if:option_count,6';
        // }

        $request->validate($rules);
        $quiz = QuizSet1::find($id);

        $quiz->category_id = $request->category_id;
        $quiz->question_format_type = $request->question_format_type;

        $quiz->option_format_type = $request->option_format_type;

        if($request->question_format_type == 1)
        {
            $rules['question_name'] = 'required';
            $quiz->question_name = $request->question_name;
        }

        if($request->question_format_type == 2)
        {
            $rules['question_name_html'] = 'required';
            $quiz->question_name = $request->question_name_html;
        }

        if($request->question_format_type == 3)
        {
            $rules['question_name'] = 'required';
            $rules['image_file'] = 'required';
            if($request->hasFile('image_file'))
            {
                $image = $request['image_file'];
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
                $image->move(public_path('storage/events/events_images'),$new_name);
                $new_name_3 = 'storage/events/events_images/'.$new_name;

                $uploaded_file_2 = $new_name_3 ?? '';
                $quiz->question_content = $uploaded_file_2;
                $quiz->question_name = $request->question_name_image;
            }
        }

        if($request->question_format_type == 4)
        {
            $rules['question_name'] = 'required';
            $rules['video_file'] = 'required';

            if($request->hasFile('video_file'))
            {
                $video = $request['video_file'];
                $image_name = $video->getClientOriginalName();
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
                $video->move(public_path('storage/events/events_video'),$new_name);
                $upload_video_3 = 'storage/events/events_video/'.$new_name;

                $uploaded_file1_4 = $upload_video_3 ?? '';
                $quiz->question_content = $uploaded_file1_4;
                $quiz->question_name = $request->question_name_video;
            }
        }


        if($request->option_format_type == 0){
            $quiz->option_1 = $request->option_1;
            $quiz->option_2 = $request->option_2;
            $quiz->option_3 = $request->option_3;
            $quiz->option_4 = $request->option_4;
            $quiz->option_5 = $request->option_5;
            $quiz->option_6 = $request->option_6;
        }

        if($request->option_format_type == 1){
            $quiz->option_1 = $request->option_1_html;
            $quiz->option_2 = $request->option_2_html;
            $quiz->option_3 = $request->option_3_html;
            $quiz->option_4 = $request->option_4_html;
            $quiz->option_5 = $request->option_5_html;
            $quiz->option_6 = $request->option_6_html;
        }

        if($request->option_format_type == 2){
            if ($request->hasFile('quiz_option1_file')) {
                $quiz->option_1 = $request->file('quiz_option1_file')->store('uploads', 'public');
            }
            if ($request->hasFile('quiz_option2_file')) {
                $quiz->option_2 = $request->file('quiz_option2_file')->store('uploads', 'public');
            }
            if ($request->hasFile('quiz_option3_file')) {
                $quiz->option_3 = $request->file('quiz_option3_file')->store('uploads', 'public');
            }
            if ($request->hasFile('quiz_option4_file')) {
                $quiz->option_4 = $request->file('quiz_option4_file')->store('uploads', 'public');
            }
            if ($request->hasFile('quiz_option5_file')) {
                $quiz->option_5 = $request->file('quiz_option5_file')->store('uploads', 'public');
            }
            if ($request->hasFile('quiz_option6_file')) {
                $quiz->option_6 = $request->file('quiz_option6_file')->store('uploads', 'public');
            }

        }

        if($request->option_format_type == 3){
            $quiz->jumpled_words = $request->jumpled_words ?? '' ;
            $quiz->rearranging_words = $request->rearranging_words ?? '' ;
        }

        $quiz->quiz_answer = $request->quiz_answer;
        if($request->quiz_answer == 1)
        {
            if(empty($quiz->quiz_answer_value = $request->option_1))
            {
                if(empty($quiz->quiz_answer_value = $request->option_1_html)){
                    $quiz->quiz_answer_value = $quiz->option_1;
                }
            }
        }
        if($request->quiz_answer == 2)
        {
            if(empty($quiz->quiz_answer_value = $request->option_2))
            {
                if(empty($quiz->quiz_answer_value = $request->option_2_html)){
                    $quiz->quiz_answer_value = $quiz->option_2;
                }
            }
        }

        if($request->quiz_answer == 3)
        {
            if(empty($quiz->quiz_answer_value = $request->option_3))
            {
                if(empty($quiz->quiz_answer_value = $request->option_3_html)){
                    $quiz->quiz_answer_value = $quiz->option_3;
                }
            }
        }

        if($request->quiz_answer == 4)
        {
            if(empty($quiz->quiz_answer_value = $request->option_4))
            {
                if(empty($quiz->quiz_answer_value = $request->option_4_html)){
                    $quiz->quiz_answer_value = $quiz->option_4;
                }
            }
        }

        if($request->quiz_answer == 5)
        {
            if(empty($quiz->quiz_answer_value = $request->option_5))
            {
                if(empty($quiz->quiz_answer_value = $request->option_5_html)){
                    $quiz->quiz_answer_value = $quiz->option_5;
                }
            }
        }

        if($request->quiz_answer == 6)
        {
            if(empty($quiz->quiz_answer_value = $request->option_6))
            {
                if(empty($quiz->quiz_answer_value = $request->option_6_html)){
                    $quiz->quiz_answer_value = $quiz->option_6;
                }
            }
        }
        $quiz->quiz_hint = $request->quiz_hint;
        $quiz->quiz_exp = $request->quiz_exp;
        $quiz->option_count = $request->option_count;

        if($request->file_type == 1)
        {
            $quiz->image_type = $request->file_type;
            $quiz->quiz_image = $request['file'];
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
                $image->move(public_path('storage/prayers/app'),$new_name);
                $new_name_2 = 'storage/prayers/app/'.$new_name;
            }
            $uploaded_file = $new_name_2 ?? '';
            $quiz->quiz_image = $uploaded_file;
        }
        else if($request->file_type == 2)
        {
            $quiz->quiz_image = $request->url_image;
            $quiz->image_type = $request->file_type;
        }

        $quiz->save();

        return back()->with('message','Quiz Edited Successfully');
    }
}
