<?php
declare(strict_types=1);

namespace HatilistBundle\Domain\Exercise\Repository;

use HatilistBundle\Domain\Exercise\Item;

interface ItemRepository
{
    /**
     * @return Item[]
     */
    public function getAll() : array;
}