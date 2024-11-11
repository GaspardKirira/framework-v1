<?php

namespace App\core\form;

class TextAreaField extends BaseField
{
    public function renderInput(): string
    {
        $errorClass = $this->model->hasError($this->attribute) ? ' is-invalid' : '';

        $value = $this->model->{$this->attribute} ?? '';

        return sprintf(
            '<textarea name="%s" class="form-control%s">%s</textarea>',
            $this->attribute,
            $errorClass,
            $value
        );
    }
}
