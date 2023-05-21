<?php

use Guynoolla\App\Repository\TreeItemsRepository;
use Guynoolla\App\Repository\UserRepository;

$treeItems = new TreeItemsRepository($this->db);

$items = $treeItems->findAll();

$this->view('page/home', [
    'title' => 'Главная',
    'items' => $items,
]);
