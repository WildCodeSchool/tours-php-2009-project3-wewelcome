<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Repository\HomeRepository;
use App\Entity\Home;
use App\Form\CarouselType;
use App\Services\FileManager;
use Symfony\Component\Config\Definition\Exception\Exception;

class CarouselController extends AbstractController
{
    /**
     * This method allows you to create new content for the carousel part.
     * @Route("/new-carousel", name="new_carousel", methods={"GET","POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function newCarousel(
        Request $request,
        EntityManagerInterface $entityManager,
        FileManager $fileManager
    ): Response {
        $carousel = new Home();
        $carousel->setType('carousel');
        $carousel->setText('null');//because there is no text in a carousel
        $form = $this->createForm(CarouselType::class, $carousel);
        $form->handleRequest($request);
        $errorAddPicture = '';
        if ($form->isSubmitted() && $form->isValid()) {
            if (
                ($form->get('pictureOne')->getData() !== null) &&
                ($form->get('pictureTwo')->getData() !== null) &&
                ($form->get('pictureThree')->getData() !== null)
            ) {
                $addPictureOne = $fileManager->saveFile(
                    'fileOne',
                    $form->get('pictureOne')->getData(),
                    $this->getParameter('carousel_directory')
                );
                $carousel->setPictureOne($addPictureOne['fileName']);
                $addPictureTwo = $fileManager->saveFile(
                    'fileTwo',
                    $form->get('pictureTwo')->getData(),
                    $this->getParameter('carousel_directory')
                );
                $carousel->setPictureTwo($addPictureTwo['fileName']);
                $addPictureThree = $fileManager->saveFile(
                    'fileThree',
                    $form->get('pictureThree')->getData(),
                    $this->getParameter('carousel_directory')
                );
                $carousel->setPictureThree($addPictureThree['fileName']);
                $entityManager->persist($carousel);
                $entityManager->flush();
                return $this->redirectToRoute('home');
            } else {
                $errorAddPicture = '⚠️ ATTENTION: vous devez ajouter une photo pour valider le formulaire';
            }
        }
        return $this->render('home/editCarousel.html.twig', [
            'form' => $form->createView(),
            'carousel' => $carousel,
            'errorAddPicture' => $errorAddPicture
        ]);
    }

    /**
     * This method allows you to modify an edited carousel part.
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
        $form = $this->createForm(CarouselType::class, $home);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $pictureOne = $form->get('pictureOne')->getData();
            $pictureTwo = $form->get('pictureTwo')->getData();
            $pictureThree = $form->get('pictureThree')->getData();
            if (
                $pictureOne !== null &&
                $home->getPictureOne() !== null
            ) {
                $fileManager->deleteFile($home->getPictureOne(), $this->getParameter('carousel_directory'));
                $addPictureOne = $fileManager->saveFile(
                    'fileOne',
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
                    'fileTwo',
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
                    'fileThree',
                    $pictureThree,
                    $this->getParameter('carousel_directory')
                );
                $home->setPictureThree($addPictureThree['fileName']);
            }
            $entityManager->flush();
            return $this->redirectToRoute('home');
        }
        return $this->render('home/editCarousel.html.twig', [
            'form' => $form->createView(),
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
