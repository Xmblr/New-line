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
        $callform = $this->Call($request);

        return $this->render('BloggerBlogBundle:Page:index.html.twig', array(
            'callform' =>$callform->createView()
        ));

    }

    public function aboutAction()
    {
        return $this->render('BloggerBlogBundle:Page:about.html.twig');
    }

    public function contactAction(Request $request)
    {
        $call = new Call();

        $callform = $this->createForm(CallType::class, $call);

        $enquiry = new Enquiry();

        $form = $this->createForm(EnquiryType::class, $enquiry);

        if ($request->isMethod($request::METHOD_POST)) {

            $callform->handleRequest($request);
            if ($callform->isValid()) {

                $this->Caller($call);

                $request->getSession()
                    ->getFlashBag()
                    ->add('success', 'Ваше сообщение успешно отправлено.')
                ;
                // Redirect - This is important to prevent users re-posting
                // the form if they refresh the page
                return $this->redirect($this->generateUrl('BloggerBlogBundle_contact'));

            }

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

    public function servicesAction()
    {
        return $this->render('BloggerBlogBundle:Page:services.html.twig');
    }

    public function seoAction()
    {
        return $this->render('BloggerBlogBundle:Page:seo.html.twig');
    }

    public function createAction()
    {
        return $this->render('BloggerBlogBundle:Page:create.html.twig');
    }

    public function supportAction()
    {
        return $this->render('BloggerBlogBundle:Page:support.html.twig');
    }
    public function programmerAction()
    {
        return $this->render('BloggerBlogBundle:Page:programmer.html.twig');
    }
    public function projectsAction()
    {
        return $this->render('BloggerBlogBundle:Page:projects.html.twig');
    }

    public function confirmAction(Request $request)
    {
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