<?php
declare(strict_types=1);

namespace Tests\HatilistBundle\Infrastructure\Exercise\Form;

use HatilistBundle\Infrastructure\Exercise\Form\EditExerciseForm;
use HatilistBundle\Infrastructure\Exercise\Form\Entities\ExerciseFormEntity;
use Symfony\Component\Form\Extension\Validator\ValidatorExtension;
use Symfony\Component\Form\Forms;
use Symfony\Component\Form\Test\TypeTestCase;
use Symfony\Component\Validator\Validation;

class EditExerciseFormTest extends TypeTestCase
{

    public function setUp()
    {
        $this->factory = Forms::createFormFactoryBuilder()
            ->addExtension(new ValidatorExtension(Validation::createValidator()))
            ->getFormFactory();
    }

    public function testSuccessfulSubmissionOfForm()
    {
        $formData = [
            'id' => 'test-id',
            'title' => 'Oefening',
            'description' => 'Complete uitleg'
        ];

        $form = $this->factory->create(EditExerciseForm::class);

        $form->submit($formData);

        $this->assertTrue($form->isSynchronized());
        /** @var ExerciseFormEntity $formSubmittedData */
        $formSubmittedData = $form->getData();

        $this->assertEquals($formSubmittedData->getId(), 'test-id');
        $this->assertEquals($formSubmittedData->getTitle(), 'Oefening');
        $this->assertEquals($formSubmittedData->getDescription(), 'Complete uitleg');

        $view = $form->createView();
        $children = $view->children;

        foreach (array_keys($formData) as $key) {
            $this->assertArrayHasKey($key, $children);
        }
    }

    public function testTooShortTitleWillFail()
    {
        $formData = [
            'id' => 'test-id',
            'title' => 'Oe',
            'description' => 'Complete uitleg'
        ];

        $form = $this->factory->create(EditExerciseForm::class);

        $form->submit($formData);

        $this->assertTrue($form->isSynchronized());
        $this->assertFalse($form->isValid());

        $this->assertEquals(1, $form->get('title')->getErrors()->count());
    }

}