<?php

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

Route::get('/cleint/getmac',function(){
    $ip = $_SERVER['REMOTE_ADDR'];
      $cmd = "arp -a " . $ip;
$status = 0;
$return = [];
exec($cmd, $return, $status);
var_dump($status, $return);
die;
});
 Route::get('/Artisanuse', function () {
  $exitCode = Artisan::call('storage:link');
  echo $exitCode;
});


Route::get('/', 'Auth\LoginController@showLoginForm')->name('login');
Route::get('/login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('/login', ['uses' => 'Auth\LoginController@login','middleware'    => 'userstatus']);
Route::get('logout', ['as' => 'logout', 'uses' => 'Auth\LoginController@logout']);
Route::post('logout', ['as' => 'logout', 'uses' => 'Auth\LoginController@logout']);
Route::get('/register', 'RegisterController@index')->name('register-agent');
Route::post('/userregister', 'RegisterController@userregister')->name('userregister');
Route::get('/load/city/{id}', 'Admin\CityController@get_city_by_country')->name('city.load.country');

Route::get('/checkUserNameAvailability',    'Admin\TeacherController@checkUserNameAvailability')->name('checkUserName');
Route::get('/checkEmailAvailability',    'Admin\TeacherController@checkEmailAvailability')->name('checkUserEmail');


Route::post('/fcmnotificationget', 'Admin\StudentController@LoadFcmNotification')->name('fcm.notification.get.user');
Route::post('/fcmnotificationgetbytype', 'Admin\StudentController@LoadFcmNotificationBytype')->name('fcm.notification.get.bytype.user');
Route::post('/fcmnotification-read', 'Admin\StudentController@ReadFcmNotification')->name('fcm.notification.read.user');

Route::group(['middleware' => ['auth']], function () {
Route::get('/lesson/create', 'LessonController@newLesson');
Route::get('/notification/lesson/notification', 'LessonController@readNotification');


Route::get('/notification/markasread',function(){
    \Auth::user()->notifications->markAsRead();

    // return true;
    // return redirect()->back();
})->name('noti.markAsRead');


Route::group(['prefix' => 'task'], function () {
Route::prefix('manage')->group(function () {
  Route::get('/', 'Admin\ManageTaskController@index')->name('admin.taskmanage.index')->middleware('permission:task-list');
  Route::get('/create', 'Admin\ManageTaskController@create')->name('admin.taskmanage.create')->middleware('permission:task-create');
  Route::post('/store', 'Admin\ManageTaskController@store')->name('admin.taskmanage.store')->middleware('permission:task-create');
  Route::get('/{id}/edit', 'Admin\ManageTaskController@edit')->name('admin.taskmanage.edit')->middleware('permission:task-edit');

  Route::get('/{id}/detail', 'Admin\ManageTaskController@detail')->name('admin.taskmanage.detail')->middleware('permission:task-edit');

  Route::post('/update', 'Admin\ManageTaskController@update')->name('admin.taskmanage.update')->middleware('permission:task-edit');
  Route::get('/{id}/delete', 'Admin\ManageTaskController@delete')->name('admin.taskmanage.delete')->middleware('permission:task-delete');
  Route::get('/datatable', 'Admin\ManageTaskController@get_task_forms')->name('admin.taskmanage.datatable')->middleware('permission:task-list');
  Route::get('/pending-datatable', 'Admin\ManageTaskController@get_task_pending_forms')->name('admin.taskmanage.pending.datatable')->middleware('permission:task-list');
  Route::get('/completed-datatable', 'Admin\ManageTaskController@get_task_completed_forms')->name('admin.taskmanage.completed.datatable')->middleware('permission:task-list');
  Route::get('/cancel-datatable', 'Admin\ManageTaskController@get_task_cancel_forms')->name('admin.taskmanage.cancel.datatable')->middleware('permission:task-list');
  Route::get('/assigned-datatable', 'Admin\ManageTaskController@get_task_AssignFrom')->name('admin.taskmanageAssigned.datatable')->middleware('permission:task-list');
  Route::get('/future-datatable', 'Admin\ManageTaskController@get_task_Future_forms')->name('admin.taskmanage.future.datatable')->middleware('permission:task-list');

  Route::post('/get-users-by-role', 'Admin\ManageTaskController@getUserRolewise')->name('admin.taskmanage.getUserRolewise')->middleware('permission:task-create');
  Route::get('/get-student-by-group', 'Admin\ManageTaskController@getStudentBygroup')->name('admin.taskmanage.getStudentBygroup')->middleware('permission:task-create');
  Route::get('/get-student-by-teacher', 'Admin\ManageTaskController@getStudentByteacher')->name('admin.taskmanage.getStudentByteacher')->middleware('permission:task-create');

  Route::post('/comment/add', 'Admin\ManageTaskController@comment_add')->name('admin.taskmanage.comment')->middleware('permission:task-create');
  Route::get('/comment/datatable', 'Admin\ManageTaskController@get_comment_forms')->name('admin.taskmanage.comment.datatable');

  Route::post('status-change', 'Admin\ManageTaskController@task_status_change')->name('admin.taskmanage.status.change');

  Route::post('status-change-detail', 'Admin\ManageTaskController@task_status_change_detail')->name('admin.taskmanage.status.detail.change');

  Route::get('total-user-task-assigner-', 'Admin\ManageTaskController@get_task_users_assign')->name('admin.taskmanage.AssignUsers');

  Route::post('user-task-ReAssign-user', 'Admin\ManageTaskController@Save_task_users_Reassign')->name('admin.taskmanage.ReAssignuser.store');

  Route::post('user-task-extendDate', 'Admin\ManageTaskController@Save_task_extendate')->name('admin.taskmanage.extendDate.store');

  Route::post('multiple-task-status-change', 'Admin\ManageTaskController@multiple_task_status_change')->name('admin.taskmanage.multiple.status.change');

  Route::post('multiple-task-assign-user', 'Admin\ManageTaskController@Multiple_task_users_Reassign')->name('admin.taskmanage.multiple.assign.user');

  
});
});


});

// ['role:superuser|manager|operator']



// admin Route file
require 'route-role/admin.php';

// teacher Route file
require 'route-role/teacher.php';

// Admission Officer Route file
require 'route-role/admissionofficer.php';


// Demonstration Officer Route file
require 'route-role/demonstrationofficer.php';

// Supervisor Officer Route file
require 'route-role/supervisorofficer.php';

// Quality Control Officer Route file
require 'route-role/qcdmanager.php';

// reporter Officer Route file
require 'route-role/reporter.php';

// parent Route file
require 'route-role/parent.php';


