<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Repository\KeysVisionRepository;
use App\Entity\KeysVision;
use App\Form\KeysType;
use App\Form\VisionType;
use App\Services\HomeManager;
use App\Services\FileManager;

class KeysVisionController extends AbstractController
{
    /**
     * This method allows you to modify an edited carousel.
     * @Route("{idKeysVision}/edit-keys-vision", name="edit_keys-vision", methods={"GET", "POST"})
     * @ParamConverter("keysVision", class="App\Entity\KeysVision", options={"mapping": {"idKeysVision": "id"}})
     * @IsGranted("ROLE_ADMIN")
     */
    public function editKeysVision(
        Request $request,
        EntityManagerInterface $entityManager,
        FileManager $fileManager,
        KeysVision $keysVision
    ): Response {

        if ($keysVision->getType() === "keys") {
            $keysVisionForm = $this->createForm(KeysType::class, $keysVision);
        } else {
            $keysVisionForm = $this->createForm(VisionType::class, $keysVision);
        }

        $keysVisionForm->handleRequest($request);
        if ($keysVisionForm->isSubmitted() && $keysVisionForm->isValid()) {
            $photo = $keysVisionForm->get('photo')->getData();
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

            if ($keysVision->getType() === "keys") {
                return $this->redirect($this->generateUrl('home') . '#section-keys');
            }
            if ($keysVision->getType() === "vision") {
                return $this->redirect($this->generateUrl('home') . '#section-vision');
            }
        }

        return $this->render('home/editKeysVision.html.twig', [
            'keysVisionForm' => $keysVisionForm->createView(),
            'keysVision' => $keysVision
        ]);
    }
}
