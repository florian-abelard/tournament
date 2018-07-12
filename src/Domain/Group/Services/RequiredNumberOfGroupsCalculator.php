<?php

declare(strict_types= 1);

namespace Flo\Tournoi\Domain\Group\Services;

class RequiredNumberOfGroupsCalculator
{
    public function calculate(int $playersNumber, int $placesNumberInGroup): int
    {
        try
        {
            $result = $playersNumber / $placesNumberInGroup;
            $result = ceil($result);
            $result = (int) $result;
        }
        catch (\Exception $e)
        {
            throw new \RuntimeException('Unable to calculate required groups number : ' . $e->getMessage());
        }

        return $result;
    }
}
