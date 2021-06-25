<?php

namespace Database\Factories;

use App\Models\TimeSeries;
use Illuminate\Database\Eloquent\Factories\Factory;

class TimeSeriesFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TimeSeries::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'topic' => $this->faker->slug(5),
            'payload' => $this->faker->text(),
            'delete' => 0
        ];
    }
}
