<?php

   namespace Grayl\Omnipay\PayPal\Controller;

   use Grayl\Omnipay\Common\Controller\OmnipayRequestControllerAbstract;
   use Grayl\Omnipay\PayPal\Entity\PayPalAuthorizeRequestData;
   use Grayl\Omnipay\PayPal\Entity\PayPalAuthorizeResponseData;

   /**
    * Class PayPalAuthorizeRequestController
    * The controller for working with PayPalAuthorizeRequestData entities
    * @method PayPalAuthorizeRequestData getRequestData()
    * @method PayPalAuthorizeResponseController sendRequest()
    *
    * @package Grayl\Omnipay\PayPal
    */
   class PayPalAuthorizeRequestController extends OmnipayRequestControllerAbstract
   {

      /**
       * Creates a new PayPalAuthorizeResponseController to handle data returned from the gateway
       *
       * @param PayPalAuthorizeResponseData $response_data The PayPalAuthorizeResponseData entity received from the gateway
       *
       * @return PayPalAuthorizeResponseController
       */
      public function newResponseController ( $response_data ): object
      {

         // Return a new PayPalAuthorizeResponseController entity
         return new PayPalAuthorizeResponseController( $response_data,
                                                       $this->response_service );
      }

   }