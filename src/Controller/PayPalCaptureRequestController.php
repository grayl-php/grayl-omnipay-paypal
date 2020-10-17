<?php

namespace Grayl\Omnipay\PayPal\Controller;

use Grayl\Omnipay\Common\Controller\OmnipayRequestControllerAbstract;
use Grayl\Omnipay\PayPal\Entity\PayPalCaptureRequestData;
use Grayl\Omnipay\PayPal\Entity\PayPalCaptureResponseData;

/**
 * Class PayPalCaptureRequestController
 * The controller for working with PayPalCaptureRequestData entities
 * @method PayPalCaptureRequestData getRequestData()
 * @method PayPalCaptureResponseController sendRequest()
 *
 * @package Grayl\Omnipay\PayPal
 */
class PayPalCaptureRequestController extends
    OmnipayRequestControllerAbstract
{

    /**
     * Creates a new PayPalCaptureResponseController to handle data returned from the gateway
     *
     * @param PayPalCaptureResponseData $response_data The PayPalCaptureResponseData entity received from the gateway
     *
     * @return PayPalCaptureResponseController
     */
    public function newResponseController($response_data): object
    {

        // Return a new PayPalCaptureResponseController entity
        return new PayPalCaptureResponseController(
            $response_data,
            $this->response_service
        );
    }

}