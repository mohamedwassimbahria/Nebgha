<?php

namespace App\Form;

use App\Entity\Evenement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class EvenementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre')
            ->add('description', TextareaType::class, [
                'required' => false,
            ])
            ->add('type', ChoiceType::class, [
                'choices' => [
                    'Séminaire' => 'Séminaire',
                    'Webinaire' => 'Webinaire',
                    'Atelier' => 'Atelier',
                    'Conférence' => 'Conférence',
                    'Sportif'=> 'Sportif',
                    ' culterelle'=>'Sportif' ,
                    'Associative'=> 'Sportif',
                ],
                'placeholder' => 'Choisissez un type',
            ])
            ->add('dateDebut', null, [
                'widget' => 'single_text',
            ])
            ->add('dateFin', null, [
                'widget' => 'single_text',
            ])
            ->add('lieu')
            ->add('latitude', NumberType::class, [
                'required' => false,
                'label' => 'Latitude',
                'attr' => ['placeholder' => 'Entrez la latitude'],
            ])
            ->add('longitude', NumberType::class, [
                'required' => false,
                'label' => 'Longitude',
                'attr' => ['placeholder' => 'Entrez la longitude'],
            ])
            ->add('capacite')
            ->add('nombreParticipants', NumberType::class, [
                'required' => false,
                'attr' => ['min' => 0, 'placeholder' => 'Nombre de participants'],
            ])
            ->add('fraisParticipation')
            ->add('tags', TextareaType::class, [
                'required' => false, // Rendre le champ non obligatoire
                'label' => 'Tags (séparés par des virgules)',
                'attr' => [
                    'placeholder' => 'Entrez des tags séparés par des virgules'
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Evenement::class,
        ]);
    }
}
