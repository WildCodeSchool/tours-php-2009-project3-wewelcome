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
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Filesystem\Filesystem;

class HousingController extends AbstractController
{
    private string $kernelRoot;

    public function __construct(string $kernelRoot)
    {
        $this->kernelRoot = $kernelRoot;
    }

    /**
     * @Route("/logement", name="housing")
     */
    public function index(
        Request $request,
        MailerInterface $mailer,
        EntityManagerInterface $entityManager,
        HousingRepository $housingRepository
    ): Response {
        $error = '';

        $houses = $housingRepository->findBy(['isBusinessTravel' => false]);
        $businessTravel = $housingRepository->findOneBy(['isBusinessTravel' => true]);

        /** Display the add housing form and add it in the DB */
        $housing = new Housing();
        $housingForm = $this->createForm(HousingFormType::class, $housing);
        $housingForm->handleRequest($request);

        if ($housingForm->isSubmitted() && $housingForm->isValid()) {
            $photoHousingFile = $housingForm->get('photoFile')->getData();

            $photoFileName = 'housing-' . uniqid() . '.' . $photoHousingFile->guessExtension();

            try {
                $photoHousingFile->move(
                    $this->getParameter('housing_directory'),
                    $photoFileName
                );
            } catch (FileException $e) {
                $error = 'Le fichier n\'a pas pu être ajouté.';
            }

            $housing->setPhoto($photoFileName);
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
            'businessTravel' => $businessTravel,
            'error' => $error
            ]);
    }

    /**
     * @Route("/{id}", name="housing_delete", methods={"DELETE"})
     */
    public function deleteHousing(Request $request, Housing $housing): Response
    {
        if ($this->isCsrfTokenValid('delete' . $housing->getId(), $request->request->get('_token'))) {
            $filesystem = new Filesystem();
            $path = $this->kernelRoot . '/public/assets/images/housing/' . $housing->getPhoto();
            $filesystem->remove($path);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($housing);
            $entityManager->flush();
        }

        return $this->redirectToRoute('housing');
    }

    /**
     * @Route("/{id}/edit", name="housing_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Housing $housing): Response
    {
        $form = $this->createForm(HousingFormType::class, $housing);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('housing');
        }

        return $this->render('housing/edit.html.twig', [
            'housing' => $housing,
            'housingForm' => $form->createView(),
        ]);
    }
}
