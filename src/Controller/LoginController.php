<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class LoginController extends AbstractController
{
    #[Route('/login', name: 'load_login_page')]
    public function loadLogin(): Response
    {
        return $this->render('login/login.html.twig');
    }

    #[Route('/register', name: 'load_register_page')]
    public function loadSignup(): Response
    {
        return $this->render('registration/register.html.twig');
    }

    #[Route('/login-user')]
    public function login(): Response
    {
        return $this->render('login/signup.html.twig');
    }
}
