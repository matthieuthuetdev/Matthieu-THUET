<?php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Routing\Attribute\Route;

final class ContactFormController extends AbstractController
{
    #[Route('/contact/form', name: 'app_contact_form')]
    public function index(Request $request, MailerInterface $mailer): Response
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $formData = $form->getData();
            $contact = [
                'firstName' => $formData['firstName'] ?? '',
                'name' => $formData['name'] ?? '',
                'companyName' => $formData['companyName'] ?? null,
                'emailAddress' => $formData['emailAddress'] ?? '',
                'subject' => $formData['subject'] ?? '',
                'content' => $formData['Content'] ?? '',
                'rgpd' => (bool) ($formData['RGPD'] ?? false),
            ];

            $ownerEmail = new Address('mthuet.pro@gmail.com', 'Matthieu THUET');
            $senderEmail = new Address($contact['emailAddress'], trim($contact['firstName'] . ' ' . $contact['name']));

            $mailer->send(
                (new TemplatedEmail())
                    ->from($ownerEmail)
                    ->to($ownerEmail)
                    ->replyTo($senderEmail)
                    ->subject('Nouveau message de contact')
                    ->htmlTemplate('emails/contact/admin.html.twig')
                    ->context([
                        'contact' => $contact,
                    ])
            );

            $mailer->send(
                (new TemplatedEmail())
                    ->from($ownerEmail)
                    ->to(new Address($contact['emailAddress']))
                    ->subject('Votre message a bien ete transmis')
                    ->htmlTemplate('emails/contact/user.html.twig')
                    ->context([
                        'contact' => $contact,
                    ])
            );

            $this->addFlash('success', 'Votre message a bien ete envoye.');

            return $this->redirectToRoute('app_contact_form');
        }

        return $this->render('contact_form/index.html.twig', [
            'contactForm' => $form->createView(),
        ]);
    }
}
