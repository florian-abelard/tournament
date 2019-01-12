<?php

declare(strict_types = 1);

namespace Flo\Tournoi\Tests\Domain\Match\Entities;

use Flo\Tournoi\Domain\Core\ValueObjects\Uuid;
use Flo\Tournoi\Domain\Core\ValueObjects\DateTime;
use Flo\Tournoi\Domain\Match\Entities\GroupMatch;
use Flo\Tournoi\Domain\Match\ValueObjects\MatchType;
use Flo\Tournoi\Domain\Match\ValueObjects\MatchStatus;
use Flo\Tournoi\Domain\Player\Entities\Player;
use Flo\Tournoi\Persistence\Match\DataTransferObjects;
use PHPUnit\Framework\TestCase;

class GroupMatchTest extends TestCase
{
    private
        $uuid,
        $player1,
        $player2,
        $stageUuid,
        $groupUuid,
        $type,
        $status,
        $position,
        $playingDate,
        $numberOfSetsToWin;

    public function setUp()
    {
        $this->uuid = new Uuid();
        $this->player1 = $this->createMock(Player::class);
        $this->player2 = $this->createMock(Player::class);
        $this->stageUuid = new Uuid();
        $this->groupUuid = new Uuid();
        $this->type = new MatchType(MatchType::TYPE_GROUP);
        $this->status = new MatchStatus('running');
        $this->position = 1;
        $this->playingDate = new DateTime();
        $this->numberOfSetsToWin = 3;
    }

    public function testCreateEntity(): GroupMatch
    {
        $match = new GroupMatch(
            $this->uuid,
            $this->player1,
            $this->player2,
            $this->stageUuid,
            $this->groupUuid
        );
        $match->setPosition($this->position);
        $match->setStatus($this->status);
        $match->setPlayingDate($this->playingDate);
        $match->setNumberOfSetsToWin($this->numberOfSetsToWin);
        $match->setWinner($this->player1);

        $this->assertSame($this->uuid, $match->uuid());
        $this->assertSame($this->player1, $match->player1());
        $this->assertSame($this->player2, $match->player2());
        $this->assertSame($this->stageUuid, $match->stageUuid());
        $this->assertSame($this->groupUuid, $match->groupUuid());
        $this->assertEquals($this->type, $match->type());
        $this->assertSame($this->status, $match->status());
        $this->assertSame($this->position, $match->position());
        $this->assertSame($this->playingDate, $match->playingDate());
        $this->assertSame($this->numberOfSetsToWin, $match->numberOfSetsToWin());
        $this->assertSame($this->player1, $match->winner());

        return $match;
    }

    /**
     * @depends testCreateEntity
     */
    public function testToDTO(GroupMatch $match)
    {
        $dto = $match->toDto();

        $this->assertInstanceOf(DataTransferObjects\GroupMatch::class, $dto);
    }
}
