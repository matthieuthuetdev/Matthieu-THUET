<?php

namespace App\Controller;

use App\Service\ClientsCatalog;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ClientsController extends AbstractController
{
    #[Route('/clients', name: 'app_clients')]
    public function index(ClientsCatalog $clientsCatalog): Response
    {
        return $this->render('clients/index.html.twig', [
            'controller_name' => 'ClientsController',
            'clients' => $clientsCatalog->all(),
        ]);
    }
}
