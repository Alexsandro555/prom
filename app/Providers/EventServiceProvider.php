<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\Event' => [
            'App\Listeners\EventListener',
        ],
        'Modules\Files\Events\FileFormatAdded' => [
          'Modules\Files\Listeners\AddFormat'
        ],
        'Modules\Files\Events\FileFormatDeleted' => [
          'Modules\Files\Listeners\DelFormat'
        ],
        'Modules\Files\Events\TypeFilesModdified' => [
          'Modules\Files\Listeners\ResizeImages'
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
