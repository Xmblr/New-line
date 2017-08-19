<?php

namespace Blogger\BlogBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;

class CommentAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('blog', 'entity', array(
                'class' => 'Blogger\BlogBundle\Entity\Blog',
                'property' => 'id',
            ))
            ->add('user', 'text')
            ->add('comment', 'textarea')
            ->add('approved', 'choice', array(
                'choices' =>array(
                    "1" => 'yes',
                    "0" => 'no'
                )
            ))
            ->add('created', 'datetime')
            ->add('updated', 'datetime');
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('blog')
            ->add('user')
            ->add('comment')
            ->add('approved')
            ->add('created')
            ->add('updated');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('blog.title')
            ->addIdentifier('user')
            ->addIdentifier('comment')
            ->add('approved')
            ->add('created')
            ->add('updated');
    }
}