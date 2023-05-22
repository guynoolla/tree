<?php

namespace Guynoolla\App\Models;

use Guynoolla\App\Core\Database;

class TreeItem
{
    public $id;
    public $parent_id;
    public $name;
    public $description;

    public $level;

    const TABLE = 'tree_items';
    protected $fillable = [];

    public function __construct(array $data=[])
    {
        $this->fillable = [
            'id',
            'name',
            'description',
            'parent_id',
        ];

        if (!empty($data)) {
            $this->fill($data);
        }
    }

    public function fill(array $data=[])
    {
        foreach ($this->fillable as $attr) {
            if (isset($data[$attr])) {
                $this->{$attr} = trim($data[$attr]);
            }
        }
    }

    public function beforeSave()
    {
        if ($this->parent_id == 0) {
            $this->parent_id = NULL;
        }
    }

    public function attrAll()
    {
        $atts = [];
        foreach ($this->fillable as $attr) {
            $atts[$attr] = $this->{$attr};
        }
        return $atts;
    }

    public function formFields()
    {
        return [
            'name' => 'Название',
            'description' => 'Описание',
            'parent_id' => 'Родитель'
        ];
    }

    public static function setLevelForEvery($treeItems, $parentId=0, $level=0)
    {
        if (isset($treeItems[$parentId])) {
            foreach ($treeItems[$parentId] as $item) {
                $level++;
                $item->level = $level;
                self::setLevelForEvery($treeItems, $item->id, $level);
                $level--;
            }

            return $treeItems;
        }
    }

    public function errors()
    {
        $errors = [];
        foreach ($this->fillable as $input) {
            if ($input === 'id') {
                continue;
            }
            if ($this->{$input} == "") {
                $errors[$input] = 'Пожалуйста, заполните поле "' . $this->formFields()[$input] . '".';
            }
        }
        return $errors;
    }
}
