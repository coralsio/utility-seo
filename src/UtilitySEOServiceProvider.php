<?php

namespace Corals\Modules\Utility\SEO;

use Corals\Modules\Utility\SEO\Facades\SEOItems;
use Corals\Modules\Utility\SEO\Models\SEOItem;
use Corals\Modules\Utility\SEO\Providers\UtilityAuthServiceProvider;
use Corals\Modules\Utility\SEO\Providers\UtilityRouteServiceProvider;
use Corals\Settings\Facades\Modules;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

class UtilitySEOServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/resources/views', 'utility-seo');
        $this->loadTranslationsFrom(__DIR__ . '/resources/lang', 'utility-seo');

        $this->mergeConfigFrom(
            __DIR__ . '/config/utility-seo.php',
            'utility-seo'
        );
        $this->publishes([
            __DIR__ . '/config/utility-seo.php' => config_path('utility-seo.php'),
            __DIR__ . '/resources/views' => resource_path('resources/views/vendor/utility-seo'),
        ]);

        $this->registerMorphMaps();
        $this->registerModulesPackages();
    }

    public function register()
    {
        $this->app->register(UtilityAuthServiceProvider::class);
        $this->app->register(UtilityRouteServiceProvider::class);

        $this->app->booted(function () {
            $loader = AliasLoader::getInstance();
            $loader->alias('SEOItems', SEOItems::class);
        });
    }

    protected function registerMorphMaps()
    {
        Relation::morphMap([
            'UtilitySEOItem' => SEOItem::class,
        ]);
    }

    protected function registerModulesPackages()
    {
        Modules::addModulesPackages('corals/utility-seo');
    }
}
