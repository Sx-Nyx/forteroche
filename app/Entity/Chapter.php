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

    public function getSlug():string
    {
        return $this->slug;
    }

    public function getNumberComment():int
    {
        return $this->numberComment;
    }

    public function setNumberComment(int $numberComment)
    {
        $this->numberComment = $numberComment;
    }
}
