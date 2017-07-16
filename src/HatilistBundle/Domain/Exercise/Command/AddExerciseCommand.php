<?php
declare(strict_types=1);

namespace HatilistBundle\Domain\Exercise\Command;

use HatilistBundle\Domain\User\User;

class AddExerciseCommand
{
    /**
     * @var string
     */
    private $title = "";

    /**
     * @var string
     */
    private $description = "";

    /**
     * @var User
     */
    private $owner = null;

    /**
     * @param string $title
     * @param string $description
     * @param User $owner
     */
    public function __construct(string $title, string $description, User $owner)
    {
        $this->title = $title;
        $this->description = $description;
        $this->owner = $owner;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return User
     */
    public function getOwner(): User
    {
        return $this->owner;
    }
}