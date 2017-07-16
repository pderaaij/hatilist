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
    private $exerciseItemRepository = null;

    /**
     * @param ItemRepository $exerciseItemRepository
     */
    public function __construct(ItemRepository $exerciseItemRepository)
    {
        $this->exerciseItemRepository = $exerciseItemRepository;
    }

    /**
     * @Route("recently-added", name="recently-added")
     */
    public function listAction()
    {
        $recentItems = $this->exerciseItemRepository->getAll();

        return $this->render(
            'HatilistBundle:Exercise:recent.html.twig',
            [ 'recentItems' => $recentItems ]
        );
    }
}