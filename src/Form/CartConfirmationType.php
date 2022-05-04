<?php

namespace App\Form;

use App\Entity\Ordering;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class CartConfirmationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add(
            'fullName',
            TextType::class,
            [
                'label' => 'Nom complet',
                'attr' => [
                    
                    'placeholder' => 'Nom & Prénom'
                ],
                'required' => true
            ])
            ->add(
                'adress',
                TextareaType::class,
                [
                    'label' => 'Adresse complete',
                    'attr' => [
                        'placeholder' => 'Adresse complète'
                    ],
                    'required' => true
                ])
            ->add(
                'postalCode',
                TextType::class,
                [
                    'label' => 'Code Postal',
                    'attr' => [
                        'placeholder' => 'Code postal'
                    ],
                    'required' => true
                ])
    
            ->add(
                'city',
                TextType::class,
                [
                    'label' => 'Ville',
                    'attr' => [
                        'placeholder' => 'Ville'
                    ],
                    'required' => true
                ]);
    
}
        
    

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
           'data_class'=> Ordering::class
        ]);
    }
}