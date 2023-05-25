<?php

namespace Models;

class User
{
    public $id;
    public $username;
    public $password_hash;

    const TABLE = 'users';
    protected $fillable = [];

    public function __construct(array $data=[])
    {
        $this->fillable = [
            'id',
            'username',
            'password_hash',
        ];

        if (!empty($data)) {
            $this->fill($data);
        }
    }

    public function fill(array $data=[])
    {
        foreach ($this->fillable as $attr) {
            if (isset($data[$attr])) {
                if ($attr === 'password') {
                    $this->password_hash = password_hash($data['password'], PASSWORD_BCRYPT);
                } else {
                    $this->{$attr} = trim($data[$attr]);
                }
            }
        }
    }

    public function beforeSave()
    {
        // если надо...
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
            'username' => 'Логин',
            'password' => 'Пароль',
        ];
    }
}
