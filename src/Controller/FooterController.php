<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Footer;
use App\Repository\FooterRepository;
use App\Form\FooterType;
use App\Services\FileManager;
use Doctrine\ORM\EntityManagerInterface;

class FooterController extends AbstractController
{
    public function getSocialNetworks(
        RequestStack $requestStack,
        EntityManagerInterface $entityManager,
        FileManager $fileManager,
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

        return $this->render('_socialNetworks.html.twig', [
            'socialNetworks' => $socialNetworks,
            'socialNetworkForm' => $socialNetworkForm->createView(),
        ]);
    }
}
