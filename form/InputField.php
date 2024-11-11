<?php

namespace App\core\form;

use App\core\Model;

class InputField extends BaseField
{
    public const TYPE_TEXT = 'text';
    public const TYPE_PASSWORD = 'password';
    public const TYPE_NUMBER = 'number';

    public string $type;
    public Model $model;
    public string $attribute;

    public function __construct(Model $model, string $attribute, string $type = self::TYPE_TEXT)
    {
        $this->type = $type;
        parent::__construct($model, $attribute);
    }



    public function passwordField(): self
    {
        $this->type = self::TYPE_PASSWORD;
        return $this;
    }

    public function renderInput(): string
    {
        $value = $this->model->{$this->attribute} ?? '';

        $errorClass = $this->model->hasError($this->attribute) ? ' is-invalid' : '';
        return sprintf(
            '<input type="%s" name="%s" class="form-control%s" value="%s">',
            $this->type,
            $this->attribute,
            $errorClass,
            $value,
        );
    }
}
