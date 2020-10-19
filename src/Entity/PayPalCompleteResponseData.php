<?php

   namespace Grayl\Omnipay\PayPal\Entity;

   use Grayl\Omnipay\Common\Entity\OmnipayResponseDataAbstract;
   use Omnipay\PayPal\Message\Response;

   /**
    * Class PayPalCompleteResponseData
    * The class for working with an complete response from a PayPalGatewayData
    * @method void __construct( Response $api_response, string $gateway_name, string $action, float $amount )
    * @method void setAPIResponse( Response $api_response )
    * @method Response getAPIResponse()
    *
    * @package Grayl\Omnipay\PayPal
    */
   class PayPalCompleteResponseData extends OmnipayResponseDataAbstract
   {

      /**
       * The raw API response entity from the gateway
       *
       * @var Response
       */
      protected $api_response;

   }