<?php
declare(strict_types=1);

namespace HatilistBundle\Domain\Exercise\Handlers;

use HatilistBundle\Domain\Exercise\Command\AddExerciseCommand;
use HatilistBundle\Domain\Exercise\Item;
use HatilistBundle\Domain\Exercise\Repository\ItemRepository;
use HatilistBundle\Domain\Interfaces\UuidGenerator;

class AddExerciseCommandHandler
{
    /**
     * @var ItemRepository
     */
    private $itemRepository = null;

    /**
     * @var UuidGenerator
     */
    private $uuidGenerator = null;

    /**
     * @param ItemRepository $itemRepository
     * @param UuidGenerator $uuidGenerator
     */
    public function __construct(
        ItemRepository $itemRepository,
        UuidGenerator $uuidGenerator
    ) {
        $this->itemRepository = $itemRepository;
        $this->uuidGenerator = $uuidGenerator;
    }

    /**
     * @param AddExerciseCommand $command
     */
    public function handle(AddExerciseCommand $command)
    {
        if (empty($command->getTitle())) {
            throw new \InvalidArgumentException("Title can't be empty.");
        }

        if (empty($command->getDescription())) {
            throw new \InvalidArgumentException("Description can't be empty.");
        }

        if ($command->getOwner() === null || empty($command->getOwner()->getId()) ) {
            throw new \InvalidArgumentException("Owner has to be assigned");
        }

        $item = Item::create($this->uuidGenerator->generateUuidV4(), $command->getTitle());
        $item->describeExercise($command->getDescription());
        $item->setOwner($command->getOwner());

        $this->itemRepository->save($item);
    }
}