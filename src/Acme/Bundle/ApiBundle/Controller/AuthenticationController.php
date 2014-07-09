<?php

namespace Acme\Bundle\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * AuthenticationController
 *
 * @author Nicolas Cabot <n.cabot@lexik.fr>
 */
class AuthenticationController extends Controller
{
    /**
     * Just to demonstrate authentication result
     *
     * @return JsonResponse
     */
    public function pingAction()
    {
        return new JsonResponse();
    }
}
