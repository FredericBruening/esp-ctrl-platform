<?php

namespace App\Http\Controllers;

use App\Models\TimeSeries;
use Illuminate\Http\Request;
use PhpMqtt\Client\Facades\MQTT;
use PhpMqtt\Client\MqttClient;

class MQTTMessagesController extends Controller {

    private \PhpMqtt\Client\Contracts\MqttClient $client;

    public function __construct()
    {
        $this->client = MQTT::connection();
    }

    public function __destruct()
    {
        $this->client->disconnect();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function publish(Request $request)
    {
        request()->validate(['topic' => 'required', 'payload' => 'required']);

        try {
            $this->client->publish(
                $topic = request()->topic,
                $payload = request()->payload,
                MqttClient::QOS_EXACTLY_ONCE,
                false
            );
        } catch (\Exception $exception) {
            // TODO: implement
        }

        return response(['success' => true, 'message' => "published to $topic"], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param string $topic
     * @return \Illuminate\Http\Response
     */
    public function retrieve($topic, $count = 1)
    {
        return TimeSeries::where('topic', $topic)->orderBy('id', 'desc')->limit($count)->get();
    }
}
