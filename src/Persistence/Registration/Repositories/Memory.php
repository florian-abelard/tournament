<?php

declare(strict_types = 1);

namespace Flo\Tournoi\Persistence\Registration\Repositories;

use Flo\Tournoi\Domain\Core\ValueObjects\Uuid;
use Flo\Tournoi\Domain\Registration\Collections\RegistrationCollection;
use Flo\Tournoi\Domain\Registration\Entities\Registration;
use Flo\Tournoi\Domain\Registration\RegistrationRepository;
use Flo\Tournoi\Persistence\Core\Repositories\Mysql as MysqlAbstract;

class Memory extends MysqlAbstract implements RegistrationRepository
{
    public
        $collection;

    public function __construct(array $registrations = [])
    {
        $this->collection = new RegistrationCollection($registrations);
    }

    public function persist(Registration $registration): void
    {
        $this->collection->add($registration);
    }
}
