<?php
declare(strict_types=1);

namespace HatilistBundle\Domain\Interfaces;


interface UuidGenerator
{

    /**
     * Generates a V4 UUID
     * @return string
     */
    public function generateUuidV4(): string;
}