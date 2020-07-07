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
     * @var bool
     */
    private $status;

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
     * @return bool
     */
    public function getStatus():bool
    {
        return $this->status;
    }

    /**
     * @param int $numberComment
     * @return Chapter
     */
    public function setNumberComment(int $numberComment):self
    {
        $this->numberComment = $numberComment;
        return $this;
    }

    /**
     * @param array $comments
     * @return Chapter
     */
    public function setComments(array $comments):self
    {
        $this->comments = $comments;
        return $this;
    }

    /**
     * @param bool $status
     * @return $this
     */
    public function setStatus(bool $status = false):self
    {
        $this->status = $status;
        return $this;
    }
}
