<?php

use App\Models\Topic;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class TopicTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @var Topic
     */
    private $topic;

    protected function setUp(): void
    {
        parent::setUp();

        $this->topic = Topic::create([
            'name' => 'Sample name'
        ]);
    }

    /** @test */
    public function it_has_a_name_attribute()
    {
        $this->assertEquals('Sample name', $this->topic->name);
    }

    /** @test */
    public function it_has_a_slug_attribute()
    {
        $this->assertEquals('sample-name', $this->topic->slug);
    }

    /** @test */
    public function it_has_many_subscribers()
    {
        $this->assertInstanceOf(\Illuminate\Support\Collection::class, $this->topic->subscribers);
    }
}
