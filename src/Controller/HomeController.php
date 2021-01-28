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
use App\Repository\HomeRepository;
use App\Entity\Home;
use App\Form\CarouselType;
use App\Form\PurposeValuesType;
use App\Services\HomeManager;
use App\Repository\ServiceRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

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
        HomeRepository $homeRepository
    ): Response {
        $error = '';

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
        if ($carousel === null) {
            $carousel = new Home();
            $carousel->setType('carousel');
            $entityManager->persist($carousel);
        }

        $purpose = $homeRepository->findOneBy(['type' => 'purpose']);
        if ($purpose === null) {
            $purpose = new Home();
            $purpose->setType('purpose');
            $entityManager->persist($purpose);
        }

        $values = $homeRepository->findOneBy(['type' => 'values']);
        if ($values === null) {
            $values = new Home();
            $values->setType('values');
            $entityManager->persist($values);
        }
        $entityManager->flush();

        return $this->render('home/index.html.twig', [
            'form' => $form->createView(),
            'partnerForm' => $partnerForm->createView(),
            'hostingPartners' => $hostingPartners,
            'otherPartners' => $othersPartners,
            'carousel' => $carousel,
            'purpose' => $purpose,
            'values' => $values,
            'servicesConcierge' => $servicesConcierge,
            'servicesSteward' => $servicesSteward,
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

    /**
     * This method allows you to modify the default home object.
     * But also to completely modify it.
     * @Route("{idCarousel}/edit-carousel", name="edit_carousel", methods={"GET", "POST"})
     * @ParamConverter("home", class="App\Entity\Home", options={"mapping": {"idCarousel": "id"}})
     * @IsGranted("ROLE_ADMIN")
     */
    public function editCarousel(
        Request $request,
        EntityManagerInterface $entityManager,
        FileManager $fileManager,
        Home $home
    ): Response {

        $carouselForm = $this->createForm(CarouselType::class, $home);
        $carouselForm->handleRequest($request);

        if ($carouselForm->isSubmitted() && $carouselForm->isValid()) {
            $pictureOne = $carouselForm->get('pictureOne')->getData();
            $pictureTwo = $carouselForm->get('pictureTwo')->getData();
            $pictureThree = $carouselForm->get('pictureThree')->getData();
            if (
                $pictureOne !== null &&
                $home->getPictureOne() !== null
            ) {
                $fileManager->deleteFile($home->getPictureOne(), $this->getParameter('carousel_directory'));
                $addPictureOne = $fileManager->saveFile(
                    'pictureOne',
                    $pictureOne,
                    $this->getParameter('carousel_directory')
                );
                $home->setPictureOne($addPictureOne['fileName']);
            }
            if (
                $pictureTwo !== null &&
                $home->getPictureTwo() !== null
            ) {
                $fileManager->deleteFile($home->getPictureTwo(), $this->getParameter('carousel_directory'));
                $addPictureTwo = $fileManager->saveFile(
                    'pictureTwo',
                    $pictureTwo,
                    $this->getParameter('carousel_directory')
                );
                $home->setPictureTwo($addPictureTwo['fileName']);
            }
            if (
                $pictureThree !== null &&
                $home->getPictureThree() !== null
            ) {
                $fileManager->deleteFile($home->getPictureThree(), $this->getParameter('carousel_directory'));
                $addPictureThree = $fileManager->saveFile(
                    'pictureThree',
                    $pictureThree,
                    $this->getParameter('carousel_directory')
                );
                $home->setPictureThree($addPictureThree['fileName']);
            }

            $entityManager->flush();

            return $this->redirectToRoute('home');
        }
        return $this->render('home/editCarousel.html.twig', [
            'carouselForm' => $carouselForm->createView(),
            'carousel' => $home
        ]);
    }

    /**
     * This method deletes the current object and therefore the default content is displayed in the view.
     * @Route("/default-carousel", name="default_carousel", methods={"GET"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function defaultCarousel(
        HomeManager $homeManager
    ): Response {

        $carousel = new Home();
        $carousel->setType('carousel');
        $homeManager->removeHome($carousel, 'carousel', 'carousel_directory');
        return $this->redirectToRoute('home');
    }

    /**
     * This method allows you to modify an edited carousel.
     * @Route("{idPurpose}/edit-purpose", name="edit_purpose", methods={"GET", "POST"})
     * @ParamConverter("home", class="App\Entity\Home", options={"mapping": {"idPurpose": "id"}})
     * @IsGranted("ROLE_ADMIN")
     */
    public function editPurpose(
        Request $request,
        EntityManagerInterface $entityManager,
        FileManager $fileManager,
        Home $home
    ): Response {

        $purposeForm = $this->createForm(PurposeValuesType::class, $home);
        $purposeForm->handleRequest($request);

        if ($purposeForm->isSubmitted() && $purposeForm->isValid()) {
            $pictureOne = $purposeForm->get('pictureOne')->getData();
            if (
                $pictureOne !== null &&
                $home->getPictureOne() !== null
            ) {
                $fileManager->deleteFile($home->getPictureOne(), $this->getParameter('purpose_directory'));
                $addPictureOne = $fileManager->saveFile(
                    'pictureOne',
                    $pictureOne,
                    $this->getParameter('purpose_directory')
                );
                $home->setPictureOne($addPictureOne['fileName']);
            }

            $entityManager->flush();

            return $this->redirect($this->generateUrl('home') . '#section-purpose');
        }
        return $this->render('home/editPurpose.html.twig', [
            'purposeForm' => $purposeForm->createView(),
            'purpose' => $home
        ]);
    }

    /**
     * This method deletes the current object and therefore the default content is displayed in the view.
     * @Route("/default-purpose", name="default_purpose", methods={"GET"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function defaultPurpose(
        HomeManager $homeManager
    ): Response {

        $purpose = new Home();
        $purpose->setType('purpose');
        $homeManager->removeHome($purpose, 'purpose', 'purpose_directory');
        return $this->redirect($this->generateUrl('home') . '#section-purpose');
    }

    /**
     * This method allows you to modify an edited carousel.
     * @Route("{idValues}/edit-values", name="edit_values", methods={"GET", "POST"})
     * @ParamConverter("home", class="App\Entity\Home", options={"mapping": {"idValues": "id"}})
     * @IsGranted("ROLE_ADMIN")
     */
    public function editValues(
        Request $request,
        EntityManagerInterface $entityManager,
        FileManager $fileManager,
        Home $home
    ): Response {

        $valuesForm = $this->createForm(PurposeValuesType::class, $home);
        $valuesForm->handleRequest($request);

        if ($valuesForm->isSubmitted() && $valuesForm->isValid()) {
            $pictureOne = $valuesForm->get('pictureOne')->getData();
            if (
                $pictureOne !== null &&
                $home->getPictureOne() !== null
            ) {
                $fileManager->deleteFile($home->getPictureOne(), $this->getParameter('values_directory'));
                $addPictureOne = $fileManager->saveFile(
                    'pictureOne',
                    $pictureOne,
                    $this->getParameter('values_directory')
                );
                $home->setPictureOne($addPictureOne['fileName']);
            }

            $entityManager->flush();

            return $this->redirect($this->generateUrl('home') . '#section-values');
        }
        return $this->render('home/editValues.html.twig', [
            'valuesForm' => $valuesForm->createView(),
            'values' => $home
        ]);
    }

    /**
     * This method deletes the current object and therefore the default content is displayed in the view.
     * @Route("/default-values", name="default_values", methods={"GET"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function defaultValues(
        HomeManager $homeManager
    ): Response {

        $values = new Home();
        $values->setType('values');
        $homeManager->removeHome($values, 'values', 'values_directory');
        return $this->redirect($this->generateUrl('home') . '#section-values');
    }
}
