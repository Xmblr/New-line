<?php

namespace Blogger\BlogBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class Builder implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    public function mainMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('Главная', array('route' => 'BloggerBlogBundle_homepage'));

        $menu->addChild('О нас', array('route' => 'BloggerBlogBundle_about'));
        $menu->addChild('Контакты', array('route' => 'BloggerBlogBundle_contact'));
        $menu->addChild('Продвижение сайтов', array('route' => 'BloggerBlogBundle_seo'));
        $menu->addChild('Создание сайтов', array('route' => 'BloggerBlogBundle_create'));
        $menu->addChild('Поддержка сайтов', array('route' => 'BloggerBlogBundle_support'));
        $menu->addChild('Услуги программиста', array('route' => 'BloggerBlogBundle_programmer'));
        $menu->addChild('Наши проекты', array('route' => 'BloggerBlogBundle_projects'));

        // access services from the container!
//        $em = $this->container->get('doctrine')->getManager();
        // findMostRecent and Blog are just imaginary examples
//        $blog = $em->getRepository('BloggerBlogBundle:Blog')->findMostRecent();

//        $menu->addChild('Latest Blog Post', array(
//            'route' => 'blog_show',
//            'routeParameters' => array('id' => $blog->getId())
//        ));

        // create another menu item
//        $menu->addChild('About Me', array('route' => 'BloggerBlogBundle_about'));
//        $menu->addChild('main');
        // you can also add sub level's to your menu's as follows
//        $menu['About Me']->addChild('Edit profile', array('route' => 'edit_profile'));

        // ... add more children

        return $menu;
    }
}