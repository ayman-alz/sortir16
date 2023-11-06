<?php

namespace App\Form;

use App\Entity\Etat;
use App\Entity\Lieu;
use App\Entity\Sortie;
use App\Entity\Ville;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Campus;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;


class SortieFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('dateHeureDebut', DateType::class,
                [
                    'input' => 'datetime_immutable'
                ])
            ->add('duree')
            ->add('dateLimiteInscription', DateType::class,
                [
                    'input' => 'datetime_immutable'
                ]
            )
            ->add('nbInsciptionMax')
            ->add('infosSortie')
            ->add('campus', EntityType::class, [
                'label' => 'Campus',
                'class' => Campus::class,
                'required' => false,
                'choice_label' => 'nom',
                'placeholder' => '--Choisir une campus--'
            ]);


    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Sortie::class]);
    }
}
