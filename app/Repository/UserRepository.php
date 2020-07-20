<?php

namespace App\Repository;

use App\Entity\User;
use Framework\Database\AbstractRepository;
use PDO;

class UserRepository extends AbstractRepository
{
    /**
     * @var PDO
     */
    protected $PDO;

    protected $table = 'user';

    protected $entity = User::class;

    public function __construct(PDO $PDO)
    {
        parent::__construct($PDO);
    }
}
