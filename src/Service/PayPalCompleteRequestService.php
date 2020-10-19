<?php

   namespace Grayl\Omnipay\PayPal\Service;

   use Grayl\Omnipay\Common\Service\OmnipayRequestServiceAbstract;
   use Grayl\Omnipay\PayPal\Entity\PayPalCompleteRequestData;
   use Grayl\Omnipay\PayPal\Entity\PayPalCompleteResponseData;
   use Grayl\Omnipay\PayPal\Entity\PayPalGatewayData;
   use Omnipay\PayPal\Message\Response;

   /**
    * Class PayPalCompleteRequestService
    * The service for working with the PayPal complete requests
    *
    * @package Grayl\Omnipay\PayPal
    */
   class PayPalCompleteRequestService extends OmnipayRequestServiceAbstract
   {

      /**
       * Sends a PayPalCompleteRequestData object to the PayPal gateway and returns a response
       *
       * @param PayPalGatewayData         $gateway_data A configured PayPalGatewayData entity to send the request through
       * @param PayPalCompleteRequestData $request_data The PayPalCompleteRequestData entity to send
       *
       * @return PayPalCompleteResponseData
       * @throws \Exception
       */
      public function sendRequestDataEntity ( $gateway_data,
                                              $request_data ): object
      {

         // Use the abstract class function to send the complete request and return a response
         return $this->sendCompletePurchaseRequestData( $gateway_data,
                                                        $request_data );
      }


      /**
       * Creates a new PayPalCompleteResponseData object to handle data returned from the gateway
       *
       * @param Response $api_response The response entity received from a gateway
       * @param string   $gateway_name The name of the gateway
       * @param string   $action       The action performed in this response (complete, capture, etc.)
       * @param string[] $metadata     Extra data associated with this response
       *
       * @return PayPalCompleteResponseData
       */
      public function newResponseDataEntity ( $api_response,
                                              string $gateway_name,
                                              string $action,
                                              array $metadata ): object
      {

         // Return a new PayPalCompleteResponseData entity
         return new PayPalCompleteResponseData( $api_response,
                                                $gateway_name,
                                                $action,
                                                $metadata[ 'amount' ] );
      }

   }