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
            <input type="text" class="login__form__input" placeholder="{$placeholder}" value="{$this->getValue($key)}" name="{$key}" {$this->getHTMLValidation($HTMLValidations)}>
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
            <textarea class="comment__form__input" placeholder="{$placeholder}" name="{$key}" {$this->getHTMLValidation($HTMLValidations)}>{$this->getValue($key)}</textarea>
            {$this->getError($key)}
HTML;
    }

    public function tinyMCE(string $key, string $placeholder): string
    {
        return <<<HTML
            <textarea class="comment__form__input" id="tinyArea" placeholder="{$placeholder}" name="{$key}">{$this->getValue($key)}</textarea>
            {$this->getError($key)}
HTML;
    }

    /**
     * @param string $key
     * @param string $label
     * @return string
     */
    public function checkbox(string $key, string $label): string
    {
        $value = (int)$this->getValue($key) === 1 ? 'checked' : '';
        return <<<HTML
            <div class="toggle__label">
            <label for="scales" class="toggle__statut">{$label}</label>
                <input type="checkbox" id="scales" name="{$key}" class="toggle__box" {$value}>
                <label for="scales" class="toggle"></label>
            </div>
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
     * @return string|null
     */
    private function getValue(string $key): ?string
    {
        $method = 'get' . str_replace(' ', '', ucwords(str_replace('_', ' ', $key)));
        return $this->data->$method();
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
