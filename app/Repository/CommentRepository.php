<?php

namespace App\Repository;

use App\Entity\Comment;

class CommentRepository
{
    /**
     * @var \PDO
     */
    private $PDO;

    public function __construct(\PDO $PDO)
    {
        $this->PDO = $PDO;
    }

    /**
     * @param Comment $comment
     * @throws \Exception
     */
    public function create(Comment $comment)
    {
        $fields = [];
        $data = [
            'author'        => $comment->getAuthor(),
            'content'       => $comment->getContent(),
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
}
