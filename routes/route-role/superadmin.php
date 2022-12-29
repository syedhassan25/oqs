<?php 


Route::group(['prefix' => 'super-admin', 'middleware' => ['auth','role:super-admin']], function () {

    Route::get('/', 'Admin\DashboardController@index');
    Route::get('/dashboard', 'Admin\DashboardController@index')->name('dashboard');
    
    Route::post('/dashboard-stats-status-history', 'Admin\DashboardController@getDashboardStats')->name('admin.dasboard.stats.status.history');
    
    Route::resource('roles', 'Admin\RoleController');
    Route::get('/users/users-datatable', 'Admin\UserController@get_user_forms');

    

    Route::resource('users', 'Admin\UserController');
    Route::prefix('parent')->group(function () {
        Route::get('/', 'Admin\ParentsController@index')->name('admin.parent.index');
        Route::get('/{id}/edit', 'Admin\ParentsController@edit')->name('admin.parent.edit');
        Route::get('/parent-datatable', 'Admin\ParentsController@get_par_forms')->name('admin.parent.datatable');
        Route::post('/update','Admin\ParentsController@update')->name('admin.parent.update');
    });

    Route::prefix('employee')->group(function () {
        Route::get('/', 'Admin\EmployeesController@index')->name('admin.employee.index');
        Route::get('/{id}/edit', 'Admin\EmployeesController@edit')->name('admin.employee.edit');
        Route::get('/employee-datatable', 'Admin\EmployeesController@get_emp_forms')->name('admin.employee.datatable');
    });
    

    Route::prefix('teacher')->group(function () {
        Route::get('/', 'Admin\TeacherController@index')->name('admin.teacher.index');
        Route::get('/create', 'Admin\TeacherController@create')->name('admin.teacher.create');
        Route::get('/{id}/edit', 'Admin\TeacherController@edit')->name('admin.teacher.edit');
        Route::get('/employee-datatable', 'Admin\TeacherController@get_emp_forms')->name('admin.teacher.datatable');
        Route::post('/update','Admin\TeacherController@update')->name('admin.teacher.update');
        Route::post('/store','Admin\TeacherController@store')->name('admin.teacher.store');
        

        
        Route::get('/student-teacher-datatable','Admin\TeacherController@get_students_by_teacher_forms')->name('admin.teacher.students');
        Route::get('/past-student-teacher-datattable','Admin\TeacherController@get_past_students_by_teacher_forms')->name('admin.teacher.students.past');
        Route::get('/student-teacher-feedback-datattable','Admin\TeacherController@get_student_feedback_forms')->name('admin.teacher.allstudents.feedback');
        

        Route::get('/freeTimeSearch/{id}','Admin\TeacherController@GetTimeByteachers');
        Route::post('/search/time','Admin\TeacherController@searchFreeTimefunc')->name('admin.teacher.search');
        
        
        
        Route::get('/student/schedule','Admin\TeacherController@schduleCalender')->name('admin.teacher.student.weekly.schedule');
        Route::get('/student/calender/schedule/{id}','Admin\TeacherController@schduleCalenderNewbyID')->name('admin.teacher.student.weekly.schedule.calender');
        // Route::get('/student/calender/schedule/{id}','Admin\TeacherController@LoadscduleCalenderByTeacher')->name('admin.teacher.student.weekly.schedule.calender');
        
        
        Route::post('/group/get-teacher','Admin\TeacherController@getteacherbyGroup')->name('admin.teacher.group.get.teacher.data');
        
        
         Route::get('/student/transfer/history','Admin\TeacherController@studentTransferhistory')->name('admin.teacher.student.transfer.history');
         Route::get('/student/transfer/historyforms','Admin\TeacherController@studentTransferhistory_forms')->name('admin.teacher.student.transfer.history.forms');
         
         
         
         
         Route::get('/attendance-add', 'Admin\TeacherController@createattendance')->name('admin.teacher.create.attendance');
        Route::post('/attendance-save', 'Admin\TeacherController@saveattendance')->name('admin.teacher.save.attendance');
         Route::post('/attendance-update-save', 'Admin\TeacherController@updateaAttendance')->name('admin.teacher.update.status.attendance');
        Route::get('/attendance-list', 'Admin\TeacherController@attendancelist')->name('admin.teacher.create.attendance.list');
        Route::get('/attendance-datatable', 'Admin\TeacherController@get_emp_attendance_forms')->name('admin.teacher.attendance.datatable');
        
         Route::post('/attendance-generate', 'Admin\StudentController@generateAttendance')->name('admin.teacher.generate.attendance');
         Route::post('/attendance-delete-all-today', 'Admin\StudentController@DeleteGenerateAttendance')->name('admin.teacher.delete.today.attendance');
        

    });



    Route::prefix('student')->group(function () {
        Route::get('/', 'Admin\StudentController@index')->name('admin.student.index');
        
        Route::get('/status/{status}', 'Admin\StudentController@index')->name('admin.student.index.status');
        Route::get('/create', 'Admin\StudentController@create')->name('admin.student.create');
        Route::post('/storefullform', 'Admin\StudentController@storefullform')->name('admin.student.storefullform');
        Route::get('/new', 'Admin\StudentController@NewForm')->name('admin.student.new');
        Route::get('/schdule', 'Admin\StudentController@SchduleForm')->name('admin.student.schdule');
        Route::get('/trailpending', 'Admin\StudentController@TrailPendingForm')->name('admin.student.trailpending');
        Route::get('/trailstarted', 'Admin\StudentController@TrailStartedForm')->name('admin.student.trailstarted');
        Route::get('/trailcompleted', 'Admin\StudentController@TrailCompletedForm')->name('admin.student.trailcompleted');


        Route::get('/student/detail/{id}', 'Admin\StudentController@getStudentDetail')->name('admin.student.detail');
        Route::get('/teacher/schdule', 'Admin\StudentController@TeacherSchduleForm')->name('admin.student.teacher.schdule');
        Route::post('/schdule/save', 'Admin\StudentController@studentSchdulesave')->name('admin.student.demo.schdule.save');
        Route::post('/meeting/schdule/save', 'Admin\StudentController@studentMeetingSchdulesave')->name('admin.student.meeting.schdule.save');
        Route::post('/store', 'Admin\StudentController@store')->name('admin.student.store');
        Route::get('/{id}/edit', 'Admin\StudentController@edit')->name('admin.student.edit');
        Route::get('/{id}/editnewform', 'Admin\StudentController@editnewform')->name('admin.student.editnewform');
        Route::post('/update','Admin\StudentController@update')->name('admin.student.update');
        Route::post('/updatenewform','Admin\StudentController@updatenewform')->name('admin.student.updatenewform');
        
        Route::get('/student-datatable', 'Admin\StudentController@get_student_forms')->name('admin.student.datatable');
        Route::get('/schdule-student-datatable', 'Admin\StudentController@get_student_schdule_forms')->name('admin.student.schdule.datatable');
        Route::get('/new-student-datatable', 'Admin\StudentController@get_new_student_forms')->name('admin.student.newFormdatatable');
        Route::get('/schdule-demo-student-datatable', 'Admin\StudentController@get_demo_schdule_student_forms')->name('admin.student.demoScduledatatablenew');
        Route::get('/schdule-meeting-student-datatable', 'Admin\StudentController@get_meeting_schdule_student_forms')->name('admin.student.meetingScduledatatable');
        Route::get('/assign-teacher-student-datatable', 'Admin\StudentController@get_assingnteacher_forms')->name('admin.student.assign.teacher.datatable');
        Route::get('/student-trail-pending-datatable', 'Admin\StudentController@get_trailPending_forms')->name('admin.student.trail.pending.datatable');
        Route::get('/student-trail-started-datatable', 'Admin\StudentController@get_trailstarted_forms')->name('admin.student.trail.started.datatable');
        Route::get('/student-trail-completed-datatable', 'Admin\StudentController@get_trailcompleted_forms')->name('admin.student.trail.completed.datatable');
        
        
        Route::post('/schdule-group-search', 'Admin\StudentController@get_student_by_group')->name('student.group.search');
        Route::get('/lesson-student-datatable', 'Admin\LessonController@get_lesson_forms')->name('admin.student.lesson.lessondatatable');
        Route::post('/leesson/store', 'Admin\LessonController@save')->name('admin.student.lesson.save');
        Route::get('/leesson/{id}/edit', 'Admin\LessonController@edit')->name('admin.student.lesson.edit');
        Route::get('/leesson/{id}/latest', 'Admin\LessonController@getlastlesson')->name('admin.student.lesson.getlastlesson');
        
        
        Route::get('/teacher-feedback-datatable', 'Admin\StudentController@get_student_feedback_forms')->name('admin.student.teacher.feedbackdatatable');
       
        Route::post('/academic/status/save', 'Admin\StudentController@AcademicStatusSave')->name('admin.student.academicstatus');
        Route::post('/billing/status/save', 'Admin\StudentController@BillingStatusSave')->name('admin.student.billingstatus');
        Route::post('/teacher/feedback/save', 'Admin\StudentController@teacherFeedbackSave')->name('admin.student.teacher.feedback');


        Route::get('/acdemic-history-datatable', 'Admin\StudentController@acdemichistoryDatatable')->name('admin.student.teacher.acdemichistoryDatatable');
        Route::get('/teacher-change-history-datatable', 'Admin\StudentController@teacherchangehistoryDatatable')->name('admin.student.teacher.teacherchangehistoryDatatable');
        
        
        Route::post('/teacher/recovery/class', 'Admin\StudentController@setStudentRecoveryclass')->name('admin.teacher.student.recovery.attendance');
        
        Route::post('/teacher/recovery/class/schdule', 'Admin\StudentController@SchduleStudentRecoveryclass')->name('admin.student.recovery.class.schdule.save');
        
        
        
          Route::get('/classes/monitoring', 'Admin\StudentController@Classmonitoring')->name('admin.student.monitoring');
          Route::get('/today-classes-datatable', 'Admin\StudentController@get_today_classes')->name('admin.student.todayclasses.datatable');
          
          Route::get('/classes/attendance/history', 'Admin\StudentController@GetAttendanceHistory')->name('admin.student.getattendancehistory');
          
          Route::get('/classes/attendance', 'Admin\StudentController@Classallmonitoring')->name('admin.student.classall.monitoring');
          Route::get('/classes-attendance-datatable', 'Admin\StudentController@get_all_classes')->name('admin.student.classall.attendance.datatable');
          Route::get('/by-student/classes-attendance-datatable//{id}', 'Admin\StudentController@get_all_classes_bystudent')->name('admin.student.bystudent.attendance.datatable');
          
          
          Route::post('/relica-create', 'Admin\StudentController@storeReplicaform')->name('admin.student.relica.create');
          
          
           Route::get('/academic-stats-status-history-by-date/{status}/{startdate}/{enddate}', 'Admin\StudentController@AcademichistorystatsBydate')->name('admin.dasboard.stats.status.history.by.date');
        Route::get('/academic-stats-status-history-by-date-datatable', 'Admin\StudentController@acdemichistoryDatatableforstatsbydate')->name('admin.dasboard.stats.status.history.by.date.datatable');
          
          
          
          
          Route::get('/uploadstudent', 'Admin\StudentController@uploadstudent');
          Route::post('/uploadFile', 'Admin\StudentController@uploadFile_newdata')->name('admin.upload.student.record');
          
          
          
          Route::get('/timeconversion', 'Admin\StudentController@timeconversion')->name('admin.student.timeconversion');
          
          
          
           Route::get('/student-all-task-datatable', 'Admin\TaskController@get_student_task_forms')->name('admin.student.all.task.forms');
           
           
            Route::post('/atttendance/store', 'Admin\StudentController@saveattendance')->name('admin.student.attendance.save');
            Route::post('/atttendance/delete', 'Admin\StudentController@deleteattendance')->name('admin.student.attendance.delete');
            
            
            Route::post('/academic-status/billing-status', 'Admin\StudentController@saveacademicstatusbilling')->name('admin.student.academic-status.billing-status');
            
            Route::post('/comments/save', 'Admin\StudentController@saveStudentCommentForm')->name('admin.student.new.comment.save');
            
            Route::get('/student-new-comments-datatable', 'Admin\StudentController@getStudentCommentsforms')->name('admin.student.new.comment.datatable');
          
    });
    
    
    
     Route::prefix('task')->group(function () {
        Route::get('/', 'Admin\TaskController@index')->name('admin.task.index')->middleware('permission:task-list');
        Route::get('/create', 'Admin\TaskController@create')->name('admin.task.create')->middleware('permission:task-create');
        Route::post('/store', 'Admin\TaskController@store')->name('admin.task.store')->middleware('permission:task-create');
        Route::get('/{id}/edit', 'Admin\TaskController@edit')->name('admin.task.edit')->middleware('permission:task-edit');
        
        Route::get('/{id}/detail', 'Admin\TaskController@detail')->name('admin.task.detail')->middleware('permission:task-edit');
        
        Route::post('/update', 'Admin\TaskController@update')->name('admin.task.update')->middleware('permission:task-edit');
        Route::get('/{id}/delete', 'Admin\TaskController@delete')->name('admin.task.delete')->middleware('permission:task-delete');
        Route::get('/datatable', 'Admin\TaskController@get_task_forms')->name('admin.task.datatable')->middleware('permission:task-list');
        Route::get('/pending-datatable', 'Admin\TaskController@get_task_pending_forms')->name('admin.task.pending.datatable')->middleware('permission:task-list');
        Route::get('/completed-datatable', 'Admin\TaskController@get_task_completed_forms')->name('admin.task.completed.datatable')->middleware('permission:task-list');
        Route::get('/cancel-datatable', 'Admin\TaskController@get_task_cancel_forms')->name('admin.task.cancel.datatable')->middleware('permission:task-list');
        Route::get('/assigned-datatable', 'Admin\TaskController@get_task_AssignFrom')->name('admin.taskAssigned.datatable')->middleware('permission:task-list');
        Route::get('/future-datatable', 'Admin\TaskController@get_task_Future_forms')->name('admin.task.future.datatable')->middleware('permission:task-list');
        
         Route::post('/get-users-by-role', 'Admin\TaskController@getUserRolewise')->name('admin.task.getUserRolewise')->middleware('permission:task-create');
         Route::get('/get-student-by-group', 'Admin\TaskController@getStudentBygroup')->name('admin.task.getStudentBygroup')->middleware('permission:task-create');
         Route::get('/get-student-by-teacher', 'Admin\TaskController@getStudentByteacher')->name('admin.task.getStudentByteacher')->middleware('permission:task-create');
         
         
         
          Route::post('/comment/add', 'Admin\TaskController@comment_add')->name('admin.task.comment')->middleware('permission:task-create');
          Route::get('/comment/datatable', 'Admin\TaskController@get_comment_forms')->name('admin.task.comment.datatable');
          
          
          Route::post('status-change','Admin\TaskController@task_status_change')->name('admin.task.status.change');
          
          Route::post('status-change-detail','Admin\TaskController@task_status_change_detail')->name('admin.task.status.detail.change');
          
          
           Route::get('total-user-task-assigner-','Admin\TaskController@get_task_users_assign')->name('admin.task.AssignUsers');
           
           
           Route::post('user-task-ReAssign-user','Admin\TaskController@Save_task_users_Reassign')->name('admin.task.ReAssignuser.store');
           
           
           Route::post('user-task-extendDate','Admin\TaskController@Save_task_extendate')->name('admin.task.extendDate.store');
           
           
           
          
          
          
         
         
    });
   
  

    Route::prefix('country')->group(function () {
        Route::get('/', 'Admin\CountryController@index')->name('admin.country.index')->middleware('permission:country-list');
        Route::get('/create', 'Admin\CountryController@create')->name('admin.country.create')->middleware('permission:country-create');
        Route::post('/store', 'Admin\CountryController@store')->name('admin.country.store')->middleware('permission:country-create');
        Route::get('/{id}/edit', 'Admin\CountryController@edit')->name('admin.country.edit')->middleware('permission:country-edit');
        Route::post('/update', 'Admin\CountryController@update')->name('admin.country.update')->middleware('permission:country-edit');
        Route::get('/{id}/delete', 'Admin\CountryController@delete')->name('admin.country.delete')->middleware('permission:country-delete');
        Route::get('/datatable', 'Admin\CountryController@get_country_forms')->middleware('permission:country-list');;
    });

    Route::prefix('city')->group(function () {
        Route::get('/', 'Admin\CityController@index')->name('admin.city.index')->middleware('permission:city-list');
        Route::get('/create', 'Admin\CityController@create')->name('admin.city.create')->middleware('permission:city-create');
        Route::post('/store', 'Admin\CityController@store')->name('admin.city.store')->middleware('permission:city-create');
        Route::get('/{id}/edit', 'Admin\CityController@edit')->name('admin.city.edit')->middleware('permission:city-edit');
        Route::post('/update', 'Admin\CityController@update')->name('admin.city.update')->middleware('permission:city-edit');
        Route::get('/{id}/delete', 'Admin\CityController@delete')->name('admin.city.delete')->middleware('permission:city-delete');
        Route::get('/datatable', 'Admin\CityController@get_city_forms')->middleware('permission:city-list');;
    });

    Route::prefix('language')->group(function () {
        Route::get('/', 'Admin\LanguageController@index')->name('admin.language.index')->middleware('permission:language-list');
        Route::get('/create', 'Admin\LanguageController@create')->name('admin.language.create')->middleware('permission:language-create');
        Route::post('/store', 'Admin\LanguageController@store')->name('admin.language.store')->middleware('permission:language-create');
        Route::get('/{id}/edit', 'Admin\LanguageController@edit')->name('admin.language.edit')->middleware('permission:language-edit');
        Route::post('/update', 'Admin\LanguageController@update')->name('admin.language.update')->middleware('permission:language-edit');
        Route::get('/{id}/delete', 'Admin\LanguageController@delete')->name('admin.language.delete')->middleware('permission:language-delete');
        Route::get('/datatable', 'Admin\LanguageController@get_language_forms')->middleware('permission:language-list');;
    });


    Route::prefix('agency')->group(function () {
     Route::get('/', 'Admin\AgencyController@index')->name('admin.agency.index')->middleware('permission:agency-list');
     Route::get('/create', 'Admin\AgencyController@create')->name('admin.agency.create')->middleware('permission:agency-create');
     Route::post('/store', 'Admin\AgencyController@store')->name('admin.agency.store')->middleware('permission:agency-create');
     Route::get('/{id}/edit', 'Admin\AgencyController@edit')->name('admin.agency.edit')->middleware('permission:agency-edit');
     Route::post('/update', 'Admin\AgencyController@update')->name('admin.agency.update')->middleware('permission:agency-edit');
     Route::get('/{id}/delete', 'Admin\AgencyController@delete')->name('admin.agency.delete')->middleware('permission:agency-delete');
     Route::get('/datatable', 'Admin\AgencyController@get_agency_forms')->middleware('permission:agency-list');;
 });


 Route::prefix('skill')->group(function () {
    Route::get('/', 'Admin\SkillController@index')->name('admin.skill.index')->middleware('permission:skill-list');
    Route::get('/create', 'Admin\SkillController@create')->name('admin.skill.create')->middleware('permission:skill-create');
    Route::post('/store', 'Admin\SkillController@store')->name('admin.skill.store')->middleware('permission:skill-create');
    Route::get('/{id}/edit', 'Admin\SkillController@edit')->name('admin.skill.edit')->middleware('permission:skill-edit');
    Route::post('/update', 'Admin\SkillController@update')->name('admin.skill.update')->middleware('permission:skill-edit');
    Route::get('/{id}/delete', 'Admin\SkillController@delete')->name('admin.skill.delete')->middleware('permission:skill-delete');
    Route::get('/datatable', 'Admin\SkillController@get_skill_forms')->middleware('permission:skill-list');;
});



Route::prefix('subject')->group(function () {
    Route::get('/', 'Admin\SubjectController@index')->name('admin.subject.index')->middleware('permission:subject-list');
    Route::get('/create', 'Admin\SubjectController@create')->name('admin.subject.create')->middleware('permission:subject-create');
    Route::post('/store', 'Admin\SubjectController@store')->name('admin.subject.store')->middleware('permission:subject-create');
    Route::get('/{id}/edit', 'Admin\SubjectController@edit')->name('admin.subject.edit')->middleware('permission:subject-edit');
    Route::post('/update', 'Admin\SubjectController@update')->name('admin.subject.update')->middleware('permission:subject-edit');
    Route::get('/{id}/delete', 'Admin\SubjectController@delete')->name('admin.subject.delete')->middleware('permission:subject-delete');
    Route::get('/datatable', 'Admin\SubjectController@get_subject_forms')->middleware('permission:subject-list');;
});
Route::prefix('reason')->group(function () {
    Route::get('/', 'Admin\ReasonController@index')->name('admin.reason.index')->middleware('permission:reason-list');
    Route::get('/create', 'Admin\ReasonController@create')->name('admin.reason.create')->middleware('permission:reason-create');
    Route::post('/store', 'Admin\ReasonController@store')->name('admin.reason.store')->middleware('permission:reason-create');
    Route::post('/storeajax', 'Admin\ReasonController@storeajax')->name('admin.reason.storeajax');
    Route::get('/{id}/edit', 'Admin\ReasonController@edit')->name('admin.reason.edit')->middleware('permission:reason-edit');
    Route::post('/update', 'Admin\ReasonController@update')->name('admin.reason.update')->middleware('permission:reason-edit');
    Route::get('/{id}/delete', 'Admin\ReasonController@delete')->name('admin.reason.delete')->middleware('permission:reason-delete');
    Route::get('/datatable', 'Admin\ReasonController@get_reason_forms')->middleware('permission:reason-list');
});




Route::prefix('ethics')->group(function () {
    Route::get('/', 'Admin\EthicsController@index')->name('admin.ethics.index')->middleware('permission:subject-list');
    Route::get('/create', 'Admin\EthicsController@create')->name('admin.ethics.create')->middleware('permission:subject-create');
    Route::post('/store', 'Admin\EthicsController@store')->name('admin.ethics.store')->middleware('permission:subject-create');
    Route::get('/{id}/edit', 'Admin\EthicsController@edit')->name('admin.ethics.edit')->middleware('permission:subject-edit');
    Route::post('/update', 'Admin\EthicsController@update')->name('admin.ethics.update')->middleware('permission:subject-edit');
    Route::get('/{id}/delete', 'Admin\EthicsController@delete')->name('admin.ethics.delete')->middleware('permission:subject-delete');
    Route::get('/datatable', 'Admin\EthicsController@get_ethics_forms')->name('admin.ethics.ethicsforms')->middleware('permission:subject-list');;
});

Route::prefix('fundamentalislam')->group(function () {
    Route::get('/', 'Admin\FundamentislamController@index')->name('admin.fundamentalislam.index')->middleware('permission:subject-list');
    Route::get('/create', 'Admin\FundamentislamController@create')->name('admin.fundamentalislam.create')->middleware('permission:subject-create');
    Route::post('/store', 'Admin\FundamentislamController@store')->name('admin.fundamentalislam.store')->middleware('permission:subject-create');
    Route::get('/{id}/edit', 'Admin\FundamentislamController@edit')->name('admin.fundamentalislam.edit')->middleware('permission:subject-edit');
    Route::post('/update', 'Admin\FundamentislamController@update')->name('admin.fundamentalislam.update')->middleware('permission:subject-edit');
    Route::get('/{id}/delete', 'Admin\FundamentislamController@delete')->name('admin.fundamentalislam.delete')->middleware('permission:subject-delete');
    Route::get('/datatable', 'Admin\FundamentislamController@get_fundamentalislam_forms')->name('admin.fundamentalislam.fundamentalislamforms')->middleware('permission:subject-list');;
});


Route::prefix('memorization')->group(function () {
    Route::get('/', 'Admin\MemorizationController@index')->name('admin.memorization.index')->middleware('permission:subject-list');
    Route::get('/create', 'Admin\MemorizationController@create')->name('admin.memorization.create')->middleware('permission:subject-create');
    Route::post('/store', 'Admin\MemorizationController@store')->name('admin.memorization.store')->middleware('permission:subject-create');
    Route::get('/{id}/edit', 'Admin\MemorizationController@edit')->name('admin.memorization.edit')->middleware('permission:subject-edit');
    Route::post('/update', 'Admin\MemorizationController@update')->name('admin.memorization.update')->middleware('permission:subject-edit');
    Route::get('/{id}/delete', 'Admin\MemorizationController@delete')->name('admin.memorization.delete')->middleware('permission:subject-delete');
    Route::get('/datatable', 'Admin\MemorizationController@get_Memorization_forms')->name('admin.memorization.memorizationforms')->middleware('permission:subject-list');;
});


Route::prefix('inventory')->group(function () {
    Route::get('/', 'Admin\InventoryController@index')->name('admin.inventory.index');
    Route::get('/create', 'Admin\InventoryController@create')->name('admin.inventory.create');
    Route::post('/store', 'Admin\InventoryController@store')->name('admin.inventory.store');
    Route::get('/{id}/edit', 'Admin\InventoryController@edit')->name('admin.inventory.edit');
    Route::post('/update', 'Admin\InventoryController@update')->name('admin.inventory.update');
    Route::get('/{id}/delete', 'Admin\InventoryController@delete')->name('admin.inventory.delete');
    Route::get('/datatable', 'Admin\InventoryController@get_inventory_forms')->name('admin.inventory.inventoryforms');
    Route::post('/get-users-by-role', 'Admin\InventoryController@getUserRolewise')->name('admin.inventory.getUserRolewise');
});



});




?>