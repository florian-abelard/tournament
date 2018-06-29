<?php

declare(strict_types = 1);

namespace Flo\Tournoi\Persistence\Tournament\DataTransferObjects;

class Tournament
{
    private
        $uuid,
        $name,
        $status;

    public function __construct(string $uuid, string $name, string $status)
    {
        $this->uuid = $uuid;
        $this->name = $name;
        $this->status = $status;
    }

    public function uuid(): string
    {
        return $this->uuid;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function status(): string
    {
        return $this->status;
    }
}
