<?php

namespace Tests\Feature;

use App\Models\TimeSeries;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MQTTRetrieverAPITest extends TestCase {

    use DatabaseMigrations;

    /** @test */
    function it_retrieves_a_single_message_by_topic()
    {
        $series = TimeSeries::factory()->create();

        $response = $this->get("/api/mqtt-messages/$series->topic");

        $response->assertStatus(200);
        $response->assertExactJson([$series->toArray()]);
    }

    /** @test */
    function it_retrieves_multiple_messages_by_topic()
    {
        $series = TimeSeries::factory(15)->create(['topic' => 'some-topic']);

        $response = $this->get("/api/mqtt-messages/some-topic/last/15");

        $response->assertStatus(200);
        $response->assertExactJson(array_reverse($series->toArray()));
    }
}
