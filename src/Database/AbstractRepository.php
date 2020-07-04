<?php

namespace Framework\Database;

use Framework\Database\Exception\NotFoundException;
use PDO;

abstract class AbstractRepository
{
    protected $table = null;

    protected $entity = null;
    /**
     * @var \PDO
     */
    protected $PDO;

    public function __construct(\PDO $PDO)
    {
        $this->PDO = $PDO;
    }

    /**
     * @param string $field
     * @param string $data
     * @return mixed
     * @throws NotFoundException
     */
    public function findBy(string $field, string $data)
    {
        $query = $this->PDO->prepare("SELECT * FROM " . $this->table . " WHERE {$field} = :field");
        $query->execute(['field' => $data]);
        $query->setFetchMode(PDO::FETCH_CLASS, $this->entity);
        $response = $query->fetch();
        if ($response === false) {
            throw new NotFoundException($this->table, $field, $data);
        }
        return $response;
    }
}
