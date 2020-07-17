<?php

namespace App\Repository;

use App\Entity\Comment;
use Exception;
use Framework\Database\AbstractRepository;
use PDO;

class CommentRepository extends AbstractRepository
{
    /**
     * @var PDO
     */
    protected $PDO;

    protected $table = 'comment';

    protected $entity = Comment::class;

    public function __construct(PDO $PDO)
    {
        parent::__construct($PDO);
    }

    /**
     * @param Comment $comment
     * @throws Exception
     */
    public function createComment(Comment $comment): void
    {
        $id = $this->create([
            'author'        => $comment->getAuthor(),
            'content'       => $comment->getContent(),
            'reported'      => $comment->getReported(),
            'chapter_id'    => $comment->getChapterId(),
            'created_at'    => $comment->getCreatedAt()->format('Y-m-d H:i:s')
        ]);
        $comment->setId($id);
    }

    public function updateComment(Comment $comment): void
    {
        $this->update([
            'reported'          => $comment->getReported(),
        ], $comment->getId());
    }

    public function report(int $id)
    {
        $comment = $this->findBy('id', $id);
        $comment->setReported($comment->getReported() + 1);
        $query = $this->PDO->query("UPDATE comment SET reported={$comment->getReported()} WHERE id={$id}");
        $query->execute();
    }

    /**
     * @return array
     */
    public function findAllReported()
    {
        $query = $this->PDO->query('SELECT * FROM comment WHERE reported > 0 ORDER BY reported DESC');
        return $query->fetchAll(PDO::FETCH_CLASS, Comment::class);
    }
}
