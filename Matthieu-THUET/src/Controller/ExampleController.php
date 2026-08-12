<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ExampleController extends AbstractController
{
    #[Route('/exemples', name: 'app_examples_index')]
    public function index(): Response
    {
        return $this->render('examples/index.html.twig');
    }

    #[Route('/exemples/exemple-1', name: 'app_examples_grid')]
    public function grid(): Response
    {
        return $this->render('examples/example_1.html.twig');
    }

    #[Route('/exemples/exemple-2', name: 'app_examples_dashboard')]
    public function dashboard(): Response
    {
        return $this->render('examples/example_2.html.twig');
    }

    #[Route('/exemples/exemple-3', name: 'app_examples_bubbles')]
    public function bubbles(): Response
    {
        return $this->render('examples/example_3.html.twig');
    }
}
