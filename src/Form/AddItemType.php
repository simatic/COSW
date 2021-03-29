<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddItemType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('Item', ChoiceType::class, ['label'=>'Item',
            'choices'=> $this->getChoixItem($options['items'])]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
            'items'=>null,
        ]);
    }
    private function getChoixItem($tableau)
    {
        $output = [];
        $i = 0;
        foreach($tableau as $v) {

            $output[$v->getId()]=$v->getTitle();;
            $i++;
        }
        return array_flip($output);
    }
}
