<?php

namespace Flo\Tournoi\Tests\Controllers\Tournament;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TournamentControllerTest extends WebTestCase
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

    public function urlProvider()
    {
        yield ['/tournament/list', 'GET'];
        yield ['/tournament/859772a8-07bf-4e9c-8733-83f3bf806b09', 'GET'];
    }
}
