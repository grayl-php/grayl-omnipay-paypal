<?php

namespace Grayl\Omnipay\PayPal\Controller;

use Grayl\Omnipay\Common\Controller\OmnipayRequestControllerAbstract;
use Grayl\Omnipay\PayPal\Entity\PayPalCompleteRequestData;
use Grayl\Omnipay\PayPal\Entity\PayPalCompleteResponseData;

/**
 * Class PayPalCompleteRequestController
 * The controller for working with PayPalCompleteRequestData entities
 * @method PayPalCompleteRequestData getRequestData()
 * @method PayPalCompleteResponseController sendRequest()
 *
 * @package Grayl\Omnipay\PayPal
 */
class PayPalCompleteRequestController extends
    OmnipayRequestControllerAbstract
{

    /**
     * Creates a new PayPalCompleteResponseController to handle data returned from the gateway
     *
     * @param PayPalCompleteResponseData $response_data The PayPalCompleteResponseData entity received from the gateway
     *
     * @return PayPalCompleteResponseController
     */
    public function newResponseController($response_data): object
    {

        // Return a new PayPalCompleteResponseController entity
        return new PayPalCompleteResponseController(
            $response_data,
            $this->response_service
        );
    }

}