<?php

namespace App\Models\Fetchers;

use JsonMachine\JsonMachine;

class Json extends Fetcher
{
    private $root = '/products';

    private $products;

    public function __construct($handle, $opts = [])
    {
        parent::__construct($handle, $opts);

        if (! empty($opts['root'])) {
            $this->root = $opts['root'];
        }

        $this->products = JsonMachine::fromStream($this->handle, $this->root);
    }

    public function parse($callback)
    {
        foreach ($this->products as $product) {
            $callback($product, $product);
        }
    }
}
