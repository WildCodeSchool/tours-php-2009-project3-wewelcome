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
use App\Form\KeysType;
use App\Services\FileManager;

class KeysController extends AbstractController
{
    /**
     * This method allows you to create new content for the keys part.
     * @Route("/new-keys/{type}", name="new_keys", methods={"GET","POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function newKeys(
        Request $request,
        EntityManagerInterface $entityManager,
        FileManager $fileManager,
        string $type
    ): Response {
        $keysVision = new KeysVision();
        $form = $this->createForm(KeysType::class, $keysVision);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $photo = $form->get('photo')->getData();
            $addPhoto = $fileManager->saveFile(
                'photo',
                $photo,
                $this->getParameter('keys-vision_directory')
            );
            $keysVision->setPhoto($addPhoto['fileName']);
            $keysVision->setType('keys');
            $entityManager->persist($keysVision);
            $entityManager->flush();
            return $this->redirect($this->generateUrl('home') . '#section-keys');
        }
        return $this->render('home/editKeys.html.twig', [
            'form' => $form->createView(),
            'keysVision' => $keysVision
        ]);
    }

    /**
     * This method allows you to modify an edited the keys part.
     * @Route("{idKeys}/edit-keys/{type}", name="edit_keys", methods={"GET", "POST"})
     * @ParamConverter("keysVision", class="App\Entity\KeysVision", options={"mapping": {"idKeys": "id"}})
     * @IsGranted("ROLE_ADMIN")
     */
    public function editKeys(
        Request $request,
        EntityManagerInterface $entityManager,
        FileManager $fileManager,
        KeysVision $keysVision,
        string $type
    ): Response {
        $form = $this->createForm(KeysType::class, $keysVision);
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
            return $this->redirect($this->generateUrl('home') . '#section-keys');
        }
        return $this->render('home/editKeys.html.twig', [
            'form' => $form->createView(),
            'keysVision' => $keysVision
        ]);
    }

    /**
     * This method deletes the current object and therefore the default content is displayed in the view.
     * @Route("{idKeys}/default-keys/{type}", name="default_keys", methods={"DELETE"})
     * @ParamConverter("keysVision", class="App\Entity\KeysVision", options={"mapping": {"idKeys": "id"}})
     * @IsGranted("ROLE_ADMIN")
     */
    public function defaultKeys(
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
        return $this->redirect($this->generateUrl('home') . '#section-keys');
    }
}
