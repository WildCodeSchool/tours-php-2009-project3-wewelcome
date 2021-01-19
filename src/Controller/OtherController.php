<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use App\Form\ApplyType;
use App\FormData\ApplyData;

class OtherController extends AbstractController
{
    /**
     * @Route("/nous-rejoindre", name="work_with_us")
     */
    public function workWithUs(Request $request): Response
    {
        $apply = new ApplyData();
        $form = $this->createForm(ApplyType::class, $apply);
        $form->handleRequest($request);

        /*if ($form->isSubmitted() && $form->isValid()) {

        }*/

        return $this->render('other/apply.html.twig', ['form' => $form->createView()]);
    }
}
