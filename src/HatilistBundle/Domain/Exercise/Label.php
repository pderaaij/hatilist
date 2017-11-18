<?php
declare(strict_types=1);

namespace HatilistBundle\Domain\Exercise;

class Label
{
    /**
     * @var string
     */
    protected $id = null;

    /**
     * @var string
     */
    protected $name = "";

    /**
     * @var string
     */
    protected $slug = "";

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
     * @param string $name
     */
    protected function __construct(string $id, string $name) 
    {
        $this->id = $id;
        $this->name = $name;
    }

    /**
     * @param string $id
     * @param string $name
     * @return Label
     */
    public static function create(string $id, string $name)
    {
        return (new self($id, $name));
    }

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