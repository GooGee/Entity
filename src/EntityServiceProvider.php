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
        /**
         * @echo($data)
         * use this directive to avoid conflict with Vue
         */
        \Blade::directive('echo', function ($expression) {
            return "<?php echo {$expression}; ?>";
        });
        /**
         * @brace('vue.data') -> {{vue.data}}
         * if Blade's rawTags is changed, @{{}} will not work
         */
        \Blade::directive('brace', function ($expression) {
            $value = str_replace('\'', '', $expression);
            return "{<?php echo '{" . $value . "}'; ?>}";
        });

        require(__DIR__ . '/routes.php');
        //$this->loadRoutesFrom(__DIR__.'/routes.php');
        $this->loadViewsFrom(__DIR__ . '/Scaffold/view', 'entity');
        $this->loadViewsFrom(__DIR__ . '/Generator/template', 'template');

        $this->publishes([
            __DIR__ . '/Scaffold/css/entity.css' => public_path('css/entity.css'),
            __DIR__ . '/Scaffold/entity.js' => public_path('js/entity.js'),
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
