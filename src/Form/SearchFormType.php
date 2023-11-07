<?php

namespace App\Form;

use App\Entity\Campus;
use App\Entity\Sortie;
use App\Form\Model\SortieFiltre;

use Doctrine\DBAL\Types\IntegerType;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\SubmitButton;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('campus' , EntityType::class, [
                'class' => Campus::class,
                'choice_label' => 'nom'
            ])
            ->add('nom' , TextType::class , [
                'label' => 'nom' ,
                'required' => false
            ])
            ->add('date_heure_debut' , DateType::class , [
               'required' => false ,
                'label' => 'date_heure_debut'
            ])
            ->add('data_limite_inscription', DateType::class , [
                'label' => 'data_limite_inscription' ,
                'required' => false])

            ->add('submit' , SubmitType::class )

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SortieFiltre::class
        ]);
    }
}
