<?php

namespace Blogger\BlogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EnquiryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class)
            ->add('email', EmailType::class)
            ->add('subject', TextType::class)
            ->add('body', TextareaType::class)
            ->add('phone', 'text', array(
                'required'=>false,
                'attr'=>array(
                    'hidden'=>''
                )
            ))
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