<?php

namespace App\Controller;

use App\Entity\AccessibilityConsultingRequest;
use App\Form\AccessibilityConsultingRequestType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Routing\Attribute\Route;

final class AccessibilityConsultingRequestController extends AbstractController
{
    #[Route('/services/accessibilite/demande', name: 'app_accessibility_consulting_request')]
    public function index(Request $request, EntityManagerInterface $entityManager, MailerInterface $mailer): Response
    {
        $accessibilityConsultingRequest = new AccessibilityConsultingRequest();
        $form = $this->createForm(AccessibilityConsultingRequestType::class, $accessibilityConsultingRequest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($accessibilityConsultingRequest);
            $entityManager->flush();

            $ownerEmail = new Address('mthuet.pro@gmail.com', 'Matthieu THUET');
            $senderEmail = new Address(
                $accessibilityConsultingRequest->getEmailAddress(),
                trim($accessibilityConsultingRequest->getFirstName() . ' ' . $accessibilityConsultingRequest->getName())
            );

            $mailer->send(
                (new TemplatedEmail())
                    ->from($ownerEmail)
                    ->to($ownerEmail)
                    ->replyTo($senderEmail)
                    ->subject('Nouvelle demande - Consulting accessibilité')
                    ->htmlTemplate('emails/accessibility_consulting_request/admin.html.twig')
                    ->context([
                        'request' => $accessibilityConsultingRequest,
                    ])
            );

            $mailer->send(
                (new TemplatedEmail())
                    ->from($ownerEmail)
                    ->to(new Address($accessibilityConsultingRequest->getEmailAddress()))
                    ->subject('Votre demande a bien été transmise')
                    ->htmlTemplate('emails/accessibility_consulting_request/user.html.twig')
                    ->context([
                        'request' => $accessibilityConsultingRequest,
                    ])
            );

            $this->addFlash('success', 'Votre demande a bien été envoyée.');

            return $this->redirectToRoute('app_accessibility_consulting_request');
        }

        return $this->render('accessibility_consulting_request/index.html.twig', [
            'accessibilityConsultingRequestForm' => $form->createView(),
        ]);
    }
}
