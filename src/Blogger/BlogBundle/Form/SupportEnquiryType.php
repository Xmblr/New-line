<?php

namespace Blogger\BlogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SupportEnquiryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('package', 'choice', array(
                'choices'  => array(
                    'Мини (2 часа)' => 'Мини (2 часа)',
                    'Стандарт (8 часов)' => 'Стандарт (8 часов)',
                    'Оптимальный (24 часа)' => 'Оптимальный (24 часа)',
                    'Максимум (40 часов)' => 'Максимум (40 часов)',
                    'Дополнительный пакет (30 минут)' => 'Дополнительный пакет (30 минут)'
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