<?php

namespace Framework\Helper;

class Form
{
    private $data;

    private $errors;

    public function __construct($data, array $errors)
    {
        $this->data = $data;
        $this->errors = $errors;
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
            }
            if ($key === 'minlength') {
                $validation .= "minlength=\"{$value}\" ";
            }
            if ($key === 'maxlength') {
                $validation .= "maxlength=\"{$value}\" ";
            }
        }
        return $validation;
    }
}
