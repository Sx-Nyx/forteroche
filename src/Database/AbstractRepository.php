<?php

namespace Framework\Database;

use Exception;
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

    /**
     * @param array $data
     * @param int $id
     * @throws Exception
     */
    public function update(array $data, int $id)
    {
        $fields = [];
        foreach ($data as $key => $value) {
            $fields[] = "$key = :$key";
        }
        $query = $this->PDO->prepare("UPDATE {$this->table} SET " . implode(', ', $fields) . " WHERE id = :id");
        $response = $query->execute(array_merge($data, ['id' => $id]));

        if ($response === false) {
            throw new Exception("Impossible de modifier l'enregistrement dans la table {$this->table}");
        }
    }

    /**
     * @param array $data
     * @return int
     * @throws Exception
     */
    public function create(array $data): int
    {
        $fields = [];
        foreach ($data as $key => $value) {
            $fields[] = "$key = :$key";
        }
        $query = $this->PDO->prepare("INSERT INTO {$this->table} SET " . implode(', ', $fields));
        $response = $query->execute($data);

        if ($response === false) {
            throw new \Exception("Impossible de créer l'enregistrement dans la table {$this->table}");
        }
        return (int)$this->PDO->lastInsertId();
    }

    /**
     * @param int $id
     * @throws Exception
     */
    public function delete(int $id): void
    {
        $query = $this->PDO->prepare("DELETE FROM {$this->table} WHERE id = ?");
        $ok = $query->execute([$id]);
        if ($ok === false) {
            throw new \Exception("Impossible de supprimer l'enregistrement $id dans la table {$this->table}");
        }
    }
}
