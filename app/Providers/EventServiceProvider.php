<?php

namespace FELS\Providers;

use FELS\Entities\User;
use FELS\Entities\Word;
use FELS\Entities\Lesson;
use FELS\Entities\Category;
use FELS\Listeners\UserEventListener;
use FELS\Entities\Observers\UserObserver;
use FELS\Entities\Observers\WordObserver;
use FELS\Entities\Observers\LessonObserver;
use FELS\Entities\Observers\CategoryObserver;
use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        //
    ];

    /**
     * The subscriber classes to register.
     *
     * @var array
     */
    protected $subscribe = [
        UserEventListener::class,
    ];

    /**
     * Register any other events for your application.
     *
     * @param  \Illuminate\Contracts\Events\Dispatcher $events
     * @return void
     */
    public function boot(DispatcherContract $events)
    {
        parent::boot($events);

        User::observe(new UserObserver);
        Word::observe(new WordObserver);
        Lesson::observe(new LessonObserver);
        Category::observe(new CategoryObserver);
    }
}
