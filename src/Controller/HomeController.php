<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\FormData\MailMessageData;
use App\Form\MailMessageType;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(Request $request, MailerInterface $mailer): Response
    {
        $mailMessage = new MailMessageData();
        $form = $this->createForm(MailMessageType::class, $mailMessage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->sendMail($mailer, $mailMessage);
            return $this->redirectToRoute('home');
        }

        return $this->render('home/index.html.twig', ['form' => $form->createView()]);
    }

    private function sendMail(MailerInterface $mailer, MailMessageData $mailMessage): void
    {
        $email = (new Email())
            ->from($_POST['mail_message']['email'])
            ->to('wewelcome.test@gmail.com')
            ->subject("Message client : " . $mailMessage->getSubject())
            ->html("
                <p>Sujet : " . $mailMessage->getSubject() . "</p>
                <p>Nom : " . $mailMessage->getFirstName() . " " . $mailMessage->getLastName() . "</p>
                <p>Message : " . $mailMessage->getMessage() . "</p>
                <p>Téléphone : " . $mailMessage->getPhone() . "</p>
                <p>Email : " . $mailMessage->getEmail() . "</p>
            ");

        $mailer->send($email);
    }
}
