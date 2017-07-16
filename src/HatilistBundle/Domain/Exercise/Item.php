<?php
declare(strict_types=1);

namespace HatilistBundle\Domain\Exercise;

use Doctrine\ORM\Mapping as ORM;
use HatilistBundle\Domain\User\User;

/**
 * @ORM\Entity
 * @Orm\Table(name="ExerciseItem")
 */
class Item
{
    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="guid")
     * @ORM\GeneratedValue(strategy="UUID")
     * @var string
     */
    protected $id = null;

    /**
     * @ORM\Column(type="string", length=255)
     * @var string
     */
    protected $title = null;

    /**
     * @ORM\Column(type="text")
     * @var string
     */
    protected $description = null;

    /**
     * @ORM\ManyToOne(targetEntity="HatilistBundle\Domain\User\User")
     * @ORM\JoinColumn(nullable=false)
     * @var User
     */
    protected $owner = null;

    /**
     * @param string $id
     */
    public function setId(string $id)
    {
        $this->id = $id;
    }

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
     * @param User $owner
     */
    public function setOwner(User $owner)
    {
        $this->owner = $owner;
    }

}