<?php
/**
 * Created by PhpStorm.
 * User: Bboto
 * Date: 28/02/2018
 * Time: 10:27
 */

namespace App\Service;


use App\Entity\Secret;

class SecretVM
{
   public $hash;
   public $secretText;
   public $createdAt;
   public $expiresAt;
   public $remainingViews;

    /**
     * Instantiates a new SecretVM based on the original Secret entity
     * SecretVM constructor.
     * @param Secret $secret
     */
   function __construct(Secret $secret)
   {
       $this->hash = $secret->getHash();
       $this->secretText = $secret->getSecretText();
       $this->createdAt = $secret->getCreatedAt();
       $this->expiresAt = $secret->getExpiresAt();
       $this->remainingViews = $secret->getRemainingViews();
   }

}