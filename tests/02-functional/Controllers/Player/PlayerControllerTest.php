<?php

namespace Flo\Tournoi\Tests\Controllers\Player;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PlayerControllerTest extends WebTestCase
{
    private const
        NULL_UUID = 'a055f192-59d2-4ed0-9b83-d21bb74537a6';

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
    public function testUrlIsRedirected($url, $method)
    {
        $client = static::createClient();

        $client->request($method, $url);

        $this->assertEquals(302, $client->getResponse()->getStatusCode());
    }

    public function urlProvider()
    {
        yield ['/player/list', 'GET'];
        yield ['/player/create', 'GET'];
    }

    public function urlRedirectedProvider()
    {
        yield ['/player/remove/' . self::NULL_UUID, 'GET'];
    }
}
