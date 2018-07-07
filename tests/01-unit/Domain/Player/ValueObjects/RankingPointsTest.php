<?php

declare(strict_types = 1);

namespace Flo\Tournoi\Tests\Domain\Player\Collections;

use Flo\Tournoi\Domain\Player\Exceptions\InvalidRankingPointsException;
use Flo\Tournoi\Domain\Player\ValueObjects\RankingPoints;
use PHPUnit\Framework\TestCase;

class RankingPointTtest extends TestCase
{

    /**
     * @dataProvider validRankingPointsProvider
     */
    public function testCreationOfValidRankingPoints($pointsNumber)
    {
        $rankingPoints = new RankingPoints($pointsNumber);

        $this->assertEquals($pointsNumber, $rankingPoints->value());
    }

    public function testCreationOfEmptyRankingPoints()
    {
        $rankingPoints = new RankingPoints();

        $this->assertNull($rankingPoints->value());
    }

    /**
     * @dataProvider outOfRangeRankingPointsProvider
     */
    public function testCreationOfOutOfRangeRankingPoints($pointsNumber)
    {
        $this->expectException(InvalidRankingPointsException::class);

        $rankingPoints = new RankingPoints($pointsNumber);
    }

    public function testEquals()
    {
        $rankingPoints1 = new RankingPoints(1500);
        $rankingPoints2 = new RankingPoints(1500);
        $rankingPoints3 = new RankingPoints(1400);

        $this->assertTrue($rankingPoints1->equals($rankingPoints2));
        $this->assertFalse($rankingPoints1->equals($rankingPoints3));
    }

    public function testlowerThan()
    {
        $rankingPoints1 = new RankingPoints(1500);
        $rankingPoints2 = new RankingPoints(1500);
        $rankingPoints3 = new RankingPoints(1400);

        $this->assertTrue($rankingPoints3->lowerThan($rankingPoints1));
        $this->assertFalse($rankingPoints1->lowerThan($rankingPoints2));
        $this->assertFalse($rankingPoints1->lowerThan($rankingPoints3));
    }

    public function testGreaterThan()
    {
        $rankingPoints1 = new RankingPoints(1500);
        $rankingPoints2 = new RankingPoints(1500);
        $rankingPoints3 = new RankingPoints(1400);

        $this->assertTrue($rankingPoints1->greaterThan($rankingPoints3));
        $this->assertFalse($rankingPoints1->greaterThan($rankingPoints2));
        $this->assertFalse($rankingPoints3->greaterThan($rankingPoints1));
    }

    public function validRankingPointsProvider()
    {
        yield [1];
        yield [5000];
        yield [1599];
    }

    public function outOfRangeRankingPointsProvider()
    {
        yield ['lower than expected' => -1];
        yield ['zero' => 0];
        yield ['greater than expected' => 54800];
    }
}
