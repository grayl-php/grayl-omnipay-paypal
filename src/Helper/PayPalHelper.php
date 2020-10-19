<?php

   namespace Grayl\Omnipay\PayPal\Helper;

   use Grayl\Mixin\Common\Traits\StaticTrait;
   use Grayl\Omnipay\Common\Entity\OmnipayGatewayOffsiteCustomer;
   use Grayl\Omnipay\Common\Helper\OmnipayHelperAbstract;
   use Grayl\Omnipay\PayPal\Controller\PayPalCompleteResponseController;
   use Grayl\Omnipay\PayPal\Entity\PayPalCompleteRequestData;

   /**
    * A package of functions for working with various PayPal objects
    * These are kept isolated to maintain separation between the main library and specific user functionality
    *
    * @package Grayl\Omnipay\PayPal
    */
   class PayPalHelper extends OmnipayHelperAbstract
   {

      // Use the static instance trait
      use StaticTrait;

      /**
       * Translates a PayPal payer ID from an offsite payment into a PayPalCompleteRequestData
       *
       * @param PayPalCompleteRequestData $request_data A PayPalCompleteRequestData entity to translate into
       * @param string                    $payer_id     The payer ID returned to us from a previous PayPal offsite request
       */
      public function translatePayPalPayerID ( PayPalCompleteRequestData $request_data,
                                               string $payer_id ): void
      {

         // Set the payer ID field into the request data
         $request_data->setMainParameter( 'payerId',
                                          $payer_id );
      }


      /**
       * Creates an OmnipayGatewayOffsiteCustomer from offsite payment data returned in a PayPalCompleteResponseData
       *
       * @param PayPalCompleteResponseController $response The response object to pull the data from
       *
       * @return OmnipayGatewayOffsiteCustomer
       * @throws \Exception
       */
      public function newOmnipayGatewayOffsiteCustomerFromResponse ( $response ): OmnipayGatewayOffsiteCustomer
      {

         // Grab the variables we need
         $data = $response->getData();

         // If we are missing payer data, throw an error
         if ( empty( $data ) || empty( $data[ 'payer' ][ 'payer_info' ][ 'email' ] ) ) {
            // Error, no user data returned
            throw new \Exception( "Offsite customer information missing" );
         }

         // Set the root array of data
         $payer = $data[ 'payer' ][ 'payer_info' ];

         // Determine what address to use
         $address = ( isset( $payer[ 'billing_address' ] ) ) ? $payer[ 'billing_address' ] : $payer[ 'shipping_address' ];

         // Return a new OmnipayGatewayOffsiteCustomer using data from the PayPal response
         return new OmnipayGatewayOffsiteCustomer( $payer[ 'first_name' ],
                                                   $payer[ 'last_name' ],
                                                   $payer[ 'email' ],
                                                   $address[ 'line1' ],
                                                   ( isset( $address[ 'line2' ] ) ) ? $address[ 'line2' ] : null,
                                                   $address[ 'city' ],
                                                   $address[ 'state' ],
                                                   $address[ 'postal_code' ],
                                                   $address[ 'country_code' ],
                                                   null );
      }

   }