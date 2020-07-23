<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Repository\ChapterRepository;
use App\Repository\CommentRepository;
use App\Repository\NovelRepository;
use DateTime;
use Framework\Controller\AbstractController;
use Framework\Database\Connection;
use Framework\Database\Exception\NotFoundException;
use Framework\Helper\Form;
use Framework\Rendering\Exception\ViewRenderingException;
use Framework\Routing\Exception\RouteNotFoundException;
use Framework\Routing\Router;
use Framework\Server\Response;
use Framework\Session\FlashMessage;
use Framework\Validator\Validator;

class NovelController extends AbstractController
{
    /**
     * @var string $viewBasePath
     */
    protected $viewBasePath = 'templates/novel/';

    /**
     * @var Router
     */
    private $router;

    public function __construct(Router $router)
    {
        parent::__construct($router);
        $this->router = $router;
    }

    /**
     * @param array $parameters
     * @return string
     * @throws ViewRenderingException
     */
    public function index(array $parameters): string
    {
        $pdo = Connection::getPDO();
        $novel = $this->findBy(new NovelRepository($pdo), 'slug', $parameters[0]);
        $chapters = (new ChapterRepository($pdo))->findAndCount($novel->getId());
        return $this->render('index', [
            'novel' => $novel,
            'novelSlug' => $novel->getSlug(),
            'chapters' => $chapters
        ]);
    }

    /**
     * @param array $parameters
     * @return string
     * @throws ViewRenderingException
     * @throws RouteNotFoundException
     */
    public function show(array $parameters): string
    {
        $comment = new Comment(new Validator($_POST));
        $pdo = Connection::getPDO();
        try {
            $chapter = (new ChapterRepository($pdo))->findWithComment($parameters[1]);
        } catch (NotFoundException $exception) {
            $this->router->generate404();
        }
        if (!empty($_POST)) {
            $data = [
                'reported' => 0,
                'chapter_id' => $chapter->getId(),
                'created_at' => new DateTime(date('Y-m-d H:i:s'))
            ];
            $this->hydrateEntity($comment, array_merge($data, $_POST), ['author', 'content', 'chapter_id', 'reported', 'created_at']);
            if (empty($comment->getErrors())) {
                (new CommentRepository($pdo))->createComment($comment);
                FlashMessage::success('Votre commentaire a bien été publié.');
                Response::redirection($this->router->generateUrl('novel.show', [
                    'novelSlug' => $parameters[0],
                    'chapterSlug' => $parameters[1],])
                );
            }
        }
        return $this->render('show', [
            'novelSlug' => $parameters[0],
            'chapterSlug' => $parameters[1],
            'chapter' => $chapter,
            'form' => new Form($comment)
        ]);
    }
}
