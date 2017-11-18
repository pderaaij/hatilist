<?php
declare(strict_types=1);

namespace HatilistBundle\Infrastructure;

use HatilistBundle\Domain\Interfaces\UuidGenerator;
use Ramsey\Uuid\UuidFactory;

class UuidGeneratorImplementation implements UuidGenerator
{

    /**
     * Generates a V4 UUID
     * @return string
     */
    public function generateUuidV4(): string
    {
        $uuid = new UuidFactory();

        return $uuid->uuid4()->toString();
    }
}