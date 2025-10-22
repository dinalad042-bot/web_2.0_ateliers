<?php

namespace App\Controller;

use App\Entity\Auther;
use App\Form\AutherType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\AutherRepository;
use Doctrine\Persistence\ManagerRegistry;
final class AutherController extends AbstractController
{
    #[Route('/auther', name: 'app_auther')]
    public function listAuthors(AutherRepository $repository): Response
    {
            $a=$repository->findAll();
        return $this->render('auther_list.html.twig', [
            'authers' => $a,
        ]);
    }
    #[Route('/add', name: 'app_auther_add')]
    public function listtAuthors(Request $request,ManagerRegistry $mr): Response
    {
        $a=$mr->getManager();

        $obj=new Auther();
        $form=$this->Createform(AutherType::class,$obj);
        $form->handleRequest($request);
        if ($form->isSubmitted())
            {
                $a->persist($obj);
                $a->flush();

                return $this->redirectToRoute('app_auther');
            }
        return $this->render('add.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    #[Route('/auther/edit/{id}', name: 'auther_edit')] // Route dynamique utilisant l'ID [1]
    public function editAuther(Request $request, EntityManagerInterface $doctrine, $id): Response
    {

        // Grâce au Param Converter de Symfony, l'objet $author est injecté et déjà récupéré
        // depuis la base de données via l'ID {id} passé dans l'URL.
        $auther=$doctrine->getRepository(Auther::class)->find($id);
        // 1. Initialisation du Formulaire avec l'objet existant ($author)
        $form = $this->createForm(AutherType::class, $auther); // Le formulaire est pré-rempli [6]

        // 2. Gestion de la requête (soumission du formulaire)
        $form->handleRequest($request); // Traitement de la requête HTTP [7]

        // 3. Vérification de la soumission et de la validité
        if ($form->isSubmitted() && $form->isValid()) {

            //$em = $doctrine->getManager(); // Accès au gestionnaire d'entités [4, 8]
            $doctrine->persist($auther);
            // PATTERN CRITIQUE (UPDATE) : Pas besoin de $em->persist($author)
            // L'entité $author est déjà "connue" ou "gérée" par l'Entity Manager puisqu'elle
            // a été récupérée par Doctrine.

            //$em->flush(); // Exécution de l'opération UPDATE en base de données [9, 10]
            $doctrine->flush();
            // Redirection après succès (Pattern réutilisable)
            return $this->redirectToRoute('app_auther');
        }

        // 4. Affichage du formulaire de modification
        return $this->render('auther/edit/edit.html.twig', [
            'formAuther' => $form->createView(), // Affichage de la vue Twig [11]
            'auther' => $auther,
        ]);
    }

    #[Route('/author/delete/{id}', name:'author_delete')]

    public function deleteAuthor(ManagerRegistry $doctrine, Auther $author): Response
    {
        // 1. Connexion à l'Entity Manager
        $em = $doctrine->getManager(); // L'Entity Manager est le chef d'orchestre de Doctrine [1]

        // 2. Recherche et vérification de l'existence de l'auteur (Si l'objet $author n'est pas résolu automatiquement)
        /* Note : Symfony peut injecter directement l'objet Author si l'ID est valide (param converter)
        if (!$author) {
            // Dans le cas où l'ID n'a pas été trouvé (mécanisme de NotFoundException)
            throw $this->createNotFoundException('Aucun auteur trouvé pour l\'id ' . $id); [5]
        }*/

        // 3. Marquage de l'entité pour la suppression
        $em->remove($author); // Indique à Doctrine de préparer la requête de suppression [2, 7]

        // 4. Exécution de la requête (Synchronisation de la base de données)
        $em->flush(); // Envoie la requête DELETE à la BD [2, 7]

        // Optionnel : Ajouter un message flash de succès
        //$this->addFlash('success', 'L\'auteur ' . $author->getUsername() . ' a été supprimé avec succès.');

        // 5. Redirection vers la liste des auteurs après la suppression
        return $this->redirectToRoute('app_auther');
    }

}
