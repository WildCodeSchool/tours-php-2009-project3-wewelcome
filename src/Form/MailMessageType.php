<?php

namespace App\Form;

use App\FormData\MailMessageData;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class MailMessageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('subject', ChoiceType::class, [
                'choices'  => [
                    'Conciergerie' => 'Conciergerie',
                    'Intendance' => 'Intendance',
                ],
                'expanded' => true,
                'multiple' => false,
            ])
            ->add('firstName', TextType::class, ['attr' => ['placeholder' => 'votre prénom']])
            ->add('lastName', TextType::class, ['attr' => ['placeholder' => 'votre nom']])
            ->add('phone', TelType::class, ['attr' => ['placeholder' => 'votre numéro de téléphone']])
            ->add('email', EmailType::class, ['attr' => ['placeholder' => 'votre adresse email']])
            ->add('message', TextareaType::class, ['attr' => ['placeholder' => 'votre message']]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => MailMessageData::class,
        ]);
    }
}
