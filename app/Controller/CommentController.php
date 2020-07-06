<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Repository\ChapterRepository;
use App\Repository\CommentRepository;
use DateTime;
use Framework\Database\Connection;
use Framework\Routing\Router;
use Framework\Server\Response;
use Framework\Session\FlashMessage;
use Framework\Session\Session;
use Framework\Validator\Validator;

class CommentController
{
    public static function new(Router $router, array $parameters)
    {
        if (!empty($_POST)) {
            $chapter = (new ChapterRepository(Connection::getPDO()))->findBy('slug', $parameters[1]);
            $comment = (new Comment(new Validator($_POST)))
                ->setAuthor($_POST['pseudo'])
                ->setContent($_POST['commentaire'])
                ->setChapterId($chapter->getId())
                ->setReported(0)
                ->setCreatedAt(new DateTime(date('Y-m-d H:i:s')));
            if (!empty($comment->getErrors())) {
                FlashMessage::errors($comment->getErrors());
                Session::set('pseudo', $comment->getAuthor());
                Session::set('commentaire', $comment->getContent());
                Response::redirection($router->generateUrl('novel.show',
                    ['novelSlug' => $parameters[0], 'chapterSlug' => $parameters[1]]));
            }
            (new CommentRepository(Connection::getPDO()))->create($comment);
            FlashMessage::success('Votre commentaire a bien été plubié');
            Response::redirection($router->generateUrl('novel.show',
                ['novelSlug' => $parameters[0], 'chapterSlug' => $parameters[1]]));
        }
    }

    public static function report(Router $router, array $parameters)
    {
        (new CommentRepository(Connection::getPDO()))->report($parameters[2]);
        Response::redirection($router->generateUrl('novel.show',
            ['novelSlug' => $parameters[0], 'chapterSlug' => $parameters[1]]));
    }
}
