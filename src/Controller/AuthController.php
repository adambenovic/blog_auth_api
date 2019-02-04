<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use App\Factory\UserFactory;
use App\Service\AuthService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route(path="/api/auth")
 */
class AuthController extends AbstractController
{
    /**
     * @var UserFactory
     */
    private $userFactory;

    /**
     * @var AuthService
     */
    private $checkUserService;

    /**
     * AuthController constructor.
     * @param UserFactory $userFactory
     * @param AuthService $checkUserService
     */
    public function __construct(
        UserFactory $userFactory,
        AuthService $checkUserService
    ){
        $this->userFactory = $userFactory;
        $this->checkUserService = $checkUserService;
    }

    /**
     * @Route("/register", methods={"POST"})
     * @param Request $request The Request
     * @return JsonResponse
     */
    public function createUser(Request $request): JsonResponse
    {
        $requestContent = $request->getContent();
        $data = json_decode($requestContent, true);

        $user = $this->userFactory->createUser($data);

        return new JsonResponse(
            [
                "user_id" => $user->getId(),
                "token" => $user->getToken(),
            ],
            201
            );
    }

    /**
     * @Route("/login", methods={"POST"})
     * @param Request $request The Request
     * @return JsonResponse
     */
    public function checkPassword(Request $request): JsonResponse
    {
        $data = json_decode($request);
        $checked = $this->checkUserService->checkPassword($data);

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

    /**
     * @Route("/check", methods={"POST"})
     * @param Request $request The Request
     * @return JsonResponse
     */
    public function checkToken(Request $request): JsonResponse
    {
        $data = json_decode($request);
        $checked = $this->checkUserService->checkToken($data);

        if($checked['user_id'] == null)
            return new JsonResponse(["error" => "User not found."], 404);

        if($checked['token'] == null)
            return new JsonResponse(["error" => "Password incorrect."], 403);

        return new JsonResponse([],200);
    }

    /**
     * @Route("/logout", methods={"DELETE"})
     * @param Request $request The Request
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        $data = json_decode($request);
        $logout = $this->checkUserService->deleteToken($data);

        if($logout === null)
            return new JsonResponse(["error" => "User not found."], 404);

        if(!$logout)
            return new JsonResponse(["error" => "User was not logged in. Can not logout."], 404);

        return new JsonResponse([], 200);
    }
}
