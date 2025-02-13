<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\DBAL\Exception\ConstraintViolationException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RegistrationController extends AbstractController
{
    #[Route('/registration', name: 'app_registration')]
    public function index(): Response
    {
        return $this->render('registration/register.html.twig', [
            'controller_name' => 'RegistrationController',
        ]);
    }

    #[Route('/register', name: 'app_register_form')]
    public function register(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $hashedPassword = $passwordHasher->hashPassword($user, $user->getPassword());
                $user->setPassword($hashedPassword);

                $entityManager->persist($user);
                $entityManager->flush();

                return $this->redirectToRoute('load_login_page');
            } catch (UniqueConstraintViolationException $e) {
                // Check which unique constraint was violated
                if (strpos($e->getMessage(), 'UNIQ_IDENTIFIER_USER_NAME') !== false) {
                    // Username conflict
                    $message = 'This username is already taken. Please choose a different username.';
                } elseif (strpos($e->getMessage(), 'UNIQ_IDENTIFIER_EMAIL') !== false) {
                    // Email conflict (make sure the email column has a unique constraint)
                    $message = 'This email is already registered. Please use a different email address.';
                } else {
                    // General unique constraint violation
                    $message = 'An error occurred due to a duplicate value. Please try again.';
                }
            }
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    #[Route('/login', name: 'load_login_page')]
    public function loadLogin(): Response
    {
        return $this->render('login/login.html.twig');
    }
}
