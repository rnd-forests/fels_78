<?php

namespace FELS\Console\Commands;

use DB;
use Illuminate\Console\Command;
use FELS\Core\Repository\Contracts\LessonRepository;

class RejectUnprocessedLessons extends Command
{
    protected $lessons;
    protected $signature = 'fels:reject-unprocessed-lessons';
    protected $description = 'Reject unprocessed lessons from users.';

    public function __construct(LessonRepository $lessons)
    {
        $this->lessons = $lessons;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        DB::transaction(function () {
            $this->lessons->destroyAll(
                $this->lessons->fetchUnprocessedLessons()->lists('id')->toArray()
            );
        });

        $this->info('All unprocessed lessons have been rejected!');
    }
}
