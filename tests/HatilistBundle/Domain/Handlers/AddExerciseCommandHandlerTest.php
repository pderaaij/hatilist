<?php
declare(strict_types=1);

namespace HatilistBundle\Tests\Domain\Handlers;

use HatilistBundle\Domain\Exercise\Command\AddExerciseCommand;
use HatilistBundle\Domain\Exercise\Handlers\AddExerciseCommandHandler;
use HatilistBundle\Domain\Exercise\Repository\ItemRepository;
use HatilistBundle\Domain\User\User;
use PHPUnit\Framework\TestCase;

class AddExerciseCommandHandlerTest extends TestCase
{

    /**
     * @var AddExerciseCommandHandler
     */
    private $commandHandler = null;

    /**
     * @var ItemRepository|\PHPUnit_Framework_MockObject_MockObject
     */
    private $mockedItemRepository = null;

    /**
     * @var User|\PHPUnit_Framework_MockObject_MockObject
     */
    private $mockedOwner = null;

    protected function setUp()
    {
        $this->mockedItemRepository = $this->createMock(ItemRepository::class);

        $this->commandHandler = new AddExerciseCommandHandler(
          $this->mockedItemRepository
        );

        $this->mockedOwner = $this->createMock(User::class);
        $this->mockedOwner->method('getId')->willReturn(11);
    }

    public function testAddExerciseCommandPassesSuccessfully()
    {
        $command = new AddExerciseCommand(
            "title",
            "description",
            $this->mockedOwner
        );

        $this->mockedItemRepository->expects($this->once())->method('save');
        $this->commandHandler->handle($command);
    }

    /**
     * @expectedException   \InvalidArgumentException
     * @expectedExceptionMessage Title can't be empty.
     */
    public function testCommandWithoutTitleWillNotBeAccepted()
    {
        $command = new AddExerciseCommand(
            "",
            "description",
            $this->mockedOwner
        );

        $this->commandHandler->handle($command);
    }

    /**
     * @expectedException   \InvalidArgumentException
     * @expectedExceptionMessage Description can't be empty.
     */
    public function testCommandWithoutDescriptionWillNotBeAccepted()
    {
        $command = new AddExerciseCommand(
            "title",
            "",
            $this->mockedOwner
        );

        $this->commandHandler->handle($command);
    }

    /**
     * @expectedException   \InvalidArgumentException
     * @expectedExceptionMessage Owner has to be assigned
     */
    public function testCommandWithoutValidUserWillNotBeAccepted()
    {
        $this->mockedOwner = $this->createMock(User::class);
        $this->mockedOwner->method('getId')->willReturn(0);

        $command = new AddExerciseCommand(
            "title",
            "description",
            $this->mockedOwner
        );

        $this->commandHandler->handle($command);
    }
}