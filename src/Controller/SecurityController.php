<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\UserRepository;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('home');
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout(): void
    {
        /*'This method can be blank - it will be intercepted by the logout key on your firewall.'*/
    }

    /**
     * @Route("/init", name="app_init")
     */
    public function register(
        Request $request,
        UserPasswordEncoderInterface $passwordEncoder,
        EntityManagerInterface $entityManager,
        UserRepository $userRepository
    ): Response {
        $users = $userRepository->findAll();

        if (empty($users)) {
            $user = new User();
            $form = $this->createForm(RegistrationFormType::class, $user);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                // encode the plain password
                $user->setPassword(
                    $passwordEncoder->encodePassword(
                        $user,
                        $form->get('plainPassword')->getData()
                    )
                );

                $user->setRoles(['ROLE_ADMIN']);

                $entityManager->persist($user);
                $entityManager->flush();

                return $this->redirectToRoute('app_login');
            }

            return $this->render('security/register.html.twig', [
                'registrationForm' => $form->createView(),
            ]);
        } else {
            return $this->redirectToRoute('app_login');
        }
    }
}
