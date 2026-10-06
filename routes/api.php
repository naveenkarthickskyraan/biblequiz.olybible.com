<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//Events
Route::get('quizset1/app_list_api',[App\Http\Controllers\Api\ApiController::class,'App']);

Route::any('quizset1/category_list_by_app_id',[App\Http\Controllers\Api\ApiController::class,'Category']);

Route::post('quizset1/quiz_list_by_app_id',[App\Http\Controllers\Api\ApiController::class,'QuizCategoryList']);

Route::post('quizset1/quiz_list_by_category_id',[App\Http\Controllers\Api\ApiController::class,'QuizCategoryList']);

Route::any('quizset1/quizset1_detail',[App\Http\Controllers\Api\ApiController::class,'quizset1']);

Route::any('quizset1/quizset1_search',[App\Http\Controllers\Api\ApiController::class,'quizset1paginate']);

Route::any('quizset1/quizset1_last_fetched',[App\Http\Controllers\Api\ApiController::class,'quizset1_last_fetched']);


//quizset2

Route::get('quizset2/app_list_api',[App\Http\Controllers\Api\ApiController::class,'quizset2App']);

Route::any('quizset2/category_list_by_app_id',[App\Http\Controllers\Api\ApiController::class,'quizset2Category']);

Route::post('quizset2/sub_category_list',[App\Http\Controllers\Api\ApiController::class,'quizset2SubCategory']);

Route::post('quizset2/quizset2_list_by_category_id',[App\Http\Controllers\Api\ApiController::class,'quizset2CategoryList']);

Route::post('quizset2/quizset2_list_by_sub_category_id',[App\Http\Controllers\Api\ApiController::class,'quizset2SubCategoryList']);

Route::post('quizset2/quizset2_detail',[App\Http\Controllers\Api\ApiController::class,'quizset2']);

Route::any('quizset2/quizset2_search',[App\Http\Controllers\Api\ApiController::class,'quizset2paginate']);

Route::any('quizset2/quizset2_last_fetched',[App\Http\Controllers\Api\ApiController::class,'
']);


//QUiz set4 
Route::get('quizset4/app_list_api',[App\Http\Controllers\Api\ApiController::class,'quizset4App']);

Route::post('quizset4/quizset4_detail',[App\Http\Controllers\Api\ApiController::class,'quizset4']);

Route::post('quizset4/quizset4_quiz_id_detail',[App\Http\Controllers\Api\ApiController::class,'quizset4_quiz_id_detail']);

Route::any('quizset4/quizset4_search',[App\Http\Controllers\Api\ApiController::class,'quizset4search']);

Route::any('quizset4/quizset4_last_fetched',[App\Http\Controllers\Api\ApiController::class,'quizset4_last_fetched']);



//quizset3

Route::get('quizset3/app_list_api',[App\Http\Controllers\Api\ApiController::class,'quizset3App']);

Route::any('quizset3/category_list_by_app_id',[App\Http\Controllers\Api\ApiController::class,'quizset3Category']);

Route::post('quizset3/sub_category_list',[App\Http\Controllers\Api\ApiController::class,'quizset3SubCategory']);

Route::post('quizset3/quizset3_list_by_category_id',[App\Http\Controllers\Api\ApiController::class,'quizset3CategoryList']);

Route::post('quizset3/quizset3_list_by_sub_category_id',[App\Http\Controllers\Api\ApiController::class,'quizset3SubCategoryList']);

Route::post('quizset3/quizset3_detail',[App\Http\Controllers\Api\ApiController::class,'quizset3']);

Route::any('quizset3/quizset3_search',[App\Http\Controllers\Api\ApiController::class,'quizset3paginate']);

Route::any('quizset3/quizset3_last_fetched',[App\Http\Controllers\Api\ApiController::class,'quizset3_last_fetched']);
