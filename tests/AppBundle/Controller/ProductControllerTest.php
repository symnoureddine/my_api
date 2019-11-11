<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

use GuzzleHttp\HandlerStack;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;


use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Exception\RequestException;



class ProductControllerTest extends  WebTestCase
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

    public function testgetProduct()
    {
        $response = $this->client->get('/api/product/1',[
            'auth' => [
                'user',
                'user',
            ]
        ]);
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testPostProduct()
    {
        $response = $this->client->post('/api/product/', [
            'auth' => [
                'user',
                'user',
            ],
            'json' => [
                'label' =>  'labelproduct2'
            ]
        ]);
        $this->assertEquals(201, $response->getStatusCode());
    }


    public function testPutProduct()
    {
        $response = $this->client->put('/api/product/1', [
            'auth' => [
                'user',
                'user',
            ],
            'json' => [
                'label' => 'labelproductput'
            ]
        ]);
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testDeleteProduct()
    {
        $response = $this->client->delete('/api/product/4',[
            'auth' => [
                'user',
                'user',
            ]
        ]);
        $this->assertEquals(200, $response->getStatusCode());
    }
}
