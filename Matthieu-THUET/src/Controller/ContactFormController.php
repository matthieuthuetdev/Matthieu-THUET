<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use Doctrine\ORM\EntityManagerInterface;
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
    public function index(Request $request, EntityManagerInterface $entityManager, MailerInterface $mailer): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($contact);
            $entityManager->flush();

            $ownerEmail = new Address('mthuet.pro@gmail.com', 'Matthieu THUET');
            $senderEmail = new Address($contact->getEmailAddress(), trim($contact->getfirstName() . ' ' . $contact->getName()));

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
                    ->to(new Address($contact->getEmailAddress()))
                    ->subject('Votre message a bien été transmis')
                    ->htmlTemplate('emails/contact/user.html.twig')
                    ->context([
                        'contact' => $contact,
                    ])
            );

            $this->addFlash('success', 'Votre message a bien été envoyé.');
            return $this->redirectToRoute('app_contact_form');
        }

        return $this->render('contact_form/index.html.twig', [
            'contactForm' => $form->createView(),
        ]);
    }
}
