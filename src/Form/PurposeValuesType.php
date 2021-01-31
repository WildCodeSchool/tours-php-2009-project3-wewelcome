<?php

namespace App\Form;

use App\Entity\Home;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class PurposeValuesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('text', TextareaType::class, ['required' => true])
            ->add('pictureOne', FileType::class, [
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '150k',
                        'maxSizeMessage' => 'La photo dépasse la limite de 150k !',
                        'mimeTypes' => [
                            'image/png',
                            'image/jpeg',
                        ],
                        'mimeTypesMessage' => 'Le format choisi est invalide ! => png ou jpeg uniquement',
                    ])
                ],
            ])
            ->add('legendPictureOne', TextType::class, ['required' => false])
            ->add('type', HiddenType::class)
            ->add('title', HiddenType::class)
            ->add('pictureTwo', HiddenType::class)
            ->add('pictureThree', HiddenType::class)
            ->add('legendPictureTwo', HiddenType::class)
            ->add('legendPictureThree', HiddenType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Home::class,
        ]);
    }
}
