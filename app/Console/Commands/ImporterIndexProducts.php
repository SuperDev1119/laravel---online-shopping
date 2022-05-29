<?php

namespace App\Console\Commands;

use App\Models\ImportTask;
use Illuminate\Console\Command;

class ImporterIndexProducts extends Command
{
    protected $signature = 'importer:index_products {new_product_table}';

    protected $description = 'Indexes Products from DB to ES';

    public function handle()
    {
        global $new_product_table;
        $new_product_table = $this->argument('new_product_table');
        (new ImportTask)->index_products();
    }
}
