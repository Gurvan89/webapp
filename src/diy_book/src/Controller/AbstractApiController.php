<?php


namespace App\Controller;


use App\Service\AbstractManager;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Exception;

/**
 * Class AbstractApiController
 * @package App\Controller
 */
abstract class AbstractApiController extends AbstractController
{
    /**
     * Json content type
     */
    const JSON_CONTENT = "json";

    /**
     * Json content type
     */
    const ERROR_MSG = "Error : %s";

    /**
     * @var LoggerInterface
     */
    protected LoggerInterface $logger;

    /**
     * Error message displayed when an error is triggered
     * @var string
     */
    protected string $errorMsg;

    /**
     * To check authorised code to return
     * @var array
     */
    protected array $httpStatusCodeAuthorized;

    /**
     * Manager to access in services
     * @var AbstractManager
     */
    protected AbstractManager $manager;

    /**
     * AbstractApiController constructor.
     * @param LoggerInterface $logger
     * @param AbstractManager $manager
     */
    public function __construct(LoggerInterface $logger, AbstractManager $manager)
    {
        $this->logger = $logger;
        $this->manager = $manager;
        $this->httpStatusCodeAuthorized = array_keys(Response::$statusTexts);
    }

    /**
     * Method to get all object
     * @return JsonResponse
     */
    protected function getAll(): JsonResponse
    {
        try {
            return $this->json($this->manager->getAll(), Response::HTTP_OK);
        } catch (Exception $e) {
            $this->logger->error($e->getMessage());
            return $this->json(
                sprintf(self::ERROR_MSG, $this->errorMsg),
                Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * To edit an object
     * @param Request $request
     * @return JsonResponse
     */
    protected function edit(Request $request): JsonResponse
    {
        if ($request->getContentType() !== self::JSON_CONTENT)
            return $this->json("Content type have to be in json", Response::HTTP_BAD_REQUEST);
        try {
            $result = $this->manager->insertOrUpdate(json_decode($request->getContent()));
        } catch (Exception $e) {
            $this->logger->error($e->getMessage());
            $errorCode = in_array($e->getCode(), $this->httpStatusCodeAuthorized) ? $e->getCode() : Response::HTTP_INTERNAL_SERVER_ERROR;
            return $this->json($e->getMessage(), $errorCode);
        }
        return $this->json($result, $result === "Created" ? Response::HTTP_CREATED : Response::HTTP_ACCEPTED);
    }

    /**
     * To remove an object
     * @param int $id
     * @return JsonResponse
     */
    public function remove(int $id): JsonResponse
    {
        try {
            $this->manager->removeById($id);
        } catch (Exception $e) {
            $this->logger->error($e->getMessage());
            return $this->json(sprintf("Error: %s", $e->getMessage()), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return $this->json("Removed successfully", Response::HTTP_OK);
    }

}