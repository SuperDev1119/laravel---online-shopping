<?php

namespace App\Models\Fetchers;

use Prewk\XmlStringStreamer;

class Xml extends Fetcher
{
    private $streamer;

    private $uniqueNode;

    private $nameSpace = '';

    public function __construct($handle, $opts = [])
    {
        parent::__construct($handle, $opts);

        $this->uniqueNode = @$opts['uniqueNode'];
        $this->nameSpace = @$opts['nameSpace'];

        if ($this->uniqueNode) {
            $this->streamer = XmlStringStreamer::createUniqueNodeParser($handle, [
                'uniqueNode' => $this->uniqueNode,
            ]);
        } else {
            $this->streamer = XmlStringStreamer::createStringWalkerParser($handle);
        }
    }

    public function parse($callback)
    {
        while ($node = $this->streamer->getNode()) {
            try {
                if ($this->nameSpace) {
                    $this->nameSpace = rtrim($this->nameSpace, ':');
                    $node = str_replace("<{$this->nameSpace}:", '<', $node);
                    $node = str_replace("</{$this->nameSpace}:", '</', $node);
                }

                $xml = simplexml_load_string($node,
          'SimpleXMLElement',
          LIBXML_NOCDATA | LIBXML_COMPACT
        );

                $data = static::xml2array($xml);
                $callback($data, $data);
            } catch (\Exception $e) {
                $message = $e->getMessage();

                \Log::error("[-] Could not parse XML ($message)\n".print_r($node, true));
                \Log::debug($e->getTraceAsString());

                app('sentry')->captureException($e);
            }
        }
    }

    public static function xml2array($xmlObject, $out = [])
    {
        foreach ((array) $xmlObject as $index => $node) {
            $out[$index] = is_object($node) ? static::xml2array($node) : $node;
        }

        return array_filter($out);
    }
}
