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
use App\Repository\KeysVisionRepository;
use App\Entity\KeysVision;
use App\Form\VisionType;
use App\Services\FileManager;
use Symfony\Component\Config\Definition\Exception\Exception;

class VisionController extends AbstractController
{
    /**
     * This method allows you to create new content for the vision part.
     * @Route("/new-vision/{type}", name="new_vision", methods={"GET","POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function newVision(
        Request $request,
        EntityManagerInterface $entityManager,
        FileManager $fileManager,
        string $type
    ): Response {
        $keysVision = new KeysVision();
        $keysVision->setType($type);
        $keysVision->setText5("null");//because there is no text5
        $keysVision->setText6("null");//because there is no text6
        $keysVision->setText7("null");//because there is no text7
        $keysVision->setText8("null");//because there is no text8
        $form = $this->createForm(VisionType::class, $keysVision);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $photo = $form->get('photo')->getData();
            try {
                if (!isset($photo)) {
                    throw new Exception('⚠️ ATTENTION: vous devez ajouter 1 photo pour valider le formulaire');
                }
                $addPhoto = $fileManager->saveFile(
                    'file',
                    $photo,
                    $this->getParameter('keys-vision_directory')
                );
                $keysVision->setPhoto($addPhoto['fileName']);
            } catch (Exception $e) {
                $this->addFlash('error', $e->getMessage());
                return $this->redirect($request->server->get('HTTP_REFERER'));
            }
            $entityManager->persist($keysVision);
            $entityManager->flush();
            return $this->redirect($this->generateUrl('home') . '#section-vision');
        }
        return $this->render('home/editVision.html.twig', [
            'form' => $form->createView(),
            'keysVision' => $keysVision
        ]);
    }

    /**
     * This method allows you to modify an edited the vision part.
     * @Route("{idVision}/edit-vision/{type}", name="edit_vision", methods={"GET", "POST"})
     * @ParamConverter("keysVision", class="App\Entity\KeysVision", options={"mapping": {"idVision": "id"}})
     * @IsGranted("ROLE_ADMIN")
     */
    public function editVision(
        Request $request,
        EntityManagerInterface $entityManager,
        FileManager $fileManager,
        KeysVision $keysVision,
        string $type
    ): Response {
        $form = $this->createForm(VisionType::class, $keysVision);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $photo = $form->get('photo')->getData();
            if (
                $photo !== null &&
                $keysVision->getPhoto() !== null
            ) {
                $fileManager->deleteFile($keysVision->getPhoto(), $this->getParameter('keys-vision_directory'));
                $addPhoto = $fileManager->saveFile(
                    'photo',
                    $photo,
                    $this->getParameter('keys-vision_directory')
                );
                $keysVision->setPhoto($addPhoto['fileName']);
            }
            $entityManager->flush();
            return $this->redirect($this->generateUrl('home') . '#section-vision');
        }
        return $this->render('home/editVision.html.twig', [
            'form' => $form->createView(),
            'keysVision' => $keysVision
        ]);
    }

    /**
     * This method deletes the current object and therefore the default content is displayed in the view.
     * @Route("{idVision}/default-vision/{type}", name="default_vision", methods={"DELETE"})
     * @ParamConverter("keysVision", class="App\Entity\KeysVision", options={"mapping": {"idVision": "id"}})
     * @IsGranted("ROLE_ADMIN")
     */
    public function defaultVision(
        Request $request,
        EntityManagerInterface $entityManager,
        FileManager $fileManager,
        KeysVision $keysVision,
        string $type
    ): Response {
        if ($this->isCsrfTokenValid('delete' . $keysVision->getId(), $request->request->get('_token'))) {
            if ($keysVision->getPhoto() !== null) {
                $fileManager->deleteFile($keysVision->getPhoto(), $this->getParameter('keys-vision_directory'));
            }
            $entityManager->remove($keysVision);
            $entityManager->flush();
        }
        return $this->redirect($this->generateUrl('home') . '#section-vision');
    }
}
