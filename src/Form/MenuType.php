<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Menu;
use App\Entity\Order;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MenuType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class,[
                'attr' => ['Placeholder' =>"Entrez le nom du menu"]
            ])
            ->add('price')
            ->add('description', TextareaType::class)
            ->add('category', EntityType::class, [
                'class' => Category::class,
            'choice_label' => 'category_name',

            ])
            ->add('image')

            // ->add('imageFile', FileType::class, [
            //     'label' => 'Image file',
            //     'required' => false,
            // ]);
            // ->add('orders', EntityType::class, [
            //     'class' => Order::class,
            //  'choice_label' => 'id',
            //  'multiple' => true,
            // ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Menu::class,
        ]);
    }



  
}
