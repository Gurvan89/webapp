<?php

namespace App\Controller;

use App\Service\ProjectManager;
use Exception;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ProjectController
 * @Route("/api/project")
 * @package App\Controller
 */
class ProjectController extends AbstractApiController
{
    /**
     * ProjectController constructor.
     * @param LoggerInterface $logger
     * @param ProjectManager $manager
     */
    public function __construct(LoggerInterface $logger, ProjectManager $manager)
    {
        parent::__construct($logger,$manager);
    }


    /**
     * To get all projects
     * @example You can find an example with postman (getAllProjects). Download postman config in directory /Postman
     * @Route("/all" , methods={"GET"})
     * @return JsonResponse
     * @throws Exception
     */
    public function getAllAction()
    {
        //In case where error is triggered
        $this->errorMsg="Unable to fetch all projects";
        return $this->getAll();
    }

    /**
     * To create or update project. This api has to contain a project in json format.
     * If you add an id in json and if this id exists in database,
     * the corresponding project will be update with the new values.
     * @example You can find an example with postman (insertProject). Download postman config in directory /Postman
     * @Route("/edit" , methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function editAction(Request $request)
    {
        return $this->edit($request);
    }

    /**
     * To remove a project with Id
     * @param int $id
     * @return JsonResponse
     * @example You can find an example with postman (removeProject). Download postman config in directory /Postman
     * @Route("/remove/{id}" , methods={"Get"})
     */
    public function removeAction(int $id)
    {
        return $this->remove($id);
    }
}