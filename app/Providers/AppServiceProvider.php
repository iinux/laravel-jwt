<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Monolog\Handler\BrowserConsoleHandler;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
        if ($this->app->environment() !== 'production') {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);

            //日志
            $logger = \Log::getMonolog();
            $logger->pushHandler(new BrowserConsoleHandler());

            //DB事件
            \DB::listen(function($query){
                \Log::info('sql :'.$query->sql , ['binding' => $query->bindings,'time' => $query->time]);
            });
        }
    }
}
