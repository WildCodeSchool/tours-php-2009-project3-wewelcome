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
use App\Form\PurposeValuesType;
use App\Services\HomeManager;
use App\Services\FileManager;

class PurposeValuesController extends AbstractController
{
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
