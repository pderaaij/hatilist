<?php
declare(strict_types=1);

namespace Tests\HatilistBundle\Infrastructure\Exercise\Repository;

use Doctrine\DBAL\Connection;
use HatilistBundle\Domain\Exercise\Item;
use HatilistBundle\Domain\User\User;
use HatilistBundle\Infrastructure\Exercise\Repository\CleanItemRepository;
use PHPUnit\Framework\TestCase;

class CleanItemRepositoryTest extends TestCase
{

    /**
     * @var CleanItemRepository
     */
    private $cleanItemRepository = null;

    /**
     * @var Connection|\PHPUnit_Framework_MockObject_MockObject
     */
    private $mockedConnection = null;

    public function setUp()
    {
        $this->mockedConnection = $this->createMock(Connection::class);
        $this->cleanItemRepository = new CleanItemRepository(
            $this->mockedConnection
        );
    }

    public function testInsertingANewExercise()
    {
        $item = Item::create('new', 'new exercise');

        $mockedOwner = $this->createMock(User::class);
        $mockedOwner->method('getId')->willReturn(1);
        $item->setOwner($mockedOwner);

        $this->mockedConnection->expects($this->once())->method('fetchAssoc')->willReturn(false);

        $this->mockedConnection->expects($this->never())->method('update');
        $this->mockedConnection->expects($this->once())->method('insert')->with(
            'exerciseitem',
            [
                'id' => 'new',
                'title' => 'new exercise',
                'description' => '',
                'owner_id' => 1,
                'created' => $item->getCreated()->format('Y-m-d H:i:s')
            ]
        );

        $this->cleanItemRepository->save($item);
    }

    public function testUpdatingAnExercise()
    {
        $item = Item::create('existing', 'changed exercise');

        $mockedOwner = $this->createMock(User::class);
        $mockedOwner->method('getId')->willReturn(1);
        $item->setOwner($mockedOwner);

        $this->mockedConnection->expects($this->once())->method('fetchAssoc')->willReturn([
            'id' => 'existing',
            'title' => 'exercise',
            'description' => 'description'
        ]);

        $this->mockedConnection->expects($this->never())->method('insert');
        $this->mockedConnection->expects($this->once())->method('update')->with(
            'exerciseitem',
            [
                'title' => 'changed exercise',
                'description' => '',
                'last_update' => (new \DateTime())->format('Y-m-d H:i:s')
            ],
            [
                'id' => 'existing'
            ]
        );

        $this->cleanItemRepository->save($item);
    }

    /**
     * @expectedException \HatilistBundle\Domain\Exercise\Exception\ExerciseNotFoundException
     */
    public function testFindingANonExistentItemThrowsException()
    {
        $this->mockedConnection->expects($this->once())->method('fetchAssoc')->willReturn(false);

        $this->cleanItemRepository->findById('i-do-not-exist');
    }

    public function testHydrationOfExerciseItem()
    {
        $this->mockedConnection
            ->expects($this->once())
            ->method('fetchAssoc')
            ->willReturn([
                'id' => '297ff1ca-fc7f-4ff0-a9e3-90b9cd773817',
                'title' => 'exercise title',
                'description' => 'exercise description',
                'username' => 'pderaaij',
                'userid' => 100,
                'created' => '2017-12-17 08:04:26'
            ]);

        $exercise = $this->cleanItemRepository->findById('297ff1ca-fc7f-4ff0-a9e3-90b9cd773817');

        $this->assertEquals('297ff1ca-fc7f-4ff0-a9e3-90b9cd773817', $exercise->getId());
        $this->assertEquals('exercise title', $exercise->getTitle());
        $this->assertEquals('exercise description', $exercise->getDescription());
        $this->assertEquals('pderaaij', $exercise->getOwner()->getUsername());
        $this->assertEquals(100, $exercise->getOwner()->getId());
    }
}