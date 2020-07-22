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

    public function input (string $key, string $placeholder, array $HTMLValidations = []): string
    {
        return <<<HTML
            <input type="text" class="login__form__input" placeholder="{$placeholder}" name="{$key}" {$this->getHTMLValidation($HTMLValidations)}>
HTML;
    }

    private function getHTMLValidation(array $HTMLValidations): string
    {
        $validation = "";
        foreach ($HTMLValidations as $key => $value) {
            if ($key === 'required' && $value === true) {
                $validation .= "required ";
            }
            if ($key === 'minlength') {
                $validation .= "minlength=\"{$value}\"";
            }
            if ($key === 'maxlength') {
                $validation .= "maxlength=\"{$value}\"";
            }
        }
        return $validation;
    }
}
