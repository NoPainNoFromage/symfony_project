<?php

namespace App\Controller;

use App\Repository\ClientRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AppController extends AbstractController
{
    #[Route('/', name: 'app_app')]
    public function index(ClientRepository $clientRepository): Response
    {
        return $this->render('app/index.html.twig', [
            'result' => $clientRepository->findClientWithExpensiveMateriel(),
        ]);
    }
}
