<?php

declare(strict_types = 1);

namespace Flo\Tournoi\Tests\Domain\Player\Entities;

use Flo\Tournoi\Domain\Core\ValueObjects\Uuid;
use Flo\Tournoi\Domain\Player\Entities\Player;
use Flo\Tournoi\Domain\Player\ValueObjects\RankingPoints;
use Flo\Tournoi\Persistence\Player\DataTransferObjects as DTO;
use PHPUnit\Framework\TestCase;

class PlayerTest extends TestCase
{
    private
        $uuid,
        $name,
        $rankingPoints;

    public function setUp()
    {
        $this->uuid = new Uuid();
        $this->name = 'Roxane Abélard';
        $this->rankingPoints = new RankingPoints(501);
    }

    public function testCreateEntity()
    {
        $player = new Player($this->uuid, $this->name);
        $player->setRankingPoints($this->rankingPoints);

        $this->assertEquals($this->uuid, $player->uuid());
        $this->assertEquals($this->name, $player->name());
        $this->assertEquals($this->rankingPoints, $player->rankingPoints());
    }

    public function testToDTO()
    {
        $player = new Player($this->uuid, $this->name);
        $player->setRankingPoints($this->rankingPoints);

        $dto = $player->toDTO();

        $this->assertInstanceOf(DTO\Player::class, $dto);
        $this->assertSame($player->uuid()->value(), $dto->uuid());
    }
}
