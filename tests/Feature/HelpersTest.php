<?php

namespace Tests\Feature;

use Mockery;
use PHPUnit\Framework\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Models\WhiteList;
use Illuminate\Pagination\LengthAwarePaginator;

class FakeBrand extends \App\Models\Brand {
    public function __construct() {}
    public static function boot() {}
}

class HelpersTest extends TestCase
{
    use \Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;

    protected function setUp(): void
    {
        $this->data = [
            'products_paginated' => new LengthAwarePaginator([], 1, 1),
        ];

        $this->setPage(1);

        parent::setUp();
    }

    public function tearDown(): void
    {
        Mockery::close();
    }

    private function getWhiteList($whitelisted) {
        $white_list = false;

        if($whitelisted) {
            $white_list = Mockery::mock(WhiteList::class, function ($mock) {
                $mock->shouldReceive('isWhiteListed')->andReturn(true);
            });
        }

        return $white_list;
    }

    private function setPage($page) {
        LengthAwarePaginator::currentPageResolver(function () use ($page) { return $page; });
    }

    private function weHaveThisAmountOfProducts($amount) {
        $this->data['products'] = ['total' => ['value' => $amount]];
    }
    private function weHaveEnoughProducts($enough_products) {
        $this->weHaveThisAmountOfProducts(
            WhiteList::MINIMUM_REQUIRED_PRODUCTS + ($enough_products ? 1 : -1),
            $this->data
        );
    }

    private function weHaveBrand($is_public)
    {
        $brand = new FakeBrand();
        $brand->in_listing = $is_public;

        $this->data['brand'] = $brand;
    }

    private function weHaveCategory()
    {
        $this->data['category'] = true;
    }

    private function weHaveColor()
    {
        $this->data['color'] = true;
    }

    private function weAreWhiteListed($whitelisted) {
        $this->data['white_list'] = $this->getWhiteList($whitelisted);
    }

    public function test__get_robots_meta_tags__when__on_first_page_with_enough_products()
    {
        $this->setPage(1);
        $this->weHaveEnoughProducts(true);

        $expected_value = [];

        $this->assertEquals(
            $expected_value,
            get_robots_meta_tags($this->data),
        );
    }

    public function test__get_robots_meta_tags__when__on_first_page_without_enough_products()
    {
        $this->setPage(1);
        $this->weHaveEnoughProducts(false);

        $expected_value = [
            'content' => 'NOINDEX,FOLLOW',
            'reason' => WhiteList::REASON_NOT_ENOUGH_PRODUCTS,
        ];

        $this->assertEquals(
            $expected_value,
            get_robots_meta_tags($this->data),
        );
    }

    public function test__get_robots_meta_tags__when__not_on_first_page()
    {
        $this->setPage(2);

        $expected_value = [
            'content' => 'NOINDEX,FOLLOW',
            'reason'  => WhiteList::REASON_NOT_MAIN_PAGE,
        ];

        $this->assertEquals(
            $expected_value,
            get_robots_meta_tags($this->data),
        );
    }

    public function test__get_robots_meta_tags__when__not_enough_products_and_no_facets()
    {
        $this->weHaveEnoughProducts(false);

        $expected_value = [
            'content' => 'NOINDEX,FOLLOW',
            'reason'  => WhiteList::REASON_NOT_ENOUGH_PRODUCTS,
        ];

        $this->assertEquals(
            $expected_value,
            get_robots_meta_tags($this->data),
        );
    }

    public function test__get_robots_meta_tags__when__not_enough_products_but_facet()
    {
        $this->weHaveColor();
        $this->weHaveEnoughProducts(false);

        $expected_value = [
            'content' => 'INDEX,FOLLOW',
            'reason'  => WhiteList::REASON_ALWAYS_INDEX_FACET,
        ];

        $this->assertEquals(
            $expected_value,
            get_robots_meta_tags($this->data),
        );
    }

    public function test__get_robots_meta_tags__when__enough_products_but_facet()
    {
        $this->weHaveColor();
        $this->weHaveEnoughProducts(true);

        $expected_value = [
            'content' => 'INDEX,FOLLOW',
            'reason'  => WhiteList::REASON_ALWAYS_INDEX_FACET,
        ];

        $this->assertEquals(
            $expected_value,
            get_robots_meta_tags($this->data),
        );
    }

    public function test__get_robots_meta_tags__when__enough_products_but_facet_page_2()
    {
        $this->setPage(2);
        $this->weHaveColor();
        $this->weHaveEnoughProducts(true);

        $expected_value = [
            'content' => 'NOINDEX,FOLLOW',
            'reason'  => WhiteList::REASON_NOT_MAIN_PAGE,
        ];

        $this->assertEquals(
            $expected_value,
            get_robots_meta_tags($this->data),
        );
    }

    public function test__get_robots_meta_tags__when__no_products_but_facet()
    {
        $this->weHaveColor();
        $this->weHaveThisAmountOfProducts(0);

        $expected_value = [
            'content' => 'NOINDEX,FOLLOW',
            'reason'  => WhiteList::REASON_NO_PRODUCTS,
        ];

        $this->assertEquals(
            $expected_value,
            get_robots_meta_tags($this->data),
        );
    }

    public function test__get_robots_meta_tags__when__no_facet_and_brand_is_public()
    {
        $this->weHaveBrand($is_public = true);
        $this->weHaveEnoughProducts(true);

        $expected_value = [];

        $this->assertEquals(
            $expected_value,
            get_robots_meta_tags($this->data),
        );
    }

    public function test__get_robots_meta_tags__when__no_facet_and_brand_is_public_page_2()
    {
        $this->setPage(2);
        $this->weHaveBrand($is_public = true);
        $this->weHaveEnoughProducts(true);

        $expected_value = [
            'content' => 'NOINDEX,FOLLOW',
            'reason'  => WhiteList::REASON_NOT_MAIN_PAGE,
        ];

        $this->assertEquals(
            $expected_value,
            get_robots_meta_tags($this->data),
        );
    }

    public function test__get_robots_meta_tags__when__no_facet_and_brand_is_public_with_category_and_enough_products()
    {
        $this->weHaveBrand($is_public = true);
        $this->weHaveCategory();
        $this->weHaveEnoughProducts(true);

        $expected_value = [];

        $this->assertEquals(
            $expected_value,
            get_robots_meta_tags($this->data),
        );
    }

    public function test__get_robots_meta_tags__when__whitelisted_and_brand_is_public_with_category_but_not_enough_products()
    {
        $this->weHaveBrand($is_public = true);
        $this->weHaveCategory();
        $this->weAreWhiteListed(true);
        $this->weHaveEnoughProducts(false);

        $expected_value = [
            'content' => 'INDEX,FOLLOW',
            'reason'  => WhiteList::REASON_IS_WHITELISTED,
        ];

        $this->assertEquals(
            $expected_value,
            get_robots_meta_tags($this->data),
        );
    }

    public function test__get_robots_meta_tags__when__no_facet_and_brand_not_public_but_has_enough_products()
    {
        $this->weHaveBrand($is_public = false);
        $this->weHaveEnoughProducts(true);

        $expected_value = [];

        $this->assertEquals(
            $expected_value,
            get_robots_meta_tags($this->data),
        );
    }

    public function test__get_robots_meta_tags__when__not_whitelisted__no_facet_and_brand_not_public_and_not_enough_products()
    {
        $this->weHaveBrand($is_public = false);
        $this->weAreWhiteListed(false);
        $this->weHaveEnoughProducts(false);

        $expected_value = [
            'content' => 'NOINDEX,FOLLOW',
            'reason'  => WhiteList::REASON_NOT_ENOUGH_PRODUCTS,
        ];

        $this->assertEquals(
            $expected_value,
            get_robots_meta_tags($this->data),
        );
    }

    public function test__get_robots_meta_tags__when__has_enough_products()
    {
        $this->weHaveEnoughProducts(true);

        $expected_value = [];

        $this->assertEquals(
            $expected_value,
            get_robots_meta_tags($this->data),
        );
    }

    public function test__get_robots_meta_tags__when__whitelisted_but_not_enough_products()
    {
        $this->weAreWhiteListed(true);
        $this->weHaveEnoughProducts(false);

        $expected_value = [
            'content' => 'INDEX,FOLLOW',
            'reason'  => WhiteList::REASON_IS_WHITELISTED,
        ];

        $this->assertEquals(
            $expected_value,
            get_robots_meta_tags($this->data),
        );
    }

    public function test__get_robots_meta_tags__when__whitelisted_but_not_enough_products_page_2()
    {
        $this->setPage(2);
        $this->weAreWhiteListed(true);
        $this->weHaveEnoughProducts(false);

        $expected_value = [
            'content' => 'NOINDEX,FOLLOW',
            'reason'  => WhiteList::REASON_NOT_MAIN_PAGE,
        ];

        $this->assertEquals(
            $expected_value,
            get_robots_meta_tags($this->data),
        );
    }

    public function test__get_robots_meta_tags__when__whitelisted_but_no_products()
    {
        $this->weAreWhiteListed(true);
        $this->weHaveThisAmountOfProducts(0);

        $expected_value = [
            'content' => 'NOINDEX,FOLLOW',
            'reason'  => WhiteList::REASON_NO_PRODUCTS,
        ];

        $this->assertEquals(
            $expected_value,
            get_robots_meta_tags($this->data),
        );
    }
}
