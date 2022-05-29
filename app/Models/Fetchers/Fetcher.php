<?php

namespace App\Models\Fetchers;

abstract class Fetcher
{
    protected $handle;

    public function __construct($handle, $opts = [])
    {
        $this->handle = $handle;
    }

    abstract public function parse($callback);
}
