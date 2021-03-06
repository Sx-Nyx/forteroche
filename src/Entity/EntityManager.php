<?php

namespace Framework\Entity;

abstract class EntityManager
{
    /**
     * @var array $errors
     */
    protected $errors;

    /**
     * @return null|array
     */
    public function getErrors(): ?array
    {
        return $this->errors;
    }

}
