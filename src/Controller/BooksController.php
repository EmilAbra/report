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

/**
* @SuppressWarnings(PHPMD)
*/
class BooksController extends AbstractController
{
    #[Route('/books', name: 'app_books')]
    public function index(
        BooksRepository $booksRepository
    ): Response {
        $books = $booksRepository
            ->findAll();

        if (empty($books)) {
                throw $this->createNotFoundException(
                    'No books found in database'
                );
        }
        return $this->render('books/index.html.twig', [
            'books' => $books
        ]);
    }

    /**
    * @Route("/books/show", name="books_show_all")
    */
    public function showAllBooks(
        BooksRepository $booksRepository
    ): Response {
        $books = $booksRepository
            ->findAll();

        if (empty($books)) {
                throw $this->createNotFoundException(
                    'No books found in database'
                );
        }

        return $this->render('books/show_all.html.twig', [
            'books' => $books
        ]);
    }

    /**
    * @Route("/books/show/{idOfBook}", name="books_show_one")
    */
    public function showOneBook(
        BooksRepository $booksRepository,
        int $idOfBook
    ): Response {
        $book = $booksRepository
            ->find($idOfBook);

        if (!$book) {
                throw $this->createNotFoundException(
                    'No book found for id ' . $idOfBook
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

        if (empty($books)) {
                throw $this->createNotFoundException(
                    'No books found in database'
                );
        }

        return $this->render('books/update_book.html.twig', [
            'books' => $books
        ]);
    }

    /**
    * @Route("/books/update/{idOfBook}", name="books_update_form", methods={"GET"})
    */
    public function updateOneBook(
        BooksRepository $booksRepository,
        int $idOfBook
    ): Response {
        $book = $booksRepository
            ->find($idOfBook);

        if (!$book) {
                throw $this->createNotFoundException(
                    'No book found for id ' . $idOfBook
                );
        }

        return $this->render('books/edit_book_form.html.twig', [
            'book' => $book
        ]);
    }

    /**
     * @Route("/books/update/{idOfBook}", name="books_update_process", methods={"GET", "POST"})
     */
    public function updateProcess(ManagerRegistry $doctrine, Request $request, int $idOfBook): Response
    {
        $author = $request->request->get('author');
        $title  = $request->request->get('title');
        $isbn  = $request->request->get('isbn');
        $imgpath  = $request->request->get('imgpath');

        $entityManager = $doctrine->getManager();
        $book = $entityManager->getRepository(Books::class)->find($idOfBook);

        if (!$book) {
            throw $this->createNotFoundException(
                'No book found for id ' . $idOfBook
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
        return $this->render('books/create_book_form.html.twig');
    }

    /**
     * @Route("/books/create", name="books_create_process", methods={"POST"})
     */
    public function createBookProcess(
        ManagerRegistry $doctrine,
        Request $request
    ): Response {
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

        if (empty($books)) {
                throw $this->createNotFoundException(
                    'No books found in database'
                );
        }

        return $this->render('books/delete_book.html.twig', [
            'books' => $books
        ]);
    }

    /**
    * @Route("/books/delete/{idOfBook}", name="delete_book_form", methods={"GET"})
    */
    public function deleteBookForm(
        BooksRepository $booksRepository,
        int $idOfBook
    ): Response {
        $book = $booksRepository
            ->find($idOfBook);

        if (!$book) {
                throw $this->createNotFoundException(
                    'No book found for id ' . $idOfBook
                );
        }

        return $this->render('books/delete_book_form.html.twig', ['book' => $book]);
    }

  /**
   * @Route("/books/delete/{idOfBook}", name="delete_book_process", methods={"GET", "POST"})
   */
    public function deleteBookProcess(
        ManagerRegistry $doctrine,
        int $idOfBook
    ): Response {
        $entityManager = $doctrine->getManager();
        $book = $entityManager->getRepository(Books::class)->find($idOfBook);

        if (!$book) {
            throw $this->createNotFoundException(
                'No book found for id ' . $idOfBook
            );
        }

        $entityManager->remove($book);
        $entityManager->flush();

        return $this->redirectToRoute('delete_book');
    }
}
