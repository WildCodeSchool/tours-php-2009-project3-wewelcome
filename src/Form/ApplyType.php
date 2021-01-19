<?php

namespace App\Form;

use App\FormData\ApplyData;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;

class ApplyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName', TextType::class)
            ->add('lastName', TextType::class)
            ->add('phone', TelType::class)
            ->add('email', EmailType::class)
            ->add('message', TextareaType::class)
            ->add('cvFile', FileType::class, [
                'constraints' => [
                    new File([
                        'maxSize' => '1M',
                        'mimeTypes' => ['application/pdf',],
                        'mimeTypesMessage' => 'Le fichier doit être un pdf !',
                    ])
                ],
            ])
            ->add('coverLetterFile', FileType::class, [
                'constraints' => [
                    new File([
                        'maxSize' => '1M',
                        'mimeTypes' => ['application/pdf',],
                        'mimeTypesMessage' => 'Le fichier doit être un pdf !',
                    ])
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ApplyData::class,
        ]);
    }
}
