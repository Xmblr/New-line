<?php
// src/Blogger/BlogBundle/Controller/PageController.php

namespace Blogger\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Blogger\BlogBundle\Entity\Enquiry;
use Blogger\BlogBundle\Form\EnquiryType;
use Blogger\BlogBundle\Form\CallType;
use Blogger\BlogBundle\Entity\Call;
use Swift_SmtpTransport;
use Swift_Mailer;
use Swift_Message;


class PageController extends Controller
{
    public function indexAction(Request $request)
    {
        $seoPage = $this->container->get('sonata.seo.page');
        $seoPage
            ->setTitle('Создание и продвижение сайтов в Минске - New-Line studio')
            ->addMeta('name', 'description', 'New-line студия - это создание и продвижение сайтов в Минске. Мы работаем с лучшими. Отличные цены ✔ гарантия качества!')
            ->addMeta('property', 'og:title', 'Создание и продвижение сайтов в Минске - New-Line studio')
            ->addMeta('property', 'og:description', 'New-line студия - это создание и продвижение сайтов в Минске. Мы работаем с лучшими. Отличные цены ✔ гарантия качества!')
            ->addMeta('property', 'og:url', 'http://new-line.by')
            ->addMeta('property', 'og:locale', 'ru_RU')
            ->addMeta('property', 'og:type', 'website')
//          ->addMeta('property', 'og:image', '{{ path(\'BloggerBlogBundle_homepage\') }}')
            ->addMeta('property', 'twitter:card', 'summary')
            ->addMeta('property', 'twitter:description', 'New-line студия - это создание и продвижение сайтов в Минске. Мы работаем с лучшими. Отличные цены ✔ гарантия качества!')
            ->addMeta('property', 'twitter:title', 'Создание и продвижение сайтов в Минске - New-Line studio')
//            ->addMeta('property', 'twitter:image', '{{ path(\'BloggerBlogBundle_homepage\') }}')

        ;


        $callform = $this->Call($request);

        return $this->render('BloggerBlogBundle:Page:index.html.twig', array(
            'callform' =>$callform->createView()
        ));

    }

    public function aboutAction(Request $request)
    {
        $seoPage = $this->container->get('sonata.seo.page');
        $seoPage
            ->setTitle('О компании - Студия создания и продвижения сайтов в Беларуси | New-line')
            ->addMeta('name', 'description', 'Студия New-line - создание и продвижение сайтов в Беларуси. Отличные цены ✔ гарантия качества! Немного полезной информации о компании')
            ->addMeta('property', 'og:title', 'О компании - Студия создания и продвижения сайтов в Беларуси | New-line')
            ->addMeta('property', 'og:description', 'Студия New-line - создание и продвижение сайтов в Беларуси. Отличные цены ✔ гарантия качества! Немного полезной информации о компании')
            ->addMeta('property', 'og:url', 'http://new-line.by/about')
            ->addMeta('property', 'og:locale', 'ru_RU')
            ->addMeta('property', 'og:type', 'website')
//          ->addMeta('property', 'og:image', '{{ path(\'BloggerBlogBundle_homepage\') }}')
            ->addMeta('property', 'twitter:card', 'summary')
            ->addMeta('property', 'twitter:description', 'Студия New-line - создание и продвижение сайтов в Беларуси. Отличные цены ✔ гарантия качества! Немного полезной информации о компании')
            ->addMeta('property', 'twitter:title', 'О компании - Студия создания и продвижения сайтов в Беларуси | New-line')
//            ->addMeta('property', 'twitter:image', '{{ path(\'BloggerBlogBundle_homepage\') }}')
        ;

        $callform = $this->Call($request);

        return $this->render('BloggerBlogBundle:Page:about.html.twig', array(
            'callform' =>$callform->createView()
        ));
    }

    public function contactAction(Request $request)
    {
        $seoPage = $this->container->get('sonata.seo.page');
        $seoPage
            ->setTitle('Контакты студии создания и продвижения сайтов - New-line')
            ->addMeta('name', 'description', 'Контактные данные студии создания и продвижения сайтов в Минске, а также по Беларуси. Свяжитесь с нами и мы выполним проект любой сложности, за максимально короткие сроки.')
            ->addMeta('property', 'og:title', 'Контакты студии создания и продвижения сайтов - New-line')
            ->addMeta('property', 'og:description', 'Контактные данные студии создания и продвижения сайтов в Минске, а также по Беларуси. Свяжитесь с нами и мы выполним проект любой сложности, за максимально короткие сроки.')
            ->addMeta('property', 'og:url', 'http://new-line.by/contact')
            ->addMeta('property', 'og:locale', 'ru_RU')
            ->addMeta('property', 'og:type', 'website')
//          ->addMeta('property', 'og:image', '{{ path(\'BloggerBlogBundle_homepage\') }}')
            ->addMeta('property', 'twitter:card', 'summary')
            ->addMeta('property', 'twitter:description', 'Контактные данные студии создания и продвижения сайтов в Минске, а также по Беларуси. Свяжитесь с нами и мы выполним проект любой сложности, за максимально короткие сроки.')
            ->addMeta('property', 'twitter:title', 'Контакты студии создания и продвижения сайтов - New-line')
//          ->addMeta('property', 'twitter:image', '{{ path(\'BloggerBlogBundle_homepage\') }}')

        ;

        $callform = $this->Call($request);

        $enquiry = new Enquiry();

        $form = $this->createForm(EnquiryType::class, $enquiry);

        if ($request->isMethod($request::METHOD_POST)) {

            $form->handleRequest($request);
            if ($form->isValid()) {

                $this->Mailer($enquiry);

                $request->getSession()
                    ->getFlashBag()
                    ->add('success', 'Ваше сообщение успешно отправлено.')
                ;
                // Redirect - This is important to prevent users re-posting
                // the form if they refresh the page
                return $this->redirect($this->generateUrl('BloggerBlogBundle_contact'));

            }

        }

        return $this->render('BloggerBlogBundle:Page:contact.html.twig', array(
            'form' => $form->createView(),
            'callform' =>$callform->createView()
        ));
    }



    public function seoAction(Request $request)
    {
        $seoPage = $this->container->get('sonata.seo.page');
        $seoPage
            ->setTitle('Seo продвижение сайта в топ - Эффективная раскрутка сайта в поисковых системах')
            ->addMeta('name', 'description', 'Seo продвижение сайта в топ поисковых систем - Google и Yandex. Только белые методы СЕО. Работаем по Беларуси, а также по России. Компадна опытных специалистов обеспечит эффективную расскрутку вашего сайта в поисковых системах за оптимальную цену.')
            ->addMeta('property', 'og:title', 'Seo продвижение сайта в топ - Эффективная раскрутка сайта в поисковых системах')
            ->addMeta('property', 'og:description', 'Seo продвижение сайта в топ поисковых систем - Google и Yandex. Только белые методы СЕО. Работаем по Беларуси, а также по России. Компадна опытных специалистов обеспечит эффективную расскрутку вашего сайта в поисковых системах за оптимальную цену.')
            ->addMeta('property', 'og:url', 'http://new-line.by/seo-prodvizhenie-sajta')
            ->addMeta('property', 'og:locale', 'ru_RU')
            ->addMeta('property', 'og:type', 'website')
//          ->addMeta('property', 'og:image', '{{ path(\'BloggerBlogBundle_homepage\') }}')
            ->addMeta('property', 'twitter:card', 'summary')
            ->addMeta('property', 'twitter:description', 'Seo продвижение сайта в топ поисковых систем - Google и Yandex. Только белые методы СЕО. Работаем по Беларуси, а также по России. Компадна опытных специалистов обеспечит эффективную расскрутку вашего сайта в поисковых системах за оптимальную цену.')
            ->addMeta('property', 'twitter:title', 'Seo продвижение сайта в топ - Эффективная раскрутка сайта в поисковых системах')
//          ->addMeta('property', 'twitter:image', '{{ path(\'BloggerBlogBundle_homepage\') }}')

        ;
        $callform = $this->Call($request);

        $enquiry = new Enquiry();

        $form = $this->createForm(EnquiryType::class, $enquiry);

        if ($request->isMethod($request::METHOD_POST)) {

            $form->handleRequest($request);
            if ($form->isValid()) {

                $this->Mailer($enquiry);

                $request->getSession()
                    ->getFlashBag()
                    ->add('success', 'Ваше сообщение успешно отправлено.')
                ;
                // Redirect - This is important to prevent users re-posting
                // the form if they refresh the page
                return $this->redirect($this->generateUrl('BloggerBlogBundle_seo'));

            }

        }

        return $this->render('BloggerBlogBundle:Page:seo.html.twig', array(
            'callform' =>$callform->createView(),
            'form' => $form->createView()
        ));
    }

    public function createAction(Request $request)
    {
        $seoPage = $this->container->get('sonata.seo.page');
        $seoPage
            ->setTitle('Создание сайтов в Минске, отличные цены - Разработка сайтов в Минске')
            ->addMeta('name', 'description', 'Создание сайтов в Минске, а также по РБ ✔ любой сложности. Наши специалисты выполнят любой проект за максимально короткие сроки. Гарантия качества! Разработка сайтов в Минске - New-line studio.')
            ->addMeta('property', 'og:title', 'Создание сайтов в Минске, отличные цены - Разработка сайтов в Минске')
            ->addMeta('property', 'og:description', 'Создание сайтов в Минске, а также по РБ ✔ любой сложности. Наши специалисты выполнят любой проект за максимально короткие сроки. Гарантия качества! Разработка сайтов в Минске - New-line studio.')
            ->addMeta('property', 'og:url', 'http://new-line.by/create-new-site')
            ->addMeta('property', 'og:locale', 'ru_RU')
            ->addMeta('property', 'og:type', 'website')
//          ->addMeta('property', 'og:image', '{{ path(\'BloggerBlogBundle_homepage\') }}')
            ->addMeta('property', 'twitter:card', 'summary')
            ->addMeta('property', 'twitter:description', 'Создание сайтов в Минске, а также по РБ ✔ любой сложности. Наши специалисты выполнят любой проект за максимально короткие сроки. Гарантия качества! Разработка сайтов в Минске - New-line studio.')
            ->addMeta('property', 'twitter:title', 'Создание сайтов в Минске, отличные цены - Разработка сайтов в Минске')
//          ->addMeta('property', 'twitter:image', '{{ path(\'BloggerBlogBundle_homepage\') }}')

        ;
        $callform = $this->Call($request);

        return $this->render('BloggerBlogBundle:Page:create.html.twig', array(
            'callform' =>$callform->createView()
        ));
    }

    public function supportAction(Request $request)
    {
        $seoPage = $this->container->get('sonata.seo.page');
        $seoPage
            ->setTitle('Создание сайтов в Минске, отличные цены - Разработка сайтов в Минске')
            ->addMeta('name', 'description', 'Поддержка сайтов в Минске, а также по РБ ✔ гарантия качества! Наша команда специалистов выполнит поддержку сайтов по оптимальной для вас цене - New-line studio')
            ->addMeta('property', 'og:title', 'Создание сайтов в Минске, отличные цены - Разработка сайтов в Минске')
            ->addMeta('property', 'og:description', 'Поддержка сайтов в Минске, а также по РБ ✔ гарантия качества! Наша команда специалистов выполнит поддержку сайтов по оптимальной для вас цене - New-line studio')
            ->addMeta('property', 'og:url', 'http://new-line.by/support-site')
            ->addMeta('property', 'og:locale', 'ru_RU')
            ->addMeta('property', 'og:type', 'website')
//          ->addMeta('property', 'og:image', '{{ path(\'BloggerBlogBundle_homepage\') }}')
            ->addMeta('property', 'twitter:card', 'summary')
            ->addMeta('property', 'twitter:description', 'Поддержка сайтов в Минске, а также по РБ ✔ гарантия качества! Наша команда специалистов выполнит поддержку сайтов по оптимальной для вас цене - New-line studio')
            ->addMeta('property', 'twitter:title', 'Создание сайтов в Минске, отличные цены - Разработка сайтов в Минске')
//          ->addMeta('property', 'twitter:image', '{{ path(\'BloggerBlogBundle_homepage\') }}')

        ;
        $callform = $this->Call($request);

        return $this->render('BloggerBlogBundle:Page:support.html.twig', array(
            'callform' =>$callform->createView()
        ));
    }

    public function programmerAction(Request $request)
    {
        $seoPage = $this->container->get('sonata.seo.page');
        $seoPage
            ->setTitle('programmer')
            ->addMeta('name', 'description', 'programmer page')
            ->addMeta('property', 'og:description', 'programmer page')

        ;
        $callform = $this->Call($request);

        return $this->render('BloggerBlogBundle:Page:programmer.html.twig', array(
            'callform' =>$callform->createView()
        ));
    }

    public function projectsAction(Request $request)
    {
        $seoPage = $this->container->get('sonata.seo.page');
        $seoPage
            ->setTitle('Наши выполненные проекты по созданию и продвижению сайтов | New-line studio')
            ->addMeta('name', 'description', 'В данном разделе Вы найдете наши выполненные работы. Хотите себе сайт? Хотите быть в Топах поисковых систем? Вы попали по адресу - гарантия качества!')
            ->addMeta('property', 'og:title', 'Наши выполненные проекты по созданию и продвижению сайтов | New-line studio')
            ->addMeta('property', 'og:description', 'В данном разделе Вы найдете наши выполненные работы. Хотите себе сайт? Хотите быть в Топах поисковых систем? Вы попали по адресу - гарантия качества!')
            ->addMeta('property', 'og:url', 'http://new-line.by/projects')
            ->addMeta('property', 'og:locale', 'ru_RU')
            ->addMeta('property', 'og:type', 'website')
//          ->addMeta('property', 'og:image', '{{ path(\'BloggerBlogBundle_homepage\') }}')
            ->addMeta('property', 'twitter:card', 'summary')
            ->addMeta('property', 'twitter:description', 'В данном разделе Вы найдете наши выполненные работы. Хотите себе сайт? Хотите быть в Топах поисковых систем? Вы попали по адресу - гарантия качества!')
            ->addMeta('property', 'twitter:title', 'Наши выполненные проекты по созданию и продвижению сайтов | New-line studio')
//          ->addMeta('property', 'twitter:image', '{{ path(\'BloggerBlogBundle_homepage\') }}')

        ;
        $callform = $this->Call($request);

        return $this->render('BloggerBlogBundle:Page:projects.html.twig', array(
            'callform' =>$callform->createView()
        ));
    }

    public function confirmAction(Request $request)
    {
        $seoPage = $this->container->get('sonata.seo.page');
        $seoPage
            ->setTitle('confirm')
            ->addMeta('name', 'description', 'confirm page')
            ->addMeta('property', 'og:description', 'confirm page')

        ;
        $callform = $this->Call($request);

        return $this->render('BloggerBlogBundle:Page:confirm.html.twig', array(
            'callform' =>$callform->createView()
        ));
    }

    public function Call($request)
    {
        $call = new Call();

        $callform = $this->createForm(CallType::class, $call);

        if ($request->isMethod($request::METHOD_POST)) {

            $callform->handleRequest($request);
            if ($callform->isValid()) {

                $this->Caller($call);

                $request->getSession()
                    ->getFlashBag()
                    ->add('success', 'Ваше сообщение успешно отправлено.');
            }
        }

        return $callform;

    }

    public function Mailer($enquiry)
    {
        $mailer = $this->Transport();

        // Create a message
        $message = Swift_Message::newInstance('Форма обратной связи')
            ->setFrom(array('seo-newline@mail.ru' => 'Обратный звонок'))
            ->setTo($this->container->getParameter('blogger_blog.emails.contact_email'))
            ->setBody($this->renderView('BloggerBlogBundle:Page:contactEmail.txt.twig', array('enquiry' => $enquiry)));
        ;

        // Send the message
        $mailer->send($message);
    }

    public function Caller($call)
    {
        $mailer = $this->Transport();

        // Create a message
        $message = Swift_Message::newInstance('Форма обратного звонка')
            ->setFrom(array('seo-newline@mail.ru' => 'Обратный звонок'))
            ->setTo($this->container->getParameter('blogger_blog.emails.contact_email'))
            ->setBody($this->renderView('BloggerBlogBundle:Page:callEmail.txt.twig', array('call' => $call)));
        ;

        // Send the message
        $mailer->send($message);
    }

    public function Transport()
    {
        // Create the Transport
        $transport = Swift_SmtpTransport::newInstance('smtp.mail.ru', 465, 'ssl')
            ->setUsername('seo-newline@mail.ru')
            ->setPassword('19086837dima')
        ;

        // Create the Mailer using your created Transport
        return $mailer = Swift_Mailer::newInstance($transport);

    }

}