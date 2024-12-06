<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class ResettingController extends AbstractController
{
    private $entityManager;
    private $mailer;
    private $tokenGenerator;

    public function __construct(
        EntityManagerInterface $entityManager,
        MailerInterface $mailer,
        TokenGeneratorInterface $tokenGenerator
    ) {
        $this->entityManager = $entityManager;
        $this->mailer = $mailer;
        $this->tokenGenerator = $tokenGenerator;
    }

    #[Route(path: '/resetting/request', name: 'fos_user_resetting_request')]
    public function request(): Response
    {
        return $this->render('resetting/request.html.twig');
    }

    #[Route(path: '/resetting/send-email', name: 'fos_user_resetting_send_email', methods: ['POST'])]
    public function sendEmail(Request $request): Response
    {
        $email = $request->request->get('email');

        $user = $this->entityManager->getRepository(User::class)->findOneBy([
            'email' => $email,
            'enabled' => true
        ]);

        if (null === $user) {
            return $this->render('resetting/request.html.twig', [
                'error' => 'User not found or account is disabled.'
            ]);
        }

        if ($user->isPasswordRequestNonExpired(3600)) {
            return $this->render('resetting/request.html.twig', [
                'error' => 'Password reset request already sent. Please check your email or wait an hour before trying again.'
            ]);
        }

        $token = $this->tokenGenerator->generateToken();
        $user->setConfirmationToken($token);
        $user->setPasswordRequestedAt(new \DateTime());

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $resetLink = $this->generateUrl('fos_user_resetting_reset', ['token' => $token], 0);
        $email = (new Email())
            ->from('noreply@example.com')
            ->to($user->getEmail())
            ->subject('Reset Password')
            ->html($this->renderView('resetting/email.html.twig', [
                'user' => $user,
                'resetLink' => $resetLink
            ]));

        $this->mailer->send($email);

        return $this->render('resetting/check_email.html.twig');
    }

    #[Route(path: '/resetting/reset/{token}', name: 'fos_user_resetting_reset')]
    public function reset(
        Request $request,
        string $token,
        UserPasswordEncoderInterface $passwordEncoder
    ): Response {
        $user = $this->entityManager->getRepository(User::class)->findOneBy([
            'confirmationToken' => $token
        ]);

        if (null === $user) {
            return $this->redirectToRoute('fos_user_resetting_request');
        }

        if (!$user->isPasswordRequestNonExpired(3600)) {
            return $this->render('resetting/request.html.twig', [
                'error' => 'Password reset link has expired. Please request a new one.'
            ]);
        }

        if ($request->isMethod('POST')) {
            $password = $request->request->get('password');
            $confirmPassword = $request->request->get('confirm_password');

            if ($password !== $confirmPassword) {
                return $this->render('resetting/reset.html.twig', [
                    'token' => $token,
                    'error' => 'Passwords do not match.'
                ]);
            }

            $user->setPlainPassword($password);
            $user->setConfirmationToken(null);
            $user->setPasswordRequestedAt(null);

            $this->entityManager->persist($user);
            $this->entityManager->flush();

            return $this->redirectToRoute('fos_user_security_login');
        }

        return $this->render('resetting/reset.html.twig', [
            'token' => $token
        ]);
    }
}
