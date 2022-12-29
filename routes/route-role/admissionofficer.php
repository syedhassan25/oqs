<?php 

 Route::group(['prefix' => 'admission-officer', 'middleware' => ['auth','role:admission-officer']], function () {
       Route::get('/', 'Admission\DashboardController@index');
       Route::get('/dashboard', 'Admission\DashboardController@index')->name('admissionpanel.dasboard.index');
       
        Route::prefix('task')->group(function () {
        Route::get('/', 'Admission\TaskController@index')->name('admissionpanel.task.index');
        Route::get('/create', 'Admission\TaskController@create')->name('admissionpanel.task.create');
        Route::post('/store', 'Admission\TaskController@store')->name('admissionpanel.task.store');
        Route::get('/{id}/edit', 'Admission\TaskController@edit')->name('admissionpanel.task.edit');
        
        Route::get('/{id}/detail', 'Admission\TaskController@detail')->name('admissionpanel.task.detail');
        
        Route::post('/update', 'Admission\TaskController@update')->name('admissionpanel.task.update');
        Route::get('/{id}/delete', 'Admission\TaskController@delete')->name('admissionpanel.task.delete')->middleware('permission:task-delete');
        Route::get('/datatable', 'Admission\TaskController@get_task_forms')->name('admissionpanel.task.datatable');
        Route::get('/pending-datatable', 'Admission\TaskController@get_task_pending_forms')->name('admissionpanel.task.pending.datatable');
        Route::get('/completed-datatable', 'Admission\TaskController@get_task_completed_forms')->name('admissionpanel.task.completed.datatable');
        Route::get('/cancel-datatable', 'Admission\TaskController@get_task_cancel_forms')->name('admissionpanel.task.cancel.datatable');
        Route::get('/assigned-datatable', 'Admission\TaskController@get_task_AssignFrom')->name('admissionpanel.taskAssigned.datatable');
        Route::get('/future-datatable', 'Admission\TaskController@get_task_Future_forms')->name('admissionpanel.task.future.datatable');
        
         Route::post('/get-users-by-role', 'Admission\TaskController@getUserRolewise')->name('admissionpanel.task.getUserRolewise');
         Route::get('/get-student-by-group', 'Admission\TaskController@getStudentBygroup')->name('admissionpanel.task.getStudentBygroup');
         Route::get('/get-student-by-teacher', 'Admission\TaskController@getStudentByteacher')->name('admissionpanel.task.getStudentByteacher');
         
         
         
          Route::post('/comment/add', 'Admission\TaskController@comment_add')->name('admissionpanel.task.comment');
          Route::get('/comment/datatable', 'Admission\TaskController@get_comment_forms')->name('admissionpanel.task.comment.datatable');
          
          
          Route::post('status-change','Admission\TaskController@task_status_change')->name('admissionpanel.task.status.change');
          
          Route::post('status-change-detail','Admission\TaskController@task_status_change_detail')->name('admissionpanel.task.status.detail.change');
          
          
           Route::get('total-user-task-assigner-','Admission\TaskController@get_task_users_assign')->name('admissionpanel.task.AssignUsers');
           
           
           Route::post('user-task-ReAssign-user','Admission\TaskController@Save_task_users_Reassign')->name('admissionpanel.task.ReAssignuser.store');
           
           
           Route::post('user-task-extendDate','Admission\TaskController@Save_task_extendate')->name('admissionpanel.task.extendDate.store');
           
           
           
          
          
          
         
         
    });
    
       Route::prefix('student')->group(function () {
        Route::get('/', 'Admission\StudentController@index')->name('admissionpanel.student.index');
        Route::get('/create', 'Admission\StudentController@create')->name('admissionpanel.student.create');
        Route::post('/store', 'Admission\StudentController@store')->name('admissionpanel.student.store');
        Route::post('/storefullform', 'Admission\StudentController@storefullform')->name('admissionpanel.student.storefullform');
        Route::get('/{id}/edit', 'Admission\StudentController@edit')->name('admissionpanel.student.edit');
        Route::post('/update','Admission\StudentController@update')->name('admissionpanel.student.update');
        
        Route::get('/new', 'Admission\StudentController@NewForm')->name('admissionpanel.student.new');
        Route::get('/schdule-demo', 'Admission\StudentController@SchduleForm')->name('admissionpanel.student.schduledemo');
        Route::get('/trailstarted', 'Admission\StudentController@TrailStartedForm')->name('admissionpanel.student.trailstarted');
        Route::get('/trailcompleted', 'Admission\StudentController@TrailCompletedForm')->name('admissionpanel.student.trailcompleted');
        Route::get('/schdule-student-datatable', 'Admission\StudentController@get_student_schdule_forms')->name('admissionpanel.student.schdule.datatable');
        Route::get('/new-student-datatable', 'Admission\StudentController@get_new_student_forms')->name('admissionpanel.student.newFormdatatable');
        Route::get('/schdule-demo-student-datatable', 'Admission\StudentController@get_demo_schdule_student_forms')->name('admissionpanel.student.demoScduledatatablenew');
        Route::get('/student-trail-started-datatable', 'Admission\StudentController@get_trailstarted_forms')->name('admissionpanel.student.trail.started.datatable');
        Route::get('/student-trail-completed-datatable', 'Admission\StudentController@get_trailcompleted_forms')->name('admissionpanel.student.trail.completed.datatable');
        Route::get('/timeconversion', 'Admission\StudentController@timeconversion')->name('admissionpanel.student.timeconversion');
        Route::post('/schdule/save', 'Admission\StudentController@studentSchdulesave')->name('admissionpanel.student.demo.schdule.save');
        Route::post('/search/time','Admission\TeacherController@searchFreeTimefunc')->name('admissionpanel.teacher.search');
        
        Route::get('/booked-time','Admission\StudentController@booktimeteacher')->name('admissionpanel.teacher.booked-time');
        Route::get('/booked-time/{id}','Admission\StudentController@booktimeteacherbystudent')->name('admissionpanel.teacher.booked-time-student');
        Route::post('/booked-time-save','Admission\StudentController@booktimeteachersave')->name('admissionpanel.teacher.booked-time.save');
        
          
    });    
       
    
 });

?>