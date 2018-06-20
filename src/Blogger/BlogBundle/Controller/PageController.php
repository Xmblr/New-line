<?php
// src/Blogger/BlogBundle/Controller/PageController.php

namespace Blogger\BlogBundle\Controller;

use Blogger\BlogBundle\Entity\CreateEnquiry;
use Blogger\BlogBundle\Entity\SeoEnquiry;
use Blogger\BlogBundle\Entity\SupportEnquiry;
use Blogger\BlogBundle\Form\CreateEnquiryType;
use Blogger\BlogBundle\Form\SeoEnquiryType;
use Blogger\BlogBundle\Form\SupportEnquiryType;
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
        $description = 'New-line студия - это создание и продвижение сайтов в Минске. Мы работаем с лучшими. Отличные цены ✔ гарантия качества!';
        $title = 'Создание и продвижение сайтов в Минске - New-Line studio';
        $url = 'http://new-line.by';

        $seoPage = $this->container->get('sonata.seo.page');
        $seoPage
            ->setTitle($title)
            ->addMeta('name', 'description', $description)
            ->addMeta('property', 'og:title', $title)
            ->addMeta('property', 'og:description', $description)
            ->addMeta('property', 'og:url', $url)
            ->addMeta('property', 'twitter:title', $title)
            ->addMeta('property', 'twitter:description', $description);


        $callform = $this->Call($request);

        return $this->render('BloggerBlogBundle:Page:index.html.twig', array(
            'callform' => $callform->createView()
        ));

    }

    public function aboutAction(Request $request)
    {
        $title = 'О компании - Студия создания и продвижения сайтов в Беларуси | New-line';
        $description = 'Студия New-line - создание и продвижение сайтов в Беларуси. Отличные цены ✔ гарантия качества! Немного полезной информации о компании';
        $url = 'http://new-line.by/about';

        $seoPage = $this->container->get('sonata.seo.page');
        $seoPage
            ->setTitle($title)
            ->addMeta('name', 'description', $description)
            ->addMeta('property', 'og:title', $title)
            ->addMeta('property', 'og:description', $description)
            ->addMeta('property', 'og:url', $url)
            ->addMeta('property', 'twitter:title', $title)
            ->addMeta('property', 'twitter:description', $description);

        $callform = $this->Call($request);

        return $this->render('BloggerBlogBundle:Page:about.html.twig', array(
            'callform' => $callform->createView()
        ));
    }

    public function contactAction(Request $request)
    {

        $title = 'Контакты студии создания и продвижения сайтов - New-line';
        $description = 'Контактные данные студии создания и продвижения сайтов в Минске, а также по Беларуси. Свяжитесь с нами и мы выполним проект любой сложности, за максимально короткие сроки.';
        $url = 'http://new-line.by/contact';

        $seoPage = $this->container->get('sonata.seo.page');
        $seoPage
            ->setTitle($title)
            ->addMeta('name', 'description', $description)
            ->addMeta('property', 'og:title', $title)
            ->addMeta('property', 'og:description', $description)
            ->addMeta('property', 'og:url', $url)
            ->addMeta('property', 'twitter:title', $title)
            ->addMeta('property', 'twitter:description', $description);

        $callform = $this->Call($request);

        $enquiry = new Enquiry();

        $form = $this->createForm(EnquiryType::class, $enquiry);

        if ($request->isMethod($request::METHOD_POST)) {

            $form->handleRequest($request);

            if ($form->isValid()) {
                if ($enquiry->getPhone() != null) {
                    $request->getSession()
                        ->getFlashBag()
                        ->add('success', 'Обнаружен спам');
                    // Redirect - This is important to prevent users re-posting
                    // the form if they refresh the page
                    return $this->redirect($this->generateUrl('BloggerBlogBundle_contact'));
                } else {
                    $this->Mailer($enquiry);

                    $request->getSession()
                        ->getFlashBag()
                        ->add('success', 'Ваше сообщение успешно отправлено.');
                    // Redirect - This is important to prevent users re-posting
                    // the form if they refresh the page
                    return $this->redirect($this->generateUrl('BloggerBlogBundle_contact'));

                }
            }

        }

        return $this->render('BloggerBlogBundle:Page:contact.html.twig', array(
            'form' => $form->createView(),
            'callform' => $callform->createView()
        ));
    }


    public function seoAction(Request $request)
    {

        $title = 'Seo продвижение сайта в топ - Эффективная раскрутка сайта в поисковых системах';
        $description = 'Seo продвижение сайта в топ поисковых систем - Google и Yandex. Только белые методы СЕО. Работаем по Беларуси, а также по России. Команда опытных специалистов обеспечит эффективную расскрутку вашего сайта в поисковых системах за оптимальную цену.';
        $url = 'http://new-line.by/seo-prodvizhenie-sajta';

        $seoPage = $this->container->get('sonata.seo.page');
        $seoPage
            ->setTitle($title)
            ->addMeta('name', 'description', $description)
            ->addMeta('property', 'og:title', $title)
            ->addMeta('property', 'og:description', $description)
            ->addMeta('property', 'og:url', $url)
            ->addMeta('property', 'twitter:title', $title)
            ->addMeta('property', 'twitter:description', $description);
        $callform = $this->Call($request);

        $enquiry = new SeoEnquiry();

        $form = $this->createForm(SeoEnquiryType::class, $enquiry);

        if ($request->isMethod($request::METHOD_POST)) {

            $form->handleRequest($request);
            if ($form->isValid()) {

                $this->Mailer($enquiry);

                $request->getSession()
                    ->getFlashBag()
                    ->add('success', 'Ваше сообщение успешно отправлено.');
                // Redirect - This is important to prevent users re-posting
                // the form if they refresh the page
                return $this->redirect($this->generateUrl('BloggerBlogBundle_seo'));

            }

        }

        return $this->render('BloggerBlogBundle:Page:seo.html.twig', array(
            'callform' => $callform->createView(),
            'form' => $form->createView()
        ));
    }

    public function createAction(Request $request)
    {

        $title = 'Создание сайтов в Минске, отличные цены - Разработка сайтов в Минске';
        $description = 'Создание сайтов в Минске, а также по РБ ✔ любой сложности. Наши специалисты выполнят любой проект за максимально короткие сроки. Гарантия качества! Разработка сайтов в Минске - New Line Studio.';
        $url = 'http://new-line.by/create-new-site';


        $seoPage = $this->container->get('sonata.seo.page');
        $seoPage
            ->setTitle($title)
            ->addMeta('name', 'description', $description)
            ->addMeta('property', 'og:title', $title)
            ->addMeta('property', 'og:description', $description)
            ->addMeta('property', 'og:url', $url)
            ->addMeta('property', 'twitter:title', $title)
            ->addMeta('property', 'twitter:description', $description);
        $callform = $this->Call($request);


        $enquiry = new CreateEnquiry();

        $form = $this->createForm(CreateEnquiryType::class, $enquiry);

        if ($request->isMethod($request::METHOD_POST)) {

            $form->handleRequest($request);
            if ($form->isValid()) {

                $this->Mailer($enquiry);

                $request->getSession()
                    ->getFlashBag()
                    ->add('success', 'Ваше сообщение успешно отправлено.');
                // Redirect - This is important to prevent users re-posting
                // the form if they refresh the page
                return $this->redirect($this->generateUrl('BloggerBlogBundle_create'));

            }

        }

        return $this->render('BloggerBlogBundle:Page:create.html.twig', array(
            'callform' => $callform->createView(),
            'form' => $form->createView()
        ));
    }

    public function supportAction(Request $request)
    {

        $title = 'Поддержка сайтов в Минске, отличные цены - New Line Studio';
        $description = 'Поддержка сайтов в Минске, а также по РБ ✔ гарантия качества! Наша команда специалистов выполнит поддержку сайтов по оптимальной для вас цене - New Line Studio';
        $url = 'http://new-line.by/support-site';

        $seoPage = $this->container->get('sonata.seo.page');
        $seoPage
            ->setTitle($title)
            ->addMeta('name', 'description', $description)
            ->addMeta('property', 'og:title', $title)
            ->addMeta('property', 'og:description', $description)
            ->addMeta('property', 'og:url', $url)
            ->addMeta('property', 'twitter:title', $title)
            ->addMeta('property', 'twitter:description', $description);
        $callform = $this->Call($request);


        $enquiry = new SupportEnquiry();

        $form = $this->createForm(SupportEnquiryType::class, $enquiry);

        if ($request->isMethod($request::METHOD_POST)) {

            $form->handleRequest($request);
            if ($form->isValid()) {

                $this->Mailer($enquiry);

                $request->getSession()
                    ->getFlashBag()
                    ->add('success', 'Ваше сообщение успешно отправлено.');
                // Redirect - This is important to prevent users re-posting
                // the form if they refresh the page
                return $this->redirect($this->generateUrl('BloggerBlogBundle_support'));

            }

        }
        return $this->render('BloggerBlogBundle:Page:support.html.twig', array(
            'callform' => $callform->createView(),
            'form' => $form->createView()
        ));
    }

    public function programmerAction(Request $request)
    {
        $title = 'Услуги программиста - New Line Studio';
        $description = 'Услуги программиста в Минске, а также по РБ ✔ гарантия качества! Наша команда специалистов выполнит выполнит задачу любой сложности по оптимальной для вас цене - New Line Studio.';
        $url = 'http://new-line.by/programmer';

        $seoPage = $this->container->get('sonata.seo.page');
        $seoPage
            ->setTitle($title)
            ->addMeta('name', 'description', $description)
            ->addMeta('property', 'og:title', $title)
            ->addMeta('property', 'og:description', $description)
            ->addMeta('property', 'og:url', $url)
            ->addMeta('property', 'twitter:title', $title)
            ->addMeta('property', 'twitter:description', $description);
        $callform = $this->Call($request);

        return $this->render('BloggerBlogBundle:Page:programmer.html.twig', array(
            'callform' => $callform->createView()
        ));
    }

    public function projectsAction(Request $request)
    {

        $title = 'Наши выполненные проекты по созданию и продвижению сайтов | New Line Studio';
        $description = 'В данном разделе Вы найдете наши выполненные работы. Хотите себе сайт? Хотите быть в Топах поисковых систем? Вы попали по адресу - гарантия качества | New Line Studio';
        $url = 'http://new-line.by/projects';

        $seoPage = $this->container->get('sonata.seo.page');
        $seoPage
            ->setTitle($title)
            ->addMeta('name', 'description', $description)
            ->addMeta('property', 'og:title', $title)
            ->addMeta('property', 'og:description', $description)
            ->addMeta('property', 'og:url', $url)
            ->addMeta('property', 'twitter:title', $title)
            ->addMeta('property', 'twitter:description', $description);
        $callform = $this->Call($request);

        return $this->render('BloggerBlogBundle:Page:projects.html.twig', array(
            'callform' => $callform->createView()
        ));
    }

    public function confirmAction(Request $request)
    {
        $seoPage = $this->container->get('sonata.seo.page');
        $seoPage
            ->setTitle('Подтверждение')
            ->addMeta('name', 'robots', 'noindex, nofollow')
            ->addMeta('name', 'description', 'confirm page')
            ->addMeta('property', 'og:description', 'confirm page');
        $callform = $this->Call($request);

        return $this->render('BloggerBlogBundle:Page:confirm.html.twig', array(
            'callform' => $callform->createView()
        ));
    }

    public function seoyandexAction(Request $request)
    {

        $title = 'Продвижение сайтов в Яндекс топ - Seo Яндекс поисковое продвижение';
        $description = 'Поисковое продвижение сайтов в Яндекс в топ. Гарантия качества, работаем по Беларуси, а также по России. Успешная команда специалистов с большим опытом выполнит seo продвижение вашего сайта в Яндексе. Мы используем только белые методы.';
        $url = 'http://new-line.by/seo-prodvizhenie-sajta/prodvizhenie-sajta-v-yandex';

        $seoPage = $this->container->get('sonata.seo.page');
        $seoPage
            ->setTitle($title)
            ->addMeta('name', 'description', $description)
            ->addMeta('property', 'og:title', $title)
            ->addMeta('property', 'og:description', $description)
            ->addMeta('property', 'og:url', $url)
            ->addMeta('property', 'twitter:title', $title)
            ->addMeta('property', 'twitter:description', $description);
        $callform = $this->Call($request);

        $enquiry = new Enquiry();

        $form = $this->createForm(EnquiryType::class, $enquiry);

        if ($request->isMethod($request::METHOD_POST)) {

            $form->handleRequest($request);
            if ($form->isValid()) {

                $this->Mailer($enquiry);

                $request->getSession()
                    ->getFlashBag()
                    ->add('success', 'Ваше сообщение успешно отправлено.');
                // Redirect - This is important to prevent users re-posting
                // the form if they refresh the page
                return $this->redirect($this->generateUrl('BloggerBlogBundle_seo'));

            }

        }

        return $this->render('BloggerBlogBundle:Page:seoyandex.html.twig', array(
            'callform' => $callform->createView(),
            'form' => $form->createView()
        ));
    }

    public function websajtiAction(Request $request)
    {

        $title = 'Продвижение Web-сайтов в топ - раскрутка web-сайтов по выгодным ценам';
        $description = 'Поисковое продвижение web-сайтов в топ Google и Яндекс по выгодным для вас ценам. Работаем по Беларуси, а также России. Команда наших специалистов, с большом опытом раскрутки web-сайтов обеспечит высокое качество выполненных работ. Только белые методы.';
        $url = 'http://new-line.by/seo-prodvizhenie-sajta/prodvizhenie-web-sajtov';

        $seoPage = $this->container->get('sonata.seo.page');
        $seoPage
            ->setTitle($title)
            ->addMeta('name', 'description', $description)
            ->addMeta('property', 'og:title', $title)
            ->addMeta('property', 'og:description', $description)
            ->addMeta('property', 'og:url', $url)
            ->addMeta('property', 'twitter:title', $title)
            ->addMeta('property', 'twitter:description', $description);
        $callform = $this->Call($request);

        $enquiry = new Enquiry();

        $form = $this->createForm(EnquiryType::class, $enquiry);

        if ($request->isMethod($request::METHOD_POST)) {

            $form->handleRequest($request);
            if ($form->isValid()) {

                $this->Mailer($enquiry);

                $request->getSession()
                    ->getFlashBag()
                    ->add('success', 'Ваше сообщение успешно отправлено.');
                // Redirect - This is important to prevent users re-posting
                // the form if they refresh the page
                return $this->redirect($this->generateUrl('BloggerBlogBundle_seo'));

            }

        }

        return $this->render('BloggerBlogBundle:Page:websajti.html.twig', array(
            'callform' => $callform->createView(),
            'form' => $form->createView()
        ));
    }

    public function priceseoAction(Request $request)
    {

        $title = 'Продвижение сайта, цены - Стоимость продвижения сайта в топ';
        $description = 'Продвижение сайта, цены ниже рыночных. Успешная команда специалистов с большим опытом выполнит продвижение вашего сайта по отличной цене и за максимально короткие сроки. Узнайте стоимость продвижения вашего сайта на нашем сайте.';
        $url = 'http://new-line.by/seo-prodvizhenie-sajta/ceny-na-prodvizhenie-sajta';

        $seoPage = $this->container->get('sonata.seo.page');
        $seoPage
            ->setTitle($title)
            ->addMeta('name', 'description', $description)
            ->addMeta('property', 'og:title', $title)
            ->addMeta('property', 'og:description', $description)
            ->addMeta('property', 'og:url', $url)
            ->addMeta('property', 'twitter:title', $title)
            ->addMeta('property', 'twitter:description', $description);
        $callform = $this->Call($request);

        $enquiry = new Enquiry();

        $form = $this->createForm(EnquiryType::class, $enquiry);

        if ($request->isMethod($request::METHOD_POST)) {

            $form->handleRequest($request);
            if ($form->isValid()) {

                $this->Mailer($enquiry);

                $request->getSession()
                    ->getFlashBag()
                    ->add('success', 'Ваше сообщение успешно отправлено.');
                // Redirect - This is important to prevent users re-posting
                // the form if they refresh the page
                return $this->redirect($this->generateUrl('BloggerBlogBundle_seo'));

            }

        }

        return $this->render('BloggerBlogBundle:Page:priceseo.html.twig', array(
            'callform' => $callform->createView(),
            'form' => $form->createView()
        ));
    }

    public function seotoptenAction(Request $request)
    {

        $title = 'Продвижение сайтов в топ 10 - New-line studio';
        $description = 'Продвижение сайтов в топ 10 поисковых систем google и яндекс по выгодным ценам. Наша команда опытных специалистов продвинет ваш сайт в топ 10 поисковых систем. Только белые методы, работа по Беларуси и России.';
        $url = 'http://new-line.by/seo-prodvizhenie-sajta/ceny-na-prodvizhenie-sajta';

        $seoPage = $this->container->get('sonata.seo.page');
        $seoPage
            ->setTitle($title)
            ->addMeta('name', 'description', $description)
            ->addMeta('property', 'og:title', $title)
            ->addMeta('property', 'og:description', $description)
            ->addMeta('property', 'og:url', $url)
            ->addMeta('property', 'twitter:title', $title)
            ->addMeta('property', 'twitter:description', $description);
        $callform = $this->Call($request);

        $enquiry = new Enquiry();

        $form = $this->createForm(EnquiryType::class, $enquiry);

        if ($request->isMethod($request::METHOD_POST)) {

            $form->handleRequest($request);
            if ($form->isValid()) {

                $this->Mailer($enquiry);

                $request->getSession()
                    ->getFlashBag()
                    ->add('success', 'Ваше сообщение успешно отправлено.');
                // Redirect - This is important to prevent users re-posting
                // the form if they refresh the page
                return $this->redirect($this->generateUrl('BloggerBlogBundle_seo'));

            }

        }

        return $this->render('BloggerBlogBundle:Page:seotopten.html.twig', array(
            'callform' => $callform->createView(),
            'form' => $form->createView()
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
        $message = Swift_Message::newInstance('Заявка с сайта New-line')
            ->setFrom(array('seo-newline@mail.ru'))
            ->setTo($this->container->getParameter('blogger_blog.emails.contact_email'))
            ->setBody($this->renderView('BloggerBlogBundle:Page:contactEmail.txt.twig', array('enquiry' => $enquiry)));;

        // Send the message
        $mailer->send($message);
    }

    public function Caller($call)
    {
        $mailer = $this->Transport();

        // Create a message
        $message = Swift_Message::newInstance('Форма обратного звонка')
            ->setFrom(array('seo-newline@mail.ru'))
            ->setTo($this->container->getParameter('blogger_blog.emails.contact_email'))
            ->setBody($this->renderView('BloggerBlogBundle:Page:callEmail.txt.twig', array('call' => $call)));;

        // Send the message
        $mailer->send($message);
    }

    public function Transport()
    {
        // Create the Transport
        $transport = Swift_SmtpTransport::newInstance('smtp.mail.ru', 465, 'ssl')
            ->setUsername('seo-newline@mail.ru')
            ->setPassword('19086837dima');

        // Create the Mailer using your created Transport
        return $mailer = Swift_Mailer::newInstance($transport);

    }

}