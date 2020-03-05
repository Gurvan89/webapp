<?php

namespace App\Controller;

use App\Service\ProjectManager;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ApiController
 * @Route("/api/project")
 * @package App\Controller
 */
class ProjectController extends AbstractController
{
    /**
     * Json content type
     */
    const JSON_CONTENT = "json";

    /**
     * To get all projects
     * @example You can find an example with postman (getAllProjects). Download postman config in directory /Postman
     * @Route("/all" , methods={"GET"})
     * @param ProjectManager $manager
     * @return JsonResponse
     * @throws Exception
     */
    public function getAllAction(ProjectManager $manager)
    {
        try {
            return $this->json($manager->getAll(), Response::HTTP_OK);
        } catch (Exception $e) {
            return $this->json("Error : Unable to fetch all projects", Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }

    /**
     * To create or update project. This api has to contain a project in json format.
     * If you add an id in json and if this id exists in database,
     * the corresponding project will be update with the new values.
     * @example You can find an example with postman (insertProject). Download postman config in directory /Postman
     * @Route("/edit" , methods={"POST"})
     * @param ProjectManager $manager
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function editAction(ProjectManager $manager, Request $request)
    {
        if ($request->getContentType() !== self::JSON_CONTENT)
            return $this->json("Content type have to be in json", Response::HTTP_BAD_REQUEST);
        try {
            $result = $manager->insertOrUpdate(json_decode($request->getContent()));
        } catch (Exception $e) {
            return $this->json($e->getMessage(), $e->getCode());
        }
        return $this->json($result, $result === "Created" ? Response::HTTP_CREATED : Response::HTTP_ACCEPTED);
    }

    /**
     * To remove a project with Id
     * @param ProjectManager $manager
     * @param int $id
     * @return JsonResponse
     * @example You can find an example with postman (removeProject). Download postman config in directory /Postman
     * @Route("/remove/{id}" , methods={"Get"})
     */
    public function removeAction(ProjectManager $manager, int $id)
    {
        try {
            $manager->removeById($id);
        } catch (Exception $e) {
            return $this->json(sprintf("Error: %s",$e->getMessage()), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return $this->json("Removed successfully", Response::HTTP_OK);
    }
}