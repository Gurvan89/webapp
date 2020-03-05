<?php


namespace App\Service;


use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;
use Psr\Log\LoggerInterface;
use Symfony\Component\Config\Definition\Exception\Exception;

abstract class AbstractManager
{
    /**
     * Message thrown when an error is triggered during insert or update
     */
    const ERROR_INSERT_UPDATE = "Unable to insert object";

    /**
     * Message thrown when an error is triggered during get all objects
     */
    const ERROR_GET_ALL = "Unable to insert object";

    /**
     * Message thrown when an error is triggered during remove object
     */
    const ERROR_REMOVE = "Unable to remove object";

    /**
     * Message thrown when an error is triggered during remove object
     */
    const NO_OBJECT_TO_REMOVE = "No object to remove in database";

    /**
     * @var EntityManagerInterface
     */
    protected EntityManagerInterface $em;

    /**
     * @var ObjectRepository
     */
    protected ObjectRepository $repo;

    /**
     * @var LoggerInterface
     */
    protected LoggerInterface $logger;

    /**
     * ProjectManager constructor.
     * @param EntityManagerInterface $manager
     * @param ObjectRepository $repo
     * @param LoggerInterface $logger
     */
    public function __construct(EntityManagerInterface $manager, ObjectRepository $repo, LoggerInterface $logger)
    {
        $this->em = $manager;
        $this->repo = $repo;
        $this->logger = $logger;
    }

    /**
     * To get all objects
     * @return array
     */
    function getAll(): array
    {
        try {
            return $this->repo->findAll();
        } catch (Exception $exception) {
            $this->logger->error($exception);
            throw new Exception(self::ERROR_GET_ALL);
        }
    }

    /**
     * To insert or update an object
     * @param object $obj
     * @return string
     */
    function insertOrUpdate(object $obj): string
    {
        if (!is_null($obj->getId()))
            $return = "Updated";
        else
            $return = "Created";
        try {
            $this->em->persist($obj);
            $this->em->flush();
            $this->em->clear();
        } catch (Exception $exception) {
            $this->logger->error($exception);
            throw new Exception(self::ERROR_INSERT_UPDATE);
        }
        return $return;
    }

    /**
     * To remove an object
     * @param int $id
     */
    function removeById(int $id): void
    {
        $obj=$this->repo->find($id);
        if (is_null($obj))
            throw new Exception(self::NO_OBJECT_TO_REMOVE);

        try {
            $this->em->remove($obj);
            $this->em->flush();
            $this->em->clear();
        } catch (Exception $exception) {
            $this->logger->error($exception);
            throw new Exception(self::ERROR_REMOVE);
        }
    }

}