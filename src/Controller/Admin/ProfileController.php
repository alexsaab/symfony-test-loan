<?php

namespace App\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class ProfileController extends AbstractDashboardController
{

    #[Route(path: '/admin/profile', name: 'admin_profile')]
    public function index(): Response
    {
        // Редирект на страницу профиля FOS User Bundle
        return $this->redirectToRoute('fos_user_profile_show');
    }
    #[Route(path: '/admin/logout', name: 'admin_logout')]
    public function logout(): Response
    {
        // Редирект на страницу выхода FOS User Bundle
        return $this->redirectToRoute('fos_user_security_logout');
    }


    #[Route(path: '/admin/login', name: 'admin_login')]
    #[Route(path: '/login', name: 'login')]
    public function login(AuthenticationUtils $authenticationUtils): mixed
    {
        if ($this->getUser())
        {
            return $this->redirectToRoute('fos_user_profile_show');
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('admin/security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
//        return $this->redirectToRoute('fos_user_security_login');
    }
}
