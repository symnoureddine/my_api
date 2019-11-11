<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

use GuzzleHttp\HandlerStack;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;


class ContactControllerTest extends  WebTestCase
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

    public function testgetContact()
    {
        $response = $this->client->get('/api/contact/1',[
            'auth' => [
                'user',
                'user',
            ]
        ]);
     
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testPostContact()
    {
        $response = $this->client->post('/api/contact/', [
            'auth' => [
                'user',
                'user',
            ],
            'json' => [
                'name' =>  'name',
                'firstName' => 'firstName'
            ]
        ]);
        $this->assertEquals(201, $response->getStatusCode());
    }


    public function testPutContact()
    {
        $response = $this->client->put('/api/contact/1', [
            'auth' => [
                'user',
                'user',
            ],
            'json' => [
                'name' =>  'name put',
                'firstName' => 'firstName put'
            ]
        ]);
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testDeleteContact()
    {
        $response = $this->client->delete('/api/contact/2',[
            'auth' => [
                'user',
                'user',
            ],
        ]);
        $this->assertEquals(200, $response->getStatusCode());
    }
}
