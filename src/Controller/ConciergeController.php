<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\FormData\MailMessageData;
use App\Form\MailMessageType;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;

class ConciergeController extends AbstractController
{
    /**
     * @Route("/conciergerie", name="concierge")
     */
    public function index(Request $request, MailerInterface $mailer): Response
    {
        $mailMessage = new MailMessageData();
        $form = $this->createForm(MailMessageType::class, $mailMessage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $email = (new TemplatedEmail())
            ->from($mailMessage->getEmail())
            ->to('wewelcome.test@gmail.com')
            ->subject('Message client : ' . $mailMessage->getSubject())
            ->htmlTemplate('emails/contact.html.twig')
            ->context(['message' => $mailMessage]);

            $mailer->send($email);

            return $this->redirectToRoute('home');
        }

        return $this->render('concierge/index.html.twig', ['form' => $form->createView()]);
    }
}
