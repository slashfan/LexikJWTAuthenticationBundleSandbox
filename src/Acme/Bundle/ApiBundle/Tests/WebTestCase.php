<?php

namespace Acme\Bundle\ApiBundle\Tests;

use Liip\FunctionalTestBundle\Test\WebTestCase as LiipWebTestCase;
use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Component\HttpFoundation\Response;

/**
 * WebTestCase
 *
 * @author Jeremy Barthe <j.barthe@lexik.fr>
 * @author Nicolas Cabot <n.cabot@lexik.fr>
 */
abstract class WebTestCase extends LiipWebTestCase
{
    protected $authorizationHeaderPrefix = 'Bearer';
    protected $queryParameterName = 'bearer';

    /**
     * Create a client with a default Authorization header.
     *
     * @param string $username
     *
     * @return \Symfony\Bundle\FrameworkBundle\Client
     */
    protected function createAuthenticatedClient($username = 'user')
    {
        $client = static::createClient();

        $jwt = $client->getContainer()->get('lexik_jwt_authentication.jwt_encoder')->encode(array(
            'username' => $username,
        ));

        $client->setServerParameter('HTTP_Authorization', sprintf('%s %s', $this->authorizationHeaderPrefix, $jwt->getTokenString()));

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
