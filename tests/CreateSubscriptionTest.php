<?php

use App\Models\Topic;
use Faker\Factory;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class CreateSubscriptionTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @var \Faker\Generator
     */
    private $faker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->faker = Factory::create();
    }

    /** @test  */
    public function it_creates_a_subscriber()
    {
        $topic = Topic::factory()->create();

        $form = ['url' => $this->faker->url];

        $this->post(route('subscriber.create', ['topic' => $topic->slug]), $form)
            ->assertResponseStatus(201);

        $this->seeJsonEquals([
            'url' => $form['url'],
            'topic' => $topic->name
        ])
            ->seeInDatabase('subscribers', [
                'topic_id' => $topic->id,
                'url' => $form['url']
            ]);
    }
}
