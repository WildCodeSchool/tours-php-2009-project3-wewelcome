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
use App\Form\PartnerType;
use App\Entity\Partner;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\PartnerRepository;
use App\Services\FileManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Repository\ServiceRepository;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(
        Request $request,
        MailerInterface $mailer,
        EntityManagerInterface $entityManager,
        ServiceRepository $serviceRepository,
        PartnerRepository $partnerRepository,
        FileManager $fileManager
    ): Response {
        $error = '';

        $servicesConcierge = $serviceRepository->findBy(['relatedTo' => 'concierge']);

        $hostingPartners = $partnerRepository->findBy(['type' => 'hostingPlatform']);
        $othersPartners = $partnerRepository->findBy(['type' => 'other']);

        /** Display the add partner form and add it in the DB */
        $partner = new Partner();
        $partnerForm = $this->createForm(PartnerType::class, $partner);
        $partnerForm->handleRequest($request);

        if ($partnerForm->isSubmitted() && $partnerForm->isValid()) {
            $logoPartnerFile = $partnerForm->get('logoFile')->getData();

            $results = $fileManager->saveFile(
                $partner->getName(),
                $logoPartnerFile,
                $this->getParameter('partners_directory')
            );

            $partner->setLogo($results['fileName']);
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
            'hostingPartners' => $hostingPartners,
            'otherPartners' => $othersPartners,
            'servicesConcierge' => $servicesConcierge,
            'error' => $error
        ]);
    }

    /**
     * @Route("/partenaire/{id}", name="partner_delete", methods={"DELETE"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function deletePartner(
        Request $request,
        Partner $partner,
        EntityManagerInterface $entityManager,
        FileManager $fileManager
    ): Response {
        if ($this->isCsrfTokenValid('delete' . $partner->getId(), $request->request->get('_token'))) {
            $fileManager->deleteFile($partner->getLogo(), $this->getParameter('partners_directory'));

            $entityManager->remove($partner);
            $entityManager->flush();
        }

        return $this->redirectToRoute('home');
    }
}
