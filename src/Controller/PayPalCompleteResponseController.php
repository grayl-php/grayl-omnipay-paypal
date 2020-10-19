<?php

   namespace Grayl\Omnipay\PayPal\Controller;

   use Grayl\Gateway\Common\Entity\ResponseDataAbstract;
   use Grayl\Gateway\Common\Service\ResponseServiceInterface;
   use Grayl\Omnipay\Common\Controller\OmnipayResponseControllerAbstract;
   use Grayl\Omnipay\PayPal\Entity\PayPalCompleteResponseData;
   use Grayl\Omnipay\PayPal\Service\PayPalCompleteResponseService;

   /**
    * Class PayPalCompleteResponseController
    * The controller for working with PayPalCompleteResponseData entities
    *
    * @package Grayl\Omnipay\PayPal
    */
   class PayPalCompleteResponseController extends OmnipayResponseControllerAbstract
   {

      /**
       * The PayPalCompleteResponseData object that holds the gateway API response
       *
       * @var PayPalCompleteResponseData
       */
      protected ResponseDataAbstract $response_data;

      /**
       * The PayPalCompleteResponseService entity to use
       *
       * @var PayPalCompleteResponseService
       */
      protected ResponseServiceInterface $response_service;

   }