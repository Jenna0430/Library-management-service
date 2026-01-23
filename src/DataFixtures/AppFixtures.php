<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Book;
use App\Entity\Author;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $listAuthor = [];
        for ($i = 1; $i < 10; $i++) {
            $author = new Author();
            $author->setFirstName('Firstname ' . $i);
            $author->setLastName('Lastname ' . $i);
            $manager->persist($author);
            $listAuthor[] = $author;
        }  

        for ($i = 1; $i < 10; $i++) {
            $book = new Book();
            $book->setTitle('Book Title ' . $i);
            $book->setCoverText('This is the cover text for book ' . $i);
            $book->setPublishedYear(2000 + $i);
            $book->setAuthor($listAuthor[array_rand($listAuthor)]);
            $manager->persist($book);
        }

        $manager->flush();

       
    }
}
