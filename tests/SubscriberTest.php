<?php

use App\Models\Subscriber;
use App\Models\Topic;
use Laravel\Lumen\Testing\DatabaseMigrations;

class SubscriberTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @var Subscriber
     */
    private $subscriber;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subscriber = Subscriber::create([
            'topic_id' => Topic::factory()->create()->id,
           'url' => 'https://babies.example.com/bat/apparel'
        ]);
    }

    /** @test */
    public function it_has_a_url_attribute()
    {
        $this->assertEquals('https://babies.example.com/bat/apparel', $this->subscriber->url);
    }

    /** @test */
    public function it_belongs_to_a_topic()
    {
        $this->assertInstanceOf(Topic::class, $this->subscriber->topic);
    }
}
