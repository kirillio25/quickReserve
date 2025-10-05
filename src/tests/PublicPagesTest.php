<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicPagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_tables_index_is_accessible(): void
    {
        $response = $this->getJson('/api/tables');
        $response->assertOk();
    }
}
