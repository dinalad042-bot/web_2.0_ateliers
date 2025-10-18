<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class GitController extends AbstractController
{
    #[Route('/Service/{name}', name: 'show_Service')]
    public function showService(string $name): Response
    {
        return $this->render('service/showService.html.twig', [
                    'name' => $name,
                ]);
    }

 #[Route('/accueil', name: 'home_index')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
                 'message' => 'Bonjour mes étudiants'
                 ]);
    }
 #[Route('/', name: 'go_to_index')]
    public function goToIndex(): Response
    {
        // Utilise redirectToRoute() pour renvoyer l'utilisateur vers la route nommée 'home_index'.
        return $this->redirectToRoute('home_index');
    }
}
