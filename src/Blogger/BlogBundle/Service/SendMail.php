<?php

namespace Blogger\BlogBundle\Service;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

// Import new namespaces
use Symfony\Component\HttpFoundation\Request;
use Blogger\BlogBundle\Entity\Enquiry;
use Blogger\BlogBundle\Form\EnquiryType;

class SendMail extends \Swift_Mailer
{

}