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
            ->setTitle('Index')
            ->addMeta('name', 'description', 'Index page')
            ->addMeta('property', 'og:description', 'Index page')

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
            ->setTitle('About')
            ->addMeta('name', 'description', 'Index page')
            ->addMeta('property', 'og:description', 'Index page')

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
            ->setTitle('contact')
            ->addMeta('name', 'description', 'Contact page')
            ->addMeta('property', 'og:description', 'Contact page')

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

    public function servicesAction(Request $request)
    {
        $seoPage = $this->container->get('sonata.seo.page');
        $seoPage
            ->setTitle('services')
            ->addMeta('name', 'description', 'services page')
            ->addMeta('property', 'og:description', 'services page')

        ;

        $callform = $this->Call($request);

        return $this->render('BloggerBlogBundle:Page:services.html.twig', array(
            'callform' =>$callform->createView()
        ));
    }

    public function seoAction(Request $request)
    {
        $seoPage = $this->container->get('sonata.seo.page');
        $seoPage
            ->setTitle('seo')
            ->addMeta('name', 'description', 'seo page')
            ->addMeta('property', 'og:description', 'seo page')

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
            ->setTitle('create')
            ->addMeta('name', 'description', 'create page')
            ->addMeta('property', 'og:description', 'create page')

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
            ->setTitle('support')
            ->addMeta('name', 'description', 'support page')
            ->addMeta('property', 'og:description', 'support page')

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
            ->setTitle('projects')
            ->addMeta('name', 'description', 'projects page')
            ->addMeta('property', 'og:description', 'projects page')

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