<?php

namespace App\Console\Commands;

use App\Models\TimeSeries;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use PhpMqtt\Client\Facades\MQTT;
use PhpMqtt\Client\MqttClient;

class VerneMQListen extends Command {

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vmq:listen';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Starts the listener for the VerneMQ MQTT Broker';

    protected MqttClient $client;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return void
     * @throws \PhpMqtt\Client\Exceptions\DataTransferException
     * @throws \PhpMqtt\Client\Exceptions\MqttClientException
     * @throws \PhpMqtt\Client\Exceptions\ProtocolViolationException
     */
    public function handle()
    {
        Log::info('Connecting to MQTT broker');

        $client = MQTT::connection();

        $lastPublish = 0;

        $client->registerLoopEventHandler(function (MqttClient $client, float $elapsedTime) use (&$lastPublish){
            if ($lastPublish + 15 > time()) {
                return;
            }

            $client->publish('timestamp', time(), MqttClient::QOS_EXACTLY_ONCE);

            $lastPublish = time();
        });

        try {
            $client->subscribe('#', function (string $topic, string $payload, bool $retained) {
                Log::info("Topic: $topic, Payload: $payload, Retained: $retained");

                TimeSeries::create(['topic' => $topic, 'payload' => $payload]);
            }, 2);
        } catch (Exception $exception) {
        }


        $client->loop(true);
    }
}
