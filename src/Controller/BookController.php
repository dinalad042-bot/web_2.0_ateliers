<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\BookType;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

final class BookController extends AbstractController
{
    #[Route('/book', name: 'list_view')]
    public function show(BookRepository $rep): Response
    {
        $book=$rep->findAll();

        return $this->render('book/book.html.twig',[
            'books'=>$book,
        ]);
    }

    #[Route('/book/add', name: 'add_book')]
    public function Ajout(Request $req,EntityManagerInterface $em): Response
    {
        $book=new Book();
        $form=$this->createForm(BookType::class,$book);
        $form->handleRequest($req);

        if ($form->isSubmitted()&& $form->isValid())
            {
                $em->persist($book);
                $em->flush();
                return $this->redirectToRoute('list_view');
            }
        return $this->render('book/add.html.twig',[
            'form_book'=>$form->createView(),
            ]);
    }
}
