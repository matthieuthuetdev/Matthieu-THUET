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

final class HomePageController extends AbstractController
{
    #[Route('/', name: 'app_home_page')]
    public function index(Request $request, EntityManagerInterface $entityManager, MailerInterface $mailer): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($contact);
            $entityManager->flush();

            $ownerEmail = new Address('mthuet.pro@gmail.com', 'Matthieu THUET');
            $senderEmail = new Address($contact->getEmailAddress(), trim($contact->getFirstName() . ' ' . $contact->getName()));

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
                    ->subject('Votre message a bien ete transmis')
                    ->htmlTemplate('emails/contact/user.html.twig')
                    ->context([
                        'contact' => $contact,
                    ])
            );

            $this->addFlash('success', 'Votre message a bien ete envoye.');

            return $this->redirect($this->generateUrl('app_home_page') . '#contact');
        }

        return $this->render('home_page/index.html.twig', [
            'contactForm' => $form->createView(),
        ]);
    }
}
