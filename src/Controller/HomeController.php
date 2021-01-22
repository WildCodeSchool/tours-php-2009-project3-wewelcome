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
use Symfony\Component\Filesystem\Filesystem;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Repository\HomeRepository;
use App\Entity\Home;
use App\Form\CarouselType;
use App\Form\PurposeType;

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
        FileManager $fileManager,
        HomeRepository $homeRepository
    ): Response {
        $error = '';

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

        $carousel = $homeRepository->findOneBy(['type' => 'carousel']);
        //Creation of a carousel object if one does not exist in the database
        //Otherwise sending the carousel in the view will not work
        if ($carousel == null) {
            $carousel = new Home();
        }

        $purpose = $homeRepository->findOneBy(['type' => 'purpose']);
        //Creation of a carousel object if one does not exist in the database
        //Otherwise sending the carousel in the view will not work
        if ($purpose == null) {
            $purpose = new Home();
        }

        return $this->render('home/index.html.twig', [
            'form' => $form->createView(),
            'partnerForm' => $partnerForm->createView(),
            'hostingPartners' => $hostingPartners,
            'otherPartners' => $othersPartners,
            'error' => $error,
            'carousel' => $carousel,
            'purpose' => $purpose
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

    /**
     * This method is used to modify the default carousel.
     * The database is therefore empty by default.
     * If there is a carousel in the database, we delete the files that are in the upload folder.
     * Then we remove the carousel that there is in comic book then we add the new one.
     * @Route("/edit-carousel", name="edit_carousel", methods={"GET", "POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function editCarousel(
        Request $request,
        EntityManagerInterface $entityManager,
        FileManager $fileManager,
        HomeRepository $homeRepository
    ): Response {

        $carousel = $homeRepository->findOneBy(['type' => 'carousel']);
        //Creation of a carousel object if one does not exist in the database
        //Otherwise sending the carousel in the view will not work
        if ($carousel == null) {
            $carousel = new Home();
        }
        $editCarousel = new Home();
        $carouselForm = $this->createForm(CarouselType::class, $editCarousel);
        $carouselForm->handleRequest($request);
        if ($carouselForm->isSubmitted() && $carouselForm->isValid()) {
            //Delete photos in the home folder if there are any
            if ($carousel->getPictureOne() !== null) {
                $fileManager->deleteFile($carousel->getPictureOne(), $this->getParameter('home_directory'));
            }
            if ($carousel->getPictureTwo() !== null) {
                $fileManager->deleteFile($carousel->getPictureTwo(), $this->getParameter('home_directory'));
            }
            if ($carousel->getPictureThree() !== null) {
                $fileManager->deleteFile($carousel->getPictureThree(), $this->getParameter('home_directory'));
            }
            //Deleting the carousel object from the database
            $entityManager->remove($carousel);
            //Saving uploader photos
            $pictureOne = $carouselForm->get('pictureOne')->getData();
            $pictureTwo = $carouselForm->get('pictureTwo')->getData();
            $pictureThree = $carouselForm->get('pictureThree')->getData();
            //Saving photos in the home folder
            $addPictureOne = $fileManager->saveFile(
                'pictureOne',
                $pictureOne,
                $this->getParameter('home_directory')
            );
            $addPictureTwo = $fileManager->saveFile(
                'pictureTwo',
                $pictureTwo,
                $this->getParameter('home_directory')
            );
            $addPictureThree = $fileManager->saveFile(
                'pictureThree',
                $pictureThree,
                $this->getParameter('home_directory')
            );
            //Saving photos in the database
            $editCarousel->setPictureOne($addPictureOne['fileName']);
            $editCarousel->setPictureTwo($addPictureTwo['fileName']);
            $editCarousel->setPictureThree($addPictureThree['fileName']);
            $editCarousel->setType('carousel');

            $entityManager->persist($editCarousel);
            $entityManager->flush();

            return $this->redirectToRoute('home');
        }
        return $this->render('home/editCarousel.html.twig', [
            'carouselForm' => $carouselForm->createView()
        ]);
    }

    /**
     * This method allows you to reset the carousel to default.
     * If there is a carousel in the database, it is deleted.
     * @Route("/default-carousel", name="default_carousel", methods={"GET"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function defaultCarousel(
        EntityManagerInterface $entityManager,
        HomeRepository $homeRepository,
        FileManager $fileManager
    ): Response {

        $carousel = $homeRepository->findOneBy(['type' => 'carousel']);
        //Creation of a carousel object if one does not exist in the database
        //Otherwise sending the carousel in the view will not work
        if ($carousel == null) {
            $carousel = new Home();
        }
        //Delete photos in the home folder if there are any
        if ($carousel != null) {
            //Delete photos in the home folder if there are any
            if ($carousel->getPictureOne() !== null) {
                $fileManager->deleteFile($carousel->getPictureOne(), $this->getParameter('home_directory'));
            }
            if ($carousel->getPictureTwo() !== null) {
                $fileManager->deleteFile($carousel->getPictureTwo(), $this->getParameter('home_directory'));
            }
            if ($carousel->getPictureThree() !== null) {
                $fileManager->deleteFile($carousel->getPictureThree(), $this->getParameter('home_directory'));
            }
        }
        //Deleting the carousel object from the database if not null
        if ($carousel != null) {
            $entityManager->remove($carousel);
        }
        $entityManager->flush();

        return $this->redirectToRoute('home');
    }

    /**
     * This method is used to modify the default carousel.
     * The database is therefore empty by default.
     * If there is a carousel in the database, we delete the files that are in the upload folder.
     * Then we remove the carousel that there is in comic book then we add the new one.
     * @Route("/edit-purpose", name="edit_purpose", methods={"GET", "POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function editPurpose(
        Request $request,
        EntityManagerInterface $entityManager,
        FileManager $fileManager,
        HomeRepository $homeRepository
    ): Response {

        $purpose = $homeRepository->findOneBy(['type' => 'purpose']);
        //Creation of a purpose object if one does not exist in the database
        //Otherwise sending the purpose in the view will not work
        if ($purpose == null) {
            $purpose = new Home();
        }
        $editPurpose = new Home();
        $purposeForm = $this->createForm(PurposeType::class, $editPurpose);
        $purposeForm->handleRequest($request);
        if ($purposeForm->isSubmitted() && $purposeForm->isValid()) {
            //Delete photos in the home folder if there are any
            if ($purpose->getPictureOne() !== null) {
                $fileManager->deleteFile($purpose->getPictureOne(), $this->getParameter('purpose_directory'));
            }
            //Deleting the purpose object from the database
            $entityManager->remove($purpose);
            //Saving uploader photos
            $pictureOne = $purposeForm->get('pictureOne')->getData();
            //Saving photos in the home folder
            $addPictureOne = $fileManager->saveFile(
                'pictureOne',
                $pictureOne,
                $this->getParameter('purpose_directory')
            );
            //Saving photos in the database
            $editPurpose->setPictureOne($addPictureOne['fileName']);
            $editPurpose->setType('purpose');

            $entityManager->persist($editPurpose);
            $entityManager->flush();

            return $this->redirectToRoute('home');
        }
        return $this->render('home/editPurpose.html.twig', [
            'purposeForm' => $purposeForm->createView()
        ]);
    }
}
