<?php

declare(strict_types = 1);

namespace Flo\Tournoi\Tests\Domain\Stage\Entities;

use Flo\Tournoi\Domain\Core\ValueObjects\Uuid;
use Flo\Tournoi\Domain\Registration\Entities\Registration;
use Flo\Tournoi\Persistence\Registration\DataTransferObjects as DTO;
use PHPUnit\Framework\TestCase;

class RegistrationTest extends TestCase
{
    private
        $playerUuid,
        $tournamentUuid,
        $registrationDate;

    public function setUp()
    {
        $this->playerUuid = new Uuid();
        $this->tournamentUuid = new Uuid();
        $this->registrationDate = new \DateTime();
    }

    public function testCreateEntity()
    {
        $registration = $this->buildRegistration();

        $this->assertEquals($this->playerUuid, $registration->playerUuid());
        $this->assertEquals($this->tournamentUuid, $registration->tournamentUuid());
        $this->assertEquals($this->registrationDate, $registration->registrationDate());
    }

    public function testToDTO()
    {
        $registration = $this->buildRegistration();

        $dto = $registration->toDTO();

        $this->assertInstanceOf(DTO\Registration::class, $dto);
        $this->assertSame($registration->playerUuid()->value(), $dto->playerUuid());
        $this->assertSame($registration->tournamentUuid()->value(), $dto->tournamentUuid());
        $this->assertSame($registration->registrationDate()->format('Y-m-d H:i:s'), $dto->registrationDate());
    }

    public function buildRegistration(): Registration
    {
        $registration = new Registration(
            $this->playerUuid,
            $this->tournamentUuid,
            $this->registrationDate
        );

        return $registration;
    }
}
