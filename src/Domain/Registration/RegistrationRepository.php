<?php

declare(strict_types = 1);

namespace Flo\Tournoi\Domain\Registration;

use Flo\Tournoi\Domain\Core\ValueObjects\Uuid;
use Flo\Tournoi\Domain\Registration\Entities\Registration;

interface RegistrationRepository
{
    public function persist(Registration $registration): void;
}
