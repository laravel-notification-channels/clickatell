<?php

namespace NotificationChannels\Clickatell\Test;

use Clickatell\Api\ClickatellHttp;
use Mockery;
use NotificationChannels\Clickatell\ClickatellClient;
use NotificationChannels\Clickatell\Exceptions\CouldNotSendNotification;
use PHPUnit\Framework\TestCase;

class ClickatellClientTest extends TestCase
{
    /** @var ClickatellClient */
    private $clickatellClient;

    /** @var ClickatellHttp */
    private $httpClient;

    public function setUp(): void
    {
        parent::setUp();

        $this->httpClient = Mockery::mock(ClickatellHttp::class);
        $this->clickatellClient = new ClickatellClient($this->httpClient);
    }

    public function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    /** @test */
    public function it_creates_a_new_clickatell_http_client_given_login_details()
    {
        $this->assertInstanceOf(ClickatellClient::class, $this->clickatellClient);
    }

    /** @test */
    public function it_gets_a_list_of_failed_queue_codes()
    {
        $listOfFailedCodes = [
            ClickatellClient::AUTH_FAILED,
            ClickatellClient::INVALID_DEST_ADDRESS,
            ClickatellClient::INVALID_API_ID,
            ClickatellClient::CANNOT_ROUTE_MESSAGE,
            ClickatellClient::DEST_MOBILE_BLOCKED,
            ClickatellClient::DEST_MOBILE_OPTED_OUT,
            ClickatellClient::MAX_MT_EXCEEDED,
        ];

        $this->assertSame($this->clickatellClient->getFailedQueueCodes(), $listOfFailedCodes);
    }

    /** @test */
    public function it_gets_a_list_of_retryable_queue_codes()
    {
        $listOfRetryCodes = [
            ClickatellClient::NO_CREDIT_LEFT,
            ClickatellClient::INTERNAL_ERROR,
        ];

        $this->assertSame($this->clickatellClient->getRetryQueueCodes(), $listOfRetryCodes);
    }

    /** @test */
    public function it_sends_a_message_to_a_single_number()
    {
        $this->expectNotToPerformAssertions();

        $to = ['27848118111'];
        $message = 'Hi there I am a message';

        $this->httpClient->shouldReceive('sendMessage')
            ->once()
            ->with($to, $message)
            ->andReturn($this->getStubSuccessResponse($to));

        $this->clickatellClient->send($to, $message);
    }

    /** @test */
    public function it_sends_a_message_to_multiple_numbers()
    {
        $this->expectNotToPerformAssertions();

        $to = ['27848118111', '1234567890'];

        $message = 'Hi there I am a message to multiple receivers';

        $this->httpClient->shouldReceive('sendMessage')
            ->once()
            ->with($to, $message)
            ->andReturn($this->getStubSuccessResponse($to));

        $this->clickatellClient->send($to, $message);
    }

    /** @test */
    public function throws_an_exception_on_failed_response_code()
    {
        $this->expectException(CouldNotSendNotification::class);
        $this->expectExceptionMessage("Clickatell responded with an error 'Invalid Destination Address: 105'");

        $to = ['27848118']; // Bad number
        $message = 'Hi there I am a message that is bound to fail';

        $this->httpClient->shouldReceive('sendMessage')
            ->once()
            ->with($to, $message)
            ->andReturn($this->getStubErrorResponse($to));

        $this->clickatellClient->send($to, $message);
    }

    /**
     * @param $to
     * @return array
     */
    private function getStubSuccessResponse($to)
    {
        $return[] = (object) [
            'id' => 'c15be99ec802d7d6424c7abd846e3bb8', // Returned message ID example
            'destination' => $to,
            'error' => false,
            'errorCode' => false,
        ];

        return $return;
    }

    /**
     * @param $to
     * @return array
     */
    private function getStubErrorResponse($to)
    {
        $return[] = (object) [
            'id' => false,
            'destination' => $to,
            'error' => 'Invalid Destination Address',
            'errorCode' => ClickatellClient::INVALID_DEST_ADDRESS,
        ];

        return $return;
    }
}
