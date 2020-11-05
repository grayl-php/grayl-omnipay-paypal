<?php

   namespace Grayl\Omnipay\PayPal\Config;

   use Grayl\Omnipay\Common\Config\OmnipayAPIEndpointAbstract;

   /**
    * Class PayPalAPIEndpoint
    * The class of a single PayPal API endpoint
    *
    * @package Grayl\Omnipay\PayPal
    */
   class PayPalAPIEndpoint extends OmnipayAPIEndpointAbstract
   {

      /**
       * The client ID
       *
       * @var string
       */
      protected string $client_id;

      /**
       * The secret
       *
       * @var string
       */
      protected string $secret;


      /**
       * Class constructor
       *
       * @param string $api_endpoint_id The ID of this API endpoint (default, provision, etc.)
       * @param string $client_id       The client ID to set
       * @param string $secret          The secret to set
       */
      public function __construct ( string $api_endpoint_id,
                                    string $client_id,
                                    string $secret )
      {

         // Call the parent constructor
         parent::__construct( $api_endpoint_id );

         // Set the class data
         $this->setClientID( $client_id );
         $this->setSecret( $secret );
      }


      /**
       * Gets the client ID
       *
       * @return string
       */
      public function getClientID (): string
      {

         // Return it
         return $this->client_id;
      }


      /**
       * Sets the client ID
       *
       * @param string $client_id The client ID to set
       */
      public function setClientID ( string $client_id ): void
      {

         // Set the client ID
         $this->client_id = $client_id;
      }


      /**
       * Gets the secret
       *
       * @return string
       */
      public function getSecret (): string
      {

         // Return it
         return $this->secret;
      }


      /**
       * Sets the secret
       *
       * @param string $secret The secret to set
       */
      public function setSecret ( string $secret ): void
      {

         // Set the secret
         $this->secret = $secret;
      }

   }