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
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Service;
use App\Form\ServiceType;
use App\Repository\ServiceRepository;
use App\Services\FileManager;

class StewardController extends AbstractController
{
    /**
     * @Route("/intendance", name="steward")
     */
    public function index(
        Request $request,
        MailerInterface $mailer,
        ServiceRepository $serviceRepository,
        EntityManagerInterface $entityManager,
        FileManager $fileManager
    ): Response {
        $services = $serviceRepository->findBy(['relatedTo' => 'steward']);

        /** Display the add service form and add it in the DB */
        $service = new Service();
        $serviceForm = $this->createForm(ServiceType::class, $service);
        $serviceForm->handleRequest($request);

        if ($serviceForm->isSubmitted() && $serviceForm->isValid()) {
            $logoServiceFile = $serviceForm->get('logoFile')->getData();
            $photoServiceFile = $serviceForm->get('photoFile')->getData();

            $resultsLogo = $fileManager->saveFile(
                $service->getTitle() . '-logo',
                $logoServiceFile,
                $this->getParameter('services_directory')
            );

            $resultsPhoto = $fileManager->saveFile(
                $service->getTitle() . '-photo',
                $photoServiceFile,
                $this->getParameter('services_directory')
            );

            $service->setLogo($resultsLogo['fileName']);
            $service->setPhoto($resultsPhoto['fileName']);
            $service->setRelatedTo('steward');
            $entityManager->persist($service);
            $entityManager->flush();

            return $this->redirectToRoute('steward');
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

            return $this->redirectToRoute('steward');
        }

        return $this->render('steward/index.html.twig', [
            'form' => $form->createView(),
            'serviceForm' => $serviceForm->createView(),
            'services' => $services
        ]);
    }
}
