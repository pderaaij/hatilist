<?php
declare(strict_types=1);

namespace HatilistBundle\Domain\Exercise;

use HatilistBundle\Domain\User\User;

class Item
{
    /**
     * @var string
     */
    protected $id = null;

    /**
     * @var string
     */
    protected $title = "";

    /**
     * @var string
     */
    protected $description = "";

    /**
     * @var Label[]
     */
    protected $labels = [];

    /**
     * @var User
     */
    protected $owner = null;

    /**
     * @var \DateTime
     */
    protected $created = null;

    /**
     * @var \DateTime
     */
    protected $lastUpdate = null;

    /**
     * @param string $id
     * @param string $title
     */
    protected function __construct(string $id, string $title)
    {
        $this->id = $id;
        $this->title = $title;
        $this->created = new \DateTime();
    }

    /**
     * @param string $id
     * @param string $title
     * @return Item
     */
    public static function create(string $id, string $title) 
    {
       return (new self($id, $title));
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
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
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * @param $description
     */
    public function describeExercise(string $description)
    {
        $this->description = $description;
    }

    /**
     * @param User $owner
     */
    public function assignOwner(User $owner)
    {
        $this->owner = $owner;
    }

    /**
     * @param User $owner
     */
    public function setOwner(User $owner)
    {
        $this->owner = $owner;
    }
}