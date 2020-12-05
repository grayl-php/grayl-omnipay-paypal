<?php

   namespace Grayl\Test\Omnipay\PayPal;

   use Grayl\Gateway\PDO\PDOPorter;
   use Grayl\Omnipay\PayPal\Controller\PayPalAuthorizeRequestController;
   use Grayl\Omnipay\PayPal\Controller\PayPalAuthorizeResponseController;
   use Grayl\Omnipay\PayPal\Entity\PayPalGatewayData;
   use Grayl\Omnipay\PayPal\PayPalPorter;
   use PHPUnit\Framework\TestCase;

   /**
    * Test class for the PayPal package
    *
    * @package Grayl\Omnipay\PayPal
    */
   class PayPalAuthorizeRequestControllerTest extends TestCase
   {

      /**
       * Test setup for sandbox environment
       */
      public static function setUpBeforeClass (): void
      {

         // Change the PDO API to sandbox mode
         PDOPorter::getInstance()
                  ->setEnvironment( 'sandbox' );

         // Change the API environment to sandbox mode
         PayPalPorter::getInstance()
                     ->setEnvironment( 'sandbox' );
      }


      /**
       * Tests the creation of a PayPalGatewayData
       *
       * @throws \Exception
       */
      public function testCreatePayPalGatewayData (): void
      {

         // Create the object
         $gateway = PayPalPorter::getInstance()
                                ->getSavedGatewayDataEntity( 'default' );

         // Check the type of object returned
         $this->assertInstanceOf( PayPalGatewayData::class,
                                  $gateway );
      }


      /**
       * Tests the creation of a PayPalAuthorizeRequestController object
       *
       * @return PayPalAuthorizeRequestController
       * @throws \Exception
       */
      public function testCreatePayPalAuthorizeRequestController (): PayPalAuthorizeRequestController
      {

         // Create the object
         $request = PayPalPorter::getInstance()
                                ->newPayPalAuthorizeRequestController( 'test-' . time(),
                                                                       65.00,
                                                                       'USD' );

         // Add two items
         $request->getRequestData()
                 ->putItem( 'nice-item',
                            2,
                            15.00 );
         $request->getRequestData()
                 ->putItem( 'test-item',
                            1,
                            35.00 );

         // Check the type of object returned
         $this->assertInstanceOf( PayPalAuthorizeRequestController::class,
                                  $request );

         // Check the total
         $this->assertEquals( 65.00,
                              $request->getRequestData()
                                      ->getAmount() );

         // Return the object
         return $request;
      }


      /**
       * Performs an offsite authorization using a request
       *
       * @param PayPalAuthorizeRequestController $request A configured PayPalAuthorizeRequestController to send
       *
       * @depends testCreatePayPalAuthorizeRequestController
       * @return PayPalAuthorizeResponseController
       * @throws \Exception
       */
      public function testSendPayPalAuthorizeRequestController ( PayPalAuthorizeRequestController $request ): PayPalAuthorizeResponseController
      {

         // Authorize the payment
         $response = $request->sendRequest();

         // Check the type of object returned
         $this->assertInstanceOf( PayPalAuthorizeResponseController::class,
                                  $response );

         // Return the response
         return $response;
      }


      /**
       * Checks a PayPalAuthorizeResponseController for data and errors
       *
       * @param PayPalAuthorizeResponseController $response A PayPalAuthorizeResponseController returned from the gateway
       *
       * @depends testSendPayPalAuthorizeRequestController
       */
      public function testPayPalAuthorizeResponseController ( PayPalAuthorizeResponseController $response ): void
      {

         // Make sure it worked
         $this->assertTrue( $response->isSuccessful() );
         $this->assertFalse( $response->isPending() );
         $this->assertNotNull( $response->getReferenceID() );
         $this->assertTrue( $response->isRedirect() );
         $this->assertNotNull( $response->getRedirectURL() );
         $this->assertNotNull( $response->getAmount() );

         echo $response->getRedirectURL();
      }

      // After the request with the redirect URL is approved, this gateway cannot be tested in PHPUnit any further
      // When the user returns from Paypal's offsite payment, a 1. Complete Purchase request and a 2. Capture request must then be performed
      // Complete PayPal process tests are located in /tests to be run in browser

   }