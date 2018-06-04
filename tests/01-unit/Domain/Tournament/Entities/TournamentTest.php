<?php

declare(strict_types = 1);

namespace Flo\Tournoi\Tests\Domain\Tournament\Entities;

use Flo\Tournoi\Domain\Core\ValueObjects\Uuid;
use Flo\Tournoi\Domain\Tournament\Entities\Tournament;
use Flo\Tournoi\Persistence\Tournament\DataTransferObjects as DTO;
use PHPUnit\Framework\TestCase;

class TournamentTest extends TestCase
{
    private
        $uuid,
        $name,
        $points;

    public function setUp()
    {
        $this->uuid = new Uuid();
        $this->name = '24 heures du Pallet';
    }

    public function testCreateEntity()
    {
        $tournament = new Tournament($this->uuid, $this->name);

        $this->assertEquals($this->uuid, $tournament->uuid());
        $this->assertEquals($this->name, $tournament->name());
    }

    public function testToDTO()
    {
        $tournament = new Tournament($this->uuid, $this->name);

        $dto = $tournament->toDTO();

        $this->assertInstanceOf(DTO\Tournament::class, $dto);
        $this->assertSame($tournament->uuid()->value(), $dto->uuid());
    }
}
