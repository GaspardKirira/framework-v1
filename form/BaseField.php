<?php

namespace App\core\form;

use App\core\Model;

abstract class BaseField
{
    public Model $model;
    public string $attribute;

    public function __construct(Model $model, string $attribute)
    {
        $this->model = $model;
        $this->attribute = $attribute;
    }

    abstract public function renderInput(): string;

    public function __toString()
    {
        // Vérifie si l'attribut existe dans le modèle pour obtenir sa valeur


        // Récupère la première erreur pour l'attribut
        $errorMessage = $this->model->getFirstError($this->attribute);

        return sprintf(
            '
            <div class="form-group">
                <label for="%s" class="form-label">%s</label>
                %s
                <div class="invalid-feedback">
                    %s
                </div>
            </div>
            ',
            $this->attribute, // Utilisation de l'attribut pour l'attribut "for" et "id"
            $this->model->getLabel($this->attribute),
            //$this->type, // Utilisation du type dynamique
            // $this->attribute,
            //$errorClass,
            //$value,
            $this->renderInput(),
            $this->attribute, // id est égal à l'attribut
            $errorMessage
        );
    }
}
