<?php

namespace App\core\db;

use App\core\Application;
use App\core\Model;
use finfo;

abstract class DbModel extends Model
{
    abstract public function tableName(): string;

    abstract public function attributes(): array;

    abstract public function primaryKey(): string;

    public function save()
    {
        $tableName = $this->tableName();
        $attributes =    $this->attributes();
        $params = array_map(fn($attr) => ":$attr", $attributes);

        $statement = self::prepare("INSERT INTO $tableName (" . implode(',', $attributes) . ") VALUES(" . implode(',', $params) . ")");

        foreach ($attributes as $attribute) {
            $statement->bindValue(":$attribute", $this->{$attribute});
        }

        $statement->execute();
        return true;
    }

    public static function findOne($where)
    {
        $model = new static();
        $tableName = $model->tableName();
        $attributes = array_keys($where);

        $sql = implode(" AND ", array_map(fn($attr) => "$attr = :$attr", $attributes));
        $statement = self::prepare("SELECT * FROM $tableName WHERE $sql");

        foreach ($where as $key => $item) {
            $statement->bindValue(":$key", $item);
        }

        $statement->execute();

        // Vérifier si aucun résultat n'est trouvé et retourner null
        $result = $statement->fetchObject(static::class);
        if (!$result) {
            return null;  // Retourner null au lieu de false
        }
        return $result;
    }

    public static function prepare($sql)
    {
        return  Application::$app->db->pdo->prepare($sql);
    }
}
