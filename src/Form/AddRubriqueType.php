<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddRubriqueType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('Rubrique', ChoiceType::class, ['label'=>'Rubrique',
            'choices'=> $this->getChoixRubrique($options['rubriques'])]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
            'rubriques'=>null,
        ]);
    }
    private function getChoixRubrique($tableau)
    {
        $output = [];
        $i = 0;
        if (is_array($tableau) || is_object($tableau)) {
            foreach ($tableau as $v) {

                $output[$v->getId()] = $v->getTitle();;
                $i++;
            }
        }
        return array_flip($output);
    }
}
