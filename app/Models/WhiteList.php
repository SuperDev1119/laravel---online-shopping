<?php

namespace App\Models;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Color;
use App\Models\Gender;
use Cache;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;
use Log;

class WhiteList extends Model
{
	use Cachable;

	const MINIMUM_REQUIRED_PRODUCTS = 15;

	const CACHING_TIME_ALL = 14400; // 60*24*10 ( 10 days )

	const REASON_NOT_MAIN_PAGE = 'Not main page';
	const REASON_NO_PRODUCTS = 'No products';
	const REASON_HAS_PRODUCTS = 'Has products';
	const REASON_IS_WHITELISTED = 'Is WhiteListed (assuming has products)';
	const REASON_ALWAYS_INDEX_FACET = 'Always index facet pages';
	const REASON_NOT_ENOUGH_PRODUCTS = 'Not enough products - should not be whitelisted';

	public $guarded = [];

	private static $white_lists_by_brand = [];

	public function colors()
	{
		return $this->belongsToMany(\App\Models\Color::class)
			->withPivot('amount')
			->withTimestamps();
	}

	public function __toString()
	{
		return $this->toString();
	}

	public function toString($color = null)
	{
		$gender = (Gender::GENDER_BOTH == $this->gender) ? '' : ucfirst($this->gender);
		return trim("{$this->category} {$this->brand} $color $gender");
	}

	public function getRoute($attrs = [])
	{
		$gender = $this->gender;

		return get_magic_route(array_merge([
			'gender' => $gender,
			'category' => $this->category,
			'brand' => $this->brand,
		], $attrs));
	}

	public function brand()
	{
		return $this->belongsTo(\App\Models\Brand::class);
	}

	public function category()
	{
		return $this->belongsTo(\App\Models\Category::class);
	}

	public function isWhiteListed($color_slug = null)
	{
		if(empty($color_slug))
			return true;

		$color = Color::where('name', $color_slug)->first();
		return $this->colors->contains($color);
	}

	private static function prepareForThisBrand(Brand $brand)
	{
		if (! isset(self::$white_lists_by_brand[$brand->slug])) {
			Log::info("Preparing white_lists (brand: $brand)");

			self::$white_lists_by_brand[$brand->slug] = Cache::remember("white-lists_by_brand_{$brand->slug}",
				self::CACHING_TIME_ALL,
				function () use ($brand) {
					Log::debug("Fetching white_lists from DB (brand: $brand)");

					$items = [];
					foreach (self::where('brand_id', $brand->id)->with(['category'])->get() as $item) {
						$items[$item->gender][$item->category->slug ?? null] = $item;
					}

					return $items;
				}
			);
		}

		return self::$white_lists_by_brand[$brand->slug];
	}

	public static function getWhiteList($gender, $brand, $category)
	{
		$gender = $gender ?: Gender::GENDER_BOTH;

		$white_lists_for_this_brand = self::prepareForThisBrand($brand);

		$white_list = @$white_lists_for_this_brand[$gender][$category->slug];

		return $white_list;
	}
}
