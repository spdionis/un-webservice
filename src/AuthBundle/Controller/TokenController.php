<?php

namespace AuthBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Noxlogic\RateLimitBundle\Annotation\RateLimit;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TokenController extends FOSRestController
{
    /**
     * @param Request $request
     *
     * @return Response
     */
    public function tokenAction(Request $request)
    {
        return $this->container->get('fos_oauth_server.controller.token')->tokenAction($request);
    }
}
