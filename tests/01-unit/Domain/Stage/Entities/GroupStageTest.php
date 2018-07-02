<?php

declare(strict_types = 1);

namespace Flo\Tournoi\Tests\Domain\Stage\Entities;

use Flo\Tournoi\Domain\Core\ValueObjects\Uuid;
use Flo\Tournoi\Domain\Stage\Entities\GroupStage;
use Flo\Tournoi\Domain\Stage\ValueObjects\StageType;
use Flo\Tournoi\Persistence\Stage\DataTransferObjects as DTO;
use PHPUnit\Framework\TestCase;

class GroupStageTest extends TestCase
{
    private
        $uuid,
        $tournamentUuid,
        $type,
        $placesNumberInGroup;

    public function setUp()
    {
        $this->uuid = new Uuid();
        $this->tournamentUuid = new Uuid();
        $this->type = new StageType(StageType::TYPE_GROUP);
        $this->placesNumberInGroup = 4;
    }

    public function testCreateEntity()
    {
        $stage = new GroupStage($this->uuid, $this->tournamentUuid);
        $stage->setPlacesNumberInGroup($this->placesNumberInGroup);

        $this->assertEquals($this->uuid, $stage->uuid());
        $this->assertEquals($this->tournamentUuid, $stage->tournamentUuid());
        $this->assertEquals($this->type, $stage->type());
        $this->assertEquals($this->placesNumberInGroup, $stage->placesNumberInGroup());
    }

    public function testToDTO()
    {
        $stage = new GroupStage($this->uuid, $this->tournamentUuid);
        $stage->setPlacesNumberInGroup($this->placesNumberInGroup);

        $dto = $stage->toDTO();

        $this->assertInstanceOf(DTO\GroupStage::class, $dto);
        $this->assertSame($stage->uuid()->value(), $dto->uuid());
    }
}
