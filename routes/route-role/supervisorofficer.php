<?php 

 Route::group(['prefix' => 'supervisor-officer', 'middleware' => ['auth','role:supervisor-officer']], function () {
       Route::get('/', 'Supervisor\DashboardController@index');
       Route::get('/dashboard', 'Supervisor\DashboardController@index')->name('supervisorpanel.dasboard.index');
       
        Route::prefix('task')->group(function () {
        Route::get('/', 'Supervisor\TaskController@index')->name('supervisorpanel.task.index');
        Route::get('/create', 'Supervisor\TaskController@create')->name('supervisorpanel.task.create');
        Route::post('/store', 'Supervisor\TaskController@store')->name('supervisorpanel.task.store');
        Route::get('/{id}/edit', 'Supervisor\TaskController@edit')->name('supervisorpanel.task.edit');
        
        Route::get('/{id}/detail', 'Supervisor\TaskController@detail')->name('supervisorpanel.task.detail');
        
        Route::post('/update', 'Supervisor\TaskController@update')->name('supervisorpanel.task.update');
        Route::get('/{id}/delete', 'Supervisor\TaskController@delete')->name('supervisorpanel.task.delete')->middleware('permission:task-delete');
        Route::get('/datatable', 'Supervisor\TaskController@get_task_forms')->name('supervisorpanel.task.datatable');
        Route::get('/pending-datatable', 'Supervisor\TaskController@get_task_pending_forms')->name('supervisorpanel.task.pending.datatable');
        Route::get('/completed-datatable', 'Supervisor\TaskController@get_task_completed_forms')->name('supervisorpanel.task.completed.datatable');
        Route::get('/cancel-datatable', 'Supervisor\TaskController@get_task_cancel_forms')->name('supervisorpanel.task.cancel.datatable');
        Route::get('/assigned-datatable', 'Supervisor\TaskController@get_task_AssignFrom')->name('supervisorpanel.taskAssigned.datatable');
        Route::get('/future-datatable', 'Supervisor\TaskController@get_task_Future_forms')->name('supervisorpanel.task.future.datatable');
        
         Route::post('/get-users-by-role', 'Supervisor\TaskController@getUserRolewise')->name('supervisorpanel.task.getUserRolewise');
         Route::get('/get-student-by-group', 'Supervisor\TaskController@getStudentBygroup')->name('supervisorpanel.task.getStudentBygroup');
         Route::get('/get-student-by-teacher', 'Supervisor\TaskController@getStudentByteacher')->name('supervisorpanel.task.getStudentByteacher');
         
         
         
          Route::post('/comment/add', 'Supervisor\TaskController@comment_add')->name('supervisorpanel.task.comment');
          Route::get('/comment/datatable', 'Supervisor\TaskController@get_comment_forms')->name('supervisorpanel.task.comment.datatable');
          
          
          Route::post('status-change','Supervisor\TaskController@task_status_change')->name('supervisorpanel.task.status.change');
          
          Route::post('status-change-detail','Supervisor\TaskController@task_status_change_detail')->name('supervisorpanel.task.status.detail.change');
          
          
           Route::get('total-user-task-assigner-','Supervisor\TaskController@get_task_users_assign')->name('supervisorpanel.task.AssignUsers');
           
           
           Route::post('user-task-ReAssign-user','Supervisor\TaskController@Save_task_users_Reassign')->name('supervisorpanel.task.ReAssignuser.store');
           
           
           Route::post('user-task-extendDate','Supervisor\TaskController@Save_task_extendate')->name('supervisorpanel.task.extendDate.store');
           
           
           
          
          
          
         
         
    });
    
       Route::prefix('student')->group(function () {
        Route::get('/', 'Supervisor\StudentController@index')->name('supervisorpanel.student.index');
        Route::get('/create', 'Supervisor\StudentController@create')->name('supervisorpanel.student.create');
        Route::post('/store', 'Supervisor\StudentController@store')->name('supervisorpanel.student.store');
        Route::get('/new', 'Supervisor\StudentController@NewForm')->name('supervisorpanel.student.new');
           Route::get('/schdule', 'Admin\StudentController@SchduleForm')->name('supervisorpanel.student.schdule');
        Route::get('/schdule-demo', 'Supervisor\StudentController@SchduleForm')->name('supervisorpanel.student.schduledemo');
        Route::get('/trailstarted', 'Supervisor\StudentController@TrailStartedForm')->name('supervisorpanel.student.trailstarted');
        Route::get('/trailcompleted', 'Supervisor\StudentController@TrailCompletedForm')->name('supervisorpanel.student.trailcompleted');
        Route::get('/schdule-student-datatable', 'Supervisor\StudentController@get_student_schdule_forms')->name('supervisorpanel.student.schdule.datatable');
        Route::get('/new-student-datatable', 'Supervisor\StudentController@get_new_student_forms')->name('supervisorpanel.student.newFormdatatable');
        Route::get('/schdule-demo-student-datatable', 'Supervisor\StudentController@get_demo_schdule_student_forms')->name('supervisorpanel.student.demoScduledatatablenew');
        Route::get('/student-trail-started-datatable', 'Supervisor\StudentController@get_trailstarted_forms')->name('supervisorpanel.student.trail.started.datatable');
        Route::get('/student-trail-completed-datatable', 'Supervisor\StudentController@get_trailcompleted_forms')->name('supervisorpanel.student.trail.completed.datatable');
        Route::get('/timeconversion', 'Supervisor\StudentController@timeconversion')->name('supervisorpanel.student.timeconversion');
        Route::post('/schdule/save', 'Supervisor\StudentController@studentSchdulesave')->name('supervisorpanel.student.demo.schdule.save');
        Route::post('/search/time','Supervisor\TeacherController@searchFreeTimefunc')->name('supervisorpanel.teacher.search');
        
        Route::get('/booked-time','Supervisor\StudentController@booktimeteacher')->name('supervisorpanel.teacher.booked-time');
        Route::get('/booked-time/{id}','Supervisor\StudentController@booktimeteacherbystudent')->name('supervisorpanel.teacher.booked-time-student');
        Route::post('/booked-time-save','Supervisor\StudentController@booktimeteachersave')->name('supervisorpanel.teacher.booked-time.save');
        
        Route::get('/{id}/edit', 'Supervisor\StudentController@edit')->name('supervisorpanel.student.edit');
        //  Route::get('/{id}/editnewform', 'Supervisor\StudentController@editnewform')->name('supervisorpanel.student.editnewform');
        Route::post('/update','Supervisor\Demonstration@update')->name('supervisorpanel.student.update');
        Route::post('/updatenewform','Supervisor\StudentController@updatenewform')->name('supervisorpanel.student.updatenewform');
        Route::get('/student-datatable', 'Supervisor\StudentController@get_student_forms')->name('supervisorpanel.student.datatable');
        
         Route::get('/lesson-student-datatable', 'Supervisor\LessonController@get_lesson_forms')->name('supervisorpanel.student.lesson.lessondatatable');
         Route::post('/leesson/store', 'Supervisor\LessonController@save')->name('supervisorpanel.student.lesson.save');
        Route::get('/leesson/{id}/edit', 'Supervisor\LessonController@edit')->name('supervisorpanel.student.lesson.edit');
        Route::get('/leesson/{id}/latest', 'Supervisor\LessonController@getlastlesson')->name('supervisorpanel.student.lesson.getlastlesson');
        
         Route::post('/atttendance/store', 'Supervisor\StudentController@saveattendance')->name('supervisorpanel.student.attendance.save');
            Route::post('/atttendance/delete', 'Supervisor\StudentController@deleteattendance')->name('supervisorpanel.student.attendance.delete');
            
            
            
        Route::get('/classes/monitoring', 'Supervisor\StudentController@Classmonitoring')->name('supervisorpanel.student.monitoring');
          Route::get('/today-classes-datatable', 'Supervisor\StudentController@get_today_classes')->name('supervisorpanel.student.todayclasses.datatable');
          
          Route::get('/classes/attendance', 'Supervisor\StudentController@Classallmonitoring')->name('supervisorpanel.student.classall.monitoring');
          Route::get('/classes-attendance-datatable', 'Supervisor\StudentController@get_all_classes')->name('supervisorpanel.student.classall.attendance.datatable');
          Route::get('/by-student/classes-attendance-datatable//{id}', 'Supervisor\StudentController@get_all_classes_bystudent')->name('supervisorpanel.student.bystudent.attendance.datatable');
        
        
          
    });    
    
    
     Route::prefix('teacher')->group(function () {
        Route::get('/', 'Supervisor\TeacherController@index')->name('supervisorpanel.teacher.index');
        Route::get('/create', 'Supervisor\TeacherController@create')->name('supervisorpanel.teacher.create');
        Route::get('/{id}/edit', 'Supervisor\TeacherController@edit')->name('supervisorpanel.teacher.edit');
        Route::get('/employee-datatable', 'Supervisor\TeacherController@get_emp_forms')->name('supervisorpanel.teacher.datatable');
        Route::post('/update','Supervisor\TeacherController@update')->name('supervisorpanel.teacher.update');
        Route::post('/store','Supervisor\TeacherController@store')->name('supervisorpanel.teacher.store');
        
        Route::get('/attendance', 'Supervisor\TeacherController@createattendance')->name('supervisorpanel.teacher.create.attendance');
        Route::post('/attendance-save', 'Supervisor\TeacherController@saveattendance')->name('supervisorpanel.teacher.save.attendance');
         Route::post('/attendance-update-save', 'Supervisor\TeacherController@updateaAttendance')->name('supervisorpanel.teacher.update.status.attendance');
        Route::get('/attendance-list', 'Supervisor\TeacherController@attendancelist')->name('supervisorpanel.teacher.create.attendance.list');
        Route::get('/attendance-datatable', 'Supervisor\TeacherController@get_emp_attendance_forms')->name('supervisorpanel.teacher.attendance.datatable');
        

        
        Route::get('/student-teacher-datatable','Supervisor\TeacherController@get_students_by_teacher_forms')->name('supervisorpanel.teacher.students');
        Route::get('/past-student-teacher-datattable','Supervisor\TeacherController@get_past_students_by_teacher_forms')->name('supervisorpanel.teacher.students.past');
        Route::get('/student-teacher-feedback-datattable','Supervisor\TeacherController@get_student_feedback_forms')->name('supervisorpanel.teacher.allstudents.feedback');
        

        Route::get('/freeTimeSearch/{id}','Supervisor\TeacherController@GetTimeByteachers');
        Route::post('/search/time','Supervisor\TeacherController@searchFreeTimefunc')->name('supervisorpanel.teacher.search');
        
        
        
        Route::get('/student/schedule','Supervisor\TeacherController@schduleCalender')->name('supervisorpanel.teacher.student.weekly.schedule');
        Route::get('/student/calender/schedule/{id}','Supervisor\TeacherController@schduleCalenderNewbyID')->name('supervisorpanel.teacher.student.weekly.schedule.calender');
        // Route::get('/student/calender/schedule/{id}','Supervisor\TeacherController@LoadscduleCalenderByTeacher')->name('supervisorpanel.teacher.student.weekly.schedule.calender');
        
        
        Route::post('/group/get-teacher','Supervisor\TeacherController@getteacherbyGroup')->name('supervisorpanel.teacher.group.get.teacher.data');
        
        
         Route::get('/student/transfer/history','Supervisor\TeacherController@studentTransferhistory')->name('supervisorpanel.teacher.student.transfer.history');
         Route::get('/student/transfer/historyforms','Supervisor\TeacherController@studentTransferhistory_forms')->name('supervisorpanel.teacher.student.transfer.history.forms');
        

    });
       
    
 });

?>