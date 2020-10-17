<?php

namespace Grayl\Omnipay\PayPal\Helper;

use Grayl\Mixin\Common\Traits\StaticTrait;
use Grayl\Omnipay\Common\Helper\OmnipayOrderHelperAbstract;
use Grayl\Omnipay\PayPal\Controller\PayPalAuthorizeRequestController;
use Grayl\Omnipay\PayPal\Controller\PayPalCaptureRequestController;
use Grayl\Omnipay\PayPal\Controller\PayPalCompleteRequestController;
use Grayl\Omnipay\PayPal\PayPalPorter;
use Grayl\Store\Order\Controller\OrderController;

/**
 * A package of functions for working with PayPal and orders
 * These are kept isolated to maintain separation between the main library and specific user functionality
 *
 * @package Grayl\Omnipay\PayPal
 */
class PayPalOrderHelper extends
    OmnipayOrderHelperAbstract
{

    // Use the static instance trait
    use StaticTrait;

    /**
     * Creates a new PayPalAuthorizeRequestController for authorizing a payment using data from an order
     *
     * @param OrderController $order_controller An OrderController entity to translate from
     *
     * @return PayPalAuthorizeRequestController
     * @throws \Exception
     */
    public function newPayPalAuthorizeRequestControllerFromOrder(
        OrderController $order_controller
    ): PayPalAuthorizeRequestController {

        // Create a new PayPalAuthorizeRequestController for authorizing a payment
        $request = PayPalPorter::getInstance()
            ->newPayPalAuthorizeRequestController();

        // Translate the OrderController and its sub classes
        $this->translateOrderController(
            $request->getRequestData(),
            $order_controller
        );

        // Return the created entity
        return $request;
    }


    /**
     * Creates a new PayPalCompleteRequestController for capturing a payment using data from an order
     *
     * @param OrderController $order_controller An OrderController entity to translate from
     * @param string          $reference_id     The Omnipay reference ID from a previous offsite authorization request
     * @param string          $payer_id         The payer ID returned from a previous offsite authorization request
     *
     * @return PayPalCompleteRequestController
     * @throws \Exception
     */
    public function newPayPalCompleteRequestControllerFromOrder(
        OrderController $order_controller,
        string $reference_id,
        string $payer_id
    ): PayPalCompleteRequestController {

        // Create a new PayPalCompleteRequestController for capturing payment
        $request = PayPalPorter::getInstance()
            ->newPayPalCompleteRequestController();

        // Translate only the OrderData entity into the capture request, the rest was sent with the authorization
        $this->translateOrderData(
            $request->getRequestData(),
            $order_controller->getOrderData()
        );

        // Translate the reference ID from the previous authorization response
        PayPalHelper::getInstance()
            ->translateOmnipayReferenceID(
                $request->getRequestData(),
                $reference_id
            );

        // Translate the PayPal payer ID from the previous authorization response
        PayPalHelper::getInstance()
            ->translatePayPalPayerID(
                $request->getRequestData(),
                $payer_id
            );

        // Return the created entity
        return $request;
    }


    /**
     * Creates a new PayPalCaptureRequestController for capturing a payment using data from an order
     *
     * @param OrderController $order_controller An OrderController entity to translate from
     * @param string          $reference_id     The Omnipay reference ID from a previous authorization
     *
     * @return PayPalCaptureRequestController
     * @throws \Exception
     */
    public function newPayPalCaptureRequestControllerFromOrder(
        OrderController $order_controller,
        string $reference_id
    ): PayPalCaptureRequestController {

        // Create a new PayPalCaptureRequestController for capturing payment
        $request = PayPalPorter::getInstance()
            ->newPayPalCaptureRequestController();

        // Translate only the OrderData entity into the capture request, the rest was sent with the authorization
        $this->translateOrderData(
            $request->getRequestData(),
            $order_controller->getOrderData()
        );

        // Translate the reference ID from the previous response
        PayPalHelper::getInstance()
            ->translateOmnipayReferenceID(
                $request->getRequestData(),
                $reference_id
            );

        // Return the created entity
        return $request;
    }

}