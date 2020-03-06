<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\MappedSuperclass;
use Exception;
use JsonSerializable;

/**
 * Class AbstractEntity
 * @MappedSuperclass
 */
abstract class AbstractEntity implements JsonSerializable
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @var int
     */
    protected ?int $id;

    /**
     * @ORM\Column(type="datetimetz")
     * @var DateTime
     */
    private DateTime $createdAt;

    /**
     * @ORM\Column(type="datetimetz")
     * @var DateTime
     */
    private DateTime $updatedAt;

    /**
     * AbstractEntity constructor.
     * @throws Exception
     */
    public function __construct()
    {
        $this->id = null;
        $this->createdAt = new DateTime();
        $this->updatedAt = new DateTime();
    }

    /**
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param DateTime $createdAt
     */
    public function setCreatedAt(DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return DateTime
     */
    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @param DateTime $updatedAt
     */
    public function setUpdatedAt(DateTime $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

}