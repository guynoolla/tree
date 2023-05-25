<?php

namespace Repository;

class Repository
{
    protected $db;
    protected $table;

    public function execute(string $sql, array $data=[]): object
	{
		$stm = $this->db->prepare($sql);

        if (!empty($data)) {
            foreach ($data as $key => $value) {
                $stm->bindValue(":{$key}", $value);
            }
        }

        return $stm->execute() ? $stm : FALSE;
	}

    public function create($model): int | bool
    {
        $sql = "INSERT INTO {$this->table} (%s) VALUES (%s)";
        $fields = $values = "";
        $data = [];

        foreach ($model->attrAll() as $attr => $value) {
            if ($value !== NULL) {
                $fields .= "{$attr}, ";
                $values .= ":{$attr}, ";
                $data[$attr] = $value;
            }
        }

        $fields = rtrim($fields, ", ");
        $values = rtrim($values, ", ");
        $sql = sprintf($sql, $fields, $values);
        $stm = $this->execute($sql, $data);

        if ($stm->rowCount() > 0) {
            return $this->db->lastInsertId();
        } else {
            return false;
        }
    }

    public function update($model)
    {
        $sql = "UPDATE {$this->table} SET %s WHERE id = %s";
        $pairs = "";
        $data = [];

        foreach ($model->attrAll() as $attr => $value) {
            if ($value !== NULL && $attr !== "id") {
                $pairs .= "{$attr} = :{$attr}, ";
                $data[$attr] = $value;
            }
        }

        $pairs = rtrim($pairs, ", ");
        $sql = sprintf($sql, $pairs, $model->id);
        $stm = $this->execute($sql, $data);

        return $stm->rowCount() > 0;
    }

    public function save($model)
    {
        $model->beforeSave();

        if (!$model->id) {
            return $this->create($model);
        } else {
            return $this->update($model);
        }
    }

    public function delete($model)
    {
        if ($model->id) {
            $sql = "DELETE FROM {$this->table} WHERE id = :id LIMIT 1";
            $stm = $this->execute($sql, ['id' => $model->id]);

            return $stm->rowCount() > 0;
        }
    }
}
