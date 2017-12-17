<?php
declare(strict_types=1);

namespace Tests\HatilistBundle\Domain\Exercise\Handlers;

use HatilistBundle\Domain\Exercise\Command\ChangeExerciseCommand;
use HatilistBundle\Domain\Exercise\Exception\ExerciseNotFoundException;
use HatilistBundle\Domain\Exercise\Handlers\ChangeExerciseCommandHandler;
use HatilistBundle\Domain\Exercise\Item;
use HatilistBundle\Domain\Exercise\Repository\ItemRepository;
use PHPUnit\Framework\TestCase;

class ChangeExerciseCommandHandlerTest extends TestCase
{

    /**
     * @var ChangeExerciseCommandHandler
     */
    private $commandHandler = null;

    /**
     * @var ItemRepository|\PHPUnit_Framework_MockObject_MockObject
     */
    private $mockedItemRepository = null;

    public function setUp()
    {
        $this->mockedItemRepository = $this->createMock(ItemRepository::class);

        $this->commandHandler = new ChangeExerciseCommandHandler($this->mockedItemRepository);
    }

    /**
     * @expectedException \HatilistBundle\Domain\Exercise\Exception\ExerciseNotFoundException
     */
    public function testNonExistingExerciseThrowsException()
    {
        $command = new ChangeExerciseCommand('not-existent', '','');

        $this->mockedItemRepository->method('findById')->willThrowException(new ExerciseNotFoundException());

        $this->commandHandler->handle($command);
    }

    public function testChangingAnExerciseSuccessful()
    {
        $command = new ChangeExerciseCommand('test', 'new title', 'new description');

        $item = Item::create('test', 'old-title');
        $this->mockedItemRepository->method('findById')->with('test')->willReturn($item);
        $this->mockedItemRepository->expects($this->once())->method('save');

        $this->commandHandler->handle($command);

        $this->assertThat($item->getTitle(), $this->equalTo($command->getTitle()));
        $this->assertThat($item->getDescription(), $this->equalTo($command->getDescription()));
    }
}