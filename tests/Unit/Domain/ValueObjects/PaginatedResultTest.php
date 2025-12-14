<?php

namespace Tests\Unit\Domain\ValueObjects;

use App\Domain\ValueObjects\PaginatedResult;
use PHPUnit\Framework\TestCase;

class PaginatedResultTest extends TestCase
{
    public function test_paginated_result_can_be_created(): void
    {
        $result = new PaginatedResult(
            items: ['item1', 'item2'],
            total: 10,
            perPage: 2,
            currentPage: 1,
            lastPage: 5,
        );

        $this->assertCount(2, $result->items);
        $this->assertEquals(10, $result->total);
        $this->assertEquals(2, $result->perPage);
        $this->assertEquals(1, $result->currentPage);
        $this->assertEquals(5, $result->lastPage);
    }

    public function test_has_more_pages_when_not_on_last_page(): void
    {
        $result = new PaginatedResult(
            items: [],
            total: 10,
            perPage: 2,
            currentPage: 1,
            lastPage: 5,
        );

        $this->assertTrue($result->hasMorePages());
    }

    public function test_has_no_more_pages_when_on_last_page(): void
    {
        $result = new PaginatedResult(
            items: [],
            total: 10,
            perPage: 2,
            currentPage: 5,
            lastPage: 5,
        );

        $this->assertFalse($result->hasMorePages());
    }

    public function test_to_array(): void
    {
        $result = new PaginatedResult(
            items: ['item1', 'item2'],
            total: 10,
            perPage: 2,
            currentPage: 1,
            lastPage: 5,
        );

        $array = $result->toArray();

        $this->assertArrayHasKey('data', $array);
        $this->assertArrayHasKey('meta', $array);
        $this->assertEquals(['item1', 'item2'], $array['data']);
        $this->assertEquals(10, $array['meta']['total']);
        $this->assertEquals(2, $array['meta']['per_page']);
        $this->assertEquals(1, $array['meta']['current_page']);
        $this->assertEquals(5, $array['meta']['last_page']);
        $this->assertTrue($array['meta']['has_more_pages']);
    }
}

