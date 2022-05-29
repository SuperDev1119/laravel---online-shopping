<?php

class Log {
  public static function info($str) {}
}

function config($a)
{
	if (is_array($a)) {
		return;
	}

	$arr = [
		'app.currency' => getenv('CURRENCY'),
		'app.locale' => getenv('LOCALE'),
		'admin.auth' => ['controller' => 'test'],
		'horizon.use' => false,
	];

	if ($v = @$arr[$a]) {
		return $v;
	}
}

if(! function_exists('_i')) {
	function _i($s)
	{
		return $s;
	}
}

class phpunit_helper
{
	public function rememberForever($key, $callback)
	{
		return $callback();
	}
}
