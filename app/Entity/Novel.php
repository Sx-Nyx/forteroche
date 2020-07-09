<?php

namespace App\Entity;

use Framework\Entity\EntityManager;
use Framework\Helper\UrlHelper;
use Framework\Validator\Validator;

class Novel extends EntityManager
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
    private $description;

    /**
     * @var string
     */
    private $slug;

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
        return (int)$this->id;
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
    public function getDescription(): string
    {
        return $this->description;
    }

    public function getSlug():?string
    {
        return $this->slug;
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
    public function setTitle(string $title, int $id):self
    {
        $this->errors = $this->validator->required('titre', 'Est requis.')
                                        ->unique('novel', 'title', 'titre', 'Doit être unique.')
                                        ->getErrors();
        $this->title = $title;
        return $this;
    }

    /**
     * @param string $description
     * @return $this
     */
    public function setDescription(string $description):self
    {
        $this->errors = $this->validator->required('description', 'Est requis.')
                                        ->getErrors();
        $this->description = $description;
        return $this;
    }

    /**
     * @param string $title
     * @return $this
     */
    public function setSlug(string $title):self
    {
        if (array_key_exists('titre', $this->errors)) {
            return $this;
        }
        $this->slug = UrlHelper::slugify($title);
        return $this;
    }
}
