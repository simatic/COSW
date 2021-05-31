<?php

namespace App\Form;

use App\Entity\Session;
use App\Entity\Soutenance;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SessionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', null, ['label'=>'Nom'])
            ->add('dateDebut', null, ['label'=>'Date de début'])
            ->add('dateFin', null, ['label'=>'Date de fin'])
            ->add('description', null, ['label'=>'Description'])
            ->add('texteMailEtudiant', null, ['label'=>'Mail envoyé aux étudiants', 'required' => false])
            ->add('texteMailJury', null, ['label'=>'Mail envoyé aux jurys', 'required' => false])
            ->add('soutenances', CollectionType::class, [
                'label' => 'Soutenances',
                'entry_type' => ChoiceType::class,
                'entry_options' => [
                    'label' => false,
                    'choices'  => $options['soutenances'],
                    'choice_label' => 'titre',
                    'placeholder' => 'Ajouter une soutenance',
                    'expanded' => false,

                ],
                'by_reference' => false,
                // this allows the creation of new forms and the prototype too
                'allow_add' => true,
                // self explanatory, this one allows the form to be removed
                'allow_delete' => true
            ])
        ;

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Session::class,
            'soutenances' => null,
        ]);
    }

    private function getChoixSoutenances($tableau)
    {
        $output = [];
        $i = 0;
        foreach($tableau as $v) {

            $output[$v->getId()]=$v->getTitre();;
            $i++;
        }
        asort($output);
        return array_flip($output);
    }
}
