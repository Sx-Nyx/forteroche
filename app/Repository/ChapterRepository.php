<?php

namespace App\Repository;

use App\Entity\Chapter;
use App\Entity\Comment;
use App\Entity\Novel;
use Framework\Database\AbstractRepository;
use Framework\Database\Exception\NotFoundException;
use PDO;

class ChapterRepository extends AbstractRepository
{
    /**
     * @var \PDO
     */
    protected $PDO;

    protected $table = 'chapter';

    protected $entity = Chapter::class;

    public function __construct(PDO $PDO)
    {
        parent::__construct($PDO);
    }

    /**
     * @param string $slug
     * @return Chapter
     * @throws NotFoundException
     */
    public function findWithComment(string $slug): Chapter
    {
        $chapter = $this->findBy('slug', $slug);

        $queryComment = $this->PDO->query("SELECT * FROM comment WHERE chapter_id = {$chapter->getId()} ORDER BY created_at DESC");
        $comments = $queryComment->fetchAll(PDO::FETCH_CLASS, Comment::class);

        $chapter->setComments($comments);

        return $chapter;
    }

    /**
     * @param int $novelId
     * @return array
     */
    public function findAllBy(int $novelId)
    {
        $query = $this->PDO->prepare("SELECT * FROM chapter WHERE novel_id = :id ORDER BY created_at");
        $query->execute(['id' => $novelId]);
        return $query->fetchAll(PDO::FETCH_CLASS, Chapter::class);
    }

    /**
     * @param int $novelId
     * @return array
     */
    public function findAndCount(int $novelId): array
    {
        $chapters = $this->findAllBy($novelId);
        foreach ($chapters as $chapter) {
            $query = $this->PDO->query("SELECT COUNT(id) FROM comment WHERE chapter_id = {$chapter->getId()}");
            $comment = (int)$query->fetch(PDO::FETCH_COLUMN);
            $chapter->setNumberComment($comment);
        }
        return $chapters;
    }

    public function updateChapter(Chapter $chapter): void
    {
        $this->update([
            'title'         => $chapter->getTitle(),
            'content'       => $chapter->getContent(),
            'status'        => $chapter->getStatus(),
            'slug'          => $chapter->getSlug(),
        ], $chapter->getId());
    }

    public function createChapter(Chapter $chapter): void
    {
        $id = $this->create([
            'title'         => $chapter->getTitle(),
            'content'       => $chapter->getContent(),
            'slug'          => $chapter->getSlug(),
            'novel_id'      => $chapter->getNovelId(),
            'status'        => $chapter->getStatus(),
            'created_at'    => $chapter->getCreatedAt()->format('Y-m-d H:i:s')
        ]);
        $chapter->setId($id);
    }
}
