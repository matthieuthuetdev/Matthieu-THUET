<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Repository\ContactRepository;
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
}
