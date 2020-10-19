<?php

   namespace Grayl\Test\Omnipay\PayPal;

   use Grayl\Gateway\PDO\PDOPorter;
   use Grayl\Omnipay\PayPal\Controller\PayPalAuthorizeRequestController;
   use Grayl\Omnipay\PayPal\Controller\PayPalAuthorizeResponseController;
   use Grayl\Omnipay\PayPal\Entity\PayPalGatewayData;
   use Grayl\Omnipay\PayPal\Helper\PayPalOrderHelper;
   use Grayl\Omnipay\PayPal\PayPalPorter;
   use Grayl\Store\Order\Controller\OrderController;
   use Grayl\Store\Order\OrderPorter;
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
       * Creates a test order object with good data
       * TODO: Change this test data
       *
       * @return OrderController
       * @throws \Exception
       */
      public function testCreateOrderController (): OrderController
      {

         // Create the test object
         $order = OrderPorter::getInstance()
                             ->newOrderController();

         // Check the type of object returned
         $this->assertInstanceOf( OrderController::class,
                                  $order );

         // Basic order data
         $data = $order->getOrderData();
         $data->setAmount( 110.00 );
         $data->setDescription( 'PayPal test order' );

         // Items
         $order->putOrderItem( OrderPorter::getInstance()
                                          ->newOrderItem( $order->getOrderID(),
                                                          'item1',
                                                          'Tester Item',
                                                          '2',
                                                          13.22 ) );
         $order->putOrderItem( OrderPorter::getInstance()
                                          ->newOrderItem( $order->getOrderID(),
                                                          'item2',
                                                          'Tester Item 2',
                                                          '1',
                                                          8.27 ) );

         // Save the order
         $order->saveOrder();

         // Return the object
         return $order;
      }


      /**
       * Tests the creation of a PayPalAuthorizeRequestController object
       *
       * @param OrderController $order_controller A configured OrderController with order information
       *
       * @depends testCreateOrderController
       * @return PayPalAuthorizeRequestController
       * @throws \Exception
       */
      public function testCreatePayPalAuthorizeRequestController ( OrderController $order_controller ): PayPalAuthorizeRequestController
      {

         // Create the object
         $request = PayPalOrderHelper::getInstance()
                                     ->newPayPalAuthorizeRequestControllerFromOrder( $order_controller );

         // Check the type of object returned
         $this->assertInstanceOf( PayPalAuthorizeRequestController::class,
                                  $request );

         // Check the total
         $this->assertEquals( 34.71,
                              $request->getRequestData()
                                      ->getMainParameter( 'amount' ) );

         // Return the object
         return $request;
      }


      /**
       * Performs an offsite authorization using a request
       *
       * @param PayPalAuthorizeRequestController $request A configured PayPalAuthorizeRequestController to send
       *
       * @depends      testCreatePayPalAuthorizeRequestController
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
      }


      /**
       * Creates an OrderPayment object from a PayPalAuthorizeResponseController and checks it for errors
       *
       * @param OrderController                   $order_controller A configured OrderController with order information
       * @param PayPalAuthorizeResponseController $response         A PayPalAuthorizeResponseController returned from the gateway
       *
       * @depends      testCreateOrderController
       * @depends      testSendPayPalAuthorizeRequestController
       * @throws \Exception
       */
      public function testCreateOrderPaymentFromPayPalAuthorizeResponseController ( OrderController $order_controller,
                                                                                    PayPalAuthorizeResponseController $response ): void
      {

         // Create a new OrderPayment record from the authorize response
         PayPalOrderHelper::getInstance()
                          ->newOrderPaymentFromOmnipayResponseController( $response,
                                                                          $order_controller,
                                                                          null );

         // Make sure the order is paid
         $this->assertFalse( $order_controller->isOrderPaid() );

         // Grab the created payment
         $payment = $order_controller->getOrderPayment();

         // Test the data
         $this->assertTrue( $payment->isSuccessful() );
         $this->assertNotNull( $payment->getReferenceID() );
         $this->assertEquals( $response->getReferenceID(),
                              $payment->getReferenceID() );
         $this->assertEquals( 'redirect',
                              $payment->getAction() );
         $this->assertEquals( 'paypal',
                              $payment->getProcessor() );
         $this->assertEquals( $response->getAmount(),
                              $payment->getAmount() );
      }

      // After the request with the redirect URL is approved, this gateway cannot be tested in PHPUnit any further
      // When the user returns from Paypal's offsite payment, a Complete Purchase and Capture requests must then be completed
      // Complete PayPal process tests are located in /tests to be run in browser

   }