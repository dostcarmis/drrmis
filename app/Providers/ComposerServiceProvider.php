<?php

namespace App\Providers;

use Auth, View;
use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('*', function($view){
            $view->with('currentUser', Auth::user());
        });
        
        View::composer('*', 'App\Http\ViewComposers\NotificationComposer');
        
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
