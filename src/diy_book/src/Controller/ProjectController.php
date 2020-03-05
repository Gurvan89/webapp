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
}