<?php

namespace App\Form;

//use App\Entity\AccountRequest;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
//use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextareaType;

/**
 * Modèle de formulaire utilisé lorsqu'un administrateur de COS
 * refuse une demande de création de compte d'organisateur de 
 * soutenances. Ce modèle de formulaire ne comprend qu'un champ de 
 * type TextArea permettant d'expliquer la raison du refus de la 
 * demande de création de compte.
 * Ce modèle de formulaire est utilisé à "/admin/account-request/{id}/decline" 
 * (route "decline_account_request").
 */
class DeclineAccountRequestType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {

        $builder->add('explanation', TextareaType::class, ['label' => 'Motif du refus', 'mapped' => false]);

    }

    /*
    public function configureOptions(OptionsResolver $resolver) {

        $resolver
            ->setDefaults(['data_class' => AccountRequest::class])
            ->setAllowedTypes('invite', 'bool');

    }
    */

}
