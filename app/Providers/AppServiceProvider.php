<?php

namespace App\Providers;
use App\models\Employee;
use App\models\SchduleStudentdemo;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use DB;
use App\models\FcmNotification;
use Carbon\Carbon;
use Config;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
         $is_time_change_val =  DB::table('time_change_europe')->first()->is_time_change;   //server Time change
         $is_time_change_valStudent =  DB::table('time_change_europe')->first()->is_time_change_student; // All student Time
         
         
         $is_time_change_valEurope =  DB::table('time_change_europe')->first()->time_change_europe;  // All Europe student Time
         $is_time_change_valAmerice =  DB::table('time_change_europe')->first()->time_change_america; // All America student Time
         
         view::share('timeChangeEuropeStatus',$is_time_change_val);
         Config::set('app.timeChangeEuropeStatus', $is_time_change_val);
         
         
         view::share('timeChangeEuropeStatusStudenttime',$is_time_change_valStudent);
         Config::set('app.timeChangeEuropeStatusStudenttime', $is_time_change_valStudent);
         
         view::share('timeChangeEuropeStatusEurope',$is_time_change_valEurope);
         Config::set('app.timeChangeEuropeStatusEurope', $is_time_change_valEurope);
         view::share('timeChangeEuropeStatusAmerica',$is_time_change_valAmerice);
         Config::set('app.timeChangeEuropeStatusAmerica', $is_time_change_valAmerice);
       
          view()->composer('*', function ($view) 
        {
           if (auth()->user()) {
               
               $user = auth()->user();
               
               $noti  = new FcmNotification();
               view::share('FcmNotiAlert',$noti->NumberAlert($user->id));
              
               
          
               
                if ($user->hasRole('teacher')) {
                  $teacher = Employee::where('user_id',auth()->user()->id)->first();
                  
                  $teacherId = $teacher->id;
                  $teachername = $teacher->employeename;
               
               
                  $teacherStudentclassesdata =  DB::table('studentattendance')->select(['studentattendance.*','student.duration','student.studentname'])->leftjoin('student', 'studentattendance.student_id', '=', 'student.id')->where('studentattendance.teacher_id',$teacherId)->whereDate('studentattendance.created_at', Carbon::today())->get();
      
                  $teacherStudentclasses = [];
                  foreach($teacherStudentclassesdata as $index => $val){
                      
                      $teacherStudentclasses[] = $val;
                      
                  }
                  
                  view::share('teacherStudentclassesPanel',$teacherStudentclasses);
                  view::share('teachernamepanel',$teachername);
            
         
        //     View::composer('main.partials.header', function ($view) {
        //     $view->with('services', DB::table('services')->get()); 
              
              
        //   });
         
                }
                
                
                if ($user->hasRole('admin')) {
                 
                    
                    $view->with('totaldemoStudent', 0);
                    $view->with('Employeeheader', 0); 

                        //   View::composer('admin.partials.sidebar', function ($view) {
                              
                        //       $Student = SchduleStudentdemo::select(['studentdemoschdules.id'])
                        //         ->leftjoin('student', 'studentdemoschdules.studentID', '=', 'student.id')
                        //         ->where('step_status', 2)->where('academicStatus', 6)->groupBy('studentdemoschdules.studentID');
                        //       $totaldemoStudent =  $Student->whereDate('studentdemoschdules.schduleDate', Carbon::today())->count();   
                              
                        //      $view->with('totaldemoStudent', $totaldemoStudent); 
                              
                        //   });
                          
                        //    View::composer('admin.partials.header', function ($view) {
                              
                        //      $Employee = Employee::where('employees.role_type', 'teacher')->get();   
                              
                        //      $view->with('Employeeheader', $Employee); 
                              
                        //   });
                    
                }
                
                
            
                
                
            }  
        });
        
    }
}
