<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use App\FormData\MailMessageData;
use App\Form\MailMessageType;
use App\Repository\PartnerRepository;
use App\Entity\Partner;
use App\Form\PartnerType;
use App\Repository\HomeRepository;
use App\Repository\ServiceRepository;
use App\Repository\KeysVisionRepository;
use App\Services\FileManager;

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
        FileManager $fileManager,
        HomeRepository $homeRepository,
        KeysVisionRepository $keysVisionRepository
    ): Response {
        $error = '';

        $carousel = $homeRepository->findBy(['type' => 'carousel']);
        $purpose = $homeRepository->findBy(['type' => 'purpose']);
        $keys = $keysVisionRepository->findBy(['type' => 'keys']);
        $values = $homeRepository->findBy(['type' => 'values']);
        $vision = $keysVisionRepository->findBy(['type' => 'vision']);
        $servicesConcierge = $serviceRepository->findBy(['relatedTo' => 'concierge']);
        $servicesSteward = $serviceRepository->findBy(['relatedTo' => 'steward']);
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

            return $this->redirect($this->generateUrl('home') . '#partners');
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

        $entityManager->flush();

        return $this->render('home/index.html.twig', [
            'carousel' => $carousel,
            'purpose' => $purpose,
            'keys' => $keys,
            'values' => $values,
            'vision' => $vision,
            'servicesConcierge' => $servicesConcierge,
            'servicesSteward' => $servicesSteward,
            'hostingPartners' => $hostingPartners,
            'otherPartners' => $othersPartners,
            'error' => $error,
            'partnerForm' => $partnerForm->createView(),
            'form' => $form->createView()
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

        return $this->redirect($this->generateUrl('home') . '#partners');
    }
}
