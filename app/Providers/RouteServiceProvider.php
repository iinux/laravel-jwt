<?php

namespace App\Providers;

use Illuminate\Routing\Router;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @param  \Illuminate\Routing\Router $router
     * @return void
     */
    public function boot(Router $router)
    {
        //

        parent::boot($router);
    }

    /**
     * Define the routes for the application.
     *
     * @param  \Illuminate\Routing\Router $router
     * @return void
     */
    public function map(Router $router)
    {
        $this->mapWebRoutes($router);

        //$this->mapApiRoutes($router);
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @param  \Illuminate\Routing\Router $router
     * @return void
     */
    protected function mapWebRoutes(Router $router)
    {
        $router->group([
            'namespace' => $this->namespace,
            'middleware' => 'web',
        ], function ($router) {
            require app_path('Http/routes.php');
        });
    }

    protected function mapWebRoutes2(Router $router)
    {
        $router->group([
            'namespace' => $this->namespace,
        ], function ($router) {
            require app_path('Http/webRoutes.php');

            //开发环境下引入测试路由
            $testRoutesPath = app_path('Http/testRoutes.php');
            if ($this->app->isLocal() && file_exists($testRoutesPath)) {
                require $testRoutesPath;
            }

            //开发环境下引入web页面开发者
            if ($this->app->isLocal()) {
                $this->mapBladeRoutes($router);
            }
        });
    }


    protected function mapBladeRoutes(Router $router)
    {
        $router->get('blade/{sec1?}/{sec2?}/{sec3?}/{sec4?}', 'BladeController@index');
    }

    public function mapApiRoutes(Router $router)
    {
        $router->group([
            'namespace' => $this->namespace . '\API',
            'domain'    => config('domain.web-api'),
            'as'        => 'web-api::'
        ], function ($router) {
            require app_path('Http/apiRoutes.php');
        });
    }
}
