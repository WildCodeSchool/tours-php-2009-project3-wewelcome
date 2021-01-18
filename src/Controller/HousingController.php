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
use App\Form\HousingFormType;
use App\Entity\Housing;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\HousingRepository;
use App\Services\FileManager;
use Symfony\Component\Filesystem\Filesystem;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class HousingController extends AbstractController
{
    /**
     * @Route("/logement", name="housing")
     */
    public function index(
        Request $request,
        MailerInterface $mailer,
        EntityManagerInterface $entityManager,
        HousingRepository $housingRepository,
        FileManager $fileManager
    ): Response {
        $error = '';

        $houses = $housingRepository->findBy(['isBusinessTravel' => false]);
        $businessTrip = $housingRepository->findOneBy(['isBusinessTravel' => true]);

        /** Display the add housing form and add it in the DB */
        $housing = new Housing();
        $housingForm = $this->createForm(HousingFormType::class, $housing);
        $housingForm->handleRequest($request);

        if ($housingForm->isSubmitted() && $housingForm->isValid()) {
            $photoHousingFile = $housingForm->get('photoFile')->getData();

            $results = $fileManager->saveFile(
                'housing',
                $photoHousingFile,
                $this->getParameter('housing_directory')
            );

            $housing->setPhoto($results['fileName']);
            $housing->setIsBusinessTravel(false);
            $entityManager->persist($housing);
            $entityManager->flush();

            return $this->redirectToRoute('housing');
        }

        /** generate contact form and send a mail */
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

        return $this->render('housing/index.html.twig', [
            'form' => $form->createView(),
            'housingForm' => $housingForm->createView(),
            'houses' => $houses,
            'businessTrip' => $businessTrip,
            'error' => $error
            ]);
    }

    /**
     * @Route("/logement/{id}", name="housing_delete", methods={"DELETE"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function deleteHousing(
        Request $request,
        Housing $housing,
        EntityManagerInterface $entityManager,
        FileManager $fileManager
    ): Response {
        if ($this->isCsrfTokenValid('delete' . $housing->getId(), $request->request->get('_token'))) {
            $fileManager->deleteFile($housing->getPhoto(), $this->getParameter('housing_directory'));

            $entityManager->remove($housing);
            $entityManager->flush();
        }

        return $this->redirectToRoute('housing');
    }

    /**
     * @Route("/logement/{id}/edit", name="housing_edit", methods={"GET","POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function editHousing(
        Request $request,
        Housing $housing,
        FileManager $fileManager,
        EntityManagerInterface $entityManager
    ): Response {
        $form = $this->createForm(HousingFormType::class, $housing);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $housingFile = $form->get('photoFile')->getData();

            if ($housingFile != null) {
                $fileManager->deleteFile($housing->getPhoto(), $this->getParameter('housing_directory'));

                $results = $fileManager->saveFile(
                    'housing',
                    $housingFile,
                    $this->getParameter('housing_directory')
                );

                $housing->setPhoto($results['fileName']);
            }

            $entityManager->flush();

            return $this->redirectToRoute('housing');
        }

        return $this->render('housing/editHousing.html.twig', [
            'housing' => $housing,
            'housingForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/voyage-d-affaires/{id}/edit", name="business_trip_edit", methods={"GET","POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function editBusinessTrip(
        Request $request,
        Housing $businessTrip,
        FileManager $fileManager,
        EntityManagerInterface $entityManager
    ): Response {
        $form = $this->createForm(HousingFormType::class, $businessTrip);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $businessTripFile = $form->get('photoFile')->getData();

            if ($businessTripFile != null) {
                $fileManager->deleteFile($businessTrip->getPhoto(), $this->getParameter('housing_directory'));

                $results = $fileManager->saveFile(
                    'businessTrip',
                    $businessTripFile,
                    $this->getParameter('housing_directory')
                );

                $businessTrip->setPhoto($results['fileName']);
            }

            $entityManager->flush();

            return $this->redirectToRoute('housing');
        }

        return $this->render('housing/editBusinessTrip.html.twig', [
            'businessTrip' => $businessTrip,
            'businessTripForm' => $form->createView(),
        ]);
    }
}
