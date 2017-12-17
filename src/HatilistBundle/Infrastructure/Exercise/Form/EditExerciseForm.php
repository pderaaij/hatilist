<?php
declare(strict_types=1);

namespace HatilistBundle\Infrastructure\Exercise\Form;

use HatilistBundle\Infrastructure\Exercise\Form\Entities\ExerciseFormEntity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditExerciseForm extends AbstractType
{

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ExerciseFormEntity::class
        ]);
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id', HiddenType::class)
            ->add('title')
            ->add('description',null, [ 'attr' => [ 'rows' => 8 ]])
            ->add('save', SubmitType::class);
    }

}