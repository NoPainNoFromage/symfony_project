<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Lien;
use App\Form\ClientType;
use App\Form\LienType;
use App\Repository\ClientRepository;
use App\Repository\LienRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/client')]
class ClientController extends AbstractController
{
    #[Route('/', name: 'app_client_index', methods: ['GET'])]
    public function index(ClientRepository $clientRepository): Response
    {
        return $this->render('client/index.html.twig', [
            'clients' => $clientRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_client_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ClientRepository $clientRepository): Response
    {
        $client = new Client();
        $form = $this->createForm(ClientType::class, $client);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $clientRepository->add($client);
            return $this->redirectToRoute('app_client_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('client/new.html.twig', [
            'client' => $client,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_client_show', methods: ['GET'])]
    public function show(Client $client): Response
    {
        return $this->render('client/show.html.twig', [
            'client' => $client,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_client_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Client $client, ClientRepository $clientRepository): Response
    {
        $form = $this->createForm(ClientType::class, $client);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $clientRepository->add($client);
            return $this->redirectToRoute('app_client_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('client/edit.html.twig', [
            'client' => $client,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/add', name: 'app_client_add_materiel', methods: ['GET', 'POST'])]
    public function addMateriel(Request $request, Client $client, LienRepository $lienRepository): Response
    {
        $lien = new Lien();
        $lien->setClient($client);
        $form = $this->createForm(LienType::class, $lien);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $lienRepository->add($lien);
            return $this->redirectToRoute('app_client_show', ['id'=>$client->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('client/add_materiel.html.twig', [
            'client' => $client,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit_materiel', name: 'app_client_edit_materiel', methods: ['GET', 'POST'])]
    public function editMateriel(Request $request, Lien $lien, LienRepository $lienRepository): Response
    {
        dump(1);
        $form = $this->createForm(LienType::class, $lien);
        $form->handleRequest($request);
        dump($form);
        if ($form->isSubmitted() && $form->isValid()) {
            $lienRepository->add($lien);
            return $this->redirectToRoute('app_client_show', ['id'=>$lien->getClient()->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('client/edit_materiel.html.twig', [
            'lien' => $lien,
            'form' => $form,
        ]);
    }


    #[Route('/{id}', name: 'app_client_delete', methods: ['POST'])]
    public function delete(Request $request, Client $client, ClientRepository $clientRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$client->getId(), $request->request->get('_token'))) {
            $clientRepository->remove($client);
        }

        return $this->redirectToRoute('app_client_index', [], Response::HTTP_SEE_OTHER);
    }
}
