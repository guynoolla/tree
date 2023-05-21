<?php

use Guynoolla\App\Repository\TreeItemsRepository;

$this->checkAccess();

$treeItems = new TreeItemsRepository($this->db);

$items = $treeItems->findAll();

$this->view('admin/index', [
    'title' => 'Главная',
    'items' => $items
]);
