<?php

namespace NotificationChannels\Clickatell;

use stdClass;
use Clickatell\Api\ClickatellHttp;
use NotificationChannels\Clickatell\Exceptions\CouldNotSendNotification;

class ClickatellClient
{
    const SUCCESSFUL_SEND = 0;
    const AUTH_FAILED = 1;
    const INVALID_DEST_ADDRESS = 105;
    const INVALID_API_ID = 108;
    const CANNOT_ROUTE_MESSAGE = 114;
    const DEST_MOBILE_BLOCKED = 121;
    const DEST_MOBILE_OPTED_OUT = 122;
    const MAX_MT_EXCEEDED = 130;
    const NO_CREDIT_LEFT = 301;
    const INTERNAL_ERROR = 901;

    /**
     * @var ClickatellHttp
     */
    private $clickatell;

    /**
     * @param ClickatellHttp $clickatellHttp
     */
    public function __construct(ClickatellHttp $clickatellHttp)
    {
        $this->clickatell = $clickatellHttp;
    }

    /**
     * @param array $to String or Array of numbers
     * @param string $message
     */
    public function send(array $to, $message)
    {
        $to = collect($to)->toArray();

        $response = $this->clickatell->sendMessage($to, $message);

        $this->handleProviderResponses($response);
    }

    /**
     * @param array $responses
     * @throws CouldNotSendNotification
     */
    protected function handleProviderResponses(array $responses)
    {
        collect($responses)->each(function (stdClass $response) {
            $errorCode = (int) $response->errorCode;

            if ($errorCode != self::SUCCESSFUL_SEND) {
                throw CouldNotSendNotification::serviceRespondedWithAnError(
                    (string) $response->error,
                    $errorCode
                );
            }
        });
    }

    /**
     * @return array
     */
    public function getFailedQueueCodes()
    {
        return [
            self::AUTH_FAILED,
            self::INVALID_DEST_ADDRESS,
            self::INVALID_API_ID,
            self::CANNOT_ROUTE_MESSAGE,
            self::DEST_MOBILE_BLOCKED,
            self::DEST_MOBILE_OPTED_OUT,
            self::MAX_MT_EXCEEDED,
        ];
    }

    /**
     * @return array
     */
    public function getRetryQueueCodes()
    {
        return [
            self::NO_CREDIT_LEFT,
            self::INTERNAL_ERROR,
        ];
    }
}
