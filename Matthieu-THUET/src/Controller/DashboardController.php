<?php

namespace App\Controller;

use App\Entity\AccessibilityConsultingRequest;
use App\Entity\Contact;
use App\Entity\WebCreationRequest;
use App\Repository\AccessibilityConsultingRequestRepository;
use App\Repository\ContactRepository;
use App\Repository\WebCreationRequestRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class DashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'app_dashboard')]
    public function index(): Response
    {
        return $this->render('dashboard/index.html.twig');
    }

    #[Route('/dashboard/creation-site', name: 'app_dashboard_web_creation_requests')]
    public function webCreationRequests(WebCreationRequestRepository $repository): Response
    {
        return $this->render('dashboard/web_creation_requests.html.twig', [
            'items' => $repository->findBy([], ['id' => 'DESC']),
        ]);
    }

    #[Route('/dashboard/accessibilite', name: 'app_dashboard_accessibility_consulting_requests')]
    public function accessibilityConsultingRequests(AccessibilityConsultingRequestRepository $repository): Response
    {
        return $this->render('dashboard/accessibility_consulting_requests.html.twig', [
            'items' => $repository->findBy([], ['id' => 'DESC']),
        ]);
    }

    #[Route('/dashboard/contacts', name: 'app_dashboard_contacts')]
    public function contacts(ContactRepository $repository): Response
    {
        return $this->render('dashboard/contacts.html.twig', [
            'items' => $repository->findBy([], ['id' => 'DESC']),
        ]);
    }

    #[Route('/dashboard/traiter/contact/{id}', name: 'app_dashboard_traiter_contact', methods: ['POST'])]
    public function traiterContact(int $id, Request $request, ContactRepository $repository, EntityManagerInterface $entityManager): Response
    {
        if (!$this->isCsrfTokenValid('traiter_contact_' . $id, (string) $request->request->get('_token'))) {
            throw $this->createAccessDeniedException();
        }

        $item = $repository->find($id);
        if ($item instanceof Contact) {
            $entityManager->remove($item);
            $entityManager->flush();
            $this->addFlash('success', 'Demande supprimée.');
        }

        return $this->redirectToRoute('app_dashboard_contacts');
    }

    #[Route('/dashboard/traiter/creation-site/{id}', name: 'app_dashboard_traiter_web_creation_request', methods: ['POST'])]
    public function traiterWebCreationRequest(int $id, Request $request, WebCreationRequestRepository $repository, EntityManagerInterface $entityManager): Response
    {
        if (!$this->isCsrfTokenValid('traiter_web_creation_request_' . $id, (string) $request->request->get('_token'))) {
            throw $this->createAccessDeniedException();
        }

        $item = $repository->find($id);
        if ($item instanceof WebCreationRequest) {
            $entityManager->remove($item);
            $entityManager->flush();
            $this->addFlash('success', 'Demande supprimée.');
        }

        return $this->redirectToRoute('app_dashboard_web_creation_requests');
    }

    #[Route('/dashboard/traiter/accessibilite/{id}', name: 'app_dashboard_traiter_accessibility_consulting_request', methods: ['POST'])]
    public function traiterAccessibilityConsultingRequest(int $id, Request $request, AccessibilityConsultingRequestRepository $repository, EntityManagerInterface $entityManager): Response
    {
        if (!$this->isCsrfTokenValid('traiter_accessibility_consulting_request_' . $id, (string) $request->request->get('_token'))) {
            throw $this->createAccessDeniedException();
        }

        $item = $repository->find($id);
        if ($item instanceof AccessibilityConsultingRequest) {
            $entityManager->remove($item);
            $entityManager->flush();
            $this->addFlash('success', 'Demande supprimée.');
        }

        return $this->redirectToRoute('app_dashboard_accessibility_consulting_requests');
    }
}

