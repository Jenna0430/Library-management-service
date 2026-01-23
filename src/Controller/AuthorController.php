<?php

namespace App\Controller;

use App\Repository\AuthorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;

final class AuthorController extends AbstractController
{
    #[Route('/api/authors', name: 'author', methods: ['GET'] )]
    public function getAllAuthors(AuthorRepository $authorRepository, SerializerInterface $serializer): JsonResponse
    {
        $authorList = $authorRepository->findAll();
        $jsonAuthorList = $serializer->serialize($authorList, 'json', ['groups' => 'getBooks']);
        return new JsonResponse($jsonAuthorList, Response::HTTP_OK, [], true);
    }

     #[Route('/api/authors/{id}', name: 'author_details', methods: ['GET'])]
    public function getAuthorDetail(int $id, AuthorRepository $authorRepository, SerializerInterface $serializer): JsonResponse
    {
        $author = $authorRepository->find($id);
        if ($author) {
            $jsonAuthor = $serializer->serialize($author, 'json', ['groups' => 'getBooks']);
            return new JsonResponse($jsonAuthor, Response::HTTP_OK, [], true);
        } else {
            return new JsonResponse(['message' => 'Author not found'], Response::HTTP_NOT_FOUND);
        }
    }

     #[Route('/api/authors/{id}', name: 'delete_authors', methods: ['DELETE'])]
    public function deleteBooke(int $id, EntityManagerInterface $em): JsonResponse
    {
       $em->remove($em->getReference('App\Entity\Author', $id));
       $em->flush();

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }

    #[Route('/api/authors', name: 'create_author', methods: ['POST'])]
    public function createAuthor(Request $request, SerializerInterface $serializer, EntityManagerInterface $em, UrlGeneratorInterface $urlGenerator): JsonResponse
    {
        $author = $serializer->deserialize(
            $request->getContent(),
            'App\Entity\Author',
            'json'
        );

        $em->persist($author);
        $em->flush();

        $jsonAuthor = $serializer->serialize($author, 'json', ['groups' => 'getBooks']);

        $location = $urlGenerator->generate('details', ['id' => $author->getId()], UrlGeneratorInterface::ABSOLUTE_URL);

        return new JsonResponse($jsonAuthor, Response::HTTP_CREATED, ["Location" => $location], true);
    }

    #[Route('/api/authors/{id}', name: 'update_author', methods: ['PUT'])]
    public function updateBook(int $id, Request $request, SerializerInterface $serializer, EntityManagerInterface $em, AuthorRepository $authorRepository): JsonResponse
    {
        $AuthorToUpdate = $serializer->deserialize(
            $request->getContent(),
            'App\Entity\Author',
            'json',
            [AbstractNormalizer::OBJECT_TO_POPULATE => $authorRepository->find($id)]
        );

        // $content = $request->toArray();
        // $idAuthor = $content['idAuthor'] ?? -1;
        // $AuthorToUpdate->setAuthor($authorRepository->find($idAuthor));

        $em->persist($AuthorToUpdate);
        $em->flush();
        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }   
}
