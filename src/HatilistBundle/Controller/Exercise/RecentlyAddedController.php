<?php
declare(strict_types=1);

namespace HatilistBundle\Controller\Exercise;

use HatilistBundle\Domain\Exercise\Repository\ItemRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class RecentlyAddedController extends Controller
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
     * @Route("recently-added", name="recently-added")
     */
    public function listAction()
    {
        $recentItems = $this->exerciseRepository->getAll();

        return $this->render(
            'HatilistBundle:Exercise:recent.html.twig',
            [ 'recentItems' => $recentItems ]
        );
    }
}