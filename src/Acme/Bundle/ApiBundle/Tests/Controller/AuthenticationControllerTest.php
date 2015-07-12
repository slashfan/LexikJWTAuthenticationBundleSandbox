<?php

namespace Acme\Bundle\ApiBundle\Tests\Controller;

use Acme\Bundle\ApiBundle\Tests\WebTestCase;
use Symfony\Component\HttpKernel\Client;

/**
 * AuthenticationControllerTest
 *
 * @author Nicolas Cabot <n.cabot@lexik.fr>
 */
class AuthenticationControllerTest extends WebTestCase
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        parent::setUp();

        $this->client = static::createClient();
    }

    /**
     * test login
     */
    public function testLoginFailure()
    {
        $data = array(
            'username' => 'user',
            'password' => 'userwrongpass',
        );

        $this->client->request('POST', $this->getUrl('login_check'), $data);
        $this->assertJsonResponse($this->client->getResponse(), 401);
    }

    /**
     * test login
     *
     * @dataProvider userProvider
     */
    public function testLoginSuccess($data)
    {
        $this->client->request('POST', $this->getUrl('login_check'), $data);
        $this->assertJsonResponse($this->client->getResponse(), 200);

        $response = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('token', $response);
        $this->assertArrayHasKey('data', $response);

        // check token from query string work

        $client = static::createClient();
        $client->request('HEAD', $this->getUrl('acme_api_ping', array($this->queryParameterName => $response['token'])));

        $this->assertJsonResponse($client->getResponse(), 200, false);

        // check token work

        $client = static::createClient();
        $client->setServerParameter('HTTP_Authorization', sprintf('%s %s', $this->authorizationHeaderPrefix, $response['token']));
        $client->request('HEAD', $this->getUrl('acme_api_ping'));

        $this->assertJsonResponse($client->getResponse(), 200, false);

        // check token works several times, as long as it is valid

        $client = static::createClient();
        $client->setServerParameter('HTTP_Authorization', sprintf('%s %s', $this->authorizationHeaderPrefix, $response['token']));
        $client->request('HEAD', $this->getUrl('acme_api_ping'));

        $this->assertJsonResponse($client->getResponse(), 200, false);

        // check a bad token does not work

        $client = static::createClient();
        $client->setServerParameter('HTTP_Authorization', sprintf('%s %s', $this->authorizationHeaderPrefix, $response['token'] . 'changed'));
        $client->request('HEAD', $this->getUrl('acme_api_ping'));

        $this->assertJsonResponse($client->getResponse(), 401, false);

        // check error if no authorization header

        $client = static::createClient();
        $client->request('HEAD', $this->getUrl('acme_api_ping'));

        $this->assertJsonResponse($client->getResponse(), 401, false);
    }

    /**
     * @return array
     */
    public function userProvider()
    {
        return array(
            // in memory user
            array(
                array(
                    'username' => 'user',
                    'password' => 'password',
                )
            ),
            // in memory admin
            array(
                array(
                    'username' => 'admin',
                    'password' => 'password',
                )
            ),
            // fosuser user by username
            array(
                array(
                    'username' => 'fosuser',
                    'password' => 'password',
                )
            ),
            // fosuser user by email
            array(
                array(
                    'username' => 'fosuser@test.tld',
                    'password' => 'password',
                )
            )
        );
    }
}
