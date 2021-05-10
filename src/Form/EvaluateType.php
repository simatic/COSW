<?php

namespace App\Form;

use App\Entity\Evaluate;
use App\Entity\Evaluation;
use App\Entity\FicheEvaluation;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EvaluateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('rubriques', CollectionType::class, [
            'entry_type' => RubriqueEvaluateType::class,
            'entry_options' => ['label' => false],])
            ->add('commentaire',null,['label'=>'Commentaire global'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => FicheEvaluation::class,
            'evaluation' => null,
        ]);
    }
}
