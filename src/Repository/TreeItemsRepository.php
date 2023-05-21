<?php

namespace Guynoolla\App\Repository;

use Guynoolla\App\Core\Database;
use Guynoolla\App\Models\TreeItem;

class TreeItemsRepository extends Repository
{
    public function __construct(Database $db)
    {
        $this->db = $db;
        $this->table = TreeItem::TABLE;
    }

    public function findAll()
    {
        $sql = "SELECT
                `id`, `name`, `description`, IFNULL(parent_id, 0) AS `parent_id`
                FROM
                    {$this->table}";
        $stm = $this->execute($sql);

        if ($stm) {
            $stm->setFetchMode(\PDO::FETCH_CLASS, TreeItem::class);
            $rows = $stm->fetchAll();
            $items = [];
            foreach ($rows as $row) {
                $items[$row->parent_id][] = $row;
            }
            return $items;
        }

        return false;
    }

    public function find(int $id)
    {
        $sql = "SELECT
                    `id`, `name`, `description`, IFNULL(parent_id, 0) AS `parent_id`
                FROM
                    {$this->table} WHERE id = :id";

        $stm = $this->execute($sql, ['id' => $id]);

        if ($stm) {
            $stm->setFetchMode(\PDO::FETCH_CLASS, TreeItem::class);
            return $stm->fetch();
        }
    }
}
