<?php
declare(strict_types=1);

namespace HatilistBundle\Domain\Exercise\Handlers;

use HatilistBundle\Domain\Exercise\Command\AddExerciseCommand;
use HatilistBundle\Domain\Exercise\Item;
use HatilistBundle\Domain\Exercise\Repository\ItemRepository;

class AddExerciseCommandHandler
{
    /**
     * @var ItemRepository
     */
    private $itemRepository = null;

    /**
     * @param ItemRepository $itemRepository
     */
    public function __construct(ItemRepository $itemRepository)
    {
        $this->itemRepository = $itemRepository;
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

        $item = new Item();
        $item->setTitle($command->getTitle());
        $item->setDescription($command->getDescription());
        $item->setOwner($command->getOwner());
        $item->setCreated(new \DateTime());

        $this->itemRepository->save($item);
    }
}