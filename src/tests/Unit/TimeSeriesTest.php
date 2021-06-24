<?php

namespace Tests\Unit;

use App\Models\TimeSeries;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class TimeSeriesTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function it_has_a_created_at_timestamp()
    {
       $series = TimeSeries::factory()->create();

       $this->assertDatabaseCount('time_series', 1);
       $this->assertNotNull($series->created_at);
    }

//    /** @test */
//    function it_can_be_deleted_asynchronously()
//    {
//
//    }
}
