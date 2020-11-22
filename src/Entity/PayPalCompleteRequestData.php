<?php

   namespace Grayl\Omnipay\PayPal\Entity;

   use Grayl\Omnipay\Common\Entity\OmnipayRequestDataAbstract;

   /**
    * Class PayPalCompleteRequestData
    * The entity for an complete payment request to the PayPal gateway
    *
    * @package Grayl\Omnipay\PayPal
    */
   class PayPalCompleteRequestData extends OmnipayRequestDataAbstract
   {

      /**
       * Sets the payer id
       *
       * @param string $payer_id The payer ID
       */
      public function setPayerID ( string $payer_id ): void
      {

         // Set the payer ID
         $this->setMainParameter( 'payerId',
                                  $payer_id );

      }


      /**
       * Gets the payer id
       *
       * @return string
       */
      public function getPayerID (): string
      {

         // Get the payer ID
         return $this->getMainParameter( 'payerId' );

      }

   }