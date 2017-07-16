<?php
declare(strict_types=1);

namespace HatilistBundle\Controller\Exercise;

use HatilistBundle\Domain\Exercise\Item;
use HatilistBundle\Domain\Exercise\Repository\ItemRepository;
use HatilistBundle\Infrastructure\Exercise\Form\AddExerciseForm;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AddExerciseController extends Controller
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
     * @Route("/exercise/add", name="add-exercise")
     */
    public function addView()
    {
        $form = $this
            ->createForm(
                AddExerciseForm::class,
                new Item(),
                [
                    'action' => $this->generateUrl("save-exercise"),
                    'method' => 'POST'
                ]
            );

        return $this->render(
            'HatilistBundle:Exercise:add.html.twig',
            [ 'form' => $form->createView() ]
        );
    }

    /**
     * @Route("/exercise/save", name="save-exercise")
     * @Method(methods={"POST"})
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function saveView(Request $request)
    {
        $form = $this->createForm(AddExerciseForm::class, new Item());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Item $item */
            $item = $form->getData();
            $item->setOwner($this->getUser());
            $item->setCreated(new \DateTime());

            $this->exerciseRepository->save($item);

            return $this->redirectToRoute('recently-added');
        }

        return $this->render(
            'HatilistBundle:Exercise:add.html.twig',
            [ 'form' => $form->createView() ]
        );
    }
}