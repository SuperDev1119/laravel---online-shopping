<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class DisableIndexing extends Command
{
    protected $signature = 'disable-indexing';

    protected $description = 'Disable indexing of the website by rewriting robot.txt';

    public function handle()
    {
        $content = <<<'EOF'
User-agent: *
Disallow: /
EOF;

        if (true === config('app.enable_indexing')) {
            $content = <<<'EOF'
User-agent: *
Disallow: /redirect/
Disallow: /*?page=*
EOF;
            $content .= "\nSitemap: ".route('get.sitemap.index');
        }

        $file = 'public/robots.txt';

        if (false !== file_put_contents($file, $content)) {
            $this->info("'$file' has been overwritten with success.");
        } else {
            $this->error("Error writing into '$file'");
        }
    }
}
