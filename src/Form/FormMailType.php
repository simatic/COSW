<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

/**
 * Modèle de formulaire utilisé pour la connexion au mail zimbra
 * d'organisateurs de soutenances.
 */
class FormMailType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {

        $builder
            ->add('email',EmailType::class)
            ->add('password',PasswordType::class);

    }

    public function configureOptions(OptionsResolver $resolver) {

    }

}