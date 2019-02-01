<?php

namespace App\Controller;

use App\Factory\UserFactory;
use App\Service\CheckUserService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route(path="/api/auth")
 */
class AuthController extends AbstractController
{
    private $userFactory;
    private $checkUserService;

    public function __construct(
        UserFactory $userFactory,
        CheckUserService $checkUserService
    ){
        $this->userFactory = $userFactory;
        $this->checkUserService = $checkUserService;
    }

    /**
     * @Route("", methods={"POST"})
     * @param Request $request The Request
     * @return JsonResponse
     */
    public function createUser(Request $request): JsonResponse
    {
        $data = json_decode($request);
        $user = $this->userFactory->createUser($data);
        $userID = $user->getId();

        return new JsonResponse(
            ["user_id" => $userID],
            201
            );
    }

    /**
     * @Route("/check", methods={"POST"})
     * @param Request $request The Request
     * @return JsonResponse
     */
    public function checkUser(Request $request): JsonResponse
    {
        $data = json_decode($request);
        $checked = $this->checkUserService->check($data);

        if($checked['user_id'] == null)
            return new JsonResponse(["error" => "User not found."], 404);
        if($checked['token'] == null)
            return new JsonResponse(["error" => "Password incorrect."], 403);

        return new JsonResponse(
            [
                "user_id" => $checked["user_id"],
                "token" => $checked['token'],
            ],
            200
        );
    }
}
