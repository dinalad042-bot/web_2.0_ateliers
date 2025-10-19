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
 #[Route('/show_static_mode/{name}', name: 'show_auther_statically')]

public function showAuthor(string $name): Response
{
    $variable_a_transferer = "Ceci est la valeur";

    // Utilisation de render() pour transférer les données à la vue
    return $this->render('show_static.html.twig', [
        'variable_twig' => $variable_a_transferer,
        'autre_info' => 2024,
        'nom'=> $name
    ]);
    // Le tableau des paramètres est envoyé du Controller à Twig [2]
}



}
