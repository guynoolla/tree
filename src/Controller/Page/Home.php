<?php

use Repository\TreeItemsRepository;
use Repository\UserRepository;

$treeItems = new TreeItemsRepository($this->db);

$items = $treeItems->findAll();

$this->view('page/home', [
    'title' => 'Главная',
    'items' => $items,
]);
