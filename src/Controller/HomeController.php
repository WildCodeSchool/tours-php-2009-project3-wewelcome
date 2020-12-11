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
            $this->sendMail($mailer);
            return $this->redirectToRoute('home');
        }

        return $this->render('home/index.html.twig', ['form' => $form->createView()]);
    }

    private function sendMail(MailerInterface $mailer): void
    {
        $email = (new Email())
            ->from($_POST['mail_message']['email'])
            ->to('wewelcome.test@gmail.com')
            ->subject("Message client : " . $_POST['mail_message']['subject'])
            ->html("
                <p>Sujet : " . $_POST['mail_message']['subject'] . "</p>
                <p>Nom : " . $_POST['mail_message']['firstName'] . " " . $_POST['mail_message']['lastName'] . "</p>
                <p>Message : " . $_POST['mail_message']['message'] . "</p>
                <p>Téléphone : " . $_POST['mail_message']['phone'] . "</p>
                <p>Email : " . $_POST['mail_message']['email'] . "</p>
            ");

        $mailer->send($email);
    }
}
