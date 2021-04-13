<?php

use App\Models\Subscriber;
use App\Models\Topic;
use App\Notifications\MessagePublished;
use Illuminate\Support\Facades\Notification;
use Laravel\Lumen\Testing\DatabaseMigrations;

class PublishMessageToTopicTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp();

        Notification::fake();
    }

    /** @test */
    public function it_notifies_all_subscribers_when_data_is_published_to_the_topic()
    {
        $topic = Topic::factory()->create();

        Subscriber::factory()
            ->count(10)
            ->for($topic)
            ->create();

        $this->call(
            'POST',
            route('topic.publish', ['topic' => $topic->slug]),
            [],
            [],
            [],
            [
                'CONTENT_TYPE' => 'application/json',
                'HTTP_ACCEPT' => 'application/json'
            ],
            json_encode(['data' => ['message' => 'hello']])
        );

        $this->assertResponseStatus(204);

        Notification::assertSentTo($topic->subscribers, MessagePublished::class);
    }

    /** @test */
    public function notifications_are_not_sent_if_the_topic_does_not_have_subscribers()
    {
        $topic = Topic::factory()->create();

        $this->call(
            'POST',
            route('topic.publish', ['topic' => $topic->slug]),
            [],
            [],
            [],
            [
                'CONTENT_TYPE' => 'application/json',
                'HTTP_ACCEPT' => 'application/json'
            ],
            json_encode(['data' => ['message' => 'hello']])
        );

        $this->assertResponseStatus(409);

        Notification::assertNothingSent();
    }
}
