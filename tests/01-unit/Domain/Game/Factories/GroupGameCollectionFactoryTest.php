<?php

declare(strict_types = 1);

namespace Flo\Tournoi\Tests\Domain\Game\Factories;

use Flo\Tournoi\Domain\Core\ValueObjects\Uuid;
use Flo\Tournoi\Domain\Game\Collections\GroupGameCollection;
use Flo\Tournoi\Domain\Game\Exceptions\InvalidNumberOfPlayersInGroupException;
use Flo\Tournoi\Domain\Game\Factories\GroupGameCollectionFactory;
use Flo\Tournoi\Domain\Group\Collections\GroupCollection;
use Flo\Tournoi\Domain\Group\Entities\Group;
use Flo\Tournoi\Domain\Player\Entities\Player;
use PHPUnit\Framework\TestCase;

class GroupGameCollectionFactoryTest extends TestCase
{
    /**
     * @dataProvider createProvider
     */
    public function testCreate(int $numberOfPlayers, int $numberOfGamesExpected)
    {
        $groupStage = $this->createGroup($numberOfPlayers);

        $groupGameCollectionFactory = new GroupGameCollectionFactory();

        $groupGames = $groupGameCollectionFactory->create($groupStage);

        $this->assertInstanceOf(GroupGameCollection::class, $groupGames);
        $this->assertCount($numberOfGamesExpected, $groupGames);
    }

    public function createProvider()
    {
        yield [2, 1];
        yield [3, 3];
        yield [4, 6];
    }

    public function testCreateFromGroupWithoutPlayers()
    {
        $groupStage = $this->createGroup(0);

        $groupGameCollectionFactory = new GroupGameCollectionFactory();

        $this->expectException(InvalidNumberOfPlayersInGroupException::class);

        $groupGames = $groupGameCollectionFactory->create($groupStage);
    }

    public function testCreateFromGroupWithTooManyPlayers()
    {
        $groupStage = $this->createGroup(5);

        $groupGameCollectionFactory = new GroupGameCollectionFactory();

        $this->expectException(InvalidNumberOfPlayersInGroupException::class);

        $groupGames = $groupGameCollectionFactory->create($groupStage);
    }

    private function createGroup(?int $numberOfPlayers): Group
    {
        $group = new Group(new Uuid(), new Uuid());

        for ($i = 1; $i <= $numberOfPlayers; $i++)
        {
            $group->addPlayer($this->createMockedPlayer());
        }

        return $group;
    }

    private function createMockedPlayer(): Player
    {
        $player = $this
            ->getMockBuilder(Player::class)
            ->disableOriginalConstructor()
            ->getMock();

        return $player;
    }
}
