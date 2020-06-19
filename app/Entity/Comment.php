<?php

namespace App\Entity;

use DateTime;

class Comment
{
    /**
     * @var int $id
     */
    private $id;

    /**
     * @var string $author
     */
    private $author;

    /**
     * @var string $content
     */
    private $content;

    /**
     * @var int $chapter_id
     */
    private $chapter_id;

    /**
     * @var \DateTime $created_at
     */
    private $created_at;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getAuthor(): string
    {
        return $this->author;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @return int
     */
    public function getChapterId(): int
    {
        return $this->chapter_id;
    }

    /**
     * @return DateTime
     * @throws \Exception
     */
    public function getCreatedAt(): DateTime
    {
        return new DateTime($this->created_at);
    }
}
