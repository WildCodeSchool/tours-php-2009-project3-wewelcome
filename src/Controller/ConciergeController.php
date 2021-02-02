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
use App\Repository\ConciergeRepository;
use App\Entity\Concierge;
use App\Form\ConciergeType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class ConciergeController extends AbstractController
{
    /**
     * @Route("/conciergerie", name="concierge")
     */
    public function index(
        Request $request,
        MailerInterface $mailer,
        ServiceRepository $serviceRepository,
        EntityManagerInterface $entityManager,
        FileManager $fileManager,
        ConciergeRepository $conciergeRepository
    ): Response {
        $services = $serviceRepository->findBy(['relatedTo' => 'concierge']);

        $pricesNoStress = $conciergeRepository->findOneBy(['type' => 'nostress']);
        $pricesOpen = $conciergeRepository->findOneBy(['type' => 'open']);

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
            $service->setRelatedTo('concierge');
            $entityManager->persist($service);
            $entityManager->flush();

            return $this->redirectToRoute('concierge');
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

            return $this->redirectToRoute('concierge');
        }

        $photos = [];

        foreach ($services as $service) {
            $photos[] = $service->getPhoto();
        }

        return $this->render('concierge/index.html.twig', [
            'form' => $form->createView(),
            'serviceForm' => $serviceForm->createView(),
            'services' => $services,
            'photos' => $photos,
            'pricesNoStress' => $pricesNoStress,
            'pricesOpen' => $pricesOpen
        ]);
    }

    /**
     * @Route("/prices/{id}", name="prices_delete", methods={"DELETE"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function deletePrices(
        Request $request,
        Concierge $concierge,
        EntityManagerInterface $entityManager
    ): Response {
        if ($this->isCsrfTokenValid('delete' . $concierge->getId(), $request->request->get('_token'))) {
            $entityManager->remove($concierge);
            $entityManager->flush();
        }

        return $this->redirect($request->server->get('HTTP_REFERER'));
    }

    /**
     * @Route("/prices/{id}/edit", name="prices_edit", methods={"POST", "GET"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function editPrices(
        Request $request,
        Concierge $concierge,
        EntityManagerInterface $entityManager
    ): Response {
        $form = $this->createForm(ConciergeType::class, $concierge);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('concierge');
        }

        return $this->render('concierge/editPrices.html.twig', [
            'concierge' => $concierge,
            'pricesForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/prices/add/{source}", name="prices_add")
     * @IsGranted("ROLE_ADMIN")
     */
    public function addPrices(
        Request $request,
        EntityManagerInterface $entityManager,
        string $source
    ): Response {
        $concierge = new Concierge();
        $form = $this->createForm(ConciergeType::class, $concierge);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($source == 'nostress') {
                $concierge->setType('nostress');
            } elseif ($source == 'open') {
                $concierge->setType('open');
            }

            $entityManager->persist($concierge);
            $entityManager->flush();

            return $this->redirectToRoute('concierge');
        }

        return $this->render('concierge/editPrices.html.twig', ['pricesForm' => $form->createView()]);
    }
}
