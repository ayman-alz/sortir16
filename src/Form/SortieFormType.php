<?php

namespace App\Form;

use App\Entity\Sortie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Campus;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


class SortieFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('dateHeureDebut', DateType::class,
                [
                    'widget' => 'single_text',
                    'html5' => true,
                ])
            ->add('duree')
            ->add('dateLimiteInscription', DateType::class,
                [
                    'widget' => 'single_text',
                    'html5' => true,
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
