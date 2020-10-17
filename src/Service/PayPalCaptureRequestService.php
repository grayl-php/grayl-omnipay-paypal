<?php

namespace Grayl\Omnipay\PayPal\Service;

use Grayl\Omnipay\Common\Service\OmnipayRequestServiceAbstract;
use Grayl\Omnipay\PayPal\Entity\PayPalCaptureRequestData;
use Grayl\Omnipay\PayPal\Entity\PayPalCaptureResponseData;
use Grayl\Omnipay\PayPal\Entity\PayPalGatewayData;
use Omnipay\PayPal\Message\Response;

/**
 * Class PayPalCaptureRequestService
 * The service for working with the PayPal capture requests
 *
 * @package Grayl\Omnipay\PayPal
 */
class PayPalCaptureRequestService extends
    OmnipayRequestServiceAbstract
{

    /**
     * Sends a PayPalCaptureRequestData object to the PayPal gateway and returns a response
     *
     * @param PayPalGatewayData        $gateway_data A configured PayPalGatewayData entity to send the request through
     * @param PayPalCaptureRequestData $request_data The PayPalCaptureRequestData entity to send
     *
     * @return PayPalCaptureResponseData
     * @throws \Exception
     */
    public function sendRequestDataEntity(
        $gateway_data,
        $request_data
    ): object {

        // Use the abstract class function to send the capture request and return a response
        return $this->sendCaptureRequestData(
            $gateway_data,
            $request_data
        );
    }


    /**
     * Creates a new PayPalCaptureResponseData object to handle data returned from the gateway
     *
     * @param Response $api_response The response entity received from a gateway
     * @param string   $gateway_name The name of the gateway
     * @param string   $action       The action performed in this response (authorize, capture, etc.)
     * @param string[] $metadata     Extra data associated with this response
     *
     * @return PayPalCaptureResponseData
     */
    public function newResponseDataEntity(
        $api_response,
        string $gateway_name,
        string $action,
        array $metadata
    ): object {

        // Return a new PayPalCaptureResponseData entity
        return new PayPalCaptureResponseData(
            $api_response,
            $gateway_name,
            $action,
            $metadata['amount']
        );
    }

}