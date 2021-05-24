<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

/**
 * Modèle de formulaire utilisé pour la connexion au mail zimbra
 * d'organisateurs de soutenances.
 * Ce modèle de formulaire est utilisé à "/connexion" (route "creator").
 */
class EmailConnectionType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {

        $builder
            ->add('email', EmailType::class, ['label' => 'Votre adresse mail'])
            ->add('password',PasswordType::class);

    }

    public function configureOptions(OptionsResolver $resolver) {

    }

}