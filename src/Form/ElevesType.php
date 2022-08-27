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
                'label' => 'Matricule *',
                'attr' => [
                    'placeholder' => 'Matricule d\'eleve'
                ],
                // 'help' => '*'
            ])
            ->add('nom', TextType::class, [
                'label' => 'Nom *',
                'attr' => [
                    'placeholder' => 'Nom d\'eleve'
                ] 
            ])
            ->add('prenom', TextType::class, [
                'label' => 'Prenom *',
                'attr' => [
                    'placeholder' => 'Prenom d\'eleve'
                ]
            ])
            ->add('dateNaissance', BirthdayType::class, [
                'label' => 'Date de niassance *',
                'format' => 'dMMyyyy',
            ])
            ->add('adresse', TextType::class, [
                'label' => 'Adresse *',
                'attr' => [
                    'placeholder' => 'Adresse exacte d\'eleve'
                ]
            ])
            ->add('telephone', TelType::class, [
                'label' => 'Telephone *',
                'attr' => [
                    'placeholder' => 'Numero telephone d\'eleve'
                ]
            ])
            ->add('mere', TextType::class, [
                'label' => 'Mere *',
                'attr' => [
                    'placeholder' => 'Mere d\'eleve'
                ]
            ])
            ->add('pere', TextType::class, [
                'label' => 'Pere *',
                'attr' => [
                    'placeholder' => 'Pere d\'eleve'
                ]
            ])
            ->add('tuteur', TextType::class, [
                'label' => 'Tuteur *',
                'attr' => [
                    'placeholder' => 'Tuteur d\'eleve'
                ],
                'required' => false,
            ])
            ->add('sexe', ChoiceType::class, [
                'label' => 'Sexe *',
                'choices' => [
                    'Homme' => 'Homme',
                    'Femme' => 'Femme',
                ],
                'expanded' => true,
                'multiple' => false,
            ])
            ->add('religion', ChoiceType::class, [
                'label' => 'Religion *',
                'choices' => [
                    'Fiangonan\'i Jesosy Kristy eto Madagasikara' => 'FJKM',
                    'Fiangonana Loterana Malagasy' => 'FLM',
                    'Eglize KAtolika Romanina' => 'EKAR',
                ],
                'expanded' => false,
                'multiple' => false,
            ])
            ->add('classe', EntityType::class, [
                'label' => 'Classe *',
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
