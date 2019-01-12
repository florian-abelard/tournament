<?php

declare(strict_types = 1);

namespace Flo\Tournoi\Tests\Domain\Match\Factories;

use Flo\Tournoi\Domain\Core\ValueObjects\Uuid;
use Flo\Tournoi\Domain\Match\Collections\GroupMatchCollection;
use Flo\Tournoi\Domain\Match\Exceptions\InvalidNumberOfPlayersInGroupException;
use Flo\Tournoi\Domain\Match\Factories\GroupMatchCollectionFactory;
use Flo\Tournoi\Domain\Group\Collections\GroupCollection;
use Flo\Tournoi\Domain\Group\Entities\Group;
use Flo\Tournoi\Domain\Player\Entities\Player;
use PHPUnit\Framework\TestCase;

class GroupMatchCollectionFactoryTest extends TestCase
{
    /**
     * @dataProvider createProvider
     */
    public function testCreate(int $numberOfPlayers, int $numberOfMatchesExpected)
    {
        $groupStage = $this->createGroup($numberOfPlayers);

        $groupMatchCollectionFactory = new GroupMatchCollectionFactory();

        $groupMatches = $groupMatchCollectionFactory->create($groupStage);

        $this->assertInstanceOf(GroupMatchCollection::class, $groupMatches);
        $this->assertCount($numberOfMatchesExpected, $groupMatches);
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

        $groupMatchCollectionFactory = new GroupMatchCollectionFactory();

        $this->expectException(InvalidNumberOfPlayersInGroupException::class);

        $groupMatches = $groupMatchCollectionFactory->create($groupStage);
    }

    public function testCreateFromGroupWithTooManyPlayers()
    {
        $groupStage = $this->createGroup(5);

        $groupMatchCollectionFactory = new GroupMatchCollectionFactory();

        $this->expectException(InvalidNumberOfPlayersInGroupException::class);

        $groupMatches = $groupMatchCollectionFactory->create($groupStage);
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
