<?php

   namespace Grayl\Omnipay\PayPal;

   use Grayl\Mixin\Common\Traits\StaticTrait;
   use Grayl\Omnipay\Common\OmnipayPorterAbstract;
   use Grayl\Omnipay\PayPal\Controller\PayPalAuthorizeRequestController;
   use Grayl\Omnipay\PayPal\Controller\PayPalCaptureRequestController;
   use Grayl\Omnipay\PayPal\Controller\PayPalCompleteRequestController;
   use Grayl\Omnipay\PayPal\Entity\PayPalAuthorizeRequestData;
   use Grayl\Omnipay\PayPal\Entity\PayPalCaptureRequestData;
   use Grayl\Omnipay\PayPal\Entity\PayPalCompleteRequestData;
   use Grayl\Omnipay\PayPal\Entity\PayPalGatewayData;
   use Grayl\Omnipay\PayPal\Service\PayPalAuthorizeRequestService;
   use Grayl\Omnipay\PayPal\Service\PayPalAuthorizeResponseService;
   use Grayl\Omnipay\PayPal\Service\PayPalCaptureRequestService;
   use Grayl\Omnipay\PayPal\Service\PayPalCaptureResponseService;
   use Grayl\Omnipay\PayPal\Service\PayPalCompleteRequestService;
   use Grayl\Omnipay\PayPal\Service\PayPalCompleteResponseService;
   use Grayl\Omnipay\PayPal\Service\PayPalGatewayService;
   use Omnipay\Omnipay;
   use Omnipay\PayPal\RestGateway;

   /**
    * Front-end for the PayPal Omnipay package
    * @method PayPalGatewayData getSavedGatewayDataEntity ( string $endpoint_id )
    *
    * @package Grayl\Omnipay\PayPal
    */
   class PayPalPorter extends OmnipayPorterAbstract
   {

      // Use the static instance trait
      use StaticTrait;

      /**
       * The name of the config file for the PayPal package
       *
       * @var string
       */
      protected string $config_file = 'gateway.omnipay.paypal.php';


      /**
       * Creates a new Omnipay ApiGateway object for use in a PayPalGatewayData entity
       *
       * @param array $credentials An array containing all of the credentials needed to create the gateway API
       *
       * @return RestGateway
       * @throws \Exception
       */
      public function newGatewayAPI ( array $credentials ): object
      {

         // Create the Omnipay PayPalGateway api entity
         /* @var $api RestGateway */
         $api = Omnipay::create( 'PayPal_Rest' );

         // Set the environment's credentials into the API
         $api->setClientID( $credentials[ 'clientid' ] );
         $api->setSecret( $credentials[ 'secret' ] );

         // Return the new instance
         return $api;
      }


      /**
       * Creates a new PayPalGatewayData entity
       *
       * @param string $endpoint_id The API endpoint ID to use (typically "default" is there is only one API gateway)
       *
       * @return PayPalGatewayData
       * @throws \Exception
       */
      public function newGatewayDataEntity ( string $endpoint_id ): object
      {

         // Grab the gateway service
         $service = new PayPalGatewayService();

         // Get an API
         $api = $this->newGatewayAPI( $service->getAPICredentials( $this->config,
                                                                   $this->environment,
                                                                   $endpoint_id ) );

         // Configure the API as needed using the service
         $service->configureAPI( $api,
                                 $this->environment );

         // Return the gateway
         return new PayPalGatewayData( $api,
                                       $this->config->getConfig( 'name' ),
                                       $this->environment );
      }


      /**
       * Creates a new PayPalAuthorizeRequestController entity
       *
       * @return PayPalAuthorizeRequestController
       * @throws \Exception
       */
      public function newPayPalAuthorizeRequestController (): PayPalAuthorizeRequestController
      {

         // Create the PayPalQueryRequestData entity
         $request_data = new PayPalAuthorizeRequestData( 'authorize',
                                                         $this->getOffsiteURLs() );

         // Return a new PayPalQueryRequestController entity
         return new PayPalAuthorizeRequestController( $this->getSavedGatewayDataEntity( 'default' ),
                                                      $request_data,
                                                      new PayPalAuthorizeRequestService(),
                                                      new PayPalAuthorizeResponseService() );
      }


      /**
       * Creates a new PayPalCompleteRequestController entity
       *
       * @return PayPalCompleteRequestController
       * @throws \Exception
       */
      public function newPayPalCompleteRequestController (): PayPalCompleteRequestController
      {

         // Create the PayPalQueryRequestData entity
         $request_data = new PayPalCompleteRequestData( 'confirm',
                                                        $this->getOffsiteURLs() );

         // Return a new PayPalQueryRequestController entity
         return new PayPalCompleteRequestController( $this->getSavedGatewayDataEntity( 'default' ),
                                                     $request_data,
                                                     new PayPalCompleteRequestService(),
                                                     new PayPalCompleteResponseService() );
      }


      /**
       * Creates a new PayPalCaptureRequestController entity
       *
       * @return PayPalCaptureRequestController
       * @throws \Exception
       */
      public function newPayPalCaptureRequestController (): PayPalCaptureRequestController
      {

         // Create the PayPalQueryRequestData entity
         $request_data = new PayPalCaptureRequestData( 'capture',
                                                       $this->getOffsiteURLs() );

         // Return a new PayPalQueryRequestController entity
         return new PayPalCaptureRequestController( $this->getSavedGatewayDataEntity( 'default' ),
                                                    $request_data,
                                                    new PayPalCaptureRequestService(),
                                                    new PayPalCaptureResponseService() );
      }

   }