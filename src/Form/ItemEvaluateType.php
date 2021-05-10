<?php


namespace App\Form;


use App\Entity\Item;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class ItemEvaluateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', null, ['label'=>false,'disabled'=>true])
            ->add('note', null, ['label'=>'Note (0 à 100%) :','constraints' => new Assert\Range([
                'min' => 0,
                'max' => 100,
                'notInRangeMessage' => 'La note doit être comprise entre 0 et 100.',
            ])]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Item::class,
            'item' => null,
        ]);
    }
}