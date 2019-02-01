<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route(path="")
 */
class PingController
{

    /**
     * @Route("")
     *
     * @return JsonResponse
     */
    public function ping()
    {
        return new JsonResponse(
            ['time' => microtime(true)]
        );
    }
}
