<?php

namespace App\Controller;

use App\Repository\AuthorRepository;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;

final class BookController extends AbstractController
{
    #[Route('/api/books', name: 'book', methods: ['GET'])]
    public function getAllBooks(BookRepository $bookRepository, SerializerInterface $serializer): JsonResponse
    {
        $bookList = $bookRepository->findAll();
        $jsonBookList = $serializer->serialize($bookList, 'json', ['groups' => 'getBooks']);

        return new JsonResponse($jsonBookList, Response::HTTP_OK, [], true);
    }

    #[Route('/api/books/{id}', name: 'details', methods: ['GET'])]
    public function getBookDetail(int $id, BookRepository $bookRepository, SerializerInterface $serializer): JsonResponse
    {
        $book = $bookRepository->find($id);
        if ($book) {
            $jsonBook = $serializer->serialize($book, 'json', ['groups' => 'getBooks']);
            return new JsonResponse($jsonBook, Response::HTTP_OK, [], true);
        } else {
            return new JsonResponse(['message' => 'Book not found'], Response::HTTP_NOT_FOUND);
        }
}

 #[Route('/api/books/{id}', name: 'delete_books', methods: ['DELETE'])]
    public function deleteBooke(int $id, EntityManagerInterface $em): JsonResponse
    {
       $em->remove($em->getReference('App\Entity\Book', $id));
       $em->flush();

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }

#[Route('/api/books', name: 'create_book', methods: ['POST'])]
    public function createBook(Request $request, SerializerInterface $serializer, EntityManagerInterface $em, UrlGeneratorInterface $urlGenerator, AuthorRepository $authorRepository): JsonResponse
    {
        $book = $serializer->deserialize(
            $request->getContent(),
            'App\Entity\Book',
            'json'
        );
        $content = $request->toArray();

        $idAuthor = $content['idAuthor'] ?? -1;
        $book->setAuthor($authorRepository->find($idAuthor));

        $em->persist($book);
        $em->flush();

        $jsonBook = $serializer->serialize($book, 'json', ['groups' => 'getBooks']);

        $location = $urlGenerator->generate('details', ['id' => $book->getId()], UrlGeneratorInterface::ABSOLUTE_URL);

        return new JsonResponse($jsonBook, Response::HTTP_CREATED, ["Location" => $location], true);
    }

   #[Route('/api/books/{id}', name: 'update_book', methods: ['PUT'])]
    public function updateBook(int $id, Request $request, SerializerInterface $serializer, EntityManagerInterface $em, BookRepository $bookRepository, AuthorRepository $authorRepository): JsonResponse
    {
        $bookToUpdate = $serializer->deserialize(
            $request->getContent(),
            'App\Entity\Book',
            'json',
            [AbstractNormalizer::OBJECT_TO_POPULATE => $bookRepository->find($id)]
        );

        $content = $request->toArray();
        $idAuthor = $content['idAuthor'] ?? -1;
        $bookToUpdate->setAuthor($authorRepository->find($idAuthor));

        $em->persist($bookToUpdate);
        $em->flush();
        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }      
}
