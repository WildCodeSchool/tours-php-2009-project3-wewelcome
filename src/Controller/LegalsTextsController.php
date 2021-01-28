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
use App\Repository\LegalsTextsRepository;
use App\Entity\LegalsTexts;
use App\Form\LegalsTextsType;
use App\Services\FileManager;
use Twig\Extra\Markdown\MarkdownExtension;

class LegalsTextsController extends AbstractController
{
    /**
     * @Route("/cgu", name="cgu")
     */
    public function indexCgu(
        LegalsTextsRepository $legalsTextsRepo
    ): Response {
        $legalsTexts = $legalsTextsRepo->findBy(['type' => 'cgu']);
        return $this->render('legalsTexts/cgu.html.twig', [
            'legalsTexts' => $legalsTexts,
        ]);
    }

    /**
     * @Route("/legal-notice", name="legal-notice")
     */
    public function indexLegalNotice(
        LegalsTextsRepository $legalsTextsRepo
    ): Response {
        $legalsTexts = $legalsTextsRepo->findBy(['type' => 'legal-notice']);
        return $this->render('legalsTexts/legalNotice.html.twig', [
            'legalsTexts' => $legalsTexts,
        ]);
    }

    /**
     * This method allows you to create new content for the CGU part or legal notice part.
     * @Route("/new-legals-texts/{type}", name="new_legals-texts", methods={"GET","POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function newLegalsTexts(
        Request $request,
        EntityManagerInterface $entityManager,
        FileManager $fileManager,
        string $type
    ): Response {
        $legalsTexts = new LegalsTexts();
        $form = $this->createForm(LegalsTextsType::class, $legalsTexts);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            switch ($type) {
                case "cgu":
                    $legalsTexts->setType('cgu');
                    break;
                case "legal-notice":
                    $legalsTexts->setType('legal-notice');
                    break;
            }
            $entityManager->persist($legalsTexts);
            $entityManager->flush();
            if ($type === "cgu") {
                return $this->redirectToRoute('cgu');
            } else {
                return $this->redirectToRoute('legal-notice');
            }
        }
        return $this->render('legalsTexts/editLegalsTexts.html.twig', [
            'form' => $form->createView(),
            'legalsTexts' => $legalsTexts,
            'type' => $type
        ]);
    }

    /**
     * This method allows you to modify an edited the CGU part or legal notice part.
     * @Route("{idLegalsTexts}/edit-legals-texts/{type}", name="edit_legals-texts", methods={"GET", "POST"})
     * @ParamConverter("legalsTexts", class="App\Entity\LegalsTexts", options={"mapping": {"idLegalsTexts": "id"}})
     * @IsGranted("ROLE_ADMIN")
     */
    public function editLegalsTexts(
        Request $request,
        EntityManagerInterface $entityManager,
        FileManager $fileManager,
        LegalsTexts $legalsTexts,
        string $type
    ): Response {
        $form = $this->createForm(LegalsTextsType::class, $legalsTexts);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            if ($type === "cgu") {
                return $this->redirectToRoute('cgu');
            } else {
                return $this->redirectToRoute('legal-notice');
            }
        }
        return $this->render('legalsTexts/editLegalsTexts.html.twig', [
            'form' => $form->createView(),
            'legalsTexts' => $legalsTexts,
            'type' => $type
        ]);
    }

    /**
     * This method deletes the current object and therefore the default content is displayed in the view.
     * @Route("{idLegalsTexts}/delete-legals-texts/{type}", name="delete_legals-texts", methods={"DELETE"})
     * @ParamConverter("legalsTexts", class="App\Entity\LegalsTexts", options={"mapping": {"idLegalsTexts": "id"}})
     * @IsGranted("ROLE_ADMIN")
     */
    public function deleteLegalsTexts(
        Request $request,
        EntityManagerInterface $entityManager,
        FileManager $fileManager,
        LegalsTexts $legalsTexts,
        string $type
    ): Response {
        if ($this->isCsrfTokenValid('delete' . $legalsTexts->getId(), $request->request->get('_token'))) {
            $entityManager->remove($legalsTexts);
            $entityManager->flush();
        }
        if ($type === "cgu") {
            return $this->redirectToRoute('cgu');
        } else {
            return $this->redirectToRoute('legal-notice');
        }
    }
}
