<?php

declare(strict_types = 1);

namespace Flo\Tournoi\Persistence\Player\Repositories;

use Flo\Tournoi\Domain\Core\ValueObjects\Uuid;
use Flo\Tournoi\Domain\Player\Entities\Player;
use Flo\Tournoi\Persistence\Player\Repositories\Memory;
use PHPUnit\Framework\TestCase;

class MemoryTest extends TestCase
{
    private const
        UUID_1 = 'a9d20e72-e26b-42db-b805-b9cac9ae171f',
        UUID_2 = '53ef86dd-6f92-4be3-9ef2-4ffc379bf488',
        UUID_3 = 'a3dbe5ae-3142-4d5d-8e98-599593b536c1';

    private
        $repository,
        $player1,
        $player2,
        $uuid1,
        $uuid2,
        $uuid3;

    public function setUp(): void
    {
        $this->repository = new Memory();

        $this->uuid1 = new Uuid(self::UUID_1);
        $this->player1 = $this->newPlayer($this->uuid1);

        $this->uuid2 = new Uuid(self::UUID_2);
        $this->player2 = $this->newPlayer($this->uuid2);

        $this->uuid3 = new Uuid(self::UUID_3);
    }

    public function testPersist(): Memory
    {
        $this->repository->persist($this->player1);
        $this->repository->persist($this->player2);

        $this->assertNotNull($this->repository->findById($this->uuid1));
        $this->assertNotNull($this->repository->findById($this->uuid2));

        return $this->repository;
    }

    /**
     * @depends testPersist
     */
    public function testFindById(Memory $repository): Memory
    {
        $this->assertEquals($this->player1, $repository->findById($this->uuid1));
        $this->assertEquals($this->player2, $repository->findById($this->uuid2));

        $this->assertNull($repository->findById($this->uuid3));

        return $repository;
    }

    /**
     * @depends testFindById
     */
    public function testFindAll(Memory $repository): void
    {
        $this->assertCount(2, $repository->findAll());
    }

    private function newPlayer(Uuid $uuid): Player
    {
        return new Player($uuid, 'name');
    }
}
