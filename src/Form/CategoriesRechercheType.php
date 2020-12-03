<?php

namespace App\Form;

use App\Entity\Categories;
use App\Entity\CategoriesRecherche;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategoriesRechercheType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('categories',EntityType::class,['class' => Categories::class,
        'choice_label' => 'titre' ,
        'label' => 'Catégorie' ]);
        //liste deroulante de catégories
        
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CategoriesRecherche::class,
        ]);
    }
}
