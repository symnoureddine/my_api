<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

use GuzzleHttp\HandlerStack;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;


class SubscriptionControllerTest extends WebTestCase
{

    protected function setUp()
    {

       $this->client = new Client([
            'base_uri' => 'http://127.0.0.1:8000',
            'headers' => [
                'Accept' => 'application/json; charset=utf-8'
            ]
        ]);
    }

    public function testgetSubscription()
    {
        $response = $this->client->get('/api/subscription/1',[
            'auth' => [
                'user',
                'user',
                ]
            ]);
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testPostSubscription()
    {

        $response = $this->client->post('/api/subscription/', [
            'auth' => [
                'user',
                'user',
            ],
            'json' => [
                'contact' => 1,
                'product' => 3,
                'beginDate' => '2014-09-27T18:30:49-0300',
                'endDate' => '2014-09-27T18:30:49-0300'
            ]
        ]);
        $this->assertEquals(201, $response->getStatusCode());
    }


    public function testPutSubscription()
    {
        $response = $this->client->put('/api/subscription/2', [
            'auth' => [
                'user',
                'user',
            ],
            'json' => [
                'contact' => 3,
                'product' => 4,
                'beginDate' => '2014-09-27T18:30:49-0300',
                'endDate' => '2014-09-27T18:30:49-0300'
            ]
        ]);
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testDeleteSubscription()
    {
        $response = $this->client->delete('/api/subscription/9',[
        'auth' => [
            'user',
            'user',
            ]
        ]);
        $this->assertEquals(200, $response->getStatusCode());
    }
}
