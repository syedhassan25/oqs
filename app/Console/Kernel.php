<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
        Commands\reassignTempTeacher::class,
        Commands\generateStudentAttendance::class,
        Commands\generateStudentAttendance::class,
        Commands\StudentReactivate::class,
        Commands\StudentDemoSchdule::class,
        Commands\StudentTailComplete::class,
        Commands\StudentTeacherDemoSchdule::class,
        Commands\TestReminderCommand::class,
        Commands\InvoiceSchedule::class,
        Commands\BillingCycle::class,
        Commands\DueInvoices::class,
        Commands\generateAttendancetwelveam::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();
        // ->everyFifteenMinutes()
        $schedule->command('student:attendance')->daily();
        
        
        
        //billing cron job end
        
        // $schedule->command('student:invoice')->everyMinute();
        
        // ->between('00:15', '01:00')
        
        
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
