<?php

declare(strict_types = 1);

namespace Flo\Tournoi\Tests\Domain\Stage\Entities;

use Flo\Tournoi\Domain\Core\ValueObjects\Uuid;
use Flo\Tournoi\Domain\Game\Entities\Game;
use Flo\Tournoi\Domain\Group\Entities\Group;
use Flo\Tournoi\Domain\Player\Entities\Player;
use Flo\Tournoi\Persistence\Group\DataTransferObjects as DTO;
use PHPUnit\Framework\TestCase;

class GroupTest extends TestCase
{
    private
        $uuid,
        $stageUuid,
        $type,
        $placesNumber;

    public function setUp()
    {
        $this->uuid = new Uuid();
        $this->stageUuid = new Uuid();
        $this->label = 'Poule A';
        $this->placesNumber = 4;
    }

    public function testCreateEntity()
    {
        $group = $this->buildGroup();

        $this->assertEquals($this->uuid, $group->uuid());
        $this->assertEquals($this->stageUuid, $group->stageUuid());
        $this->assertEquals($this->label, $group->label());
        $this->assertEquals($this->placesNumber, $group->placesNumber());
    }

    public function testAddPlayerInEntity()
    {
        $group = $this->buildGroup();

        $this->assertCount(0, $group->players());

        $player = $this->createMock(Player::class);
        $group->addPlayer($player);

        $this->assertCount(1, $group->players());
        $this->assertEquals($player, $group->players()->last());
    }

    public function testAddGameInEntity()
    {
        $group = $this->buildGroup();

        $this->assertCount(0, $group->games());

        $game = $this->createMock(Game::class);
        $group->addGame($game);

        $this->assertCount(1, $group->games());
        $this->assertEquals($game, $group->games()->last());
    }

    public function testToDTO()
    {
        $group = $this->buildGroup();

        $dto = $group->toDTO();

        $this->assertInstanceOf(DTO\Group::class, $dto);
        $this->assertSame($group->uuid()->value(), $dto->uuid());
        $this->assertSame($group->stageUuid()->value(), $dto->stageUuid());
    }

    public function buildGroup(): Group
    {
        $group = new Group($this->uuid, $this->stageUuid);
        $group->setLabel($this->label);
        $group->setPlacesNumber($this->placesNumber);

        return $group;
    }
}
