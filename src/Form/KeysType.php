<?php

namespace App\Form;

use App\Entity\KeysVision;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;

class KeysType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, ['required' => true])
            ->add('photo', FileType::class, [
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
            ->add('text1', TextType::class, ['required' => true])
            ->add('text2', TextType::class, ['required' => true])
            ->add('text3', TextType::class, ['required' => true])
            ->add('text4', TextType::class, ['required' => true])
            ->add('text5', TextType::class, ['required' => true])
            ->add('text6', TextType::class, ['required' => true])
            ->add('text7', TextType::class, ['required' => true])
            ->add('text8', TextType::class, ['required' => true])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => KeysVision::class,
        ]);
    }
}
