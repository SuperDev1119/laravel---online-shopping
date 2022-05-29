<?php

namespace App\Jobs;

use App\Models\ImportTask;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateBrands implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $import_task;

    public $timeout = 72000;

    public function __construct(ImportTask $import_task)
    {
        $this->import_task = $import_task;
    }

    public function handle()
    {
        $this->import_task->run_update_brands();
    }
}
