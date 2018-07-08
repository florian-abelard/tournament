<?php

declare(strict_types = 1);

namespace Flo\Tournoi\Tests\Domain\Core\ValueObjects;

use Flo\Tournoi\Domain\Core\Exceptions\InvalidUuidException;
use Flo\Tournoi\Domain\Core\ValueObjects\Uuid;
use PHPUnit\Framework\TestCase;

class UuidTest extends TestCase
{
    private const
        VALID_UUID = 'a9d20e72-e26b-42db-b805-b9cac9ae171f',
        VALID_UUID_2 = 'e3b4359b-9723-41c2-8725-95dd26440b4f',
        INVALID_UUID = 'dazd-fazf465f46a0-f6az50';

    public function testCreation()
    {
        $uuid = new Uuid();

        $this->assertNotEmpty($uuid->value());
        $this->assertInternalType('string', $uuid->value());
    }

    public function testCreationWithValidUuid()
    {
        $uuid = new Uuid(self::VALID_UUID);

        $this->assertSame(self::VALID_UUID, $uuid->value());
    }

    public function testCreationWithInvalidUuid()
    {
        $this->expectException(InvalidUuidException::class);

        $uuid = new Uuid(self::INVALID_UUID);
    }

    public function testUuidsAreEqual()
    {
        $uuid1 = new Uuid(self::VALID_UUID);
        $uuid2 = new Uuid(self::VALID_UUID);

        $this->assertTrue($uuid1->equals($uuid2));
    }

    /**
     * @dataProvider notEqualUuidsProvider
     */
    public function testUuidsAreNotEqual(?string $uuid1, ?string $uuid2)
    {
        $uuid1 = new Uuid($uuid1);
        $uuid2 = new Uuid($uuid2);

        $this->assertFalse($uuid1->equals($uuid2));
    }

    public function notEqualUuidsProvider()
    {
        yield [self::VALID_UUID, self::VALID_UUID_2];
        yield [self::VALID_UUID, null];
        yield [null, self::VALID_UUID];
        yield [null, null];
    }

    public function testToString()
    {
        $uuid1 = new Uuid();
        $uuid2 = new Uuid((string) $uuid1);

        $this->assertEquals($uuid1, $uuid2);
    }

    public function testFromString()
    {
        $uuid = Uuid::fromString(self::VALID_UUID);

        $this->assertSame(self::VALID_UUID, $uuid->value());
    }
}
