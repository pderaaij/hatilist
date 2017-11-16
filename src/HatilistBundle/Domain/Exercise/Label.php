<?php
declare(strict_types=1);

namespace HatilistBundle\Domain\Exercise;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @Orm\Table(name="ExerciseLabel")
 */
class Label
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
    protected $name = "";

    /**
     * @ORM\Column(type="string", unique=true)
     * @var string
     */
    protected $slug = "";

    /**
     * @ORM\Column(type="datetime")
     * @var \DateTime
     */
    protected $created = null;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @var \DateTime
     */
    protected $lastUpdate = null;

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId(string $id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;

        // TODO
        $this->slug = $name;
    }

    /**
     * @return string
     */
    public function getSlug(): string
    {
        return $this->slug;
    }

    /**
     * @return \DateTime
     */
    public function getCreated(): \DateTime
    {
        return $this->created;
    }

    /**
     * @param \DateTime $created
     */
    public function setCreated(\DateTime $created)
    {
        $this->created = $created;
    }

    /**
     * @return \DateTime
     */
    public function getLastUpdate(): \DateTime
    {
        return $this->lastUpdate;
    }

    /**
     * @param \DateTime $lastUpdate
     */
    public function setLastUpdate(\DateTime $lastUpdate)
    {
        $this->lastUpdate = $lastUpdate;
    }

}