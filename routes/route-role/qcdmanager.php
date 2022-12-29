<?php 

 Route::group(['prefix' => 'quality-control', 'middleware' => ['auth','role:qcd-manager']], function () {
       Route::get('/', 'Qualitycontrol\DashboardController@index');
       Route::get('/dashboard', 'Qualitycontrol\DashboardController@index')->name('qualitycontrolpanel.dasboard.index');
       
        Route::prefix('task')->group(function () {
        Route::get('/', 'Qualitycontrol\TaskController@index')->name('qualitycontrolpanel.task.index');
        Route::get('/create', 'Qualitycontrol\TaskController@create')->name('qualitycontrolpanel.task.create');
        Route::post('/store', 'Qualitycontrol\TaskController@store')->name('qualitycontrolpanel.task.store');
        Route::get('/{id}/edit', 'Qualitycontrol\TaskController@edit')->name('qualitycontrolpanel.task.edit');
        
        Route::get('/{id}/detail', 'Qualitycontrol\TaskController@detail')->name('qualitycontrolpanel.task.detail');
        
        Route::post('/update', 'Qualitycontrol\TaskController@update')->name('qualitycontrolpanel.task.update');
        Route::get('/{id}/delete', 'Qualitycontrol\TaskController@delete')->name('qualitycontrolpanel.task.delete')->middleware('permission:task-delete');
        Route::get('/datatable', 'Qualitycontrol\TaskController@get_task_forms')->name('qualitycontrolpanel.task.datatable');
        Route::get('/pending-datatable', 'Qualitycontrol\TaskController@get_task_pending_forms')->name('qualitycontrolpanel.task.pending.datatable');
        Route::get('/completed-datatable', 'Qualitycontrol\TaskController@get_task_completed_forms')->name('qualitycontrolpanel.task.completed.datatable');
        Route::get('/cancel-datatable', 'Qualitycontrol\TaskController@get_task_cancel_forms')->name('qualitycontrolpanel.task.cancel.datatable');
        Route::get('/assigned-datatable', 'Qualitycontrol\TaskController@get_task_AssignFrom')->name('qualitycontrolpanel.taskAssigned.datatable');
        Route::get('/future-datatable', 'Qualitycontrol\TaskController@get_task_Future_forms')->name('qualitycontrolpanel.task.future.datatable');
        
         Route::post('/get-users-by-role', 'Qualitycontrol\TaskController@getUserRolewise')->name('qualitycontrolpanel.task.getUserRolewise');
         Route::get('/get-student-by-group', 'Qualitycontrol\TaskController@getStudentBygroup')->name('qualitycontrolpanel.task.getStudentBygroup');
         Route::get('/get-student-by-teacher', 'Qualitycontrol\TaskController@getStudentByteacher')->name('qualitycontrolpanel.task.getStudentByteacher');
         
         
         
          Route::post('/comment/add', 'Qualitycontrol\TaskController@comment_add')->name('qualitycontrolpanel.task.comment');
          Route::get('/comment/datatable', 'Qualitycontrol\TaskController@get_comment_forms')->name('qualitycontrolpanel.task.comment.datatable');
          
          
          Route::post('status-change','Qualitycontrol\TaskController@task_status_change')->name('qualitycontrolpanel.task.status.change');
          
          Route::post('status-change-detail','Qualitycontrol\TaskController@task_status_change_detail')->name('qualitycontrolpanel.task.status.detail.change');
          
          
           Route::get('total-user-task-assigner-','Qualitycontrol\TaskController@get_task_users_assign')->name('qualitycontrolpanel.task.AssignUsers');
           
           
           Route::post('user-task-ReAssign-user','Qualitycontrol\TaskController@Save_task_users_Reassign')->name('qualitycontrolpanel.task.ReAssignuser.store');
           
           
           Route::post('user-task-extendDate','Qualitycontrol\TaskController@Save_task_extendate')->name('qualitycontrolpanel.task.extendDate.store');
           
           
           
          
          
          
         
         
    });
    
       Route::prefix('student')->group(function () {
        Route::get('/', 'Qualitycontrol\StudentController@index')->name('qualitycontrolpanel.student.index');
        Route::get('/create', 'Qualitycontrol\StudentController@create')->name('qualitycontrolpanel.student.create');
        Route::post('/store', 'Admin\StudentController@store')->name('qualitycontrolpanel.student.store');
        Route::get('/new', 'Qualitycontrol\StudentController@NewForm')->name('qualitycontrolpanel.student.new');
        Route::get('/schdule-demo', 'Qualitycontrol\StudentController@SchduleForm')->name('qualitycontrolpanel.student.schduledemo');
        Route::get('/trailstarted', 'Qualitycontrol\StudentController@TrailStartedForm')->name('qualitycontrolpanel.student.trailstarted');
        Route::get('/trailcompleted', 'Qualitycontrol\StudentController@TrailCompletedForm')->name('qualitycontrolpanel.student.trailcompleted');
        Route::get('/schdule-student-datatable', 'Qualitycontrol\StudentController@get_student_schdule_forms')->name('qualitycontrolpanel.student.schdule.datatable');
        Route::get('/new-student-datatable', 'Qualitycontrol\StudentController@get_new_student_forms')->name('qualitycontrolpanel.student.newFormdatatable');
        Route::get('/schdule-demo-student-datatable', 'Qualitycontrol\StudentController@get_demo_schdule_student_forms')->name('qualitycontrolpanel.student.demoScduledatatablenew');
        Route::get('/student-trail-started-datatable', 'Qualitycontrol\StudentController@get_trailstarted_forms')->name('qualitycontrolpanel.student.trail.started.datatable');
        Route::get('/student-trail-completed-datatable', 'Qualitycontrol\StudentController@get_trailcompleted_forms')->name('qualitycontrolpanel.student.trail.completed.datatable');
        Route::get('/timeconversion', 'Qualitycontrol\StudentController@timeconversion')->name('qualitycontrolpanel.student.timeconversion');
        Route::post('/schdule/save', 'Qualitycontrol\StudentController@studentSchdulesave')->name('qualitycontrolpanel.student.demo.schdule.save');
        Route::post('/search/time','Qualitycontrol\TeacherController@searchFreeTimefunc')->name('qualitycontrolpanel.teacher.search');
        
        Route::get('/booked-time','Qualitycontrol\StudentController@booktimeteacher')->name('qualitycontrolpanel.teacher.booked-time');
        Route::get('/booked-time/{id}','Qualitycontrol\StudentController@booktimeteacherbystudent')->name('qualitycontrolpanel.teacher.booked-time-student');
        Route::post('/booked-time-save','Qualitycontrol\StudentController@booktimeteachersave')->name('qualitycontrolpanel.teacher.booked-time.save');
        
        Route::get('/{id}/edit', 'Qualitycontrol\StudentController@edit')->name('qualitycontrolpanel.student.editnewform');
        //  Route::get('/{id}/editnewform', 'Qualitycontrol\StudentController@editnewform')->name('qualitycontrolpanel.student.editnewform');
        Route::post('/update','Qualitycontrol\StudentController@update')->name('qualitycontrolpanel.student.update');
        Route::post('/updatenewform','Qualitycontrol\StudentController@updatenewform')->name('qualitycontrolpanel.student.updatenewform');
        Route::get('/student-datatable', 'Qualitycontrol\StudentController@get_student_forms')->name('qualitycontrolpanel.student.datatable');
        
         Route::get('/lesson-student-datatable', 'Qualitycontrol\LessonController@get_lesson_forms')->name('qualitycontrolpanel.student.lesson.lessondatatable');
         Route::post('/leesson/store', 'Qualitycontrol\LessonController@save')->name('qualitycontrolpanel.student.lesson.save');
        Route::get('/leesson/{id}/edit', 'Qualitycontrol\LessonController@edit')->name('qualitycontrolpanel.student.lesson.edit');
        Route::get('/leesson/{id}/latest', 'Qualitycontrol\LessonController@getlastlesson')->name('qualitycontrolpanel.student.lesson.getlastlesson');
        
        Route::get('/student/detail/{id}', 'Qualitycontrol\StudentController@getStudentDetail')->name('qualitycontrolpanel.student.detail');
        
        Route::get('/test/list', 'Qualitycontrol\StudentController@StudentTest')->name('qualitycontrolpanel.student.test.list');
        Route::get('/test/list-datatable', 'Qualitycontrol\StudentController@get_test_student_forms')->name('qualitycontrolpanel.student.test.list.datatable');
        Route::get('/test/list-3months-datatable', 'Qualitycontrol\StudentController@get_test_student_forms_3months')->name('qualitycontrolpanel.student.test.list.3months.datatable');
        Route::get('/test/{id}', 'Qualitycontrol\StudentController@StudentTestAttend')->name('qualitycontrolpanel.student.test.attend');
        Route::post('/test/save', 'Qualitycontrol\StudentController@StudentTestSave')->name('qualitycontrolpanel.student.test.save');
        Route::get('/test/save/view', 'Qualitycontrol\StudentController@studentReportResult')->name('qualitycontrolpanel.student.test.save.view');
        Route::get('/test/save/view-datatable', 'Qualitycontrol\StudentController@get_test_student_save')->name('qualitycontrolpanel.student.test.save.view.datatable');
        
        Route::get('/test/report/edit/{id}', 'Qualitycontrol\StudentController@StudentTestAttendreportedit')->name('qualitycontrolpanel.student.test.attend.report.edit');
        
        Route::get('/datattable/get-student-all-classess', 'Qualitycontrol\StudentController@get_all_classes')->name('qualitycontrolpanel.student.classess.all');
        
        Route::post('/send-notification-teacher-test','Qualitycontrol\StudentController@sendTestNotificationTeacher')->name('qualitycontrolpanel.student.notification.teacher.test');
        
        
        Route::get('/report-comment-history-datatable', 'Qualitycontrol\StudentController@getStudentReportCommentsforms')->name('qualitycontrolpanel.report.student.comment.datatable.test');
        
        Route::post('/report/comments/save', 'Qualitycontrol\StudentController@saveReportStudentCommentForm')->name('qualitycontrolpanel.student.report.comment.save.test');
        
        
    });    
    
    
     Route::prefix('teacher')->group(function () {
        Route::get('/student/schedule','Qualitycontrol\TeacherController@schduleCalender')->name('qualitycontrolpanel.teacher.student.weekly.schedule');
        Route::get('/student/calender/schedule/{id}','Qualitycontrol\TeacherController@schduleCalenderNewbyID')->name('qualitycontrolpanel.teacher.student.weekly.schedule.calender');
       });
    
    Route::prefix('spotcheck')->group(function () {
    Route::get('/', 'Qualitycontrol\SpotcheckController@index')->name('qualitycontrolpanel.spotcheck.index');
    Route::get('/create', 'Qualitycontrol\SpotcheckController@create')->name('qualitycontrolpanel.spotcheck.create');
    Route::post('/store', 'Qualitycontrol\SpotcheckController@store')->name('qualitycontrolpanel.spotcheck.store');
    Route::get('/{id}/edit', 'Qualitycontrol\SpotcheckController@edit')->name('qualitycontrolpanel.spotcheck.edit');
    Route::post('/update', 'Qualitycontrol\SpotcheckController@update')->name('qualitycontrolpanel.spotcheck.update');
    Route::get('/datatable', 'Qualitycontrol\SpotcheckController@get_spotcheck_forms')->name('qualitycontrolpanel.spotcheck.get_spotcheck_forms');
    Route::get('/detail/{id}', 'Qualitycontrol\SpotcheckController@get_spotcheck_detail')->name('qualitycontrolpanel.spotcheck.detail');
    Route::get('/get-student-by-teacher', 'Qualitycontrol\SpotcheckController@getStudentByteacher')->name('qualitycontrolpanel.spotcheck.getStudentByteacher');
});

       
    
 });

?>