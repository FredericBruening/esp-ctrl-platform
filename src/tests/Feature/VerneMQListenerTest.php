<?php

namespace Tests\Feature;

use App\Models\TimeSeries;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use PhpMqtt\Client\Facades\MQTT;
use Tests\TestCase;

class VerneMQListenerTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function it_records_a_time_series_for_every_message_in_the_stream()
    {
       $client = MQTT::connection();

       $series = TimeSeries::factory()->make()->toArray();

       $client->publish($series['topic'], $series['payload'], 2);
       $client->loop(true, true);
       $client->disconnect();

        $this->assertCount(1, TimeSeries::where('topic', $series['topic'])->get());
    }
}
