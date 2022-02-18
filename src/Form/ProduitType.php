<?php

namespace App\Form;

use App\Entity\Produit;
use App\Entity\ContenuPanier;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;


class ProduitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, ['label' => "Nom du produit(s)"])
            ->add('description', TextareaType::class, ['label' => "Description du produit(s)"])
            ->add('prix', NumberType::class, ['label' => "Prix du produit(s)"])
            ->add('stock', NumberType::class, ['label' => "Produit(s) en stock"])
            ->add('photo', FileType::class, ['label' => "Image(JPEG, PNG)"]) 
            ->add('submit', SubmitType::class, ['label' => "Ajouter le(s) produit(s)"])
        ;
            //->add('contenuPaniers', EntityType::class,['class' => ContenuPanier::class])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Produit::class,
        ]);
    }
}
