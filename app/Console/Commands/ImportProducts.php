<?php

namespace App\Console\Commands;

use App\Models\ImportTask;
use Illuminate\Console\Command;

class ImportProducts extends Command
{
    protected $signature = 'import:products';

    protected $description = 'Import & Indexes Products from enabled Sources';

    public function handle()
    {
        $import_task = new ImportTask();

        // to avoid created()) callback
        $import_task->finished = true;
        $import_task->save();
        $import_task->finished = false;

        $import_task->run_import();
        $import_task->run_update_brands();
    }
}
