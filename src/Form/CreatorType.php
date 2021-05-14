<?php

namespace App\Form;

use App\Entity\Creator;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;

/**
 * Modèle de formulaire utilisé pour la finalisation de la création 
 * de comptes d'organisateurs de soutenances.
 * Ce modèle de formulaire est utilisé à "/register/complete-registration/{id}" (route "complete_registration").
 */
class CreatorType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {

        $builder
            ->add('firstName', TextType::class,  ['label' => 'Votre prénom', 'disabled' => true])
            ->add('lastName', TextType::class,  ['label' => 'Votre nom', 'disabled' => true])
            ->add('email', EmailType::class,  ['label' => 'Votre adresse mail', 'disabled' => true])
            ->add('password', RepeatedType::class, 
            /* Toutes les contraintes sur le choix du mot de passe ci-dessous */
            [
                'type' => PasswordType::class,
                'invalid_message' => 'Les mots de passe ne correspondent pas.',
                'required' => true,
                'first_options'  => ['label' => 'Mot de passe'],
                'second_options' => ['label' => 'Répéter le mot de passe'],
                'help' => 'Définissez un mot de passe pour finaliser la création de votre compte.',
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez définir un mot de passe.',
                    ]),
                    new Length([
                        // à modifier...
                        'min' => 4,
                        'minMessage' => 'Votre mot de passe doit contenir plus de 8 caractères.',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ]);

    }

    public function configureOptions(OptionsResolver $resolver) {

        $resolver->setDefaults(['data_class' => Creator::class]);

    }

}
