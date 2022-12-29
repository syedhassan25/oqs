<?php 

 Route::group(['prefix' => 'reporter', 'middleware' => ['auth','role:reporter']], function () {
       Route::get('/', 'Reporter\DashboardController@index');
       Route::get('/dashboard', 'Reporter\DashboardController@index')->name('reporter.dasboard.index');
       Route::prefix('student')->group(function () {
       Route::get('/', 'Reporter\StudentController@index')->name('reporter.student.index');
       Route::get('/student-datatable', 'Reporter\StudentController@get_student_forms')->name('reporter.student.studentdatatablenew');
       Route::post('/comments/save', 'Reporter\StudentController@saveStudentCommentForm')->name('reporter.student.new.comment.save');
       Route::get('/student-new-comments-datatable', 'Reporter\StudentController@getStudentCommentsforms')->name('reporter.student.new.comment.datatable');
    });    
       
    
 });

?>