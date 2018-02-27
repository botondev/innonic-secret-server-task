<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SecretRepository")
 */
class Secret
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    public $id;

    /**
     * @ORM\Column(type="string")
     */
    public $hash;

    /**
     * @ORM\Column(type="string", name="secret_text")
     */
    public $secretText;

    /**
     * @ORM\Column(type="datetime")
     */
    public $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    public $expiresAt;

    /**
     * @ORM\Column(type="integer")
     */
    public $remainingViews;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getHash()
    {
        return $this->hash;
    }

    /**
     * @param mixed $hash
     */
    public function setHash($hash): void
    {
        $this->hash = $hash;
    }

    /**
     * @return mixed
     */
    public function getSecretText()
    {
        return $this->secretText;
    }

    /**
     * @param mixed $secretText
     */
    public function setSecretText($secretText): void
    {
        $this->secretText = $secretText;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param mixed $createdAt
     */
    public function setCreatedAt($createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return mixed
     */
    public function getExpiresAt()
    {
        return $this->expiresAt;
    }

    /**
     * @param mixed $expiresAt
     */
    public function setExpiresAt($expiresAt): void
    {
        $this->expiresAt = $expiresAt;
    }

    /**
     * @return mixed
     */
    public function getRemainingViews()
    {
        return $this->remainingViews;
    }

    /**
     * @param mixed $remainingViews
     */
    public function setRemainingViews($remainingViews): void
    {
        $this->remainingViews = $remainingViews;
    }

}
