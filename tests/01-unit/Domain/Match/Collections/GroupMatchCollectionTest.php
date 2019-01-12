<?php

declare(strict_types = 1);

namespace Flo\Tournoi\Tests\Domain\match\Collections;

use Flo\Tournoi\Domain\Core\ValueObjects\Uuid;
use Flo\Tournoi\Domain\Match\Collections\GroupMatchCollection;
use Flo\Tournoi\Domain\Match\Entities\GroupMatch;
use Flo\Tournoi\Domain\Player\Entities\Player;
use PHPUnit\Framework\TestCase;

class GroupMatchCollectionTest extends TestCase
{
    private
        $match1,
        $match2,
        $match3,
        $match4;


    public function setUp(): void
    {
        $this->match1 = $this->createMatch(1);
        $this->match2 = $this->createMatch(2);
        $this->match3 = $this->createMatch(3);
        $this->match4 = $this->createMatch(4);
    }

    public function testAdd(): GroupMatchCollection
    {
        $collection = new GroupMatchCollection();
        $collection->add($this->match1);
        $collection->add($this->match2);

        $this->assertCount(2, $collection);

        $collection->add($this->match3);
        $collection->add($this->match4);

        $this->assertCount(4, $collection);

        return $collection;
    }

    /**
     * @dataProvider MatchesToSortProviders
     */
   public function testSortByPosition(GroupMatchCollection $collection): void
   {
       $collection->sortByPosition();

       foreach ($collection as $index => $match)
       {
           if ($index === 0)
           {
               continue;
           }

           $this->assertGreaterThan(
               $collection[--$index]->position(),
               $match->position()
           );
       }
   }

    public function createMatch(int $position = 1): GroupMatch
    {
        $match = new GroupMatch(
            new Uuid(),
            $this->createMock(Player::class),
            $this->createMock(Player::class),
            new Uuid(),
            new Uuid()
        );
        $match->setPosition($position);

        return $match;
    }

    public function MatchesToSortProviders(): \Traversable
    {
        $match1 = $this->createMatch(1);
        $match2 = $this->createMatch(2);
        $match3 = $this->createMatch(5);
        $match4 = $this->createMatch(3);

        yield [
            (new GroupMatchCollection())
                ->add($match1)
                ->add($match2)
                ->add($match3)
                ->add($match4)
        ];
        yield [
            (new GroupMatchCollection())
                ->add($match4)
                ->add($match3)
                ->add($match2)
                ->add($match1)
        ];
    }
}
