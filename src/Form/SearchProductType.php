<?php

namespace App\Form;

use App\Classe\Search;
use App\Entity\Brand;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('string', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'placeholder' => 'Votre recherche',
                    'class' => 'form-control-sm'
                ]
            ])
//            ->add('categories', EntityType::class, [
//                'label' => 'Catégories',
//                'required' => false,
//                'class' => Category::class,
//                'multiple' => true,
//                'expanded' => true
//            ])
            ->add('brands', EntityType::class, [
                'label' => 'Marques à découvrir',
                'required' => false,
                'class' => Brand::class,
                'multiple' => true,
                'expanded' => true
            ])

            ->add('submit', SubmitType::class, [
                'label' => "Filtrer",
                'attr' => [
                    'class' => 'btn btn-primary btn-hover-dark rounded-2 w-100 mx-auto'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Search::class,
            'method' => 'GET',
            'crsf_protection' => false,
        ]);
    }
}
