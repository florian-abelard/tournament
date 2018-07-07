<?php

declare(strict_types = 1);

namespace Flo\Tournoi\Tests\Domain\Player\Collections;

use Flo\Tournoi\Domain\Core\ValueObjects\Uuid;
use Flo\Tournoi\Domain\Player\Collections\PlayerCollection;
use Flo\Tournoi\Domain\Player\Entities\Player;
use Flo\Tournoi\Domain\Player\ValueObjects\RankingPoints;
use PHPUnit\Framework\TestCase;

class PlayerCollectionTest extends TestCase
{
    private
        $player1,
        $player2,
        $player3,
        $player4;


    public function setUp(): void
    {
        $this->player1 = $this->createPlayer('Antoine', 1599);
        $this->player2 = $this->createPlayer('Simon Gauzy', 3480);
        $this->player3 = $this->createPlayer('Rox', null);
        $this->player4 = $this->createPlayer('Matthias', 1140);
    }

    public function testAdd(): PlayerCollection
    {
        $collection = new PlayerCollection();
        $collection->add($this->player1);
        $collection->add($this->player2);

        $this->assertCount(2, $collection);

        $collection->add($this->player3);
        $collection->add($this->player4);

        $this->assertCount(4, $collection);

        return $collection;
    }

    public function testLast(): void
    {
        $collection = new PlayerCollection();

        $collection->add($this->player1);
        $collection->add($this->player2);
        $collection->add($this->player3);

        $this->assertEquals($this->player3, $collection->last());
    }

    /**
     * @dataProvider playersToSortProviders
     */
    public function testSortByRankingPoints(PlayerCollection $collection): void
    {
        $collection->sortByRankingPoints();

        foreach ($collection as $index => $player)
        {
            if ($index === 0)
            {
                continue;
            }

            $this->assertLessThanOrEqual(
                $collection[--$index]->rankingPoints()->value(),
                $player->rankingPoints()->value()
            );
        }
    }

    private function createPlayer(string $name, ?int $points): Player
    {
        $player = new Player(new Uuid(), $name);
        $player->setRankingPoints(new RankingPoints($points));

        return $player;
    }

    public function playersToSortProviders(): \Traversable
    {
        $player1 = $this->createPlayer('Antoine', 1599);
        $player2 = $this->createPlayer('Simon', 3480);
        $player3 = $this->createPlayer('Rox', null);
        $player4 = $this->createPlayer('Matthias', 1140);
        $player5 = $this->createPlayer('Mickaël', 1140);

        yield [
            (new PlayerCollection())
                ->add($player1)
                ->add($player2)
                ->add($player3)
                ->add($player4)
                ->add($player5)
        ];
        yield [
            (new PlayerCollection())
                ->add($player5)
                ->add($player4)
                ->add($player3)
                ->add($player2)
                ->add($player1)
        ];
        yield [
            (new PlayerCollection())
                ->add($player3)
                ->add($player2)
                ->add($player1)
        ];
    }
}
