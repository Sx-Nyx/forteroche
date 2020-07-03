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

    public function find(int $id)
    {
        $query = $this->PDO->prepare('SELECT * FROM comment WHERE id = :id');
        $query->execute(['id' => $id]);
        $query->setFetchMode(\PDO::FETCH_CLASS, Comment::class);
        return $query->fetch();
    }

    public function report(int $id)
    {
        $comment = $this->find($id);
        $comment->setReported($comment->getReported() + 1);
        $query = $this->PDO->query("UPDATE comment SET reported={$comment->getReported()} WHERE id={$id}");
        $query->execute();
    }
}
