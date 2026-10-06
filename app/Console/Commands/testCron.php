<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use DB;
use Goutte\Client;
use App\Models\Quiz\QuizSet2;
use App\Models\Module;
Use App\Models\Admin;
use Illuminate\Support\Facades\Validator;
use App\Models\Category\QuizCategorySet2;
use App\Models\SubCategory\QuizSubCategorySet2;


use Illuminate\Support\Facades\Mail;

class testCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'testCron:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Every five minutes delete user';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        
        $url = 'https://tamil.telugubiblequiz.online/2023/03/tamil-bible-quiz-old-testament.html';
        
        $client = new Client();
        $crawler = $client->request('GET', $url);
        
        $content = $crawler->filter('.K2-grid > ul li a')->each(function ($node) {
            $link = $node->attr('href');
            
            return [
                'link' => $link,
            ];
        });
        
        $content_1 = $crawler->filter('.K2-grid > ul li span')->each(function ($node) {
            $link = $node->text();
            return $link;
        });

        foreach($content as $key => $row)
        {
            $category = new QuizSubCategorySet2();
            $category->sub_category_name = $content_1[$key];
            $category->sub_category_description = "";
            $category->sub_category_image = "";
            $category->image_type = 1;
            $category->category_id = 1;
            $category->save();
            $id = $category->id;
            $url =  $row['link'];

            $client_1 = new Client();
            $crawler_1 = $client_1->request('GET', $url);
            
            $content_2 = $crawler_1->filter('.post-body a')->each(function ($node) {
                $link_1 = $node->attr('href');
                // $text_1 = $node->filter('a button')->text();
                $buttonNode = $node->filter('a button');
                if (!$buttonNode->count()) {
                    $text_1 =  null;
                }else{
                    $text_1 = $buttonNode->text();
                }
                
                return [
                    'link' => $link_1,
                    'text' => $text_1,
                ];
            });
            
            if($content_2[0]['text'] == null)
            {
                $content_3 = $crawler_1->filter('.single-question-container')->each(function ($node) use ($id) {
                    if($node->filter('div > .questionName')->count() > 0)
                    {
                        $link_2 = $node->filter('div > .questionName')->text();

                        $text_2 = $node->filter('div .label-div')->each(function ($childran) {
                            return $childran->text();
                        });
                            
                        $trimmedData = array_map('trim', $text_2);

                        $answer = $node->filter('.correct')->each(function ($correct) {
                            return $correct->text();
                        });
                        
                        $count = count($trimmedData);
                        $QuizSet2 = new QuizSet2();

                        $input = $link_2;
                        $output = preg_replace('/^\d+[➤]\s+/u', '', $input);
                        $QuizSet2->question_name = $output;

                        $QuizSet2->question_content = null;
                        $QuizSet2->question_format_type = 1;
                        $QuizSet2->option_format_type = 0;

                        $options = [
                            'option_1',
                            'option_2',
                            'option_3',
                            'option_4',
                            'option_5',
                            'option_6'
                        ];

                        $option_label = [];
                        for ($i = 0; $i < count($options); $i++) {
                            if ($count > $i) {
                                $explode = explode(" ",$trimmedData[$i]);
                                unset($explode[0]);
                                $QuizSet2->{$options[$i]} = implode(' ',$explode);
                                $option_label[$i + 1] = implode(' ',$explode);
                            } else {
                                $QuizSet2->{$options[$i]} = "";
                            }
                        }

                        $QuizSet2->category_id = 1;
                        
                        $explode_1 = explode(" ",$answer[0]);
                        unset($explode_1[0]);

                        $answers_original = implode(' ',$explode_1);
                        $answers_original_key = array_search($answers_original, $option_label);
                        $QuizSet2->quiz_answer_value = implode(' ',$explode_1);
                        $QuizSet2->quiz_answer = $answers_original_key;

                        $QuizSet2->sub_category_id = $id;
                        $QuizSet2->option_count = $count;
                        $QuizSet2->save();
                    }else{
                        return "null";
                    }
                });

                if(count($content_3) == 0 || $content_3[0] == "null")
                {
                    $content_3 = $crawler_1->filter('fieldset')->each(function ($node) use ($id) {
                        $link_2 = $node->filter('h3')->text(); 

                        $text_2 = $node->filter('label')->each(function ($childran) {
                            return $childran->text();
                        });
                        
                        $answer = $node->filter('.Acorrect')->each(function ($correct) {
                            return $correct->text();
                        });
                        
                        $trimmedData = array_map('trim', $text_2);
    
                        $count = count($trimmedData);
                        $QuizSet2 = new QuizSet2();

                        $input = $link_2;
                        $output = preg_replace('/^\d+[➤]\s+/u', '', $input);
                        $QuizSet2->question_name = $output;
                
                        $QuizSet2->question_content = null;
                        $QuizSet2->question_format_type = 1;
                        $QuizSet2->option_format_type = 0;

                        $options = [
                            'option_1',
                            'option_2',
                            'option_3',
                            'option_4',
                            'option_5',
                            'option_6'
                        ];

                        $option_label = [];
                        for ($i = 0; $i < count($options); $i++) {
                            if ($count > $i) {
                                $explode = explode(" ",$trimmedData[$i]);
                                unset($explode[0]);
                                $QuizSet2->{$options[$i]} = implode(' ',$explode);
                                $option_label[$i + 1] = implode(' ',$explode);
                            } else {
                                $QuizSet2->{$options[$i]} = "";
                            }
                        }

                        $QuizSet2->category_id = 1;
                        
                        $explode_1 = explode(" ",$answer[0]);
                        unset($explode_1[0]);

                        $answers_original = implode(' ',$explode_1);
                        $answers_original_key = array_search($answers_original, $option_label);
                        $QuizSet2->quiz_answer_value = implode(' ',$explode_1);
                        $QuizSet2->quiz_answer = $answers_original_key;

                        $QuizSet2->sub_category_id = $id;
                        $QuizSet2->option_count = $count;
                        $QuizSet2->save();
                    });
                }
            }
            else{
                foreach($content_2 as $key_1 => $row_1)
                {
                    $url =  $row_1['link'];
                    $client_2 = new Client();
                    $crawler_2 = $client_2->request('GET', $url);

                    $content_3 = $crawler_2->filter('.quiz-form  .quiz-form__quiz')->each(function ($node) use ($id) {
                        if($node->filter('.quiz-form__question')->count() > 0)
                        {
                            $link_2 = $node->filter('.quiz-form__question')->text();

                            $text_2 = $node->filter('label')->each(function ($childran) {
                                return $childran->text();
                            });
                            
                            $answer = $node->filter('.correct')->each(function ($correct) {
                                return $correct->text();
                            });
                    
                            $trimmedData = array_map('trim', $text_2);
        
                            $count = count($trimmedData);
                            $QuizSet2 = new QuizSet2();

                            $input = $link_2;
                            $output = preg_replace('/^\d+[➤]\s+/u', '', $input);
                            $QuizSet2->question_name = $output;

                            $QuizSet2->question_content = null;
                            $QuizSet2->question_format_type = 1;
                            $QuizSet2->option_format_type = 0;

                            $options = [
                                'option_1',
                                'option_2',
                                'option_3',
                                'option_4',
                                'option_5',
                                'option_6'
                            ];

                            $option_label = [];
                            for ($i = 0; $i < count($options); $i++) {
                                if ($count > $i) {
                                    $explode = explode(" ",$trimmedData[$i]);
                                    unset($explode[0]);
                                    $QuizSet2->{$options[$i]} = implode(' ',$explode);
                                    $option_label[$i + 1] = implode(' ',$explode);
                                } else {
                                    $QuizSet2->{$options[$i]} = "";
                                }
                            }

                            $QuizSet2->category_id = 1;
                            
                            if(!empty($answer) )
                            {
                                $explode_1 = explode(" ",$answer[0]);
                                unset($explode_1[0]);
                                $answers_original = implode(' ',$explode_1);
                                $answers_original_key = array_search($answers_original, $option_label);
                                $QuizSet2->quiz_answer_value = implode(' ',$explode_1);
                                $QuizSet2->quiz_answer = $answers_original_key;
                                $QuizSet2->sub_category_id = $id;
                                $QuizSet2->option_count = $count;
                                $QuizSet2->save();
                            }
                        }else{
                            return "null";
                        }
                    });

                    if(count($content_3) == 0 || $content_3[0] == "null")
                    {
                        $content_3 = $crawler_2->filter('fieldset')->each(function ($node) use ($id) {
                            $link_2 = $node->filter('h3')->text(); 

                            $text_2 = $node->filter('label')->each(function ($childran) {
                                return $childran->text();
                            });
                            
                            $answer = $node->filter('.Acorrect')->each(function ($correct) {
                                return $correct->text();
                            });
                            
                            $trimmedData = array_map('trim', $text_2);
        
                            $count = count($trimmedData);
                            $QuizSet2 = new QuizSet2();

                            $input = $link_2;
                            $output = preg_replace('/^\d+[➤]\s+/u', '', $input);
                            $QuizSet2->question_name = $output;
                    
                            $QuizSet2->question_content = null;
                            $QuizSet2->question_format_type = 1;
                            $QuizSet2->option_format_type = 0;

                            $options = [
                                'option_1',
                                'option_2',
                                'option_3',
                                'option_4',
                                'option_5',
                                'option_6'
                            ];

                            $option_label = [];
                            for ($i = 0; $i < count($options); $i++) {
                                if ($count > $i) {
                                    $explode = explode(" ",$trimmedData[$i]);
                                    unset($explode[0]);
                                    $QuizSet2->{$options[$i]} = implode(' ',$explode);
                                    $option_label[$i + 1] = implode(' ',$explode);
                                } else {
                                    $QuizSet2->{$options[$i]} = "";
                                }
                            }

                            $QuizSet2->category_id = 1;
                            
                            $explode_1 = explode(" ",$answer[0]);
                            unset($explode_1[0]);

                            $answers_original = implode(' ',$explode_1);
                            $answers_original_key = array_search($answers_original, $option_label);
                            $QuizSet2->quiz_answer_value = implode(' ',$explode_1);
                            $QuizSet2->quiz_answer = $answers_original_key;

                            $QuizSet2->sub_category_id = $id;
                            $QuizSet2->option_count = $count;
                            $QuizSet2->save();
                        });
                    }
                }
            }
        }
        dd('added successfully');
    }
}
