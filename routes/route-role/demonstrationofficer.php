<?php 

 Route::group(['prefix' => 'demonstration-officer', 'middleware' => ['auth','role:demonstration-officer']], function () {
       Route::get('/', 'Demonstration\DashboardController@index');
       Route::get('/dashboard', 'Demonstration\DashboardController@index')->name('demonstrationpanel.dasboard.index');
       
        Route::prefix('task')->group(function () {
        Route::get('/', 'Demonstration\TaskController@index')->name('demonstrationpanel.task.index');
        Route::get('/create', 'Demonstration\TaskController@create')->name('demonstrationpanel.task.create');
        Route::post('/store', 'Demonstration\TaskController@store')->name('demonstrationpanel.task.store');
        Route::get('/{id}/edit', 'Demonstration\TaskController@edit')->name('demonstrationpanel.task.edit');
        
        Route::get('/{id}/detail', 'Demonstration\TaskController@detail')->name('demonstrationpanel.task.detail');
        
        Route::post('/update', 'Demonstration\TaskController@update')->name('demonstrationpanel.task.update');
        Route::get('/{id}/delete', 'Demonstration\TaskController@delete')->name('demonstrationpanel.task.delete')->middleware('permission:task-delete');
        Route::get('/datatable', 'Demonstration\TaskController@get_task_forms')->name('demonstrationpanel.task.datatable');
        Route::get('/pending-datatable', 'Demonstration\TaskController@get_task_pending_forms')->name('demonstrationpanel.task.pending.datatable');
        Route::get('/completed-datatable', 'Demonstration\TaskController@get_task_completed_forms')->name('demonstrationpanel.task.completed.datatable');
        Route::get('/cancel-datatable', 'Demonstration\TaskController@get_task_cancel_forms')->name('demonstrationpanel.task.cancel.datatable');
        Route::get('/assigned-datatable', 'Demonstration\TaskController@get_task_AssignFrom')->name('demonstrationpanel.taskAssigned.datatable');
        Route::get('/future-datatable', 'Demonstration\TaskController@get_task_Future_forms')->name('demonstrationpanel.task.future.datatable');
        
         Route::post('/get-users-by-role', 'Demonstration\TaskController@getUserRolewise')->name('demonstrationpanel.task.getUserRolewise');
         Route::get('/get-student-by-group', 'Demonstration\TaskController@getStudentBygroup')->name('demonstrationpanel.task.getStudentBygroup');
         Route::get('/get-student-by-teacher', 'Demonstration\TaskController@getStudentByteacher')->name('demonstrationpanel.task.getStudentByteacher');
         
         
         
          Route::post('/comment/add', 'Demonstration\TaskController@comment_add')->name('demonstrationpanel.task.comment');
          Route::get('/comment/datatable', 'Demonstration\TaskController@get_comment_forms')->name('demonstrationpanel.task.comment.datatable');
          
          
          Route::post('status-change','Demonstration\TaskController@task_status_change')->name('demonstrationpanel.task.status.change');
          
          Route::post('status-change-detail','Demonstration\TaskController@task_status_change_detail')->name('demonstrationpanel.task.status.detail.change');
          
          
           Route::get('total-user-task-assigner-','Demonstration\TaskController@get_task_users_assign')->name('demonstrationpanel.task.AssignUsers');
           
           
           Route::post('user-task-ReAssign-user','Demonstration\TaskController@Save_task_users_Reassign')->name('demonstrationpanel.task.ReAssignuser.store');
           
           
           Route::post('user-task-extendDate','Demonstration\TaskController@Save_task_extendate')->name('demonstrationpanel.task.extendDate.store');
           
           
           
          
          
          
         
         
    });
    
       Route::prefix('student')->group(function () {
        Route::get('/', 'Demonstration\StudentController@index')->name('demonstrationpanel.student.index');
        Route::get('/create', 'Demonstration\StudentController@create')->name('demonstrationpanel.student.create');
        Route::post('/store', 'Admin\StudentController@store')->name('demonstrationpanel.student.store');
        Route::get('/new', 'Demonstration\StudentController@NewForm')->name('demonstrationpanel.student.new');
        Route::get('/schdule-demo', 'Demonstration\StudentController@SchduleForm')->name('demonstrationpanel.student.schduledemo');
        Route::get('/trailstarted', 'Demonstration\StudentController@TrailStartedForm')->name('demonstrationpanel.student.trailstarted');
        Route::get('/trailcompleted', 'Demonstration\StudentController@TrailCompletedForm')->name('demonstrationpanel.student.trailcompleted');
        Route::get('/schdule-student-datatable', 'Demonstration\StudentController@get_student_schdule_forms')->name('demonstrationpanel.student.schdule.datatable');
        Route::get('/new-student-datatable', 'Demonstration\StudentController@get_new_student_forms')->name('demonstrationpanel.student.newFormdatatable');
        Route::get('/schdule-demo-student-datatable', 'Demonstration\StudentController@get_demo_schdule_student_forms')->name('demonstrationpanel.student.demoScduledatatablenew');
        Route::get('/student-trail-started-datatable', 'Demonstration\StudentController@get_trailstarted_forms')->name('demonstrationpanel.student.trail.started.datatable');
        Route::get('/student-trail-completed-datatable', 'Demonstration\StudentController@get_trailcompleted_forms')->name('demonstrationpanel.student.trail.completed.datatable');
        Route::get('/timeconversion', 'Demonstration\StudentController@timeconversion')->name('demonstrationpanel.student.timeconversion');
        Route::post('/schdule/save', 'Demonstration\StudentController@studentSchdulesave')->name('demonstrationpanel.student.demo.schdule.save');
        Route::post('/search/time','Demonstration\TeacherController@searchFreeTimefunc')->name('demonstrationpanel.teacher.search');
        
        Route::get('/booked-time','Demonstration\StudentController@booktimeteacher')->name('demonstrationpanel.teacher.booked-time');
        Route::get('/booked-time/{id}','Demonstration\StudentController@booktimeteacherbystudent')->name('demonstrationpanel.teacher.booked-time-student');
        Route::post('/booked-time-save','Demonstration\StudentController@booktimeteachersave')->name('demonstrationpanel.teacher.booked-time.save');
        
        Route::get('/{id}/edit', 'Demonstration\StudentController@edit')->name('demonstrationpanel.student.editnewform');
        //  Route::get('/{id}/editnewform', 'Demonstration\StudentController@editnewform')->name('demonstrationpanel.student.editnewform');
        Route::post('/update','Demonstration\StudentController@update')->name('demonstrationpanel.student.update');
        Route::post('/updatenewform','Demonstration\StudentController@updatenewform')->name('demonstrationpanel.student.updatenewform');
        Route::get('/student-datatable', 'Demonstration\StudentController@get_student_forms')->name('demonstrationpanel.student.datatable');
        
         Route::get('/lesson-student-datatable', 'Demonstration\LessonController@get_lesson_forms')->name('demonstrationpanel.student.lesson.lessondatatable');
         Route::post('/leesson/store', 'Demonstration\LessonController@save')->name('demonstrationpanel.student.lesson.save');
        Route::get('/leesson/{id}/edit', 'Demonstration\LessonController@edit')->name('demonstrationpanel.student.lesson.edit');
        Route::get('/leesson/{id}/latest', 'Demonstration\LessonController@getlastlesson')->name('demonstrationpanel.student.lesson.getlastlesson');
        
        Route::get('/student/detail/{id}', 'Demonstration\StudentController@getStudentDetail')->name('demonstrationpanel.student.detail');
        
        Route::get('/test/list', 'Demonstration\StudentController@StudentTest')->name('demonstrationpanel.student.test.list');
        Route::get('/test/list-datatable', 'Demonstration\StudentController@get_test_student_forms')->name('demonstrationpanel.student.test.list.datatable');
        Route::get('/test/{id}', 'Demonstration\StudentController@StudentTestAttend')->name('demonstrationpanel.student.test.attend');
        Route::post('/test/save', 'Demonstration\StudentController@StudentTestSave')->name('demonstrationpanel.student.test.save');
        Route::get('/test/save/view', 'Demonstration\StudentController@studentReportResult')->name('demonstrationpanel.student.test.save.view');
        Route::get('/test/save/view-datatable', 'Demonstration\StudentController@get_test_student_save')->name('demonstrationpanel.student.test.save.view.datatable');
        
        Route::get('/test/report/edit/{id}', 'Demonstration\StudentController@StudentTestAttendreportedit')->name('demonstrationpanel.student.test.attend.report.edit');
        
        
          
    });  
       Route::prefix('teacher')->group(function () {
        Route::get('/student/schedule','Demonstration\TeacherController@schduleCalender')->name('demonstrationpanel.teacher.student.weekly.schedule');
        Route::get('/student/calender/schedule/{id}','Demonstration\TeacherController@schduleCalenderNewbyID')->name('demonstrationpanel.teacher.student.weekly.schedule.calender');
       });
       
    
 });

?>