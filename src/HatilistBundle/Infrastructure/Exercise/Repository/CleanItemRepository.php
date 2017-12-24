<?php
declare(strict_types=1);

namespace HatilistBundle\Infrastructure\Exercise\Repository;

use Doctrine\DBAL\Connection;
use HatilistBundle\Domain\Exercise\Exception\ExerciseNotFoundException;
use HatilistBundle\Domain\Exercise\Item;
use HatilistBundle\Domain\Exercise\Repository\ItemRepository;
use HatilistBundle\Domain\User\User;
use Zend\Hydrator\Reflection;
use Zend\Hydrator\Strategy\DateTimeFormatterStrategy;

class CleanItemRepository implements ItemRepository
{

    /**
     * @var Connection
     */
    private $connection = null;

    /**
     * @param Connection $db
     */
    public function __construct(Connection $db)
    {
        $this->connection = $db;
    }

    /**
     * @return Item[]
     */
    public function getAll(): array
    {
        // TODO: Implement getAll() method.
    }

    /**
     * @param string $exerciseId
     * @return Item
     */
    public function findById(string $exerciseId): Item
    {
        $resultItem = $this->connection->fetchAssoc(
            "SELECT
                          ei.*,
                          fu.*,
                          fu.id as userId,
                          ei.id as id
                       FROM
                          exerciseitem ei
                       LEFT JOIN
                          fos_user fu ON fu.id = ei.owner_id
                       WHERE
                          ei.id = '$exerciseId'"
        );

        if ($resultItem ===  false) {
            throw new ExerciseNotFoundException("Could not find exercise with id " . $exerciseId);
        }

        return $this->hydrateExercise($resultItem);
    }

    /**
     * @param int $numberOfItems
     * @return Item[]
     */
    public function findRecent(int $numberOfItems): array
    {
        $result = $this->connection->fetchAll(
            "SELECT * FROM exerciseitem ORDER BY created DESC LIMIT $numberOfItems"
        );


        $items = [];

        foreach ($result as $resultItem) {
            $items[] = $this->hydrateExercise($resultItem);
        }

        return $items;
    }

    /**
     *
     * @param Item $item
     * @return void
     */
    public function save(Item $item)
    {
        try {
            $this->findById($item->getId());

            $this->connection->update(
                'exerciseitem',
                [
                    'title' => $item->getTitle(),
                    'description' => $item->getDescription(),
                    'last_update' => (new \DateTime())->format('Y-m-d H:i:s')
                ],
                [
                    'id' => $item->getId()
                ]
            );

        } catch (ExerciseNotFoundException $e) {
            $this->connection->insert(
                'exerciseitem',
                [
                    'id' => $item->getId(),
                    'title' => $item->getTitle(),
                    'description' => $item->getDescription(),
                    'owner_id' => $item->getOwner()->getId(),
                    'created' => $item->getCreated()->format('Y-m-d H:i:s')
                ]
            );
        }

    }

    /**
     * TODO: Find a better way for hydration
     *
     * @param $resultItem
     * @return Item
     */
    private function hydrateExercise($resultItem): Item
    {
        $hydrator = new Reflection();
        $hydrator->addStrategy('created', new DateTimeFormatterStrategy('Y-m-d H:i:s'));
        $hydrator->addStrategy('lastUpdated', new DateTimeFormatterStrategy('Y-m-d H:i:s'));

        $exercise = $hydrator->hydrate(
            $resultItem,
            (new \ReflectionClass(Item::class))->newInstanceWithoutConstructor()
        );

        if (array_key_exists('userid', $resultItem)) {
            $resultItem['id'] = $resultItem['userid'];
        }

        $user = $hydrator->hydrate(
            $resultItem,
            (new \ReflectionClass(User::class))->newInstanceWithoutConstructor()
        );

        $exercise->setOwner($user);

        return $exercise;
    }
}