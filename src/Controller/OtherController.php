<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use App\Form\ApplyType;
use App\FormData\ApplyData;
use App\Services\FileManager;

class OtherController extends AbstractController
{
    /**
     * @Route("/nous-rejoindre", name="work_with_us")
     */
    public function workWithUs(Request $request, MailerInterface $mailer, FileManager $fileManager): Response
    {
        $apply = new ApplyData();
        $form = $this->createForm(ApplyType::class, $apply);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $cvName = $apply->getLastName() . '-' . $apply->getFirstName() . '-cv';
            $coverLetterName = $apply->getLastName() . '-' . $apply->getFirstName() . '-lettre_motiv';

            if ($apply->getCvFile() !== null && $apply->getCoverLetterFile() !== null) {
                $cvResults = $fileManager->saveFile(
                    $cvName,
                    $apply->getCvFile(),
                    $this->getParameter('temp_directory')
                );

                $coverLetterResults = $fileManager->saveFile(
                    $coverLetterName,
                    $apply->getCoverLetterFile(),
                    $this->getParameter('temp_directory')
                );

                $email = (new TemplatedEmail())
                ->from($apply->getEmail())
                ->to('wewelcome.test@gmail.com')
                ->subject('Nouvelle candidature : ' . $apply->getFirstName() . ' ' . $apply->getLastName())
                ->htmlTemplate('emails/apply.html.twig')
                ->context(['message' => $apply])
                ->attachFromPath($this->getParameter('temp_directory') . $cvResults['fileName'])
                ->attachFromPath($this->getParameter('temp_directory') . $coverLetterResults['fileName']);

                $mailer->send($email);

                $fileManager->deleteFile($cvResults['fileName'], $this->getParameter('temp_directory'));
                $fileManager->deleteFile($coverLetterResults['fileName'], $this->getParameter('temp_directory'));
            }

            return $this->redirectToRoute('work_with_us');
        }

        return $this->render('other/apply.html.twig', ['form' => $form->createView()]);
    }
}
