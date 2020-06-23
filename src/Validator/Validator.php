<?php

namespace Framework\Validator;

class Validator
{
    /**
     * @var array
     */
    private $fields;

    /**
     * @var array
     */
    private $errors = [];

    public function __construct(array $fields)
    {
        $this->fields = $fields;
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
