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
     * @return Label[]
     */
    public function getLabels(): array
    {
        return $this->labels;
    }

    /**
     * @return User
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * @param User $owner
     */
    public function setOwner(User $owner)
    {
        $this->owner = $owner;
    }

    /**
     * @return \DateTime
     */
    public function getCreated(): \DateTime
    {
        return $this->created;
    }

    /**
     * @return \DateTime
     */
    public function getLastUpdate(): \DateTime
    {
        return $this->lastUpdate;
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


    // TODO: To remove, just here to support forms

    /**
     * @param string $title
     */
    public function setTitle(string $title)
    {
        $this->title = $title;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description)
    {
        $this->description = $description;
    }

}