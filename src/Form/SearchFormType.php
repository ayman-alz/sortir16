<?php

namespace App\Form;

use App\Entity\Campus;
use App\Form\Model\SortieFilter;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('campus', EntityType::class, [
                'class' => Campus::class,
                'required' => false,
                'choice_label' => 'nom',
                'placeholder' => '--Choisir une campus--',
            ])
            ->add('nom', TextType::class, [
                'label' => '',
                'required' => false,


            ])
            ->add('date_heure_debut', DateType::class, [
                'label' => '',
                'required' => false,

            ])
            ->add('data_limite_inscription', DateType::class,
                [
                    'label' => '',
                    'required' => false,

                ])
            ->add('organisateur', CheckboxType::class, [
                'label' => "Sorties dont je suis l'organisateur/trice",
                'attr' => array(
                    'class'=> 'form-check-input me-1',
                    'type'=> 'checkbox'
                ),
                'required' => false,

            ])
            ->add('inscrit', CheckboxType::class, [
                'label' => 'Sorties auxquelles je suis inscrit',
                'attr' => array(
                    'class'=> 'form-check-input me-1',
                    'type'=> 'checkbox'
                ),
                'required' => false,

            ])
            ->add('noninscrit', CheckboxType::class, [
                'label' => "Sorties auxquelles je ne suis pas inscrit/e"
                , 'attr' => array(
                    'class'=> 'form-check-input me-1',
                    'type'=> 'checkbox'
                ),
                'required' => false,

            ])
            ->add('soireepasse', CheckboxType::class, [
                'label' => "Sortie Passes"
                , 'attr' => array(
                    'class'=> 'form-check-input me-1',
                    'type'=> 'checkbox'
                ),
                'required' => false,

            ])
            ->add('submit' , SubmitType::class,
                [
                    'attr'=> array(
                        'class'=>"btn btn-success" ,
                    'style'=>"width: 100% ;height: 100px"
                    )
                ]);

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SortieFilter::class
        ]);
    }
}