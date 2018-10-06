<?php

declare(strict_types = 1);

namespace Flo\Tournoi\Tests\Domain\Game\Entities;

use Flo\Tournoi\Domain\Core\ValueObjects\Uuid;
use Flo\Tournoi\Domain\Core\ValueObjects\DateTime;
use Flo\Tournoi\Domain\Game\Entities\GroupGame;
use Flo\Tournoi\Domain\Game\ValueObjects\GameType;
use Flo\Tournoi\Domain\Game\ValueObjects\GameStatus;
use Flo\Tournoi\Domain\Player\Entities\Player;
use Flo\Tournoi\Persistence\Game\DataTransferObjects;
use PHPUnit\Framework\TestCase;

class GroupGameTest extends TestCase
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
        $this->type = new GameType(GameType::TYPE_GROUP);
        $this->status = new GameStatus('running');
        $this->position = 1;
        $this->playingDate = new DateTime();
        $this->numberOfSetsToWin = 3;
    }

    public function testCreateEntity(): GroupGame
    {
        $game = new GroupGame(
            $this->uuid,
            $this->player1,
            $this->player2,
            $this->stageUuid,
            $this->groupUuid
        );
        $game->setPosition($this->position);
        $game->setStatus($this->status);
        $game->setPlayingDate($this->playingDate);
        $game->setNumberOfSetsToWin($this->numberOfSetsToWin);
        $game->setWinner($this->player1);

        $this->assertSame($this->uuid, $game->uuid());
        $this->assertSame($this->player1, $game->player1());
        $this->assertSame($this->player2, $game->player2());
        $this->assertSame($this->stageUuid, $game->stageUuid());
        $this->assertSame($this->groupUuid, $game->groupUuid());
        $this->assertEquals($this->type, $game->type());
        $this->assertSame($this->status, $game->status());
        $this->assertSame($this->position, $game->position());
        $this->assertSame($this->playingDate, $game->playingDate());
        $this->assertSame($this->numberOfSetsToWin, $game->numberOfSetsToWin());
        $this->assertSame($this->player1, $game->winner());

        return $game;
    }

    /**
     * @depends testCreateEntity
     */
    public function testToDTO(GroupGame $game)
    {
        $dto = $game->toDto();

        $this->assertInstanceOf(DataTransferObjects\GroupGame::class, $dto);
    }
}
