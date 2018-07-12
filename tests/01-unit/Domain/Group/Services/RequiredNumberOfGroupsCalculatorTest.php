<?php

declare(strict_types = 1);

namespace Flo\Tournoi\Tests\Domain\Group\Factories;

use Flo\Tournoi\Domain\Group\Services\RequiredNumberOfGroupsCalculator;
use PHPUnit\Framework\TestCase;

class RequiredNumberOfGroupsCalculatorTests extends TestCase
{
    /**
     * @dataProvider calculateProvider
     */
    public function testCalculate(
        int $numberOfPlayers,
        int $numberOfPlacesInGroup,
        int $numberOfGroupsExpected
    ){
        $calculator = new RequiredNumberOfGroupsCalculator();

        $numberOfGroups = $calculator->calculate($numberOfPlayers, $numberOfPlacesInGroup);

        $this->assertEquals($numberOfGroupsExpected, $numberOfGroups);
    }

    public function calculateProvider()
    {
        yield [12, 4, 3];
        yield [13, 4, 4];
        yield [12, 3, 4];
        yield [11, 3, 4];
        yield [5, 2, 3];
        yield [5, 1, 5];
    }
}
