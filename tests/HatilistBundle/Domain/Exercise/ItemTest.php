<?php
declare(strict_types=1);

namespace Tests\HatilistBundle\Domain\Exercise;

use HatilistBundle\Domain\Exercise\Item;
use HatilistBundle\Domain\User\User;
use PHPUnit\Framework\TestCase;

class ItemTest extends TestCase
{

    public function testDescribingAnExercise()
    {
        $item = Item::create('test', 'Test exercise');
        $item->describeExercise('Description of the item');

        $this->assertThat(
            $item->getTitle(),
            $this->equalTo('Test exercise')
        );

        $this->assertThat(
            $item->getDescription(),
            $this->equalTo('Description of the item')
        );
    }

    public function testAssigningAnOwnerToAnExercise()
    {
        $item = Item::create('test', 'Test exercise');
        $mockedOwner = $this->createMock(User::class);
        $mockedOwner->method('getId')->willReturn('ASE3');
        $item->assignOwner($mockedOwner);

        $this->assertThat(
            $item->getOwner()->getId(),
            $this->equalTo('ASE3')
        );
    }
}