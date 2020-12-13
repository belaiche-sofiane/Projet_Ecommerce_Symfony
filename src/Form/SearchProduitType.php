<?php

namespace App\Form;

use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class SearchProduitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('mots',SearchType::class,[
                'label' => 'Chercher par mot clé',
                'attr'=>[
                    'class' => 'form-control mr-sm-2',
                    'placeholder'=>'Entrez vos mots-clés',
                    
                ],
                'required'=>false
            ])
            ->add('categorie',EntityType::class,[
                'class' => Category::class,
                'label' => 'Choisir la catégorie',
                'attr'=>[
                    'class' => 'form-control mr-sm-2',                    
                ],
                'required'=>false
            ])
            ->add('Rechercher',SubmitType::class,[
                'attr'=>[
                    'class' => 'btn btn-primary my-2 my-sm-0'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
