<?php

namespace App\Service;

use App\Entity\Project;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Response;

class ProjectManager extends AbstractManager
{

    /**
     * ProjectManager constructor.
     * @param EntityManagerInterface $manager
     * @param LoggerInterface $logger
     */
    public function __construct(EntityManagerInterface $manager, LoggerInterface $logger)
    {
        parent::__construct($manager, $manager->getRepository(Project::class), $logger);
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
        if (!isset($obj->name) || !isset($obj->estimatedDuration) || !isset($obj->type)) {
            throw new Exception("Json bad format", Response::HTTP_BAD_REQUEST);
        }
        if (isset($obj->id))
            $project = $this->repo->find($obj->id);
        if (!isset($project)) {
            if ($this->repo->isNameExist($obj->name))
                throw new Exception("Name already exists in database", Response::HTTP_BAD_REQUEST);
            $project = new Project();
        }
        if (is_int($obj->estimatedDuration)) {
            $project->setEstimatedDuration($obj->estimatedDuration);
        } else {
            throw new Exception(
                "Json bad format. Estimated duration has to be an integer",
                Response::HTTP_BAD_REQUEST);
        }
        $project->setName($obj->name);
        if (in_array(strtoupper($obj->type), Project::AUTHORIZED_TYPES)) {
            $project->setType($obj->type);
        } else {
            throw new Exception(
                sprintf("Json bad format. Type authorized: %s", join(",", Project::AUTHORIZED_TYPES)),
                Response::HTTP_BAD_REQUEST);
        }
        $project->setDescription($obj->description ?? null);
        return parent::insertOrUpdate($project);
    }

}