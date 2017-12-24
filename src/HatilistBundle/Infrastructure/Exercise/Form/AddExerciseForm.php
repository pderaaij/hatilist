<?php
declare(strict_types=1);

namespace HatilistBundle\Infrastructure\Exercise\Form;

use HatilistBundle\Domain\Exercise\Item;
use HatilistBundle\Infrastructure\Exercise\Form\Entities\ExerciseFormEntity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class AddExerciseForm extends AbstractType
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
            ->add('title', null, [
                'required' => true,
                'constraints' => [ new Length(['min' => 3])]
            ])
            ->add('description',null, [ 'attr' => [ 'rows' => 8 ]])
            ->add('save', SubmitType::class);
    }


}