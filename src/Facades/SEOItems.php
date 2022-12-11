<?php

namespace Corals\Modules\Utility\SEO\Facades;
use Illuminate\Support\Facades\Facade;

class SEOItems extends Facade
{

    /**
     * @return mixed
     */
    protected static function getFacadeAccessor()
    {
        return \Corals\Modules\Utility\SEO\Classes\SEOItems::class;
    }

}
