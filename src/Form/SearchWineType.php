<?php

namespace App\Form;

use App\Entity\Area;
use App\Entity\Type;
use App\Entity\Product;
use App\Entity\GrapeVariety;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class SearchWineType extends AbstractType
{
    const PRICE = [1, 5, 10, 20, 30, 50];
    const PRICEMAX = [5, 10, 20, 30, 50, 1000];

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('type', EntityType::class, [
                'class' => Type::class,
                'label' => 'Type'
            ])
            ->add('area', EntityType::class, [
                'class' => Area::class,
                'label' => 'Région'
            ])
            ->add('minimumPrice', ChoiceType::class, [
                'choices' => array_combine(self::PRICE, self::PRICE),
                'label' => 'Prix minimum'
            ])
            ->add('maximumPrice', ChoiceType::class, [
                'choices' => array_combine(self::PRICEMAX, self::PRICEMAX),
                'label' => 'Prix maximum'
            ])
            ->add('submit', SubmitType::class,[
                'label' => 'Envoyer',
                'attr' => array(
                    'class' => 'btn btn-lg btn-danger')
            ])

        ;
    }


}
