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
use App\Form\PartnerFormType;
use App\Entity\Partner;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\PartnerRepository;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(
        Request $request,
        MailerInterface $mailer,
        EntityManagerInterface $entityManager,
        PartnerRepository $partnerRepository,
        SluggerInterface $slug
    ): Response {
        $error = '';

        $partners = $partnerRepository->findAll();

        /** Display the add partner form and add it in the DB */
        $partner = new Partner();
        $partnerForm = $this->createForm(PartnerFormType::class, $partner);
        $partnerForm->handleRequest($request);

        if ($partnerForm->isSubmitted() && $partnerForm->isValid()) {
            $logoPartnerFile = $partnerForm->get('logo')->getData();

            $logoSlugName = $slug->slug($partner->getName());
            $logoFileName = $logoSlugName . '-' . uniqid() . '.' . $logoPartnerFile->guessExtension();

            try {
                $logoPartnerFile->move(
                    $this->getParameter('partners_directory'),
                    $logoFileName
                );
            } catch (FileException $e) {
                $error = 'Le fichier n\'a pas pu être ajouté.';
            }

            $partner->setLogo($logoFileName);
            $entityManager->persist($partner);
            $entityManager->flush();

            return $this->redirectToRoute('home');
        }

        /** display the contact form and send an email to Alexandre */
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

        return $this->render('home/index.html.twig', [
            'form' => $form->createView(),
            'partnerForm' => $partnerForm->createView(),
            'partners' => $partners,
            'error' => $error
        ]);
    }
}
