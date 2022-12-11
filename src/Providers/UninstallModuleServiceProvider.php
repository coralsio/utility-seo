<?php

namespace Corals\Modules\Utility\SEO\Providers;

use Corals\Foundation\Providers\BaseUninstallModuleServiceProvider;
use Corals\Modules\Utility\SEO\database\migrations\CreateSEOItemsTable;
use Corals\Modules\Utility\SEO\database\seeds\UtilitySEODatabaseSeeder;

class UninstallModuleServiceProvider extends BaseUninstallModuleServiceProvider
{
    protected $migrations = [
        CreateSEOItemsTable::class,
    ];

    protected function providerBooted()
    {
        $this->dropSchema();

        $utilitySEODatabaseSeeder = new UtilitySEODatabaseSeeder();

        $utilitySEODatabaseSeeder->rollback();
    }
}
