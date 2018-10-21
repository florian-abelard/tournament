<?php

declare(strict_types = 1);

namespace Flo\Tournoi\Tests\Domain\game\Collections;

use Flo\Tournoi\Domain\Core\ValueObjects\Uuid;
use Flo\Tournoi\Domain\Game\Collections\GroupGameCollection;
use Flo\Tournoi\Domain\Game\Entities\GroupGame;
use Flo\Tournoi\Domain\Player\Entities\Player;
use PHPUnit\Framework\TestCase;

class GroupGameCollectionTest extends TestCase
{
    private
        $game1,
        $game2,
        $game3,
        $game4;


    public function setUp(): void
    {
        $this->game1 = $this->createGame(1);
        $this->game2 = $this->createGame(2);
        $this->game3 = $this->createGame(3);
        $this->game4 = $this->createGame(4);
    }

    public function testAdd(): GroupGameCollection
    {
        $collection = new GroupGameCollection();
        $collection->add($this->game1);
        $collection->add($this->game2);

        $this->assertCount(2, $collection);

        $collection->add($this->game3);
        $collection->add($this->game4);

        $this->assertCount(4, $collection);

        return $collection;
    }

    /**
     * @dataProvider GamesToSortProviders
     */
   public function testSortByPosition(GroupGameCollection $collection): void
   {
       $collection->sortByPosition();

       foreach ($collection as $index => $game)
       {
           if ($index === 0)
           {
               continue;
           }

           $this->assertGreaterThan(
               $collection[--$index]->position(),
               $game->position()
           );
       }
   }

    public function createGame(int $position = 1): GroupGame
    {
        $game = new GroupGame(
            new Uuid(),
            $this->createMock(Player::class),
            $this->createMock(Player::class),
            new Uuid(),
            new Uuid()
        );
        $game->setPosition($position);

        return $game;
    }

    public function GamesToSortProviders(): \Traversable
    {
        $game1 = $this->createGame(1);
        $game2 = $this->createGame(2);
        $game3 = $this->createGame(5);
        $game4 = $this->createGame(3);

        yield [
            (new GroupGameCollection())
                ->add($game1)
                ->add($game2)
                ->add($game3)
                ->add($game4)
        ];
        yield [
            (new GroupGameCollection())
                ->add($game4)
                ->add($game3)
                ->add($game2)
                ->add($game1)
        ];
    }
}
