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
use Symfony\Component\Config\Definition\Exception\Exception;

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
        $home->setType($type);
        $home->setTitle("null");//because there is no title
        $home->setPictureTwo("null");//because there is no picture2
        $home->setPictureThree("null");//because there is no picture3
        $home->setLegendPictureTwo("null");//because there is no picture2
        $home->setLegendPictureThree("null");//because there is no picture3
        $form = $this->createForm(PurposeValuesType::class, $home);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $pictureOne = $form->get('pictureOne')->getData();
            try {
                if (!isset($pictureOne)) {
                    throw new Exception('⚠️ ATTENTION: vous devez ajouter 1 photo pour valider le formulaire');
                }
                $addPictureOne = $fileManager->saveFile(
                    'fileOne',
                    $pictureOne,
                    $this->getParameter('purpose-values_directory')
                );
                $home->setPictureOne($addPictureOne['fileName']);
            } catch (Exception $e) {
                $this->addFlash('error', $e->getMessage());
                return $this->redirect($request->server->get('HTTP_REFERER'));
            }
            $entityManager->persist($home);
            $entityManager->flush();
            return $this->redirect($this->generateUrl('home') . '#section-' . $type);
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
                    'fileOne',
                    $pictureOne,
                    $this->getParameter('purpose-values_directory')
                );
                $home->setPictureOne($addPictureOne['fileName']);
            }
            $entityManager->flush();
            return $this->redirect($this->generateUrl('home') . '#section-' . $type);
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
        return $this->redirect($this->generateUrl('home') . '#section-' . $type);
    }
}
