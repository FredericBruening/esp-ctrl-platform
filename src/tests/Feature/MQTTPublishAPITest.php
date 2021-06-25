<?php

namespace Tests\Feature;

use App\Models\TimeSeries;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MQTTPublishAPITest extends TestCase {

    use DatabaseMigrations, WithFaker;

    /** @test */
    function it_publishes_a_message_on_a_topic()
    {
        $response = $this->post('/api/mqtt-messages', $message = TimeSeries::factory()->make()->toArray());

        $response->assertCreated();
        $response->assertExactJson(["success" => true, "message" => "published to {$message['topic']}"]);

        sleep(1);

        $this->assertCount(1, TimeSeries::where('topic', $message['topic'])->get());
    }
}
