<?php

namespace Corals\Modules\Utility\SEO\Providers;

use Corals\Modules\Utility\SEO\Models\SEOItem;
use Corals\Modules\Utility\SEO\Policies\SEOItemPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class UtilityAuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        SEOItem::class => SEOItemPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
    }
}
