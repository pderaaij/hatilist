<?php
declare(strict_types=1);

namespace HatilistBundle\Controller\Exercise;

use HatilistBundle\Domain\Exercise\Command\AddExerciseCommand;
use HatilistBundle\Domain\Exercise\Item;
use HatilistBundle\Infrastructure\Exercise\Form\AddExerciseForm;
use League\Tactician\CommandBus;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AddExerciseController extends Controller
{

    /**
     * @var CommandBus
     */
    private $commandBus = null;

    /**
     * @param CommandBus $commandBus
     */
    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
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

            $command = new AddExerciseCommand(
                $item->getTitle(),
                $item->getDescription(),
                $this->getUser()
            );

            $this->commandBus->handle($command);

            return $this->redirectToRoute('recently-added');
        }

        return $this->render(
            'HatilistBundle:Exercise:add.html.twig',
            [ 'form' => $form->createView() ]
        );
    }
}