<?php

namespace App\Form;

use App\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', null, array('label' => 'Nom du produit'))
            ->add('stock', null, array('label' => 'Produit en stock'))
            ->add('price', null, array('label' => 'Prix'))
            ->add('note', null, array('label' => 'Note'))
            ->add('picture', null, array('label' => "Chemin de l'image"))
            ->add('description', null, array('label' => 'Description'))
            ->add('year', DateType::class, [
                "label" => "Millésime",
                'widget' => 'choice',
                'years' => range(date('Y'), date('Y')-50),
            ])
            ->add('area', null, array('label' => 'Région'))
            ->add('domain', null, array('label' => 'Cave'))
            ->add('type', null, array('label' => 'Type de vin'))
            ->add('grapeVariety', null, array('label' => 'Cépage'))
            ->add('submit', SubmitType::class,[
                'label' => 'Envoyer',
                'attr' => array(
                    'class' => 'btn btn-lg btn-danger')
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
