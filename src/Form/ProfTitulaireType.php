<?php

namespace App\Form;

use App\Entity\ProfTitulaire;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ProfTitulaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom',
                'attr' => [
                    'placeholder' => 'Nom prof titulaire',
                ],
            ])
            ->add('prenom', TextType::class, [
                'label' => 'Prenom',
                'attr' => [
                    'placeholder' => 'Prenom prof titulaire',
                ],
            ])
            ->add('adresse', TextType::class, [
                'label' => 'Adresse',
                'attr' => [
                    'placeholder' => 'Adresse prof titulaire',
                ],
            ])
            ->add('telephone', TelType::class, [
                'label' => 'Telephone',
                'attr' => [
                    'placeholder' => 'Numero telephone prof titulaire',
                ],
            ])
            ->add('sexe', ChoiceType::class, [
                    'choices' => [
                        'sexe' => [
                            'Homme' => 'homme',
                            'Femme' => 'femme',
                        ]
                    ],
                    'expanded' => true,
                    'multiple' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ProfTitulaire::class,
        ]);
    }
}
