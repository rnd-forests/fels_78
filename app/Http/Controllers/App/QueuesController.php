<?php

namespace FELS\Http\Controllers\App;

use Queue;
use FELS\Http\Controllers\Controller;

class QueuesController extends Controller
{
    /**
     * Subscribe for all queued jobs.
     *
     * @return mixed
     */
    public function subscribe()
    {
        return Queue::marshal();
    }
}
