<?php

namespace Framework\Validator;

use PDO;

class Validator
{
    /**
     * @var array
     */
    private $fields;

    /**
     * @var PDO|null
     */
    private $PDO;

    /**
     * @var array
     */
    private $errors = [];

    public function __construct(array $fields, PDO $PDO = null)
    {
        $this->fields = $fields;
        $this->PDO = $PDO;
    }

    /**
     * @param string $key
     * @param int $min
     * @param string $message
     * @return $this
     */
    public function min(string $key, int $min, string $message): self
    {
        $value = $this->getValue($key);
        $length = mb_strlen($value);
        if ($length < $min) {
            $this->setErrors($key, $message);
        }
        return $this;
    }

    /**
     * @param string $key
     * @param int $max
     * @param string $message
     * @return $this
     */
    public function max(string $key, int $max, string $message): self
    {
        $value = $this->getValue($key);
        $length = mb_strlen($value);
        if ($length > $max) {
            $this->setErrors($key, $message);
        }
        return $this;
    }

    /**
     * @param string $key
     * @param string $message
     * @return $this
     */
    public function required(string $key, string $message): self
    {
        $value = $this->getValue($key);
        if (is_null($value) || empty($value) ) {
            $this->setErrors($key, $message);
        }
        return $this;
    }

    /**
     * @param string $table
     * @param string $field
     * @param string $key
     * @param string $message
     * @param int|null $exclude
     * @return $this
     */
    public function unique(string $table, string $field, string $key, string $message, ?int $exclude = null): self
    {
        $params = [$this->getValue($key)];
        $query = "SELECT id FROM $table WHERE $field = ?";

        if ($exclude !== null) {
            $query .= " AND id != ?";
            $params[] = $exclude;
        }

        $statement = $this->PDO->prepare($query);
        $statement->execute($params);
        if ($statement->fetchColumn() !== false) {
            $this->setErrors($key, $message);
        }

        return $this;
    }

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * @param string $key
     * @param string $message
     */
    private function setErrors(string $key, string $message): void
    {
        $this->errors[$key] = $message;
    }

    /**
     * @param string $key
     * @return string|null
     */
    private function getValue(string $key): ?string
    {
        if (array_key_exists($key, $this->fields)) {
            return $this->fields[$key];
        }
        return null;
    }
}
