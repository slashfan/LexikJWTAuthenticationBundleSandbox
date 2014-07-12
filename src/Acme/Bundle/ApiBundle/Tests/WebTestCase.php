<?php

namespace Acme\Bundle\ApiBundle\Tests;

use Liip\FunctionalTestBundle\Test\WebTestCase as LiipWebTestCase;
use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\User\User;

/**
 * WebTestCase
 *
 * @author Jeremy Barthe <j.barthe@lexik.fr>
 * @author Nicolas Cabot <n.cabot@lexik.fr>
 */
abstract class WebTestCase extends LiipWebTestCase
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    protected $authorizationHeaderPrefix = 'Bearer';
    protected $queryParameterName = 'bearer';

    /**
     * Create a client with a default Authorization header.
     *
     * @param string $username
     * @param string $password
     *
     * @return \Symfony\Bundle\FrameworkBundle\Client
     */
    protected function createAuthenticatedClient($username = 'user', $password = 'password')
    {
        $client = static::createClient();
        $client->request(
            'POST',
            $this->getUrl('login_check'),
            array(
                'username' => $username,
                'password' => $password,
            )
        );

        $response = $client->getResponse();
        $data     = json_decode($response->getContent(), true);

        $client = static::createClient();
        $client->setServerParameter('HTTP_Authorization', sprintf('%s %s', $this->authorizationHeaderPrefix, $data['token']));

        return $client;
    }

    /**
     * Shortcut method to execute a JSON request.
     *
     * @param Client $client
     * @param string $method
     * @param string $uri
     * @param array  $data
     *
     * @return \Symfony\Component\DomCrawler\Crawler
     */
    protected function jsonRequest(Client $client, $method, $uri, array $data = array())
    {
        return $client->request(
            $method,
            $uri,
            array(),
            array(),
            array('CONTENT_TYPE' => 'application/json'),
            json_encode($data)
        );
    }

    /**
     * @param Response $response
     * @param int      $statusCode
     * @param bool     $checkValidJson
     * @param string   $contentType
     */
    protected function assertJsonResponse(Response $response, $statusCode = 200, $checkValidJson =  true, $contentType = 'application/json')
    {
        $this->assertEquals(
            $statusCode, $response->getStatusCode(),
            $response->getContent()
        );
        $this->assertTrue(
            $response->headers->contains('Content-Type', $contentType),
            $response->headers
        );

        if ($checkValidJson) {
            $decode = json_decode($response->getContent(), true);
            $this->assertTrue(($decode !== null && $decode !== false),
                'is response valid json: [' . $response->getContent() . ']'
            );
        }
    }

    /**
     * @param Response $response
     * @param int      $statusCode
     */
    protected function assertJsonHalResponse(Response $response, $statusCode = 200)
    {
        $this->assertJsonResponse($response, $statusCode);

        $content = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('_links', $content);
        $this->assertArrayHasKey('_embedded', $content);
    }

    /**
     * @param Response $response
     * @param int      $statusCode
     */
    protected function assertJsonHalPaginationResponse(Response $response, $statusCode = 200)
    {
        $this->assertJsonResponse($response, $statusCode);
        $this->assertJsonHalResponse($response, $statusCode);

        $content = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('page', $content);
        $this->assertArrayHasKey('limit', $content);
        $this->assertArrayHasKey('pages', $content);
    }
}
