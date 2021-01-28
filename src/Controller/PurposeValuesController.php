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
use App\Form\PurposeValuesType;
use App\Services\FileManager;

class PurposeValuesController extends AbstractController
{
    /**
     * This method allows you to create new content for the purpose part or values part.
     * @Route("/new-purpose-values/{type}", name="new_purpose-values", methods={"GET","POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function newPurposeValues(
        Request $request,
        EntityManagerInterface $entityManager,
        FileManager $fileManager,
        string $type
    ): Response {
        $home = new Home();
        $form = $this->createForm(PurposeValuesType::class, $home);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $pictureOne = $form->get('pictureOne')->getData();
            $addPictureOne = $fileManager->saveFile(
                'pictureOne',
                $pictureOne,
                $this->getParameter('purpose-values_directory')
            );
            $home->setPictureOne($addPictureOne['fileName']);

            switch ($type) {
                case "purpose":
                    $home->setType('purpose');
                    break;
                case "values":
                    $home->setType('values');
                    break;
            }
            $entityManager->persist($home);
            $entityManager->flush();
            if ($type === "purpose") {
                return $this->redirect($this->generateUrl('home') . '#section-purpose');
            } else {
                return $this->redirect($this->generateUrl('home') . '#section-values');
            }
        }
        return $this->render('home/editPurposeValues.html.twig', [
            'form' => $form->createView(),
            'home' => $home,
            'type' => $type
        ]);
    }

    /**
     * This method allows you to modify an edited the purpose part or values part.
     * @Route("{idPurposeValues}/edit-purpose-values/{type}", name="edit_purpose-values", methods={"GET", "POST"})
     * @ParamConverter("home", class="App\Entity\Home", options={"mapping": {"idPurposeValues": "id"}})
     * @IsGranted("ROLE_ADMIN")
     */
    public function editPurposeValues(
        Request $request,
        EntityManagerInterface $entityManager,
        FileManager $fileManager,
        Home $home,
        string $type
    ): Response {
        $form = $this->createForm(PurposeValuesType::class, $home);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $pictureOne = $form->get('pictureOne')->getData();
            if (
                $pictureOne !== null &&
                $home->getPictureOne() !== null
            ) {
                $fileManager->deleteFile($home->getPictureOne(), $this->getParameter('purpose-values_directory'));
                $addPictureOne = $fileManager->saveFile(
                    'pictureOne',
                    $pictureOne,
                    $this->getParameter('purpose-values_directory')
                );
                $home->setPictureOne($addPictureOne['fileName']);
            }
            $entityManager->flush();
            if ($home->getType() === "purpose") {
                return $this->redirect($this->generateUrl('home') . '#section-purpose');
            } else {
                return $this->redirect($this->generateUrl('home') . '#section-values');
            }
        }
        return $this->render('home/editPurposeValues.html.twig', [
            'form' => $form->createView(),
            'home' => $home,
            'type' => $type
        ]);
    }

    /**
     * This method deletes the current object and therefore the default content is displayed in the view.
     * @Route("{idPurposeValues}/default-purpose-values/{type}", name="default_purpose-values", methods={"DELETE"})
     * @ParamConverter("home", class="App\Entity\Home", options={"mapping": {"idPurposeValues": "id"}})
     * @IsGranted("ROLE_ADMIN")
     */
    public function defaultPurposeValues(
        Request $request,
        EntityManagerInterface $entityManager,
        FileManager $fileManager,
        Home $home,
        string $type
    ): Response {
        if ($this->isCsrfTokenValid('delete' . $home->getId(), $request->request->get('_token'))) {
            if ($home->getPictureOne() !== null) {
                $fileManager->deleteFile($home->getPictureOne(), $this->getParameter('purpose-values_directory'));
            }
            $entityManager->remove($home);
            $entityManager->flush();
        }
        if ($type === "purpose") {
            return $this->redirect($this->generateUrl('home') . '#section-purpose');
        } else {
            return $this->redirect($this->generateUrl('home') . '#section-values');
        }
    }
}
