<?php

namespace App\Form;

use App\Entity\Client;
use App\Entity\Lien;
use App\Entity\Materiel;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LienType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('quantite')
            ->add('client', EntityType::class, array(
                'class' => Client::class,
                'choice_label' => 'getNomComplet',
                // 'choice_value' => function (?Client $entity) {
                //     return $entity ?$entity->getId() : '';
                // }, 
                
            ))
            ->add('materiel', EntityType::class, array(
                'class' => Materiel::class,
                'choice_label' => 'getSelectLabel',
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Lien::class,
        ]);
    }
}
