<?php

/**
 * This file has been auto-generated
 * by the Symfony Routing Component.
 */

return [
    false, // $matchHost
    [ // $staticRoutes
        '/api/authors' => [
            [['_route' => 'author', '_controller' => 'App\\Controller\\AuthorController::getAllAuthors'], null, ['GET' => 0], null, false, false, null],
            [['_route' => 'create_author', '_controller' => 'App\\Controller\\AuthorController::createAuthor'], null, ['POST' => 0], null, false, false, null],
        ],
        '/api/books' => [
            [['_route' => 'book', '_controller' => 'App\\Controller\\BookController::getAllBooks'], null, ['GET' => 0], null, false, false, null],
            [['_route' => 'create_book', '_controller' => 'App\\Controller\\BookController::createBook'], null, ['POST' => 0], null, false, false, null],
        ],
    ],
    [ // $regexpList
        0 => '{^(?'
                .'|/_error/(\\d+)(?:\\.([^/]++))?(*:35)'
                .'|/api/(?'
                    .'|authors/([^/]++)(?'
                        .'|(*:69)'
                    .')'
                    .'|books/([^/]++)(?'
                        .'|(*:94)'
                    .')'
                .')'
            .')/?$}sDu',
    ],
    [ // $dynamicRoutes
        35 => [[['_route' => '_preview_error', '_controller' => 'error_controller::preview', '_format' => 'html'], ['code', '_format'], null, null, false, true, null]],
        69 => [
            [['_route' => 'author_details', '_controller' => 'App\\Controller\\AuthorController::getAuthorDetail'], ['id'], ['GET' => 0], null, false, true, null],
            [['_route' => 'delete_authors', '_controller' => 'App\\Controller\\AuthorController::deleteBooke'], ['id'], ['DELETE' => 0], null, false, true, null],
            [['_route' => 'update_author', '_controller' => 'App\\Controller\\AuthorController::updateBook'], ['id'], ['PUT' => 0], null, false, true, null],
        ],
        94 => [
            [['_route' => 'details', '_controller' => 'App\\Controller\\BookController::getBookDetail'], ['id'], ['GET' => 0], null, false, true, null],
            [['_route' => 'delete_books', '_controller' => 'App\\Controller\\BookController::deleteBooke'], ['id'], ['DELETE' => 0], null, false, true, null],
            [['_route' => 'update_book', '_controller' => 'App\\Controller\\BookController::updateBook'], ['id'], ['PUT' => 0], null, false, true, null],
            [null, null, null, null, false, false, 0],
        ],
    ],
    null, // $checkCondition
];
