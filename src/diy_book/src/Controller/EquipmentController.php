<?php

namespace App\Controller;

use App\Service\EquipmentManager;
use Exception;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class EquipmentController
 * @Route("/api/equipment")
 * @package App\Controller
 */
class EquipmentController extends AbstractApiController
{

    /**
     * ProjectController constructor.
     * @param LoggerInterface $logger
     * @param EquipmentManager $manager
     */
    public function __construct(LoggerInterface $logger, EquipmentManager $manager)
    {
        parent::__construct($logger,$manager);
    }

    /**
     * To get all equipments of all projects
     * @return JsonResponse
     * @throws Exception
     * @example You can find an example with postman (getAllEquipments). Download postman config in directory /Postman
     * @Route("/all" , methods={"GET"})
     */
    public function getAllAction()
    {
        //In case where error is triggered
        $this->errorMsg="Unable to fetch all equipments";
        return $this->getAll();
    }


    /**
     * To create or update equipment. This api has to contain a equipment in json format.
     * If you add an id in json and if this id exists in database,
     * the corresponding equipment will be update with the new values.
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     * @example You can find an example with postman (insertEquipment). Download postman config in directory /Postman
     * @Route("/edit" , methods={"POST"})
     */
    public function editAction(Request $request)
    {
        return $this->edit($request);
    }

    /**
     * To remove a project with Id
     * @param int $id
     * @return JsonResponse
     * @example You can find an example with postman (removeEquipment). Download postman config in directory /Postman
     * @Route("/remove/{id}" , methods={"Get"})
     */
    public function removeAction(int $id)
    {
        return $this->remove($id);
    }
}