<?php

namespace App\Services\UpdateSources;

use App\Models\Source;
use stringEncode\Exception;

abstract class BaseSource
{
    protected $requiredEnvParams;

    public function __invoke()
    {
        if (! $this->check_env_params()) {
            return error_log('[-] Cannot update Sources from '.(new \ReflectionClass($this))->getShortName().': missing env variables');
        }

        return $this->update();
    }

    abstract public function update();

    protected function update_source($unique_name, $title, $path, $raw = [], $parameters = [])
    {
        $name = strtolower((new \ReflectionClass($this))->getShortName()).' - '.$unique_name;

        $verb = Source::where('path', $path)->update(['name' => $name]) ? 'Updating' : 'Creating';
        echo "[+] $verb Source:\t'$name': ";

        try {
            $source = Source::updateOrCreate([
                'name' => $name,
            ], array_merge($parameters, [
                'title' => $title,
                'path' => $path,
                'extra' => print_r($raw, true),
            ]));

            echo "done (id: $source->id)\n";

            return $source;
        } catch (\Exception $e) {
            $this->handle__Exception($e, $path);
        }
    }

    private function check_env_params()
    {
        if (empty($this->requiredEnvParams)) {
            throw new Exception('Required env variables are not set');
        }

        foreach ($this->requiredEnvParams as $param) {
            if (empty(env($param))) {
                return false;
            }
        }

        return true;
    }

    protected function handle__Exception($e, $url = null)
    {
        if (\Illuminate\Database\QueryException::class != get_class($e)) {
            throw $e;
        }

        echo $e->getMessage()."\n\n";

        if ($url) {
            echo "Found the same PATH in those Source:\n";
            foreach (Source::where('path', '=', $url) as $source) {
                echo "\t - id: $source->id, name: '$source->name'\n";
            }
            echo "\n\n";
        }
    }
}
