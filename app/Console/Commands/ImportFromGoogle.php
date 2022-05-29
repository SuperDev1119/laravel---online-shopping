<?php

namespace App\Console\Commands;

use App\Models\ModelFromGoogle;
use Illuminate\Console\Command;

class TextRefFromGoogle extends ModelFromGoogle
{
    const CACHING_TIME_ALL = 21600; // 60*24*15 ( 15 days )
    const ENV_NAME_FOR_URL = 'URL_GOOGLE_CSV_TEXTREF';

    public $url = null;
    public $text = null;

    protected static $fields = [
        'url',
        'text',
    ];

    public static $tuple_key = 'url';

    public function __toString() {
        return $this->url;
    }

    public function __construct($values = []) {
        parent::__construct($values);

        $this->url = trim($this->url);
        $this->text = nl2br(trim($this->text));

        if(empty($this->url) || empty($this->text))
            throw new \Exception("'url' and 'text' cannot be empty", 1);

    }

    public static function afterSave() {
        \App\Models\TextRef::whereRaw("text = ''")->delete();
    }
}

class FooterCmsFromGoogle extends ModelFromGoogle
{
    const CACHING_TIME_ALL = 21600; // 60*24*15 ( 15 days )
    const ENV_NAME_FOR_URL = 'URL_GOOGLE_CSV_FOOTERCMS';

    public $url = null;
    public $title = null;
    public $content = null;

    protected static $fields = [
        'url',
        'title',
        'content',
    ];

    public static $tuple_key = 'url';
}

class MenuPanelFromGoogle extends ModelFromGoogle
{
    const CACHING_TIME_ALL = 21600; // 60*24*15 ( 15 days )
    const ENV_NAME_FOR_URL = 'URL_GOOGLE_CSV_MENUPANEL';

    public $gender = null;
    public $category = null;
    public $background = null;
    public $url = null;
    public $title = null;
    public $order = 0;

    protected static $fields = [
        'gender',
        'category',
        'background',
        'url',
        'title',
        'order',
    ];
}

class PushLinkingFromGoogle extends ModelFromGoogle
{
    const CACHING_TIME_ALL = 10080; // 1 week in minutes
    const ENV_NAME_FOR_URL = 'URL_GOOGLE_CSV_PUSH_LINKING';

    public $link = null;
    public $title = null;

    protected static $fields = [
        'link',
        'title',
    ];
}

class ImportFromGoogle extends Command
{
    protected $signature = 'import:from_google {class_from} {class_to}';
    protected $description = '';

    public function handle()
    {
        $class_from = $this->argument('class_from');
        $class_to = $this->argument('class_to');
        $this->import(__NAMESPACE__.'\\'.$class_from, $class_to);
    }

    private function import($class_from, $class_to)
    {
        $all = $class_from::all(true);
        $nb_all = count($all);

        $i = 1;
        foreach ($all as $item) {
            try {
                echo "[$i/$nb_all]\tWorking on item: ".($i++)." ($class_from): ";

                if($key = $class_from::$tuple_key) {
                    $r = $class_to::updateOrCreate([
                        $key => $item->$key,
                    ], (array) $item);
                } else {
                    $r = $class_to::updateOrCreate((array) $item);
                }

                echo "\t$r->id | [$item]\n";
            } catch (\PDOException $e) {
                if (! in_array($e->getCode(), [23505])) {
                    var_dump([
                        $e->getMessage(),
                        $item,
                    ]);
                } else {
                    echo "\n\t[+] Error: " . $e->getMessage() . "\n";
                }

            }
        }

        $class_from::afterSave();
    }
}
