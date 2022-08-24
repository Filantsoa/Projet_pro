<?php

namespace App\Form;

use App\Entity\Classe;
use App\Entity\ProfTitulaire;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Reposotory\ProfTitulaireRepository;
use Doctrine\ORM\EntityRepository;

class ClasseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomClasse', TextType::class, [
                'label' => 'Classe',
                'attr' => [
                    'placeholder' => 'Classe',
                ]

            ])
            ->add('profTitulaire', EntityType::class, [
                'label' => 'Prof Titulaire',
                'class' => ProfTitulaire::class,
                'query_builder' => function (EntityRepository $titulaire)
                {
                    return $titulaire->createQueryBuilder('u')
                        ->orderBy('u.prenom', 'DESC');
                },
                'choice_label' => ucwords('prenom'),
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Classe::class,
        ]);
    }
}
