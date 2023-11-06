<?php

namespace App\Form;

use App\Entity\Lieu;
use App\Entity\Ville;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class LieuFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class,
                [
                    'label' => 'Nom',
                    'required' => true,
                    'constraints' => [
                        new NotBlank(
                            [
                                'message' => 'Ce chomo ne peut pas être vide'
                            ]
                        ),
                        new Length([
                            'min' => 2,
                            'max' => 255,
                            'minMessage' => 'La rue du lieu doit comporter au moins {{ limit }} caractères.',
                            'maxMessage' => 'La rue du lieu ne peut pas comporter plus de {{ limit }} caractères.',

                        ])
                    ]
                ])
            ->add('rue', TextType::class,
                [
                    'label' => 'Rue',
                    'required' => true,
                    'constraints' => [
                        new NotBlank(
                            [
                                'message' => 'Ce chomo ne peut pas être vide'
                            ]
                        ),
                        new Length([
                            'min' => 2,
                            'max' => 255,
                            'minMessage' => 'La rue du lieu doit comporter au moins {{ limit }} caractères.',
                            'maxMessage' => 'La rue du lieu ne peut pas comporter plus de {{ limit }} caractères.',
                        ])
                    ]
                ])
            ->add('latitude', IntegerType::class,[
                'label' =>'latitude',
                'required' => true,
            ])

            ->add('longitude', IntegerType::class,[
                'label' =>'longitude',
                'required' => true,
            ])

            ->add('ville', EntityType::class, [
                    'class' => Ville::class,
                    'label' => 'Les ville',
                    'label_attr' => [
                        'class' => 'form-label mt-4',
                    ],
                    'choice_label' => 'nom',
                    'multiple' => true,
                    'expanded' => false,
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Lieu::class,
        ]);
    }
}