<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;


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
        $response = $this->client->get('/contact/1');
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testPostContact()
    {
        $response = $this->client->post('/contact/', [
            'json' => [
                'name' =>  'name',
                'first_name' => 'firstName'
            ]
        ]);
        $this->assertEquals(201, $response->getStatusCode());
    }


    public function testPutContact()
    {
        $response = $this->client->put('/contact/1', [
            'json' => [
                'name' =>  'name put',
                'first_name' => 'firstName put'
            ]
        ]);
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testDeleteContact()
    {
        $response = $this->client->delete('/contact/9');
        $this->assertEquals(200, $response->getStatusCode());
    }
}
