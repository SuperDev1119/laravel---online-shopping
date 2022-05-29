<?php

use App\Libraries\Cloudinary;
use App\Models\Category;
use App\Models\WhiteList;

function remove_accents($string)
{
	if (! preg_match('/[\x80-\xff]/', (string)$string)) {
		return $string;
	}

	$chars = [
		// Decompositions for Latin-1 Supplement
		chr(195).chr(128) => 'A', chr(195).chr(129) => 'A',
		chr(195).chr(130) => 'A', chr(195).chr(131) => 'A',
		chr(195).chr(132) => 'A', chr(195).chr(133) => 'A',
		chr(195).chr(135) => 'C', chr(195).chr(136) => 'E',
		chr(195).chr(137) => 'E', chr(195).chr(138) => 'E',
		chr(195).chr(139) => 'E', chr(195).chr(140) => 'I',
		chr(195).chr(141) => 'I', chr(195).chr(142) => 'I',
		chr(195).chr(143) => 'I', chr(195).chr(145) => 'N',
		chr(195).chr(146) => 'O', chr(195).chr(147) => 'O',
		chr(195).chr(148) => 'O', chr(195).chr(149) => 'O',
		chr(195).chr(150) => 'O', chr(195).chr(153) => 'U',
		chr(195).chr(154) => 'U', chr(195).chr(155) => 'U',
		chr(195).chr(156) => 'U', chr(195).chr(157) => 'Y',
		chr(195).chr(159) => 's', chr(195).chr(160) => 'a',
		chr(195).chr(161) => 'a', chr(195).chr(162) => 'a',
		chr(195).chr(163) => 'a', chr(195).chr(164) => 'a',
		chr(195).chr(165) => 'a', chr(195).chr(167) => 'c',
		chr(195).chr(168) => 'e', chr(195).chr(169) => 'e',
		chr(195).chr(170) => 'e', chr(195).chr(171) => 'e',
		chr(195).chr(172) => 'i', chr(195).chr(173) => 'i',
		chr(195).chr(174) => 'i', chr(195).chr(175) => 'i',
		chr(195).chr(177) => 'n', chr(195).chr(178) => 'o',
		chr(195).chr(179) => 'o', chr(195).chr(180) => 'o',
		chr(195).chr(181) => 'o', chr(195).chr(182) => 'o',
		chr(195).chr(182) => 'o', chr(195).chr(185) => 'u',
		chr(195).chr(186) => 'u', chr(195).chr(187) => 'u',
		chr(195).chr(188) => 'u', chr(195).chr(189) => 'y',
		chr(195).chr(191) => 'y',
		// Decompositions for Latin Extended-A
		chr(196).chr(128) => 'A', chr(196).chr(129) => 'a',
		chr(196).chr(130) => 'A', chr(196).chr(131) => 'a',
		chr(196).chr(132) => 'A', chr(196).chr(133) => 'a',
		chr(196).chr(134) => 'C', chr(196).chr(135) => 'c',
		chr(196).chr(136) => 'C', chr(196).chr(137) => 'c',
		chr(196).chr(138) => 'C', chr(196).chr(139) => 'c',
		chr(196).chr(140) => 'C', chr(196).chr(141) => 'c',
		chr(196).chr(142) => 'D', chr(196).chr(143) => 'd',
		chr(196).chr(144) => 'D', chr(196).chr(145) => 'd',
		chr(196).chr(146) => 'E', chr(196).chr(147) => 'e',
		chr(196).chr(148) => 'E', chr(196).chr(149) => 'e',
		chr(196).chr(150) => 'E', chr(196).chr(151) => 'e',
		chr(196).chr(152) => 'E', chr(196).chr(153) => 'e',
		chr(196).chr(154) => 'E', chr(196).chr(155) => 'e',
		chr(196).chr(156) => 'G', chr(196).chr(157) => 'g',
		chr(196).chr(158) => 'G', chr(196).chr(159) => 'g',
		chr(196).chr(160) => 'G', chr(196).chr(161) => 'g',
		chr(196).chr(162) => 'G', chr(196).chr(163) => 'g',
		chr(196).chr(164) => 'H', chr(196).chr(165) => 'h',
		chr(196).chr(166) => 'H', chr(196).chr(167) => 'h',
		chr(196).chr(168) => 'I', chr(196).chr(169) => 'i',
		chr(196).chr(170) => 'I', chr(196).chr(171) => 'i',
		chr(196).chr(172) => 'I', chr(196).chr(173) => 'i',
		chr(196).chr(174) => 'I', chr(196).chr(175) => 'i',
		chr(196).chr(176) => 'I', chr(196).chr(177) => 'i',
		chr(196).chr(178) => 'IJ', chr(196).chr(179) => 'ij',
		chr(196).chr(180) => 'J', chr(196).chr(181) => 'j',
		chr(196).chr(182) => 'K', chr(196).chr(183) => 'k',
		chr(196).chr(184) => 'k', chr(196).chr(185) => 'L',
		chr(196).chr(186) => 'l', chr(196).chr(187) => 'L',
		chr(196).chr(188) => 'l', chr(196).chr(189) => 'L',
		chr(196).chr(190) => 'l', chr(196).chr(191) => 'L',
		chr(197).chr(128) => 'l', chr(197).chr(129) => 'L',
		chr(197).chr(130) => 'l', chr(197).chr(131) => 'N',
		chr(197).chr(132) => 'n', chr(197).chr(133) => 'N',
		chr(197).chr(134) => 'n', chr(197).chr(135) => 'N',
		chr(197).chr(136) => 'n', chr(197).chr(137) => 'N',
		chr(197).chr(138) => 'n', chr(197).chr(139) => 'N',
		chr(197).chr(140) => 'O', chr(197).chr(141) => 'o',
		chr(197).chr(142) => 'O', chr(197).chr(143) => 'o',
		chr(197).chr(144) => 'O', chr(197).chr(145) => 'o',
		chr(197).chr(146) => 'OE', chr(197).chr(147) => 'oe',
		chr(197).chr(148) => 'R', chr(197).chr(149) => 'r',
		chr(197).chr(150) => 'R', chr(197).chr(151) => 'r',
		chr(197).chr(152) => 'R', chr(197).chr(153) => 'r',
		chr(197).chr(154) => 'S', chr(197).chr(155) => 's',
		chr(197).chr(156) => 'S', chr(197).chr(157) => 's',
		chr(197).chr(158) => 'S', chr(197).chr(159) => 's',
		chr(197).chr(160) => 'S', chr(197).chr(161) => 's',
		chr(197).chr(162) => 'T', chr(197).chr(163) => 't',
		chr(197).chr(164) => 'T', chr(197).chr(165) => 't',
		chr(197).chr(166) => 'T', chr(197).chr(167) => 't',
		chr(197).chr(168) => 'U', chr(197).chr(169) => 'u',
		chr(197).chr(170) => 'U', chr(197).chr(171) => 'u',
		chr(197).chr(172) => 'U', chr(197).chr(173) => 'u',
		chr(197).chr(174) => 'U', chr(197).chr(175) => 'u',
		chr(197).chr(176) => 'U', chr(197).chr(177) => 'u',
		chr(197).chr(178) => 'U', chr(197).chr(179) => 'u',
		chr(197).chr(180) => 'W', chr(197).chr(181) => 'w',
		chr(197).chr(182) => 'Y', chr(197).chr(183) => 'y',
		chr(197).chr(184) => 'Y', chr(197).chr(185) => 'Z',
		chr(197).chr(186) => 'z', chr(197).chr(187) => 'Z',
		chr(197).chr(188) => 'z', chr(197).chr(189) => 'Z',
		chr(197).chr(190) => 'z', chr(197).chr(191) => 's',
	];

	$string = strtr($string, $chars);

	return $string;
}

// Let's fallback to laravel __() function for now
if(! function_exists('_i'))
{
	function _i(string $string, $array = []) {
		if(empty($string))
			return '';

		return vsprintf(__($string), $array);
	}
}

function get_human_readable_url($path) {
	$path = preg_replace('#^'._i('mode').'/#', '', $path);
	$path = preg_replace('#^'._i('marques').'/#', '', $path);
	$path = implode(' ', array_reverse(explode('/', $path)));
	$path = str_replace('-', ' ', $path);
	return $path;
}

function get_categories_as_tree() {
	static $tree = null;

	if(null == $tree)
		$tree = Category::root()->descendants->toTree();

	return $tree;
}

function get_robots_meta_tags($data = [])
{
	if(1 < $data['products_paginated']->resolveCurrentPage()) {
		return [
			'content' => 'NOINDEX,FOLLOW',
			'reason'  => WhiteList::REASON_NOT_MAIN_PAGE,
		];
	}

	if(0 == $data['products']['total']['value']) {
		return [
			'content' => 'NOINDEX,FOLLOW',
			'reason'  => WhiteList::REASON_NO_PRODUCTS,
		];
	}

	if(@$data['white_list']) {
		if($data['white_list']->isWhiteListed(@$data['color'])) {
			return [
				'content' => 'INDEX,FOLLOW',
				'reason'  => WhiteList::REASON_IS_WHITELISTED,
			];
		}
	} else {
		if(@$data['color']) {
			return [
				'content' => 'INDEX,FOLLOW',
				'reason'  => WhiteList::REASON_ALWAYS_INDEX_FACET,
			];
		}
	}

	if(WhiteList::MINIMUM_REQUIRED_PRODUCTS > $data['products']['total']['value']) {
		return [
			'content' => 'NOINDEX,FOLLOW',
			'reason'  => WhiteList::REASON_NOT_ENOUGH_PRODUCTS,
		];
	}

	return [];
}

function base64_asset($filename, $mime_type = 'image/svg+xml')
{
	$data = base64_encode(file_get_contents($filename));

	return 'data:'.$mime_type.';base64,'.$data;
}

function get_random_gif()
{
	return @\App\Models\PushGrid::inRandomOrder()->first()->url;
}

function alt_for_product_image($product)
{
	return $product['name'].' - '.$product['brand_original'].' - '.config('app.site_name');
}

function clean_for_html($text, $allowed_tags = null)
{
	return str_replace([
		'  ',
		' .',
	], [
		' ',
		'.',
	], trim(strip_tags($text, $allowed_tags)));
}

function text_for_seo__count($data)
{
	return max(rand(100, 300), $data['products']['total']['value']);
}

function text_for_seo__price($data)
{
	return max(rand(20, 50), @$data['aggs']['price_min']['value']);
}

function text_for_seo__gender($data)
{
	$gender = @$data['gender'];

	if (\App\Models\Gender::GENDER_BOTH == $gender) {
		$gender = '';
	}

	if (empty($gender)) {
		return;
	}

	return _i('pour %s', ['gender' => ucfirst(_i($gender))]);
}

function text_for_seo__brand($data)
{
	if (! $data['brand']) {
		return;
	}

	$value = $data['brand']->display_name;

	if ($type = $data['brand']->brand_type) {
		$value .= ' ('.$type->name.')';
	}

	return $value;
}

function text_for_seo__category($data, $s = 'produits')
{
	return empty($data['category_title']) ? _i($s) : ucwords($data['category_title']);
}

function get_current_sales_period() {
	static $current_sales_period = null;

	if(null == $current_sales_period) {
		$now = Carbon\Carbon::now();
		$current_sales_period = \App\Models\SalesPeriod::where('starts_at', '<=', $now)->where('ends_at', '>=', $now)->first();
	}

	return $current_sales_period;
}

function get_next_sales_period() {
	static $next_sales_period = null;

	if(null == $next_sales_period) {
		$now = Carbon\Carbon::now();
		$next_sales_period = \App\Models\SalesPeriod::where('starts_at', '>', $now)->first();
	}

	return $next_sales_period;
}

function create_cache_key()
{
	$args = func_get_args();
	$cache_key = '';

	foreach ($args as $key => $value) {
		$cache_key .= $key.$value;
	}

	return $cache_key;
}

function show_product_image($product, $for_grid = false, $retina = false)
{
	$url = $for_grid ? Cloudinary::forGrid($product['image_url'], [
		'retina' => $retina,
		'seo-file-name' => $product['slug'],
	]) : Cloudinary::get($product['image_url'], null, $product['slug']);

	return $url;
}

function show_product_image_for_google($product)
{
	return Cloudinary::get($product['image_url'], 'fit-in/500x500/filters:fill(blur)', $product['slug']);
}

function show_product_opengraph_image($product)
{
	return Cloudinary::get($product['image_url'], 'fit-in/1200x630/filters:fill(blur)', $product['slug']);
}

function is_connection_secure()
{
	return Request::secure()
		|| ('https' === Request::server('HTTP_X_FORWARDED_PROTO'))
		|| ('{"scheme":"https"}' === Request::server('HTTP_CF_VISITOR'));
}

function get_magic_route($params)
{
	$route = '';

	$params = array_filter($params, function ($value, $key) {
		return ! empty($value) && in_array($key, [
			'brand',
			'category',
			'gender',
			'color',

			'promotion',
		]);
	}, ARRAY_FILTER_USE_BOTH);

	$promotion = (! empty($params['promotion']));
	$brand = (! empty($params['brand']));
	$gender = (! empty($params['gender']));
	$category = (! empty($params['category']));
	$color = (! empty($params['color']));

	if ($promotion) {
		$brand = false;
		unset($params['promotion']);
	}
	if ($gender) {
		$params['gender'] = _i($params['gender']);

		if (\App\Models\Gender::GENDER_BOTH() == $params['gender']) {
			$gender = false;
			unset($params['gender']);
		}
	}

	if (isset($params['brand']) && is_object($params['brand'])) {
		$params['brand'] = $params['brand']->slug;
	}

	if (isset($params['category']) && is_object($params['category'])) {
		$params['category'] = $params['category']->slug;
	}

	if (isset($params['color']) && is_object($params['color'])) {
		$params['color'] = $params['color']->name;
	}

	if ($promotion) {
		$route .= '.byPromotion';
	}

	if ($gender) {
		$route .= '.byGender';
	}
	if ($brand) {
		$route .= '.byBrand';
	}
	if ($category) {
		$route .= '.byCategory';
	}
	if ($color) {
		$route .= '.byColor';
	}

	if (empty($route)) {
		$route = '.all_products';
	}

	return route('get.products'.$route, $params);
}

if (! function_exists('mb_ucfirst')) {
	function mb_ucfirst($str)
	{
		$fc = mb_strtoupper(mb_substr($str, 0, 1));

		return $fc.mb_substr($str, 1);
	}
}

if (! function_exists('slugify')) {
		// https://gist.github.com/boffey/8540107
	function slugify($string, $sep = '-')
	{
		// Added by SS
		$paramterized_string = preg_replace('/(^"|"$)/', '', $string);

		// Get rid of anything thats not a valid letter, number, dash and underscore and
		// replace with a dash
		$paramterized_string = preg_replace("/[^a-z0-9\-_]/i", $sep, $string);

		// Remove connected dahses so we don't end up with -- anyhwere.
		$paramterized_string = preg_replace("/$sep{2,}/", $sep, $paramterized_string);

		// Remove any trailing spaces from the string
		$paramterized_string = preg_replace("/^$sep|$sep$/", '', $paramterized_string);

		// Downcase the string
		return mb_strtolower($paramterized_string);
	}
}
