<?php

namespace Flo\Tournoi\Tests\Controllers;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TestControllerTest extends WebTestCase
{
    public function testDisplayList()
    {
        $client = static::createClient();

        $client->request('GET', '/test');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}
