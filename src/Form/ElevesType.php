<?php

namespace App\Form;

use App\Entity\Eleves;
use App\Entity\Classe;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class ElevesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('matricule', NumberType::class, [
                'attr' => [
                    'placeholder' => 'Matricule d\'eleve'
                ]
            ])
            ->add('nom', TextType::class, [
                'attr' => [
                    'placeholder' => 'Nom d\'eleve'
                ] 
            ])
            ->add('prenom', TextType::class, [
                'attr' => [
                    'placeholder' => 'Prenom d\'eleve'
                ]
            ])
            ->add('dateNaissance', BirthdayType::class)
            ->add('adresse', TextType::class, [
                'attr' => [
                    'placeholder' => 'Adresse exacte d\'eleve'
                ]
            ])
            ->add('telephone', TelType::class, [
                'attr' => [
                    'placeholder' => 'Numero telephone d\'eleve'
                ]
            ])
            ->add('mere', TextType::class, [
                'attr' => [
                    'placeholder' => 'Mere d\'eleve'
                ]
            ])
            ->add('pere', TextType::class, [
                'attr' => [
                    'placeholder' => 'Pere d\'eleve'
                ]
            ])
            ->add('tuteur', TextType::class, [
                'attr' => [
                    'placeholder' => 'Tuteur d\'eleve'
                ]
            ])
            ->add('sexe', ChoiceType::class, [
                'choices' => [
                    'Homme' => 'Homme',
                    'Femme' => 'Femme',
                ],
                'expanded' => true,
                'multiple' => false,
            ])
            ->add('religion', ChoiceType::class, [
                'choices' => [
                    'Fiangonan\'i Jesosy Kristy eto Madagasikara' => 'FJKM',
                    'Fiangonana Loterana Malagasy' => 'FLM',
                    'Eglize KAtolika Romanina' => 'EKAR',
                ],
                'expanded' => false,
                'multiple' => false,
            ])
            ->add('classe', EntityType::class, [
                'class' => Classe::class,
                'choice_label' => 'nomClasse',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Eleves::class,
        ]);
    }
}
