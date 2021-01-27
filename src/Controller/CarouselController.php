<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Repository\HomeRepository;
use App\Entity\Home;
use App\Form\CarouselType;
use App\Services\HomeManager;
use App\Services\FileManager;

class CarouselController extends AbstractController
{
    /**
     * @Route("/new-carousel", name="new_carousel", methods={"GET","POST"})
     */
    public function newCarousel(
        Request $request,
        EntityManagerInterface $entityManager,
        FileManager $fileManager
    ): Response {
        $carousel = new Home();
        $carouselForm = $this->createForm(CarouselType::class, $carousel);
        $carouselForm->handleRequest($request);
        if ($carouselForm->isSubmitted() && $carouselForm->isValid()) {
            $pictureOne = $carouselForm->get('pictureOne')->getData();
            $pictureTwo = $carouselForm->get('pictureTwo')->getData();
            $pictureThree = $carouselForm->get('pictureThree')->getData();
            $addPictureOne = $fileManager->saveFile(
                'pictureOne',
                $pictureOne,
                $this->getParameter('carousel_directory')
            );
            $carousel->setPictureOne($addPictureOne['fileName']);

            $addPictureTwo = $fileManager->saveFile(
                'pictureTwo',
                $pictureTwo,
                $this->getParameter('carousel_directory')
            );
            $carousel->setPictureTwo($addPictureTwo['fileName']);

            $addPictureThree = $fileManager->saveFile(
                'pictureThree',
                $pictureThree,
                $this->getParameter('carousel_directory')
            );
            $carousel->setPictureThree($addPictureThree['fileName']);
            $carousel->setType('carousel');
            $entityManager->persist($carousel);
            $entityManager->flush();
            return $this->redirectToRoute('home');
        }
        return $this->render('home/editCarousel.html.twig', [
            'carouselForm' => $carouselForm->createView(),
            'carousel' => $carousel
        ]);
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
     * @Route("{idCarousel}/default-carousel", name="default_carousel", methods={"DELETE"})
     * @ParamConverter("home", class="App\Entity\Home", options={"mapping": {"idCarousel": "id"}})
     * @IsGranted("ROLE_ADMIN")
     */
    public function defaultCarousel(
        Request $request,
        EntityManagerInterface $entityManager,
        FileManager $fileManager,
        Home $home
    ): Response {
        if ($this->isCsrfTokenValid('delete' . $home->getId(), $request->request->get('_token'))) {
            if ($home->getPictureOne() !== null) {
                $fileManager->deleteFile($home->getPictureOne(), $this->getParameter('carousel_directory'));
            }
            if ($home->getPictureTwo() !== null) {
                $fileManager->deleteFile($home->getPictureTwo(), $this->getParameter('carousel_directory'));
            }
            if ($home->getPictureThree() !== null) {
                $fileManager->deleteFile($home->getPictureThree(), $this->getParameter('carousel_directory'));
            }
            $entityManager->remove($home);
            $entityManager->flush();
        }
        return $this->redirectToRoute('home');
    }
}
