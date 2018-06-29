<?php

declare(strict_types = 1);

namespace Flo\Tournoi\Tests\Domain\Tournament\Entities;

use Flo\Tournoi\Domain\Core\ValueObjects\Uuid;
use Flo\Tournoi\Domain\Tournament\Entities\Tournament;
use Flo\Tournoi\Domain\Tournament\ValueObjects\TournamentStatus;
use Flo\Tournoi\Persistence\Tournament\DataTransferObjects as DTO;
use PHPUnit\Framework\TestCase;

class TournamentTest extends TestCase
{
    private
        $uuid,
        $name,
        $status;

    public function setUp()
    {
        $this->uuid = new Uuid();
        $this->name = '24 heures du Pallet';
        $this->status = new TournamentStatus('running');
    }

    public function testCreateEntity()
    {
        $tournament = new Tournament(
            $this->uuid,
            $this->name,
            $this->status
        );

        $this->assertEquals($this->uuid, $tournament->uuid());
        $this->assertEquals($this->name, $tournament->name());
        $this->assertEquals($this->status, $tournament->status());
    }

    public function testToDTO()
    {
        $tournament = new Tournament(
            $this->uuid,
            $this->name,
            $this->status
        );

        $dto = $tournament->toDTO();

        $this->assertInstanceOf(DTO\Tournament::class, $dto);
        $this->assertSame($tournament->uuid()->value(), $dto->uuid());
        $this->assertSame($tournament->status()->value(), $dto->status());
    }
}
