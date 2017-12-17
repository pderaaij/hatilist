<?php
declare(strict_types=1);

namespace HatilistBundle\Controller\Exercise;

use HatilistBundle\Domain\Exercise\Repository\ItemRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class ExerciseController extends Controller
{
    /**
     * @var ItemRepository
     */
    private $exerciseRepository = null;

    /**
     * @param ItemRepository $exerciseRepository
     */
    public function __construct(ItemRepository $exerciseRepository)
    {
        $this->exerciseRepository = $exerciseRepository;
    }

    /**
     * @Route("exercise/{exerciseId}", name="exercise-view")
     * @param string $exerciseId
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function viewAction(string $exerciseId)
    {
        $exercise = $this->exerciseRepository->findById($exerciseId);

        return $this->render(
            'HatilistBundle:Exercise:item.html.twig',
            [ 'exercise' => $exercise ]
        );
    }

}