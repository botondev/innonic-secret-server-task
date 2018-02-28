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
    protected $id;

    /**
     * @ORM\GeneratedValue(strategy="UUID")
     * @ORM\Column(type="string", unique = true)
     */
    protected $hash;

    /**
     * @ORM\Column(type="string", name="secret_text")
     */
    protected $secretText;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $expiresAt;

    /**
     * @ORM\Column(type="integer")
     */
    protected $remainingViews;

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
