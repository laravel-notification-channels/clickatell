<?php

namespace NotificationChannels\Clickatell\Test;

use PHPUnit\Framework\TestCase;
use Clickatell\Api\ClickatellHttp;
use NotificationChannels\Clickatell\ClickatellMessage;

class ClickatellMessageTest extends TestCase
{
    protected $clickatellMessage;
    private $httpClient;

    public function setUp(): void
    {
        parent::setUp();
        $this->httpClient = \Mockery::mock(ClickatellHttp::class);
        $this->clickatellMessage = new ClickatellMessage($this->httpClient);
    }

    /** @test */
    public function it_sets_a_clickatell_message()
    {
        $this->assertInstanceOf(
            ClickatellMessage::class,
            $this->clickatellMessage
        );
    }

    /** @test */
    public function it_can_construct_with_a_new_message()
    {
        $actual = ClickatellMessage::create('This is some content');

        $this->assertEquals('This is some content', $actual->getContent());
    }

    /** @test */
    public function it_can_set_new_content()
    {
        $actual = ClickatellMessage::create();

        $this->assertEmpty($actual->getContent());

        $actual->content('Hello');

        $this->assertEquals('Hello', $actual->getContent());
    }
}
