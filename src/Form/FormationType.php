<?php

namespace App\Form;

use App\Entity\Formation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityRepository; // Import nécessaire pour le query_builder
use App\Entity\User; // Assure-toi que tu importes la classe User correctement

class FormationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('dateDebut', null, [
                'widget' => 'single_text',
                'data' => new \DateTime(),
            ])
            ->add('Duree')
            ->add('description')
            ->add('cout')
            ->add('id_prof', EntityType::class, [
                'label' => 'Professeur',
                'class' => User::class,
                'query_builder' => function (UserRepository $repository) {
                    return $repository->createQueryBuilder('u')
                        ->where('u INSTANCE OF App\Entity\Professeur'); 
                },
                'choice_label' => 'nom',
                'placeholder' => 'Sélectionnez un professeur',
            ]);
            
            

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Formation::class,
        ]);
    }
}
