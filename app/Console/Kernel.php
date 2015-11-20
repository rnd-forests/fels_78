<?php

namespace FELS\Console;

use Illuminate\Console\Scheduling\Schedule;
use FELS\Console\Commands\RejectUnprocessedLessons;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        RejectUnprocessedLessons::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('auth:clear-resets')
            ->weekly()
            ->withoutOverlapping()
            ->environments('production');

        $schedule->command('fels:reject-unprocessed-lessons')
            ->withoutOverlapping()
            ->daily();
    }
}
