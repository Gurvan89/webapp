<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Entity;

/**
 * Class Equipment
 * @Entity
 */
class Equipment extends AbstractEntity
{
    /**
     * @ORM\Column(type="string")
     * @var string
     */
    private string $type;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    private string $quantity;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    private string $color;

    /**
     * @ORM\ManyToOne(targetEntity="Project", inversedBy="equipments")
     * @var Project
     */
    private Project $project;

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
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getQuantity(): string
    {
        return $this->quantity;
    }

    /**
     * @param string $quantity
     */
    public function setQuantity(string $quantity): void
    {
        $this->quantity = $quantity;
    }

    /**
     * @return string
     */
    public function getColor(): string
    {
        return $this->color;
    }

    /**
     * @param string $color
     */
    public function setColor(string $color): void
    {
        $this->color = $color;
    }

    /**
     * @return Project
     */
    public function getProject(): Project
    {
        return $this->project;
    }

    /**
     * @param Project $project
     */
    public function setProject(Project $project): void
    {
        $this->project = $project;
    }

}