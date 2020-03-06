<?php

namespace App\Service;

use App\Entity\Equipment;
use App\Entity\Project;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Response;

class EquipmentManager extends AbstractManager
{

    /**
     * ProjectManager constructor.
     * @param EntityManagerInterface $manager
     * @param LoggerInterface $logger
     */
    public function __construct(EntityManagerInterface $manager, LoggerInterface $logger)
    {
        parent::__construct($manager, $manager->getRepository(Equipment::class), $logger);
    }

    /**
     * Insert or update Project
     * Check object received by the request
     * @param object $obj
     * @return string
     * @throws \Exception
     */
    function insertOrUpdate(object $obj): string
    {
        if (!isset($obj->type) || !isset($obj->quantity) || !isset($obj->projectId) || !isset($obj->color))
            throw new Exception("Json bad format", Response::HTTP_BAD_REQUEST);
        if (!is_string($obj->type) || !is_string($obj->quantity) || !is_int($obj->projectId) || !is_string($obj->color))
            throw new Exception("Fields bad format", Response::HTTP_BAD_REQUEST);
        if (isset($obj->id))
            $equipment = $this->repo->find($obj->id);
        else
            $equipment = new Equipment();
        $project = $this->em->find(Project::class, $obj->projectId);
        if (is_null($project) || !$project instanceof Project)
            throw new Exception("No corresponding project for this project Id : ".$obj->projectId, Response::HTTP_BAD_REQUEST);
        $equipment->setType($obj->type);
        $equipment->setColor($obj->color);
        $equipment->setQuantity($obj->quantity);
        $project->addEquipment($equipment);
        return parent::insertOrUpdate($equipment);
    }

}