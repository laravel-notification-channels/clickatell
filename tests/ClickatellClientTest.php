<?php

namespace NotificationChannels\Clickatell\Test;

use NotificationChannels\Clickatell\ClickatellClient;

class ClickatellClientTest extends \PHPUnit_Framework_TestCase
{
    /** @var $clickatellClient ClickatellClient */
    private $clickatellClient;

    /** @var array */
    private $clientResponseCodes;

    public function setUp()
    {
        parent::setUp();
        $this->clickatellClient = new ClickatellClient('user', 'pass', 'api_id');
        $this->clientResponseCodes = [
            ClickatellClient::SUCCESSFUL_SEND,
            ClickatellClient::AUTH_FAILED,
            ClickatellClient::INVALID_DEST_ADDRESS,
            ClickatellClient::INVALID_API_ID,
            ClickatellClient::CANNOT_ROUTE_MESSAGE,
            ClickatellClient::DEST_MOBILE_BLOCKED,
            ClickatellClient::DEST_MOBILE_OPTED_OUT,
            ClickatellClient::MAX_MT_EXCEEDED,
            ClickatellClient::NO_CREDIT_LEFT,
            ClickatellClient::INTERNAL_ERROR,
        ];
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
        $this->markTestIncomplete('Pending http client dependency injected');
    }

    /** @test */
    public function it_sends_a_message_to_multiple_numbers()
    {
        $this->markTestIncomplete('Pending http client dependency injected');
    }

    /** @test */
    public function throws_an_exception_on_failed_response_code()
    {
        $this->markTestIncomplete('Pending http client dependency injected');
    }
}
