<?php

namespace App\Console;

use App\Jobs\InvoicesQueuesJob;
use App\Jobs\SendMailTicketJob;
use App\Models\TicketsEmailQueues;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
        $schedule->call(function () {
            TicketsEmailQueues::all()->where('status', '!=', 'sent')->collect()->each(
                function ($ticketEmailQueue) {
                    SendMailTicketJob::dispatch($ticketEmailQueue);
                }
            );
        })->everyMinute();
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
