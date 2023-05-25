<?php

namespace Repository;

use Core\Database;
use Models\User;

class UserRepository extends Repository
{
    protected $db;
    protected $table;

    public function __construct(Database $db)
    {
        $this->db = $db;
        $this->table = User::TABLE;
    }

    public function findByUsername(string $username)
    {
        $sql = "SELECT * FROM {$this->table} WHERE username = :username";

        $stm = $this->execute($sql, ['username' => $username]);

        if ($stm) {
            $stm->setFetchMode(\PDO::FETCH_CLASS, User::class);
            return $stm->fetch();
        }
    }

    public function find(int $id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE id = :id";

        $stm = $this->execute($sql, ['id' => $id]);

        if ($stm) {
            $stm->setFetchMode(\PDO::FETCH_CLASS, User::class);
            return $stm->fetch();
        }
    }
}
