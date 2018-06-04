<?php

declare(strict_types = 1);

namespace Flo\Tournoi\Persistence\Player\Repositories;

use Flo\Tournoi\Domain\Player\Entities\Player;
use Flo\Tournoi\Persistence\Player\Repositories\Memory;
use PHPUnit\Framework\TestCase;

class MemoryTest extends TestCase
{

    public function setUp()
    {
    }

    public function testPersist()
    {
        $repository = new Memory();

        $this->assertCount(0, $repository->findAll());

        $player = $this->createMock(Player::class);
        $repository->persist($player);

        $this->assertCount(1, $repository->findAll());
    }
}
