<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('admin.login');
});

Route::get('/api', function () {
    return view('admin.api.api_route_list');
});

Route::get('auth/login', function () {
    return view('auth.login');
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::get('add-to-log', 'App\Http\Controllers\HomeController@myTestAddToLog');


Route::group(['prefix' => 'admin'], function()
{
	Route::group(['middleware' => 'admin.guest'], function()
    {
		Route::view('/login','admin.login')->name('admin.login');
		Route::post('/login',[App\Http\Controllers\AdminController::class, 'authenticate'])->name('admin.auth');
	});

	Route::group(['middleware' => 'admin.auth'], function()
    {
        Route::post('/import_list', [App\Http\Controllers\HomeController::class, 'import'])->name('users.import');

        Route::get('/dashboard', [App\Http\Controllers\AdminController::class,'dashboard'])->name('admin.dashboard');

        Route::get('/admin_add_app', [App\Http\Controllers\Quiz\QuizSet1AppController::class,'Add_list'])->name('admin.add_app');

        Route::get('/app_list',[App\Http\Controllers\Quiz\QuizSet1AppController::class,'show'])->name('admin.applist');

        Route::post('/insert', [App\Http\Controllers\Quiz\QuizSet1AppController::class,'store'])->name('admin.insert');

        Route::any('/edit_app/{id}',[App\Http\Controllers\Quiz\QuizSet1AppController::class,'EditApp'])->name('admin.edit');

        Route::post('/delete_app/{id}',[App\Http\Controllers\Quiz\QuizSet1AppController::class,'delete'])->name('admin.delete');

        Route::any('/edit_app_list/{id}',[App\Http\Controllers\Quiz\QuizSet1AppController::class,'EditAppList'])->name('admin.update');

        Route::any('/mapped_app/{id}',[App\Http\Controllers\Quiz\QuizSet1AppController::class,'edit'])->name('admin.mapping');

        Route::post('/update_map_cat/{id}',[App\Http\Controllers\Quiz\QuizSet1MappedApp::class,'insert'])->name('admin.mapping_cat');

        Route::post('/app_status_update', [App\Http\Controllers\Quiz\QuizSet1AppController::class, 'active'])->name('admin.app.status');

        //category_list

        Route::get('/category_list',[App\Http\Controllers\Quiz\QuizSet1CategoryController::class,'show'])->name('category.list');

        Route::get('/add_category', [App\Http\Controllers\Quiz\QuizSet1CategoryController::class,'Add_list'])->name('admin.add_category');

        Route::post('/category.insert', [App\Http\Controllers\Quiz\QuizSet1CategoryController::class,'store']);

        Route::post('/edit_category_list/{id}',[App\Http\Controllers\Quiz\QuizSet1CategoryController::class,'EditCatList']);

        Route::any('/edit_category/{id}',[App\Http\Controllers\Quiz\QuizSet1CategoryController::class,'EditCategory'])->name('admin.edit_category');

        Route::post('/delete_category/{id}',[App\Http\Controllers\Quiz\QuizSet1CategoryController::class,'delete']);

        Route::post('/category_status_update', [App\Http\Controllers\Quiz\QuizSet1CategoryController::class, 'active']);

        //profile update
        Route::get('/profile_update', function ()
        {
            return view('admin.accounts.profile_update');
        })->name('admin.profile_update');

        Route::any('/home','App\Http\Controllers\AdminController@profileUpdate')->name('profileupdate');

        //Accounts

        Route::get('/superadmin',[App\Http\Controllers\AdminController::class,'superadmin'])->name('superadmin.list');

        Route::get('/admin_add_sub_admin',[App\Http\Controllers\AdminController::class,'add'])->name('add_superadmin');

        Route::post('/admin_insert',[App\Http\Controllers\AdminController::class,'insert']);

        Route::any('/edit_admin/{id}',[App\Http\Controllers\AdminController::class,'edit'])->name('edit_superadmin');

        Route::any('/edit_admin_list/{id}',[App\Http\Controllers\AdminController::class,'editlist']);

        Route::post('/user_status_update', [App\Http\Controllers\AdminController::class, 'active']);

        Route::post('/delete_admin/{id}',[App\Http\Controllers\AdminController::class,'delete']);

        Route::get('/logActivity', 'App\Http\Controllers\HomeController@logActivity');

        Route::post('/activitydelete',[App\Http\Controllers\AdminController::class,'activitydelete']);

        route::post('/manage/{id}',[App\Http\Controllers\AdminController::class,'manage']);

        // Quiz

        Route::post('/edit_Quiz_list/{id}',[App\Http\Controllers\Quiz\QuizSet1Controller::class,'EditQuestionList']);

        Route::any('/edit_Quiz/{id}',[App\Http\Controllers\Quiz\QuizSet1Controller::class,'EditQuestion'])->name('admin.edit.Quiz');

        Route::post('/delete_Quiz/{id}',[App\Http\Controllers\Quiz\QuizSet1Controller::class,'delete']);

        // Route::post('/QuizSet1Store', [App\Http\Controllers\Quiz\QuizSet1Controller::class,'store']);
        Route::post('/QuizSetStore', [App\Http\Controllers\Quiz\QuizSet1Controller::class,'store']);

        Route::get('/Quiz',[App\Http\Controllers\Quiz\QuizSet1Controller::class,'show'])->name('admin.Quiz');

        Route::get('/add_Quiz',[App\Http\Controllers\Quiz\QuizSet1Controller::class,'add'])->name('admin.add_Quiz');

        Route::post('/Quiz_status_update', [App\Http\Controllers\Quiz\QuizSet1Controller::class, 'active']);


        Route::get('/users-export', [App\Http\Controllers\UserController::class,'export'])->name('users.export');

	}
    );

    Route::get('/logout', [App\Http\Controllers\AdminController::class, 'logout'])->name('admin.logout');
});


Route::group(['prefix' => 'Quiz'], function()
{
	Route::group(['middleware' => 'admin.auth'], function()
    {

        Route::get('/admin_add_app', [App\Http\Controllers\Quiz\QuizSet2AppController::class,'Add_list'])->name('Quiz.add_app');

        Route::get('/app_list',[App\Http\Controllers\Quiz\QuizSet2AppController::class,'show'])->name('Quiz.applist');

        Route::post('/insert', [App\Http\Controllers\Quiz\QuizSet2AppController::class,'store']);

        Route::any('/edit_app/{id}',[App\Http\Controllers\Quiz\QuizSet2AppController::class,'EditApp'])->name('Quiz.edit');

        Route::post('/delete_app/{id}',[App\Http\Controllers\Quiz\QuizSet2AppController::class,'delete']);

        Route::any('/edit_app_list/{id}',[App\Http\Controllers\Quiz\QuizSet2AppController::class,'EditAppList']);

        Route::any('/mapped_app/{id}',[App\Http\Controllers\Quiz\QuizSet2AppController::class,'edit'])->name('Quiz.mapping');

        Route::post('/update_map_cat/{id}',[App\Http\Controllers\Quiz\QuizSet2MappedApp::class,'insert'])->name('Quiz.mapping_cat');

        Route::post('/app_status_update', [App\Http\Controllers\Quiz\QuizSet2AppController::class, 'active']);


        //Category

        Route::get('/category_list',[App\Http\Controllers\Quiz\QuizSet2CategoryController::class,'show'])->name('Quiz.categorylist');

        Route::get('/add_category', [App\Http\Controllers\Quiz\QuizSet2CategoryController::class,'Add_list'])->name('Quiz.add_category');

        Route::post('/category.insert', [App\Http\Controllers\Quiz\QuizSet2CategoryController::class,'store']);

        Route::post('/edit_category_list/{id}',[App\Http\Controllers\Quiz\QuizSet2CategoryController::class,'EditCatList']);

        Route::any('/edit_category/{id}',[App\Http\Controllers\Quiz\QuizSet2CategoryController::class,'EditCategory'])->name('Quiz.edit_category');

        Route::post('/delete_category/{id}',[App\Http\Controllers\Quiz\QuizSet2CategoryController::class,'delete']);

        Route::post('/category_status_update', [App\Http\Controllers\Quiz\QuizSet2CategoryController::class, 'active']);

        //Sub Category

        Route::post('/edit_sub_category_list/{id}',[App\Http\Controllers\Quiz\QuizSet2SubCategoryController::class,'EditSubCatList']);

        Route::post('/insert_sub_category', [App\Http\Controllers\Quiz\QuizSet2SubCategoryController::class,'store']);

        Route::any('/edit_sub_category/{id}',[App\Http\Controllers\Quiz\QuizSet2SubCategoryController::class,'EditSubCategory'])->name('Quiz.edit_sub_category');

        Route::post('/delete_sub_category/{id}',[App\Http\Controllers\Quiz\QuizSet2SubCategoryController::class,'delete']);

        Route::post('/sub_category_status_update', [App\Http\Controllers\Quiz\QuizSet2SubCategoryController::class, 'active']);

        Route::get('/add_sub_category',[App\Http\Controllers\Quiz\QuizSet2SubCategoryController::class,'add'])->name('Quiz.add_sub_category');

        Route::get('/sub_category_list',[App\Http\Controllers\Quiz\QuizSet2SubCategoryController::class,'show'])->name('Quiz.sub_categorylist');

        Route::post('/subcat', [App\Http\Controllers\Quiz\QuizSet2SubCategoryController::class, 'subCat']);


        //Quiz

        Route::post('/edit_Quiz_list/{id}',[App\Http\Controllers\Quiz\QuizSet2Controller::class,'EditQuestionList']);

        Route::any('/edit_Quiz/{id}',[App\Http\Controllers\Quiz\QuizSet2Controller::class,'EditQuestion'])->name('Quiz.edit.Quiz');

        Route::post('/delete_Quiz/{id}',[App\Http\Controllers\Quiz\QuizSet2Controller::class,'delete']);

        Route::post('/insert_Quiz', [App\Http\Controllers\Quiz\QuizSet2Controller::class,'store']);

        Route::get('/Quizs',[App\Http\Controllers\Quiz\QuizSet2Controller::class,'show'])->name('Quiz.Quiz_list');

        Route::get('/add_Quizs',[App\Http\Controllers\Quiz\QuizSet2Controller::class,'add'])->name('Quiz.add_Quiz');

        Route::post('/Quiz_status_update', [App\Http\Controllers\Quiz\QuizSet2Controller::class, 'active']);

        Route::get('/export_subcategory',[App\Http\Controllers\Quiz\QuizSet2SubCategoryController::class,'export_subcategory'])->name('Quiz.export_subcategory');

        Route::post('/import_subcategory',[App\Http\Controllers\Quiz\QuizSet2SubCategoryController::class,'import_subcategory'])->name('Quiz.import_subcategory');


	}
    );
});

Route::group(['prefix' => 'QuizSet3'], function()
{
	Route::group(['middleware' => 'admin.auth'], function()
    {

        Route::get('/admin_add_app', [App\Http\Controllers\Quiz\QuizSet3AppController::class,'Add_list'])->name('QuizSet3.add_app');

        Route::get('/app_list',[App\Http\Controllers\Quiz\QuizSet3AppController::class,'show'])->name('QuizSet3.applist');

        Route::post('/insert', [App\Http\Controllers\Quiz\QuizSet3AppController::class,'store']);

        Route::any('/edit_app/{id}',[App\Http\Controllers\Quiz\QuizSet3AppController::class,'EditApp'])->name('QuizSet3.edit');

        Route::post('/delete_app/{id}',[App\Http\Controllers\Quiz\QuizSet3AppController::class,'delete']);

        Route::any('/edit_app_list/{id}',[App\Http\Controllers\Quiz\QuizSet3AppController::class,'EditAppList']);

        Route::any('/mapped_app/{id}',[App\Http\Controllers\Quiz\QuizSet3AppController::class,'edit'])->name('QuizSet3.mapping');

        Route::post('/update_map_cat/{id}',[App\Http\Controllers\Quiz\QuizSet3MappedApp::class,'insert'])->name('QuizSet3.mapping_cat');

        Route::post('/app_status_update', [App\Http\Controllers\Quiz\QuizSet3AppController::class, 'active']);


        //Category

        Route::get('/category_list',[App\Http\Controllers\Quiz\QuizSet3CategoryController::class,'show'])->name('QuizSet3.categorylist');

        Route::get('/add_category', [App\Http\Controllers\Quiz\QuizSet3CategoryController::class,'Add_list'])->name('QuizSet3.add_category');

        Route::post('/category.insert', [App\Http\Controllers\Quiz\QuizSet3CategoryController::class,'store']);

        Route::post('/edit_category_list/{id}',[App\Http\Controllers\Quiz\QuizSet3CategoryController::class,'EditCatList']);

        Route::any('/edit_category/{id}',[App\Http\Controllers\Quiz\QuizSet3CategoryController::class,'EditCategory'])->name('QuizSet3.edit_category');

        Route::post('/delete_category/{id}',[App\Http\Controllers\Quiz\QuizSet3CategoryController::class,'delete']);

        Route::any('/category_map/{id}',[App\Http\Controllers\Quiz\QuizSet3CategoryController::class,'edit'])->name('QuizSet3.category_app');

        Route::post('/update_map_sub_cat/{id}',[App\Http\Controllers\Quiz\QuizSet3MappedApp::class,'categoryinsert'])->name('QuizSet3.mapping_sub_cat');

        Route::post('/category_status_update', [App\Http\Controllers\Quiz\QuizSet3CategoryController::class, 'active']);

       //subcategory


       Route::post('/edit_sub_category_list/{id}',[App\Http\Controllers\Quiz\QuizSet3SubCategoryController::class,'EditSubCatList']);

       Route::post('/insert_sub_category', [App\Http\Controllers\Quiz\QuizSet3SubCategoryController::class,'store']);

       Route::any('/edit_sub_category/{id}',[App\Http\Controllers\Quiz\QuizSet3SubCategoryController::class,'EditSubCategory'])->name('QuizSet3.edit_sub_category');

       Route::post('/delete_sub_category/{id}',[App\Http\Controllers\Quiz\QuizSet3SubCategoryController::class,'delete']);

       Route::post('/sub_category_status_update', [App\Http\Controllers\Quiz\QuizSet3SubCategoryController::class, 'active']);

       Route::get('/add_sub_category',[App\Http\Controllers\Quiz\QuizSet3SubCategoryController::class,'add'])->name('QuizSet3.add_sub_category');

       Route::get('/sub_category_list',[App\Http\Controllers\Quiz\QuizSet3SubCategoryController::class,'show'])->name('QuizSet3.sub_categorylist');

       Route::post('/subcat', [App\Http\Controllers\Quiz\QuizSet3SubCategoryController::class, 'subCat']);


       //QuizSet3

       Route::post('/insert_QuizSet3s',[App\Http\Controllers\Quiz\QuizSet3Controller::class,'store'])->name('insert.file');

       Route::post('/edit_QuizSet3s_list/{id}',[App\Http\Controllers\Quiz\QuizSet3Controller::class,'EditQuestionList']);

       Route::any('/edit_QuizSet3s/{id}',[App\Http\Controllers\Quiz\QuizSet3Controller::class,'EditQuestion'])->name('QuizSet3.edit.QuizSet3');

       Route::post('/delete_QuizSet3s/{id}',[App\Http\Controllers\Quiz\QuizSet3Controller::class,'delete']);

       Route::get('/fetch_QuizSet3',[App\Http\Controllers\Quiz\QuizSet3Controller::class,'show'])->name('QuizSet3.QuizSet3_list');

       Route::get('/add_QuizSet3s',[App\Http\Controllers\Quiz\QuizSet3Controller::class,'add'])->name('QuizSet3.add_QuizSet3');

       Route::post('/QuizSet3s_status_update', [App\Http\Controllers\Quiz\QuizSet3Controller::class, 'active']);


	}
    );
});

Route::group(['prefix' => 'QuizSet4'], function()
{
	Route::group(['middleware' => 'admin.auth'], function()
    {

        Route::get('/admin_add_app', [App\Http\Controllers\Quiz\QuizSet4AppController::class,'Add_list'])->name('QuizSet4.add_app');

        Route::get('/app_list',[App\Http\Controllers\Quiz\QuizSet4AppController::class,'show'])->name('QuizSet4.applist');

        Route::post('/insert', [App\Http\Controllers\Quiz\QuizSet4AppController::class,'store']);

        Route::any('/edit_app/{id}',[App\Http\Controllers\Quiz\QuizSet4AppController::class,'EditApp'])->name('QuizSet4.edit');

        Route::post('/delete_app/{id}',[App\Http\Controllers\Quiz\QuizSet4AppController::class,'delete']);

        Route::any('/edit_app_list/{id}',[App\Http\Controllers\Quiz\QuizSet4AppController::class,'EditAppList']);

        Route::any('/mapped_app/{id}',[App\Http\Controllers\Quiz\QuizSet4AppController::class,'edit'])->name('QuizSet4.mapping');

        Route::post('/update_map_cat/{id}',[App\Http\Controllers\QuizSet4\QuizSet4MappedApp::class,'insert'])->name('QuizSet4.mapping_cat');

        Route::post('/app_status_update', [App\Http\Controllers\Quiz\QuizSet4AppController::class, 'active']);

        //Quiz Set 4

        Route::post('/Quiz_upload', [App\Http\Controllers\Quiz\QuizSet4Controller::class, 'upload'])->name('upload');

        Route::post('/edit_QuizSet4s_list/{id}',[App\Http\Controllers\Quiz\QuizSet4Controller::class,'EditQuestionList']);

        Route::any('/edit_QuizSet4s/{id}',[App\Http\Controllers\Quiz\QuizSet4Controller::class,'EditQuestion'])->name('QuizSet4.edit_QuizSet4s');

        Route::post('/delete_QuizSet4s/{id}',[App\Http\Controllers\Quiz\QuizSet4Controller::class,'delete']);

        Route::post('/insert_QuizSet4s', [App\Http\Controllers\Quiz\QuizSet4Controller::class,'store']);

        Route::get('/QuizSet4s_list',[App\Http\Controllers\Quiz\QuizSet4Controller::class,'show'])->name('QuizSet4.QuizSet4');

        Route::get('/add_QuizSet4s',[App\Http\Controllers\Quiz\QuizSet4Controller::class,'add'])->name('QuizSet4.add_QuizSet4s');

        Route::post('/QuizSet4s_status_update', [App\Http\Controllers\Quiz\QuizSet4Controller::class, 'active']);
	}
    );
});
