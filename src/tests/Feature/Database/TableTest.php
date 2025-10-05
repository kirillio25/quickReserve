<?php

namespace Tests\Feature\Database;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Table;

class TableTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_table(): void
    {
        $table = Table::create([
            'name' => 'Столик 1',
            'seats' => 4,
            'is_reserved' => false,
            'location' => 'зал 1',
        ]);

        $this->assertDatabaseHas('tables', [
            'id' => $table->id,
            'name' => 'Столик 1',
            'seats' => 4,
            'is_reserved' => false,
            'location' => 'зал 1',
        ]);
    }
}
