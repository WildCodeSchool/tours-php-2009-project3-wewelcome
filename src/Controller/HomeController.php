<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(): Response
    {
        return $this->render('home/index.html.twig');
    }

    /**
     * @Route("/contact_mail", name="home_contact_mail")
     */
    public function sendMail(): Response
    {
        $from = $_POST['mail'];
        $receiver = "wewelcome.test@gmail.com";
        $subject = "Demande de contact : " . $_POST['firstName'] . " " . $_POST['lastName'];
        $message = "Nom : " . $_POST['lastName'] . " Prénom : " . $_POST['firstName'] . " Sujet : "
            . $_POST['subject'] . " Téléphone : " . $_POST['phone'] . " Mail : " . $_POST['mail'] .
            " Message : " . $_POST['message'];

        $success = mail($receiver, $subject, $message, "From: <$from>");

        if ($success) {
            var_dump("Votre message à bien été envoyé.");
        } else {
            var_dump("Une erreur s'est produite à l'envoi de votre message.");
        }
        return $this->render('home/index.html.twig');
    }
}
