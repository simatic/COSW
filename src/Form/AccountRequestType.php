<?php

namespace App\Form;

use App\Entity\AccountRequest;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use App\Security\Status;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class AccountRequestType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        if($options['invite']) {

            $builder
            ->add('email', EmailType::class, ['label' => 'Adresse mail'])
            ->add('status', HiddenType::class, ['empty_data' => Status::PENDING]);

        } else {

            $builder
            ->add('firstName', TextType::class, ['label' => 'Votre prénom'])
            ->add('lastName', TextType::class, ['label' => 'Votre nom'])
            ->add('email', EmailType::class, ['label' => 'Votre adresse mail'])
            ->add('status', HiddenType::class, ['empty_data' => Status::PENDING]);

        }

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
        ->setDefaults([
            'data_class' => AccountRequest::class,
            'invite' => false
        ])
        ->setAllowedTypes('invite', 'bool');
    }
}
