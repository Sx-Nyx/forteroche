<?php

namespace App\Entity;

use DateTime;
use Framework\Entity\EntityManager;
use Framework\Validator\Validator;

class Comment extends EntityManager
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
     * @var int $reported
     */
    private $reported;

    /**
     * @var \DateTime $created_at
     */
    private $created_at;

    /**
     * @var Validator|null
     */
    private $validator;

    public function __construct(?Validator $validator = null)
    {
        $this->validator = $validator;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
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
        return htmlentities($this->content);
    }

    /**
     * @return int
     */
    public function getChapterId(): int
    {
        return $this->chapter_id;
    }

    /**
     * @return int
     */
    public function getReported(): int
    {
        return $this->reported;
    }

    /**
     * @return DateTime
     * @throws \Exception
     */
    public function getCreatedAt(): DateTime
    {
        return new DateTime($this->created_at);
    }

    /**
     * @param string $author
     * @return $this
     */
    public function setAuthor(string $author): self
    {
        $this->errors = $this->validator->min('pseudo', 3, 'Contenir au minimum 3 caractères.')
                                        ->max('pseudo', 15, 'Contenir au minimum 15 caractères.')
                                        ->getErrors();
        $this->author = $author;
        return $this;
    }

    /**
     * @param string $content
     * @return $this
     */
    public function setContent(string $content): self
    {
        $this->errors = $this->validator->min('commentaire', 10, 'Contenir au minimum 10 caractères.')
                                        ->getErrors();
        $this->content = $content;
        return $this;
    }

    /**
     * @param int $chapter_id
     * @return $this
     */
    public function setChapterId(int $chapter_id): self
    {
        $this->chapter_id = $chapter_id;
        return $this;
    }

    /**
     * @param int $nbReport
     * @return $this
     */
    public function setReported(int $nbReport): self
    {
        $this->reported = $nbReport;
        return $this;
    }

    /**
     * @param DateTime $created_at
     * @return $this
     */
    public function setCreatedAt(DateTime $created_at): self
    {
        $this->created_at = $created_at->format('Y-m-d H:i:s');;
        return $this;
    }
}
