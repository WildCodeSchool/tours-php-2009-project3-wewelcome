<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Service;
use App\Form\ServiceType;
use App\Repository\ServiceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Services\FileManager;

class ServiceController extends AbstractController
{
    /**
     * @Route("/service/{id}", name="service_delete", methods={"DELETE"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function deleteService(
        Request $request,
        Service $service,
        EntityManagerInterface $entityManager,
        FileManager $fileManager
    ): Response {
        if ($this->isCsrfTokenValid('delete' . $service->getId(), $request->request->get('_token'))) {
            $fileManager->deleteFile($service->getLogo(), $this->getParameter('services_directory'));
            $fileManager->deleteFile($service->getPhoto(), $this->getParameter('services_directory'));

            $entityManager->remove($service);
            $entityManager->flush();
        }

        return $this->redirectToRoute('concierge');
    }

    /**
     * @Route("/service/{id}/edit", name="service_edit", methods={"GET","POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function editService(
        Request $request,
        Service $service,
        FileManager $fileManager,
        EntityManagerInterface $entityManager
    ): Response {
        $form = $this->createForm(ServiceType::class, $service);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $logoFile = $form->get('logoFile')->getData();
            $photoFile = $form->get('photoFile')->getData();

            if ($logoFile != null) {
                $fileManager->deleteFile($service->getLogo(), $this->getParameter('services_directory'));

                $resultsLogo = $fileManager->saveFile(
                    $service->getTitle() . '-logo',
                    $logoFile,
                    $this->getParameter('services_directory')
                );

                $service->setLogo($resultsLogo['fileName']);
            }

            if ($photoFile != null) {
                $fileManager->deleteFile($service->getPhoto(), $this->getParameter('services_directory'));

                $resultsPhoto = $fileManager->saveFile(
                    $service->getTitle() . '-photo',
                    $photoFile,
                    $this->getParameter('services_directory')
                );

                $service->setPhoto($resultsPhoto['fileName']);
            }

            $entityManager->flush();

            return $this->redirectToRoute('concierge');
        }

        return $this->render('concierge/editService.html.twig', [
            'service' => $service,
            'serviceForm' => $form->createView(),
        ]);
    }
}
