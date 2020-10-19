<?php

   namespace Grayl\Omnipay\PayPal\Controller;

   use Grayl\Gateway\Common\Entity\ResponseDataAbstract;
   use Grayl\Gateway\Common\Service\ResponseServiceInterface;
   use Grayl\Omnipay\Common\Controller\OmnipayResponseControllerAbstract;
   use Grayl\Omnipay\PayPal\Entity\PayPalAuthorizeResponseData;
   use Grayl\Omnipay\PayPal\Service\PayPalAuthorizeResponseService;

   /**
    * Class PayPalAuthorizeResponseController
    * The controller for working with PayPalAuthorizeResponseData entities
    *
    * @package Grayl\Omnipay\PayPal
    */
   class PayPalAuthorizeResponseController extends OmnipayResponseControllerAbstract
   {

      /**
       * The PayPalAuthorizeResponseData object that holds the gateway API response
       *
       * @var PayPalAuthorizeResponseData
       */
      protected ResponseDataAbstract $response_data;

      /**
       * The PayPalAuthorizeResponseService entity to use
       *
       * @var PayPalAuthorizeResponseService
       */
      protected ResponseServiceInterface $response_service;

   }