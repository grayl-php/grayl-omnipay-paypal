<?php

   namespace Grayl\Omnipay\PayPal\Entity;

   use Grayl\Omnipay\Common\Entity\OmnipayGatewayDataAbstract;
   use Omnipay\PayPal\RestGateway;

   /**
    * Class PayPalGatewayData
    * This entity for the PayPal API
    * @method void __construct( RestGateway $api, string $gateway_name, string $environment )
    * @method void setAPI( RestGateway $api )
    * @method RestGateway getAPI()
    *
    * @package Grayl\Omnipay\PayPal
    */
   class PayPalGatewayData extends OmnipayGatewayDataAbstract
   {

      /**
       * Fully configured Omnipay PayPal gateway entity
       *
       * @var RestGateway
       */
      protected $api;

   }