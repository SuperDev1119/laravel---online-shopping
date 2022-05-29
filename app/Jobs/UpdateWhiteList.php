<?php

namespace App\Jobs;

use App\Models\Brand;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateWhiteList implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $brand;

    public $timeout = 36000;

    public function __construct(Brand $brand)
    {
        $this->brand = $brand;
    }

    public function handle()
    {
        \Artisan::call('update:white_lists', [
            'brands' => [$this->brand->slug],
        ]);
    }
}
