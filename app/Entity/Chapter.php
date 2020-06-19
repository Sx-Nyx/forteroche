<?php

namespace App\Entity;

class Chapter
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $content;

    /**
     * @var string
     */
    private $slug;

    /**
     * @var int
     */
    private $numberComment;

    /**
     * @var []Comment
     */
    private $comments;

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
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @return string
     */
    public function getSlug():string
    {
        return $this->slug;
    }

    /**
     * @return int
     */
    public function getNumberComment():int
    {
        return $this->numberComment;
    }

    /**
     * @return array
     */
    public function getComments(): array
    {
        return $this->comments;
    }

    /**
     * @param int $numberComment
     */
    public function setNumberComment(int $numberComment)
    {
        $this->numberComment = $numberComment;
    }

    /**
     * @param array $comments
     */
    public function setComments(array $comments): void
    {
        $this->comments = $comments;
    }
}
