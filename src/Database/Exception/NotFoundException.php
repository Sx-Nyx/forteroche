<?php

namespace Framework\Database\Exception;

class NotFoundException extends \Exception
{
    public function __construct(string $table, string $field, string $data)
    {
        $this->message = "Aucun enregistrement ne correspond à '$data' sur le champ '$field' dans la table '$table'";
    }
}
