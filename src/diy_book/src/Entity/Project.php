<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\PersistentCollection;
use Exception;

/**
 * Class AbstractProject
 * @Entity(repositoryClass="App\Repository\ProjectRepository")
 */
class Project extends AbstractEntity
{
    /**
     * 3  project's types existing
     */
    const SEWING_TYPE = "SEWING";
    const KNITTING_TYPE = "KNITTING";
    const CROCHET_TYPE = "CROCHET";

    /**
     * This array is used in order to check the type in setter
     */
    const AUTHORIZED_TYPES = [self::SEWING_TYPE, self::KNITTING_TYPE, self::CROCHET_TYPE];

    /**
     * @ORM\Column(type="string", unique=true, nullable=false)
     * @var string
     */
    private string $name;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string
     */
    private ?string $description;

    /**
     * Estimation duration of the project by day (8 hours)
     * @ORM\Column(type="integer", nullable=false)
     * @var int
     */
    private int $estimatedDuration;

    /**
     * @ORM\Column(type="string",length=20, nullable=false)
     * @var string
     */
    private string $type;

    /**
     * @ORM\OneToMany(targetEntity="Equipment", mappedBy="project", cascade={"persist"})
     * @var PersistentCollection | ArrayCollection
     */
    private $equipments;

    /**
     * AbstractProject constructor.
     * @throws Exception
     */
    public function __construct()
    {
        $this->equipments = new ArrayCollection([]);
        parent::__construct();
    }

    /**
     * add new equipment
     * @param Equipment $equipment
     */
    public function addEquipment(Equipment $equipment)
    {
        $equipment->setProject($this);
        $this->equipments->add($equipment);
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return int
     */
    public function getEstimatedDuration(): int
    {
        return $this->estimatedDuration;
    }

    /**
     * @param int $estimatedDuration
     */
    public function setEstimatedDuration(int $estimatedDuration): void
    {
        $this->estimatedDuration = $estimatedDuration;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type): void
    {
        $type = strtoupper($type);
        if (in_array($type, self::AUTHORIZED_TYPES))
            $this->type = $type;
    }

    /**
     * @return PersistentCollection
     */
    public function getEquipments(): PersistentCollection
    {
        return $this->equipments;
    }

    /**
     * @param PersistentCollection $equipments
     */
    public function setEquipments(PersistentCollection $equipments): void
    {
        $this->equipments = $equipments;
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize()
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "type" => $this->type,
            "estimatedDuration" => $this->estimatedDuration,
            "equipments" => $this->equipments->toArray(),
            "description" => $this->description
        ];
    }
}