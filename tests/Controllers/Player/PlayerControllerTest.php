<?php

namespace Flo\Tournoi\Tests\Controllers\Player;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PlayerControllerTest extends WebTestCase
{
    /**
     * @dataProvider urlProvider
     */
    public function testUrlIsSuccessful($url, $method)
    {
        $client = static::createClient();

        $client->request($method, $url);

        $this->assertTrue($client->getResponse()->isSuccessful());
    }

    /**
     * @dataProvider urlRedirectedProvider
     */
    public function testUrlIsRedirected($url)
    {
        $client = static::createClient();

        $client->request('GET', $url);

        $this->assertEquals(302, $client->getResponse()->getStatusCode());
    }

    public function urlProvider()
    {
        yield ['/player/list', 'GET'];
        yield ['/player/add', 'GET'];
    }

    public function urlRedirectedProvider()
    {
        yield ['/player/remove/sample-uuid', 'GET'];
    }
}
