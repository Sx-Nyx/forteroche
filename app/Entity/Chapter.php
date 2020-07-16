<?php

namespace App\Entity;

use DateTime;
use Framework\Entity\EntityManager;
use Framework\Helper\UrlHelper;
use Framework\Validator\Validator;

class Chapter extends EntityManager
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
    private $novelId;

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
     * @var DateTime
     */
    private $createdAt;

    /**
     * @var Validator|null
     */
    private $validator;

    public function __construct(?Validator $validator = null)
    {
        $this->validator = $validator;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @return string|null
     */
    public function getContent(): ?string
    {
        return $this->content;
    }

    public function getNovelId(): int
    {
        return $this->novelId;
    }

    /**
     * @return string|null
     */
    public function getSlug(): ?string
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
     * @return int|null
     */
    public function getStatus(): ?int
    {
        return $this->status;
    }

    /**
     * @return DateTime
     * @throws \Exception
     */
    public function getCreatedAt(): DateTime
    {
        return new DateTime($this->createdAt);
    }

    /**
     * @param int $id
     * @return $this
     */
    public function setId(int $id):self
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @param string $title
     * @param int $id
     * @return $this
     */
    public function setTitle(string $title, int $id): self
    {
        $this->errors = $this->validator->required('titre', 'Est requis.')
                                        ->unique('chapter', 'title', 'titre', 'Doit être unique.', $id)
                                        ->getErrors();

        $this->title = $title;
        return $this;
    }

    /**
     * @param string $content
     * @return $this
     */
    public function setContent(string $content): self
    {
        $this->errors = $this->validator->required('contenu', 'Est requis.')
                                        ->getErrors();

        $this->content = $content;
        return $this;
    }

    /**
     * @param int $novelId
     * @return $this
     */
    public function setNovelId(int $novelId): self
    {
        $this->errors = $this->validator->exists('novel', 'novel', 'Doit exister')
                                        ->getErrors();

        $this->novelId = $novelId;
        return $this;
    }

    /**
     * @param string $title
     * @return $this
     */
    public function setSlug(string $title): self
    {
        if (array_key_exists('titre', $this->errors)) {
            return $this;
        }
        $this->slug = UrlHelper::slugify($title);
        return $this;
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
        if ($status) {
            $this->status = 1;
        } else {
            $this->status = 0;
        }
        return $this;
    }

    /**
     * @param DateTime $createdAt
     * @return $this
     */
    public function setCreatedAt(DateTime $createdAt): self
    {
        $this->createdAt = $createdAt->format('Y-m-d H:i:s');;
        return $this;
    }
}
