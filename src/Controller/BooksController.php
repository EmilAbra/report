<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Books;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\BooksRepository;

class BooksController extends AbstractController
{
    #[Route('/books', name: 'app_books')]
    public function index(): Response
    {
        return $this->render('books/index.html.twig');
    }

    /**
    * @Route("/books/show", name="books_show_all")
    */
    public function showAllBooks(
        BooksRepository $booksRepository
    ): Response {
        $books = $booksRepository
            ->findAll();

        if (!$books) {
                throw $this->createNotFoundException(
                    'No books found in database'
                );
            }

        return $this->render('books/show_all.html.twig', [
            'books' => $books
        ]);
    }

    /**
    * @Route("/books/show/{id}", name="books_show_one")
    */
    public function showOneBook(
        BooksRepository $booksRepository, int $id
    ): Response {
        $book = $booksRepository
            ->find($id);

        if (!$book) {
                throw $this->createNotFoundException(
                    'No book found for id '.$id
                );
            }

        return $this->render('books/show_one.html.twig', [
            'book' => $book
        ]);
    }

    /**
    * @Route("/books/update", name="books_update")
    */
    public function updateBook(
        BooksRepository $booksRepository
    ): Response {
        $books = $booksRepository
            ->findAll();

        if (!$books) {
                throw $this->createNotFoundException(
                    'No books found in database'
                );
            }

        return $this->render('books/update_book.html.twig', [
            'books' => $books
        ]);
    }

    /**
    * @Route("/books/update/{id}", name="books_update_form", methods={"GET"})
    */
    public function updateOneBook(
        BooksRepository $booksRepository, int $id
    ): Response {
        $book = $booksRepository
            ->find($id);

        if (!$book) {
                throw $this->createNotFoundException(
                    'No book found for id '.$id
                );
            }

        return $this->render('books/book_edit_form.html.twig', [
            'book' => $book
        ]);
    }

    /**
     * @Route("/books/update/{id}", name="books_update_process", methods={"GET", "POST"})
     */
    public function updateProcess(ManagerRegistry $doctrine, Request $request, int $id): Response
    {
        $author = $request->request->get('author');
        $title  = $request->request->get('title');
        $isbn  = $request->request->get('isbn');
        $imgpath  = $request->request->get('imgpath');

        $entityManager = $doctrine->getManager();
        $book = $entityManager->getRepository(Books::class)->find($id);

        if (!$book) {
            throw $this->createNotFoundException(
                'No book found for id '.$id
            );
        }

        $book->setAuthor($author);
        $book->setTitel($title);
        $book->setIsbn($isbn);
        $book->setImgpath($imgpath);

        $entityManager->flush();

        return $this->redirectToRoute('books_update');
    }

    /**
     * @Route("/books/create", name="books_create_form", methods={"GET"})
     */
    public function createBook(): Response
    {
        return $this->render('books/book_create_form.html.twig');
    }

    /**
     * @Route("/books/create", name="books_create_process", methods={"POST"})
     */
    public function createBookProcess(
        ManagerRegistry $doctrine, Request $request
    ): Response
    {
        $author = $request->request->get('author');
        $title  = $request->request->get('title');
        $isbn  = $request->request->get('isbn');
        $imgpath  = $request->request->get('imgpath');

        $entityManager = $doctrine->getManager();

        $book = new Books();
        $book->setAuthor($author);
        $book->setTitel($title);
        $book->setIsbn($isbn);
        $book->setImgpath($imgpath);

        $entityManager->persist($book);

        $entityManager->flush();

        return $this->redirectToRoute('books_show_all');
    }

    /**
     * @Route("/books/delete", name="delete_book", methods={"GET"})
     */
     public function deleteBook(
         BooksRepository $booksRepository
     ): Response {
         $books = $booksRepository
             ->findAll();

         if (!$books) {
                 throw $this->createNotFoundException(
                     'No books found in database'
                 );
             }

         return $this->render('books/delete_book.html.twig', [
             'books' => $books
         ]);
    }

    /**
    * @Route("/books/delete/{id}", name="delete_book_form", methods={"GET"})
    */
    public function deleteBookForm(
      BooksRepository $booksRepository, int $id
    ): Response {
        $book = $booksRepository
            ->find($id);

        if (!$book) {
                throw $this->createNotFoundException(
                    'No book found for id '.$id
                );
        }

    return $this->render('books/delete_book_form.html.twig', ['book' => $book]);
    }

  /**
   * @Route("/books/delete/{id}", name="delete_book_process", methods={"GET", "POST"})
   */
    public function deleteBookProcess(
        ManagerRegistry $doctrine,
        int $id
    ): Response {
        $entityManager = $doctrine->getManager();
        $book = $entityManager->getRepository(Books::class)->find($id);

        if (!$book) {
            throw $this->createNotFoundException(
              'No book found for id '.$id
            );
        }

        $entityManager->remove($book);
        $entityManager->flush();

        return $this->redirectToRoute('delete_book');
    }
}
