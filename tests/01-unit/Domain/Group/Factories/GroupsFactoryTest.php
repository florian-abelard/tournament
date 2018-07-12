<?php

declare(strict_types = 1);

namespace Flo\Tournoi\Tests\Domain\Group\Factories;

use Flo\Tournoi\Domain\Core\ValueObjects\Uuid;
use Flo\Tournoi\Domain\Group\Collections\GroupCollection;
use Flo\Tournoi\Domain\Group\Factories\GroupsFactory;
use Flo\Tournoi\Domain\Group\Services\RequiredNumberOfGroupsCalculator;
use Flo\Tournoi\Domain\Player\Collections\PlayerCollection;
use Flo\Tournoi\Domain\Player\Entities\Player;
use Flo\Tournoi\Domain\Player\ValueObjects\RankingPoints;
use Flo\Tournoi\Domain\Stage\Entities\GroupStage;
use PHPUnit\Framework\TestCase;

class GroupsFactoryTests extends TestCase
{
    private
        $groupsFactory;

    protected function setUp()
    {
        $this->groupsFactory = new GroupsFactory(
            new RequiredNumberOfGroupsCalculator
        );
    }

    /**
     * @dataProvider createProvider
     */
    public function testCreate(array $rankingPointsList, int $numberOfGroupsExpected)
    {
        $players = $this->createPlayerCollection($rankingPointsList);

        $groupStage = $this->createMockedGroupStage(3);

        $groups = $this->groupsFactory->create($players, $groupStage);

        $this->assertInstanceOf(GroupCollection::class, $groups);
        $this->assertCount($numberOfGroupsExpected, $groups);
    }

    public function createProvider()
    {
        yield [[1500, null, 1300, 500, 700, 1600], 2];
        yield [[1500, null, 1300, 500, 700, 1600, null], 3];
    }

    private function createPlayerCollection(array $rankingPointsList): PlayerCollection
    {
        $collection = new PlayerCollection();

        foreach ($rankingPointsList as $rankingPoints)
        {
            $collection->add($this->createMockedPlayer($rankingPoints));
        }

        return $collection;
    }

    private function createMockedPlayer(?int $points): Player
    {
        $player = $this
            ->getMockBuilder(Player::class)
            ->disableOriginalConstructor()
            ->getMock();

        $player->method('rankingPoints')->willReturn(new RankingPoints($points));

        return $player;
    }

    private function createMockedGroupStage(?int $placesNumber): GroupStage
    {
        $groupStage = $this
            ->getMockBuilder(GroupStage::class)
            ->setConstructorArgs([new Uuid(), new Uuid()])
            ->getMock();
        $groupStage->method('placesNumberInGroup')->willReturn($placesNumber);

        return $groupStage;
    }

}
