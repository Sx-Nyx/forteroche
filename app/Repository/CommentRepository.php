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
    public function create(Comment $comment)
    {
        $fields = [];
        $data = [
            'author'        => $comment->getAuthor(),
            'content'       => $comment->getContent(),
            'reported'      => $comment->getReported(),
            'chapter_id'    => $comment->getChapterId(),
            'created_at'    => $comment->getCreatedAt()->format('Y-m-d H:i:s')
        ];
        foreach ($data as $key => $value) {
            $fields[] = "$key = :$key";
        }
        $query = $this->PDO->prepare("INSERT INTO comment SET " . implode(', ', $fields));
        $response = $query->execute($data);
        if ($response === false) {
            throw new \Exception("Impossible de créer le commentaire");
        }
    }

    public function report(int $id)
    {
        $comment = $this->findBy('id', $id);
        $comment->setReported($comment->getReported() + 1);
        $query = $this->PDO->query("UPDATE comment SET reported={$comment->getReported()} WHERE id={$id}");
        $query->execute();
    }
}
