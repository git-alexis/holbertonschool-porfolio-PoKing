<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ResetPasswordFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class ResetPasswordController extends AbstractController
{
    #[Route('/request-reset', name: 'app_forgot_password')]
    public function requestReset(Request $request, EntityManagerInterface $entityManager, MailerInterface $mailer): Response
    {
        if ($request->isMethod('POST')) {
            $pseudo = $request->request->get('pseudo');
            // retrieves the account associated to the user pseudo
            $user = $entityManager->getRepository(User::class)->findOneBy(['pseudo' => $pseudo]);

            // if the account exists, the user receives a reset email
            if ($user) {
                // creates a token
                $resetToken = bin2hex(random_bytes(32));
                $user->setResetToken($resetToken);

                $entityManager->persist($user);
                $entityManager->flush();

                // creates the reset url
                $resetUrl = $this->generateUrl('app_reset_password', ['token' => $resetToken], UrlGeneratorInterface::ABSOLUTE_URL);

                $email = (new Email())
                    ->from('no-reply@poking.com')
                    ->to($user->getMail())
                    ->subject('Reset your password')
                    ->html("<p>Click on this link to reset your password : <a href='$resetUrl'>Reset my password</a></p>");

                $mailer->send($email);

                $this->addFlash('success', 'A reset email has been sent to the email address associated with your account');
            } else {
                // if the account doesn't exist, error message
                $this->addFlash('error', 'Pseudo not found');
            }
        }

        return $this->render('reset_password/request_reset.html.twig');
    }

    #[Route('/reset-password/{token}', name: 'app_reset_password')]
    public function resetPassword(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher, string $token): Response
    {
        // retrieves the token associated to a user
        $user = $entityManager->getRepository(User::class)->findOneBy(['resetToken' => $token]);

        // if the token doesn't exist, error message
        if (!$user) {
            $this->addFlash('error', 'Invalid reset link.');
            return $this->redirectToRoute('app_forgot_password');
        }

        $form = $this->createForm(ResetPasswordFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $newPassword = $form->get('plainPassword')->getData();
            $confirmPassword = $form->get('confirmPassword')->getData();

            // if the two passwords are filled in, we check that they are identical
            if ($newPassword !== '' and $confirmPassword !== '') {
                // if this is not the case, error message
                if ($newPassword !== $confirmPassword) {
                    $this->addFlash('error', 'The two passwords don\'t match.');
                } else {
                    // hashes the new password, cancels the token and updates the account in database
                    $hashedPassword = $passwordHasher->hashPassword($user, $newPassword);

                    $user->setPassword($hashedPassword);
                    $user->setResetToken(null);

                    $entityManager->persist($user);
                    $entityManager->flush();

                    return $this->redirectToRoute('app_login');
                }
            }
        }

        return $this->render('reset_password/reset_password.html.twig', [
            'resetPasswordForm' => $form->createView(),
        ]);
    }
}
