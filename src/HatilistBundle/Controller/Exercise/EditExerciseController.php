<?php
declare(strict_types=1);

namespace HatilistBundle\Controller\Exercise;

use HatilistBundle\Domain\Exercise\Command\ChangeExerciseCommand;
use HatilistBundle\Domain\Exercise\Repository\ItemRepository;
use HatilistBundle\Infrastructure\Exercise\Form\EditExerciseForm;
use HatilistBundle\Infrastructure\Exercise\Form\Entities\ExerciseFormEntity;
use League\Tactician\CommandBus;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class EditExerciseController extends Controller
{

    /**
     * @var CommandBus
     */
    private $commandBus = null;

    /**
     * @var ItemRepository
     */
    private $exerciseRepository = null;

    /**
     * @param CommandBus $commandBus
     * @param ItemRepository $exerciseRepository
     */
    public function __construct(
        CommandBus $commandBus,
        ItemRepository $exerciseRepository
    ) {
        $this->commandBus = $commandBus;
        $this->exerciseRepository = $exerciseRepository;
    }

    /**
     * @Route("/exercise/edit/{id}", name="edit-exercise")
     * @param string $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editView(string $id)
    {

        $exercise = $this->exerciseRepository->findById($id);
        $formEntity = new ExerciseFormEntity();

        $formEntity->setId($exercise->getId());
        $formEntity->setTitle($exercise->getTitle());
        $formEntity->setDescription($exercise->getDescription());

        $form = $this
            ->createForm(
                EditExerciseForm::class,
                $formEntity,
                [
                    'action' => $this->generateUrl("change-exercise"),
                    'method' => 'POST'
                ]
            );

        return $this->render(
            'HatilistBundle:Exercise:edit.html.twig',
            [ 'form' => $form->createView() ]
        );
    }

    /**
     * @Route("/exercise/change", name="change-exercise")
     * @Method(methods={"POST"})
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function changeView(Request $request)
    {
        $form = $this->createForm(EditExerciseForm::class, new ExerciseFormEntity());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var ExerciseFormEntity $item */
            $item = $form->getData();

            $command = new ChangeExerciseCommand(
                $item->getId(),
                $item->getTitle(),
                $item->getDescription()
            );

            $this->commandBus->handle($command);

            return $this->redirectToRoute('exercise-view', [ 'exerciseId' => $item->getId() ]);
        }

        return $this->render(
            'HatilistBundle:Exercise:edit.html.twig',
            [ 'form' => $form->createView() ]
        );
    }
}