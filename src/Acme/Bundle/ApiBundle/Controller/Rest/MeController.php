<?php

namespace Acme\Bundle\ApiBundle\Controller\REST;

use FOS\RestBundle\Controller\Annotations as FOSRest;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * PageController
 *
 * @author Nicolas Cabot <n.cabot@lexik.fr>
 *
 * @FOSRest\NamePrefix("api_")
 */
class MeController extends Controller
{
    /**
     * @throws AccessDeniedException
     * @return array
     *
     * @FOSRest\View()
     */
    public function meAction()
    {
        return $this->getUser();
    }
}
