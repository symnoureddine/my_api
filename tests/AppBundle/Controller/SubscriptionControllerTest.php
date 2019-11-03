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
        $mock = new MockHandler([new Response(200, [])]);
        $handler = HandlerStack::create($mock);
        $this->client = new Client(['handler' => $handler]);
    }


    public function testgetSubscription()
    {

        $response = $this->client->get('/subscription/1');
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testPostUser()
    {
        $response = $this->client->post('/subscription', [
            'json' => [
                    'contact' => 1,
                    'product' => 3,
                    'beginDate' => '2014-09-27T18:30:49-0300',
                    'endDate' => '2014-09-27T18:30:49-0300'
            ]
        ]);
        $this->assertEquals(200, $response->getStatusCode());
    }


    public function testPutUser()
    {
        $response = $this->client->put('/subscription/2', [
            'json' => [
                'contact' => 3,
                'product' => 4,
                'beginDate' => '2014-09-27T18:30:49-0300',
                'endDate' => '2014-09-27T18:30:49-0300'
        ]
    	]);
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testDeleteUser()
    {
        $response = $this->client->delete('/subscription/3');
        $this->assertEquals(200, $response->getStatusCode());
    }

}
