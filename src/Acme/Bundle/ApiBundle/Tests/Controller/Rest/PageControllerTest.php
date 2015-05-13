<?php

namespace Acme\Bundle\ApiBundle\Tests\Controller\Rest;

use Acme\Bundle\ApiBundle\Tests\WebTestCase;

/**
 * PageControllerTest
 *
 * @author Nicolas Cabot <n.cabot@lexik.fr>
 */
class PageControllerTest extends WebTestCase
{
    /**
     * @param array $user
     *
     * @dataProvider getUsers
     */
    public function testGetPages($user)
    {
        $client = $this->createAuthenticatedClient($user);
        $client->request('GET', $this->getUrl('api_get_pages'));

        $response = $client->getResponse();
        $this->assertJsonResponse($response, 200);

        $content = json_decode($response->getContent(), true);
        $this->assertInternalType('array', $content);
        $this->assertCount(10, $content);

        $page = $content[0];
        $this->assertArrayHasKey('title', $page);
        $this->assertArrayHasKey('published_at', $page);
        $this->assertArrayNotHasKey('content', $page);
    }

    /**
     * @param array $user
     *
     * @dataProvider getUsers
     */
    public function testGetPage($user)
    {
        $client = $this->createAuthenticatedClient($user);
        $client->request('GET', $this->getUrl('api_get_page', array('id' => 1)));

        $response = $client->getResponse();
        $this->assertJsonResponse($response, 200);

        $content = json_decode($response->getContent(), true);
        $this->assertInternalType('array', $content);

        $this->assertArrayHasKey('title', $content);
        $this->assertArrayHasKey('published_at', $content);
        $this->assertArrayHasKey('content', $content);
    }

    /**
     * @param array $user
     *
     * @dataProvider getUsers
     */
    public function testPostPage($user)
    {
        $client = $this->createAuthenticatedClient($user);
        $client->request('POST', $this->getUrl('api_post_page'), array());

        $response = $client->getResponse();

        if ($user === 'admin') {
            $this->assertJsonResponse($response, 201, false);
        } else {
            $this->assertJsonResponse($response, 403);
        }
    }

    /**
     * @return array
     */
    public function getUsers()
    {
        return array(
            array('user'),
            array('admin'),
            array('fosuser'),
            array('fosuser@test.tld'),
        );
    }
}
