<?php

namespace Framework\Helper;

use Framework\Entity\EntityManager;

class Form
{
    /**
     * @var EntityManager $data
     */
    private $data;

    public function __construct(EntityManager $data)
    {
        $this->data = $data;
    }

    /**
     * @param string $key
     * @param string $placeholder
     * @param array $HTMLValidations
     * @return string
     */
    public function input(string $key, string $placeholder, array $HTMLValidations = []): string
    {
        return <<<HTML
            <input type="text" class="login__form__input" placeholder="{$placeholder}" name="{$key}" {$this->getHTMLValidation($HTMLValidations)}>
            {$this->getError($key)}
HTML;
    }

    /**
     * @param string $key
     * @param string $placeholder
     * @param array $HTMLValidations
     * @return string
     */
    public function textarea(string $key, string $placeholder, array $HTMLValidations = []): string
    {
        return <<<HTML
            <textarea class="comment__form__input" placeholder="{$placeholder}" name="{$key}" {$this->getHTMLValidation($HTMLValidations)}></textarea>
            {$this->getError($key)}
HTML;
    }

    /**
     * @param array $HTMLValidations
     * @return string
     */
    private function getHTMLValidation(array $HTMLValidations): string
    {
        $validation = "";
        foreach ($HTMLValidations as $key => $value) {
            if ($key === 'required' && $value === true) {
                $validation .= "required ";
            } else {
                $validation .= "$key=\"{$value}\" ";
            }
        }
        return $validation;
    }

    /**
     * @param string $key
     * @return string
     */
    private function getError(string $key): string
    {
        if (!empty($this->data->getErrors()[$key])) {
            return '<div class="invalid-field">' . $this->data->getErrors()[$key] . '</div>';
        }
        return '';
    }
}
