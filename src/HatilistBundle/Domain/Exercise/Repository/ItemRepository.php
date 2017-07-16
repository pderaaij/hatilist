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

    /**
     * @param string $exerciseId
     * @return Item
     */
    public function findById(string $exerciseId) : Item;

    /**
     * @param int $numberOfItems
     * @return Item[]
     */
    public function findRecent(int $numberOfItems): array;

}