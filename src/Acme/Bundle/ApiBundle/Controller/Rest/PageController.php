<?php

namespace Acme\Bundle\ApiBundle\Controller\Rest;

use Acme\Bundle\ApiBundle\Model\Page;
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
class PageController extends Controller
{
    /**
     * @throws AccessDeniedException
     * @return array
     *
     * @FOSRest\View(serializerGroups={"list"})
     */
    public function getPagesAction()
    {
        if (!$this->get('security.context')->isGranted('ROLE_USER')) {
            throw new AccessDeniedException();
        }

        $data = array();

        for ($i = 1; $i <= 10; $i++) {
            $data[] = new Page('Page ' . $i, 'Content page ' . $i, new \DateTime());
        }

        return $data;
    }

    /**
     * @param int $id
     *
     * @throws AccessDeniedException
     * @return Page
     *
     * @FOSRest\View()
     */
    public function getPageAction($id)
    {
        if (!$this->get('security.context')->isGranted('ROLE_USER')) {
            throw new AccessDeniedException();
        }

        return new Page('Page ' . $id, 'Content page ' . $id, new \DateTime());
    }

    /**
     * @throws AccessDeniedException
     *
     * @FOSRest\View(statusCode=201)
     */
    public function postPageAction()
    {
        if (!$this->get('security.context')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException();
        }
    }
}
