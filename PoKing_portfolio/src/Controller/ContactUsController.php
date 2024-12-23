<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mime\Email;


class ContactUsController extends AbstractController
{
    #[Route('/contact-us', name: 'app_contact_us')]
    public function index(Request $request, MailerInterface $mailer): Response
    {
        // Checks whether the request is a form submission
        if ($request->isMethod('POST')) {
            // Regular expression to validate email addresses
            $regex = '/^[a-zA-Z0-9._\-]+@[a-zA-Z0-9.\-]+\.[a-zA-Z]{2,}$/';

            // Validates the email format
            if (preg_match($regex, $request->request->get('email'))) {
                $email = (new Email())
                    ->from($request->request->get('email'))
                    ->to('alex59.billemont@gmail.com')
                    ->replyTo($request->request->get('email'))
                    ->subject($request->request->get('subject'))
                    ->text($request->request->get('message'));

                $mailer->send($email);

                // Success message
                $this->addFlash('success', 'Request sent successfully');
            } else {
                // Error message for invalid email
                $this->addFlash('error', 'Invalid email, valid format: test@example.com');
            }
        }

        return $this->render('contact_us/contact_us.html.twig');
    }
}
