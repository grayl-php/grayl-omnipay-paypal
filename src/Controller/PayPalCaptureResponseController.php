<?php

namespace Grayl\Omnipay\PayPal\Controller;

use Grayl\Gateway\Common\Entity\ResponseDataAbstract;
use Grayl\Gateway\Common\Service\ResponseServiceInterface;
use Grayl\Omnipay\Common\Controller\OmnipayResponseControllerAbstract;
use Grayl\Omnipay\PayPal\Entity\PayPalCaptureResponseData;
use Grayl\Omnipay\PayPal\Service\PayPalCaptureResponseService;

/**
 * Class PayPalCaptureResponseController
 * The controller for working with PayPalCaptureResponseData entities
 *
 * @package Grayl\Omnipay\PayPal
 */
class PayPalCaptureResponseController extends
    OmnipayResponseControllerAbstract
{

    /**
     * The PayPalCaptureResponseData object that holds the gateway API response
     *
     * @var PayPalCaptureResponseData
     */
    protected ResponseDataAbstract $response_data;

    /**
     * The PayPalCaptureResponseService entity to use
     *
     * @var PayPalCaptureResponseService
     */
    protected ResponseServiceInterface $response_service;

}