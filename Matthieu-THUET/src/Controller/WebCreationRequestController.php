<?php

namespace App\Controller;

use App\Entity\WebCreationRequest;
use App\Form\WebCreationRequestType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Routing\Attribute\Route;

final class WebCreationRequestController extends AbstractController
{
    #[Route('/services/creation-site/demande', name: 'app_web_creation_request')]
    public function index(Request $request, EntityManagerInterface $entityManager, MailerInterface $mailer): Response
    {
        $webCreationRequest = new WebCreationRequest();
        $form = $this->createForm(WebCreationRequestType::class, $webCreationRequest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($webCreationRequest);
            $entityManager->flush();

            $ownerEmail = new Address('mthuet.pro@gmail.com', 'Matthieu THUET');
            $senderEmail = new Address(
                $webCreationRequest->getEmailAddress(),
                trim($webCreationRequest->getFirstName() . ' ' . $webCreationRequest->getName())
            );

            $mailer->send(
                (new TemplatedEmail())
                    ->from($ownerEmail)
                    ->to($ownerEmail)
                    ->replyTo($senderEmail)
                    ->subject('Nouvelle demande - Création de site web')
                    ->htmlTemplate('emails/web_creation_request/admin.html.twig')
                    ->context([
                        'request' => $webCreationRequest,
                    ])
            );

            $mailer->send(
                (new TemplatedEmail())
                    ->from($ownerEmail)
                    ->to(new Address($webCreationRequest->getEmailAddress()))
                    ->subject('Votre demande a bien été transmise')
                    ->htmlTemplate('emails/web_creation_request/user.html.twig')
                    ->context([
                        'request' => $webCreationRequest,
                    ])
            );

            $this->addFlash('success', 'Votre demande a bien été envoyée.');

            return $this->redirectToRoute('app_web_creation_request');
        }

        return $this->render('web_creation_request/index.html.twig', [
            'webCreationRequestForm' => $form->createView(),
        ]);
    }
}
