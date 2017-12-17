<?php
declare(strict_types=1);

namespace HatilistBundle\Domain\Exercise\Handlers;

use HatilistBundle\Domain\Exercise\Command\ChangeExerciseCommand;
use HatilistBundle\Domain\Exercise\Exception\ExerciseNotFoundException;
use HatilistBundle\Domain\Exercise\Repository\ItemRepository;

class ChangeExerciseCommandHandler
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
     * @param ChangeExerciseCommand $command
     */
    public function handle(ChangeExerciseCommand $command)
    {
        $exercise = $this->itemRepository->findById($command->getExerciseId());

        $exercise->nameExercise($command->getTitle());
        $exercise->describeExercise($command->getDescription());

        $this->itemRepository->save($exercise);
    }


}