<?php

declare(strict_types = 1);

namespace Flo\Tournoi\Persistence\Player\Repositories;

use Flo\Tournoi\Domain\Core\ValueObjects\Uuid;
use Flo\Tournoi\Domain\Player\Collections\PlayerCollection;
use Flo\Tournoi\Domain\Player\Entities\Player;
use Flo\Tournoi\Domain\Registration\Collections\RegistrationCollection;
use Flo\Tournoi\Domain\Registration\Entities\Registration;
use Flo\Tournoi\Persistence\Player\Repositories\Memory;
use PHPUnit\Framework\TestCase;

class MemoryTest extends TestCase
{
    private const
        PLAYER_UUID_1 = 'a9d20e72-e26b-42db-b805-b9cac9ae171f',
        PLAYER_UUID_2 = '53ef86dd-6f92-4be3-9ef2-4ffc379bf488',
        NULL_PLAYER_UUID = 'a3dbe5ae-3142-4d5d-8e98-599593b536c1',
        TOURNAMENT_UUID = 'ff77d643-5796-4cb6-be41-df628be64b6b',
        NULL_TOURNAMENT_UUID = 'be013a11-9177-497f-936f-7ebeeb382f6a';

    private
        $repository,
        $player1,
        $player2;

    public function setUp(): void
    {
        $this->repository = new Memory();

        $this->player1 = $this->newPlayer(new Uuid(self::PLAYER_UUID_1));
        $this->player2 = $this->newPlayer(new Uuid(self::PLAYER_UUID_2));

        $registration = new Registration(
            $this->player1->uuid(),
            new Uuid(self::TOURNAMENT_UUID),
            new \DateTime('2017-05-20')
        );
        $this->player1->addRegistration($registration);
    }

    public function testPersist(): Memory
    {
        $this->repository->persist($this->player1);
        $this->repository->persist($this->player2);

        $this->assertSame($this->player2, $this->repository->last());

        return $this->repository;
    }

    /**
     * @depends testPersist
     */
    public function testFindById(Memory $repository): void
    {
        $this->assertEquals($this->player1, $repository->findById(new Uuid(self::PLAYER_UUID_1)));
        $this->assertEquals($this->player2, $repository->findById(new Uuid(self::PLAYER_UUID_2)));

        $this->assertNull($repository->findById(new Uuid(self::NULL_PLAYER_UUID)));
    }

    /**
     * @depends testPersist
     */
    public function testFindAll(Memory $repository): void
    {
        $this->assertCount(2, $repository->findAll());
    }

    /**
     * @depends testPersist
     */
    public function testFindByTournamentId(Memory $repository): void
    {
        $result = $repository->findByTournamentId(new Uuid(self::TOURNAMENT_UUID));

        $this->assertInstanceOf(PlayerCollection::class, $result);
        $this->assertCount(1, $result);

        $result = $repository->findByTournamentId(new Uuid(self::NULL_TOURNAMENT_UUID));

        $this->assertInstanceOf(PlayerCollection::class, $result);
        $this->assertCount(0, $result);
    }

    /**
     * @depends testPersist
     */
    public function testFindNotInTournament(Memory $repository): void
    {
        $result = $repository->findNotInTournament(new Uuid(self::TOURNAMENT_UUID));

        $this->assertInstanceOf(PlayerCollection::class, $result);
        $this->assertCount(1, $result);

        $result = $repository->findNotInTournament(new Uuid(self::NULL_TOURNAMENT_UUID));

        $this->assertInstanceOf(PlayerCollection::class, $result);
        $this->assertCount(2, $result);
    }

    /**
     * @depends testPersist
     */
    public function testRemove(Memory $repository): void
    {
        $this->assertCount(2, $repository->findAll());

        $repository->remove(new Uuid(self::PLAYER_UUID_1));

        $this->assertCount(1, $repository->findAll());
    }

    private function newPlayer(Uuid $id): Player
    {
        return new Player($id, 'name');
    }
}
