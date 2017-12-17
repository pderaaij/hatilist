<?php
declare(strict_types=1);

namespace HatilistBundle\Domain\Exercise\Command;

class ChangeExerciseCommand
{

    /**
     * @var string
     */
    private $exerciseId = '';

    /**
     * @var string
     */
    private $title = '';

    /**
     * @var string
     */
    private $description = '';

    /**
     * @param string $exerciseId
     * @param string $title
     * @param string $description
     */
    public function __construct(string $exerciseId, string $title, string $description)
    {
        $this->exerciseId = $exerciseId;
        $this->title = $title;
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getExerciseId(): string
    {
        return $this->exerciseId;
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

}