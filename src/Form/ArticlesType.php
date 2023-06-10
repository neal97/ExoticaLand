<?php

namespace App\Form;

use App\Entity\Articles;
use App\Entity\Categorie;
use Doctrine\DBAL\Types\FloatType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class ArticlesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', TextType::class, [
                "label" => "titre",
                "required" => false,
                "attr" => [
                    "class" => "",
                    "placeholder" => "Nom du produit"
                ]
            ])
            ->add('description', TextType::class, [
                "label" => "description",
                "required" => false,
                "attr" => [
                    "class" => "",
                    "placeholder" => "Description du produit"
                ]
            ])
            ->add('prix', NumberType::class, [
                "label" => "Prix",
                "required" => false,
                "attr" => [
                    "class" => "",
                    "placeholder" => "Prix du produit"
                ]
            ])
            ->add('stock', NumberType::class, [
                "label" => "Stock",
                "required" => false,
                "attr" => [
                    "class" => "",
                    "placeholder" => "Nombre en stock"
                ]
            ])
            ->add('categorie', EntityType::class, [
                "class" => Categorie::class,
                "placeholder" => "Selectionner une catégorie",
                'choice_label'=>'nom',
                'required'=>false   
                
            ])
           
            ->add('photo', TextType::class, [
                "label" => "photo",
                "required" => false,
                "attr" => [
                    "class" => "",
                    "placeholder" => "photo du produit"
                ]
            ])
            ->add('Enregistrer', SubmitType::class)
        ;
    }
  
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Articles::class,
        ]);
    }
}
