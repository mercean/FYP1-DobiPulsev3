<?php

namespace App\Filament\Resources\BulkOrderResources.phpResource\Pages;

use App\Filament\Resources\BulkOrderResources.phpResource;
use Filament\Resources\Pages\Page;

class ReportsPage extends Page
{
    protected static string $resource = BulkOrderResources.phpResource::class;

    protected static string $view = 'filament.resources.bulk-order-resources.php-resource.pages.reports-page';
}
