<?php

use Illuminate\Http\Request;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
// Route::get('public/getdata',function(){
//     return [];
// });



Route::post('student/register', 'ApiController@savestudentRegisterWPFData');

Route::post('login', 'PassportController@login');
Route::post('register', 'PassportController@register');

 
Route::middleware('auth:api')->group(function () {
    Route::get('studentslist', 'ApiController@studentdata');
    Route::get('studentbyid', 'ApiController@studentdatabyid');
    Route::get('studentslesson', 'ApiController@get_lesson_forms');
    Route::get('studentsclasses', 'ApiController@get_all_classes');
    Route::post('generateAttendance', 'ApiController@Attendancegenerate');
});


// Route::post('student/register', function (Request $request) {
    
//     \Log::info(array_diff(request()->all(), request()->query()));
    
//     return array_diff(request()->all(), request()->query());
// });