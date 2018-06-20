<?php

namespace Blogger\BlogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CreateEnquiryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type', 'choice', array(
                'choices'  => array(
                    'Landing-page' => 'Landing-page',
                    'Сайт-визитка' => 'Сайт-визитка',
                    'Корпоративный сайт' => 'Корпоративный сайт',
                    'Интернет-магазин' => 'Интернет-магазин'
                ),
                'choices_as_values' => true
            ))
            ->add('name', TextType::class)
            ->add('email', EmailType::class)
            ->add('phone', TextareaType::class)
        ;
    }

//    public function configureOptions(OptionsResolver $resolver)
//    {
//
//    }
//
//    public function getBlockPrefix()
//    {
//        return 'contact';
//    }
}