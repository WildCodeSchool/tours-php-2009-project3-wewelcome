<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Footer;
use App\Repository\FooterRepository;
use App\Form\FooterType;
use App\Services\FileManager;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class FooterController extends AbstractController
{
    public function getSocialNetworks(
        RequestStack $requestStack,
        EntityManagerInterface $entityManager,
        FooterRepository $footerRepository
    ): Response {
        /** Display the add social network form and add it in the DB */
        $request = $requestStack->getMasterRequest();
        $socialNetwork = new Footer();
        $socialNetworkForm = $this->createForm(FooterType::class, $socialNetwork);
        $socialNetworkForm->handleRequest($request);

        if ($socialNetworkForm->isSubmitted() && $socialNetworkForm->isValid()) {
            switch ($socialNetwork->getTitle()) {
                case 'Facebook':
                    $socialNetwork->setLogo('facebookDefault.png');
                    break;
                case 'Instagram':
                    $socialNetwork->setLogo('instaDefault.png');
                    break;
                case 'LinkedIn':
                    $socialNetwork->setLogo('linkedinDefault.png');
                    break;
            }

            $socialNetwork->setIsSocialNetwork(true);
            $entityManager->persist($socialNetwork);
            $entityManager->flush();
        }

        $socialNetworks = $footerRepository->findBy(['isSocialNetwork' => true]);

        return $this->render('footer/_socialNetworks.html.twig', [
            'socialNetworks' => $socialNetworks,
            'socialNetworkForm' => $socialNetworkForm->createView(),
        ]);
    }

    public function getContactInfo(
        FooterRepository $footerRepository
    ): Response {
        $contactInfo = $footerRepository->findOneBy(['isSocialNetwork' => false]);

        return $this->render('footer/_contactInfo.html.twig', ['contactInfo' => $contactInfo]);
    }

    /**
     * @Route("/footer/{id}", name="footer_delete", methods={"DELETE"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function deleteFooter(
        RequestStack $requestStack,
        EntityManagerInterface $entityManager,
        Footer $footer,
        FooterRepository $footerRepository
    ): Response {
        $request = $requestStack->getMasterRequest();

        if ($request != null) {
            if ($this->isCsrfTokenValid('delete' . $footer->getId(), $request->request->get('_token'))) {
                $entityManager->remove($footer);
                $entityManager->flush();
            }
        }

        return $this->redirectToRoute('home');
    }

    /**
     * @Route("/footer/{id}/edit", name="footer_edit", methods={"GET","POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function editFooter(
        RequestStack $requestStack,
        Footer $footer,
        EntityManagerInterface $entityManager
    ): Response {
        $request = $requestStack->getMasterRequest();

        if ($request != null) {
            $footerForm = $this->createForm(FooterType::class, $footer);
            $footerForm->handleRequest($request);

            if ($footerForm->isSubmitted() && $footerForm->isValid()) {
                $entityManager->flush();

                return $this->redirectToRoute('home');
            }

            return $this->render('footer/editFooter.html.twig', [
                'footer' => $footer,
                'footerForm' => $footerForm->createView(),
            ]);
        }
        return $this->redirectToRoute('home');
    }

    /**
     * @Route("/footer/add", name="footer_add", methods={"GET","POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function addFooter(
        RequestStack $requestStack,
        EntityManagerInterface $entityManager
    ): Response {
        $request = $requestStack->getMasterRequest();

        if ($request != null) {
            $footer = new Footer();
            $footerForm = $this->createForm(FooterType::class, $footer);
            $footerForm->handleRequest($request);

            if ($footerForm->isSubmitted() && $footerForm->isValid()) {
                $footer->setIsSocialNetwork(false);
                $entityManager->persist($footer);
                $entityManager->flush();

                return $this->redirectToRoute('home');
            }

            return $this->render('footer/editFooter.html.twig', [
                'footerForm' => $footerForm->createView(),
            ]);
        }
        return $this->redirectToRoute('home');
    }
}
