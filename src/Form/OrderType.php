<?php

namespace App\Form;

use App\Entity\DeliveryMethod;
use App\Entity\Menu;
use App\Entity\Order;
use App\Entity\Status;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('order_num')
            ->add('created_at')
            ->add('menu', EntityType::class, [
                'class' => Menu::class,
'choice_label' => 'id',
'multiple' => true,
            ])
            ->add('status', EntityType::class, [
                'class' => Status::class,
'choice_label' => 'id',
            ])
            ->add('deliveryMethod', EntityType::class, [
                'class' => DeliveryMethod::class,
'choice_label' => 'id',
            ])
            ->add('user', EntityType::class, [
                'class' => User::class,
'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Order::class,
        ]);
    }
}
