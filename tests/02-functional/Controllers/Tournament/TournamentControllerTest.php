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
        yield ['/player/create', 'GET'];
    }
}
