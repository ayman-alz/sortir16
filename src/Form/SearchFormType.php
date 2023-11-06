<?php

namespace App\Form;

use App\Form\Model\SortieFiltre;
use Doctrine\DBAL\Types\DateType;
use Doctrine\DBAL\Types\IntegerType;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('campus' , EntityType::class)
            ->add('$nom' , TextType::class)
            ->add('$date_heure_debut' , DateType::class)
            ->add('$ata_limite_inscription	', DateType::class , ['widget' => 'single_text'])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SortieFiltre::class
        ]);
    }
}
