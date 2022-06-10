<?php

namespace App\Components;

use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('contact')]
class ContactComponent extends AbstractController
{
    public function getContact()
    {
        $form = $this->createForm(ContactType::class);

        return $form->createView();
    }

}