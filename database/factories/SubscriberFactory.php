<?php

namespace Database\Factories;

use App\Models\Subscriber;
use App\Models\Topic;
use Illuminate\Database\Eloquent\Factories\Factory;

class SubscriberFactory extends Factory
{
    protected $model = Subscriber::class;

    public function definition(): array
    {
    	return [
    	    'topic_id' => Topic::factory(),
    	    'url' => $this->faker->url
    	];
    }
}
