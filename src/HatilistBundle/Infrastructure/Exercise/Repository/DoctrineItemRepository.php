<?php
declare(strict_types=1);

namespace HatilistBundle\Infrastructure\Exercise\Repository;

use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityManagerInterface;
use HatilistBundle\Domain\Exercise\Item;
use HatilistBundle\Domain\Exercise\Repository\ItemRepository;

class DoctrineItemRepository implements ItemRepository
{

    /**
     * @var EntityManagerInterface
     */
    private $entityManager = null;

    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @return Item[]
     */
    public function getAll(): array
    {
        return $this->entityManager
            ->getRepository('HatilistBundle:Exercise\Item')
            ->findAll();
    }

    /**
     * @param string $exerciseId
     * @return Item
     */
    public function findById(string $exerciseId): Item
    {
        return $this->entityManager
            ->getRepository('HatilistBundle:Exercise\Item')
            ->find($exerciseId);
    }

    /**
     * @param int $numberOfItems
     * @return Item[]
     */
    public function findRecent(int $numberOfItems): array
    {
        return $this->entityManager
            ->getRepository('HatilistBundle:Exercise\Item')
            ->findBy(
                [],
                ['created' => Criteria::DESC],
                $numberOfItems
            );

    }
}