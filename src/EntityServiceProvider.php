<?php

namespace GooGee\Entity;

use Illuminate\Support\ServiceProvider;

class EntityServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \Blade::directive('echo', function ($expression) {
            return "<?php echo {$expression}; ?>";
        });

        $this->loadRoutesFrom(__DIR__ . '/routes.php');
        $this->loadViewsFrom(__DIR__ . '/Scaffold/view', 'entity');
        $this->loadViewsFrom(__DIR__ . '/Generator/template', 'template');

        $this->publishes([
            __DIR__ . '/Scaffold/entity.js' => public_path('vendor/entity/js/entity.js'),
        ], 'public');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
