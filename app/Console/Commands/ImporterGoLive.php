<?php

namespace App\Console\Commands;

use App\Models\ImportTask;
use Illuminate\Console\Command;

class ImporterGoLive extends Command
{
    protected $signature = 'importer:go_live {new_table} {new_index}';

    protected $description = 'Go Live with specified table and index';

    public function handle()
    {
        (new ImportTask)->go_live(
            $this->argument('new_table'),
            $this->argument('new_index')
        );
    }
}
