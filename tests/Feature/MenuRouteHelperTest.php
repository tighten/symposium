<?php

namespace Tests\Feature;

use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class MenuRouteHelperTest extends TestCase
{
    #[Test]
    public function default_parameters(): void
    {
        $defaults = ['filter' => 'active', 'sort' => 'alpha'];
        $linkParams = [];
        $queryParams = [];

        $url = menuRoute('talks.index', [
            'link' => $linkParams,
            'query' => $queryParams,
            'defaults' => $defaults,
        ]);

        $this->assertEquals(
            route('talks.index', ['filter' => 'active', 'sort' => 'alpha']),
            $url,
        );
    }

    #[Test]
    public function link_parameters(): void
    {
        $defaults = ['filter' => 'active', 'sort' => 'alpha'];
        $linkParams = ['filter' => 'active'];
        $queryParams = [];

        $url = menuRoute('talks.index', [
            'link' => $linkParams,
            'query' => $queryParams,
            'defaults' => $defaults,
        ]);

        $this->assertEquals(
            route('talks.index', ['filter' => 'active', 'sort' => 'alpha']),
            $url,
        );
    }

    #[Test]
    public function query_parameters(): void
    {
        $defaults = ['filter' => 'active', 'sort' => 'alpha'];
        $linkParams = ['sort' => 'alpha'];
        $queryParams = ['filter' => 'archived'];

        $url = menuRoute('talks.index', [
            'link' => $linkParams,
            'query' => $queryParams,
            'defaults' => $defaults,
        ]);

        $this->assertEquals(
            route('talks.index', ['filter' => 'archived', 'sort' => 'alpha']),
            $url,
        );
    }
}
