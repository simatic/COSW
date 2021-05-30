<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

/**
 * Modèle de formulaire utilisé pour la connexion au mail zimbra
 * d'organisateurs de soutenances.
 * Ce modèle de formulaire est utilisé à "/connexion" (route "creator").
 */
class EmailConnectionType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {

        $builder
            ->add('email', EmailType::class, ['label' => 'Votre adresse mail'])
            ->add('texte_email_jury', TextareaType::class, ['label' => 'Texte mail jury'])
            ->add('texte_email_etudiant', TextareaType::class, ['label' => 'Texte mail etudiant'])
            ->add('password',PasswordType::class);

    }

    public function configureOptions(OptionsResolver $resolver) {

    }

}